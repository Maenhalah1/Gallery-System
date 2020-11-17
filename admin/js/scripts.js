$(document).ready(function(){
        var href_user;
        var splitted_href_user;
        var user_id;
        var href_image;
        var splitted_href_image;
        var image_name;
        var photo_name;
    $(".modal_thumbnails").click(function(){
        
        href_user = $("#user-id").prop('href');
        splitted_href_user = href_user.split("=");
        user_id = splitted_href_user[splitted_href_user.length - 1];
        console.log(user_id);
        href_image = $(this).prop('src');
        splitted_href_image = href_image.split("/");
        image_name = splitted_href_image[splitted_href_image.length - 1];
        console.log(image_name);
        $("#set_user_image").prop('disabled',false);
        photo_name = $(this).attr("data");
        $.ajax({
            url: "ajax_code.php",
            data:{photo_name:photo_name,user_id:user_id},
            type: "POST",
            success:function(data){
                if(!data.error){
                    $('#modal_sidebar').html(data);
                    
                }
            }
        });
    });
    
    $("#set_user_image").click(function(){

        $.ajax({
            url: "ajax_code.php",
            data:{image_name:image_name, user_id:user_id},
            type: "POST",
            success:function(data){
                if(!data.error){
                    $('.userEdit #profile-img').prop('src',data);
                    
                }
            }

        });
    });

    /*********************** Edit Photo Slide Bar **********************/ 
$(".info-box-header").click(function(){
    $(".inside").slideToggle("fast");
    $("#toggle").toggleClass("glyphicon glyphicon-menu-down , glyphicon glyphicon-menu-up");
});

$(".delete-link").click(function(){

    return confirm("Are You Sure To Deleting ?");

});



    tinymce.init({selector:'.text-editor'});
});

