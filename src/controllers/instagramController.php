<?php
require_once("../util/env.php");

class InstagramController
{
  private static $appId = INSTAGRAM_APP_ID;
  private static $appSecret = INSTAGRAM_APP_SECRET;
  private static $apiUrl = "https://api.instagram.com/";
  private static $graphApiUrl = "https://graph.instagram.com/";

  public function getAuthUrl()
  {
    $params = array(
      "client_id" => self::$appId,
      "redirect_uri" => "https://localhost/MPic/includes/instagram.php",
      "scope" => "user_profile,user_media",
      "response_type" => "code"
    );
    $url = self::$apiUrl . "oauth/authorize?" . http_build_query($params);

    return $url;
  }

  public function getAccessToken($code)
  {
    $url = self::$apiUrl . "oauth/access_token";
    $params = array(
      "client_id" => self::$appId,
      "client_secret" => self::$appSecret,
      "grant_type" => "authorization_code",
      "redirect_uri" => "https://localhost/MPic/includes/instagram.php",
      "code" => $code
    );
    $response = $this->makeRequest("POST", $url, $params);

    return $this->getLongLivedAccessToken($response["access_token"]);
  }

  public function getLongLivedAccessToken($shortLivedAccessToken)
  {
    $url = self::$graphApiUrl . "access_token";
    $params = array(
      "client_secret" => self::$appSecret,
      "grant_type" => "ig_exchange_token",
      "access_token" => $shortLivedAccessToken
    );
    $response = $this->makeRequest("GET", $url, $params);

    return $response["access_token"];
  }

  public function getUserId($accessToken)
  {
    $url = self::$graphApiUrl . "me";
    $params = array(
      "fields" => "id",
      "access_token" => $accessToken
    );

    $response = $this->makeRequest("GET", $url, $params);

    return $response["id"];
  }

  public function getPhotos($accessToken)
  {
    $url = self::$graphApiUrl . $this->getUserId($accessToken) . "/media";
    $params = array(
      "fields" => "caption,media_type,media_url",
      "access_token" => $accessToken
    );

    $images = array();
    do
    {
      if(isset($apiResponse["paging"]["next"]))
        $params["after"] = $apiResponse["paging"]["cursors"]["after"];

      $apiResponse = $this->makeRequest("GET", $url, $params);
      $response = $apiResponse["data"];

      for($i=0; $i<count($response); $i+=1)
      {
        if($response[$i]["media_type"] != "IMAGE")
          continue;

        $data = array(
          "source" => $response[$i]["media_url"],
          "likes" => "??",
          "description" => isset($response[$i]["caption"]) ? $response[$i]["caption"] : "<i>No description</i>"
        );
        array_push($images, $data);
      }
    } while(count($images) < 100 && isset($apiResponse["paging"]["next"]));

    return $images;
  }

  public function makeRequest($method, $url, $params)
  {
    $ch = curl_init();

    if($method == "POST")
    {
      curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
      curl_setopt($ch, CURLOPT_POST, true);
    }
    else if($method == "GET")
    {
      $url .= "?" . http_build_query($params);
    }
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    curl_close($ch);

    return json_decode($response, true);
  }
}
?>
