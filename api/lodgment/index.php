<?php

header('Access-Control-Allow-Headers: Content-Type, X-Requested-With');
header('Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS');

require dirname(__FILE__) . '../../../third-party/Slim/Slim.php';
require dirname(__FILE__) . '../../../libs/lodgment.php';

\Slim\Slim::registerAutoloader();

$app    = new \Slim\Slim();
$uup    = new uup();
// base router
$app->get('/', function() use ($uup) {

    echo json_encode($uup->getAllLodgments());

});

$app->get('/:id', function($id) use ($uup) {

    echo json_encode($uup->getLodgmentViewWithId($id));

});

$app->get('/userId/:id', function($id) use ($uup) {

    echo json_encode($uup->getLodgmentViewWithUserID($id));

});

$app->get('/message/:id', function($id) use ($uup) {

    echo json_encode($uup->getLodgmentViewWithMessageId($id));

});

$app->get('/reason/:id', function($id) use ($uup) {

    echo json_encode($uup->getLodgmentViewWithReasonId($id));

});

$app->get('/delete/:id', function($id) use ($uup) {

    echo json_encode($uup->deleteLodgmentId($id));

});

$app->post('/', function() use ($app,$uup){

    $data = (array) json_decode($app->request()->getBody());

   echo json_encode($uup->saveContent(array(
                "id"          => $data["id"],
                "user_id"     => $data["user_id"],
                "message_id"  => $data["message_id"],
                "ip"          => $data["ip"],
                "date"        => $data["date"],
                "reason_id"   => $data["reason_id"]
   )));

});


$app->notFound(function () use ($uup) {

    echo json_encode($uup->errorNotFound());

});

$app->options('/', function() {

});

$app->run();