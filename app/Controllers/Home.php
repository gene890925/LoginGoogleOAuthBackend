<?php

namespace App\Controllers;
use CodeIgniter\API\ResponseTrait;

class Home extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        // return view('welcome_message');
        //  $header = $request->getHeaderLine("Authorization");
        //  return $header;
    }
    public function options()
    {
        return $this->respond([
            "status"=> 'on',
            "request" => $this->request->getIPAddress()
        ]);
    }

    public function test()
    {
        return view('test');
    }
}
