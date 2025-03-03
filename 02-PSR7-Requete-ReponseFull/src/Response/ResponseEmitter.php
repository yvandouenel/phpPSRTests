<?php

namespace Diginamic\Framework\Response;

use Psr\Http\Message\ResponseInterface;

class ResponseEmitter
{
  public function emit(ResponseInterface $response): void
  {
    // Headers de sécurité par défaut
    //  ces headers supplémentaires sont particulièrement importants en production, mais peuvent être utiles même en développement pour détecter tôt d'éventuels problèmes de sécurité.
    $defaultHeaders = [
      'X-Content-Type-Options' => 'nosniff',
      'X-Frame-Options' => 'DENY',
      'X-XSS-Protection' => '1; mode=block',
      'Cache-Control' => 'no-store, no-cache, must-revalidate',
      'Pragma' => 'no-cache',
      'Expires' => '0'
    ];
    // Ajoute les headers par défaut s'ils ne sont pas déjà définis
    foreach ($defaultHeaders as $name => $value) {
      if (!$response->hasHeader($name)) {
        header("$name: $value");
      }
    }

    // Envoie les headers
    foreach ($response->getHeaders() as $name => $values) {
      foreach ($values as $value) {
        error_log("Header value: " . $value);
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
