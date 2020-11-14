<?php include("includes/header.php"); ?>
<?php 
$number_photo_in_per_page = 4;
$photos_count = photo::count_all_records();
$page = isset($_GET['page']) && !empty($_GET['page']) ? (int) filter_var( $_GET['page'], FILTER_SANITIZE_NUMBER_INT) : 1;
$paginate = new paginate($page, $number_photo_in_per_page, $photos_count);
$sql = "SELECT * FROM photos ";
$sql .= "lIMIT " . $paginate->items_per_page;
$sql .= " OFFSET " . $paginate->offset();
$photos = photo::find_this_query($sql);
if(empty($photos)) {
    Redirect("index.php");
}

?>

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
                <div class='row'>
                    <ul class="pager">
                        <?php if($paginate->total_pages() > 1):?>
                            <?php if($paginate->has_next()):?>  <!-- next link-->
                                <li class="next"><a class='paginate-links' href="index.php?page=<?php echo $paginate->next();?>">Next</a></li>
                            <?php endif;?> <!-- end has_next condition -->

                            <?php for($i=1;$i <= $paginate->total_pages(); $i++):?> <!-- indections link-->
                                <?php if($i == $paginate->current_page):?>
                                    <li><a class='paginate-links indections indection-active' href="index.php?page=<?php echo $i;?>"><?php echo $i;?></a></li>
                                <?php else:?>
                                    <li><a class='paginate-links indections' href="index.php?page=<?php echo $i;?>"><?php echo $i;?></a></li>
                                <?php endif;?>
                             <?php endfor;?>
                            <?php if($paginate->has_previous()):?> <!-- previous link-->
                                <li class="previous"><a class='paginate-links' href="index.php?page=<?php echo $paginate->previous();?>">Previous</a></li>
                            <?php endif;?> <!-- end has_previous condition -->
                        <?php endif;?><!-- end total_pages condition -->
                    </ul>
                </div>
            </div>

            


            <!-- Blog Sidebar Widgets Column -->
            <!-- <div class="col-md-4"> -->

            
                 <?php //include("includes/sidebar.php"); ?>



            <!-- </div> -->
        <!-- /.row -->

        <?php include("includes/footer.php"); ?>
