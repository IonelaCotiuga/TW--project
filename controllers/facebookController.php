<?php
require_once("../util/env.php");

class FacebookController
{
  private static $appId = FACEBOOK_APP_ID;
  private static $appSecret = FACEBOOK_APP_SECRET;
  private static $apiUrl = "https://www.facebook.com/v14.0/dialog/oauth";
  private static $graphApiUrl = "https://graph.facebook.com/";

  public function getAuthUrl()
  {
    $params = array(
      "client_id" => self::$appId,
      "redirect_uri" => "https://localhost/MPic/includes/facebook.php",
      "scope" => "user_photos, user_likes,user_posts ",
      "state" => "state-param",
      "auth_type" => "rerequest",
      "response_type" => "code"
    );
    $url = self::$apiUrl . "?" . http_build_query($params);

    return $url;
  }

  public function getAccessToken($code)
  {
    $url = "https://graph.facebook.com/v14.0/oauth/access_token?";
    $params = array(
      "client_id" => self::$appId,
      "client_secret" => self::$appSecret,
      "redirect_uri" => "https://localhost/MPic/includes/facebook.php",
      "code" => $code
    );
    $url = $url . http_build_query($params);

    $response = $this->makeRequest("GET", $url, array());

    return $response["access_token"];
  }


  public function getUserId($accessToken)
  {

    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://graph.facebook.com/v14.0/me',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'GET',
      CURLOPT_HTTPHEADER => array(
        'Authorization: Bearer '.$accessToken
      ),
    ));

    $response = json_decode(curl_exec($curl), true);

    curl_close($curl);
    return $response["id"];

  }

  public function getPhotos($accessToken)
  {
    $images = array();

    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://graph.facebook.com/v14.0/'.$this->getUserId($accessToken).'/feed?fields=full_picture,message',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'GET',
      CURLOPT_HTTPHEADER => array(
        'Authorization: Bearer '.$accessToken
      ),
    ));

    $value = json_decode(curl_exec($curl),true);

    curl_close($curl);

    $value = $value['data'];

    
    for($i = 0; $i < count($value); $i+=1){
      if(!isset($value[$i]["full_picture"]))
        continue;

      $photo_id =  $value[$i]["id"];
      $likes = $this->getNrLikes($accessToken, $photo_id);

      $data = array(
        "source" => $value[$i]["full_picture"],
        "likes" => $likes,
        "description" => isset($value[$i]["message"]) ? $value[$i]["message"] : "<i>No description</i>"
      );

      array_push($images, $data);
      
    }

    return $images;

  }

  public function getNrLikes($accessToken, $photo_id)
  {
    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://graph.facebook.com/v13.0/'.$photo_id.'/?fields=reactions.summary(total_count)',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'GET',
      CURLOPT_HTTPHEADER => array(
        'Authorization: Bearer '.$accessToken
      ),
    ));

    $response = json_decode(curl_exec($curl), true);

    curl_close($curl);
    return $response["reactions"]["summary"]["total_count"];

  }

  public function makeRequest($method, $url, $params)
  {
    $ch = curl_init();

    if($method == "POST")
    {
      curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
      curl_setopt($ch, CURLOPT_POST, true);
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
