<?php



use \Psr\Http\Message\ServerRequestInterface as Request;

use \Psr\Http\Message\ResponseInterface as Response;



use function FastRoute\TestFixtures\all_options_cached;



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

        "mysql:host=" . $settings['host'] . ";dbname=" . $settings['dbname'] . ";charset=utf8",

        $settings['user'],

        $settings['pass']

    );

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);



    return $pdo;
};



$app->get('/get', function (Request $request, Response $response, array $args) {

    $sql = "select * from book_log bl

    join reservation_info r

    on bl.bl_reservation = r.resinfo_id

    join agency a

    on r.resinfo_agency = a.agency_id 

    join rooms rm

    on bl.bl_room = rm.room_id

    join room_type rt 

    on rm.room_type = rt.rtype_id

    join room_status rs

    on bl.bl_status = rs.rstatus_id

    join room_view rv 

    on rm.room_view = rv.rview_id

    join building b

    on rm.room_building = b.building_id

    left join guest_info gi

    on bl.bl_ginfo = gi.ginfo_id where bl.bl_id = 1";

    $sth = $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);

    return $this->response->withJson($sth);
});
$app->run();
