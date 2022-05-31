<?php
class JWTController
{
  private $header;
  private $payload;
  private $signature;

  public function __construct($id, $username, $email)
  {
    $this->header = json_encode(["alg" => "HS256", "typ" => "JWT"]);
    $this->payload = json_encode(["sub" => "1234567890", "id" => $id, "username" => $username, "email" => $email, "iat" => time(), "exp" => time() + (60 * 60)]);
  }

  public function generateToken()
  {
    $base64Header = str_replace(["+", "/", "="], ["-", "_", ""], base64_encode($this->header));
    $base64Payload = str_replace(["+", "/", "="], ["-", "_", ""], base64_encode($this->payload));

    $this->signature = hash_hmac("sha256", $base64Header . "." . $base64Payload, "KEY123", true);
    $base64Signature = str_replace(["+", "/", "="], ["-", "_", ""], base64_encode($this->signature));

    $jwt = $base64Header . "." . $base64Payload . "." . $base64Signature;
    return $jwt;
  }

  public static function validateToken($token)
  {
    //
  }

  public static function getPayload($token)
  {
    $tokenParts = explode(".", $token);
    $payload = base64_decode($tokenParts[1]);

    return json_decode($payload, true);
  }
}
?>
