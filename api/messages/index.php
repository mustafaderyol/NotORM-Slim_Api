<?php

header('Access-Control-Allow-Headers: Content-Type, X-Requested-With');
header('Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS');

require dirname(__FILE__) . '../../../third-party/Slim/Slim.php';
require dirname(__FILE__) . '../../../libs/messages.php';

\Slim\Slim::registerAutoloader();

$app    = new \Slim\Slim();
$uup    = new uup();
// base router
$app->get('/', function() use ($uup) {

    echo json_encode($uup->getAllMessages());

});

$app->get('/:id', function($id) use ($uup) {

    echo json_encode($uup->getMessageViewWithId($id));

});

$app->get('/max/', function() use ($uup) {

    echo json_encode($uup->getMaxViewedMessage());

}); 

$app->get('/message/:id', function($id) use ($uup) {

    echo json_encode($uup->getMessage($id));

});

$app->get('/university/:id', function($id) use ($uup) {

    echo json_encode($uup->getMessageViewWithUniversity($id));

});

$app->get('/delete/:id', function($id) use ($uup) {

    echo json_encode($uup->deleteUserId($id));

});

$app->post('/', function() use ($app,$uup){

    $data = (array) json_decode($app->request()->getBody());

   echo json_encode($uup->saveContent(array(
        "id"                    => $data["id"],
        "user_id"               => $data["user_id"],
        "message_parent_id"     => $data["message_parent_id"],
        "message"               => $data["message"],
        "mesage_date"           => $data["mesage_date"],
        "sender_ip"             => $data["sender_ip"],
        "university_id"         => $data["university_id"]
   )));

});


$app->post('/update/', function() use ($app,$uup){

    $data = (array) json_decode($app->request()->getBody());

   echo json_encode($uup->updateContent(array(
      
        "id"                    => $data["id"],
        "message"               => $data["message"]
   )));

});


$app->notFound(function () use ($uup) {

    echo json_encode($uup->errorNotFound());

});

$app->options('/', function() {

});

$app->run();