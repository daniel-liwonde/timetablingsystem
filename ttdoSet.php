<?php
include('connect.php');
require('ttFunctions.php');
$sem = showCurrentSem($conn);
$index = $_GET["index"];
if ($index == "exam") {
    $subid = $_GET["course"];
    $sql = mysqli_query($conn, "SELECT exm FROM subject WHERE subject_id='$subid'") or die(mysqli_error($conn));
    $row = mysqli_fetch_assoc($sql);
    $status = $row['exm'];
    if ($status == '0') {
        $sql = mysqli_query($conn, "UPDATE subject SET exm=1 WHERE subject_id='$subid'") or die(mysqli_error($conn));
        $sql = mysqli_query($conn, "SELECT exm FROM subject WHERE subject_id='$subid'") or die(mysqli_error($conn));
        $row = mysqli_fetch_assoc($sql);
        $st = $row['exm'];
        echo $st;
    } else {
        $sql = mysqli_query($conn, "UPDATE subject SET exm=0 WHERE subject_id='$subid'") or die(mysqli_error($conn));
        $sql = mysqli_query($conn, "SELECT exm FROM subject WHERE subject_id='$subid'") or die(mysqli_error($conn));
        $row = mysqli_fetch_assoc($sql);
        $st = $row['exm'];
        echo $st;
    }
} else {
    $subid = $_GET["course"];
    $sql = mysqli_query($conn, "SELECT ext FROM subject WHERE subject_id='$subid'") or die(mysqli_error($conn));
    $row = mysqli_fetch_assoc($sql);
    $status = $row['ext'];
    if ($status == '0') {
        $sql = mysqli_query($conn, "UPDATE subject SET ext=1 WHERE subject_id='$subid'") or die(mysqli_error($conn));
        $sql = mysqli_query($conn, "SELECT ext FROM subject WHERE subject_id='$subid'") or die(mysqli_error($conn));
        $row = mysqli_fetch_assoc($sql);
        $st = $row['ext'];
        echo $st;
    } else {
        $sql = mysqli_query($conn, "UPDATE subject SET ext=0 WHERE subject_id='$subid'") or die(mysqli_error($conn));
        $sql = mysqli_query($conn, "SELECT ext FROM subject WHERE subject_id='$subid'") or die(mysqli_error($conn));
        $row = mysqli_fetch_assoc($sql);
        $st = $row['ext'];
        echo $st;
    }
}

?>