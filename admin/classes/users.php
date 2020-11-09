<?php
class users extends db_object
{
    protected static $db_table = "users";
    protected static $db_table_fields = array("username", "password","email", "first_name", "last_name");
    public $id;
    public $username;
    public $password;
    public $email;
    public $first_name;
    public $last_name;

    // verify username and password that written by user
    public static function verify_user($username, $password)
    {
        $sql = "SELECT * FROM users WHERE username = ? AND password = ?";
        $founded = self::find_this_query($sql, array($username, $password));
        $founded = !empty($founded) ? array_shift($founded) : false;
        return $founded;

    }



}
?>
