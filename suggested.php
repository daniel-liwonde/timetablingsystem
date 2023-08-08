<?php
$findDays=mysqli_query($connection,"SELECT  distinct dayid from  schedule where lectid='$lect'");											 
if(mysqli_num_rows($findDays)>0) {
    while($day=mysqli_fetch_assoc($findDays)) {
        $dayID=$day['dayid'];
   $findday=mysqli_query($connection,"SELECT day FROM week_days WHERE id='$dayID'");
	$theDay=mysqli_fetch_assoc($findday);
	$dayName=$theDay['day'];
 echo "<tr>";
 echo "<td>{$dayName}</td>";
        $findslots=mysqli_query($connection,"SELECT roomid, timeslot, allocatedcourse FROM schedule WHERE 
		dayid='$dayID' AND lectid='$lect' ORDER BY timeslot ASC");
        $slots = array(); // initialize an array to store all the slots for the current day
        while($row=mysqli_fetch_assoc($findslots)) {
            $slots[] = $row; // add the current row to the $slots array
        }
        for($i=0;$i<6;$i++) {
            $slot_found = false; // initialize a flag to check if a slot was found for the current time slot
            foreach ($slots as $slot) {
                if($slot['timeslot']==$i) {
                    $room=$slot['roomid'];
                    $findroom=mysqli_query($connection,"SELECT room FROM rooms WHERE id='$room'");
                    $theRoom=mysqli_fetch_assoc($findroom);
                    $roomName=$theRoom['room'];
                    echo "<td> 
                        {$slot['timeslot']}<br> {$slot['allocatedcourse']} <br>{$roomName}
                    </td> ";
                    $slot_found = true; // set the flag to true
                    break; // exit the foreach loop, since we found a slot for the current time slot
                }
            }
            if(!$slot_found) {
                echo "<td>-</td>"; // if no slot was found, display a dash (-)
            }
        }
        echo "</table><br>";
    }
} else {
    echo "No timetable was found for lecturer";
}
