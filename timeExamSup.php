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
$sem = showCurrentSem($conn);
if ($sem == 0) {
    echo json_encode(
        [
            "res" => "<div class='alert alert-warning'>
		<button type='button' class='close' data-dismiss='alert'>&times;</button>
		<i class='fas fa-check-circle'></i>&nbsp; Please set the current semester under settings</div>"
        ]
    );
} else {
    $sql = mysqli_query($conn, "SELECT *
        FROM suppcourses") or die(mysqli_error($conn));
    if (mysqli_num_rows($sql) == 0) {
        echo json_encode(
            [
                "res" => "<div class='alert alert-danger'> <i class='fas fa-circle-exclamation'></i> &nbsp;Please add the  courses you want to generate time table for first</div>"
            ]
        );
    } else {

        if ($sdate == '' || $edate == '') {
            echo json_encode(
                [
                    "res" => "<div class='alert alert-danger'> <i class='fas fa-circle-exclamation'></i> &nbsp;Please select start and end date</div>"
                ]
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
        FROM suppcourses
        INNER JOIN teacher ON suppcourses.teacher_id = teacher.teacher_id WHERE suppcourses.allocatedExam=0";
                    $result = mysqli_query($conn, $sql);
                    $teacherCourses = array();

                    while ($row = mysqli_fetch_assoc($result)) {
                        $teacherCourses[] = $row;
                    }

                    $scheduleDetails = getScheduleSup($start_date, $end_date, $teacherCourses, $num_days, $conn);
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
                                $sesions = mysqli_query($conn, "Select * FROM examsessionssup");
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
                                        //fetch available rooms;
                                        $roomQuery = mysqli_query($conn, "SELECT * FROM examvenuessup");

                                        while ($rooms = mysqli_fetch_assoc($roomQuery)) {
                                            $id = $rooms['rid'];
                                            $roomQuery2 = mysqli_query($conn, "SELECT * FROM rooms WHERE id='$id'");
                                            $room = mysqli_fetch_assoc($roomQuery2);
                                            $roomsArray[] = $room;
                                        }

                                        //end fetch rooms

                                        $clashchecker = array();
                                        $sessionid = $sess['id'];
                                        $thedate = $current_date->format('Y-m-d');
                                        $getSchedule = mysqli_query($conn, "SELECT * FROM examschedulesup WHERE edate='$thedate' AND sessionid='$sessionid'
                        AND exam_week='$i' AND sem='$sem'");
                                        while ($row = mysqli_fetch_assoc($getSchedule)) {
                                            $clashchecker[] = $row['courseid'];
                                        }
                                        if (mysqli_num_rows($roomQuery2) > 0) { //open if there are rooms assigned
                                            for ($j = 1; $j <= $sessionsPerCourse; $j++) {
                                                if (count($teacherCourses) > 0) { //check if array is valid
                                                    $randomIndex = array_rand($teacherCourses);
                                                    $randomCourse = $teacherCourses[$randomIndex];
                                                    $course = $randomCourse['subject_title'];
                                                    $courseid = $randomCourse['subject_id'];
                                                    $noOfStudents = $randomCourse['pop'];
                                                    //room issue

                                                    $allocated = false;
                                                    $randomRoomIndex = array_rand($roomsArray);
                                                    $randomRoom = $roomsArray[$randomRoomIndex];
                                                    $roomCapacity = $randomRoom['capacity'];
                                                    $roomId = $randomRoom['id'];
                                                    if ($roomCapacity >= $noOfStudents) { // open capacity ok
                                                        //room issue
                                                        $foundClash = checkClassClashExam($clashchecker, $conn, $courseid);
                                                        if ($foundClash == false) { //no clash will occour
                                                            //echo "<li> $course</li>";
                                                            $newCapacity = ($roomCapacity - $noOfStudents);
                                                            $roomsArray[$randomRoomIndex]['capacity'] = $newCapacity;
                                                            mysqli_query($conn, "INSERT INTO examschedulesup (edate,courseid,course,sessionid,exam_week,roomid,round,cap,sem) 
            VALUES('$thedate','$courseid','$course','$sessionid','$i','$roomId',1,'$noOfStudents','$sem')");
                                                            mysqli_query($conn, "UPDATE examschedulesup SET rspace='$newCapacity' WHERE edate='$thedate' AND sessionid='$sessionid' AND 
                                                exam_week='$i' AND roomid='$roomId'") or die(mysqli_error($conn));

                                                            $clashchecker[] = $courseid;
                                                            unset($teacherCourses[$randomIndex]);
                                                            $teacherCourses = array_values($teacherCourses);
                                                        }
                                                    } //close capacity ok
                                                }
                                            }
                                        } else { // no rooms message
                                            echo json_encode(
                                                array(
                                                    "res" => "<div class='alert alert-danger'> <i class='fas fa-circle-exclamation'></i> &nbsp;
                                                <button type='button' class='close' data-dismiss='alert'>&times;</button>
                                                No rooms are availabe please assign rooms</div>"
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
                    { //reallocate second time
                        $teacherCourses = reallocateCoursesSup($conn, $sessionsPerCourse, $teacherCourses, $sem);
                        $left = count($teacherCourses);
                        if ($left == 0) //all courses reallocated second attempt
                        {
                            echo json_encode(
                                [
                                    "res" => "<div class='alert alert-success'> <i class='fas fa-circle-check'></i> &nbsp;
                                <button type='button' class='close' data-dismiss='alert'>&times;</button>
                                Timetable generated, all courses are allocated second attempt"
                                ]
                            );
                        } //end allocate second time
                        else { // try third time
                            $teacherCourses = reallocateCoursesSup($conn, $sessionsPerCourse, $teacherCourses, $sem);
                            $left = count($teacherCourses);
                            if ($left == 0) { //courses were allocated third
                                echo json_encode(
                                    [
                                        "res" => "<div class='alert alert-danger'> <i class='fas fa-circle-exclamation'></i> &nbsp;
                                    <button type='button' class='close' data-dismiss='alert'>&times;</button>
                                    Timetable generated but $left courses were not allocated increase time span or sessions the course is $course</div>"
                                    ]
                                );
                            }
                        } //end do third attempt
                    } //close  $lCourses >0
                    else { //all courses were allocated first time
                        echo json_encode(
                            [
                                "res" => "<div class='alert alert-success'> <i class='fas fa-circle-check'></i> &nbsp;
                            <button type='button' class='close' data-dismiss='alert'>&times;</button>
                            Timetable generated but all  courses were not allocated, first time</div>"
                            ]
                        );
                    }
                } // close valid dates provided
            } //if date is less than today
        }
    }
}