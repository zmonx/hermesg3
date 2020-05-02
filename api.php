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
$app->post('/saveadd/{resinfo_id}/{room_id}', function (Request $request, Response $response, array $args) {
    $resinfo = $args['resinfo_id'];
    $room_id = $args['room_id'];
    $sql = "SELECT *from reservation_info re 
    join book_log bl
    on  re.resinfo_id = bl.bl_reservation
    WHERE re.resinfo_id = $resinfo
    group by re.resinfo_id";
    $sth = $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    $bl_id = ($sth[0]['bl_id']);
    $bl_ginfo = ($sth[0]['bl_ginfo']);
    $sql1 = "INSERT INTO reservation_info (resinfo_code, resinfo_first_name, resinfo_last_name, resinfo_telno, resinfo_email, resinfo_comments, resinfo_bookdate, resinfo_agency, resinfo_number, resinfo_flag )
    SELECT resinfo_code, resinfo_first_name, resinfo_last_name, resinfo_telno, resinfo_email, resinfo_comments, resinfo_bookdate, resinfo_agency, resinfo_number, resinfo_flag
    FROM reservation_info WHERE resinfo_id = $resinfo";
    $this->db->query($sql1);
    $sql2 = "INSERT INTO book_log (bl_reservation, bl_ginfo, bl_checkin, bl_timestamp, bl_room, bl_status, bl_price, bl_incbreakfast, bl_breakfast, bl_comment)
    SELECT bl_reservation, bl_ginfo, bl_checkin, bl_timestamp, '$room_id', bl_status, bl_price, bl_incbreakfast, bl_breakfast, bl_comment
    FROM book_log WHERE bl_id = $bl_id";
    $this->db->query($sql2);
    $sql3 = "INSERT INTO guest_info (ginfo_title_name, ginfo_first_name, ginfo_last_name, ginfo_passport_id, ginfo_birthday, ginfo_sex, ginfo_company, ginfo_nation, ginfo_email, ginfo_telno, ginfo_mail_addr, ginfo_bill_addr, ginfo_comment, ginfo_flag, ginfo_room, ginfo_in, ginfo_out, ginfo_night, ginfo_price, ginfo_rateplan, ginfo_full_price, ginfo_status, ginfo_price_total, ginfo_passport_image, ginfo_selfie_image, ginfo_credit_card, ginfo_payment, ginfo_tax, ginfo_empfront, ginfo_update, ginfo_checkin, ginfo_checkout, ginfo_tax_id, ginfo_name_bill)
    SELECT ginfo_title_name, ginfo_first_name, ginfo_last_name, ginfo_passport_id, ginfo_birthday, ginfo_sex, ginfo_company, ginfo_nation, ginfo_email, ginfo_telno, ginfo_mail_addr, ginfo_bill_addr, ginfo_comment, ginfo_flag, '$room_id', ginfo_in, ginfo_out, ginfo_night, ginfo_price, ginfo_rateplan, ginfo_full_price, ginfo_status, ginfo_price_total, ginfo_passport_image, ginfo_selfie_image, ginfo_credit_card, ginfo_payment, ginfo_tax, ginfo_empfront, ginfo_update, ginfo_checkin, ginfo_checkout, ginfo_tax_id, ginfo_name_bill
    FROM guest_info WHERE ginfo_id = $bl_ginfo";
    $this->db->query($sql3);
    $sql4 = "UPDATE rooms set room_status ='0'where room_id = '$room_id'";
    $this->db->query($sql4);
});
$app->get('/editguest/{id}', function (Request $request, Response $response, array $args) {
    $id = $args['id'];
    $sql = "SELECT *from guest_info g
    join book_log bl
    on  g.ginfo_id = bl.bl_ginfo
    WHERE g.ginfo_id = $id
    group by g.ginfo_id";
    $sth = $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    return $this->response->withJson($sth);
});
$app->run();
