<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require './api/vendor/autoload.php';
$config = [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
    ],
];


$app = new \Slim\App();

$app->get("/", function (Request $request, Response $response, array $args) {

    $response->getBody()->write("<h1>Hello World</h1>");
    return $response;
});
$app->get("/hello", function (Request $request, Response $response, array $args) {

    $response->getBody()->write("<h1>Hello GET method , Piyamin</h1>");
    return $response;
});
$app->get("/hello/{name}/{lname}", function (Request $request, Response $response, array $args) {
    $name = $args['name'];
    $lname = $args['lname'];
    $response->getBody()->write("<h1>Hello,$name $lname</h1>");
    return $response;
});
$app->post('/hello', function (Request $request, Response $response) {
    $data = $request->getParsedBody();
    $name = filter_var($data['name'], FILTER_SANITIZE_STRING);
    $name = filter_var($data['lname'], FILTER_SANITIZE_STRING);

    $response->getBody()->write("Hello, $name");
    return $response;
});

$app->run();


// http://localhost/www/index.php
