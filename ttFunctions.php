<?php
function findMaxSchedule($conn)
{
    // Assuming $conn is your database connection

    // Execute the query to get the maximum scheduleid
    $result = mysqli_query($conn, "SELECT MAX(scheduleid) AS max_scheduleid FROM schedule") or die(mysqli_error($conn));

    // Fetch the result as an associative array
    $row = mysqli_fetch_assoc($result);

    // Get the maximum scheduleid value
    $maxScheduleId = $row['max_scheduleid'];
    if ($maxScheduleId == null)
        $maxScheduleId = 0;
    // Output the result or use it as needed
    return $maxScheduleId;

}
function findMaxScheduleWend($conn)
{
    // Assuming $conn is your database connection

    // Execute the query to get the maximum scheduleid
    $result = mysqli_query($conn, "SELECT MAX(scheduleid) AS max_scheduleid FROM schedule_wend") or die(mysqli_error($conn));

    // Fetch the result as an associative array
    $row = mysqli_fetch_assoc($result);

    // Get the maximum scheduleid value
    $maxScheduleId = $row['max_scheduleid'];
    if ($maxScheduleId == null)
        $maxScheduleId = 0;
    // Output the result or use it as needed
    return $maxScheduleId;

}
function showCurrentSem($conn)
{

    $ss = mysqli_query($conn, "SELECT * FROM currentsem") or die(mysqli_error($conn));
    if (mysqli_num_rows($ss) == 0)
        $csem = 0;
    else {
        $data = mysqli_fetch_assoc($ss);
        $s = $data['sem'];
        $csem = $s;
    }
    return $csem;
}
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
                        if (($row['courseid'] == $item)) { //if the current course belongs to the same class with this courses
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
function checkTeacherClash($clashchecker, $teacher_id, $currentDayID, $slot, $sem)
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
    $teacherl,
    $sem

) {
    $num = findMaxSchedule($conn);
    $check = mysqli_query($conn, "SELECT * FROM checker WHERE courseid='$courseid'");
    if (mysqli_num_rows($check) == 0) { // picked course is not scheduled give it the first slot
        $num = $num + 1;
        mysqli_query($conn, "INSERT INTO schedule(scheduleid,dayid,roomid,timeslot,allocatedcourse,
lectid,lecturerfname,lecturerlname,subject_id,sem,pref)
values('$num','$currentDayID','$currentRoomID',$slot,'$course','$teacher_id','$teacherf','$teacherl','$courseid','$sem',1)") or
            die(mysqli_error($conn));
        mysqli_query($conn, "INSERT INTO checker(courseid,slots,sem)
values('$courseid',1,'$sem')") or die(mysqli_error($conn));

        //add the course to added course array
    } // end course not scheduled
    else { //course already scheduled atleast once
        $checksessions = mysqli_fetch_assoc($check);
        $checkSlots = $checksessions['slots']; //find number of slots
        if ($checkSlots == 1) {
            $check2 = mysqli_query($conn, "SELECT * FROM schedule WHERE dayid='$currentDayID' and timeslot='$slot' AND
        roomid='$currentRoomID' AND sem='$sem'") or die(mysqli_error($conn));
            if (mysqli_num_rows($check2) > 0) { //picked slot already available
                mysqli_query($conn, "UPDATE schedule  SET allocatedcourse='$course',pref=1,  lectid='$teacher_id',lecturerfname='$teacherf',lecturerlname='$teacherl' WHERE dayid='$currentDayID' and timeslot='$slot' AND
        roomid='$currentRoomID' and sem='$sem'") or
                    die(mysqli_error($conn));
                mysqli_query($conn, "UPDATE checker SET slots=slots+1 WHERE courseid='$courseid'AND sem='$sem' ");

            } else {
                //give the course a second slot and update checker
                $num = $num + 1;
                mysqli_query($conn, "INSERT INTO
schedule(scheduleid,subject_id,dayid,roomid,timeslot,allocatedcourse,lectid,lecturerfname,lecturerlname,sem,pref)
values('$num','$courseid','$currentDayID','$currentRoomID',$slot,'$course','$teacher_id','$teacherf','$teacherl','$courseid','$sem',1)") or
                    die(mysqli_error($conn));
                mysqli_query($conn, "UPDATE checker SET slots=slots+1  WHERE courseid='$courseid' AND sem='$sem' ");

            }
        } //end give it second slot
    } //end course already scheduled atleast once
}
//end do seschedule==========================================


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
function doScheduleWend(
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

) {
    $num = findMaxScheduleWend($conn);

    $check = mysqli_query($conn, "SELECT * FROM checker_wend WHERE courseid='$courseid'");
    if (mysqli_num_rows($check) == 0) { // picked course is not scheduled give it the first slot
        $num = $num + 1;
        mysqli_query($conn, "INSERT INTO schedule_wend(scheduleid,dayid,roomid,timeslot,allocatedcourse,
lectid,lecturerfname,lecturerlname,subject_id,sem)
values('$num','$currentDayID','$currentRoomID',$slot,'$course','$teacher_id','$teacherf','$teacherl','$courseid','$sem')") or
            die(mysqli_error($conn));
        mysqli_query($conn, "INSERT INTO checker_wend(courseid,slots,sem)
values('$courseid',1,'$sem')") or die(mysqli_error($conn));
        mysqli_query($conn, "UPDATE wendcourses SET allocated=allocated+1 WHERE subject_id='$courseid' and sem='$sem' ");
        //add the course to added course array
    } // end course not scheduled
    else { //course already scheduled atleast once
        $checksessions = mysqli_fetch_assoc($check);
        $checkSlots = $checksessions['slots']; //find number of slots
        if ($checkSlots == 1) {
            $check2 = mysqli_query($conn, "SELECT * FROM schedule_wend WHERE dayid='$currentDayID' and timeslot='$slot' AND
        roomid='$currentRoomID' AND sem='$sem'") or die(mysqli_error($conn));
            if (mysqli_num_rows($check2) > 0) { //picked slot already available
                mysqli_query($conn, "UPDATE schedule_wend  SET allocatedcourse='$course', lectid='$teacher_id',lecturerfname='$teacherf',lecturerlname='$teacherl' WHERE dayid='$currentDayID' and timeslot='$slot' AND
        roomid='$currentRoomID' and sem='$sem'") or
                    die(mysqli_error($conn));
                mysqli_query($conn, "UPDATE checker_wend SET slots=slots+1 WHERE courseid='$courseid'AND sem='$sem' ");
                mysqli_query($conn, "UPDATE wendcourses SET allocated=allocated+1,sem='$sem' WHERE subject_id='$courseid' ");
            } else {
                //give the course a second slot and update checker
                $num = $num + 1;
                mysqli_query($conn, "INSERT INTO
schedule_wend(scheduleid,dayid,roomid,timeslot,allocatedcourse,lectid,lecturerfname,lecturerlname,subject_id,sem)
values('$num','$currentDayID','$currentRoomID',$slot,'$course','$teacher_id','$teacherf','$teacherl','$courseid','$sem')") or
                    die(mysqli_error($conn));
                mysqli_query($conn, "UPDATE checker_wend SET slots=slots+1  WHERE courseid='$courseid' AND sem='$sem' ");
                mysqli_query($conn, "UPDATE wendcourses SET allocated=allocated+1 WHERE subject_id='$courseid' ");
            }
        } //end give it second slot
    } //end course already scheduled atleast once
}
//end do seschedulewend==========================================

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
    $sem = showCurrentSem($conn);
    $semschedule = mysqli_query($conn, "SELECT * FROM schedule WHERE sem='$sem'") or die(mysqli_error($conn));
    if (mysqli_num_rows($semschedule) > 0) {
        $days = mysqli_query($conn, "SELECT * FROM week_days") or die(mysqli_error($conn));
        $rooms = mysqli_query($conn, "SELECT * FROM rooms") or die(mysqli_error($conn));

        while ($day = mysqli_fetch_assoc($days)) {
            $dayid = $day['id'];
            ?>
            <table cellpadding="10" cellspacing="0" border="1">
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
                            $schedule = mysqli_query($conn, "SELECT * FROM schedule WHERE roomid='$currentRoomID' AND dayid='$dayid' AND sem='$sem' ORDER BY timeslot ASC") or die(mysqli_error($conn));
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
    } else {
        ?>
        <script type="text/JavaScript">
                                                                                                                                                                                                                                                                                                                                                                                                                            alert("No timetable for this semester");
                                                                                                                                                                                                                                                                                                                                                                                                                            </script>
        <?php
    }
}
function displayTTExportWend($conn)
{
    $sem = showCurrentSem($conn);
    $semschedule = mysqli_query($conn, "SELECT * FROM schedule_wend WHERE sem='$sem'") or die(mysqli_error($conn));
    if (mysqli_num_rows($semschedule) > 0) {
        $days = mysqli_query($conn, "SELECT * FROM week_ends") or die(mysqli_error($conn));
        $rooms = mysqli_query($conn, "SELECT * FROM rooms INNER JOIN wendvenues ON rooms.id=wendvenues.rid") or die(mysqli_error($conn));

        while ($day = mysqli_fetch_assoc($days)) {
            $dayid = $day['id'];
            ?>
            <table cellpadding="10" cellspacing="0" border="1" width="80%">
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
                            $schedule = mysqli_query($conn, "SELECT * FROM schedule_wend WHERE roomid='$currentRoomID' AND dayid='$dayid' AND sem='$sem' ORDER BY timeslot ASC") or die(mysqli_error($conn));
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
                                        $coid = mysqli_query($conn, "SELECT subject_id FROM wendcourses WHERE subject_title='$data'");
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
    } else {
        echo ';
        <script type="text/JavaScript">
                alert("No timetable for this semester")                                                                                                                                                                                                                                                                                                        </script>
        ';
    }
}

function redoAllocateExams($conn, $sessionsPerCourse, $teacherCourses, $sem)
{
    $find_weeks = mysqli_query($conn, "SELECT distinct exam_week FROM examschedule WHERE sem='$sem'");
    while ($wrow = mysqli_fetch_assoc($find_weeks)) {
        $eWeek = $wrow['exam_week'];
        $find_date = mysqli_query($conn, "SELECT distinct edate FROM examschedule WHERE exam_week='$eWeek' AND sem='$sem'");
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
                            AND rspace > 0 AND sem='$sem'";
                $rooms = $conn->query($roomQuery);
                while ($room = $rooms->fetch_assoc()) {
                    $roomsArray[] = $room;
                }
                // if ($rooms->num_rows > 0) { //open if there are rooms assigned
                for ($j = 1; $j <= $sessionsPerCourse; $j++) { //possible number of courses to insert
                    if (count($teacherCourses) > 0) { //check if array is valid
                        $randomIndex = array_rand($teacherCourses);
                        $randomCourse = $teacherCourses[$randomIndex];
                        $course = $randomCourse['subject_title'];
                        $courseid = $randomCourse['subject_id'];
                        $noOfStudents = $randomCourse['students'];

                        $getSchedule = mysqli_query($conn, "SELECT * FROM examschedule WHERE edate='$eDate' AND sessionid='$sessionid'
                        AND exam_week='$eWeek' AND sem='$sem'");
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
                            $foundClash = checkClassClashExam($clashchecker, $conn, $courseid, $sem);
                            if ($foundClash == false) { //if no clash will occour
                                //echo "<li> $course</li>";
                                mysqli_query($conn, "INSERT INTO examschedule (edate,courseid,course,sessionid,exam_week,roomid,round,sem) 
            VALUES('$eDate','$courseid','$course','$sessionid','$eWeek','$roomId',2,'$sem')");
                                $newCapacity = $roomCapacity - $noOfStudents;
                                $roomsArray[$randomRoomIndex]['rspace'] = $newCapacity;
                                mysqli_query($conn, "UPDATE examschedule SET rspace='$newCapacity' WHERE edate='$eDate' AND sessionid='$sessionid' AND 
                                                exam_week='$eWeek' AND roomid='$roomId' AND sem='$sem'") or die(mysqli_error($conn));
                                $scheduledCourses = ["courseId" => $courseid, "sem" => $sem];
                                $clashchecker[] = $scheduledCourses;
                                unset($teacherCourses[$randomIndex]);
                                $teacherCourses = array_values($teacherCourses);

                            } //close if no clash
                        } //close if capacity ok
                    } //close array is valid
                } //close possible number of courses
                //} //close if rooms are assigned
            } //close while session
        } //end cAQurrent date
    } //end weeks

    return $teacherCourses;
}
function reallocateCoursesSup($conn, $sessionsPerCourse, $teacherCourses, $sem)
{
    $find_weeks = mysqli_query($conn, "SELECT distinct exam_week FROM examschedulesup");
    while ($wrow = mysqli_fetch_assoc($find_weeks)) {
        $eWeek = $wrow['exam_week'];
        $find_date = mysqli_query($conn, "SELECT distinct edate FROM examschedulesup WHERE exam_week='$eWeek' AND sem='$sem'");
        mysqli_data_seek($find_date, 0);
        while ($dates = mysqli_fetch_assoc($find_date)) { //dates
            $sesions = mysqli_query($conn, "Select * FROM examsessionssup");
            $clashchecker = array();
            //mysqli_data_seek($sesions, 0);

            while ($sess = mysqli_fetch_assoc($sesions)) {
                //******************************************************* */
                $roomsArray = [];
                $sessionid = $sess['id'];
                $eDate = $dates['edate'];
                $roomQuery = mysqli_query($conn, "SELECT roomid,rspace FROM examschedulesup  WHERE edate='$eDate'  AND exam_week='$eWeek' AND sessionid='$sessionid'
                            AND rspace > 0 AND sem='$sem'");
                while ($room = mysqli_fetch_assoc($roomQuery)) {
                    $roomsArray[] = $room;
                }
                for ($j = 1; $j <= $sessionsPerCourse; $j++) { //possible number of courses to insert
                    if (count($teacherCourses) > 0) { //check if array is valid
                        $randomIndex = array_rand($teacherCourses);
                        $randomCourse = $teacherCourses[$randomIndex];
                        $course = $randomCourse['subject_title'];
                        $courseid = $randomCourse['subject_id'];
                        $noOfStudents = $randomCourse['pop'];
                        $sessionid = $sess['id'];
                        $eDate = $dates['edate'];
                        $getSchedule = mysqli_query($conn, "SELECT * FROM examschedulesup WHERE edate='$eDate' AND sessionid='$sessionid'
                        AND exam_week='$eWeek' AND sem='$sem'");
                        while ($row = mysqli_fetch_assoc($getSchedule)) {
                            $clashchecker[] = $row['courseid'];
                        }
                        //room issue
                        $randomRoomIndex = array_rand($roomsArray);
                        $randomRoom = $roomsArray[$randomRoomIndex];
                        $roomCapacity = $randomRoom['rspace'];
                        $roomId = $randomRoom['roomid'];
                        if ($roomCapacity >= $noOfStudents) { // open capacity ok

                            //room issue
                            $foundClash = checkClassClashExam($clashchecker, $conn, $courseid, $sem);
                            if ($foundClash == false) { //if no clash will occour
                                //echo "<li> $course</li>";
                                mysqli_query($conn, "INSERT INTO examschedulesup (edate,courseid,course,sessionid,exam_week,roomid,round,sem) 
            VALUES('$eDate','$courseid','$course','$sessionid','$eWeek','$roomId',2,'$sem')");
                                $newCapacity = $roomCapacity - $noOfStudents;
                                $roomsArray[$randomRoomIndex]['rspace'] = $newCapacity;
                                mysqli_query($conn, "UPDATE examschedulesup SET rspace='$newCapacity' WHERE edate='$eDate' AND sessionid='$sessionid' AND 
                                                exam_week='$eWeek' AND roomid='$roomId' AND sem='$sem'") or die(mysqli_error($conn));

                                $clashchecker[] = $courseid;
                                unset($teacherCourses[$randomIndex]);
                                $teacherCourses = array_values($teacherCourses);
                            } //close if no clash
                        } //close if capacity ok
                    } //close possible number of courses to add
                } //************************************************************ */
            } //close while session
        } //end current date
    } //end weeks
    return $teacherCourses;
}
?>