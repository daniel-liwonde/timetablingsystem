<?php
require_once("connect.php");
require('ttFunctions.php');
$sem = showCurrentSem($conn);
if (isset($_GET['cname'])) {
    $cid = $_GET['cname'];
    $done = mysqli_query($conn, "SELECT * FROM examschedulesup WHERE scheduleid='$cid' AND sem='$sem'") or die(mysqli_error($conn));
    $name = mysqli_fetch_assoc($done);
    echo $name['course'];
}
if (isset($_GET['cid'])) {
    $cid = $_GET['cid'];
    $done = mysqli_query($conn, "SELECT * FROM examschedulesup INNER JOIN suppcourses ON examschedulesup.courseid=suppcourses.subject_id WHERE examschedulesup.scheduleid='$cid' AND examschedulesup.sem='$sem'") or die(mysqli_error($conn));
    $name = mysqli_fetch_assoc($done);
    $r = $name['roomid'];
    $s = $name['sessionid'];
    $w = $name['exam_week'];
    $d = $name['edate'];
    $pop = $name['pop'];
    $rspace = $name['rspace'] + $pop;

    $done = mysqli_query($conn, "DELETE FROM examschedulesup WHERE scheduleid='$cid' AND sem='$sem'") or die(mysqli_error($conn));
    if (mysqli_affected_rows($conn) > 0) {
        mysqli_query($conn, "UPDATE examschedulesup SET rspace='$rspace' WHERE roomid='$r' and sessionid='$s' and exam_week='$w' and edate='$d' AND sem='$sem'") or die(mysqli_error($conn));
        echo "Done deleting...";
    } else
        echo "failed to delete" . $cid;
}
?>