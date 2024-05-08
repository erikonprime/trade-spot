<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';

use App\Framework\Http\Kernel;
use Symfony\Component\HttpFoundation\Request;

define('BASE_PATH', dirname(__DIR__));

$request = Request::createFromGlobals();

$kernel = new Kernel();

$response = $kernel->handle($request);

$response->send();
