<?php
require_once('connect.php');
require_once('ttFunctions.php');
$examDays;
$sessionsNum;
$sessionsPerCourse;
$coursesPerDay;
$sdate = $_GET['start_date'];
$edate = $_GET['end_date'];
$start_date = new DateTime($_GET['start_date']);
$end_date = new DateTime($_GET['end_date']);
$interval = $start_date->diff($end_date);
$num_days = $interval->format('%a');
$num_days = $num_days + 1;
$current_date = clone $start_date;
$today = Date('Y-m-d');
$today = new DateTime($today);
$td = $today->format("l, j F Y");
if ($sdate == '' || $edate == '') {
    echo json_encode(
        array(
            "res" => "<div class='alert alert-danger'> <i class='fas fa-circle-exclamation'></i> &nbsp;Please select start and end date</div>"
        )
    );
} else {
    if (($start_date < $today) || ($end_date < $today)) {
        echo json_encode(
            array(
                "res" => "<div class='alert alert-danger'> <i class='fas fa-circle-exclamation'></i> &nbsp;Please select dates that are not less than today {$td}</div>"
            )
        );
    } else {
        if ($end_date <= $start_date) {
            echo json_encode(
                array(
                    "res" => "<div class='alert alert-danger'> <i class='fas fa-circle-exclamation'></i> &nbsp;End date can
        not be less than  or equal to start date</div>"
                )
            );
        } else {

            $scheduleDetails = array();
            $sql = "SELECT *
        FROM teacher 
        INNER JOIN subject ON teacher.teacher_id = subject.teacher_id WHERE subject.exm=0 AND subject.allocatedExam=0";
            $result = mysqli_query($conn, $sql);
            $teacherCourses = array();

            while ($row = mysqli_fetch_assoc($result)) {
                $teacherCourses[] = $row;
            }

            $scheduleDetails = getSchedule($start_date, $end_date, $teacherCourses, $num_days, $conn);
            $examDays = $scheduleDetails['examDays'];
            $holidays = $scheduleDetails['holidays'];
            $sessionsPerCourse = $scheduleDetails['coursePerSession'];
            $coursesPerDay = $scheduleDetails['coursesPerDay'];
            $examDays = $scheduleDetails['examDays'];
            $totalCourses = $scheduleDetails['totalcourses'];
            $weeks = $scheduleDetails['weekends'];
            $i = 1;
            while ($current_date <= $end_date) {
                // Check if the current date is a holiday
                $holiday_dates = get_holidays($current_date->format('Y'));
                $is_holiday = in_array($current_date->format('Y-m-d'), $holiday_dates);
                // Skip the iteration if the current date is a holiday
                if ($is_holiday) {
                    //echo "Holiday{$holidays}" .$current_date->format("D,M d, Y") . "<br>";
                    $current_day_of_week = $current_date->format('w');
                    // If the holiday falls on a Saturday or Sunday, skip the next Monday
                    if ($current_day_of_week == 6 || $current_day_of_week == 0) {
                        if ($current_day_of_week == 6) {
                            $current_date->modify('next Monday');
                        } else {
                            $current_date->modify('+2 days');
                            $i++;
                        }

                    } else {
                        $current_date->modify('+1 day');
                    }
                    continue;
                }

                // Display the current date
                if ($current_date->format('w') != 6) { //if not saturday
                    if ($current_date->format('w') == 0) { //if sunday
                        $i++;
                    } //close if sunday
                    else { //not weekend
                        $sesions = mysqli_query($conn, "Select * FROM examsessions");
                        $sessionsNum = mysqli_num_rows($sesions);
                        if ($sessionsNum == 0) { //if no sessions are available
                            echo json_encode(
                                [
                                    "res" => "<div class='alert alert-danger'> <i class='fas fa-circle-exclamation'></i> &nbsp;No sessions defined, please set sessions first</div>"
                                ]
                            );
                        } //close if no sessions are available
                        else { //sessions are available
                            $roomsArray = [];

                            while ($sess = mysqli_fetch_assoc($sesions)) { //session = sessions set by user
                                //echo count($teacherCourses);
                                $roomQuery = "SELECT * FROM examvenues INNER JOIN rooms ON examvenues.room=rooms.room";
                                $rooms = $conn->query($roomQuery);
                                while ($room = $rooms->fetch_assoc()) {
                                    $roomsArray[] = $room;
                                }
                                $clashchecker = array();
                                $sessionid = $sess['id'];
                                $thedate = $current_date->format('Y-m-d');
                                $getSchedule = mysqli_query($conn, "SELECT * FROM examschedule WHERE edate='$thedate' AND sessionid='$sessionid'
                        AND exam_week='$i'");
                                while ($row = mysqli_fetch_assoc($getSchedule)) {
                                    $clashchecker[] = $row['courseid'];
                                }

                                if ($rooms->num_rows > 0) { //open if there are rooms assigned

                                    // Shuffle the rooms array to pick rooms at random

                                    for ($j = 1; $j <= $sessionsPerCourse; $j++) { //loop courses
                                        if (count($teacherCourses) > 0) { //check if array is valid
                                            $randomIndex = array_rand($teacherCourses);
                                            $randomCourse = $teacherCourses[$randomIndex];
                                            $course = $randomCourse['subject_title'];
                                            $courseid = $randomCourse['subject_id'];
                                            $noOfStudents = $randomCourse['students'];
                                            $allocated = false;
                                            $randomRoomIndex = array_rand($roomsArray);
                                            $randomRoom = $roomsArray[$randomRoomIndex];
                                            $roomCapacity = $randomRoom['capacity'];
                                            $roomId = $randomRoom['id'];
                                            if ($roomCapacity >= $noOfStudents) { // open capacity ok
                                                $foundClash = checkClassClashExam($clashchecker, $conn, $courseid);
                                                if ($foundClash == false) { // start no clash will occour proceed
                                                    //echo "<li> $course</li>"; 
                                                    $newCapacity = $roomCapacity - $noOfStudents;
                                                    $roomsArray[$randomRoomIndex]['capacity'] = $newCapacity;
                                                    mysqli_query($conn, "INSERT INTO examschedule (edate,courseid,course,sessionid,exam_week,roomid,round) 
            VALUES('$thedate','$courseid','$course','$sessionid','$i','$roomId',1)");
                                                    mysqli_query($conn, "UPDATE examschedule SET rspace='$newCapacity' WHERE edate='$thedate' AND sessionid='$sessionid' AND 
                                                exam_week='$i' AND roomid='$roomId'") or die(mysqli_error($conn));
                                                    $clashchecker[] = $courseid;
                                                    unset($teacherCourses[$randomIndex]);
                                                    $teacherCourses = array_values($teacherCourses);

                                                } //close no clash will occour
                                            } //close capacity ok
                                        } //close check if array is ok
                                    } //close loop courses
                                } //close if rooms are assigned
                                else { // no rooms message
                                    echo json_encode(
                                        array(
                                            "res" => "<div class='alert alert-danger'> <i class='fas fa-circle-exclamation'></i> &nbsp;No rooms are availabe please assign rooms</div>"
                                        )
                                    );
                                } //close no rooms message
                            } //close for loop session
                        } //close sessions are available
                    } //close not weekend
                } //close if not saturday
                $current_date->modify('+1 day');
            }
            $lCourses = count($teacherCourses);
            if ($lCourses > 0) //reallocate left courses
            {
                /*
                $lCosPerDay = round(($lCourses / $examDays));
                $lCosPsess = round(($lCosPerDay / $sessionsNum));
                */
                $find_weeks = mysqli_query($conn, "SELECT distinct exam_week FROM examschedule");
                while ($wrow = mysqli_fetch_assoc($find_weeks)) {
                    $eWeek = $wrow['exam_week'];
                    $find_date = mysqli_query($conn, "SELECT distinct edate FROM examschedule WHERE exam_week='$eWeek'");
                    mysqli_data_seek($find_date, 0);
                    while ($dates = mysqli_fetch_assoc($find_date)) { //dates
                        $sesions = mysqli_query($conn, "Select * FROM examsessions");
                        $clashchecker = array();
                        //mysqli_data_seek($sesions, 0);
                        $roomsArray = [];

                        while ($sess = mysqli_fetch_assoc($sesions)) {
                            //******************************************************* */
                            $sessionid = $sess['id'];
                            $eDate = $dates['edate'];
                            $roomQuery = "SELECT roomid,rspace FROM examschedule  WHERE edate='$eDate'  AND exam_week='$eWeek' AND sessionid='$sessionid'
                            AND rspace > 0";
                            $rooms = $conn->query($roomQuery);
                            while ($room = $rooms->fetch_assoc()) {
                                $roomsArray[] = $room;
                            }
                            if ($rooms->num_rows > 0) { //open if there are rooms assigned


                                for ($j = 1; $j <= $sessionsPerCourse; $j++) { //possible number of courses to insert
                                    if (count($teacherCourses) > 0) { //check if array is valid
                                        $randomIndex = array_rand($teacherCourses);
                                        $randomCourse = $teacherCourses[$randomIndex];
                                        $course = $randomCourse['subject_title'];
                                        $courseid = $randomCourse['subject_id'];
                                        $noOfStudents = $randomCourse['students'];

                                        $getSchedule = mysqli_query($conn, "SELECT * FROM examschedule WHERE edate='$eDate' AND sessionid='$sessionid'
                        AND exam_week='$eWeek'");
                                        while ($row = mysqli_fetch_assoc($getSchedule)) {
                                            $clashchecker[] = $row['courseid'];
                                        }
                                        //*************************************************************************** */

                                        $randomRoomIndex = array_rand($roomsArray);
                                        $randomRoom = $roomsArray[$randomRoomIndex];
                                        $roomCapacity = $randomRoom['rspace'];
                                        $roomId = $randomRoom['roomid'];
                                        if ($roomCapacity >= $noOfStudents) { // open capacity ok
                                            //************************************************************************* */
                                            $foundClash = checkClassClashExam($clashchecker, $conn, $courseid);
                                            if ($foundClash == false) { //if no clash will occour
                                                //echo "<li> $course</li>";
                                                mysqli_query($conn, "INSERT INTO examschedule (edate,courseid,course,sessionid,exam_week,roomid,round) 
            VALUES('$eDate','$courseid','$course','$sessionid','$eWeek','$roomId',2)");
                                                $newCapacity = $roomCapacity - $noOfStudents;
                                                $roomsArray[$randomRoomIndex]['rspace'] = $newCapacity;
                                                mysqli_query($conn, "UPDATE examschedule SET rspace='$newCapacity' WHERE edate='$eDate' AND sessionid='$sessionid' AND 
                                                exam_week='$eWeek' AND roomid='$roomId'") or die(mysqli_error($conn));
                                                $clashchecker[] = $courseid;
                                                unset($teacherCourses[$randomIndex]);
                                                $teacherCourses = array_values($teacherCourses);

                                            } //close if no clash
                                        } //close if capacity ok
                                    } //close array is valid
                                } //close possible number of courses
                            } //close if rooms are assigned
                        } //close while session
                    } //end current date
                } //end weeks
            } //end count >0
            $left = count($teacherCourses);
            if ($left == 0) {
                echo json_encode(
                    [
                        "res" => "<div class='alert alert-success'> <i class='fas fa-check-circle'></i> &nbsp;Timetable generated all courses  were allocated</div>"
                    ]
                );
            } else {
                echo json_encode(
                    [
                        "res" => "<div class='alert alert-danger'> <i class='fas fa-check-circle'></i> &nbsp;Timetable generated but $left courses  were not allocated</div>"
                    ]
                );
            }
        } // close valid dates provided
    } //if date is less than today
}