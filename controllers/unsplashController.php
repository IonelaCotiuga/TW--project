<?php
require_once("../util/env.php");

class UnsplashController
{
  private static $accessKey = UNSPLASH_ACCESS_KEY;
  private static $secretKey = UNSPLASH_ACCESS_SECRET;
  private static $apiUrl = "https://api.unsplash.com/";

  public function getAuthUrl()
  {
    $url = "https://unsplash.com/oauth/authorize?client_id=" . self::$accessKey . "&redirect_uri=https://localhost/MPic/includes/unsplash.php&response_type=code&scope=public+read_photos+write_photos";

    return $url;
  }

  public function getBearerToken($code)
  {
    $url = "https://unsplash.com/oauth/token?client_id=" . self::$accessKey . "&client_secret=" . self::$secretKey . "&redirect_uri=https://localhost/MPic/includes/unsplash.php&code=" . $code . "&grant_type=authorization_code";

    $response = $this->makeRequest("POST", $url, array());

    return $response["access_token"];
  }

  public function getName($token)
  {
    $url = self::$apiUrl . "me";
    $headers = array(
      "Authorization: Bearer " . $token
    );

    $response = $this->makeRequest("GET", $url, $headers);

    return $response["username"];
  }

  public function getPhotos($token)
  {
                                      //todo: replace with $this->getName()
    $url = self::$apiUrl . "users/" . "girl_behindthelens" . "/photos?per_page=100";
    $headers = array(
        "Authorization: Bearer " . $token
    );

    $response = $this->makeRequest("GET", $url, $headers);
    $images = array();

    for($i=0; $i<count($response); $i+=1)
    {
      $data = array(
        "source" => $response[$i]["urls"]["regular"],
        "likes" => $response[$i]["likes"],
        "description" => isset($response[$i]["description"]) ? $response[$i]["description"] : "<i>No description</i>"
      );
      array_push($images, $data);
    }

    return $images;
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
