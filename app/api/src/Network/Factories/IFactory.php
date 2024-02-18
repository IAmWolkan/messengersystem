<?php

declare(strict_types=1);

namespace MS\Api\Network\Factories;

interface IFactory {
  public function create(string $name);
}
