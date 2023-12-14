<?php

require_once('ttFunctions.php');
require_once('connect.php');
if (isset($_POST['show'])) {
    $lect = $_POST['lect'];
    $sem = showCurrentSem($conn);
    $findLect = mysqli_query($conn, "SELECT  firstname,lastname from teacher where teacher_id='$lect'");
    $theName = mysqli_fetch_assoc($findLect);
    echo "<div class='alert alert-info'><i class='icon-calendar icon-large'></i>&nbsp;Time table for:<b> {$theName['lastname']} &nbsp;{$theName['firstname']}</b></div>";

    ?>

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
                    $findslots = mysqli_query($conn, "SELECT roomid, sem,timeslot, allocatedcourse FROM schedule WHERE dayid='$dayID' 
							 AND lectid='$lect' AND sem='$sem' ORDER BY timeslot ASC");


                    for ($i = 0; $i < 6; $i++) {
                        mysqli_data_seek($findslots, 0);
                        $slots = mysqli_fetch_assoc($findslots);
                        if ($slots !== null) { // check if $slots is not null
                            $room = $slots['roomid'];
                            $findroom = mysqli_query($conn, "SELECT room FROM rooms WHERE id='$room'");
                            $theRoom = mysqli_fetch_assoc($findroom);
                            $roomName = $theRoom['room'];
                            if ($slots['timeslot'] == $i) {
                                echo "<td> 
                 {$slots['allocatedcourse']} <br>({$roomName})
            </td> ";
                            } else {
                                echo "<td align='center'>-</td>";
                            }
                        } else {
                            echo "<td align='center'>-</td>"; // handle the case where $slots is null
                        }
                    }

                    echo "</tr>";
                }

            } else
                echo "No timetabe was found for lecturer";


}