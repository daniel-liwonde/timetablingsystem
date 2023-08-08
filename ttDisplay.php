<?php
$examDays;
$sessionsPerCourse;
$coursesPerDay;


$start_date = new DateTime($_POST['start_date']);
$end_date = new DateTime($_POST['end_date']);
$interval = $start_date->diff($end_date);
$num_days = $interval->format('%a');
$num_days = $num_days + 1;
$current_date = clone $start_date;
if ($end_date <= $start_date) {
    ?>
    <div class="alert alert-danger"> <i class="fas fa-circle-exclamation"></i> &nbsp;End date can
        not be less than start date</div>
    <?php
} else {

    $scheduleDetails = array();
    $sql = "SELECT teacher.lastname, teacher.teacher_id, teacher.firstname, subject.subject_title, subject.subject_id
        FROM teacher 
        INNER JOIN subject ON teacher.teacher_id = subject.teacher_id WHERE subject.exm=0 AND subject.allocated!=2";
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
    ?>
    <div class="alert alert-info"><i class="fas fa-circle-exclamation"></i> &nbsp; The exam will be
        administered in
        <?php echo $weeks; ?> weeks, from
        <?php echo $current_date->format(" l,M d, Y") . " to " . $end_date->format("l,M d, Y") .
            "({$num_days} days)" ?>
        Courses per session:
        <?php echo $sessionsPerCourse ?> - per day
        <?php echo $coursesPerDay ?>, total days
        <?php echo $examDays ?> ,total number of courses:
        <?php echo $totalCourses ?>
    </div>

    <table border="1" class="table table-bordered" id="example">
        <tr>

            <th colspan='5' align="center">
                <?php echo "WEEK 1" ?>
            </th>

        </tr>

        <tr>
            <th> DAY</th>
            <th> VENUE</th>
            <th> TIME</th>
            <th> COURSE</th>
        </tr>
        <?php

        $i = 2;
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
                        ?>

                        <tr>
                            <th colspan='5' align="center">



                                <?php echo "WEEK{$i}" ?>
                            </th>
                        </tr>
                        <tr>
                            <th> DAY</th>
                            <th> VENUE</th>
                            <th> TIME</th>
                            <th> COURSE</th>
                        </tr>
                        <?php
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
                    ?>
                    <tr>
                        <th colspan='5' align="center">
                            <?php echo "WEEK{$i}" ?>
                        </th>
                    </tr>
                    <tr>
                        <th> DAY</th>
                        <th> VENUE</th>
                        <th> TIME</th>
                        <th> COURSE</th>
                    </tr>
                    <?php
                    $i++;
                } //close if sunday
                else { //not weekend
                    $sesions = mysqli_query($conn, "Select * FROM examsessions");
                    if (mysqli_num_rows($sesions) == 0) { //if no sessions are available
                        for ($j = 1; $j <= 2; $j++) { //session =2
                            echo "<tr>
        <td>";
                            echo $current_date->format("l, j F Y") . "<br>";
                            if ($j == 1)
                                echo "(Morning Hours)";
                            else
                                echo "(Afternoon Hours)";
                            echo "</td>";
                            ?>
                            <td>
                                <?php
                                $duproom = mysqli_query($conn, "SELECT * FROM examvenues ");
                                while ($room = mysqli_fetch_assoc($duproom))

                                    echo "{$room['room']}<br>"


                                        ?>

                                </td>
                                <td>Not Set</td>
                                <td>
                                    <ol>
                                        <?php
                                echo count($teacherCourses);
                                $clashchecker = array();
                                while (count($clashchecker) < $sessionsPerCourse) {
                                    if (count($teacherCourses) > 0) { //check if array is valid
                                        $randomIndex = array_rand($teacherCourses);
                                        $randomCourse = $teacherCourses[$randomIndex];
                                        $course = $randomCourse['subject_title'];
                                        $courseid = $randomCourse['subject_id'];
                                        $foundClash = checkClassClashExam($clashchecker, $conn, $courseid);
                                        if ($foundClash == false) {
                                            echo "<li> $course</li>";
                                            $clashchecker[] = $courseid;
                                            unset($teacherCourses[$randomIndex]);
                                            $teacherCourses = array_values($teacherCourses);
                                        }

                                    }
                                }
                                ?>
                                    <ol>
                            </td>
                            </tr>
                            <?php
                        } //close for loop session
                    } //close if no sessions are available
                    else { //sessions are available
                        while ($sess = mysqli_fetch_assoc($sesions)) { //session =2
                            echo "<tr>
        <td>";
                            echo $current_date->format("l, j F Y") . "<br>";
                            echo "({$sess['session_name']})";
                            echo "</td>";
                            ?>
                            <td>
                                <?php
                                $duproom = mysqli_query($conn, "SELECT * FROM examvenues ");
                                while ($room = mysqli_fetch_assoc($duproom))

                                    echo "{$room['room']}<br>"


                                        ?>

                                </td>
                                <td>
                                <?php echo $sess['session_from']; ?> -
                                <?php echo $sess['session_to']; ?>
                            </td>
                            <td>
                                <ol>
                                    <?php
                                    echo count($teacherCourses);
                                    $clashchecker = array();
                                    for ($j = 1; $j <= $sessionsPerCourse; $j++) {
                                        if (count($teacherCourses) > 0) { //check if array is valid
                                            $randomIndex = array_rand($teacherCourses);
                                            $randomCourse = $teacherCourses[$randomIndex];
                                            $course = $randomCourse['subject_title'];
                                            $courseid = $randomCourse['subject_id'];
                                            $foundClash = checkClassClashExam($clashchecker, $conn, $courseid);
                                            if ($foundClash == false) {
                                                echo "<li> $course</li>";
                                                $clashchecker[] = $courseid;
                                                unset($teacherCourses[$randomIndex]);
                                                $teacherCourses = array_values($teacherCourses);
                                            }

                                        }
                                    }
                                    ?>

                            </td>
                            </tr>
                            <?php
                        } //close for loop session
                    } //close sessions are available
                } //close not weekend
            } //close if not saturday
            $current_date->modify('+1 day');
        }
        echo "</table>";
        echo "<br><br>";
        echo count($teacherCourses);
}