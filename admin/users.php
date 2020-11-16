<?php include("includes/header.php"); ?>
<?php if(!$session->get_signed_in()) { Redirect("login.php");}?>
<?php
$users = users::get_all_fields();
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
                            USERS
                        </h1>
                        <?php echo $message;?>
                        <a href="action_user.php?do=add" class='btn btn-primary'>Create User</a>
                        <div class="col-md-12">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Profile Image</th>
                                    <th>User name</th>
                                    <th>First name</th>
                                    <th>Last name</th>
                                    <th>Email</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($users as $user):?>
                                <tr>
                                    <td><?php echo $user->id; ?></td>
                                    <td><img class='users-admin-image'src="<?php echo $user->get_image();?>" alt="image"></td>
                                    <td>
                                        <?php echo $user->username; ?>
                                        <div class='action_links'>
                                            <a href="action_user.php?do=delete&id=<?php echo $user->id;?>">Delete</a>
                                            <a href="action_user.php?do=edit&id=<?php echo $user->id;?>"">Edit</a>
                                            <a href="#">View</a>
                                        </div>
                                    </td>

                                    <td><?php echo $user->first_name; ?></td>
                                    <td><?php echo $user->last_name; ?></td>
                                    <td><?php echo $user->email; ?></td>
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