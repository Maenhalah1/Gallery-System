<?php
if(empty($_GET['do'])  || !isset($_GET['do'])): //check if get do or id is empty
    
    Redirect("comments.php");
    die();

?>

<?php elseif($_GET['do'] == 'delete'):  //if do is delete ?>

 <?php include("includes/init.php"); ?>
 <?php if(!$session->get_signed_in()) { Redirect("login.php");}?>

<?php
        if(empty($_GET['id']) || !isset($_GET['id'])) {
            Redirect("comments.php");
            die();
        }
        $_GET['id'] = filter_var($_GET['id'], FILTER_SANITIZE_STRING);
        if(is_numeric($_GET['id'])) {
            $comment = comment::find_by_ID($_GET['id']);
            if($comment) {
                $comment->delete();
                Redirect("comments.php");
                
            }else{
                Redirect("comments.php");
            }
        }else{
            Redirect("comments.php");
        }
?>
<?php 
endif;
?>