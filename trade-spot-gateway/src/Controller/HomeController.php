<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class HomeController
{

    public function index(): JsonResponse
    {
        $content = 'INDEX';

        return new JsonResponse($content);
    }

    public function test(Request $request): JsonResponse
    {
        return new JsonResponse('test');
    }

    public function test2(Request $request, $data): JsonResponse
    {
        return new JsonResponse(['q' => $request->get('id')]);
    }

}
