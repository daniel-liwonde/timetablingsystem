<?php
require_once('session.php');
require_once('header.php');
require_once('connect.php');
require('functions.php');
require_once('ttFunctions.php');
$year = date('Y');
$sem = checksem();
$msgP;
$sem = showCurrentSem($conn);
//cancelling a course manual schedule
if (isset($_GET['delid'])) {
    $del = $_GET['delid'];
    $donec = mysqli_query($conn, "DELETE FROM classes WHERE classid='$del'");
    $donecc = mysqli_query($conn, "DELETE FROM course_class WHERE classid='$del'");
    if ($donec && $donecc) { //done
        if (mysqli_affected_rows($conn) > 0) {
            $msgcl = "<div class='alert alert-warning'><i class='icon-check icon-large'></i> &nbsp;Class successifully removed!</div>";
        }
    }
}
if (isset($_GET['subid'])) {
    $sub = $_GET['subid'];
    $room = $_GET['roomid'];
    $tslot = $_GET['slotid'];
    $day = $_GET['dayid'];
    $subname = $_GET['subject_title'];
    $done = mysqli_query($conn, "DELETE FROM schedule WHERE timeslot=$tslot and roomid=$room and dayid=$day AND subject_id=$sub AND sem='$sem'");
    if ($done) { //done
        if (mysqli_affected_rows($conn) > 0) {
            $msgP = "<div class='alert alert-warning'><i class='icon-check icon-large'></i> &nbsp; {$subname}  Removed from schedule successifully!</div>";

            $getsub = mysqli_query($conn, "SELECT * FROM subject WHERE subject_id='$sub'");
            $Sessions = mysqli_fetch_assoc($getsub);

            if ($Sessions['allocated'] == 2) {
                mysqli_query($conn, "UPDATE subject SET allocated=1 WHERE subject_id='$sub'");
                mysqli_query($conn, "UPDATE checker SET slots=1 WHERE courseid='$sub'");
            } else {
                mysqli_query($conn, "UPDATE subject SET allocated=0 WHERE subject_id='$sub'");
                mysqli_query($conn, "DELETE FROM checker  WHERE courseid='$sub'");
            }
        }
    } //close done
}
if (isset($_POST['saveRoom'])) {
    $roomName = $_POST['roomname'];
    $duproom = mysqli_query($conn, "SELECT room FROM rooms WHERE room ='$roomName'");
    if (mysqli_num_rows($duproom) == 0) {
        mysqli_query($conn, "INSERT INTO rooms(room)
		values('$roomName')") or die(mysqli_error($conn));

        $msg = "<span class='alert alert-success'><i class='icon-check icon-large'></i> &nbsp;Room {$roomName} is added successifully</span>";
    } else
        $msg = "<span class='alert alert-danger'><i class='icon-check icon-large'></i> &nbsp;Room {$roomName} is already added</span>";

}

if (isset($_POST['addClass'])) {
    $className = $_POST['class'];
    $dupclass = mysqli_query($conn, "SELECT  classname  FROM classes WHERE classname ='$className'");
    if (mysqli_num_rows($dupclass) == 0) {
        mysqli_query($conn, "INSERT INTO classes(classname)
		values('$className')") or die(mysqli_error($conn));

        $msgcl = "<span class='alert alert-success'><i class='icon-check icon-large'></i> &nbsp;Class {$className} is added successifully</span>";
    } else
        $msgcl = "<span class='alert alert-danger'>Class {$className} is already added</span>";

}
if (isset($_GET['id'])) {
    $del = $_GET['id'];
    $done = mysqli_query($conn, "DELETE FROM rooms WHERE id='$del'");
    $done = mysqli_query($conn, "DELETE FROM schedule WHERE roomid='$del'");
    $done = mysqli_query($conn, "DELETE FROM examvenues WHERE id='$del'");
    if ($done) { //done
        if (mysqli_affected_rows($conn) > 0) {
            $msgc = "<div class='alert alert-success'><i class='fas fa-check-circle'></i> &nbsp;Room  successifully removed!</div>";
        }
    }
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
                                <strong><i class="icon-calendar icon-large"></i>&nbsp;Timetable Settings</strong>
                            </div>
                            <div class="hero-unit-3" style="margin-top:10px">

                                <div class="alert alert-info">
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                    <strong><i class="icon-home icon-large"></i>&nbsp;Add class rooms</strong>
                                </div>
                                <form class="form-inline" method="POST">
                                    <div class="control-group" style="float:left; padding-right:5px">
                                        <div class="controls">
                                            <input type="text" name="roomname" placeholder="enter room name" required>
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

                            <div class="hero-unit-3" style="margin-top:10px; max-height: 250px; overflow-y: scroll;">

                                <div class="alert alert-info">
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                    <strong><i class="icon-home icon-large"></i>&nbsp;Added Rooms
                                    </strong>
                                </div>

                                <table cellpadding="0" cellspacing="0" border="0"
                                    class="table table-striped table-bordered table-hover" width="20%">
                                    <thead>
                                        <tr>
                                            <th>Room Name</th>
                                            <th>Remove Room</th>


                                        </tr>
                                    </thead>
                                    <tbody>


                                        <?php
                                        $sql = "SELECT * from rooms";
                                        $find = mysqli_query($conn, $sql);

                                        //f(mysql_affected_rows($find)>0){
                                        
                                        while ($rows = mysqli_fetch_assoc($find)) {
                                            ?>
                                            <tr>
                                                <td>
                                                    <?php echo $rows['room'] ?>
                                                </td>
                                                <td>
                                                    <a onclick="return confirm('This action will result into removing the room, teaching and exam courses scheduled in this room in your timetables!Do you wish to continue?')"
                                                        class="btn btn-danger"
                                                        href="ttSetings.php?id=<?php echo $rows['id'] ?>">
                                                        <i class="fas fa-remove"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <?php
                                        }

                                        ?>

                                    </tbody>
                                </table>

                                <div>
                                    <?php if (isset($msgc))
                                        echo $msgc;
                                    unset($msgc); ?>
                                </div>
                            </div>

                            <div class="hero-unit-3" style="margin-top:10px">

                                <div class="alert alert-info">
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                    <strong><i class="icon-group icon-large"></i>&nbsp;Add class</strong>
                                </div>
                                <form class="form-inline" method="POST">
                                    <div class="control-group" style="float:left; padding-right:5px">
                                        <div class="controls">
                                            <input type="text" name="class" placeholder="enter class name">
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
                                    <strong><i class="icon-plus-sign icon-large"></i>&nbsp;Add a Course to
                                        a
                                        Class</strong>
                                </div>
                                <!-- start form -->
                                <table cellpadding="0" cellspacing="0" border="0"
                                    class="table table-striped table-bordered table-hover" id="example">
                                    <thead>
                                        <tr>
                                            <th>Course Name</th>
                                            <th>Action</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $find = mysqli_query($conn, "SELECT * FROM classes");
                                        //f(mysql_affected_rows($find)>0){
//f(mysql_affected_rows($find)>0){
                                        
                                        while ($rows = mysqli_fetch_assoc($find)) {
                                            $class_id = $rows['classid'];
                                            ?>
                                            <tr>
                                                <td>
                                                    <?php echo $rows['classname'] ?>
                                                </td>
                                                <td>
                                                    <a class="btn btn-info" href="setClassCourse.php?cid=<?php echo $class_id ?>&cname=
<?php echo $rows['classname'] ?>"><i class="icon icon-plus-sign icon-large"></i>&nbsp;</a>


                                                </td>
                                                <td><a onclick="return confirm('The class and its associated data will be deleted. Do you want to proceed?')"
                                                        class="btn btn-danger"
                                                        href="ttSetings.php?delid=<?php echo $class_id ?>"><i
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
                                    <strong><i class="fa-list-check icon-large"></i>&nbsp;Set time table
                                        Preferences</strong>

                                </div>


                                <div class="control-group" style="float:left; padding-right:5px">

                                    <div class="controls">
                                        <select id="pcourse" required>
                                            <option value="">Select course</option>
                                            <?php
                                            $sql = "SELECT teacher.lastname, teacher.teacher_id, teacher.firstname, subject.subject_title, subject.subject_id
        FROM teacher 
        INNER JOIN subject ON teacher.teacher_id = subject.teacher_id WHERE subject.ext=0  order by subject.subject_title asc";
                                            $find = mysqli_query($conn, $sql);

                                            //f(mysql_affected_rows($find)>0){
                                            
                                            while ($rows = mysqli_fetch_assoc($find)) {
                                                ?>
                                                <option value="<?php echo $rows['subject_id'] ?>">
                                                    <?php echo $rows['subject_title'] ?>
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
                                        <select id="pday" required>
                                            <option value="">Select day </option>

                                            <?php
                                            $find = mysqli_query($conn, "SELECT * FROM week_days");
                                            //f(mysql_affected_rows($find)>0){
                                            
                                            while ($rows = mysqli_fetch_assoc($find)) {
                                                ?>
                                                <option value="<?php echo $rows['id'] ?>">
                                                    <?php echo $rows['day'] ?>
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
                                        <select id="proom" required>
                                            <option value="">Select room</option>

                                            <?php
                                            $find = mysqli_query($conn, "SELECT * FROM rooms");
                                            //f(mysql_affected_rows($find)>0){
                                            
                                            while ($rows = mysqli_fetch_assoc($find)) {
                                                ?>
                                                <option value="<?php echo $rows['id'] ?>">
                                                    <?php echo $rows['room'] ?>
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
                                        <select id="pslot" required>
                                            <option value="">Select slot</option>

                                            <option value="0">8:00-9:30</option>
                                            <option value="1">9:30-11:00</option>
                                            <option value="2">11:00-12:30</option>
                                            <option value="3">12:30-2:00</option>
                                            <option value="4">2:00-3:30 </option>
                                            <option value="5">3:30-5:00 </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <div class="controls">

                                        <button type="submit" id="setpref" role="button" class="btn btn-info">
                                            <i class="icon-save icon-large"></i>&nbsp;&nbsp;Set
                                        </button>

                                        <script>
                                            $(document).ready(function () {
                                                $("#setpref").click(function () {
                                                    $("#msg").html("Please wait...");
                                                    $.getJSON("ttdoWork.php", {
                                                        pcourse: $("#pcourse").val(),
                                                        proom: $("#proom").val(),
                                                        pday: $("#pday").val(),
                                                        pslot: $("#pslot").val()
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
                                    <strong><i class="icon-calendar "></i>&nbsp; Prefered
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
                                            <th>Code</th>
                                            <th>Course Name</th>
                                            <th>Slot</th>
                                            <th>Day </th>
                                            <th>Room</th>
                                            <th>Action</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $find = mysqli_query($conn, "SELECT * FROM subject WHERE allocated != 0");
                                        while ($row = mysqli_fetch_assoc($find)) {
                                            $subid = $row['subject_id'];
                                            $subname = $row['subject_title'];
                                            $find2 = mysqli_query($conn, "SELECT * FROM schedule WHERE subject_id='$subid'");
                                            mysqli_data_seek($find2, 0);
                                            while ($rows = mysqli_fetch_assoc($find2)) {
                                                $roomid = $rtag = $rows['roomid'];
                                                $slotid = $stag = $rows['timeslot'];
                                                $dayid = $dtag = $rows['dayid'];
                                                $rtag = ($rtag == 0) ? "NOT SET" : $rows['roomid'];
                                                $stag = ($stag == 10 || $stag == 0) ? "NOT SET" : $rows['timeslot'];
                                                $dtag = ($dtag == 0) ? "NOT SET" : $rows['dayid'];
                                                if ($dtag != 0) {
                                                    $fiday = mysqli_query($conn, "SELECT * FROM week_days  WHERE id='$dtag' ");
                                                    $day = mysqli_fetch_assoc($fiday);
                                                    $dtag = $day['day'];
                                                }
                                                if ($rtag != 0) {
                                                    $findroom = mysqli_query($conn, "SELECT room FROM rooms WHERE id='$rtag' ");
                                                    $r = mysqli_fetch_assoc($findroom);
                                                    $rtag = $r['room'];
                                                }


                                                switch ($stag) {
                                                    case 0:
                                                        $stag = "8:00-9:30";
                                                        break;
                                                    case 1:
                                                        $stag = "9:30-11:00";
                                                        break;
                                                    case 2:
                                                        $stag = "11:00-12:30";
                                                        break;
                                                    case 3:
                                                        $stag = "12:30-2:00";
                                                        break;
                                                    case 4:
                                                        $stag = "2:00-3:30";
                                                        break;
                                                    case 5:
                                                        $stag = "8:00-9:30";
                                                        break;

                                                }

                                                ?>
                                                <tr>
                                                    <td>
                                                        <?php echo $row['subject_code'] ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $row['subject_title'] ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $stag ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $dtag ?>

                                                    </td>
                                                    <td>
                                                        <?php echo $rtag ?>
                                                    </td>
                                                    <td><a onclick="return confirm('Are you sure you want to remove this schedule?')"
                                                            tootip="Remove" class="btn btn-danger"
                                                            href="ttSetings.php?subid=<?php echo $subid ?>&dayid=<?php echo $dayid ?>&slotid=<?php echo $slotid ?>&roomid=<?php echo $roomid ?>&subject_title=<?php echo $subname ?>">
                                                            <i class="icon icon-remove icon-large"></i></a>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
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