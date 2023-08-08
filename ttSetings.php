<?php
require_once('header.php');
require_once('connect.php');
require_once('ttFunctions.php');
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
if (isset($_GET['did'])) {
    $del = $_GET['did'];
    $donec = mysqli_query($conn, "DELETE FROM rooms WHERE id='$del'");
    $donecc = mysqli_query($conn, "DELETE FROM course_room WHERE roomid='$del'");
    $donecc = mysqli_query($conn, "DELETE FROM schedule WHERE roomid='$del'");
    if ($donec && $donecc) { //done
        if (mysqli_affected_rows($conn) > 0) {
            $msgcl = "<div class='alert alert-warning'><i class='icon-check icon-large'></i> &nbsp;Class successifully removed!</div>";
        }
    }
}
if (isset($_POST['saveRoom'])) {
    $roomName = $_POST['roomname'];
    $capacity = $_POST['capacity'];
    $location = $_POST['location'];
    $duproom = mysqli_query($conn, "SELECT room FROM rooms WHERE room ='$roomName' AND location='$location'");
    if (mysqli_num_rows($duproom) == 0) {
        mysqli_query($conn, "INSERT INTO rooms(room,capacity,location)
		values('$roomName','$capacity','$location')") or die(mysqli_error($conn));

        $msg = "<span class='alert alert-success'><i class='fas fa-check-circle icon-large'></i> &nbsp;Room $roomName located at $location is added successifully</span>";
    } else {
        $duproom2 = mysqli_query($conn, "SELECT room FROM rooms WHERE room ='$roomName' and capacity='$capacity' and location='$location'");
        if (mysqli_num_rows($duproom) == 0) {
            $msg = "<span class='alert alert-danger'><i class='icon-check icon-large'></i> &nbsp;Room $roomName with capacity $capacity at located at $location is already added</span>";
        }
        else
        {
            mysqli_query($conn, "UPDATE rooms SET capacity='$capacity' WHERE room='$roomName' and location='$location'") or die(mysqli_error($conn));
            $msg = "<span class='alert alert-success'><i class='fas fa-check-circle icon-large'></i> &nbsp;Capacity for $roomName located at $location updated to $capacity </span>";
        }

    }
}
//start set room
if (isset($_POST['saveRoomPref'])) {
    $roomId = $_POST['proom'];
    $course = $_POST['pcourse'];
    $duproom = mysqli_query($conn, "SELECT * FROM course_room WHERE roomid ='$roomId' and course='$course'") or die(mysqli_error($conn));
    if (mysqli_num_rows($duproom) == 0) {
        if(checkRoomCompatibility($conn,$roomId,$course)==1){
           
            mysqli_query($conn, "INSERT INTO course_room(roomid,course) values('$roomId','$course')") or die(mysqli_error($conn));

            if (mysqli_affected_rows($conn) > 0) {
                $msg2 = "<span class='alert alert-success'><i class='fas fa-check-circle icon-large'></i> &nbsp;course assigned </span>";
            }
        } else {
            $msg2 = "<span class='alert alert-danger'><i class='icon-remove-sign'></i> &nbsp;The number of students for the course can not fit in the selected room! Please select another room</span>";
        }
    }
    else {
            $msg2 = "<span class='alert alert-danger'><i class='icon-remove-sign icon-large'></i> &nbsp;room already assigned to that course </span>";
        }

}
//end set room
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
if (isset($_GET['delid'])) {
    $del = $_GET['delid'];
    $done = mysqli_query($conn, "DELETE FROM course_room WHERE roomid='$del'");
    if ($done) { //done
        if (mysqli_affected_rows($conn) > 0) {
            $mg = "<div class='alert alert-success'><i class='fas fa-check-circle'></i> &nbsp;Deleted  successifully!</div>";
        }
    }
}
if (isset($_GET['tecset'])) {
    $tid = $_GET['tecset'];
    $getStatus = mysqli_query($conn, "SELECT ext FROM subject  WHERE subject_id=$tid AND ext=1");
    if (mysqli_num_rows($getStatus) == 0) //update to 1
        mysqli_query($conn, "UPDATE subject SET ext=1 WHERE subject_id=$tid");
    else
        mysqli_query($conn, "UPDATE subject SET ext=0 WHERE subject_id=$tid");
}
if (isset($_GET['exaset'])) {
    $exad = $_GET['exaset'];
    $getStatus = mysqli_query($conn, "SELECT exm FROM subject  WHERE subject_id=$exad AND exm=1");
    if (mysqli_num_rows($getStatus) == 0) //update to 1
        mysqli_query($conn, "UPDATE subject SET exm=1 WHERE subject_id=$exad");
    else
        mysqli_query($conn, "UPDATE subject SET exm=0 WHERE subject_id=$exad");
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
                    <div class="span12" style="border:1px; width:107%;  margin-top:20px; ">
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
                                    <strong><i class="icon-home icon-large"></i>&nbsp;Add Class Rooms</strong>
                                </div>
                                <form class="form-inline" method="POST">
                                    <div class="control-group" style="float:left; padding-right:5px">
                                        <div class="controls">
                                            <input type="text" name="roomname" placeholder="Enter room name" required>
                                             <input type="number" name="capacity" placeholder="Enter capacity" required>
                                             <input type="text" name="location" placeholder="location" required>
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

                            <div class="hero-unit-3" style="margin-top:10px; height:300px; overflow-y:scroll">

                                <div class="alert alert-success">
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                    <strong><i class="icon-home icon-large"></i>&nbsp;Added Rooms
                                    </strong>
                                </div>

                                <table cellpadding="0" cellspacing="0" 
                                    class="table table-striped table-bordered table-hover examples">
                                    <thead>
                                        <tr>
                                            <th>Room Name</th>
                                            <th>Capacity</th>
                                             <th>Location</th>
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
                                                     <td>
                                                    <?php echo $rows['capacity'] ?>
                                                </td>
                                                <td>
                                                    <?php echo $rows['location'] ?>
                                                </td>
                                                <td>
                                                    <a onclick="return confirm('This action will result into removing the room, teaching and exam courses scheduled in this room in your timetables!Do you wish to continue?')"
                                                        class="btn btn-danger"
                                                        href="ttSetings.php?did=<?php echo $rows['id'] ?>">
                                                        <i class="fas fa-trash"></i>
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
                                    <!-- start assign room -->
 <div class="hero-unit-3" style="margin-top:10px">

                                <div class="alert alert-info">
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                    <strong><i class="icon-home icon-large"></i>&nbsp;Assign Courses to Prefered Rooms</strong>
                                </div>
                                <form class="form-inline" method="POST">
                                    <div class="control-group" style="float:left; padding-right:5px">
                                        <div class="controls">
                                            <select name="pcourse" required>
                                            <option value="">Select course</option>
                                            <?php
                                                $sql = "SELECT * FROM subject
        INNER JOIN teacher ON subject.teacher_id = teacher.teacher_id  WHERE subject.ext=0  order by subject.subject_title asc";
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
                                             <select name="proom" required>
                                            <option value="">Select room</option>

                                            <?php
                                                $find = mysqli_query($conn, "SELECT * FROM rooms");
                                                //f(mysql_affected_rows($find)>0){
                                                
                                                while ($rows = mysqli_fetch_assoc($find)) {
                                                    ?>
                                                    <option value="<?php echo $rows['id'] ?>"><?php echo $rows['room']?>
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
                                            <button type="submit" name="saveRoomPref" role="button" class="btn btn-info">
                                                <i class="icon-plus-sign icon-large"></i>&nbsp;&nbsp;Add</button>
                                        </div>
                                    </div>
                                </form>

                                <div>
                    <?php if (isset($msg2))
            echo $msg2;
        unset($msg2); ?>
    </div>
    <!-- end slider -->
</div>
                                   
<!-- start show course assigned room -->
<div class="hero-unit-3" style="margin-top:10px; height:300px; overflow-y:scroll">

                                <div class="alert alert-success">
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                    <strong><i class="icon-home icon-large"></i>&nbsp;Assigned courses to rooms
                                    </strong>
                                </div>

                                <table cellpadding="0" cellspacing="0" 
                                    class="table table-striped table-bordered table-hover examples">
                                    <thead>
                                        <tr>
                                            <th>Room Name</th>
                                            <th>Location</th>
                                            <th>Assigned Course</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>


                       <?php
            $sql = "SELECT * from rooms INNER JOIN course_room ON rooms.id=course_room.roomid INNER JOIN subject ON subject.subject_id=course_room.course ";
            $find = mysqli_query($conn, $sql) or die(mysqli_error($conn));

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

                        <?php echo $rows['subject_title'] ?>
                    </td>
                    
                    <td>
                        <a onclick="return confirm('This action will remove the course from the assigned class.Do you wish to continue?')"
                            class="btn btn-danger" href="ttSetings.php?delid=<?php echo $rows['id'] ?>">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>
                <?php
            }

            ?>

        </tbody>
    </table>
    <?php if (isset($mg))
        echo $mg;
    unset($mg); ?>
</div>
<!--end assigned course room -->

<!--end assign room -->




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
                            <div class="hero-unit-3" style="margin-top:10px;height:300px; overflow-y:scroll">

                                <div class="alert alert-success">
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

                            <!--start inc/ex -->

                            
                            <div class="hero-unit-3" style="margin-top:10px;height:300px; overflow-y:scroll">

                                <div class="alert alert-info">
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                    <strong><i class="icon-home icon-large"></i>&nbsp;Include or exclude courses from
                                        timetable</strong>
                                </div>
                                <table cellpadding="0" cellspacing="0" border="0"
                                    class="table table-striped table-bordered examples">
                                    <thead>
                                        <tr>
                                            <th rowspan="2">Code</th>
                                            <th rowspan="2">subject Name</th>
                                            <th>Teaching</th>
                                            <th>Exam</th>
                                            <th>Teaching</th>
                                            <th>Exam</th>
                                        </tr>
                                        <tr>
                                            <td>Excluded</td>
                                            <td>Excluded</td>
                                            <td>Include/Exclude</td>
                                            <td>Include/Exclude</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                        <?php
                                        
                                        $find = mysqli_query($conn, "SELECT * FROM subject WHERE teacher_id!=0");
                                        //f(mysql_affected_rows($find)>0){
//f(mysql_affected_rows($find)>0){
                                        
                                        while ($rows = mysqli_fetch_assoc($find)) {
                                            $id = $rows['subject_id'];
                                            $t = $rows['ext'];
                                            $e = $rows['exm'];
                                            if ($t == 0)
                                                $tag = "NO";
                                            else
                                                $tag = "YES";
                                            $etag = ($e == 0) ? "NO" : "YES";
                                            ?>
                                            <tr>
                                                <td>
                                                    <?php echo $rows['subject_code'] ?>
                                                </td>
                                                <td>
                                                    <?php echo $rows['subject_title'] ?>
                                                </td>
                                                <td>
                                                    <?php echo $tag ?>
                                                </td>
                                                <td>
                                                    <?php echo $etag ?>
                                                </td>
                                                <td>
                                                    <a <?php if ($t == 0) { ?> class="btn btn-success" <?php $txt = "Exclude";
                                                    } else { ?> class="btn btn-danger" <?php $txt = "Include";
                                                    } ?>
                                                        href="ttSetings.php?tecset=<?php echo $id ?>"><?php echo $txt ?></a>
                                                </td>
                                                <td>
                                                    <a <?php if ($e == 0) { ?> class="btn btn-success" <?php $etxt = "Exclude";
                                                    } else { ?> class="btn btn-danger" <?php $etxt = "Include";
                                                    } ?>
                                                        href="ttSetings.php?exaset=<?php echo $id ?>"><?php echo $etxt ?></a>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                    
                                    </tbody>
                                </table>
                                <!-- end slider -->
                            </div>

                            <!-- end inc/exc -->


                                                </div> <!-- closing wrapper-->
                    </div>
                </div>

                <?php include('footer.php'); ?>
            </div>

        </div>
    </div>
</body>

</html>