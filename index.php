<?php include("includes/header.php"); ?>

<?php $photos = photo::get_all_fields();?>
        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-12">
                <div class="thumbnails row">
                    <?php foreach($photos as $photo): ?>
                        
                            <div class="col-xs-6 col-md-3">
                                <a class="thumbnail showing-box-pic" href="photo.php?id=<?php echo $photo->id?>">
                                        <img class="showing-pic" src="<?php echo "admin" . DS . $photo->picture_path();?>" alt="">
                                </a>
                            </div>
                        
                    
                
                    <?php endforeach; ?>
                </div>
            </div>




            <!-- Blog Sidebar Widgets Column -->
            <!-- <div class="col-md-4"> -->

            
                 <?php //include("includes/sidebar.php"); ?>



            <!-- </div> -->
        <!-- /.row -->

        <?php include("includes/footer.php"); ?>
