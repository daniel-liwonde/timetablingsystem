<?php
require('connect.php');
$del = mysqli_query($conn, "TRUNCATE TABLE examschedulesup") or die(mysqli_error($conn));
echo json_encode(
    array(
        "res" => "<div class='alert alert-success'><i class='fas fa-check-circle'></i>
&nbsp;Timetable data is reset successifully!"
    )
);

?>