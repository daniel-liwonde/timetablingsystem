<?php

?>
<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<head>
    <title>Timetable</title>
    <?php
    require_once('ttFunctions.php');
    require_once('connect.php');
    $sem = showCurrentSem($conn);

    header("Content-Type:application/msword");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("content-disposition: attachment;filename=$sem Weekend_Teaching_Timetable.xlx");
    ?>
</head>

<body>
    <h2>
        <center>Malawi University of Applied Sciences</center>
    </h2>
    <div class="alert alert-info text-center"><i class="icon-calendar icon-large"></i>
        <center><b>&nbsp;
                <?php echo "  $sem  Semester" ?>
            </b> Weekend Teaching Timetable
        </center>
    </div>
    <br><br>
    <?php

    displayTTExportWend($conn);
    ?>
</body>

</html>
<?php

exit; // end of word output
?>