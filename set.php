<?php
include('conn.php'); 
if(isset($_POST['saveRoom']))
{
$roomName=$_POST['roomname'];
mysqli_query($connection,"INSERT INTO rooms(room)
		values('$roomName')")or die(mysqli_error($connection));
		
		echo"Room {$roomName} is added successifully";
	
}
?>