<?php
require('functions.php');
$year = date('Y');
$sem = checksem();
$find_weeks = mysqli_query($conn, "SELECT distinct exam_week FROM examschedulesup");
if (mysqli_num_rows($find_weeks) == 0) {
    echo "<div class='alert alert-warning'><i class='fas fa-circle-exclamation'></i>&nbsp;There is no timetable, currently to view it generate the timetable!</div>";
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
                <th> VENUE</th>
                <th> TIME</th>
                <th> COURSES</th>
            </tr>

            <?php
            //mysqli_data_seek($find_date, 0);
            //while ($dates = mysqli_fetch_assoc($find_date)) { //dates
            // $cdate = $dates['edate'];
            //$currentDate = new DateTime($cdate);
            //$currentDate = $currentDate->format("l, j F Y");
            $find_dates = mysqli_query($conn, "SELECT distinct edate FROM examschedulesup WHERE exam_week='$eWeek' ORDER BY edate ASC ");
            while ($drow = mysqli_fetch_assoc($find_dates)) {

                $cdate = $drow['edate'];
                $currentDate = new DateTime($cdate);
                $currentDate = $currentDate->format("l, j F Y");

                $sesions = mysqli_query($conn, "SELECT * FROM examsessionssup");
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
                            <?php
                            $duproom = mysqli_query($conn, "SELECT * FROM examvenuessup INNER JOIN rooms ON examvenuessup.room=rooms.room ");
                            while ($room = mysqli_fetch_assoc($duproom))

                                echo "{$room['room']}
                                 (<font color='#61C2A2'>{$room['location']}</font>)<br>
                                "


                                    ?>

                            </td>
                            <td>
                            <?php echo $sFrom; ?> -
                            <?php echo $sTo; ?>
                        </td>
                        <td>

                            <ul>

                                <?php

                                $getSchedule = mysqli_query($conn, "SELECT * FROM examschedulesup WHERE edate='$cdate' AND sessionid='$sessionid'
                        AND exam_week='$eWeek' ");
                                while ($row = mysqli_fetch_assoc($getSchedule)) {
                                    $cid = $row["scheduleid"];
                                    $course = $row['course'];
                                    echo "<li>$course <a title='remove' onclick='doDeleteSup(" . json_encode($course) . ",$cid)'><i class='fas fa-remove fa-sm'></i></a></li>";
                                }
                                ?>

                            </ul>
                        </td>
                    </tr>
                    <?php

                } //close while session
            } //end current date
            "echo</table>";
    } //end weeks
}
?>