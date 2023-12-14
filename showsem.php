<?php
require_once('connect.php');
require_once('ttFunctions.php');
$ss = mysqli_query($conn, "SELECT * FROM currentsem") or die(mysqli_error($conn));
if (mysqli_num_rows($ss) == 0)
    echo "<div class='alert alert-info'>Not set</div>";
else {
    $data = mysqli_fetch_assoc($ss);
    $s = $data['sem'];
    $max = findMaxSchedule($conn);

    echo "<span class='alert alert-info' style='margin-left:72%'><i class='fas fa-info-circle '></i> &nbsp;&nbsp;You are operating in $s semester</span";
}

?>