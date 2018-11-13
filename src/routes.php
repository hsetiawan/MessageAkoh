<?php

use Slim\Http\Request;
use Slim\Http\Response;

// Routes

$app->get('/', function (Request $request, Response $response, array $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});

$app->group('/msg', function() {
    $this->get('', \MessageController::class . ':getAllMessages'); //get all messages [GET]
    $this->get('/{idMessage}', \MessageController::class . ':getMessageByID'); //get a message by id [GET]
    $this->post('', \MessageController::class . ':proccessMessage'); //send message with parameter msg & sender_id [POST]
});
 