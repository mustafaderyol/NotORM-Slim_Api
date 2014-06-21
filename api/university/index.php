<?php

header('Access-Control-Allow-Headers: Content-Type, X-Requested-With');
header('Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS');

require dirname(__FILE__) . '../../../third-party/Slim/Slim.php';
require dirname(__FILE__) . '../../../libs/university.php';

\Slim\Slim::registerAutoloader();

$app    = new \Slim\Slim();
$uup    = new uup();
// base router
$app->get('/', function() use ($uup) {

    echo json_encode($uup->getAllUniversities());

});

$app->get('/:id', function($id) use ($uup) {

    echo json_encode($uup->getUniversityViewWithId($id));

});

$app->get('/ext/:ext', function($ext) use ($uup) {

    echo json_encode($uup->getUniversityViewWithExt($ext));

});

$app->get('/city/:id', function($id) use ($uup) {

    echo json_encode($uup->getUniversityViewWithCity($id));

});

$app->get('/delete/:id', function($id) use ($uup) {

    echo json_encode($uup->deleteUniversityId($id));

});

$app->post('/', function() use ($app,$uup){

    $data = (array) json_decode($app->request()->getBody());

   echo json_encode($uup->saveContent(array(
        "id"                => $data["id"],
        "university_name"   => $data["university_name"],
        "university_ext"    => $data["university_ext"],
        "city_id"           => $data["city_id"]
   )));

});


$app->post('/update/', function() use ($app,$uup){

    $data = (array) json_decode($app->request()->getBody());

   echo json_encode($uup->updateContent(array(
        "id"                => $data["id"],
        "university_name"   => $data["university_name"],
        "university_ext"    => $data["university_ext"],
        "city_id"           => $data["city_id"]
   )));

});


$app->notFound(function () use ($uup) {

    echo json_encode($uup->errorNotFound());

});

$app->options('/', function() {

});

$app->run();