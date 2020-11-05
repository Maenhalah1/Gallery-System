<?php
class users {

    public $id;
    public $username;
    public $password;
    public $email;
    public $first_name;
    public $last_name;

    // get all users recorders
    public static function get_all_users () {
        $users = self::find_this_query("SELECT * FROM users ");
        return $users;
    }
    // Find user By his id and get it records
    public static function find_user_by_ID ($id) {

        $result = self::find_this_query("SELECT * FROM users WHERE id = ? LIMIT 1",array($id));
        return  !empty($result) ? array_shift($result) : false; //check if has result and get first index from array
    }

    // verify username and password that written by user
    public static function verify_user($username,$password) {
        $sql = "SELECT * FROM users WHERE username = ? AND password = ?";
        $founded = self::find_this_query($sql, array($username,$password));
        $founded = !empty($founded) ? array_shift($founded) : false;
        return $founded;

    }

    // Execute Query and fetch it
    public static function find_this_query($sql,$arr=null) {
        global $database;
        $res = $database->query($sql,$arr);
        $rows = $res->fetchAll();
        if(!empty($rows)) {
            $obj_array = array();
            foreach ($rows as $row) {
                $obj_array[] = self::istantation($row);
            }
            return $obj_array;
        } else {
            return null;

        }



    }
    //instantation array values to object properties
    private static function istantation($record) {
        $obj = new self;
        foreach ($record as $property => $value) {
            if ($obj->has_property($property)) { // check if object has name property with the same key name of ass array => $record
                $obj->$property = $value;
            }
        }
        return $obj;
    }
    // check if propety has in class properties
    private function has_property($prop) {
        $property_array = get_object_vars($this);
        return array_key_exists($prop, $property_array);
    }
    // Create a user and insert it into table users in data base
    public function createuser() {
        global $database;
        $sql = "INSERT INTO users(username,password,email,first_name,last_name)";
        $sql .= "VALUES(:uname, :pass, :eml, :fname, :lname)";
        $values = array(
            ':uname'    => $this->username,
            ':pass'     => $this->password,
            ':eml'      => $this->email,
            ':fname'    => $this->first_name,
            ':lname'    => $this->last_name
        );

        $res = $database->query($sql,$values);
        if($res){
            $this->id = $database->last_id();
            return true;
        }else {
            return false;
        }


    }



}


?>
