<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require './api/vendor/autoload.php';
$config = [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        // Database connection settings
        "db" => [
            "host" => "127.0.0.1",
            "dbname" => "hermes",
            "user" => "root",
            "pass" => "usbw"
        ],
    ],
];

$app = new \Slim\App($config);

// DIC configuration
$container = $app->getContainer();


// PDO database library 
$container['db'] = function ($c) {
    $settings = $c->get('settings')['db'];
    $pdo = new PDO(
        "mysql:host=" . $settings['host'] . ";dbname=" . $settings['dbname'],
        $settings['user'],
        $settings['pass']
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    return $pdo;
};


// $app->get('/', function (Request $request, Response $response, array $args) {

//     $response->getBody()->write("Hello World");
//     return $response;
// });
$app->get('/getdb', function (Request $request, Response $response, array $args) {
    $sql = "SELECT re.resinfo_first_name , re.resinfo_last_name ,re.resinfo_telno ,re.resinfo_email ,r.room_name from reservation_info re join rooms r
    on  resinfo_id = room_id;";
    $sth = $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    return $this->response->withJson($sth);
});
// $app->get('/getdb/{id}', function (Request $request, Response $response, array $args) {
//     $id = $args['id'];
//     $sql = "SELECT * from person WHERE id =$id";
//     $sth = $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
//     return $this->response->withJson($sth);
// });
$app->run();