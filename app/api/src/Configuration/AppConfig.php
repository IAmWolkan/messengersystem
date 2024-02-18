<?php

declare(strict_types=1);

namespace MS\Api\Configuration;

use MS\Api\Configuration\Exception\MissingConfigException;

class AppConfig {
  private static $config;
  
  public static function get(string $property) {
    $configPath = explode('.', $property);
    
    $current = self::$config;
    foreach($configPath as $path) {
      if(!array_key_exists($path, $current)) {
        throw new MissingConfigException("Could not find $property in configuration file");
      }

      $current = $current[$path];
    }

    return $current;
  }

  public static function setConfig(array $config) {
    self::$config = $config;
  }
}
