<?php
include('functions.php');
if (isset($_POST['login'])) { // start
    $username = clean($conn, $_POST['username']);
    $password = md5(clean($conn, $_POST['password']));
    $stud_pass = clean($conn, $_POST['password']);
    $query = mysqli_query($conn, "select * from user where username='$username' and password='$password'");
    $count = mysqli_num_rows($query);
    $row = mysqli_fetch_array($query);
    if ($count > 0) { //user found
        session_start();
        $_SESSION['level'] = $row['user_level'];
        //$_COOKIE['id'] = $row['user_id'];
        $_SESSION["id"] = $row['user_id'];
        header('location:timetable.php');
        session_write_close();
        exit();
    } //end found user
    else { //check teacher or student
        session_write_close();
        $query = mysqli_query($conn, "select * from teacher where username='$username' and password='$password'");
        $count = mysqli_num_rows($query);
        $row = mysqli_fetch_array($query);
        if ($count > 0) { //found teacher
            session_start();
            //session_regenerate_id();
            $_SESSION["id"] = $row['teacher_id'];
            //$_COOKIE['id'] = $row['teacher_id'];
            // $_COOKIE['level']=$row['user_level'];
            $_SESSION["level"] = $row['user_level'];
            header('location:teacher_home.php');
            session_write_close();
            exit();
        } //end found teacher
        else { //check student
            session_write_close();
            $query = mysqli_query($conn, "select * from student where username='$username' and password='$password'") or die(mysqli_error($conn));
            $count = mysqli_num_rows($query);
            $row = mysqli_fetch_array($query);
            if ($count > 0) { //found student
                $uid = $row['id'];
                $cyear = date('Y');
                $csem = checksem();
                session_start();
                $_SESSION["id"] = $row['id'];
                $_SESSION['year'] = $row['stud_current_year'];
                $_SESSION['ssem'] = $row['current_sem'];
                $_SESSION['pro'] = $row['cys'];
                $_SESSION['ADM_YEAR'] = $row['addm_year'];
                header('location:student_home.php');
                session_write_close();
                exit();
            } //end found student
            else { //not found
                //session_write_close();
                $message = " Access Denied";
            } //end not found
        } //end check student
    } //end check teacher or student
} //end start

include('header.php');
?>
<style>
    /* Default styles for larger screens */

    .mycover {
        margin-left: 25%;
        width: 50%;
    }

    .adj {
        margin-left: 280px;
        margin-top: -1090px
    }

    /* Media query for smaller screens (max-width: 767px) */
    @media (max-width: 990px) {
        .mycover {
            margin-left: 0;
            /* Remove the left margin for smaller screens */
            width: 100%;
        }

        .submit {
            width: 240px;
            margin-left: 5%;

        }

        .control-group {
            margin-left: -45px
        }

        .adj {
            margin-left: 50%
        }

        /* Additional styles for smaller screens if needed */
        /* For example, you can adjust the font size, padding, etc. */
    }
</style>

<body style=" background-color: #f6f7f9;">
    <div class="row-fluid">
        <div class="span12">
            <div class="navbar navbar-fixed-top navbar-inverse" style="background-color:#67CFAC">
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
                        <div class="nav-collapse collapse">
                            <!-- .nav, .navbar-search, .navbar-form, etc -->
                        </div>
                    </div>
                </div>
            </div>

            <div class="container" style="margin:0 auto;margin-top:40px">
                <div class="row-fluid">
                    <div class="mycover">
                        <img src="img/ttnob2.png" style="margin-left:27%">
                        <span class="text-warning"
                            style="margin-top:174px;font-size:20px; margin-left:-230px;position:absolute">Enter
                            Login
                            details below</span>

                        <div class="hero-unit-3"
                            style="background-color: #ffffff; height: 270px; margin-top: 50px; box-shadow: 0 0 0 1px rgba(20, 20, 31, .05), 0 1px 3px 0 rgba(20, 20, 31, .15);">
                            <!-- login -->
                            <form class="form-horizontal" method="post" autocomplete="off"
                                style="margin-top: 37px; margin-left: -57px;">
                                <div class="control-group">
                                    <div class="controls">
                                        <div class="input-prepend">
                                            <span class="add-on" style="height: 30px;"> <i class="fa fa-user fa-2x"
                                                    style="color: #61C2A2"></i></span>
                                            <input
                                                style="width: 100%; max-width: 300px; height: 30px; background-color: #ffffff;"
                                                type="text" name="username" id="inputEmail" placeholder="Username"
                                                required>
                                        </div>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <div class="controls">
                                        <div class="input-prepend">
                                            <span class="add-on" style="height: 30px;"><i class="fa fa-lock fa-2x"
                                                    style="color: #61C2A2"></i></span>
                                            <input type="password"
                                                style="width: 100%; max-width: 300px; height: 30px; background-color: #ffffff important!;"
                                                name="password" id="inputPassword" placeholder="Password" required><br>

                                        </div>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <div class="controls">
                                        <button type="submit" class="btn btn-info submit" name="login"
                                            class="btn btn-info"><i class=" fas fa-sign-in fa-lg"></i>&nbsp;&nbsp;Sign
                                            in</button>
                                    </div><br>
                                    <?php if (isset($message)) { ?>
                                        <div class="alert alert-danger"
                                            style="margin-bottom: -7px; width: 100%; max-width:300px; margin-left: 123px">
                                            <i class="icon-remove-sign"></i>&nbsp;
                                            <?php echo $message;
                                            $message = ''; ?>
                                        </div>
                                    <?php } ?>
                                </div>
                                <a class="adj" href="javascript:void(0);" onclick='$("#edit").show("slow");'>Forgot
                                    password</a>
                            </form>


                            <div style="display:none;font: normal 12px arial; padding:10px; background: #e6f3f9; color: #0099FF;"
                                id="edit">
                                Enter your email address below and check your email
                                <form class="form-horizontal" method="post">
                                    <div class="control-group">
                                        <label class="control-label" for="inputEmail"></label>
                                        <div class="controls">
                                            <input type="email" name="usermail" id="inputEmail"
                                                placeholder="Enter your email here" required>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <div class="controls">
                                            <button type="submit" name="send" class="btn btn-info"
                                                style="background-color:#61C2A2"><i
                                                    class="icon-signin icon-large"></i>&nbsp;Send
                                                email</button>
                                        </div>
                                    </div>
                                </form>
                                <a title="close" href="javascript:void(0);" onclick='$("#edit").hide("slow");'
                                    style=" text-decoration:none; margin-left:100%">&times;</a>
                            </div>
                            <br>
                            <?php
                            if (isset($_POST['send'])) {

                                $mail = clean($conn, $_POST['usermail']);

                                $msg = recoverPass($mail);
                                echo $msg;
                            }


                            ?>
                        </div>
                    </div>

                </div>
                <?php //include('footer.php');?>

            </div>
        </div>
    </div>






</body>

</html>