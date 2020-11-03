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

        $result = self::find_this_query("SELECT * FROM users WHERE id = $id LIMIT 1");
        return  !empty($result) ? array_shift($result) : false; //check if has result and get first index from array
    }
    // Execute Query and fetch it
    public static function find_this_query($sql) {
        global $database;
        $res = $database->query($sql);
        $rows = $res->fetchAll();
        $obj_array = array();
        foreach ($rows as $row) {
            $obj_array[] = self::istantation($row);
        }
        return  $obj_array;



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




}


?>
