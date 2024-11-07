<?php

/**
 * 一般使用者登入
 */

namespace App\Controllers;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\Models\UserModel;
use App\Entities\UserEntity;
use CodeIgniter\API\ResponseTrait;

use Google_Client;
use Google_Service_Oauth2;

class UserController extends BaseController
{
    use ResponseTrait;

    protected $userModel;

    /**
     * 建構方法
     */
    public function __construct()
    {
        $this->userModel = new UserModel();
    }

     /**
     * [GET] google登入
     *
     * @return ResponseTrait
     */
    public function googleLogin()
    {
        //設定取得Google API 三要素：用戶端編號、用戶端密鑰、已授權的重新導向URI
        $clientID = getenv('GOOGLE_CLIENT_ID');
        $clientSecret = getenv('GOOGLE_SECRET_KEY');
        $redirectUrl = getenv('redirectUrl');

       
        // 建立client端 的 request需求 給 Google
        $client = new Google_Client();
        $client->setClientId($clientID);
        $client->setClientSecret($clientSecret);
        $client->setRedirectUri($redirectUrl);
        $client->addScope('email');
        $client->addScope(Google_Service_Oauth2::USERINFO_PROFILE);

       $url=$client->createAuthUrl();
       header('Location:'.$url);

    }

    /**
     * [GET] google取得資料
     
     * @return ResponseTrait
     */
    public function googleCallback()
    {   
        $clientID = getenv('GOOGLE_CLIENT_ID');
        $clientSecret = getenv('GOOGLE_SECRET_KEY');
        $redirectUrl = getenv('redirectUrl');

        // 建立client端 的 request需求 給 Google
        $client = new Google_Client();
        $client->setClientId($clientID);
        $client->setClientSecret($clientSecret);
        $client->setRedirectUri($redirectUrl);
        $client->addScope('email');

        
        $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
        $client->setAccessToken($token);
        $gauth = new Google_Service_Oauth2($client);
        $google_info = $gauth->userinfo->get();
        $email = $google_info->email;
        $first_name = $google_info->givenName ?? '';
        $last_name = $google_info->familyName ?? '';
        
        
        $comb     = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $shf      = str_shuffle($comb);
        $password = substr($shf, 0, 6);

        $result = $this->userModel->where('email', $email)->first();

        //沒有帳號就做新增會員
        if (is_null($result)) {
            
            $userEntity = new UserEntity();
            $userEntity->email            = $email;
            $userEntity->password         = password_hash($password, PASSWORD_DEFAULT);
            $userEntity->first_name       = $first_name;
            $userEntity->last_name        = $last_name;
            $userEntity->cellphone_number = '';
            $isCreated = $this->userModel->insert($userEntity);

           $result = $this->userModel->where('email', $email)->first();
           $u_id= $result->u_id;
        }else{
            $u_id= $result->u_id;
        }
        
        $key = getenv('JWT_SECRET');
        $iat = time(); // current timestamp value
        $exp = $iat + 3600;

        $payload = array(
            "iss" => "Issuer of the JWT",
            "aud" => "Audience that the JWT",
            "sub" => "Subject of the JWT",
            "iat" => $iat, //Time the JWT issued at
            "exp" => $exp, // Expiration time of token
            "u_id" => $u_id,
        );
        $token = JWT::encode($payload, $key, 'HS256');
        
        
        return $this->respond([
            'msg' => 'success',
            'result' => [
                'token' => $token
            ]

        ], 200);
        
    }
    /**
     * [POST] 取得用戶資料
     *
     * @return ResponseTrait
     */
    public function userData()
    {   
         // 獲取 HTTP 請求物件
        $request = \Config\Services::request();

        // 從 Authorization 頭中提取 token
        $authHeader = $request->getHeaderLine('Authorization');
        
        // 通常 Authorization 頭的格式是 "Bearer your_token_here"，所以需要進行分割
        $token = '';
        if (preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            $token = $matches[1];
        }

        $key = getenv('JWT_SECRET');

        $decoded = JWT::decode($token, new Key($key, 'HS256'));
    
        // 將解碼結果轉換為陣列 (如果需要)
        $decoded_array = (array) $decoded;
        
        // 從解碼後的數據提取 uid
        $u_id = $decoded_array['u_id'];

        $result = $this->userModel->where('u_id', $u_id)->first();

        
        return $this->respond([
            'msg' => 'success',
            'result' => [
                'u_id' =>   $result->u_id,
                'email'  =>  $result->email,
                'first_name' =>  $result->first_name,
                'last_name' =>  $result->last_name
            ]

        ], 200);
        
    }

}
