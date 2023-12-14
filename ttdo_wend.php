<?php
include('connect.php');
require('ttFunctions.php');
$sem = showCurrentSem($conn);
if (isset($_GET['course_id'])) {
    $id = $_GET['course_id'];

    $sql1 = mysqli_query($conn, "SELECT * FROM  wendcourses WHERE subject_id='$id' AND sem='$sem'") or die(mysqli_error($conn));
    if (mysqli_num_rows($sql1) > 0)
        echo json_encode(
            array(
                "res" => "<div class='alert alert-danger'><i class='fas fa-circle-exclamation'></i> &nbsp; course already added to 
    weekend  timetable!</div>"
            )
        );
    else {
        $sql = mysqli_query($conn, "SELECT * FROM subject WHERE subject_id='$id'") or die(mysqli_error($conn));
        $row = mysqli_fetch_assoc($sql);
        $code = $row['subject_code'];
        $title = $row['subject_title'];
        $teacher_id = $row['teacher_id'];
        $prog = $row['prog'];

        $coursPop = $row['students'];
        $done = mysqli_query($conn, "INSERT INTO  wendcourses(subject_title,subject_id,teacher_id,pop,sem,prog)
VALUE('$title','$id','$teacher_id','$coursPop','$sem','$prog')") or die(mysqli_error($conn));
        if ($done) { //done
            if (mysqli_affected_rows($conn) > 0) {
                echo json_encode(
                    array(
                        "res" => "<div class='alert alert-success'><i class='fas fa-circle-exclamation'></i> &nbsp; $title added to weekend
    courses!</div>"
                    )
                );
            }
        } //close done
    }
}
//remove courses
if (isset($_GET['cid'])) {
    $id = $_GET['cid'];
    $sql = mysqli_query($conn, "SELECT * FROM subject WHERE subject_id='$id'") or die(mysqli_error($conn));
    $row = mysqli_fetch_assoc($sql);
    $title = $row['subject_title'];
    $done = mysqli_query($conn, "DELETE FROM  wendcourses WHERE subject_id='$id' AND sem='$sem'") or die(mysqli_error($conn));
    if ($done) { //done
        if (mysqli_affected_rows($conn) > 0) {
            echo json_encode(
                [
                    "res" => "<div class='alert alert-success'><i class='fas fa-circle-check'></i> &nbsp; $title is removed from weekend
    courses!</div>"
                ]
            );
        }
    } //close done
}
?>