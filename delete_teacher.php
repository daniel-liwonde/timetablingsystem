<?php
include('connect.php');
$get_id=$_GET['id'];
mysqli_query($conn,"delete from teacher where teacher_id='$get_id'")or die(mysqli_error($conn));
mysqli_query($conn,"delete from teacher_student where teacher_id='$get_id'")or die(mysqli_error($conn));
header('location:teacher.php');
?>
