<?php
require_once('connect.php');
require_once('ttFunctions.php');
$clashchecker = array();
$session = $_GET['psession'];
$eDate = $_GET['examDate'];
$courseid = $_GET['pcourse'];
$week = $_GET['week'];
$current_date = new DateTime($eDate);
$holiday_dates = get_holidays($current_date->format('Y'));
$is_holiday = in_array($current_date->format('Y-m-d'), $holiday_dates);
$current_day_of_week = $current_date->format('w');
$today = Date('Y-m-d');
$today = new DateTime($today);
$td = $today->format("l, j F Y");
if ($current_date < $today) {
    echo json_encode(
        array(
            "res" => "<div class='alert alert-danger'> <i class='fas fa-circle-exclamation'></i> &nbsp;Please select a date that are not less than today {$td}</div>"
        )
    );
} else {
    // If the holiday falls on a Saturday or Sunday, skip the next Monday
    if ($current_day_of_week == 6 || $current_day_of_week == 0) {
        echo json_encode(array("res" => "<div class='alert alert-danger'><i class='icon-remove-sign'></i> &nbsp;The requested schedule is  on a weekend please select another date</div>"));
    } else {
        // Skip the iteration if the current date is a holiday
        if ($is_holiday) {
            echo json_encode(array("res" => "<div class='alert alert-danger'><i class='icon-remove-sign'></i> &nbsp;The requested schedule is on holiday please select another date</div>"));
        } else {
            $findcourse = mysqli_query($conn, "SELECT * FROM subject WHERE subject_id='$courseid'");
            $thecourse = mysqli_fetch_assoc($findcourse);
            $course = $thecourse['subject_title'];
            $dup = mysqli_query($conn, "SELECT * FROM examschedule WHERE course='$course'");
            if (mysqli_num_rows($dup) == 0) {
                $getSchedule = mysqli_query($conn, "SELECT * FROM examschedule WHERE edate='$eDate' AND sessionid='$session'");
                while ($row = mysqli_fetch_assoc($getSchedule)) {
                    $clashchecker[] = $row['courseid'];
                }
                $sessionClash = checkClassClashExam($clashchecker, $conn, $courseid);
                //START CHECK FOR TEACHER CLASHs
                if ($sessionClash == false) { //no crash will occour proceed  
                    mysqli_query($conn, "INSERT INTO examschedule (edate,courseid,course,sessionid,exam_week,pref) 
            VALUES('$eDate','$courseid','$course','$session','$week','1')");
            mysqli_query($conn,"UPDATE subject SET allocatedExam=1 WHERE subject_id='$courseid'");
                    echo json_encode(array("res" => "<div class='alert alert-success'><i class='icon-check icon-large'></i> &nbsp;{$course} Scheduled successifully! Please reflesh the page to see below</div>"));
                } //end proceed
                else {

                    echo json_encode(array("res" => "<div class='alert alert-danger'><i class='icon-remove-sign'></i> &nbsp;The requested schedlue will result in a clash, please choose another schedlue</div>"));
                }
            } else {
                echo json_encode(array("res" => "<div class='alert alert-danger'><i class='icon-remove-sign'></i> &nbsp;{$course} is already scheduled</div>"));
            }
        }
    }
}
?>