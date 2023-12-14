<?php
require_once('connect.php');
$sem = $_GET['sem'];
$cs = mysqli_query($conn, "SELECT * from currentsem") or die(mysqli_error($conn));
if (mysqli_num_rows($cs) == 0) {
    mysqli_query($conn, "INSERT INTO currentsem(sem) VALUES('$sem')") or die(mysqli_error($conn));
    echo "<div class='alert alert-success'>current sem set to $sem </div>";
} else {
    mysqli_query($conn, "UPDATE currentsem SET sem='$sem'") or die(mysqli_error($conn));
    echo "current sem updated to $sem ";
}

?>