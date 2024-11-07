<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use \Firebase\JWT\JWT;
class JWTController extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        return $this->fail("Please Login!", 400);
        // $key = getenv('JWT_SECRET');
        // $iat = time(); // current timestamp value
        // $exp = $iat + 3600;

        // $payload = array(
        //     "iss" => "Issuer of the JWT",
        //     "aud" => "Audience that the JWT",
        //     "sub" => "Subject of the JWT",
        //     "iat" => $iat, //Time the JWT issued at
        //     "exp" => $exp, // Expiration time of token
        // );

        // $token = JWT::encode($payload, $key, 'HS256');

        // $response = [
        //     'msg' => 'Get Key Successful',
        //     'token' => $token
        // ];
        // // return $this->respond($response, 200);
        // return $token;
    }
}
