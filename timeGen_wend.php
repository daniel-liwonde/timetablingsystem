<?php
require('ttFunctions.php');
require('connect.php');
$year = date('Y');
$sem = showCurrentSem($conn);
if ($sem == 0) {
    echo "<div class='alert alert-warning'>
		<button type='button' class='close' data-dismiss='alert'>&times;</button>
		<i class='fas fa-check-circle'></i>&nbsp; Please set the current semester under settings</div>";
} else {
    $find_weeks = mysqli_query($conn, "SELECT distinct exam_week FROM examschedule WHERE sem='$sem'");
    if (mysqli_num_rows($find_weeks) == 0) {
        echo "<div class='alert alert-warning'><i class='fas fa-circle-exclamation'></i>&nbsp;There is no timetable, please generate the timetable first!</div>";
    } else {
        while ($wrow = mysqli_fetch_assoc($find_weeks)) {
            $eWeek = $wrow['exam_week'];


            ?>
            <table border="1" class="table table-bordered">
                <tr>

                    <th colspan='5' align="center">
                        <?php echo "WEEK {$eWeek}" ?>
                    </th>

                </tr>

                <tr>
                    <th> DAY</th>

                    <th> TIME</th>
                    <th width="160"> VENUE</th>
                    <th> COURSES</th>
                </tr>

                <?php
                //mysqli_data_seek($find_date, 0);
                //while ($dates = mysqli_fetch_assoc($find_date)) { //dates
                // $cdate = $dates['edate'];
                //$currentDate = new DateTime($cdate);
                //$currentDate = $currentDate->format("l, j F Y");
                $find_dates = mysqli_query($conn, "SELECT distinct edate FROM examschedule WHERE exam_week='$eWeek'  ORDER BY edate ASC ");
                while ($drow = mysqli_fetch_assoc($find_dates)) {

                    $cdate = $drow['edate'];
                    $currentDate = new DateTime($cdate);
                    $currentDate = $currentDate->format("l, j F Y");

                    $sesions = mysqli_query($conn, "SELECT * FROM examsessions");
                    while ($sess = mysqli_fetch_assoc($sesions)) { //sessions
                        $sessionid = $sess['id'];
                        $sessionName = $sess['session_name'];
                        $sFrom = $sess['session_from'];
                        $sTo = $sess['session_to'];
                        ?>
                        <tr>
                            <td>
                                <?php echo $currentDate ?> <br>
                                (
                                <?php echo $sessionName ?>)

                            </td>
                            <td>
                                <?php echo $sFrom; ?> -
                                <?php echo $sTo; ?>
                            </td>
                            <td colspan="2">
                                <table class="table table-bordered table-hover">
                                    <?php
                                    $duproom = mysqli_query($conn, "SELECT DISTINCT examschedule.roomid,rooms.location,rooms.capacity, rooms.id,rooms.room from examschedule INNER JOIN rooms ON examschedule.roomid=rooms.id
                                
                            WHERE examschedule.edate='$cdate' AND examschedule.sessionid='$sessionid'");
                                    while ($room = mysqli_fetch_assoc($duproom)) {
                                        $roomId = $room['roomid'];
                                        ?>

                                        <tr>
                                            <td width="150">
                                                <?php
                                                echo "{$room['room']}({$room['capacity']})
                                 (<font color='#61C2A2'>{$room['location']}</font>)<br>
                                "


                                                    ?>
                                            </td>

                                            <td>
                                                <ul>

                                                    <?php

                                                    $getSchedule = mysqli_query($conn, "SELECT * FROM examschedule WHERE edate='$cdate' AND sessionid='$sessionid'
                        AND exam_week='$eWeek' AND roomid='$roomId'");
                                                    while ($row = mysqli_fetch_assoc($getSchedule)) {
                                                        $cid = $row["scheduleid"];
                                                        $course = $row['course'];
                                                        $query = mysqli_query($conn, "SELECT  students FROM subject WHERE subject_title='$course'");
                                                        $rate = mysqli_fetch_assoc($query);
                                                        $students = $rate['students'];
                                                        $round = $row['round'];
                                                        $rspace = $row['rspace'];
                                                        echo "<li>$course($students)<a title='remove' onclick='doDelete(" . json_encode($course) . ",$cid)'><i class='fas fa-remove fa-sm'></i></a></li>";
                                                    }

                                                    ?>

                                                </ul>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    ?>

                                </table>
                            </td>
                        </tr>
                        <?php

                    } //close while session
                } //end current date
                "echo</table>";
        } //end weeks
    }
}
?>