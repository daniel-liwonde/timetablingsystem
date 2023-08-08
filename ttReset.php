<?php
require('connect.php');
$del = mysqli_query($conn, "TRUNCATE TABLE schedule") or die(mysqli_error($conn));
$del2 = mysqli_query($conn, "TRUNCATE TABLE checker") or die(mysqli_error($conn));
mysqli_query($conn, "UPDATE subject SET allocated =0 WHERE allocated !=0 ");
echo json_encode(
    array(
        "res" => "<div class='alert alert-success'><i class='fas fa-check-circle'></i>
&nbsp;Timetable data is reset successifully!"
    )
);

?>