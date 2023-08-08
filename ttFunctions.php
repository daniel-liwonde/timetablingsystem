<?php
require_once('session.php');
//START CHECKING FOR SAME CLASSS COURSE CLASH
/*
To avoid course in the same class sloted on the same time slot at the same day
BEFORE giving it a slot
we should find all the classes this course belong and check if any of the course in those classes
have been given the CURRENT slot at this day
*/
//FUNCTION START HERE
function checkRoomCompatibility($conn, $roomId, $course)
{
    $room = mysqli_query($conn, "SELECT * FROM rooms WHERE id='$roomId'") or die(mysqli_error($conn));
    $roomcapa = mysqli_fetch_assoc($room);
    $rCapacity = $roomcapa['capacity'];
    $coursePopulation = mysqli_query($conn, "SELECT * FROM subject WHERE subject_id='$course'") or die(mysqli_error($conn));
    $getPop = mysqli_fetch_assoc($coursePopulation);
    $coursePop = $getPop['students'];
    if ($coursePop <= $rCapacity)
        return 1;
    else
        return 0;
}
function checkClassClash($clashchecker, $conn, $courseid, $currentDayID, $slot)
{
    $found = false;
    foreach ($clashchecker as $items) { //checking a sloted with a course in the same CLASS in the same day
        $r = mysqli_query($conn, "SELECT * FROM course_class WHERE courseid='$courseid'");
        // find all CLASSES currentcourse belongs to
        $classes = array(); //create an array to hold the CLASSES this course belongs to
        while ($row = mysqli_fetch_assoc($r)) { //fetch a class id at a time
            $classes[] = $row['classid']; // add the current class ids to $classes array
        } //all classes this course belong to are now in $classes array
//echo "{$course} found in " . count($classes). " classes <br> Below are the classes<br>";
        if (count($classes) > 0) // if we have any class in $classes
        {
            foreach ($classes as $class) { // get a class at a time as $class
//get all courses that belong to this class
                $findcourses = mysqli_query($conn, "SELECT courseid FROM course_class WHERE classid='$class'");
                if (mysqli_num_rows($findcourses) > 0) // if there are courses in this class
                {
                    //echo "courses in class {$class}: <br>";
                    while ($row = mysqli_fetch_assoc($findcourses)) //get a course at a time
/*REQUIRED
compare the current course with the one in added courses
*/
                        if (($row['courseid'] == $items['courseid']) && ($items['dayid'] == $currentDayID) && ($items['slot'] == $slot)) {
                            $found = true;
                            break;
                        }
                } //close if there are courses
            } //close foreach class
        } //close if there are classes
    } //close checking FOR a sloted with a course in the same CLASS in the same day
    return $found;
} //END FUNCTION

function checkClassClashExam($clashchecker, $conn, $courseid)
{
    $found = false;
    foreach ($clashchecker as $item) { //checking a sloted with a course in the same CLASS in the same day
        $r = mysqli_query($conn, "SELECT * FROM course_class WHERE courseid='$courseid'");
        // find all CLASSES currentcourse belongs to
        $classes = array(); //create an array to hold the CLASSES this course belongs to
        while ($row = mysqli_fetch_assoc($r)) { //fetch a class id at a time
            $classes[] = $row['classid']; // add the current class ids to $classes array
        } //all classes this course belong to are now in $classes array
//echo "{$course} found in " . count($classes). " classes <br> Below are the classes<br>";
        if (count($classes) > 0) // if we have any class in $classes
        {
            foreach ($classes as $class) { // get a class at a time as $class
//get all courses that belong to this class
                $findcourses = mysqli_query($conn, "SELECT courseid FROM course_class WHERE classid='$class'");
                if (mysqli_num_rows($findcourses) > 0) // if there are courses in this class
                {
                    //echo "courses in class {$class}: <br>";
                    while ($row = mysqli_fetch_assoc($findcourses)) //get a course at a time
/*REQUIRED
compare the current course with the one in added courses
*/
                        if ($row['courseid'] == $item) { //if the current course belongs to the same class with this courses
                            $found = true;
                            break;
                        }
                } //close if there are courses
            } //close foreach class
        } //close if there are classes
    } //close checking FOR a sloted with a course in the same CLASS in the same day
    return $found;
} //END FUNCTION
function checkClassClash2($clashchecker, $conn, $courseid, $currentDayID, $slot)
{
    $found = false;
    foreach ($clashchecker as $items) { //checking a sloted with a course in the same CLASS in the same day
        $r = mysqli_query($conn, "SELECT * FROM course_class WHERE courseid='$courseid'");
        // find all CLASSES currentcourse belongs to
        $classes = array(); //create an array to hold the CLASSES this course belongs to
        while ($row = mysqli_fetch_assoc($r)) { //fetch a class id at a time
            $classes[] = $row['classid']; // add the current class ids to $classes array
        } //all classes this course belong to are now in $classes array
//echo "{$course} found in " . count($classes). " classes <br> Below are the classes<br>";
        if (count($classes) > 0) // if we have any class in $classes
        {
            foreach ($classes as $class) { // get a class at a time as $class
//get all courses that belong to this class
                $findcourses = mysqli_query($conn, "SELECT courseid FROM course_class WHERE classid='$class'");
                if (mysqli_num_rows($findcourses) > 0) // if there are courses in this class
                {
                    //echo "courses in class {$class}: <br>";
                    while ($row = mysqli_fetch_assoc($findcourses)) //get a course at a time
/*REQUIRED
compare the current course with the one in added courses
*/
                        if (($row['courseid'] == $items['subject_id']) && ($items['dayid'] == $currentDayID) && ($items['timeslot'] == $slot)) {
                            $found = true;
                            break;
                        }
                } //close if there are courses
            } //close foreach class
        } //close if there are classes
    } //close checking FOR a sloted with a course in the same CLASS in the same day
    return $found;
} //END FUNCTION
//END CHECKING FOR SAME CLASS CHECK
//teacher clash checker starts here
function checkTeacherClash($clashchecker, $teacher_id, $currentDayID, $slot)
{
    $found = false;
    foreach ($clashchecker as $items) {
        if (($items['teacher_id'] == $teacher_id) && ($items['dayid'] == $currentDayID) && ($items['slot'] == $slot)) {
            $found = true;
            break;
        }
    }
    return $found;
}
function checkTeacherClash2($clashchecker, $teacher_id, $currentDayID, $slot)
{
    $found = false;
    foreach ($clashchecker as $items) {
        if (($items['lectid'] == $teacher_id) && ($items['dayid'] == $currentDayID) && ($items['timeslot'] == $slot)) {
            $found = true;
            break;
        }
    }
    return $found;
}
//end teacher clash checker function
/// Function to do schedule====================================
//start checking picked course for existances
/**
 * Summary of doSchedule
 * @param mixed $conn
 * @param mixed $courseid
 * @param mixed $currentDayID
 * @param mixed $currentRoomID
 * @param mixed $slot
 * @param mixed $course
 * @param mixed $teacher_id
 * @param mixed $teacherf
 * @param mixed $teacherl
 * @param mixed $randomIndex
 * @param mixed $clashchecker
 * @return void
 */
function doSchedule(
    $conn,
    $courseid,
    $currentDayID,
    $currentRoomID,
    $slot,
    $course,
    $teacher_id,
    $teacherf,
    $teacherl
) {
    $check = mysqli_query($conn, "SELECT * FROM checker WHERE courseid='$courseid'");
    if (mysqli_num_rows($check) == 0) { // picked course is not scheduled give it the first slot

        mysqli_query($conn, "INSERT INTO schedule(dayid,roomid,timeslot,allocatedcourse,
lectid,lecturerfname,lecturerlname,subject_id)
values('$currentDayID','$currentRoomID',$slot,'$course','$teacher_id','$teacherf','$teacherl','$courseid')") or
            die(mysqli_error($conn));
        mysqli_query($conn, "INSERT INTO checker(courseid,slots)
values('$courseid',1)") or die(mysqli_error($conn));
        mysqli_query($conn, "UPDATE subject SET allocated=allocated+1 WHERE subject_id='$courseid' ");
        //add the course to added course array
    } // end course not scheduled
    else { //course already scheduled atleast once
        $checksessions = mysqli_fetch_assoc($check);
        $checkSlots = $checksessions['slots']; //find number of slots
        if ($checkSlots == 1) {
            $check2 = mysqli_query($conn, "SELECT * FROM schedule WHERE dayid='$currentDayID' and timeslot='$slot' AND
        roomid='$currentRoomID'") or die(mysqli_error($conn));
            if (mysqli_num_rows($check2) > 0) { //picked slot already available
                mysqli_query($conn, "UPDATE schedule  SET allocatedcourse='$course', lectid='$teacher_id',lecturerfname='$teacherf',lecturerlname='$teacherl' WHERE dayid='$currentDayID' and timeslot='$slot' AND
        roomid='$currentRoomID'") or
                    die(mysqli_error($conn));
                mysqli_query($conn, "UPDATE checker SET slots=slots+1 WHERE courseid='$courseid' ");
                mysqli_query($conn, "UPDATE subject SET allocated=allocated+1 WHERE subject_id='$courseid' ");
            } else {
                //give the course a second slot and update checker
                mysqli_query($conn, "INSERT INTO
schedule(dayid,roomid,timeslot,allocatedcourse,lectid,lecturerfname,lecturerlname,subject_id)
values('$currentDayID','$currentRoomID',$slot,'$course','$teacher_id','$teacherf','$teacherl','$courseid')") or
                    die(mysqli_error($conn));
                mysqli_query($conn, "UPDATE checker SET slots=slots+1 WHERE courseid='$courseid' ");
                mysqli_query($conn, "UPDATE subject SET allocated=allocated+1 WHERE subject_id='$courseid' ");
            }
        } //end give it second slot
    } //end course already scheduled atleast once
}
//end do seschedule==========================================

// reseve course for reschedule========================

function lecturerTT($session_id, $conn)
{
    $lect = $session_id;
    $findLect = mysqli_query($conn, "SELECT  firstname,lastname from teacher where teacher_id='$lect'");
    $theName = mysqli_fetch_assoc($findLect);
    echo "<div class='alert alert-info'><i class='icon-calendar icon-large'></i>&nbsp;Time table for:<b> {$theName['lastname']} &nbsp;{$theName['firstname']}</b></div>";

    ?>

    <table cellpadding="0" cellspacing="0" border="1" class="table table-striped table-bordered">
        <thead>
            <tr>

                <th>Day</th>
                <th>8:00am - 9:30am</th>
                <th>9:30am - 11:00am</th>
                <th>11:00am - 12:30pm</th>
                <th>12:30pm - 2:00pm</th>
                <th>2:00pm - 3:30pm</th>
                <th>3:30pm - 5:00pm</th>
            </tr>
        </thead>
        <tbody>
            <!-- end script -->

            <?php

            $findDays = mysqli_query($conn, "SELECT  distinct dayid from  schedule where lectid='$lect'");
            if (mysqli_num_rows($findDays) > 0) {
                while ($day = mysqli_fetch_assoc($findDays)) {
                    $dayID = $day['dayid'];
                    $findday = mysqli_query($conn, "SELECT day FROM week_days WHERE id='$dayID'");
                    $theDay = mysqli_fetch_assoc($findday);
                    $dayName = $theDay['day'];
                    echo "<tr>";
                    echo "<td>{$dayName}</td>";
                    $findslots = mysqli_query($conn, "SELECT roomid, timeslot, allocatedcourse FROM schedule WHERE 
dayid='$dayID' AND lectid='$lect' ORDER BY timeslot ASC");
                    $slots = array(); // initialize an array to store all the slots for the current day
                    while ($row = mysqli_fetch_assoc($findslots)) {
                        $slots[] = $row; // add the current row to the $slots array
                    }
                    for ($i = 0; $i < 6; $i++) {
                        $slot_found = false; // initialize a flag to check if a slot was found for the current time slot
                        foreach ($slots as $slot) {
                            if ($slot['timeslot'] == $i) {
                                $room = $slot['roomid'];
                                $findroom = mysqli_query($conn, "SELECT room FROM rooms WHERE id='$room'");
                                $theRoom = mysqli_fetch_assoc($findroom);
                                $roomName = $theRoom['room'];
                                echo "<td> 
{$slot['allocatedcourse']} <br>({$roomName})
</td> ";
                                $slot_found = true; // set the flag to true
                                break; // exit the foreach loop, since we found a slot for the current time slot
                            }
                        }
                        if (!$slot_found) {
                            echo "<td valign='middle' style='text-align:center; verticle:middle'>-</td>"; // if no slot was found, display a dash (-)
                        }
                    } //end for loop
                    echo "</tr>";
                } //end while days
            } //end if days >0
            else { //no days found
                echo "<tr><td colspan='7'>No timetable was found for lecturer</td></tr>";
            } //close no days else
            echo "</tbody></table>";
}


//General timetable
function displayTT($conn)
{
    $days = mysqli_query($conn, "SELECT * FROM week_days") or die(mysqli_error($conn));
    $rooms = mysqli_query($conn, "SELECT * FROM rooms") or die(mysqli_error($conn));

    while ($day = mysqli_fetch_assoc($days)) {
        $dayid = $day['id'];
        ?>
                <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Day</th>
                            <th>Room</th>
                            <th>8:00am - 9:30am</th>
                            <th>9:30am - 11:00am</th>
                            <th>11:00am - 12:30pm</th>
                            <th>12:30pm - 2:00pm</th>
                            <th>2:00pm - 3:30pm</th>
                            <th>3:30pm - 5:00pm</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        mysqli_data_seek($rooms, 0);

                        while ($room_rows = mysqli_fetch_assoc($rooms)) {
                            $currentRoom = $room_rows['room'];
                            $currentRoomID = $room_rows['id'];
                            ?>
                            <tr>
                                <td>
                                    <?php echo $day['day']; ?>
                                </td>
                                <td>
                                    <?php echo $currentRoom; ?>
                                </td>
                                <?php
                                $schedule = mysqli_query($conn, "SELECT * FROM schedule WHERE roomid='$currentRoomID' AND dayid='$dayid' ORDER BY timeslot ASC") or die(mysqli_error($conn));
                                while ($schedule_row = mysqli_fetch_assoc($schedule)) {
                                    $data = $schedule_row['allocatedcourse'];
                                    $lectl = $schedule_row['lecturerlname'];
                                    $lectf = $schedule_row['lecturerfname'];
                                    $cid = $schedule_row['scheduleid'];
                                    if ($data == null) {

                                        echo "<td style='text-align:center;vertical-align:middle;''>-</td>";
                                    } else {
                                        echo "<td>$data<br><font color='#52595D'>($lectl &nbsp;{$lectf})
                                        <a title='remove' onclick='doDelete(" . json_encode($data) . ",$cid)'><i class='fas fa-remove fa-sm'></i></a></li>
                                        </font></td>";
                                    }

                                }
                                ?>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
                <?php
    }
}

function get_holidays($year)
{
    $holidays = array(
        // New Year's Day
        "{$year}-01-01",

        // John Chilembwe Day
        "{$year}-01-15",

        // Martyrs' Day
        "{$year}-03-03",

        // Good Friday
        date('Y-m-d', strtotime("{$year}-01-01 + {$year} days")),

        // Easter Monday
        date('Y-m-d', strtotime("{$year}-01-01 + {$year} days") + 3 * 86400),

        // Labour Day
        "{$year}-05-01",

        // Kamuzu Day
        "{$year}-05-14",

        // Eid al-Fitr
        date('Y-m-d', strtotime('first day of Shawwal', strtotime("{$year}-01-01"))),

        // Independence Day
        "{$year}-07-06",

        // Eid al-Adha
        date('Y-m-d', strtotime('10 days after Arafat Day', strtotime("{$year}-01-01"))),

        // Mother's Day
        date('Y-m-d', strtotime("second Sunday of October {$year}")),

        // Christmas Day
        "{$year}-12-25",

        // Boxing Day
        "{$year}-12-26"
    );

    return $holidays;
}
function getSchedule($start_date, $end_date, $teacherCourses, $num_days, $conn)
{
    $i = 2;
    $weeks = 0;
    $holidays = 0;
    $totalCourses = count($teacherCourses);
    $current_date = clone $start_date;
    while ($current_date <= $end_date) {
        // Check if the current date is a holiday
        $holiday_dates = get_holidays($current_date->format('Y'));
        $is_holiday = in_array($current_date->format('Y-m-d'), $holiday_dates);

        // Skip the iteration if the current date is a holiday
        if ($is_holiday) {
            $holidays++;
            //echo "Holiday{$holidays}" .$current_date->format("D,M d, Y") . "<br>";
            $current_day_of_week = $current_date->format('w');
            // If the holiday falls on a Saturday or Sunday, skip the next Monday
            if ($current_day_of_week == 6 || $current_day_of_week == 0) {
                if ($current_day_of_week == 6) {
                    $current_date->modify('next Monday');
                } else {
                    $current_date->modify('+2 days');
                }

            } else {
                $current_date->modify('+1 day');
            }

            continue;
        }

        // Display the current date
        if ($current_date->format('w') != 6) {
            if ($current_date->format('w') == 0) {
                //echo "Week{$i}" .$current_date->format("D,M d, Y") . "<br>";
                $i++;
                $weeks++;
            } else {
                //echo $current_date->format("D,M d, Y")."<br>";
            }
        }
        $current_date->modify('+1 day');
    }
    $sesion = mysqli_query($conn, "Select * FROM examsessions");
    $getsessions = mysqli_num_rows($sesion);
    if ($getsessions == 0) { //if no sessions are available
        $div = 2;
    } else
        $div = $getsessions;
    //$num_days = $interval->format('%a'); 
    $totalDays = ($weeks * 2) + $holidays;
    $examDays = $num_days - $totalDays;
    $coursesPerDay = round(($totalCourses / $examDays));
    $coursePerSession = round(($coursesPerDay / $div));
    return
        [
            'examDays' => $examDays,
            'coursePerSession' => $coursePerSession,
            'coursesPerDay' => $coursesPerDay,
            'holidays' => $holidays,
            'weekends' => $i,
            'totalcourses' => $totalCourses
        ];
}
//getSchedule for suppcourses

function getScheduleSup($start_date, $end_date, $teacherCourses, $num_days, $conn)
{
    $i = 2;
    $weeks = 0;
    $holidays = 0;
    $totalCourses = count($teacherCourses);
    $current_date = clone $start_date;
    while ($current_date <= $end_date) {
        // Check if the current date is a holiday
        $holiday_dates = get_holidays($current_date->format('Y'));
        $is_holiday = in_array($current_date->format('Y-m-d'), $holiday_dates);

        // Skip the iteration if the current date is a holiday
        if ($is_holiday) {
            $holidays++;
            //echo "Holiday{$holidays}" .$current_date->format("D,M d, Y") . "<br>";
            $current_day_of_week = $current_date->format('w');
            // If the holiday falls on a Saturday or Sunday, skip the next Monday
            if ($current_day_of_week == 6 || $current_day_of_week == 0) {
                if ($current_day_of_week == 6) {
                    $current_date->modify('next Monday');
                } else {
                    $current_date->modify('+2 days');
                }

            } else {
                $current_date->modify('+1 day');
            }

            continue;
        }

        // Display the current date
        if ($current_date->format('w') != 6) {
            if ($current_date->format('w') == 0) {
                //echo "Week{$i}" .$current_date->format("D,M d, Y") . "<br>";
                $i++;
                $weeks++;
            } else {
                //echo $current_date->format("D,M d, Y")."<br>";
            }
        }
        $current_date->modify('+1 day');
    }
    $sesion = mysqli_query($conn, "Select * FROM examsessionssup");
    $getsessions = mysqli_num_rows($sesion);
    if ($getsessions == 0) { //if no sessions are available
        $div = 2;
    } else
        $div = $getsessions;
    //$num_days = $interval->format('%a'); 
    $totalDays = ($weeks * 2) + $holidays;
    $examDays = $num_days - $totalDays;
    $coursesPerDay = round(($totalCourses / $examDays));
    $coursePerSession = round(($coursesPerDay / $div));
    return
        [
            'examDays' => $examDays,
            'coursePerSession' => $coursePerSession,
            'coursesPerDay' => $coursesPerDay,
            'holidays' => $holidays,
            'weekends' => $i,
            'totalcourses' => $totalCourses
        ];
}
//end supp
function displayTTExport($conn)
{
    $days = mysqli_query($conn, "SELECT * FROM week_days") or die(mysqli_error($conn));
    $rooms = mysqli_query($conn, "SELECT * FROM rooms") or die(mysqli_error($conn));

    while ($day = mysqli_fetch_assoc($days)) {
        $dayid = $day['id'];
        ?>
                <table cellpadding="10" cellspacing="0" border="1" width="100%">
                    <thead>
                        <tr bgcolor="DDDDDD" height="30">

                            <th>Day</th>
                            <th>Room</th>
                            <th>8:00am - 9:30am</th>
                            <th>9:30am - 11:00am</th>
                            <th>11:00am - 12:30pm</th>
                            <th>12:30pm - 2:00pm</th>
                            <th>2:00pm - 3:30pm</th>
                            <th>3:30pm - 5:00pm</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        mysqli_data_seek($rooms, 0);

                        $j = 1;
                        while ($room_rows = mysqli_fetch_assoc($rooms)) {
                            $currentRoom = $room_rows['room'];
                            $currentRoomID = $room_rows['id'];
                            $roomLocation = $room_rows['location'];
                            ?>
                            <tr <?php if ($j % 2 == 0) { ?> bgcolor="#DDDDDD" <?php } else { ?> bgcolor="#FFFFFF" <?php } ?>>
                                <td>
                                    <?php echo $day['day']; ?>
                                </td>
                                <td>
                                    <?php echo "$currentRoom<br>(<font color='#61C2A2'>$roomLocation</font>)"; ?>
                                </td>
                                <?php
                                $schedule = mysqli_query($conn, "SELECT * FROM schedule WHERE roomid='$currentRoomID' AND dayid='$dayid' ORDER BY timeslot ASC") or die(mysqli_error($conn));
                                while ($schedule_row = mysqli_fetch_assoc($schedule)) {
                                    $data = $schedule_row['allocatedcourse'];
                                    $lectl = $schedule_row['lecturerlname'];
                                    $lectf = $schedule_row['lecturerfname'];
                                    if ($data == null) {

                                        echo "<td style='text-align:center;vertical-align:middle;''>-</td>";
                                    } else {
                                        ?>
                                        <td>
                                            <?php echo $data ?><br>
                                            <font color='#52595D'>
                                                <?php echo "($lectl &nbsp;{$lectf})" ?>
                                            </font>
                                            <br>
                                            <?php
                                            $coid = mysqli_query($conn, "SELECT subject_id FROM subject WHERE subject_title='$data'");
                                            $subid = mysqli_fetch_assoc($coid);
                                            $subject_id = $subid['subject_id'];
                                            $classes = mysqli_query($conn, "SELECT * from course_class INNER JOIN classes ON course_class.classid=
                                 classes.classid WHERE course_class.courseid='$subject_id'");
                                            $i = 1;
                                            ?>

                                            <?php
                                            while ($r = mysqli_fetch_assoc($classes)) {
                                                if ($i == 3) {
                                                    echo "<font color='#61C2A2'>{$r['classname']}</font><br>";
                                                    $i = 0;
                                                } else
                                                    echo "<font color='#61C2A2'>{$r['classname']}</font>,";
                                                $i++;
                                            }
                                            ?>
                                        </td>
                                        <?php
                                    }

                                }
                                ?>
                            </tr>
                            <?php
                            $j++;
                        }
                        ?>
                    </tbody>
                </table>
                <?php
    }
}

?>