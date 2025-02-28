<?php

namespace Diginamic\Framework\Router;

class Route
{
  public function __construct(
    private string $path,
    private string $controller,
    private string $controllerMethod,
    private string $httpMethod
  ) {}

  public function matches(string $path): bool
  {
    return $this->path === $path;
  }

  public function getController(): string
  {
    return $this->controller;
  }

  public function getControllerMethod(): string
  {
    return $this->controllerMethod;
  }
  public function getHttpMethod(): string
  {
    return $this->httpMethod;
  }
}
