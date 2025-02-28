<?php

return [
  [
    "path" => '/',
    "controller" => 'Diginamic\Framework\Controller\HomeController',
    "controllerMethod" => 'index',
    "httpMethod" => 'GET'
  ],
  [
    "path" => '/uri-infos',
    "controller" => 'Diginamic\Framework\Controller\FirstController',
    "controllerMethod" => 'handleRequest',
    "httpMethod" => 'GET'
  ],
  [
    "path" => '/test-post',
    "controller" => 'Diginamic\Framework\Controller\FirstController',
    "controllerMethod" => 'testPost',
    "httpMethod" => 'GET'
  ],
  [
    "path" => '/test-post',
    "controller" => 'Diginamic\Framework\Controller\FirstController',
    "controllerMethod" => 'testPost',
    "httpMethod" => 'POST'
  ]
];
