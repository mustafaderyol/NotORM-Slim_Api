<?php

header('Access-Control-Allow-Headers: Content-Type, X-Requested-With');
header('Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS');

require dirname(__FILE__) . '../../../third-party/Slim/Slim.php';
require dirname(__FILE__) . '../../../libs/reason.php';

\Slim\Slim::registerAutoloader();

$app    = new \Slim\Slim();
$uup    = new uup();
// base router
$app->get('/', function() use ($uup) {

    echo json_encode($uup->getAllReasons());

});

$app->get('/:id', function($id) use ($uup) {

    echo json_encode($uup->getReasonViewWithId($id));

});

$app->get('/delete/:id', function($id) use ($uup) {

    echo json_encode($uup->deleteReasonId($id));

});

$app->post('/', function() use ($app,$uup){

    $data = (array) json_decode($app->request()->getBody());

   echo json_encode($uup->saveContent(array(
                "id"          => $data["id"],
                "reason"      => $data["reason"]
   )));

});


$app->post('/update/', function() use ($app,$uup){

    $data = (array) json_decode($app->request()->getBody());

   echo json_encode($uup->updateContent(array(
                "id"          => $data["id"],
                "reason"      => $data["reason"]
   )));

});


$app->notFound(function () use ($uup) {

    echo json_encode($uup->errorNotFound());

});

$app->options('/', function() {

});

$app->run();