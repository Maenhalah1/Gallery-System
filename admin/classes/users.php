<?php
class users
{
    protected static $db_table = "users";
    protected static $db_table_fields = array("username", "password","email", "first_name", "last_name");
    public $id;
    public $username;
    public $password;
    public $email;
    public $first_name;
    public $last_name;

    // get all users recorders
    public static function get_all_users()
    {
        $users = self::find_this_query("SELECT * FROM users ");
        return $users;
    }

    // Find user By his id and get it records
    public static function find_user_by_ID($id)
    {

        $result = self::find_this_query("SELECT * FROM users WHERE id = ? LIMIT 1", array($id));
        return !empty($result) ? array_shift($result) : false; //check if has result and get first index from array
    }

    // verify username and password that written by user
    public static function verify_user($username, $password)
    {
        $sql = "SELECT * FROM users WHERE username = ? AND password = ?";
        $founded = self::find_this_query($sql, array($username, $password));
        $founded = !empty($founded) ? array_shift($founded) : false;
        return $founded;

    }

    // Execute Query and fetch it
    public static function find_this_query($sql, $arr = null)
    {
        global $database;
        $res = $database->query($sql, $arr);
        $rows = $res->fetchAll();
        if (!empty($rows)) {
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
    private static function istantation($record)
    {
        $obj = new self;
        foreach ($record as $property => $value) {
            if ($obj->has_property($property)) { // check if object has name property with the same key name of ass array => $record
                $obj->$property = $value;
            }
        }
        return $obj;
    }

    // check if propety has in class properties
    private function has_property($prop)
    {
        $property_array = get_object_vars($this);
        return array_key_exists($prop, $property_array);
    }
    protected function properties(){
        $prop = array();
        foreach (self::$db_table_fields as $field) {
            if(property_exists($this,$field)) {
                $prop[$field] = $this->$field;
            }
        }
        return $prop;
    }

    public function save(){
        return isset($this->id) ? $this->update_user() : $this->create_user();
    }

    // Create a user and insert it into table users in data base
    public function create_user()
    {
        global $database;
        $properties = $this->properties();
        $bindparam = implode(", :", array_keys($properties));
        $bindparamArr = explode(", ", $bindparam);
        $prop_values = array_values($properties);

        $sql = "INSERT INTO " .  self::$db_table. "(" . implode(", ",array_keys($properties)). ")";
        $sql .= "VALUES(:" . $bindparam  . " )";
        $values = array();
        for($i = 0; $i < count($prop_values);$i++) {
            $values[$bindparamArr[$i]] = $prop_values[$i];
        }

        $res = $database->query($sql, $values);
        if ($res) {
            $this->id = $database->last_id();
            return true;
        } else {
            return false;
        }
    }

    // send updated data user to user table in data base
    public function update_user()
    {
        global $database;
        $properties = $this->properties();
        $set_array = array();
        $values = array();
        foreach ($properties as $property_key => $property_value) {
            $bindparam = ":" . $property_key;
            $set_array[] = $property_key . " = " . $bindparam;
            $values[$bindparam] = $property_value;

        }
        $sql = "UPDATE " .  self::$db_table;
        $sql .= " SET " . implode(", ", $set_array);
        $sql .= " WHERE id= {$this->id}";

        $stmt = $database->query($sql, $values);
        return $stmt->rowCount() ? true : false; // check if has any change
    }
    public function delete_user() {
        global $database;
        $sql     = "DELETE FROM " .  self::$db_table;
        $sql    .= " WHERE id = ?";
        $sql    .= " LIMIT 1";
        $stmt = $database->query($sql, array($this->id));
        return $stmt->rowCount() ? true : false;
    }

}
?>
