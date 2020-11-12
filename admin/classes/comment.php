<?php
class comment extends db_object
{
    protected static $db_table = "comments";
    protected static $db_table_fields = array("id", "photo_id","author", "body","added_date");
    public $id;
    public $photo_id;
    public $author;
    public $body;
    public $added_date;
    
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

    // create new comment
    public static function create_comment ($photoid="", $author="", $body=""){

        if( !empty($photoid) && !empty($author) && !empty($body)) {
            $comment = new comment();
            $comment->photo_id = (int)$photoid;
            $comment->author = $author;
            $comment->body = $body;
            $comment->added_date = Date("Y-m-d H-i-s",time());
            return $comment;
        }else{
            return false;
        }
    }

    public static function find_comments_by_photo_id($photoid=0) {

        $sql = "SELECT * FROM " . self::$db_table;
        $sql .= " WHERE photo_id = ?";
        $sql .= " ORDER BY added_date DESC";

        return self::find_this_query($sql,array((int)$photoid));
    }


}
?>
