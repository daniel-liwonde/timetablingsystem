<?php
include('session.php');
include('header.php');
require_once('functions.php');
require_once('ttFunctions.php');
$sem = showCurrentSem($conn);
if (isset($_GET['action']) == "delete") {
    $del = mysqli_query($conn, "DELETE FROM suppcourses WHERE sem='$sem'") or die(mysqli_error($conn));
}
?>

<body>
    <div class="row-fluid">
        <div class="span12">
            <?php include 'navbar.php'; ?>
            <div class="container">

                <div class="row-fluid">


                    <div class="span12" style="border:1px; margin-top:20px; ">
                        <!--slider-->
                        <?php require_once('ttopMenu.php') ?>

                        <div class="hero-unit-3" style="margin-top:15px;min-height:900px; width:103%">
                            <div class="alert alert-info">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <strong><i class="fas fa-list-check"></i>&nbsp;Create timetable for selected
                                    courses</strong>
                            </div>
                            <!-- start nested hero unit-3 -->
                            <div class="hero-unit-3 container" style="margin-top:10px; width:50%;float:left;">
                                <div class="alert alert-info">
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                    <strong><i class="icon-list "></i>&nbsp;Available courses</strong>
                                </div>
                                <div id="msg">
                                    <?php if (isset($msg))
                                        echo $msg;
                                    unset($msg); ?>
                                </div>
                                <table class="table table-stripped table-hover table-bordered" id="example">
                                    <thead>
                                        <tr>
                                            <th>Course Code</th>
                                            <th>Course Name</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sql = "SELECT * FROM subject
        INNER JOIN teacher ON subject.teacher_id =teacher.teacher_id";
                                        $find = mysqli_query($conn, $sql);

                                        //f(mysql_affected_rows($find)>0){
                                        
                                        while ($rows = mysqli_fetch_assoc($find)) {
                                            $course_id = $rows['subject_id'];
                                            $studs = $rows['students']
                                                ?>
                                            <tr>
                                                <td>
                                                    <?php echo $rows['subject_code'] ?>
                                                </td>
                                                <td>
                                                    <?php echo $rows['subject_title'] ?>
                                                </td>
                                                <td>
                                                    <a class="btn btn-info" href="#" onclick='$("#msg").html("Please wait..."),$.getJSON("do.php",
                                                    {
course_id:<?php echo $course_id ?>} ,
function(data){
    $("#msg").css("display", "block");
$("#msg").html(data.res); 

setTimeout(function () {
                                                    $("#msg").css("display", "none");
                                                }, 8000);
}
);'><i class="fas fa-circle-plus"></i>Add </a>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                        //}
                                        ?>
                                    <tbody>
                                </table>

                            </div>

                            <!-- end nested hero-3 -->
                            <!-- start nested hero unit-3-second -->
                            <div class="hero-unit-3"
                                style="margin-top:10px; width:43%;float:left;position:relative; margin-left:1%; max-height:660px;overflow-y:auto">
                                <div class="alert alert-info">
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                    <strong><i class="fas fa-circle-plus"></i>&nbsp;Added Courses | <a
                                            onclick="return confirm('This action will remove all Supplementary added course. Do you want to proceed?')"
                                            href="?action=delete">Remove
                                            all added courses</a></strong>
                                </div>

                                <div id="msgd">

                                </div>
                                <table class="table table-stripped table-hover table-bordered examples" id="myTable">

                                </table>
                            </div>

                            <!-- end nested hero-3-second -->

                            <!-- end slider -->
                        </div>
                    </div>


                </div><!-- end fluid -->

                <?php include('footer.php'); ?>
            </div>


        </div>

    </div>
</body>

</html>