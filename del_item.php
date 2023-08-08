<?php
include('connect.php');
$get_id=$_GET['id'];
mysqli_query($conn,"delete from budget_items where id='$get_id'")or die(mysqli_error($conn));
mysqli_query($conn,"delete from budget_line where id='$get_id'")or die(mysqli_error($conn));
mysqli_query($conn,"delete from expenses where source='$get_id'")or die(mysqli_error($conn));
header('location:settings.php');
?>
