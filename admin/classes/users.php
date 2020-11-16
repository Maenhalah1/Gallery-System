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

// get all images the user uploaded 
    public function get_all_image_uploaded(){
        if($this->username && $this->id){
            if(file_exists($this->image_path . DS . $this->username)){
                $images = scandir($this->image_path . DS . $this->username);
                if(!empty($images)){
                    $images = array_diff($images,array('.','..'));
                    $allowed_ex = array("jpg","jpeg","png"); 
                    foreach($images as $image){
                        $exArr = explode('.',$image);
                        $ex = end($exArr);
                        $ex = strtolower($ex);
                        if(!in_array($ex,$allowed_ex)){
                            $images = array_diff($images,array($image));
                        }
                    }
                    sort($images);
                    return $images;
                }else{
                    return false;
                }
            }
        }else{
            return false;
        }
    }

    public function get_path_pic($img){
        if(file_exists($this->image_path . DS . $this->username . DS . $img)){
            return $this->image_path . DS . $this->username . DS . $img;
        }else{
            return false;
        }
    }


    // get size any images from the specifed user file
    public function get_size_image($img){
        if ($this->get_path_pic($img)){
            return filesize($this->get_path_pic($img)); 
        }else{
            return false;
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

    public function ajax_save_user_image($id,$image){
        if($id == $this->id){
            global $database;
            $this->user_image = $image;
            $sql = "UPDATE " . self::$db_table . " SET user_image = :image WHERE id = :id";
            $database->query($sql,array(":image" => $this->user_image , ":id" => $this->id));
            return $this->get_image();
        }else{
            return false;
        }

    }

    public function get_info_image_user_for_sidbar($userid, $photoname){
        $user = users::find_by_ID($userid);
        $fullname =$user->first_name . " " . $user->last_name;
        $output = "<a class='thumbnail'><img width='100' src='" . $user->get_path_pic($photoname) . "'></a>";
        $output .= "<p>Uploaded By {$fullname}</p>";
        $output .= "<p>{$photoname}</p>";
        $size = (int)$user->get_size_image($photoname);
        if($size > 1000000) {
            $t = "MB";
            $size = number_format($size  * 0.000001, 1) ;
        }else {
            $t = "KB";
            $size = number_format($size  * 0.001, 1);
        }
        $output .= "<p>{$size} $t</p>";
        return $output;
    }

    // delete user with directory
    public function delete_with_dir() {
        if(!empty($this->username && $this->id)) {
            if($this->delete()) {
                $target = SITE_PATH . DS . 'admin' . DS . $this->image_path . DS . $this->username;
                if(is_dir($target)){
                    $this->delete_files_in_dir($target);
                    return rmdir($target) ? true : false;
                    echo "yes";
                }
            }else{
                return true;
            }
        }else{
            return false;
        }
    }

    //Delete all files in directory
    private function delete_files_in_dir($dir){
        if(is_dir($dir)){
            $dir .= DS;
            $dirfiles = glob($dir ."*",GLOB_MARK);
            if(empty($dirfiles)){
                return;
            }else{
                foreach($dirfiles as $file){
                    if(is_dir($file)){
                        $this->delete_files_in_dir($file);
                    }else{
                        unlink($file);
                    }
                    
                }
            }
        }
    }





}
?>
