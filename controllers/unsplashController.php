<?php
class UnsplashController
{
  private const ACCESS_KEY = "Q3GGyx8UxiVNa7CnMhW1hP5mbxSxpH5j9rJPDZh5uNo";
  private const SECRET_KEY = "5R-dTNbUOhqRICvPurxREnMqMjjzusXcSuEnKnBQhi4";
  private const API_URL = "https://api.unsplash.com/";

  private $username;

  public function getAuthUrl()
  {
    $url = "https://unsplash.com/oauth/authorize?client_id=" . self::ACCESS_KEY . "&redirect_uri=https://localhost/MPic/includes/unsplash.php&response_type=code&scope=public+read_photos+write_photos";

    return $url;
  }

  public function getBearerToken($code)
  {
    $url = "https://unsplash.com/oauth/token?client_id=" . self::ACCESS_KEY . "&client_secret=" . self::SECRET_KEY . "&redirect_uri=https://localhost/MPic/includes/unsplash.php&code=" . $code . "&grant_type=authorization_code";

    $response = json_decode($this->makeRequest("POST", $url, array()), true);

    return $response["access_token"];
  }

  public function getName($token)
  {
    $url = self::API_URL . "me";
    $headers = array(
      "Authorization: Bearer " . $token
    );

    $response = json_decode($this->makeRequest("GET", $url, $headers), true);
    $this->username = $response["username"];

    return $this->username;
  }

  public function getPhotos($token)
  {
    $headers = array(
        "Authorization: Bearer " . $token
    );
    $images = array();

                             //todo: replace with $this->getName()
    $url = self::API_URL . "users/" . "girl_behindthelens" . "/photos?per_page=100";
    $response = json_decode($this->makeRequest("GET", $url, $headers), true);

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

    return $response;
  }
}
