<?php

require_once 'vendor/autoload.php';

use Diginamic\Framework\Router\Router;
use Diginamic\Framework\Response\ResponseEmitter;
use Diginamic\Framework\Exception\RouteNotFoundException;
use Diginamic\Framework\Middleware\MiddlewareHandler;
use Diginamic\Framework\Middleware\AuthMiddleware;
use GuzzleHttp\Psr7\ServerRequest;
use GuzzleHttp\Psr7\Response;

// Démarrer la session si vous utilisez les sessions pour l'authentification
session_start();

$router = new Router();

// Ajout d'un middleware global d'authentification
// Avec la liste des routes protégées
$authMiddleware = new AuthMiddleware([
  '/admin',
  '/profile'
  // Ajoutez ici d'autres routes protégées
]);
$router->addMiddleware($authMiddleware);

// Chargement des routes depuis le fichier routes.php
$routes = require_once __DIR__ . '/src/Router/routes.php';

// Parcours du tableau de routes et ajout de chaque route au router
foreach ($routes as $route) {
  $middlewares = $route['middlewares'] ?? [];
  $paramPatterns = $route['params'] ?? [];

  $router->addRoute(
    $route['path'],
    $route['controller'],
    $route['controllerMethod'],
    $route['httpMethod'],
    $paramPatterns,
    $middlewares
  );
}

// Traitement de la requête actuelle
$request = ServerRequest::fromGlobals();
$emitter = new ResponseEmitter();

try {
  // Dispatch de la route
  $route = $router->dispatch($request);

  // Préparation du gestionnaire de middleware
  $middlewareHandler = new MiddlewareHandler();

  // Ajout des middlewares de la route
  foreach ($route['middlewares'] as $middleware) {
    $middlewareHandler->addMiddleware($middleware);
  }

  // Définition du contrôleur comme fonction finale
  $controller = new $route['controller']();
  $method = $route['controllerMethod'];

  $middlewareHandler->setController(function ($request) use ($controller, $method, $route) {
    return $controller->$method($request, $route['params'] ?? []);
  });

  // Exécution de la chaîne de middlewares
  $response = $middlewareHandler->handle($request);

  $emitter->emit($response);
} catch (RouteNotFoundException $e) {
  // Gestion de l'erreur 404
  $response = new Response(
    404,
    ['Content-Type' => 'text/html'],
    '<h1>404 - Page non trouvée</h1>'
  );
  $emitter->emit($response);
}
