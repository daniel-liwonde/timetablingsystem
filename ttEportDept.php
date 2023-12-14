<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
require_once('connect.php');
require_once('session.php');
require_once("ttFunctions.php");
$sem = showCurrentSem($conn);
$lect = $_GET['Lect'];
echo "<div class='alert alert-info'><i class='icon-calendar icon-large'></i>&nbsp;Time table for:<b> $lect &nbsp;</b></div>";
?>

<head>
    <title>Departments</title>
    <?php
    header("Content-Type:application/msword");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("content-disposition: attachment;filename={$lect}_{$sem}_Timetable.doc");
    ?>
    <html>

    <head>
    </head>

<body>
    <h2>
        <center>Malawi University of Business and Applied Sciences</center>
    </h2>
    <div class="alert alert-info text-center"><i class="icon-calendar icon-large"></i>
        <center>&nbsp;Time table for:<b>
                <?php echo $lect ?>
            </b> For
            <?php echo "$sem  Semester" ?>
        </center>
    </div>
    <br><br>
    <table cellpadding="10" cellspacing="0" border="1" bordercolor="#DDDDDD" width="100%">
        <thead>
            <tr bgcolor="DDDDDD" height="30">

                <th>Day</th>
                <th>8:00am - 9:30am</th>
                <th>9:30am - 11:00am</th>
                <th>11:00am - 12:30pm</th>
                <th>12:30pm - 2:00pm</th>
                <th>2:00pm - 3:30pm</th>
                <th>3:30pm - 5:00pm</th>
            </tr>
        </thead>
        <tbody>
            <!-- end script -->

            <?php
            $findDays = mysqli_query($conn, "SELECT  distinct dayid from  schedule where dept='$lect'");
            if (mysqli_num_rows($findDays) > 0) {
                $j = 1;
                while ($day = mysqli_fetch_assoc($findDays)) {
                    $dayID = $day['dayid'];
                    $findday = mysqli_query($conn, "SELECT day FROM week_days WHERE id='$dayID'");
                    $theDay = mysqli_fetch_assoc($findday);
                    $dayName = $theDay['day'];
                    ?>
                    <tr <?php if ($j % 2 == 0) { ?> bgcolor="#DDDDDD" <?php } else { ?> bgcolor="#FFFFFF" <?php } ?>>
                        <?php
                        echo "<td>{$dayName}</td>";
                        $findslots = mysqli_query($conn, "SELECT * FROM schedule WHERE 
dayid='$dayID' AND dept='$lect' ORDER BY timeslot ASC");
                        $slots = array(); // initialize an array to store all the slots for the current day
                        while ($row = mysqli_fetch_assoc($findslots)) {
                            $slots[] = $row; // add the current row to the $slots array
                        }
                        for ($i = 0; $i < 6; $i++) {
                            $slot_found = false; // initialize a flag to check if a slot was found for the current time slot
                            foreach ($slots as $slot) {
                                if ($slot['timeslot'] == $i) {
                                    $room = $slot['roomid'];
                                    $lectName = $slot['lecturerlname'] . " " . $slot['lecturerfname'];
                                    $findroom = mysqli_query($conn, "SELECT * FROM rooms WHERE id='$room'");
                                    $theRoom = mysqli_fetch_assoc($findroom);
                                    $roomName = $theRoom['room'];
                                    $loc = $theRoom['location'];
                                    echo "<td> 
{$slot['allocatedcourse']} <br><font color='#414A4C'>($lectName)</font><br>(<font color='#61C2A2'>{$roomName} - $loc</font>)
</td> ";
                                    $slot_found = true; // set the flag to true
                                    break; // exit the foreach loop, since we found a slot for the current time slot
                                }
                            }
                            if (!$slot_found) {
                                echo "<td valign='middle' style='text-align:center; verticle:middle'>-</td>"; // if no slot was found, display a dash (-)
                            }
                        } //end for loop
                        echo "</tr>";
                        $j++;
                } //end while days
            } //end if days >0
            else { //no days found
                echo "<tr><td colspan='7'>No timetable was found for $lect </td></tr>";
            } //close no days else
            echo "</tbody></table>";
            ?>
</body>

</html>
<?php

exit; // end of word output
?>