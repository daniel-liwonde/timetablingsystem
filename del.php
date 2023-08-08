<?php
include('connect.php');
$get_id=$_GET['id'];
mysqli_query($conn,"delete from expenses where exp_id='$get_id'")or die(mysqli_error($conn));
header('location:expenditure.php');
?>
