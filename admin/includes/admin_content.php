
            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Blank Page
                            <small>Subheading</small>
                        </h1>
                        <?php

                            echo "<h1>users</h1>";
                            $users = users::get_all_fields();
                            foreach ($users as $user) {
                                echo $user->username . "<br>";
                            }
                        echo "<h1>photos</h1>";
                        $photos = photo::get_all_fields();
                        if(!empty($photos)) {
                            foreach ($photos as $photo) {
                                echo $photo->title . "<br>";
                            }
                        }else {
                            echo "no photo";
                        }
                            $photo = new photo();
                            $photo->title = "car1";
                            $photo->size = 50;
                            //$r = $photo->create();
                           // echo $r ? "Created" : "Faild";

//                            $user = users::find_by_ID(100);
//                            if(!empty($user) ) {
//                                echo $user->first_name;
//                            }else {
//                                echo "no data";
//                            }
//                            echo "<br>";

//                        $user2 = users::find_by_ID(27);
//
//                        $r = $user2->delete();
//                       echo $r ? "Deleted" : "Faild";

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