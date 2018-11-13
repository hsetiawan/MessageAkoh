<?php

use Slim\Http\Request;
use Slim\Http\Response;

// Routes
$app->get('/', function (Request $request, Response $response, array $args) {
    // This Log
    $this->logger->info("'/' route");
    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args); 
});

$app->group('/msg', function() { 
    
	//get all messages [GET], 
    //routes to MessageController class to method getAllMessages
    $this->get('', \MessageController::class . ':getAllMessages'); 


    //get message by :id [GET], 
    //routes to MessageController class to method getMessageByID
    $this->get('/{idMessage}', \MessageController::class . ':getMessageByID'); 

    //send message with parameters `msg & sender_id` [POST], 
    //routes to MessageController class to method proccessMessage
    $this->post('', \MessageController::class . ':proccessMessage'); 
});
 