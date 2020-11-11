
<?php
if(empty($_GET['do'])  || !isset($_GET['do'])): //check if get do or id is empty
    
    Redirect("users.php");
    die();

?>

<?php elseif($_GET['do'] == 'delete'):  //if do is delete ?>

 <?php include("includes/init.php"); ?>
 <?php if(!$session->get_signed_in()) { Redirect("login.php");}?>

<?php
        if(empty($_GET['id']) || !isset($_GET['id'])) {
            Redirect("users.php");
            die();
        }
        $_GET['id'] = filter_var($_GET['id'], FILTER_SANITIZE_STRING);
        if(is_numeric($_GET['id'])) {
            $user = users::find_by_ID($_GET['id']);
            if($user) {
                $user->delete();
                Redirect("users.php");
            }else{
                Redirect("users.php");
            }
        }else{
            Redirect("users.php");
        }
?>

<?php  elseif($_GET['do'] == 'add'): // if do is add?>

    <?php include("includes/header.php"); ?>
<?php if(!$session->get_signed_in()) { Redirect("login.php");}?>

    <?php if(isset($_POST['create'])) {
        $user = new users();

            $user->username = $_POST['username'];
            $user->email = $_POST['email'];
            $user->last_name = $_POST['last_name'];
            $user->first_name = $_POST['first_name'];
            $user->password = $_POST['password'];
            $user->user_image = !empty($_FILES['user_image']) ? $_FILES['user_image'] : "";
            if($user->user_image['error'] != 0) {
                $user->user_image= null;
                $user->save();
                Redirect("users.php");
            }else{
                $user->set_file($user->user_image);
                $user->save_data_and_image();
                Redirect("users.php");
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
                    <div class="col-lg-12">
                        <h1 class="page-header">USERS</h1>
                        <form action="<?php echo "action_user.php?do=add"?>" method="post" enctype="multipart/form-data">
                            <div class="col-md-6 col-md-offset-3">
                            <div class="form-group">
                                        <label for="username">User Image</label>
                                    <input type="file" name='user_image'>
                                </div> 
                                <div class="form-group">
                                        <label for="username">User name</label>
                                    <input type="text" name='username' class="form-control">
                                </div> 
                                <div class="form-group">
                                        <label for="email">Email</label>
                                    <input type="text" name='email' class="form-control" >
                                </div>
                                <div class="form-group">
                                        <label for="first_name">First name</label>
                                    <input type="text" name='first_name' class="form-control" >
                                </div>
                                
                                <div class="form-group">
                                        <label for="last_name">Last name</label>
                                    <input type="text" name='last_name'  class="form-control" >
                                </div>
                                <div class="form-group">
                                        <label for="password">Password</label>
                                    <input type="text" name='password'  class="form-control" >
                                </div>
                                <div class="form-group">
                                    <input type="submit" name='create'  value="Create User" class="form-control btn btn-primary submit-button" >
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        

  <?php include("includes/footer.php"); ?>

  <?php  elseif($_GET['do'] == 'edit'): // if do is edit?>
    <?php include("includes/header.php"); ?>
    <?php if(!$session->get_signed_in()) { Redirect("login.php");}?>
    <?php 
        $_GET['id'] = filter_var($_GET['id'], FILTER_SANITIZE_STRING);
        $user = users::find_by_ID($_GET['id']);
        if(empty($user) || !$user) {
            Redirect("users.php");
            die();
        }
        
        ?>
  <?php if(isset($_POST['update'])) {

            $user->username = $_POST['username'];
            $user->email = $_POST['email'];
            $user->last_name = $_POST['last_name'];
            $user->first_name = $_POST['first_name'];
            $user->password = empty($_POST['password']) ? $user->password : $_POST['password'];
            if($_FILES['user_image']['error'] != 0) {
                $user->save();
                Redirect("users.php");
            }else{
                $user->user_image = $_FILES['user_image']['name'];
                $user->set_file($user->user_image);
                $user->save_data_and_image();
                Redirect("users.php");
            }
           
  

    } ?> 
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
                        <h1 class="page-header">USERS</h1>
                        <div class="col-md-6">
                            <img class="img-responsive showing-img" src="<?php echo $user->get_image();?>">
                        </div>
                        <form action="<?php echo "action_user.php?do=edit&id=" . $user->id;?>" method="post" enctype="multipart/form-data">
                            <div class="col-md-6">
                            <div class="form-group">
                                        <label for="username">User Image</label>
                                    <input type="file" name='user_image'>
                                </div> 
                                <div class="form-group">
                                        <label for="username">User name</label>
                                    <input type="text" name='username' class="form-control" value="<?php echo $user->username;?>" >
                                </div> 
                                <div class="form-group">
                                        <label for="email">Email</label>
                                    <input type="text" name='email' class="form-control" value="<?php echo $user->email;?>" >
                                </div>
                                <div class="form-group">
                                        <label for="first_name">First name</label>
                                    <input type="text" name='first_name' class="form-control" value="<?php echo $user->first_name;?>" >
                                </div>
                                
                                <div class="form-group">
                                        <label for="last_name">Last name</label>
                                    <input type="text" name='last_name'  class="form-control" value="<?php echo $user->last_name;?>" >
                                </div>
                                <div class="form-group">
                                        <label for="password">Password</label>
                                    <input type="text" name='password'  class="form-control" >
                                </div>
                                <div class="form-group">
                                    <input type="submit" name='update'  value="Update" class="form-control btn btn-primary submit-button" >
                                </div>
                                <div class="form-group">
                                    <a href="action_user.php?do=delete&id=<?php echo $user->id;?>" class="form-control btn btn-danger submit-button" >Delete User</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        

  <?php include("includes/footer.php"); ?>


<?php else: ?>
     <?php include("includes/init.php"); ?>
    <?php Redirect("users.php");?>
 
<?php endif; ?>