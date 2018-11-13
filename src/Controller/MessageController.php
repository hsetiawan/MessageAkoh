<?php

namespace App\Controller;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;


class MessageController
{
    protected $logger;
    protected $pdo;

    public function __construct($logger,$pdo) {
        $this->logger = $logger;
        $this->pdo = $pdo;
    }

   //method  melihat pesan yang sudah di kirim
   public function getAllMessages(Request $request,Response $response,array $args) {
        $result = array();
        $codeResult = 0;
        $methodName = "getAllMessages";
        $msgProccess = "";
        $msgStatus = "failed";

        
        $sql = "SELECT * FROM t_message order by created_at desc";
          try {
              $db = $this->pdo;
              $stmt = $db->prepare($sql);  $stmt->execute();
              $objResult = $stmt->fetchAll();
              $db = null;
              if($objResult){ //if obj result is found
                $msgStatus = "success";        
                $msgProccess = $objResult;
                $codeResult = $this->dataOK($methodName,$request);
              }else{
                $msgProccess = "is not found.";
                $codeResult = $this->dataNotFound($methodName,$request);
              }
              
          } catch(PDOException $e) {
            $msgProccess = $e;
            $codeResult = $this->error($methodName,$request,$e);
          }

          $result = $this->resultResponse($msgStatus,$msgProccess);
          $newResponse = $response->withJson($result,$codeResult);
        return $newResponse;
    }


  // method melihat pesan yang sudah di kirim by message id | message id is required
   public function getMessageByID(Request $request,Response $response,array $args) {
        $idParameter = $args['idMessage']; //get parameter id message
        $result = array();
        $codeResult = 0;
        $methodName = "getMessageByID";
        $msgProccess = "";
        $msgStatus = "failed";

         
        $sql = "SELECT * FROM t_message WHERE message_id=:message_id  "; //query sql
          try {
              $db = $this->pdo;
              $stmt = $db->prepare($sql);
              $stmt->bindParam("message_id", $idParameter);  $stmt->execute();
              $objResult = $stmt->fetchObject();
              $db = null;
              if($objResult){ //if obj result is found
      
                $msgStatus = "success";        
                $msgProccess = $objResult;
                $codeResult = $this->dataOK($methodName,$request);
              
              }else{ //if obj result is not found/ false
                
                $msgProccess = "not found";
                $codeResult = $this->dataNotFound($methodName,$request);
              
              }
              
          } catch(PDOException $e) {
            $msgProccess = $e;
            $codeResult = $this->error($methodName,$request,$e);
          }

          $result = $this->resultResponse($msgStatus,$msgProccess);
          $newResponse = $response->withJson($result,$codeResult);
        return $newResponse;
    }


   // method mengirim pesan
   public function proccessMessage(Request $request,Response $response,array $args) {
        $methodName = "proccessMessage";

        $collectParameter =  $request->getParsedBody(); //collect all parameter 
        $result = array();
        $codeResult = 0;
        $msgProccess = "";
        $msgStatus = "failed";

        $doProccess = true;

         //start validation 
        if(empty($collectParameter) ){  // if send request without parameter
          
          $doProccess = false;
          $msgProccess = "parameter is not correct";
        
        }else{
          if (!array_key_exists("msg",$collectParameter) 
          || strlen($collectParameter["msg"]) < 1){ //  content message length is less of 1
            $doProccess = false;
            $msgProccess = "message is empty";
          } 

          if(!array_key_exists("sender_id",$collectParameter) 
          || strlen($collectParameter["sender_id"]) < 1 ){ //  sender)id message length is less of 1
            $doProccess = false;
            $msgProccess = "sender_id is empty";
          }
        }
        //end of vaidation

        if($doProccess){ //do proccess insert to db 
            $msgContent = $collectParameter["msg"]; // get message content from parameter
            $sender_id = $collectParameter["sender_id"]; // get message content from parameter
            $sql = "INSERT into t_message (message_value,sender_id) values (:message_value,:sender_id)"; //query sql insert
            

            try {
                $db = $this->pdo;
                $stmt = $db->prepare($sql);
                $stmt->bindParam("message_value", $msgContent); 
                $stmt->bindParam("sender_id", $sender_id); 
                $stmt->execute();
                $objResult = $db->lastInsertId(); //get last id, if success insert message.
                $db = null;

                if($objResult != null){ //if obj result is not null 

                   $msgStatus = "success";
                   $msgProccess = $objResult;
                   $codeResult = $this->dataOK($methodName,$request); 
                   
                }else{ //if obj result is null

                  $msgProccess = $objResult;
                  $codeResult = $this->dataNotFound($methodName,$request);
                
                }
                
            } catch(PDOException $e) {
              $codeResult = $this->error($methodName,$request,$e);
              $msgProccess = $e;
            }

        }else{
           $codeResult = $this->error($methodName,$request,$msgProccess);
        }
        
        $result = $this->resultResponse($msgStatus,$msgProccess);
        $newResponse = $response->withJson($result,$codeResult); //convert result to json
        return $newResponse;
    }


    //log type warning : if data return is not found.
    public function dataNotFound($functionName,Request $request){
           $resultCode = 404;  
           $path = $request->getUri()->getPath();
           $this->logger->warn($path." ".$functionName." : code 404 - data not found.");
      return $resultCode;
    }

    //log type info : if data return is no empty.
    public function dataOK($functionName,Request $request){
           $resultCode = 200;  
           $path = $request->getUri()->getPath();
           $this->logger->info($path." ".$functionName." : code 200");
      return $resultCode;
    }

    //log type error.
    public function error($functionName,Request $request,$reason){
           $resultCode = 400;  
           $path = $request->getUri()->getPath();
           $this->logger->error($path." ".$functionName." . reason : ".$reason);
      return $resultCode;
    }
    
  public function resultResponse($status,$data){
       $result = array(["status" => $status, "data" => $data]);    
      return $result;
    }

   
}