<?php
require_once("connect.php");
require_once('ttFunctions.php');
$sem = showCurrentSem($conn);
if (isset($_GET['cid'])) {
    $cid = $_GET['cid'];
    $course = mysqli_query($conn, "SELECT * FROM schedule WHERE scheduleid='$cid'") or die("err0" . mysqli_error($conn));
    $coureseName = mysqli_fetch_assoc($course);
    $schedule = $coureseName['scheduleid'];
    $courseTitle = $coureseName['allocatedcourse'];
    $getCourse = mysqli_query($conn, "SELECT * FROM subject WHERE subject_title='$courseTitle'") or die(mysqli_error($conn));
    $coid = mysqli_fetch_assoc($getCourse);
    $ccode = $coid['subject_id'];
    $done = mysqli_query($conn, "UPDATE schedule SET allocatedcourse='',lecturerfname='',lecturerlname='', lectid=0 WHERE scheduleid='$cid'") or die(mysqli_error($conn));
    $checker = mysqli_query($conn, "SELECT * FROM checker WHERE courseid='$ccode'AND sem='$sem' ") or die("err1" . mysqli_error($conn));
    $slots = mysqli_fetch_assoc($checker);
    $numofSlots = $slots['slots'];
    if ($numofSlots = 2) {
        mysqli_query($conn, "UPDATE checker SET slots=1 WHERE courseid='$ccode'AND sem='$sem' ") or die("err2" . mysqli_error($conn));
    } else {
        mysqli_query($conn, "DELETE FROM checker WHERE courseid='$ccode' AND sem='$sem'") or die("err3" . mysqli_error($conn));
    }
    if (mysqli_affected_rows($conn) > 0) {
        echo "Done";
    } else
        echo "failed to delete";

}
?>