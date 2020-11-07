
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
//                        $user1->create_user();
//                        echo $user1->id;
                        $user2 = users::find_user_by_ID(3);
                        if($user2) {
                            $user2->email = 'maen2@gmail.com';
                            $res = $user2->save();
                            echo $res ? "succssefully updated" : "no updated to data";
                        }
//                        $user2 = users::find_user_by_ID(14);
//                        if($user2) {
//                            $res = $user2->delete_user();
//                            echo $res ? "Deleted user Succssfully" : "No Delete any think";
//                        }else{
//                            echo "there isn't user has this id";
//                        }
//                        $user2 = users::find_user_by_ID(3);
//                        if($user2) {
//                            $user2->email = 'maen123a@gmail.com';
//                            $res = $user2->save();
//                            echo $res ? "succssefully updated" : "no updated to data";
//                        }
//                        $user2 = new users();
//                        $user2->username = "example223212";
//                        $user2->password = "123";
//                        $user2->email = "123";
//                        $user2->first_name = "ex1";
//                        $user2->last_name = "ex2";
//                        $r = $user2->save();
//                        echo $r ? "Created" : "Faild";
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