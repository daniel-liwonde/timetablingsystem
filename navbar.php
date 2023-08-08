<?php
include('session.php');
?>
<div class="navbar navbar-fixed-top navbar-inverse">
    <div class="navbar-inner">
        <div class="container">

            <!-- .btn-navbar is used as the toggle for collapsed navbar content -->
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>

            <!-- Be sure to leave the brand out there if you want it shown -->

            <!-- Everything you want hidden at 940px or less, place within here -->

            <?php
            $l = $_SESSION['level'];
            $id = $session_id;
            $user = mysqli_query($conn, "select * from user where  user_id='$id'") or die("here" . mysqli_error($conn));
            $us = mysqli_fetch_array($user); ?>

            <div class="nav-collapse collapse">
                <!-- .nav, .navbar-search, .navbar-form, etc -->

                <ul class="nav">
                    <li><a href="timetable.php"><i class="icon-home icon-large"></i>&nbsp;Home</a></li>


                    <li>
                        <?php if ($l == 9) { ?><a href="teacher.php">
                            <?php } else { ?> <a href="#" onClick="alert('ACCESS DENIED')">
                                <?php } ?><i class="icon-group  icon-large"></i>&nbsp;Lecturers
                            </a>
                    </li>


                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="icon-folder-close-alt icon-large"> </i>&nbsp;Entry
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <?php if (($l == 3) or ($l == 7) or ($l == 6) or ($l == 1) or ($l == 2) or ($l == 9) or ($l == 10)) { ?><a
                                        href="course.php">
                                    <?php } else { ?> <a href="#" onClick="alert('ACCESS DENIED')">
                                        <?php } ?>Program
                                    </a>
                            </li>
                            <li>
                                <?php if (($l == 3) or ($l == 7) or ($l == 6) or ($l == 1) or ($l == 2) or ($l == 10) or ($l == 9)) { ?><a
                                        href="subject.php">
                                    <?php } else { ?> <a href="#" onClick="alert('ACCESS DENIED')">
                                        <?php } ?>Course
                                    </a>
                            </li>
                            <li>
                                <?php if (($l == 3) or ($l == 7) or ($l == 1) or ($l == 2) or ($l == 9)) { ?><a
                                        href="department.php">
                                    <?php } else { ?> <a href="#" onClick="alert('ACCESS DENIED')">
                                        <?php } ?>Department
                                    </a>
                            </li>

                        </ul>
                    </li>


                    <li>
                        <?php if (($l == 9)) { ?><a href="user.php">
                            <?php } else { ?> <a href="#" onClick="alert('ACCESS DENIED')">
                                <?php } ?><i class="icon-user icon-large"></i>&nbsp;User
                            </a>
                    </li>
                    <li><a href="#myModal" role="button" data-toggle="modal"><i
                                class="icon-signout icon-large"></i>&nbsp;Logout</a></li>
                </ul>
            </div>

        </div>
    </div>
</div>

<div class="hero-unit-header" style="margin:0 auto">
    <div class="container">
        <div class="row-fluid">
            <div class="span12">
                <div class="row-fluid">
                    <div class="span6">
                        <img src="images/head_tec2.png">
                    </div>
                    <div class="span6">

                        <div class="pull-right">
                            <i class="icon-calendar icon-large"></i>
                            <?php
                            $Today = date('y:m:d');
                            $new = date('l, F d, Y', strtotime($Today));
                            echo $new;
                            ?>
                            <br><br>
                            <?php
                            $i = $_SESSION['id'];
                            $user_query = mysqli_query($conn, "select * from user where user_id='$i'") or die(mysqli_error($conn));
                            if (mysqli_num_rows($user_query) == 0) {
                                $user_query2 = mysqli_query($conn, "select * from teacher where teacher_id='$i'") or die(mysqli_error($conn));
                                $row = mysqli_fetch_array($user_query2);
                            } else
                                $row = mysqli_fetch_array($user_query);
                            ?>
                            <a onClick='$.getJSON("x.php");' class="btn btn-info">Welcome:<i
                                    class="icon-user icon-large"></i>&nbsp;
                                <?php echo $row['firstname'] . " " . $row['lastname']; ?>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>