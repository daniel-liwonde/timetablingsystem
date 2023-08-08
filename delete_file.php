<?php
include('connect.php');
$get_id=$_GET['id'];
mysqli_query($conn,"delete from files where file_id='$get_id'")or die(mysqli_error($conn));
header('location:file.php');
?>
