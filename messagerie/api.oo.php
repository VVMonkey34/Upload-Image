<?php
    session_start();

   require "autoload.php";


if(!isset($_GET["action"]) || !isset($_SESSION["mail"]))
{
    exit;
}
 $me = Me::loadme();


switch($_GET["action"])
{
    case "get_contacts":

   
    echo json_encode($me->get_contacts());
    break;
    case "send_message":
    $post =  file_get_contents("php://input");
    $info= json_decode($post,true);
    $msg = $info["msg"];

    // Renvoie la methode send_message et verifie si il y a déja une discussions ou non
    $message =  $me->send_message($msg,
    isset($_GET["to"])?$_GET['to']:null,
    isset($_GET["discussion_id"])?$_GET['discussion_id']:null);

    $reponse=[
    "discussion_id"=>$message->discussion_id,
    "discussions"=> $me->get_discussions(),
    "discussion"=>$message->getConversation()->toArray()];
    echo json_encode(  $reponse);
    break;
    case "get_messages":
    $conversation = Conversation::load($_GET['discussion_id']);
    echo $conversation->tojson();
    break;
    case "get_discussions":
 
    echo  json_encode( $me->get_discussions());
    break;
    case "refresh":

        $resultats=["discussions"=>json_encode( $me->get_discussions())];
        if(isset($_GET["discussion_id"]))
                {
                      $conversation = Conversation::load($_GET['discussion_id']);
                   
                 $discussion_id=$_GET["discussion_id"];
                 $resultats["messages"]=  $conversation->tojson();
                }
              echo json_encode(   $resultats  );

    break;




} 
?>