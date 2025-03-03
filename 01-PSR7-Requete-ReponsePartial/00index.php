<?php

require 'vendor/autoload.php';


use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\ServerRequest;

// Créer une requête
$request = new ServerRequest('GET', 'http://coopernet.fr');

// Créer une réponse
$response = new Response(
  200,
  ['Content-Type' => 'application/json'],
  json_encode(['message' => 'Hello World'])
);

// Vérifier que tout fonctionne
echo $response->getStatusCode(); // Devrait afficher 200
error_log("Requête / réponse ok");
