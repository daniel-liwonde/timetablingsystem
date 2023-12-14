<?php
require('connect.php');
require('ttFunctions.php');
$sem = showCurrentSem($conn);
$del = mysqli_query($conn, "DELETE FROM  schedule WHERE sem='$sem'") or die(mysqli_error($conn));

$del2 = mysqli_query($conn, "DELETE FROM  checker WHERE sem='$sem'") or die(mysqli_error($conn));
mysqli_query($conn, "UPDATE subject SET allocated =0 WHERE allocated !=0  AND sem='$sem'");
echo json_encode(
    array(
        "res" => "<div class='alert alert-success'><i class='fas fa-check-circle'></i>
&nbsp;Timetable data is reset successifully!"
    )
);

?>