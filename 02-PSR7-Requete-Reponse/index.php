<?php

require_once 'vendor/autoload.php';


use Diginamic\Framework\Controller\FirstController;
use Diginamic\Framework\Response\ResponseEmitter;
use GuzzleHttp\Psr7\ServerRequest;

// Création de la requête à partir des données du serveur
$request = ServerRequest::fromGlobals();

// Instanciation du contrôleur et traitement de la requête
$controller = new FirstController();
$response = $controller->handleRequest($request);

// Envoi de la réponse avec l'émetteur
$emitter = new ResponseEmitter();
$emitter->emit($response);
