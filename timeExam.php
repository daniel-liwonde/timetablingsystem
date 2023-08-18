<?php
require_once('connect.php');
require_once('ttFunctions.php');
$examDays;
$sessionsNum;
$sessionsPerCourse;
$coursesPerDay;
$sdate=$_GET['start_date'];
$edate =$_GET['end_date'];
$start_date = new DateTime($_GET['start_date']);
$end_date = new DateTime($_GET['end_date']);
$interval = $start_date->diff($end_date);
$num_days = $interval->format('%a');
$num_days = $num_days + 1;
$current_date = clone $start_date;
$today = Date('Y-m-d');
$today = new DateTime($today);
$td = $today->format("l, j F Y");
if($sdate=='' || $edate=='')
{
  echo json_encode(
        array(
            "res" => "<div class='alert alert-danger'> <i class='fas fa-circle-exclamation'></i> &nbsp;Please select start and end date</div>"
        )
    );  
}
else
{
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
                        for ($j = 1; $j <= 2; $j++) { //session =2
                            echo $current_date->format("l, j F Y") . "<br>";
                            if ($j == 1)
                                $sess = "(Morning Hours)";
                            else
                                $sess = "(Afternoon Hours)";
                            //echo count($teacherCourses);
                            $clashchecker = array();
                            while (count($clashchecker) < $sessionsPerCourse) {
                                if (count($teacherCourses) > 0) { //check if array is valid
                                    $randomIndex = array_rand($teacherCourses);
                                    $randomCourse = $teacherCourses[$randomIndex];
                                    $course = $randomCourse['subject_title'];
                                    $courseid = $randomCourse['subject_id'];
                                    $foundClash = checkClassClashExam($clashchecker, $conn, $courseid);
                                    if ($foundClash == false) {
                                        // echo "<li> $course</li>";
                                        $clashchecker[] = $courseid;
                                        unset($teacherCourses[$randomIndex]);
                                        $teacherCourses = array_values($teacherCourses);
                                    }

                                }
                            }
                        } //close for loop session
                    } //close if no sessions are available
                    else { //sessions are available
                        while ($sess = mysqli_fetch_assoc($sesions)) { //session = sessions set by user
                            //echo count($teacherCourses);
                            $clashchecker = array();
                            $sessionid = $sess['id'];
                            $thedate = $current_date->format('Y-m-d');
                            $getSchedule = mysqli_query($conn, "SELECT * FROM examschedule WHERE edate='$thedate' AND sessionid='$sessionid'
                        AND exam_week='$i'");
                            while ($row = mysqli_fetch_assoc($getSchedule)) {
                                $clashchecker[] = $row['courseid'];
                            }

                            for ($j = 1; $j <= $sessionsPerCourse; $j++) {
                                if (count($teacherCourses) > 0) { //check if array is valid
                                    $randomIndex = array_rand($teacherCourses);
                                    $randomCourse = $teacherCourses[$randomIndex];
                                    $course = $randomCourse['subject_title'];
                                    $courseid = $randomCourse['subject_id'];
                                    $venues=mysqli_query($conn,"SELECT * FROM examvenues") or die(mysqli_error($conn));
                                    while($row=mysqli_fetch_assoc($venues))
                                    {//open rooms
                                        $rname=$row['room'];
                                        $getRroom=mysqli_query($conn,"SELECT * FROM rooms where room='$rname'") or die(mysqli_error($conn));
                                        $room=mysqli_fetch_assoc($getRroom);
                                        $capacity=$room['capacity'];
                                        $roomId= $room["id"];
                                        if(checkRoomCompatibility($conn, $roomId, $courseid)==1)
                                        {//start check room capacity
                                    $foundClash = checkClassClashExam($clashchecker, $conn, $courseid);
                                    if ($foundClash == false) {
                                        //echo "<li> $course</li>";
                                        mysqli_query($conn, "INSERT INTO examschedule (edate,courseid,course,sessionid,exam_week,roomid) 
            VALUES('$thedate','$courseid','$course','$sessionid','$i')");
                                        $clashchecker[] = $courseid;
                                        unset($teacherCourses[$randomIndex]);
                                        $teacherCourses = array_values($teacherCourses);
                                    }
                                }//close  check room capacity
                                }//close rooms
                                }
                            }
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
                    while ($sess = mysqli_fetch_assoc($sesions)) {
                        //******************************************************* */
                        for ($j = 1; $j <= $sessionsPerCourse; $j++) { //possible number of courses to insert
                            if (count($teacherCourses) > 0) { //check if array is valid
                                $randomIndex = array_rand($teacherCourses);
                                $randomCourse = $teacherCourses[$randomIndex];
                                $course = $randomCourse['subject_title'];
                                $courseid = $randomCourse['subject_id'];
                                $sessionid = $sess['id'];
                                $eDate = $dates['edate'];
                                $getSchedule = mysqli_query($conn, "SELECT * FROM examschedule WHERE edate='$eDate' AND sessionid='$sessionid'
                        AND exam_week='$eWeek'");
                                while ($row = mysqli_fetch_assoc($getSchedule)) {
                                    $clashchecker[] = $row['courseid'];
                                }
                                $foundClash = checkClassClashExam($clashchecker, $conn, $courseid);
                                if ($foundClash == false) { //if no clash will occour
                                    //echo "<li> $course</li>";
                                    mysqli_query($conn, "INSERT INTO examschedule (edate,courseid,course,sessionid,exam_week) 
            VALUES('$eDate','$courseid','$course','$sessionid','$eWeek')");

                                    $clashchecker[] = $courseid;
                                    unset($teacherCourses[$randomIndex]);
                                    $teacherCourses = array_values($teacherCourses);
                                } //close if no clash
                            } //close possible number of courses to add
                        } //************************************************************ */
                    } //close while session
                } //end current date
            } //end weeks
        } //end count >0
        $left = count($teacherCourses);

        echo json_encode(
            array(
                "res" => "<div class='alert alert-success'> <i class='fas fa-check-circle'></i> &nbsp;Timetable generated all courses are allocated</div>"
            )
        );
    } // close valid dates provided
} //if date is less than today
}