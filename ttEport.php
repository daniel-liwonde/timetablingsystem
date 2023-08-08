<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
require_once('functions.php');
require_once('ttFunctions.php');
$sem = (checksem() == 1) ? "Jan-June" : "July-Dec";
$year = date('Y');
$prvYear = $year - 1;
?>
<html>

<head>
    <title>Timetable</title>
    <?php
    header("Content-Type:application/msword");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("content-disposition: attachment;filename={$sem}_{$year}_Teaching_Timetable.xlx");
    ?>
</head>

<body>
    <h2>
        <center>Malawi University of Applied Sciences</center>
    </h2>
    <div class="alert alert-info text-center"><i class="icon-calendar icon-large"></i>
        <center><b>&nbsp;
                <?php echo "  $prvYear/$year Semester" ?>
            </b> Master Teaching Time table
        </center>
    </div>
    <br><br>
    <?php
    displayTTExport($conn);
    ?>
</body>

</html>
<?php

exit; // end of word output
?>