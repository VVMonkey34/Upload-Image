<?php
require "credentials.php";


class Db
{
    public $host;
    public $dbname;
    public $username;
    public $password;
    public $dbco;

/*****************************
 * Singleton
 * Db : $db
 * Db::singleton()
 */

    public static $db;
    
    public static function singleton(){

        if(!self::$db){
            global $host, $username, $password, $dbname;
            //Si elle n'existe pas on créer Db et connexion
            self::$db= new Db();
            self::$db->connect(HOST_NAME, NAME, PASSWORD, BDD);
        }

        return self::$db;
    }



    public function connect($set_host, $set_username, $set_password, $set_database)
    {
        $this->host = $set_host;
        $this->username = $set_username;
        $this->password = $set_password;
        $this->dbname = $set_database;
        try {
            $this->dbco = new PDO("mysql:host=$this->host;dbname=$this->dbname;charset=utf8", "$this->username", "$this->password");
            $this->dbco->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
    }



    public function create($table, $fields = array(), $values = array())
    {
        try {

            $str_fields = implode(",", $fields);

            $tableau_values = [];

            foreach ($fields as $field) {

                array_push($tableau_values, ":" . $field);
            }

            $str_fields2 = implode(",", $tableau_values);

            $keys_values = array_combine($tableau_values, $values);

            $prep = $this->dbco->prepare("
                                        INSERT INTO
                                        $table($str_fields)
                                            VALUES ( $str_fields2)
                                        ");

            $prep->execute($keys_values);
            print_r($prep);
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
    }


    public function select_one($table, $field, $id)
    {
        try {
            $sth = $this->dbco->prepare("SELECT * FROM  $table WHERE $field = '$id'");
            
            $sth->execute();
            $resultat = $sth->fetchAll(PDO::FETCH_ASSOC);
            
            return $resultat[0];
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
    }


    public function select_all($table, $field, $value)
    {
        try {
            $sth = $this->dbco->prepare("SELECT * FROM  $table WHERE $field = $value");
            $sth->execute();
            $resultat = $sth->fetchAll(PDO::FETCH_ASSOC);

            return $resultat;
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
    }



    public function delete($table, $field, $id)
    {
        //delete('users', 'pseudo', 'test');
        try {
            $sql = "DELETE FROM  $table WHERE $field ='$id'";
            
            $sth = $this->dbco->prepare($sql);

            var_dump($sth);
            $sth->execute();
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
    }

    public function update($table, $fields = array(), $values = array(), $id, $field_id)
    {
        $updates = [];
        foreach ($fields as $i => $field) {

        array_push ($updates, $field ."="."'".$values[$i]."'");
    }

    $sql = "UPDATE $table SET ".implode(",",$updates)." WHERE $field_id = '$id' ";

    echo "<pre>";
    print_r($sql);
    echo "</pre>";

    $sth = $this->dbco->prepare($sql);
    $sth->execute();
    }



    public function select_sql($sql)
{
    try {
        $sth = $this->dbco->prepare($sql);
        $sth->execute();
        $resultat = $sth->fetchAll(PDO::FETCH_ASSOC);
        

       
        return $resultat;
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}

}