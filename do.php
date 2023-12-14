<?php
include('connect.php');
require('ttFunctions.php');
$sem = showCurrentSem($conn);
if (isset($_GET['course_id'])) {
    $id = $_GET['course_id'];

    $sql1 = mysqli_query($conn, "SELECT * FROM suppcourses WHERE subject_id='$id' AND sem='$sem'") or die(mysqli_error($conn));
    if (mysqli_num_rows($sql1) > 0)
        echo json_encode(
            array(
                "res" => "<div class='alert alert-danger'><i class='fas fa-circle-exclamation'></i> &nbsp; course already added to 
    for timetabling!</div>"
            )
        );
    else {
        $sql = mysqli_query($conn, "SELECT * FROM subject WHERE subject_id='$id'") or die(mysqli_error($conn));
        $row = mysqli_fetch_assoc($sql);
        $code = $row['subject_code'];
        $title = $row['subject_title'];
        $teacher_id = $row['teacher_id'];

        $coursPop = $row['students'];
        $done = mysqli_query($conn, "INSERT INTO suppcourses(subject_title,subject_id,teacher_id,pop,sem)
VALUE('$title','$id','$teacher_id','$coursPop','$sem')") or die(mysqli_error($conn));
        if ($done) { //done
            if (mysqli_affected_rows($conn) > 0) {
                echo json_encode(
                    array(
                        "res" => "<div class='alert alert-success'><i class='fas fa-circle-exclamation'></i> &nbsp; $title added to supplimentary
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
    $done = mysqli_query($conn, "DELETE FROM suppcourses WHERE subject_id='$id' AND sem='$sem'") or die(mysqli_error($conn));
    if ($done) { //done
        if (mysqli_affected_rows($conn) > 0) {
            echo json_encode(
                [
                    "res" => "<div class='alert alert-success'><i class='fas fa-circle-check'></i> &nbsp; $title is removed from supplimentary
    courses!</div>"
                ]
            );
        }
    } //close done
}
//setting course numbers


if (isset($_GET['prog'])) {
    $subid = $_GET['course'];
    $prog = $_GET['prog'];
    $number = $_GET['number'];
    if (($subid == '') || ($prog == '') || ($number == '')) {
        echo json_encode(["res" => "<div class='alert alert-danger'><i class='fas fa-circle-exclamation'></i> &nbsp;Please fill in all required fields!</div>"]);
    } else {
        if ($subid == '00') {
            $sql = mysqli_query($conn, "SELECT * FROM course  WHERE course_id='$prog'") or die(mysqli_error($conn));
            $row = mysqli_fetch_assoc($sql);
            $title = $row["cys"];
            $done = mysqli_query($conn, "UPDATE subject SET students='$number' WHERE prog='$prog'") or die(mysqli_error($conn));
            echo json_encode(["res" => "<div class='alert alert-success'><i class='fas fa-circle-check'></i> &nbsp; number of students for all courses in  $title are  
    are set to $number!</div>"]
            );
        } else {
            $sql = mysqli_query($conn, "SELECT * FROM subject  WHERE subject_id='$subid'") or die(mysqli_error($conn));
            $row = mysqli_fetch_assoc($sql);
            $title = $row["subject_title"];
            $done = mysqli_query($conn, "UPDATE subject SET students='$number' WHERE subject_id='$subid'") or die(mysqli_error($conn));
            echo json_encode(["res" => "<div class='alert alert-success'><i class='fas fa-circle-check'></i> &nbsp; number of students for   $title is 
    are set to $number!</div>"]
            );
        }
    }
}
?>