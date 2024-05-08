<?php

use App\Controller;

return [
    ['GET', '/', [Controller\HomeController::class, 'index']],
    ['GET', '/test', [Controller\HomeController::class, 'test']],
    ['POST', '/test/{id:\d+}', [Controller\HomeController::class, 'test2']],
    ['GET', '/api/ping', [Controller\ApiController::class, 'ping']],
];
