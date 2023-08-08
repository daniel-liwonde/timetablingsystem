<?php
include('connect.php');
$get_id=$_GET['id'];
mysqli_query($conn,"update teacher set  active ='1' where teacher_id='$get_id'")or die(mysqli_error($conn));
header('location:teacher.php');
?>
