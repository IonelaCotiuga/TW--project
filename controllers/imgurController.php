<?php
require_once("../util/env.php");

class ImgurController
{
  private static $clientId = IMGUR_CLIENT_ID;
  private static $clientSecret = IMGUR_CLIENT_SECRET;
  private static $apiUrl = "https://api.imgur.com/";

  public function getAuthUrl()
  {
    $url = self::$apiUrl . "oauth2/authorize?response_type=token&clientId=" . self::$clientId . "&state=" . md5(rand());

    return $url;
  }

  public function getPhotos($accessToken)
  {
    $url = self::$apiUrl . "3/account/me/images";
    $headers = array(
      "Authorization: Bearer " . $accessToken
    );

    $response = $this->makeRequest("GET", $url, $headers)["data"];
    $images = array();

    for($i=0; $i<count($response); $i+=1)
    {
      if(substr($response[$i]["type"], 0, 5) != "image")
        continue;

      $data = array(
        "source" => $response[$i]["link"],
        "likes" => "??",
        "description" => isset($response[$i]["description"]) ? $response[$i]["description"] : "<i>No description</i>"
      );
      array_push($images, $data);
    }

    return $images;
  }

  public function uploadImage($image, $accessToken)
  {
    $url = self::$apiUrl . "3/upload";
    $headers = array(
      "Authorization: Bearer " . $accessToken
    );
    $data = explode(",", $this->image);
    $body = array(
      "image" => $data[1],
      "type" => "base64"
    );

    $response = $this->makeRequest("POST", $url, $headers, $body);

    return $response;
  }

  public function makeRequest($method, $url, $headers, $body = null)
  {
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
    if($method == "POST")
    {
      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
    }

    $response = curl_exec($ch);
    curl_close($ch);

    return json_decode($response, true);
  }
}
?>
