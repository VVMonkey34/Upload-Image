<?php
require "autoload.php";
session_start();
require_once("fonctions.php");


if(!isset($_GET["action"]))
{
    exit;
}

switch($_GET["action"])
{
    case "get_contacts":

$resultats = Db::singleton()->select_sql("
SELECT * FROM user 
WHERE mail <> '".$_SESSION["mail"]."' ");

$contacts=[];

foreach( $resultats  as $compte  )
{
        if(!$compte["pseudo"] || !$compte["user_img"] ) continue;
        unset($compte["password"]);
        array_push($contacts,$compte);
   
}
echo json_encode($contacts);

    break;
    case "send_message":
// Recupere le message en post

    date_default_timezone_set('Europe/Paris');
    $post =  file_get_contents("php://input");
    $info= json_decode($post,true);
    $msg = $info["msg"];
$date = new DateTime();

$reponse=[];
if(isset($_GET["to"]))
{
    $to = $_GET["to"];
    //Nouvelle discussion
  
    $discussion_id= $_SESSION["mail"] . "_" . $date->getTimestamp();
    add_discussion($discussion_id,$to);
    add_discussion($discussion_id,$_SESSION["mail"]);
     
    $discussion=[  
        "participants"=>[ $_SESSION["mail"], $to],
        "messages"=>[]
    ];

// Renvoyer les discussions
$reponse["discussion_id"]=$discussion_id;
$compte= moncompte();
$reponse["discussions"]=$compte["discussions"];
}else
{
    //Discussion 
    $discussion_id= $_GET["discussion_id"];
   $discussion= json_decode(file_get_contents("discussions/$discussion_id") ,true);
}
//
array_push( $discussion["messages"],[
"author"=>$_SESSION["mail"],
"msg"=>$msg,
"date"=> date("Y-m-d H:i:s")
]);
file_put_contents("discussions/$discussion_id",json_encode($discussion));

// Renvoyer les messages de la discussion courante

$reponse["discussion"]=$discussion;

echo json_encode($reponse);
    break;
        case "get_messages"://?action=get_messages&discussion_id=xxxxx
            //Envoie les messages d'une discussion donnée 
            // discussion_id
            $discussion_id= $_GET["discussion_id"];
            echo file_get_contents("discussions/$discussion_id");
            break;
        case "get_discussions":
          
            echo json_encode( get_discussions() );
            break;
            case "refresh":
                $resultats=["discussions"=>get_discussions()];
                if(isset($_GET["discussion_id"]))
                {
                 $discussion_id=$_GET["discussion_id"];
                 $resultats["messages"]= json_decode( file_get_contents("discussions/$discussion_id"),true)["messages"];
                }
              echo json_encode(   $resultats  );
         

                break;

}