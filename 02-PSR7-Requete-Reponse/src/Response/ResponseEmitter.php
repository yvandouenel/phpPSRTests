<?php

namespace Diginamic\Framework\Response;

use Psr\Http\Message\ResponseInterface;

class ResponseEmitter
{
  public function emit(ResponseInterface $response): void
  {
    // Envoie les headers
    foreach ($response->getHeaders() as $name => $values) {
      foreach ($values as $value) {
        header(sprintf('%s: %s', $name, $value), false);
      }
    }

    // Envoie le status code
    header(sprintf(
      'HTTP/%s %s %s',
      $response->getProtocolVersion(),
      $response->getStatusCode(),
      $response->getReasonPhrase()
    ));

    // Envoie le corps de la réponse
    echo $response->getBody();
  }
}
