<?php
require_once "includes/header.php";
if ($session->get_signed_in()) {
    Redirect("index.php");
}
if(isset($_POST['submit'])) {
    $username = trim(filter_var($_POST['username'], FILTER_SANITIZE_STRING));
    $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
    $passhacked = sha1($password);
    $user_found = users::verify_user($username,$passhacked);

    if(is_object($user_found)) {
        $session->login($user_found);
        Redirect("index.php");

    } else {
        $message = "password or username are not correct";
    }
}else{
    $username="";
    $password="";
    $message="";
}

?>

<div class="col-md-4 col-md-offset-3 loginAdmin">

    <h1 class="center headerAdmin">Admin Log in</h1>
    <h4 class="Admindanger"><?php echo htmlentities($message);?></h4>

    <form id="login-id" action="<?php echo $_SERVER['PHP_SELF']?>" method="post">

        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" name="username" value="<?php echo htmlentities($username); ?>" >

        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" name="password" value="<?php echo htmlentities($password); ?>">

        </div>


        <div class="form-group">
            <input type="submit" name="submit" value="Login" class="btn btn-primary">

        </div>


    </form>


</div>
