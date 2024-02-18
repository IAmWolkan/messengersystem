<?php

declare(strict_types=1);

namespace MS\Api\Network\Matchers;

use Monolog\Logger;
use MS\Api\Network\Exceptions\InvalidRequestException;
use MS\Api\Network\Exceptions\MissingMethodException;
use MS\Api\Network\Factories\ControllerFactory;
use Symfony\Component\HttpFoundation\{Request, Response};

class ApiMatcher implements IMatcher {
  private ControllerFactory $factory;
  private Logger $logger;

  public function __construct(
    Logger $logger,
    ControllerFactory $factory
  ) {
    $this->logger = $logger;
    $this->factory = $factory;
  }

  public function findRoute(Request $request): Response {
    try {
      list($version, $controllerName, $method) = $this->parseRequest($request);
      

      $this->factory->setVersion($version);    
      $controller = $this->factory->create($controllerName);

      if(!method_exists($controller, $method))
        throw new MissingMethodException("Could not find method $method in controller $controllerName");

      return $controller->$method($request);
    } catch(\Exception $ex) {
      $this->logger->error($ex->getMessage(), $ex->getTrace());
      throw new InvalidRequestException("Invalid request");
    }
  }

  private function parseRequest(Request $request) {
    $path = $request->getPathInfo();
    if(str_starts_with($path, '/'))
      $path = substr($path, 1);

    if(!str_ends_with($path, '/'))
      $path .= '/';

    @list($version, $controller, $entityId) = explode('/', $path);
    $method = $request->getMethod();

    if($entityId !== null) {
      $request->attributes->set('entityId', $entityId);
    }

    return [$version, $controller, $method];
  }
}
