<?php
require_once('connect.php');
require_once('ttFunctions.php');
$clashchecker = array();
$currentRoomID = $_GET['proom'];
$currentDayID = $_GET['pday'];
$slot = $_GET['pslot'];
$courseid = $_GET['pcourse'];
$sem = showCurrentSem($conn);

$findTeacher = mysqli_query($conn, "SELECT * 
        FROM wendcourses
        INNER JOIN teacher  ON wendcourses.teacher_id=teacher.teacher_id   WHERE wendcourses.subject_id='$courseid' and sem='$sem'");
$theTeacher = mysqli_fetch_assoc($findTeacher);
$teacher_id = $theTeacher['teacher_id'];
$teacherf = $theTeacher['firstname'];
$teacherl = $theTeacher['lastname'];
$course = $theTeacher['subject_title'];
//check if course already allocated to another room
$duproom = mysqli_query($conn, "SELECT * FROM course_room WHERE roomid ='$currentRoomID' and course='$courseid'") or die(mysqli_error($conn));
if (mysqli_num_rows($duproom) != 0) {
    echo json_encode(["res" => "<div class='alert alert-danger' style='text-align:left'> <i class='icon-remove-sign'></i> &nbsp; {$course} is allocated to another room in the main settings you can not allocate it in a different room, please verify in settings</div>"]);
} else { //room duplicate not there proceed
    if (checkRoomCompatibility($conn, $currentRoomID, $courseid) == 0) { //check if students can fit into the selected room
        echo json_encode(["res" => "<div class='alert alert-danger' style='text-align:left'> <i class='icon-remove-sign'></i> &nbsp; {$course} has a higher number of students than the capacity of the room selected</div>"]);
    } else { //proceed students can fit into the selected room
        $checkroom = mysqli_query($conn, "SELECT allocatedcourse FROM schedule_wend WHERE dayid='$currentDayID' and timeslot='$slot' AND
        roomid='$currentRoomID' AND sem='$sem'") or die(mysqli_error($conn));
        if (mysqli_num_rows($checkroom) > 0) {
            $c = mysqli_fetch_assoc($checkroom);
            $cn = $c['allocatedcourse'];
            if ($cn != "") {
                echo json_encode(["res" => "<div class='alert alert-danger' style='text-align:left'> <i class='icon-remove-sign'></i> &nbsp;Clash will occourse allocating <font color='green'>{$course} </font>at the requested schedule because there is <font color='green'>$cn</font> alreadyat that schedule! please select a different room</div>"]);

            }
        } else { //no room clash
            $checks = mysqli_query($conn, "SELECT * FROM checker_wend WHERE courseid='$courseid' and slots=2 AND sem='$sem'");
            if (mysqli_num_rows($checks) > 0) { // check sessions

                echo json_encode(array("res" => "<div class='alert alert-danger'> <i class='icon-remove-sign'></i> &nbsp; {$course} is already scheduled twice</div>"));
            } else { //schedule the course
                $getSchedule = mysqli_query($conn, "SELECT * FROM schedule_wend WHERE sem='$sem'");
                while ($row = mysqli_fetch_assoc($getSchedule)) {
                    $clashchecker[] = $row;
                }
                $classClashChecker = checkClassClash2($clashchecker, $conn, $courseid, $currentDayID, $slot);
                //START CHECK FOR TEACHER CLASHs
                $teacherClashChecker = checkTeacherClash2($clashchecker, $teacher_id, $currentDayID, $slot, $sem);
                if (($classClashChecker == false) && ($teacherClashChecker == false)) { //no crash will occour proceed

                    doScheduleWend(
                        $conn,
                        $courseid,
                        $currentDayID,
                        $currentRoomID,
                        $slot,
                        $course,
                        $teacher_id,
                        $teacherf,
                        $teacherl,
                        $sem
                    );

                    echo json_encode(array("res" => "<div class='alert alert-success'><i class='fas fa-check-circle icon-large'></i> &nbsp;{$course}  Scheduled successifully! Please reflesh the page to see below</div>"));
                } //end proceed
                else {

                    echo json_encode(array("res" => "<div class='alert alert-danger'><i class='icon-remove-sign'></i> &nbsp;The requested schedlue will result in a clash, please choose another slot</div>"));
                }
            } //end schedule the course
            //echo json_encode(array("ms" => "Ireached the server"));
        } //end room clash check
    } //end check if students can fitt into the room
} //end check room duplicate

//end set pref

?>