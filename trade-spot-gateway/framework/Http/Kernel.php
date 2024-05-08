<?php

namespace App\Framework\Http;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use FastRoute;

class Kernel
{
    public function handle(Request $request): JsonResponse
    {
        $dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $routeCollector) {
            $routes = include BASE_PATH . '/routes/web.php';
            foreach ($routes as $route) {
                $routeCollector->addRoute(...$route);
            }
        });

        $routeInfo = $dispatcher->dispatch($request->getMethod(), $request->getPathInfo());

        switch ($routeInfo[0]) {
            case FastRoute\Dispatcher::NOT_FOUND:
                return new JsonResponse('not found');
            case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
                return new JsonResponse('not allowed');
            case FastRoute\Dispatcher::FOUND:
                [$status, [$controller, $method], $vars] = $routeInfo;

                foreach ($vars as $key => $var) {
                    $request->attributes->set($key, $var);
                }

                return call_user_func([new $controller, $method], $request, $vars);
        }

        return new JsonResponse('ERROR!');
    }

}
