<?php

declare(strict_types=1);

namespace MS\Api\Drivers\Factories;

use Monolog\Logger;
use MS\Api\Configuration\AppConfig;
use MS\Api\Drivers\Exceptions\DriverException;

class MongoClientFactory {
  private static ?\MongoDB\Client $client = null;
  private Logger $logger;
  private AppConfig $appConfig;

  public function __construct(
    Logger $logger,
    AppConfig $appConfig
  ) {
    $this->logger = $logger;
    $this->appConfig = $appConfig;
  }

  public function create() {
    try {
      if(self::$client === null)
        self::$client = new \MongoDB\Client($this->appConfig->get('db.connection'));

      return self::$client;
    } catch (\Exception $ex) {
      $this->logger->error($ex->getMessage(), $ex->getTrace());
      throw new DriverException($ex->getMessage(), 500, $ex);
    }
  }
}
