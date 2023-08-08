<?php
require_once('session.php');
require_once('header.php');
require_once('connect.php');
require('functions.php');
require_once('ttFunctions.php');
$year = date('Y');
$sem = checksem();
$msgP;
//cancelling a course manual schedule
if (isset($_GET['id'])) {
    $del = $_GET['id'];
    $done = mysqli_query($conn, "DELETE FROM examvenues WHERE id='$del'");
    if ($done) { //done
        if (mysqli_affected_rows($conn) > 0) {
            $msgc = "<div class='alert alert-success'><i class='fas fa-check-circle'></i> &nbsp;Room  successifully removed!</div>";
        }
    }
}
//cancelling a course manual schedule
if (isset($_GET['delid'])) {
    $del = $_GET['delid'];
    $donec = mysqli_query($conn, "DELETE FROM examsessions WHERE id='$del'");
    $donec2 = mysqli_query($conn, "DELETE FROM examschedule WHERE sessionid='$del'");
    if ($donec && $donec2) { //done
        if (mysqli_affected_rows($conn) > 0) {
            $msgcl = "<div class='alert alert-success'><i class='fas fa-check-circle'></i> &nbsp;session  successifully removed!</div>";
        }
    }
}
if (isset($_GET['subid'])) {
    $schedule = $_GET['subid'];
    $coid = $_GET['coid'];
    $done = mysqli_query($conn, "DELETE FROM examschedule WHERE scheduleid=$schedule");
    if ($done) { //done
        if (mysqli_affected_rows($conn) > 0) {
            mysqli_query($conn,"UPDATE subject SET allocatedExam=0 WHERE subject_id='$coid'") or die(mysqli_error($conn));
            $msgP = "<div class='alert alert-success'><i class='icon-check icon-large'></i> &nbsp;  schedule removed successifully!</div>";
        }
    } //close done
}
if (isset($_POST['saveRoom'])) {
    $roomName = $_POST['roomname'];
    $duproom = mysqli_query($conn, "SELECT room FROM examvenues WHERE room ='$roomName'");
    if (mysqli_num_rows($duproom) == 0) {
        mysqli_query($conn, "INSERT INTO examvenues(room)
		values('$roomName')") or die(mysqli_error($conn));

        $msg = "<span class='alert alert-success'><i class='fas fa-check-circle'></i> &nbsp;Room {$roomName} is added successifully</span>";
    } else
        $msg = "<span class='alert alert-danger'><i class='icon-check icon-large'></i> &nbsp;Room {$roomName} is already added</span>";

}

if (isset($_POST['addClass'])) {
    $sessionName = $_POST['sessionName'];
    $fro = $_POST['fro'];
    $to = $_POST['to'];
   
    $dupclass = mysqli_query($conn, "SELECT  session_name  FROM examsessions WHERE session_name='$sessionName' and session_from='$fro'
    and session_to='$to'");
    if (mysqli_num_rows($dupclass) == 0) {
        mysqli_query($conn, "INSERT INTO examsessions(session_name,session_from,session_to)
		values('$sessionName','$fro','$to')") or die(mysqli_error($conn));

        $msgcl = "<span class='alert alert-success'><i class='icon-check icon-large'></i> &nbsp;Session {$sessionName}  from {$fro} to {$to} is added successifully</span>";
    } else
        $msgcl = "<span class='alert alert-danger'>Session {$sessionName}  from {$fro} to {$to} is already added</span>";

}

?>

<body>
    <div class="row-fluid">
        <div class="span12">
            <?php include('navbar.php'); ?>
            <div class="container">

                <div class="row-fluid">
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
                        <?php require_once "ttMenu.php"; ?>
                    </div>
                    <div class="span12" style="border:1px; width:85%; margin-left:22%; margin-top:-455px; ">
                        <?php require_once "ttopMenu.php"; ?>
                        <br><br>
                        <div class="hero-unit-3" style="margin-top:10px"> <!--wrapper -->
                            <div class="alert alert-info">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <strong><i class="icon-calendar icon-large"></i>&nbsp;Examination Timetable
                                    Settings</strong>
                            </div>
                            <div class="hero-unit-3" style="margin-top:10px">

                                <div class="alert alert-info">
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                    <strong><i class="icon-home icon-large"></i>&nbsp;Add class rooms for Exams</strong>
                                </div>
                                <form class="form-inline" method="POST">
                                    <div class="control-group" style="float:left; padding-right:5px">
                                        <div class="controls">

                                            <select name="roomname" required>
                                                <option value="">Select room</option>
                                                <?php
                                                $sql = "SELECT * from rooms";
                                                $find = mysqli_query($conn, $sql);

                                                //f(mysql_affected_rows($find)>0){
                                                
                                                while ($rows = mysqli_fetch_assoc($find)) {
                                                    ?>
                                                    <option value="<?php echo $rows['room'] ?>"><?php echo $rows['room'] ."(".$rows['location'].")"?>
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
                                            <button type="submit" name="saveRoom" role="button" class="btn btn-info">
                                                <i class="icon-plus-sign icon-large"></i>&nbsp;&nbsp;Add</button>
                                        </div>
                                    </div>
                                </form>

                                <div>
                                    <?php if (isset($msg))
                                        echo $msg;
                                    unset($msg); ?>
                                </div>
                                <!-- end slider -->
                            </div>




                            <div class="hero-unit-3" style="margin-top:10px">

                                <div class="alert alert-info">
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                    <strong><i class="icon-home icon-large"></i>&nbsp;Added exam rooms
                                    </strong>
                                </div>

                                <table cellpadding="0" cellspacing="0" border="0"
                                    class="table table-striped table-bordered table-hover" width="20%">
                                    <thead>
                                        <tr>
                                            <th>Room Name</th>
                                             <th>Campus</th>
                                            <th>Action</th>


                                        </tr>
                                    </thead>
                                    <tbody>


                                        <?php
                                        $sql = "SELECT * from examvenues INNER JOIN rooms ON examvenues.room=rooms.room";
                                        $find = mysqli_query($conn, $sql);

                                        //f(mysql_affected_rows($find)>0){
                                        
                                        while ($rows = mysqli_fetch_assoc($find)) {
                                            ?>
                                            <tr>
                                                <td>
                                                    <?php echo $rows['room'] ?>
                                                </td>
                                                 <td>
                                                    <?php echo $rows['location'] ?>
                                                    </td>
                                                    <td>
                                                        <a class="btn btn-danger"
                                                            href="examTTSettings.php?id=<?php echo $rows['id'] ?>">
                                                        <i class="fas fa-remove"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <?php
                                        }

                                        ?>

                                    </tbody>
                                </table>


                            </div>
                            <!-- end slider -->
                            <div>
                                <?php if (isset($msgc))
                                    echo $msgc;
                                unset($msgc); ?>
                            </div>

                            <div class="hero-unit-3" style="margin-top:10px">

                                <div class="alert alert-info">
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                    <strong><i class="fas fa-clock fa-lg"></i>&nbsp;Add Exam Sessions</strong>
                                </div>
                                <form class="form-inline" method="POST">
                                    <div class="control-group" style="float:left; padding-right:5px">
                                        <div class="controls">
                                            <select name="fro" required>
                                                <option value="">Exam session start time</option>
                                                <option> 7 am</option>
                                                <option> 7:30 am</option>
                                                <option> 8:00 am</option>
                                                <option> 8:30 am</option>
                                                <option> 9:00 am</option>
                                                <option> 9:30 am</option>
                                                <option> 10:00 am</option>
                                                <option> 10:30 am</option>
                                                <option> 11: 00 am</option>
                                                <option>11:30 am</option>
                                                <option> 12:00 pm</option>
                                                <option>12:30 pm</option>
                                                <option>1:00 pm</option>
                                                <option>1:30 pm</option>
                                                <option>2:00 pm</option>
                                                <option>2:30 pm</option>
                                                <option>3:00 pm</option>
                                                <option>3:30 pm</option>
                                                <option>4:00 pm</option>
                                                <option>4:30 pm</option>
                                                <option>5:00 pm</option>
                                                <option>5:30 pm</option>
                                                 <option>6:00 pm</option>
                                                  <option>6:30 pm</option>
                                                   <option>7:00 pm</option>
                                                    <option>7:30 pm</option>
                                                     <option>8:00 pm</option>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="control-group" style="float:left; padding-right:5px">
                                        <div class="controls">
                                            <select name="to" required>
                                                <option value="">Exam Session end time</option>
                                                <option> 7 am</option>
                                                <option> 7:30 am</option>
                                                <option> 8:00 am</option>
                                                <option> 8:30 am</option>
                                                <option> 9:00 am</option>
                                                <option> 9:30 am</option>
                                                <option> 10:00 am</option>
                                                <option> 10:30 am</option>
                                                <option> 11: 00am</option>
                                                <option>11:30 am</option>
                                                <option> 12:00 pm</option>
                                                <option>12:30 pm</option>
                                                <option>1:00 pm</option>
                                                <option>1:30 pm</option>
                                                <option>2:00 pm</option>
                                                <option>2:30 pm</option>
                                                <option>3:00 pm</option>
                                                <option>3:30 pm</option>
                                                <option>4:00 pm</option>
                                                <option>4:30 pm</option>
                                                <option>5:00 pm</option>
                                                <option>5:30 pm</option>
                                                 <option>6:00 pm</option>
                                                  <option>6:30 pm</option>
                                                   <option>7:00 pm</option>
                                                    <option>7:30 pm</option>
                                                     <option>8:00 pm</option>

                                            </select>
                                        </div>
                                    </div>

                                    <div class="control-group" style="float:left; padding-right:5px">
                                        <div class="controls">

                                            <input type="text" name="sessionName"
                                                placeholder="session name.eg. afternoon hours" required>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <div class="controls">

                                            <button type="submit" name="addClass" role="button" class="btn btn-info"><i
                                                    class="icon-plus-sign icon-large"></i>&nbsp;&nbsp;Add</button>
                                        </div>
                                    </div>
                                </form>
                                <div>
                                    <?php if (isset($msgcl))
                                        echo $msgcl;
                                    unset($msgcl); ?>
                                </div>
                                <!-- end slider -->
                            </div>
                            <div class="hero-unit-3" style="margin-top:10px">

                                <div class="alert alert-info">
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                    <strong><i class="icon-plus-sign icon-large"></i>&nbsp; Added
                                        Exam sessions</strong>
                                </div>
                                <!-- start form -->
                                <table cellpadding="0" cellspacing="0" border="0"
                                    class="table table-striped table-bordered table-hover" id="example">
                                    <thead>
                                        <tr>
                                            <th>Session Name</th>
                                            <th>From</th>
                                            <th>To</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $find = mysqli_query($conn, "SELECT * FROM examsessions");
                                        //f(mysql_affected_rows($find)>0){
//f(mysql_affected_rows($find)>0){
                                        
                                        while ($rows = mysqli_fetch_assoc($find)) {
                                            $eclass_id = $rows['id'];
                                            ?>
                                            <tr>
                                                <td>
                                                    <?php echo $rows['session_name'] ?>
                                                </td>
                                                <td>
                                                    <?php echo $rows['session_from'] ?>
                                                </td>
                                                <td>
                                                    <?php echo $rows['session_to'] ?>
                                                </td>
                                    
                                                <td><a onclick="return confirm('The session will be deleted. Do you want to proceed?')"
                                                        class="btn btn-danger"
                                                        href="examTTSettings.php?delid=<?php echo $eclass_id ?>"><i
                                                            class="icon icon-trash icon-large"></i></a></td>


                                            </tr>
                                            <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>


                                <!-- end slider -->
                            </div>
                            <div class="hero-unit-3" style="margin-top:10px; overflow-y:auto ;">

                                <div class="alert alert-info">
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                    <strong><i class="fa-list-check icon-large"></i>&nbsp;Set time exam timetable
                                        Preferences</strong>
                                        <diV class="alert alert-danger"><span class="text-warning"><b>PLEASE TAKE NOTE:</b></span><br>
                                        Make sure that your schedule is within the intended examination timetable period. The system will not check 
                                        against wrong schedules made outside  the intended exam period!
                                    </diV>

                                </div>


                                <div class="control-group" style="float:left; padding-right:5px">

                                    <div class="controls">
                                        <select id="pcourse" required>
                                            <option value="">Select course</option>
                                            <?php
                                            $sql = "SELECT teacher.lastname, teacher.teacher_id, teacher.firstname, subject.subject_title, subject.subject_id
        FROM teacher 
        INNER JOIN subject ON teacher.teacher_id = subject.teacher_id WHERE subject.exm!=1 order by subject.subject_title asc";
                                            $find = mysqli_query($conn, $sql);

                                            //f(mysql_affected_rows($find)>0){
                                            
                                            while ($rows = mysqli_fetch_assoc($find)) {
                                                ?>
                                                <option value="<?php echo $rows['subject_id'] ?>"><?php echo $rows['subject_title'] ?></option>
                                                <?php
                                            }
                                            //}
                                            ?>

                                        </select>
                                    </div>
                                </div>
                            
                                <div class="control-group" style="float:left; padding-right:5px">

                                    <div class="controls">
                                        <select id="psession" required>
                                            <option value="">Session</option>

                                            <?php
                                            $find = mysqli_query($conn, "SELECT * FROM examsessions");
                                            //f(mysql_affected_rows($find)>0){
                                            
                                            while ($rows = mysqli_fetch_assoc($find)) {
                                                ?>
                                                <option value="<?php echo $rows['id'] ?>"><?php echo $rows['session_name'] ?>
                                                </option>
                                                <?php
                                            }
                                            //}
                                            ?>

                                        </select>
                                    </div>
                                </div>
                                <div class="control-group" style="float:left; padding-right:5px">

                                    <div class="controls">
                                        <input type="date" id="examDate"required>
                                    </div>
                                </div>
                                <div class="control-group" style="float:left; padding-right:5px">

                                    <div class="controls">
                                        <select id="week"required>
                                            <option value=" ">Select week</option>
                                            <option value="1">WEEK 1</option>
                                            <option value="2">WEEK 2</option>
                                            <option value="3">WEEK 3</option>
                                            <option value="4">WEEK 4</option>
                                            <option value="5">WEEK 5</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <div class="controls">

                                        <button  type="submit" id="set" role="button" class="btn btn-info"
                                        onclick='$("#msg").html("Please wait..."),
                                         $.getJSON("ttdoWorkExam.php", {
                                                        pcourse: $("#pcourse").val(),
                                                        psession: $("#psession").val(),
                                                        examDate: $("#examDate").val(),
                                                        week: $("#week").val()
                                                    
                                                    },
                                                        function (data) {
                                                            $("#msg").html(data.res);
                                                        });
                                        '>
                                            <i class="icon-save icon-large"></i>&nbsp;&nbsp;Set
                                        </button>

                                        <script>
                                            $(document).ready(function () {
                                                $("#").click(function () {
                                                    $("#msg").html("Please wait...");
                                                    $.getJSON("ttdoWorkExam.php", {
                                                        pcourse: $("#pcourse").val(),
                                                        psession: $("#psession").val(),
                                                        examDate: $("#examDate").val()
                                                    
                                                    },
                                                        function (data) {
                                                            $("#msg").html(data.res);
                                                        });
                                                });
                                            });
                                        </script>

                                    </div>
                                </div>

                                <br>
                                <br>
                                <div id="msg"></div>
                            </div>



                            <!-- START TABLE -->

                            <div class="hero-unit-3" style="margin-top:10px">

                                <div class="alert alert-info">
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                    <strong><i class="icon-calendar "></i>&nbsp; Preffered
                                        settings</strong>
                                </div>
                                <div>
                                    <?php if (isset($msgP)) {
                                        echo $msgP;
                                        unset($msgP);
                                    }
                                    ?>
                                </div>
                                <table cellpadding="0" cellspacing="0" border="0"
                                    class="table table-striped table-bordered" id="example">
                                    <thead>
                                        <tr>
                                            <th>Course</th>
                                            <th>Session</th>
                                            <th>Date</th>
                                            <th>From </th>
                                            <th>To</th>
                                            <th>Week</th>
                                            <th>Action</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $find = mysqli_query($conn, "SELECT * FROM
                                         examschedule JOIN examsessions ON 
                                        examschedule.sessionid=examsessions.id AND examschedule.pref=1");
                                        while ($row = mysqli_fetch_assoc($find)) 
                                        {
                                            $subname = $row['course'];
                                             $coid = $row['courseid'];
                                            $from = $row['session_from'];
                                            $to= $row['session_to'];
                                            $sid = $row['scheduleid'];
                                            $sdate = $row['edate'];
                                            $date = new DateTime($sdate);
                                            $week = $row['exam_week'];
                                            $date= $date->format("l, j F Y");
                                           
                                            $sessionname = $row['session_name'];
                                            
                                                ?>
                                                <tr>
                                                    <td>
                                                        <?php echo $subname ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $sessionname ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $date ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $from ?>

                                                    </td>
                                                    <td>
                                                        <?php echo $to ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $week ?>
                                                        </td>
                                                        <td><a onclick="return confirm('Are you sure you want to remove this schedule?')"
                                                                tootip="Remove" class="btn btn-danger"
                                                                href="examTTSettings.php?subid=<?php echo $sid ?>&coid=<?php  echo $coid ?>">
                                                            <i class="icon icon-remove icon-large"></i></a>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                        ?>
                                    </tbody>
                                </table>
                                <!-- end slider -->
                            </div>
                            <!--END TABLE-->


                        </div> <!-- closing wrapper-->
                    </div>
                </div>

                <?php include('footer.php'); ?>
            </div>

        </div>
    </div>
</body>

</html>