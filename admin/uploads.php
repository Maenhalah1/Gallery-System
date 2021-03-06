<?php include("includes/header.php"); ?>
<?php if(!$session->get_signed_in()) { Redirect("login.php");}?>
<?php
    if(isset($_FILES['file'])) {

        $photo = new photo();
        $photo->title = $_POST['title'];
        $photo->set_file($_FILES['file']);
        $photo->user_id = $session->user_id;

        if($photo->save()){
            $session->message("<p class='alert alert-success edit-alert'>The Photo {$photo->title} has Been Uploaded Successfully</p>");
            Redirect("uploads.php");
        }else{
            $message = join("<br>", $photo->error);
        }
    }

?>

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
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            UPLOADS
                        </h1>
                        <?php echo $message;?>
                        <div class="row">
                            <div class="col-md-6">
                                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">

                                        <div class="form-group">
                                            <input type="text" name="title" placeholder="Title" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <input type="file" name="file" >
                                        </div>
                                        <input type="submit" value="Upload" class="btn btn-primary" name="submit">
                                </form>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" class='dropzone'>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        

        </div>

  <?php include("includes/footer.php"); ?>