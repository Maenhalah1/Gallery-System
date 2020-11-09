<?php
class photo extends db_object {

    protected static $db_table = "photos";
    protected static $db_table_fields = array("id", "title","description", "type", "filename", "size");
    public $id;
    public $title;
    public $description;
    public $type;
    public $filename;
    public $size;
    public $tmp_path;
    public $upload_dir = 'images';
    public $error = array();
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
    public function set_file($file){
        if(empty($file) || !$file || !is_array($file)) {
                $this->error[] = "Not Founded File";
                return false;

        }else if($file['error'] != 0) {
            $this->error[] = $this->upload_errors_array[$file['error']];
            return false;
        }else {
            $this->filename = basename($file['name']);
            $this->size = $file['size'];
            $this->tmp_path = $file['tmp_name'];
            $this->type = $file['type'];
            return true;
        }
    }

    public function save() {
        if($this->id) {
            echo "create";
            $this->update();
            return true;
        } else {
            if (!empty($this->error)) {

                return false;
            } else if (empty($this->filename) || empty($this->tmp_path)) {
                $this->error[] = "the file was not available";
                return false;
            } else {

                echo "create";
                $target_path = SITE_PATH . DS . 'admin' . DS . $this->upload_dir . DS .$this->filename;
                if(move_uploaded_file($this->tmp_path, $target_path)) {

                    if($this->create()) {
                        unset($this->tmp_path);
                        return true;
                    }
                } else {
                    $this->error[] = "the file dirctory probably does not premission";
                    return false;
                }
            }
        }
    }
    public function picture_path(){
        if(isset($this->filename)) {
            return $this->upload_dir . DS . $this->filename;
        }else{
            return false;
        }
    }

}
?>


