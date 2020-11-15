$(document).ready(function(){
        var href_user;
        var splitted_href_user;
        var user_id;
        var href_image;
        var splitted_href_image;
        var image_name;
    $(".modal_thumbnails").click(function(){
        
        href_user = $("#user-id").prop('href');
        splitted_href_user = href_user.split("=");
        user_id = splitted_href_user[splitted_href_user.length - 1];

        href_image = $(this).prop('src');
        splitted_href_image = href_image.split("/");
        image_name = splitted_href_image[splitted_href_image.length - 1];
        console.log(image_name);
        $("#set_user_image").prop('disabled',false);
    });
    
    $("#set_user_image").click(function(){

        $.ajax({
            url: "ajax_code.php",
            data:{image_name:image_name, user_id:user_id},
            type: "POST",
            success:function(data){
                if(!data.error){
                    location.reload();
                }
            }

        });
    });



    tinymce.init({selector:'.text-editor'});
});

