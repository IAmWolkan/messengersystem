<?php

declare(strict_types=1);

namespace MS\Api\Controllers\V1;

use MS\Api\Controllers\Exceptions\NotYetImplementedException;
use Symfony\Component\HttpFoundation\{Request, Response};

class Messages implements IController {
  public function get(Request $request): Response {
    $entityId = $request->attributes->get('entityId');

    return new Response("{\"Id\":\"$entityId\"}", 200);
  }

  public function put(Request $request): Response {
    throw new NotYetImplementedException();
  }

  public function post(Request $request): Response {
    throw new NotYetImplementedException();
  }

  public function delete(Request $request): Response {
    throw new NotYetImplementedException();
  }
}
