<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
require_once('connect.php');
require_once('session.php');
require_once("ttFunctions.php");
$sem = showCurrentSem($conn);
?>

<head>
    <title></title>
    <?php
    header("Content-Type:application/msword");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("content-disposition: attachment;filename=$sem _Exam_Timetable.doc");
    ?>
    <html>

    <head>
    </head>

<body>
    <h2>
        <center>
            <font color="blue">Malawi University of Business and Applied Sciences</font>
        </center>
    </h2>
    <div class="alert alert-info text-center"><i class="icon-calendar icon-large"></i>
        <center>&nbsp;
            <b>
                <?php echo "  $sem Semester" ?> Selected courses Time table
            </b>
        </center>
    </div>
    <br>
    <?php
    require_once("timeGenDisplaySup.php");
    ?>
</body>

</html>
<?php

exit; // end of word output
?>