<?php
require('ttFunctions.php');
require('connect.php');
$sem = showCurrentSem($conn);
$del = mysqli_query($conn, "DELETE FROM  examschedulesup WHERE sem='$sem'") or die(mysqli_error($conn));
echo json_encode(
    array(
        "res" => "<div class='alert alert-success'><i class='fas fa-check-circle'></i>
&nbsp;<button type='button' class='close' data-dismiss='alert'>&times;</button>Timetable data is reset successifully!"
    )
);

?>