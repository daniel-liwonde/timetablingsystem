<?php
require_once('connect.php');
require_once('ttFunctions.php');
$sem = showCurrentSem($conn);
if ($sem == 0) {
    echo "<div class='alert alert-warning'>
		<button type='button' class='close' data-dismiss='alert'>&times;</button>
		<i class='fas fa-check-circle'></i>&nbsp; Please set the current semester under settings</div>";
} else {
    $days = mysqli_query($conn, "SELECT * FROM week_ends") or die(mysqli_error($conn));
    $rooms = mysqli_query($conn, "SELECT * FROM rooms INNER JOIN wendvenues ON rooms.id=wendvenues.rid") or die(mysqli_error($conn));

    while ($day = mysqli_fetch_assoc($days)) {
        $dayid = $day['id'];
        ?>
        <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Day</th>
                    <th>Room</th>
                    <th>8:00am - 9:30am</th>
                    <th>9:30am - 11:00am</th>
                    <th>11:00am - 12:30pm</th>
                    <th>12:30pm - 2:00pm</th>
                    <th>2:00pm - 3:30pm</th>
                    <th>3:30pm - 5:00pm</th>
                </tr>
            </thead>
            <tbody>
                <?php
                mysqli_data_seek($rooms, 0);
                while ($room_rows = mysqli_fetch_assoc($rooms)) {
                    $currentRoom = $room_rows['room'];
                    $roomLocation = $room_rows['location'];
                    $currentRoomID = $room_rows['id'];
                    $rCapacity = $room_rows['capacity'];
                    ?>
                    <tr>
                        <td>
                            <?php echo $day['day']; ?>
                        </td>
                        <td>
                            <?php echo "$currentRoom($rCapacity)<br>(<font color='#61C2A2'>$roomLocation</font>)"; ?>

                        </td>
                        <?php
                        $schedule = mysqli_query($conn, "SELECT * FROM schedule_wend WHERE roomid='$currentRoomID' AND dayid='$dayid' AND sem='$sem' ORDER BY timeslot ASC") or die(mysqli_error($conn));
                        //mysqli_data_seek($schedule, 0);
                        while ($schedule_row = mysqli_fetch_assoc($schedule)) {
                            $data = $schedule_row['allocatedcourse'];
                            $lectl = $schedule_row['lecturerlname'];
                            $lectf = $schedule_row['lecturerfname'];
                            $cid = $schedule_row['scheduleid'];
                            if ($data == null) {

                                echo "<td style='text-align:center;vertical-align:middle;''>-</td>";
                            } else {
                                $rate = mysqli_query($conn, "SELECT students FROM subject WHERE  subject_title='$data' ") or die(mysqli_error($conn));
                                if (mysqli_num_rows($rate) != 0) {
                                    $studNums = mysqli_fetch_assoc($rate);
                                    $students = $studNums['students'];
                                    ?>
                                    <td>
                                        <?php echo "$data ($students)" ?>
                                        <a title="Remove" onclick='doDeleteWend(<?php echo json_encode($data) ?>,<?php echo $cid ?>)'><i
                                                class='fas fa-remove fa-sm'></i></a></li>
                                        <br>
                                        <font color='#52595D'>
                                            <?php echo "($lectl &nbsp;$lectf )" ?>
                                        </font>


                                        <br>
                                        <?php
                                        $coid = mysqli_query($conn, "SELECT subject_id FROM subject WHERE subject_title='$data'");
                                        $subid = mysqli_fetch_assoc($coid);
                                        $subject_id = $subid['subject_id'];
                                        $classes = mysqli_query($conn, "SELECT * from course_class INNER JOIN classes ON course_class.classid=
                                 classes.classid WHERE course_class.courseid='$subject_id'");
                                        $i = 1;
                                        ?>

                                        <?php
                                        while ($r = mysqli_fetch_assoc($classes)) {

                                            if ($i == 3) {
                                                echo "<font color='#61C2A2'>{$r['classname']},</font><br>";
                                                $i = 0;
                                            } else
                                                echo "<font color='#61C2A2'>{$r['classname']}</font>,";
                                            $i++;
                                        }
                                        ?>


                                    </td>
                                    <?php
                                }
                            }
                        }
                        ?>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
        <?php
    }
}

?>