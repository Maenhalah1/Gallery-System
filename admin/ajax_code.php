<?php 

require_once("includes/init.php");

if(isset($_POST['image_name']) && isset($_POST['user_id'])){
    $user = users::find_by_ID($_POST['user_id']);
    echo $user->ajax_save_user_image($_POST['user_id'],$_POST['image_name']); 
}
if(isset($_POST['photo_name']) && isset($_POST['user_id'])){
    echo users::get_info_image_user_for_sidbar($_POST['user_id'], $_POST['photo_name']);
}
?>