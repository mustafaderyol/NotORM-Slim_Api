<?php

header('Access-Control-Allow-Headers: Content-Type, X-Requested-With');
header('Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS');

require dirname(__FILE__) . '../../../third-party/Slim/Slim.php';
require dirname(__FILE__) . '../../../libs/user.php';

\Slim\Slim::registerAutoloader();

$app    = new \Slim\Slim();
$uup    = new uup();
// base router
$app->get('/', function() use ($uup) {

    echo json_encode($uup->getAllUsers());

});

$app->get('/:id', function($id) use ($uup) {

    echo json_encode($uup->getUserViewWithId($id));

});

$app->get('/max/', function() use ($uup) {

    echo json_encode($uup->getMaxViewedUser());

}); 

$app->get('/usernick/:nick', function($nick) use ($uup) {

    echo json_encode($uup->getUserViewWithNick($nick));

});

$app->get('/university/:id', function($id) use ($uup) {

    echo json_encode($uup->getUserViewWithUniversity($id));

});

$app->get('/delete/id/:id', function($id) use ($uup) {

    echo json_encode($uup->deleteUserId($id));

});

$app->get('/delete/nick/:nick', function($nick) use ($uup) {

    echo json_encode($uup->deleteUserNick($nick));

});

$app->post('/', function() use ($app,$uup){

    $data = (array) json_decode($app->request()->getBody());

   echo json_encode($uup->saveContent(array(
      "id"          => $data["id"],
      "user_nick"     => $data["user_nick"],
      "user_mail"     => $data["user_mail"],
      "user_password" => $data["user_password"],
      "user_photo"    => $data["user_photo"],
      "user_gender"   => $data["user_gender"],
      "university_id" => $data["university_id"]
   )));

});


$app->post('/update/', function() use ($app,$uup){

    $data = (array) json_decode($app->request()->getBody());

   echo json_encode($uup->updateContent(array(
      "id"            => $data["id"],
      "user_nick"     => $data["user_nick"],
      "user_mail"     => $data["user_mail"],
      "user_password" => $data["user_password"],
      "user_photo"    => $data["user_photo"],
      "user_gender"   => $data["user_gender"],
      "university_id" => $data["university_id"]
   )));

});


$app->notFound(function () use ($uup) {

    echo json_encode($uup->errorNotFound());

});

$app->options('/', function() {

});

$app->run();