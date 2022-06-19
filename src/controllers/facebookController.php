<?php
require_once("../util/env.php");

class FacebookController
{
  private static $appId = FACEBOOK_APP_ID;
  private static $appSecret = FACEBOOK_APP_SECRET;
  private static $apiUrl = "https://graph.facebook.com/v14.0/";
  private static $redirectUrl = "https://localhost/MPic/includes/facebook.php";

  public function getAuthUrl()
  {
    $params = array(
      "client_id" => self::$appId,
      "redirect_uri" => self::$redirectUrl,
      "scope" => "user_photos,user_likes,user_posts",
      "state" => "state-param",
      "auth_type" => "rerequest",
      "response_type" => "code"
    );
    $url = "https://www.facebook.com/v14.0/dialog/oauth?" . http_build_query($params);

    return $url;
  }

  public function getAccessToken($code)
  {
    $url = self::$apiUrl . "oauth/access_token?";
    $params = array(
      "client_id" => self::$appId,
      "client_secret" => self::$appSecret,
      "redirect_uri" => self::$redirectUrl,
      "code" => $code
    );
    $url .= http_build_query($params);

    $response = $this->makeRequest("GET", $url, array());

    return $response["access_token"];
  }

  public function getUserId($accessToken)
  {
    $url = self::$apiUrl . "me";
    $headers = array(
      "Authorization: Bearer " . $accessToken
    );

    $response = $this->makeRequest("GET", $url, $headers);

    return $response["id"];
  }

  public function getPhotos($accessToken)
  {
    $url = self::$apiUrl . $this->getUserId($accessToken) . "/feed?fields=full_picture,message";
    $headers = array(
      "Authorization: Bearer " . $accessToken
    );

    $response = $this->makeRequest("GET", $url, $headers);
    $response = $response["data"];
    $images = array();

    for($i = 0; $i < count($response); $i += 1)
    {
      if(!isset($response[$i]["full_picture"]))
        continue;

      $photoId =  $response[$i]["id"];
      $likes = $this->getNrLikes($accessToken, $photoId);

      $data = array(
        "source" => $response[$i]["full_picture"],
        "likes" => $likes,
        "description" => isset($response[$i]["message"]) ? $response[$i]["message"] : "<i>No description</i>"
      );

      array_push($images, $data);
    }

    return $images;
  }

  public function getNrLikes($accessToken, $photoId)
  {
    $url = self::$apiUrl . $photoId . "?fields=reactions.summary(total_count)";
    $headers = array(
      "Authorization: Bearer " . $accessToken
    );

    $response = $this->makeRequest("GET", $url, $headers);

    return $response["reactions"]["summary"]["total_count"];
  }

  public function makeRequest($method, $url, $headers)
  {
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
    if($method == "POST")
      curl_setopt($ch, CURLOPT_POST, true);

    $response = curl_exec($ch);
    curl_close($ch);

    return json_decode($response, true);
  }
}
?>
