<?php
include('connect.php');
$get_id=$_GET['id'];
mysqli_query($conn,"delete from user where user_id='$get_id'")or die(mysqli_error($conn));
header('location:user.php');
?>
