<?php

declare(strict_types=1);

namespace MS\Api\Configuration;

use Auryn\Injector;
use MS\Api\Network\Factories\{
  ControllerFactory,
  MatcherFactory
};
use MS\Api\Network\Matchers\ApiMatcher;
use MS\Api\Network\Router;
use Monolog\Handler\ErrorLogHandler;
use Monolog\{
  Level,
  Logger
};

class InjectorConfig {
  public static function Setup(Injector $injector) {
    self::loadConfig();

    // Configure loggins
    $logger = new Logger(AppConfig::get('logger.name'));
    $logger->pushHandler(new ErrorLogHandler(ErrorLogHandler::OPERATING_SYSTEM, Level::Debug));
    $injector->delegate(Logger::class, function()use($logger) {
      return $logger;
    });

    // Configure networking
    $injector->define(Router::class, [':matcherClasses' => [
      ApiMatcher::class
    ]]);

    // Configure factories
    $injector->define(ControllerFactory::class, [':injector' => $injector]);
    $injector->define(MatcherFactory::class, [':injector' => $injector]);
  }

  private static function loadConfig() {
    $config = \yaml_parse(file_get_contents("config.yml"));
    AppConfig::setConfig($config);
  }
}
