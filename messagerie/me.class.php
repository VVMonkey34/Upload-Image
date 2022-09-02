<?php


$db = Db::singleton();

class Me extends User
{

    protected $pass;

    public function __construct($newpseudo, $newurl, $newmail,$newpass,$newdiscussions){
        parent::__construct($newpseudo, $newurl, $newmail, $newdiscussions);
        $this-> pass = $newpass;
    }


    public function get_contacts(){// fonction dèja crée dans le api.php (ancien code) on utilise chaque fonction(ou bien applé méthode)dans la class correspondante
    
        $contacts=[];
        $comptes = Db::singleton() ->select_sql("
        SELECT * FROM user 
        WHERE mail<>'". $this->mail."'");


        foreach( $comptes  as $compte  )
        {
        if(!$compte['pseudo'] || !$compte['user_img']) continue;
        
        unset($compte['password']);
        array_push($contacts,$compte);
        
        } 

        return $contacts;

    }

    
    public function get_discussions(){

          $db = Db::singleton();
          $sql="SELECT participant.discussion_id FROM user
          INNER JOIN participant ON (user.user_id = participant.user_id)
          WHERE user.mail = '$this->mail'";

          $discussions = $db->select_sql($sql);
          $resultats=[];
            foreach( $discussions as $discussion_row)
            {   
                $discussion_id = discussion_row["discussion_id"];
                $sql_participants="SELECT user.* FROM participants
                INNER JOIN user ON (user.user_id = participant.user_id)
                WHERE participants.discussion_id='$discussion_id'";
                $participants = $db -> select_sql($sql_participants);
                

                $sql="SELECT * FROM message
                WHERE discussion_id='$discussion_id'
                ORDER BY send_date DESC
                LIMIT 1";
                $result_lastmessages = $db->select_sql($sql);
                

                if(count($result_lastmessages ) > 0){

                    $message = $result_lastmessages[0];
                    array_push($resultats,
                    [
                        "id"=> $discussion_id,
                        "participants"=>$participants,
                        "last" => $message

                    ]);
                }     
            }
            return $resultats;
    }




    public function send_message($msg,$to,$discussion_id){
        date_default_timezone_set('Europe/Paris');
    $date = new DateTime();
    
    if($to)
    {
        //Nouvelle discussion
        $discussion = Conversation::create($to);
    }
    else if($discussion_id)
    {
        $discussion = Conversation ::load($discussion_id);
    }
    //
    $message = new Message($discussion_id,$msg, $this -> mail,date("Y-m-d H:i:s"),null,null );
    $discussion -> add_message($message);
    $discussion ->save();

    return  $message;
    }

    
    // public function tojson(){
    // return json_encode ();
    // }




    public static function loadme(){ //  fonction statique avec une constante
        
        $compte = Db::singleton()->select_one("user","mail",$_SESSION["mail"]);
        $compte ["discussions"]=[];
        return   new Me($compte['pseudo'],
            $compte['user_img'],
            $compte['mail'],
            $compte['password'],
            $compte['discussions']);
    }
       
   

        public function save(){
    
            $filepath= __DIR__ . "/accounts/". $this -> mail;
            $compte = json_decode(file_get_contents($filepath),true);
    
            $compte['pseudo'] = $this -> pseudo;
            $compte['url'] = $this -> url;
            $compte['mail'] = $this -> mail;
            $compte['pwd'] = $this -> pass;
    
            file_put_contents($filepath,json_encode( $compte)  );
            
    
        }
        
    
}


?>