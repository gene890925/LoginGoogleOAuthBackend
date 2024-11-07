<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class ApiAccessFilter implements FilterInterface
{

    protected $allowHeaders = [
        "Access-Control-Allow-Headers",
        "Origin,Accept",
        // "X-Requested-With",
        "Content-Type",
        "Authorization",
        // "Access-Control-Request-Method",
        // "Access-Control-Request-Headers",
        // "X-Access-Token",
        // "X-Refresh-Token",
        // "X-Edit-Verify-Token",
        // "X-Edit-Sdk-Token",
        // "X-User-Sdk-Token",
        // "X-Activity-Page-Path",
        // "X-Activity-Domain",
        // "X-Activity-Page-Path",
        // "X-Unique-Key",
        // "X-Page-Domain",
        // "X-Page-Path",
        // "X-Page-Url"
    ];

    protected $allowMethods = [
        'DELETE',
        'PUT',
        'POST',
        'GET',
        'PATCH',
        'OPTIONS'
    ];

    public function before(RequestInterface $request, $arguments = null)
    {
        $response = \CodeIgniter\Config\Services::response();
        $response->setHeader("Access-Control-Allow-Origin", "*");
        $response->setHeader("Access-Control-Allow-Credentials", "true");
        $response->setHeader("Access-Control-Allow-Headers", implode(", ", $this->allowHeaders));
        if (strcasecmp($request->getMethod(), "options") == 0) {
            $response->setHeader("Access-Control-Allow-Methods", implode(", ", $this->allowMethods));
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}
