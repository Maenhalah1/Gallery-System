<?php
class db_object {
    protected static $db_table = "users";
    protected static $db_table_fields = array();
    // get all fields recorders
    public static function get_all_fields()
    {

        $fields = static::find_this_query("SELECT * FROM " . static::$db_table);
        return $fields;
    }

    // Find recorde By his id and get it records
    public static function find_by_ID($id)
    {
        $result = static::find_this_query("SELECT * FROM " .static::$db_table . " WHERE id = ? LIMIT 1", array($id));
        return !empty($result) ? array_shift($result) : false; //check if has result and get first index from array
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
                $obj_array[] = static::istantation($row);
            }
            return $obj_array;
        } else {
            return null;
        }
    }
    //instantation array values to object properties
    private static function istantation($record)
    {
        $class = get_called_class();
        $obj = new $class;
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
        foreach (static::$db_table_fields as $field) {
            if(property_exists($this,$field)) {
                $prop[$field] = $this->$field;
            }
        }
        return $prop;
    }

    public function save(){
        return isset($this->id) ? $this->update() : $this->create();
    }

    // Create a user and insert it into table users in data base
    public function create()
    {
        global $database;
        $properties = $this->properties();
        $bindparam = implode(", :", array_keys($properties));
        $bindparamArr = explode(", ", $bindparam);
        $prop_values = array_values($properties);

        $sql = "INSERT INTO " .  static::$db_table. "(" . implode(", ",array_keys($properties)). ")";
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

    // send updated data  to table in data base
    public function update()
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
        $sql = "UPDATE " .  static::$db_table;
        $sql .= " SET " . implode(", ", $set_array);
        $sql .= " WHERE id= {$this->id}";

        $stmt = $database->query($sql, $values);
        return $stmt->rowCount() ? true : false; // check if has any change
    }
    // delete recorde from table in data base
    public function delete() {
        global $database;
        $sql     = "DELETE FROM " .  static::$db_table;
        $sql    .= " WHERE id = ?";
        $sql    .= " LIMIT 1";
        $stmt = $database->query($sql, array($this->id));
        return $stmt->rowCount() ? true : false;
    }

    public static function count_all_records(){
        global $database;
        $sql = "SELECT COUNT(*) FROM " . static::$db_table;
        $stmt = $database->query($sql);
        $data = $stmt->fetch();
        return (int)array_shift($data);
    }




}


?>