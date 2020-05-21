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
$app->get('/room/{id}', function (Request $request, Response $response, array $args) {
    $bl_id = $args['id'];
    $sql = "SELECT *from guest_info g 
        join book_log bl
        on  g.ginfo_id = bl.bl_ginfo
        WHERE bl.bl_id = $bl_id";
    $sth = $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    
    $bl_ginfo = ($sth[0]['bl_ginfo']);
    $ginfo_in = ($sth[0]['ginfo_in']);
    $ginfo_out =($sth[0]['ginfo_out']);
    // echo "<pre>";
    // print_r($ginfo_in);
    // print_r($ginfo_out);
    // echo "</pre>";
    // exit();
    $sql1 ="SELECT r.room_name from book_log bl join guest_info g
        on bl.bl_ginfo = g.ginfo_id
        join rooms r
        on bl.bl_room = r.room_id
        where   bl.bl_ginfo = $bl_ginfo AND bl.bl_checkin between '$ginfo_in' and '$ginfo_out'
        group by bl.bl_room";
    $sth1 = $this->db->query($sql1)->fetchAll(PDO::FETCH_ASSOC);
    // $notroom = $sth1['room_name'];
    //  echo "<pre>";
    // print_r($sth1);
    // echo "</pre>";
    // exit();
    $sql2 = "SELECT room_name ,room_id from rooms where room_name != ''";
    if(count($sth1)>0){
        foreach($sth1 as $key){
            $sql2 .= " And room_name != " .$key['room_name'];
        }
    }
    $sth2 = $this->db->query($sql2)->fetchAll(PDO::FETCH_ASSOC);
    return $this->response->withJson($sth2);
});
$app->post('/saveadd', function (Request $request, Response $response, array $args) {
    $params =$_POST;
    $bl_id = $params['id_bl_save'];
    $room_id = $params['select'];
    // echo("<pre>");
    // print_r($params);
    // echo("</pre>");
    // exit();
    try {
        $sql = "SELECT *from guest_info g 
        join book_log bl
        on  g.ginfo_id = bl.bl_ginfo
        join reservation_info re
        on bl.bl_reservation = re.resinfo_id
        WHERE bl_id = $bl_id";
        $sth = $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        $bl_ginfo = ($sth[0]['bl_ginfo']);
        $ginfo_in = ($sth[0]['ginfo_in']);
        $ginfo_out = ($sth[0]['ginfo_out']);
        $resinfo_id =($sth[0]['resinfo_id']);
        // echo "<pre>";
        // print_r($sth);
        // echo "</pre>";
        // exit();
        $sql1 = "SELECT (ginfo_out - ginfo_in)+1 as day FROM guest_info where ginfo_id = $bl_ginfo;";
        $sth1 = $this->db->query($sql1)->fetch(PDO::FETCH_ASSOC);
        // echo "<pre>";
        // print_r($sth1);
        // print_r($sth1['day']);
        // echo "</pre>";
        // exit();
        for ($i=0; $i < ($sth1['day']) ; $i++) { 
            $sql2 = "INSERT INTO book_log (bl_reservation, bl_ginfo, bl_checkin, bl_room,bl_status)
            VALUE ('$resinfo_id', '$bl_ginfo','$ginfo_in', '$room_id','2') ";
            $this->db->query($sql2);
        }
        
        return $this->response->withJson(array('message' => 'success'));
    } catch (PDOException $e) {
        return $this->response->withJson(array('message' => 'false4'));
    }
});
// card 2 show
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
// card 2 update
$app->post('/update_guest', function (Request $request, Response $response, array $args) {
    $params = $_POST;
    $bl_id = $params['id_bl_update'];
    $ginfo_first_name = $params['fname_edit_infoguest'];
    $ginfo_last_name = $params['lname_edit_infoguest'];
    $ginfo_passport_id = $params['passport_edit_infoguest'];
    $ginfo_telno = $params['phone_edit_infoguest'];
    $ginfo_birthday = $params['bd_edit_infoguest'];
    $ginfo_nation = $params['nation_edit_infoguest'];
    $ginfo_email = $params['email_edit_infoguest'];
    $ginfo_sex = $params['sex_edit_infoguest'];
    $room_price = $params['room_price_edit_infoguest'];
    $ginfo_mail_addr = $params['padd_edit_infoguest'];
    $ginfo_comment = $params['badd_edit_infoguest'];
    $bl_incbreakfast = $params['incbreakfast_edit_infoguest'];
    $bl_breakfast = $params['breakfast_edit_infoguest'];
    try {
        $sql = "SELECT g.ginfo_id from guest_info g 
        join book_log bl
        on  g.ginfo_id = bl.bl_ginfo
        WHERE bl.bl_id = $bl_id ";
        $sth = $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        $ginfo_id = ($sth[0]['ginfo_id']);

        $sql1 = "UPDATE guest_info set ginfo_first_name ='$ginfo_first_name', ginfo_last_name ='$ginfo_last_name', ginfo_passport_id ='$ginfo_passport_id', 
        ginfo_birthday ='$ginfo_birthday' , ginfo_nation = '$ginfo_nation', ginfo_email = '$ginfo_email', ginfo_telno = '$ginfo_telno', 
        ginfo_mail_addr ='$ginfo_mail_addr', ginfo_comment = '$ginfo_comment',ginfo_tax_id='115522', ginfo_name_bill='test', ginfo_sex ='$ginfo_sex' where ginfo_id = $ginfo_id";
        $this->db->query($sql1);


        return $this->response->withJson(array('message' => 'success'));
    } catch (PDOException $e) {
        return $this->response->withJson(array('message' => 'false'));
    }
});
// card 3 (15)
$app->get('/show_gesinfo_checkout', function (Request $request, Response $response, array $args) {
    $sql = "SELECT * FROM reservation_info rs join book_log bl
    on rs.resinfo_id = bl.bl_reservation join guest_info g
    on bl.bl_ginfo = g.ginfo_id join rooms r
    on bl.bl_room = r.room_id join room_type rt
    on r.room_type = rt.rtype_id join room_view rv
    on r.room_view = rv.rview_id join building bd
    on r.room_building = bd.building_id join  agency a
    on rs.resinfo_agency = a.agency_id";
    $sth = $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    return $this->response->withJson($sth);
});

$app->get('/show_data_agency', function (Request $request, Response $response, array $args) {
    $sql = "SELECT * FROM agency ";
    $sth = $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    return $this->response->withJson($sth);
});
$app->run();
