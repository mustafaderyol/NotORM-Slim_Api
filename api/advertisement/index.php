<?php

header('Access-Control-Allow-Headers: Content-Type, X-Requested-With');
header('Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS');

require dirname(__FILE__) . '../../../third-party/Slim/Slim.php';
require dirname(__FILE__) . '../../../libs/advertisement.php';

\Slim\Slim::registerAutoloader();

$app    = new \Slim\Slim();
$uup    = new uup();
// base router
$app->get('/', function() use ($uup) {

    echo json_encode($uup->getAllAdvertisement());

});

$app->get('/:id', function($id) use ($uup) {

    echo json_encode($uup->getAdvertisementViewWithId($id));

});

$app->get('/delete/:id', function($id) use ($uup) {

    echo json_encode($uup->deleteAdvertisementId($id));

});

$app->post('/', function() use ($app,$uup){

    $data = (array) json_decode($app->request()->getBody());

   echo json_encode($uup->saveContent(array(
        "id"            => $data["id"],
        "company_id"    => $data["company_id"],
        "city_id"       => $data["city_id"],
        "date"          => $data["date"],
        "picture"       => $data["picture"]
   )));

});


$app->post('/update/', function() use ($app,$uup){

    $data = (array) json_decode($app->request()->getBody());

   echo json_encode($uup->updateContent(array(
        "id"            => $data["id"],
        "company_id"    => $data["company_id"],
        "city_id"       => $data["city_id"],
        "date"          => $data["date"],
        "picture"       => $data["picture"]
   )));

});


$app->notFound(function () use ($uup) {

    echo json_encode($uup->errorNotFound());

});

$app->options('/', function() {

});

$app->run();