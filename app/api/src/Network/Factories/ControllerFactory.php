<?php

declare(strict_types=1);

namespace MS\Api\Network\Factories;

use Auryn\Injector;
use MS\Api\Controllers\V1\IController;
use MS\Api\Network\Exceptions\MissingControllerException;

class ControllerFactory implements IFactory { 
  private Injector $injector;
  private string $version;

  public function __construct(Injector $injector) {
    $this->injector = $injector;
  }

  public function create(string $name): IController {
    $name = ucfirst($name);
    $classPath = "\\MS\\Api\\Controllers\\$this->version\\$name";
    if(!class_exists($classPath))
      throw new MissingControllerException("Could not find controller $name in version {$this->version}");

    return $this->injector->make($classPath);
  }

  public function setVersion(string $version) {
    $version = ucfirst($version);
    $this->version = $version;
  }
}
