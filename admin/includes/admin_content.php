
            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Blank Page
                            <small>Subheading</small>
                        </h1>
                        <?php

                            $users = users::get_all_users();
                            foreach ($users as $user) {
                                echo $user->username . "<br>";
                            }
                            $user = users::find_user_by_ID(1);
                            if(!empty($user) ) {
                                echo $user->first_name;
                            }else {
                                echo "no data";
                            }
                            echo "<br>";
                            ?>
                        <?php

//                        $user1 = new users();
//                        $user1->username = "ahmad123";
//                        $user1->email = "a@a.com";
//                        $user1->password = "123";
//                        $user1->first_name = "ahmad";
//                        $user1->last_name = "mohammad";
//                        $user1->createuser();
//                        echo $user1->id;


                        ?>


                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="index.html">Dashboard</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-file"></i> Blank Page
                            </li>
                        </ol>
                    </div>
                </div>
            </div>