<?php
$year = date('Y');
$sem = checksem();
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
        $find_dates = mysqli_query($conn, "SELECT distinct edate FROM examschedule WHERE exam_week='$eWeek' ORDER BY edate ASC ");
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
                        $duproom = mysqli_query($conn, "SELECT * FROM examvenues ");
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
                    <td>
                        <ul>

                            <?php

                            $getSchedule = mysqli_query($conn, "SELECT * FROM examschedule WHERE edate='$cdate' AND sessionid='$sessionid'
                        AND exam_week='$eWeek' ");
                            while ($row = mysqli_fetch_assoc($getSchedule)) {
                                echo "<li>{$row['course']} </li>";
                            }
                            ?>

                        </ul>
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