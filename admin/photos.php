<?php include("includes/header.php"); ?>
<?php if(!$session->get_signed_in()) { Redirect("login.php");}?>
<?php
$photos = photo::get_all_fields();
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
                            PHOTOS
                        </h1>
                        <?php echo $message;?>
                        <div class="col-md-12">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>Photo</th>
                                    <th>ID</th>
                                    <th>File name</th>
                                    <th>Title</th>
                                    <th>Size</th>
                                    <th>Comments</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($photos as $photo):?>
                                <tr>
                                    <td><img class='img-gallery'src="<?php echo $photo->picture_path(); ?>" alt="image">
                                    <div>
                                        <a href="action_pic.php?do=delete&id=<?php echo $photo->id;?>">Delete</a>
                                        <a href="action_pic.php?do=edit&id=<?php echo $photo->id;?>"">Edit</a>
                                        <a href="../photo.php?id=<?php echo $photo->id; ?>">View</a>
                                    </div>
                                    </td>
                                    
                                    <td><?php echo $photo->id; ?></td>
                                    <td><?php echo $photo->filename; ?></td>
                                    <td><?php echo $photo->title; ?></td>
                                    <td><?php echo $photo->size; ?></td>
                                    <td>
                                        <?php
                                         $comments=comment::find_comments_by_photo_id($photo->id);
                                         $number_of_comment = count(is_countable($comments) ? $comments : []);
                                         if($number_of_comment > 0) {
                                             echo "<a href='photo_comments.php?id=" . $photo->id . "'>" . $number_of_comment . " comments" . "</a>";
                                         }else{
                                             echo htmlentities($number_of_comment . " comments");
                                         }
                                        ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                            
                            

                    </div>
                </div>
            </div>
        

        </div>

  <?php include("includes/footer.php"); ?>