<?php

namespace Diginamic\Framework\Router;

use Diginamic\Framework\Exception\RouteNotFoundException;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Classe qui permet :
 *   d'ajouter de nouvelles routes
 *   de renvoyer le bon controller et la bonne méthode en fonction qu'une requête HTTP
 */
class Router
{
  /** @var Route[] */
  private array $routes = [];

  public function addRoute(string $path, string $controller, string $controllerMethod, string $httpMethod,): void
  {
    $this->routes[] = new Route($path, $controller, $controllerMethod, $httpMethod);
  }


  /**
   * la méthode dispatch
   * - Reçoit la requête HTTP
   * - En extrait le chemin
   * - Cherche une route correspondante
   * - Retourne les informations nécessaires pour exécuter le bon controller
   * - Ou lance une exception si aucune route ne correspond
   *
   * @param ServerRequestInterface $request
   * @return array avec les clés "controller" et "method"
   */
  public function dispatch(ServerRequestInterface $request): array
  {
    $path = $request->getUri()->getPath();
    $httpMethod = $request->getMethod();

    foreach ($this->routes as $route) {
      if ($route->matches($path) && ($httpMethod == $route->getHttpMethod())) {
        return [
          'controller' => $route->getController(),
          'method' => $route->getControllerMethod()
        ];
      }
    }

    throw new RouteNotFoundException('No route found for ' . $path);
  }
}
