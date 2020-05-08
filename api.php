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
        "mysql:host=" . $settings['host'] . ";dbname=" . $settings['dbname'] . ";charset=UTF8",
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
    $sql = "SELECT * from reservation_info re 
    join book_log bl
    on  re.resinfo_id = bl.bl_reservation
    join rooms r 
    on bl.bl_room = r.room_id
    group by re.resinfo_id;";
    $sth = $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    return $this->response->withJson($sth);
});
$app->get('/getdb/{id}', function (Request $request, Response $response, array $args) {
    $id = $args['id'];
    $sql = "SELECT * from reservation_info re 
    join book_log bl
    on  re.resinfo_id = bl.bl_reservation
    join rooms r 
    on bl.bl_room = r.room_id
    WHERE re.resinfo_id = $id
    group by re.resinfo_id";
    $sth = $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    return $this->response->withJson($sth);
});
$app->get('/addroom/{id}', function (Request $request, Response $response, array $args) {
    $id = $args['id'];
    $sql = "SELECT *from reservation_info re 
    join book_log bl
    on  re.resinfo_id = bl.bl_reservation
    WHERE re.resinfo_id = $id
    group by re.resinfo_id";
    $sth = $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    return $this->response->withJson($sth);
});
$app->get('/room', function (Request $request, Response $response, array $args) {
    $sql = "SELECT * from rooms r join room_status rs on r.room_status = rs.rstatus_id WHERE rs.rstatus_eng='Avaliable'";
    $sth = $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    return $this->response->withJson($sth);
});
$app->post('/saveadd', function (Request $request, Response $response, array $args) {
    $params = $_POST;
    $bl_id = $params['id_bl_save'];
    $room_id = $params['select'];
    try {
        $sql = "SELECT *from guest_info g 
        join book_log bl
        on  g.ginfo_id = bl.bl_ginfo
        WHERE bl_id = $bl_id";
        $sth = $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        $bl_ginfo = ($sth[0]['bl_ginfo']);
        $sql1 = "INSERT INTO book_log (bl_reservation, bl_ginfo, bl_checkin, bl_room)
        SELECT bl_reservation, bl_ginfo, bl_checkin, '$room_id'
        FROM book_log WHERE bl_id = $bl_id";
        $this->db->query($sql1);
        $sql2 = "INSERT INTO guest_info ( ginfo_first_name, ginfo_last_name,ginfo_tax_id, ginfo_name_bill)
        SELECT ginfo_first_name, ginfo_last_name, ginfo_tax_id, ginfo_name_bill
        FROM guest_info WHERE ginfo_id = $bl_ginfo";
        $this->db->query($sql2);
        $sql3 = "UPDATE rooms set room_status ='4'where room_id = '$room_id'";
        $this->db->query($sql3);
        return $this->response->withJson(array('message' => 'success'));
    } catch (PDOException $e) {
        return $this->response->withJson(array('message' => 'false4'));
    }
});
$app->get('/show_info/{id}', function (Request $request, Response $response, array $args) {
    $bl_id = $args['id'];
    $sql = "SELECT * FROM reservation_info rs join book_log bl
    on rs.resinfo_id = bl.bl_reservation join guest_info g
    on bl.bl_ginfo = g.ginfo_id join rooms r
    on bl.bl_room = r.room_id join room_type rt
    on r.room_type = rt.rtype_id join room_view rv
    on r.room_view = rv.rview_id join building bd
    on r.room_building = bd.building_id
    where bl.bl_id = $bl_id ";
    $sth = $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    return $this->response->withJson($sth);
});
$app->post('/update_guest', function (Request $request, Response $response, array $args) {
    $params = $_POST;
    $bl_id = $params['id_bl_save'];
    $room_id = $params['select'];
    try {
        $sql = "SELECT *from guest_info g 
        join book_log bl
        on  g.ginfo_id = bl.bl_ginfo
        WHERE bl_id = $bl_id";
        $sth = $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        $bl_ginfo = ($sth[0]['bl_ginfo']);
        $sql1 = "INSERT INTO book_log (bl_reservation, bl_ginfo, bl_checkin, bl_room)
        SELECT bl_reservation, bl_ginfo, bl_checkin, '$room_id'
        FROM book_log WHERE bl_id = $bl_id";
        $this->db->query($sql1);
        $sql2 = "INSERT INTO guest_info ( ginfo_first_name, ginfo_last_name,ginfo_tax_id, ginfo_name_bill)
        SELECT ginfo_first_name, ginfo_last_name, ginfo_tax_id, ginfo_name_bill
        FROM guest_info WHERE ginfo_id = $bl_ginfo";
        $this->db->query($sql2);
        $sql3 = "UPDATE rooms set room_status ='4'where room_id = '$room_id'";
        $this->db->query($sql3);
        return $this->response->withJson(array('message' => 'success'));
    } catch (PDOException $e) {
        return $this->response->withJson(array('message' => 'false4'));
    }
});
$app->run();
