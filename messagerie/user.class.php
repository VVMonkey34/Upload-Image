<?php

class user   //nom de la class
{

    protected $pseudo; //attribut de class (les proprietés  de chaque class)
    protected $url;//attribut de class
    protected $mail;//attribut de class
    protected $discussions;

    
    public function __construct($newpseudo, $newurl, $newmail, $newdiscussions){// fonction de construction avec argument
        $this-> pseudo = $newpseudo; 
        $this-> url = $newurl;
        $this-> mail = $newmail;
        $this ->discussions = $newdiscussions;  //rajouter cette attribut(tableau vide ) pour pouvoir stocker les conversations
    }

    public static function load($mail){ //  fonction statique avec une constante
         
    $filepath= __DIR__ . "/accounts/$mail";
    if (file_exists($filepath)) {    
        $compte = json_decode(file_get_contents($filepath),true);
        $user= new User($compte['pseudo'],$compte['url'],$compte['mail'],$compte['discussions']);
    }
    return $user;
    }


    public function add_discussion($discussion_id) {
        array_push($this ->discussions,$discussion_id);
        $this ->save();
    }
    public function compte()
    {
        return [
"pseudo"=> $this -> pseudo,
       'url'=> $this -> ur,
       'mail' => $this -> mail
        ];

    }

    public function save(){ // fonction récupéré du fichier fonction .php  [on  an rajouter $compte avec les attributs]
    
        $filepath= __DIR__ . "/accounts/". $this -> mail;
        $compte = json_decode(file_get_contents($filepath),true);

        $compte['pseudo'] = $this -> pseudo;
        $compte['url'] = $this -> url;
        $compte['mail'] = $this -> mail;
        $compte['discussions'] = $this ->discussions;

        file_put_contents($filepath,json_encode( $compte)  );
        
    }
    
    // public function tojson(){  // fonction tojson (qui n'existait pas dans l'ancien code api.php)
    // return json_encode ();
    // }

}
?>

