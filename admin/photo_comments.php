<?php include("includes/header.php"); ?>
<?php if(!$session->get_signed_in()) { Redirect("login.php");}?>
<?php if(!isset($_GET['id']) || empty($_GET['id'])) { Redirect("photos.php");}?>
<?php
$_GET['id'] = filter_var($_GET['id'], FILTER_SANITIZE_STRING);
$comments = comment::find_comments_by_photo_id($_GET['id']);
if(!empty($comments)):
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
                            COMMENTS
                        </h1>
                        <div class="col-md-12">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Author</th>
                                    <th>Body</th>
                                    <th>Added comment date</th>                                 
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($comments as $comment):?>
                                <tr>
                                    <td><?php echo $comment->id; ?>
                                        <div class='action_links'>
                                            <a href="action_comment.php?do=delete&id=<?php echo $comment->id;?>">Delete</a>
                                        </div>
                                    </td>

                                    
                                    <td><?php echo $comment->author; ?></td>
                                    <td><?php echo $comment->body; ?></td>
                                    <td><?php echo $comment->added_date; ?></td>
                                </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        

        </div>

    <?php else: Redirect("photos.php"); endif;?>    
<?php include("includes/footer.php"); ?>
 