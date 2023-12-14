<?php
include('session.php');
require_once('header.php');
require_once 'connect.php';
require_once('functions.php');
$year = date('Y');
$sem = checksem();
?>

<body>
    <div class="row-fluid">
        <div class="span12">
            <?php include 'navbar.php'; ?>
            <div class="container">

                <div class="row-fluid">
                    <!--
                    <div class="hero-unit-3" style="width:18.5%">
                        <div class="alert-index alert-success">
                            <i class="icon-calendar icon-large"></i>
                            <?php
                            $Today = date('y:m:d');
                            $new = date('l, F d, Y', strtotime($Today));
                            echo $new;
                            ?>
                        </div>
                    </div>
                    <div class="hero-unit-1" style="width:20%">
                        <?php //require_once "ttMenu.php"; ?>
                    </div>
                    -->
                    <div class="span12" style="border:1px; width:107%;  margin-top:20px; ">
                        <!--slider-->
                        <!--slider-->
                        <?php require_once('ttopMenu.php') ?>
                        <div class="hero-unit-3" style="margin-top:10px">

                            <div class="alert alert-info">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <strong><i class="icon-calendar icon-large"></i>&nbsp;Lecturer Time Table | <a
                                        href="timeGen.php">
                                        Back
                                    </a>
                                </strong>
                            </div>

                            <form class="form-inline">
                                <div class="control-group" style="float:left; padding-right:5px">

                                    <div class="controls">
                                        <select name="lect" required onchange="displayTT(this.value)">
                                            <option value="">Lecturer name</option>
                                            <?php
                                            $find = mysqli_query($conn, "SELECT * FROM teacher");
                                            //f(mysql_affected_rows($find)>0){
                                            
                                            while ($rows = mysqli_fetch_assoc($find)) {
                                                ?>
                                                <option value="<?php echo $rows['teacher_id'] ?>">
                                                    <?php echo $rows['lastname'] . " " . $rows['firstname'] ?>
                                                </option>
                                                <?php
                                            }
                                            //}
                                            ?>

                                        </select>

                                    </div>

                                </div>
                                <div class="control-group">
                                    <div class="controls">

                                        <button style="visibility:hidden" type="submit" name="show" role="button"
                                            class="btn btn-info"><i
                                                class="icon-list icon-large"></i>&nbsp;&nbsp;Display</button>
                                    </div>
                                </div>
                            </form>
                            <div id="cs" style="margin-top:50px;margin-bottom:10px">

                            </div>
                            <div id="timeTable">
                            </div>
                        </div>
                    </div>
                </div>
                <?php include('footer.php'); ?>
            </div>
        </div>
    </div>
</body>

</html>