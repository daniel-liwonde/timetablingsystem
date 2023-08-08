<?php
include('connect.php');
$idz = $_SESSION["id"];
mysqli_query($conn, "update user set auth='0' where user_id='$idz'") or die(mysqli_error($conn));
unset($_SESSION['id']);
unset($_SESSION['level']);

header('location:index.php');

?>