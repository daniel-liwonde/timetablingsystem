<?php
require_once('session.php');
require_once('header.php');
require_once('connect.php');
require('functions.php');
$year = date('Y');
$sem = checksem();
if (isset($_POST['add'])) {
    $clid = $_GET['cid'];
    $cName = $_POST['coName'];
    $sNum = $_POST['sNum'];
    $courseName = mysqli_query($conn, "SELECT *  FROM subject WHERE subject_id='$cName'") or die(mysqli_error($conn));
    $name = mysqli_fetch_assoc($courseName);
    $course = $name['subject_title'];
    $dupcourse = mysqli_query($conn, "SELECT classid FROM course_class WHERE courseid ='$cName' 
and classid='$clid'");
    if (mysqli_num_rows($dupcourse) == 0) {
        mysqli_query($conn, "INSERT INTO course_class(courseid,classid)
		values('$cName','$clid')") or die(mysqli_error($conn));
        mysqli_query($conn, "UPDATE subject SET students='$sNum' WHERE subject_id='$cName'");
        $msg = "<span class='alert alert-success'>$course is added successifully</span>";
    } else {
        mysqli_query($conn, "UPDATE subject SET students='$sNum' WHERE subject_id='$cName'");
        $msg = "<span class='alert alert-warning'>Number of students for<font color='red'> $course </font>has been  Updated to <font color='red'>$sNum</font></span>";

    }

}
if (isset($_POST['subid'])) {
    $subid = $_POST['subid'];
    $cl = $_POST['classID'];
    $dupcourse = mysqli_query($conn, "DELETE FROM course_class WHERE courseid ='$subid' and classid='$cl'");
}
?>

<body>
    <div class="row-fluid">
        <div class="span12">
            <?php include('navbar.php'); ?>
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
                    <div class="span12" style="width:107%;  margin-top:20px;">
                        <!--slider-->
                        <?php require_once('ttopMenu.php') ?>
                        <br><br>
                        <div class="hero-unit-3" style="margin-top:10px"> <!--wrapper -->
                            <div class="alert alert-info">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <strong><i class="icon-calendar icon-large"></i>&nbsp;Add Courses to </strong>
                            </div>
                            <div class="hero-unit-3" style="margin-top:10px">

                                <div class="alert alert-info">
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                    <strong><i class="icon-calendar icon-large"></i>&nbsp;Add courses to <b>
                                            <?php
                                            echo $_GET['cname']; ?>
                                        </b>
                                </div>
                                <form class="form-inline" method="POST">
                                    <div class="control-group" style="float:left; padding-right:5px">
                                        <div class="controls">
                                            <select name="coName" required>
                                                <option value="">Select course </option>
                                                <?php
                                                $findc = mysqli_query($conn, "SELECT * FROM subject WHERE teacher_id !=0  order by subject_title asc");
                                                while ($rowsc = mysqli_fetch_assoc($findc)) {
                                                    ?>
                                                    <option value="<?php echo $rowsc['subject_id'] ?>">
                                                        <?php echo $rowsc['subject_title'] ?></option>
                                                    <?php
                                                }
                                                //}
                                                ?>

                                            </select>
                                            <input type="text" name="sNum" placeholder="Number of students">
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <div class="controls">
                                            <button type="submit" name="add" role="button" class="btn btn-info">
                                                <i class="icon-plus-sign icon-large"></i>&nbsp;&nbsp;Add/Update</button>
                                        </div>
                                    </div>
                                </form>

                                <div>
                                    <?php if (isset($msg))
                                        echo $msg;
                                    unset($msg); ?>
                                </div>
                                <div Class="alert alert-info" style="margin-top:20px">The following are courses in <b>
                                        <?php
                                        echo $_GET['cname']; ?>
                                    </b> class</div>
                                <!-- start table-->
                                <table cellpadding="0" cellspacing="0" border="0"
                                    class="table table-striped table-bordered table-hover" id="example">
                                    <thead>
                                        <tr>
                                            <th>Course Name</th>
                                            <th>Number of Students</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $clid = $_GET['cid'];
                                        $find2 = mysqli_query($conn, "SELECT * FROM course_class
JOIN subject ON subject.subject_id=course_class.courseid WHERE course_class.classid='$clid'");
                                        //f(mysql_affected_rows($find)>0){
//f(mysql_affected_rows($find)>0){
                                        
                                        while ($rows2 = mysqli_fetch_assoc($find2)) {
                                            $subid = $rows2['subject_id'];
                                            $classid = $rows2['classid'];
                                            ?>
                                            <tr>
                                                <td>
                                                    <?php echo $rows2['subject_title'] ?>
                                                </td>
                                                <td>
                                                    <?php echo $rows2['students'] ?>
                                                </td>
                                                <td>
                                                    <form method="post" action="">
                                                        <input type="hidden" name="subid" value="<?php echo $subid ?>">
                                                        <input type="hidden" name="classID" value="<?php echo $classid ?>">

                                                        <button type="submit" class="btn btn-danger">
                                                            <i class="icon icon-trash icon-large"></i></button>
                                                </td>
                                                </form>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>

                                <!-- end table-->

                                <!-- end slider -->
                            </div>




                        </div> <!-- closing wrapper-->
                    </div>
                </div>

                <?php include('footer.php'); ?>
            </div>

        </div>
    </div>
</body>

</html>