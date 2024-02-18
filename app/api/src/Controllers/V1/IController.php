<?php

declare(strict_types=1);

namespace MS\Api\Controllers\V1;

use Symfony\Component\HttpFoundation\{Request, Response};

interface IController {
  public function get(Request $request): Response;

  public function post(Request $request): Response;

  public function put(Request $request): Response;

  public function delete(Request $request): Response;
}
