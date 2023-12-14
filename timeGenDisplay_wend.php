<?php
require_once('connect.php');
require_once('ttFunctions.php');
$sem = showCurrentSem($conn);
$find_weeks = mysqli_query($conn, "SELECT distinct exam_week FROM examschedule");
while ($wrow = mysqli_fetch_assoc($find_weeks)) {
    $eWeek = $wrow['exam_week'];


    ?>

    <table cellpadding="10" cellspacing="0" border="1" bordercolor="#DDDDDD" width="100%">
        <tr bgcolor="#DDDDDD">

            <th colspan='4'>
                <?php echo "WEEK {$eWeek}" ?>
            </th>
        </tr>
        <tr>
            <th> DAY</th>
            <th> VENUE</th>
            <th> TIME</th>
            <th> COURSE</th>
        </tr>

        <?php
        //mysqli_data_seek($find_date, 0);
        //while ($dates = mysqli_fetch_assoc($find_date)) { //dates
        // $cdate = $dates['edate'];
        //$currentDate = new DateTime($cdate);
        //$currentDate = $currentDate->format("l, j F Y");
        $find_dates = mysqli_query($conn, "SELECT distinct edate FROM examschedule WHERE exam_week='$eWeek' AND sem='$sem'ORDER BY edate ASC ");
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
                        <?php
                        $duproom = mysqli_query($conn, "SELECT * FROM examvenues INNER JOIN rooms ON examvenues.rid=rooms.id");
                        while ($room = mysqli_fetch_assoc($duproom))

                            echo "{$room['room']}
                            <br>
                           (<font color='#61C2A2'>{$room['location']}</font>)
                            "


                                ?>

                        </td>
                        <td>
                        <?php echo $sFrom; ?> -
                        <?php echo $sTo; ?>
                    </td>

                    <td colspan="2">
                        <table class="table table-bordered table-hover" border="1">
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
                                                echo "<li>$course($students)<a title='remove' onclick='doDeleteWend(" . json_encode($course) . ",$cid)'><i class='fas fa-remove fa-sm'></i></a></li>";
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
                </td>
                </tr>

                <?php

            } //close while session
        } //end current date
        ?>
    </table>
    <?php
} //end weeks
?>