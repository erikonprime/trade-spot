<?php

namespace App\Controller;

use App\Framework\Api\Client;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ApiController
{
    private Client $api;

    public function __construct()
    {
        $this->api = new Client();
    }

    public function ping(): JsonResponse
    {
        $response = $this->api->get('ping');
        return new JsonResponse(['status' => 'ok', 'result' => $response], Response::HTTP_OK);
    }

}
