<?php

use MS\Api\Network\Router;
use Symfony\Component\HttpFoundation\Request;

require_once("bootstrap.php");

/** @var Router */
$router = $injector->make(Router::class);

$request = Request::createFromGlobals();
$response = $router->run($request);
$response->send();
