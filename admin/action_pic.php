
<?php
if(empty($_GET['do']) || empty($_GET['id']) || !isset($_GET['do']) || !isset($_GET['id'])): //check if get do or id is empty
    
    Redirect("photos.php");
    die();

?>

<?php
 elseif($_GET['do'] == 'delete'):  //if do is delete ?>

 <?php include("includes/init.php"); ?>
 <?php if(!$session->get_signed_in()) { Redirect("login.php");}?>

<?php
        $_GET['id'] = filter_var($_GET['id'], FILTER_SANITIZE_STRING);
        if(is_numeric($_GET['id'])) {
            $photo = photo::find_by_ID($_GET['id']);
            if($photo) {
                $photo->delete_photo();
                Redirect("photos.php");
            }else{
                Redirect("photos.php");
            }
        }else{
            Redirect("photos.php");
        }
?>

<?php elseif($_GET['do'] == 'edit'): // if do is edit?>

    <?php include("includes/header.php"); ?>
<?php if(!$session->get_signed_in()) { Redirect("login.php");}?>
<?php 
        $_GET['id'] = filter_var($_GET['id'], FILTER_SANITIZE_STRING);
        $photo = photo::find_by_ID($_GET['id']);
        if(empty($photo) || !$photo) {
            Redirect("photos.php");
            die();
        }
        
        ?>
    <?php if(isset($_POST['update'])) {

        if($photo) {
            $photo->title = $_POST['title'];
            $photo->caption = $_POST['caption'];
            $photo->alternate_text = $_POST['alter-text'];
            $photo->description = $_POST['description'];
            $photo->save();
           
        }

    }?>
        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <?php include "includes/top_nav.php"; ?>
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
           <?php include "includes/left_nav.php"; ?>
            <!-- /.navbar-collapse -->
        </nav>

        <div id="page-wrapper">

            
            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-10">
                        <h1 class="page-header">
                            Photos
                            <small>Subheading</small>
                        </h1>
                        <form action="<?php echo "action_pic.php?do=edit&id=5"?>" method="post">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <input type="text" name='title' placeholder='Title' class="form-control" value="<?php echo $photo->title; ?>">
                                </div>     
                                <div class="form-group">
                                        <label for="caption">Caption</label>
                                    <input type="text" name='caption' class="form-control" value="<?php echo $photo->caption; ?>" >
                                </div>
                                <div class="form-group">
                                        <label for="caption">alternate Text</label>
                                    <input type="text" name='alter-text' class="form-control" value="<?php echo $photo->alternate_text; ?>" >
                                </div>
                                
                                <div class="form-group">
                                        <label for="caption">Description</label>
                                    <textarea class="form-control" name='description' rows="10" cols="30"><?php echo $photo->description; ?></textarea>
                                </div>
                            </div>
                            <div class="col-md-4" >
                                <div  class="photo-info-box">
                                    <div class="info-box-header">
                                        <h4>Save <span id="toggle" class="glyphicon glyphicon-menu-up pull-right"></span></h4>
                                    </div>
                                    <div class="inside">
                                        <div class="box-inner">
                                        <p class="text">
                                        <span class="glyphicon glyphicon-calendar"></span> Uploaded on: April 22, 2030 @ 5:26
                                        </p>
                                        <p class="text ">
                                            Photo Id: <span class="data photo_id_box">34</span>
                                        </p>
                                        <p class="text">
                                            Filename: <span class="data">image.jpg</span>
                                        </p>
                                        <p class="text">
                                        File Type: <span class="data">JPG</span>
                                        </p>
                                        <p class="text">
                                        File Size: <span class="data">3245345</span>
                                        </p>
                                        </div>
                                        <div class="info-box-footer clearfix">
                                            <div class="info-box-delete pull-left">
                                                <a  href="action_pic.php?do=delete&id=<?php echo $photo->id; ?>" class="btn btn-danger btn-lg ">Delete</a>   
                                            </div>
                                            <div class="info-box-update pull-right ">
                                                <input type="submit" name="update" value="Update" class="btn btn-primary btn-lg ">
                                            </div>   
                                        </div>
                                    </div>          
                                </div>
                            </div>   
                        </form>
                    </div>
                </div>
            </div>
        </div>

  <?php include("includes/footer.php"); ?>



       
<?php endif; ?>