<?php

header('Access-Control-Allow-Headers: Content-Type, X-Requested-With');
header('Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS');

require dirname(__FILE__) . '../../../third-party/Slim/Slim.php';
require dirname(__FILE__) . '../../../libs/city.php';

\Slim\Slim::registerAutoloader();

$app    = new \Slim\Slim();
 $app->contentType('text/html; charset=utf-8');
$uup    = new uup();
// base router
$app->get('/', function() use ($uup) {

  echo json_encode($uup->getAllCities());

});

$app->get('/:id', function($id) use ($uup) {

    echo json_encode($uup->getCityViewWithId($id));

});


$app->get('/cityName/:name', function($name) use ($uup) {

    echo json_encode($uup->getCityViewWithCityName($name));

});

$app->get('/delete/id/:id', function($id) use ($uup) {

    echo json_encode($uup->deleteCityId($id));

});

$app->get('/delete/name/:name', function($name) use ($uup) {

    echo json_encode($uup->deleteCityName($name));

});

$app->post('/', function() use ($app,$uup){

    $data = (array) json_decode($app->request()->getBody());

   echo json_encode($uup->saveContent(array(
        "id"       => $data["id"],
        "city_name"     => $data["city_name"]
   )));

});


$app->post('/update/', function() use ($app,$uup){

    $data = (array) json_decode($app->request()->getBody());

   echo json_encode($uup->updateContent(array(
        "id"       => $data["id"],
        "city_name"     => $data["city_name"]
   )));

});


$app->notFound(function () use ($uup) {

    echo json_encode($uup->errorNotFound());

});

$app->options('/', function() {

});

$app->run();