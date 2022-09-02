<?php

class Message
{
public $discussion_id;
public $received;
public $send;
public $read;
public $author;
public $msg;

public function __construct( $newdiscussion_id,$newauthor,$newmsg,$newsend,$newreceived, $newread, ){
   $this->discussion_id=$newdiscussion_id;
    $this-> received = $newreceived; 
    $this-> send = $newsend;
    $this-> read = $newread; 
    $this-> author = $newauthor;
    $this-> msg = $newmsg;
}
public function getConversation()
{
    return Conversation::load($this->discussion_id);
}
    // public function tojson(){
    // return json_encode ();
    // }
}
?>