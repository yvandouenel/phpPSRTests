<?php

namespace Diginamic\Framework\Controller;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Psr7\Response;

class FirstController
{
  public function handleRequest(ServerRequestInterface $request): ResponseInterface
  {
    // Récupération de l'URI et analyse de ses composants
    $uri = $request->getUri();

    $uriComponents = [
      'HTTP Method' => $request->getMethod(),
      'Scheme (protocole)' => $uri->getScheme(),
      'Host (domaine)' => $uri->getHost(),
      'Port' => $uri->getPort() ?: '80/443',
      'Path (chemin)' => $uri->getPath(),
      'Query (paramètres)' => $uri->getQuery(),
      'Fragment (ancre)' => $uri->getFragment(),
      'URI complète' => (string) $uri
    ];

    // Création du contenu HTML pour une meilleure lisibilité
    $html = '<h1>Analyse de l\'URI</h1>';
    $html .= '<ul>';
    foreach ($uriComponents as $name => $value) {
      $html .= sprintf(
        '<li><strong>%s :</strong> %s</li>',
        htmlspecialchars($name),
        htmlspecialchars($value)
      );
    }
    $html .= '</ul>';

    // Création de la réponse
    $response = new Response(
      200,
      ['Content-Type' => 'text/html; charset=utf-8'],
      $html
    );

    return $response;
  }

  public function testPost(ServerRequestInterface $request): ResponseInterface
  {
    if ($request->getMethod() == "GET") {
      // Création du contenu HTML pour une meilleure lisibilité
      $html = '<h1>Formulaire de test</h1>';
      $html .= '<form method="post" action="/test-post">';
      $html .= '    <div>';
      $html .= '        <label for="firstname">Prénom :</label>';
      $html .= '        <input type="text" id="firstname" name="firstname" required>';
      $html .= '    </div>';
      $html .= '    <div style="margin-top: 10px;">';
      $html .= '        <button type="submit">Envoyer</button>';
      $html .= '    </div>';
      $html .= '</form>';

      // Création et renvoi de la réponse
      return new Response(
        200,
        ['Content-Type' => 'text/html; charset=utf-8'],
        $html
      );
    } elseif ($request->getMethod() == "POST") {
      // Récupération des données POST en utilisant getParsedBody()
      $postData = $request->getParsedBody();
      // Création du contenu HTML pour une meilleure lisibilité
      $html = '<h1>Résultat du formulaire de test</h1>';
      $html .= '<dl>';
      $html .= ' <dt>Valeur de POST</dt>';
      // Affichage de toutes les données POST
      if (is_array($postData) && !empty($postData)) {
        foreach ($postData as $key => $value) {
          $html .= ' <dd><strong>' . htmlspecialchars($key) . '</strong>: ' . htmlspecialchars($value) . '</dd>';
        }
      } else {
        $html .= ' <dd>Aucune donnée POST reçue</dd>';
      }
      $html .= '</dl>';

      // Création et renvoi de la réponse
      return new Response(
        200,
        ['Content-Type' => 'text/html; charset=utf-8'],
        $html
      );
    }
  }
}
