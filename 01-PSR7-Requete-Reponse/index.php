<?php

require_once 'vendor/autoload.php';


use Diginamic\Framework\Controller\FirstController;
use GuzzleHttp\Psr7\ServerRequest;

// Création de la requête à partir des données du serveur
$request = ServerRequest::fromGlobals();

// Instanciation du contrôleur et traitement de la requête
$controller = new FirstController();
$response = $controller->handleRequest($request);

// Envoi du corps de la réponse
echo $response->getBody();
