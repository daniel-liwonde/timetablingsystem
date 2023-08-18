<?php
require('connect.php');
mysqli_query($conn, "TRUNCATE TABLE room_records") or die(mysqli_error($conn));
$del = mysqli_query($conn, "TRUNCATE TABLE examschedule") or die(mysqli_error($conn));
echo json_encode(
    array(
        "res" => "<div class='alert alert-success'><i class='fas fa-check-circle'></i>
&nbsp;Timetable data is reset successifully!"
    )
);

?>