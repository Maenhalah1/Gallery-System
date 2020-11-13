<?php require_once("includes/init.php"); ?>
<?php 
if(empty($_GET['id']) || !isset($_GET['id'])) {
    Redirect("index.php");
    exit();
}
$_GET['id'] = filter_var($_GET['id'], FILTER_SANITIZE_STRING);
$_GET['id'] = (int)$_GET['id'];
$photo = photo::find_by_ID($_GET['id']);
if(!$photo) {
    Redirect("index.php");
    exit();
}

if(isset($_POST['submit'])) {
    $author = trim(filter_var($_POST['author'] ,FILTER_SANITIZE_STRING));
    $body   = filter_var($_POST['body'] ,FILTER_SANITIZE_STRING);
    $new_comment = comment::create_comment($photo->id,$author,$body);
    if($new_comment) {
        $new_comment->save();
        Redirect("photo.php?id={$photo->id}");
    }else{
        $message= "You have some problems saving";
    }

}else{
    $author="";
    $body="";
    $message="";
}

$all_comments = comment::find_comments_by_photo_id($photo->id);

?>

<?php require_once("includes/header.php")?>

    <!-- Navigation -->
    <?php require_once("includes" . DS . "navigation.php")?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Post Content Column -->
            <div class="col-lg-12">

                <!-- Blog Post -->

                <!-- Title -->
                <h1><?php echo $photo->title ?></h1>

                <!-- Author -->
                <p class="lead">
                    by <a href="#">Admin</a>
                </p>

                <hr>

                <!-- Date/Time -->
                <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo Date("F d Y g:i A " ,strtotime($photo->upload_date))?></p>

                <hr>

                <!-- Preview Image -->
                <img class="img-responsive main-photo" src="<?php echo "admin" . DS . $photo->picture_path();?>" alt="">

                <hr>

                <!-- Post Content -->
                <p class="lead"><?php ?></p>
                
                <hr>

                <!-- Blog Comments -->

                <!-- Comments Form -->
                <div class="well">
                    <h4>Write a Comment:</h4>
                    <form role="form" method="post" action="photo.php?id=<?php echo $photo->id;?>">
                        <div class="form-group">
                            <label for="author">Author</label>
                            <input type="text" name="author" class="form-control">
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" name="body" rows="3"></textarea>
                        </div>
                        <button type="submit" name="submit" class="btn btn-primary">Send</button>
                    </form>
                </div>

                <hr>

                <!-- Posted Comments -->

                <!-- Comment -->
                <?php if(!empty($all_comments)):?>
                    <?php foreach($all_comments as $comment):?>
                        <div class="media">
                            <a class="pull-left" href="#">
                                <img class="media-object" src="http://placehold.it/64x64" alt="">
                            </a>
                            <div class="media-body">
                                <h4 class="media-heading"><?php echo $comment->author;?>
                                    <small><?php echo Date("F d Y g:i A " ,strtotime($comment->added_date))?></small>
                                </h4>
                                <?php echo $comment->body;?>
                            </div>
                        </div>
                    <?php endforeach;?>
                <?php endif;?>

                <!-- Comment -->
               

            </div>

            <!-- Blog Sidebar Widgets Column -->
            <!-- <div class="col-md-4"> -->

                <?php //require_once("includes" . DS . "sidebar.php")?>
                

            <!-- </div> -->

        </div>
    </div>
        <!-- /.row -->
<?php require_once("includes/footer.php")?>
