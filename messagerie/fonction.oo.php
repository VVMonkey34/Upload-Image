<?php




class fonction{
function moncompte()
{
    $mail = $_SESSION["mail"];
    return load_compte($mail);
}  

function load_compte($mail)
{
    global $db;
    $user = $db -> select_one('user',"mail",$mail);
    $user ["discussion"] = [];

    // $filepath= __DIR__ . "/accounts/$mail";
    // if (file_exists($filepath)) {    
    //     $compte = json_decode(file_get_contents($filepath),true);
}
//  return $compte;
}  

function save_moncompte($compte){
    $mail = $_SESSION["mail"];
    save_compte($compte,$mail);
}

function save_compte($compte,$mail){
    $filepath= __DIR__ . "/accounts/$mail";
    file_put_contents($filepath,json_encode( $compte)  );
}

function add_discussion($discussion_id,$mail)
{
    $compte=load_compte($mail);
    array_push($compte["discussions"],$discussion_id);
    save_compte($compte,$mail);
}


function get_discussions()
{
            $moncompte= moncompte();
            $discussions= $moncompte["discussions"];
            $resultats=[];
            foreach( $discussions as $discussion_id)
            {
                if(!file_exists("discussions/$discussion_id")) continue;
              $discussion = json_decode(  file_get_contents("discussions/$discussion_id"),true);
              $discussion["id"]= $discussion_id;
              $blnSave=false;
              $update=[];
             foreach($discussion["messages"]as $message){
             
                if($message['author']==$_SESSION["mail"] && !isset($messages["received"]))
                {
                    $message['received']=date("Y-m-d H:i:s");
                    $blnSave=true;
                }
                array_push($update,$message);
             }
             if($blnSave)
             {
                $discussion["messages"]=$update;
                file_put_contents("discussions/$discussion_id",json_encode($discussion));
             }
              $last_message= $discussion["messages"][ count($discussion["messages"]) -1 ];
              $discussion["last"]=$last_message;
              unset($discussion["messages"]);
              array_push($resultats,$discussion);
                  
            }
            return $resultats;
}
}