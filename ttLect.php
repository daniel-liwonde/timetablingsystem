<?php
require_once("connect.php");
require_once("ttFunctions.php");
$sem = showCurrentSem($conn);
if (isset($_GET['lect'])) {

    $lect = $_GET['lect'];
    if ($lect == "")
        echo "<div class='alert alert-danger'>Please select a lecturer</div>";
    else {
        $findLect = mysqli_query($conn, "SELECT  firstname,lastname from teacher where teacher_id='$lect'");
        $theName = mysqli_fetch_assoc($findLect);
        ?>
        <div class='alert alert-info'><i class='icon-calendar icon-large'></i>&nbsp;Time table
            for:<b>
                <?php echo $theName['lastname'] . " &nbsp;" . $theName['firstname'] ?>&nbsp; |
                &nbsp;
            </b><span style="margin-top:-5px; text-decolration:none"><b><a style="text-decoration:none"
                        href="ttEportLect.php?Lect=<?php echo $lect ?>">
                        &nbsp;Export to Word <i class="fas fa-file-export"></i></a></b></span></div>



        <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered">
            <thead>
                <tr>

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

                $findDays = mysqli_query($conn, "SELECT  distinct dayid from  schedule where lectid='$lect' AND sem='$sem'");
                if (mysqli_num_rows($findDays) > 0) {
                    while ($day = mysqli_fetch_assoc($findDays)) {
                        $dayID = $day['dayid'];
                        $findday = mysqli_query($conn, "SELECT day FROM week_days WHERE id='$dayID'");
                        $theDay = mysqli_fetch_assoc($findday);
                        $dayName = $theDay['day'];
                        echo "<tr>";
                        echo "<td>{$dayName}</td>";
                        $findslots = mysqli_query($conn, "SELECT roomid, timeslot, allocatedcourse FROM schedule WHERE 
dayid='$dayID' AND lectid='$lect' AND sem='$sem' ORDER BY timeslot ASC");
                        $slots = array(); // initialize an array to store all the slots for the current day
                        while ($row = mysqli_fetch_assoc($findslots)) {
                            $slots[] = $row; // add the current row to the $slots array
                        }
                        for ($i = 0; $i < 6; $i++) {
                            $slot_found = false; // initialize a flag to check if a slot was found for the current time slot
                            foreach ($slots as $slot) {
                                if ($slot['timeslot'] == $i) {
                                    $room = $slot['roomid'];
                                    $findroom = mysqli_query($conn, "SELECT * FROM rooms WHERE id='$room'");
                                    $theRoom = mysqli_fetch_assoc($findroom);
                                    $roomName = $theRoom['room'];
                                    $loc = $theRoom['location'];
                                    echo "<td> 
{$slot['allocatedcourse']} <br>(<font color='#61C2A2'>{$roomName} - $loc</font>)
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
                    } //end while days
                } //end if days >0
                else { //no days found
                    echo "<tr><td colspan='7'>No timetable was found for lecturer in<font color='green'> $sem </font>semester</td></tr>";
                } //close no days else
                echo "</tbody></table>";
    }
}
?>