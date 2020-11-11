<?php
class users extends db_object
{
    protected static $db_table = "users";
    protected static $db_table_fields = array("username", "password","email", "first_name", "last_name","user_image");
    public $id;
    public $username;
    public $password;
    public $email;
    public $first_name;
    public $last_name;
    public $user_image;
    public $image_path = "users_images";
    public $tmp_path;
    public $default_image = "users_images" . DS . "default.jpg";

    public $error_image = array();
    public $upload_errors_array = array(
        UPLOAD_ERR_OK           => "there is no error",
        UPLOAD_ERR_INI_SIZE     => "the upload file exceeds the upload_max_filesize",
        UPLOAD_ERR_FORM_SIZE    =>"the upload file exceeds the MAX_FILE_SIZE",
        UPLOAD_ERR_PARTIAL      => "the file only partial",
        UPLOAD_ERR_NO_FILE      => "no file uploaded",
        UPLOAD_ERR_NO_TMP_DIR   => "missing tmp directory",
        UPLOAD_ERR_CANT_WRITE   => "fiald to write file",
        UPLOAD_ERR_EXTENSION    => "php extension stop the file"
    );

    //get source image
    public function get_image(){
        if($this->username && $this->id){
            return empty($this->user_image) ? $this->default_image : $this->image_path . DS . $this->username . DS . $this->user_image;
        }
    }


    // verify username and password that written by user
    public static function verify_user($username, $password)
    {
        $sql = "SELECT * FROM users WHERE username = ? AND password = ?";
        $founded = self::find_this_query($sql, array($username, $password));
        $founded = !empty($founded) ? array_shift($founded) : false;
        return $founded;

    }


    //set file image
    public function set_file($file){
        if(empty($file) || !$file || !is_array($file)) {
                $this->error[] = "Not Founded File";
                return false;

        }else if($file['error'] != 0) {
            $this->error[] = $this->upload_errors_array[$file['error']];
            return false;
        }else {
            $this->user_image = basename($file['name']);
            $this->tmp_path = $file['tmp_name'];
            return true;
        }
    }

    public function save_data_and_image() {
        
            if (!empty($this->error)) {
                return false;
            } else if (empty($this->user_image) || empty($this->tmp_path)) {
                $this->error[] = "the file was not available";
                return false;
            } else {
                
               if(!is_dir($this->image_path . DS . $this->username)) {
                  mkdir($this->image_path . DS . $this->username); 
               }
               $path = $this->image_path . DS . $this->username;
               $target_path = SITE_PATH . DS . 'admin' . DS . $path . DS .$this->user_image;
                if(move_uploaded_file($this->tmp_path, $target_path)) {
                    if($this->id) {
                        if($this->update()) {
                            unset($this->tmp_path);
                            return true;
                        }
                    }else {
                        if($this->create()) {
                            unset($this->tmp_path);
                            return true;
                        }
                    }
                    
                } else {
                    $this->error[] = "the file dirctory probably does not premission";
                    return false;
                }
            }
        
    }





}
?>
