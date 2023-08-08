<?php
include('connect.php');
require_once('ttFunctions.php');
$leftSlots = array();
$leftSlots2 = array();
$clashchecker = array();
$sql = "SELECT teacher.lastname, teacher.teacher_id, teacher.firstname, subject.subject_title, subject.subject_id
        FROM teacher 
        INNER JOIN subject ON teacher.teacher_id = subject.teacher_id WHERE subject.ext=0 AND subject.allocated!=2";
$result = mysqli_query($conn, $sql);
$teacherCourses = array();
while ($row = mysqli_fetch_assoc($result)) {
	$teacherCourses[] = $row;
}

//get courses already scheduled into $clashchecker
$getCoursesScheduled = mysqli_query($conn, "SELECT * FROM schedule") or die(mysqli_error($conn));
if (mysqli_num_rows($getCoursesScheduled) > 0) { //some courses are found
	while ($ro = mysqli_fetch_assoc($getCoursesScheduled)) {

		$currentDayID = $ro['dayid'];
		$slot = $ro['timeslot'];
		$teacher_id = $ro['lectid'];
		$courseid = $ro['subject_id'];
		$addedCourseDetails = array(
			'dayid' => $currentDayID,
			'slot' => $slot,
			'teacher_id' => $teacher_id,
			'courseid' => $courseid
		);
		$clashchecker[] = $addedCourseDetails;
	}
} //close courses found


$rooms = mysqli_query($conn, "SELECT* FROM rooms") or die(mysqli_error($conn));
$days = mysqli_query($conn, "SELECT* FROM week_days") or die(mysqli_error($conn));
while ($day_rows = mysqli_fetch_assoc($days)) {

	$currentDayID = $day_rows['id'];
	mysqli_data_seek($rooms, 0);
	while ($room_rows = mysqli_fetch_assoc($rooms)) {
		$currentRoomID = $room_rows['id'];
		for ($i = 0; $i < 6; $i++) { //start time slots

			if (count($teacherCourses) > 0) { //check if array is valid
				$randomIndex = array_rand($teacherCourses);
				$randomCourse = $teacherCourses[$randomIndex];
				//$randomCourse = $teacherCourses[array_rand($teacherCourses)];
				$teacherf = $randomCourse['firstname'];
				$teacherl = $randomCourse['lastname'];
				$course = $randomCourse['subject_title'];
				$courseid = $randomCourse['subject_id'];
				$teacher_id = $randomCourse['teacher_id'];
				$slot = $i;
				// find slots ,days and rooms already filled and skip them

				$findCoursesAlreadyScheduled = mysqli_query($conn, "SELECT timeslot FROM schedule WHERE dayid='$currentDayID' and timeslot='$slot'
				and roomid='$currentRoomID'");
				if (mysqli_num_rows($findCoursesAlreadyScheduled) == 0) { //continue the slot is not filled 
					//START CHECK FOR CLASS CLASH
					$classClashChecker = checkClassClash($clashchecker, $conn, $courseid, $currentDayID, $slot);
					//START CHECK FOR TEACHER CLASH
					$teacherClashChecker = checkTeacherClash($clashchecker, $teacher_id, $currentDayID, $slot);
					if (($classClashChecker == false) && ($teacherClashChecker == false)) { //no crash will occour proceed  
						//schedule course
						$check = mysqli_query($conn, "SELECT * FROM checker WHERE courseid='$courseid'");
						if (mysqli_num_rows($check) == 0) { // picked course is not scheduled give it the first slot

							mysqli_query($conn, "INSERT INTO schedule(dayid,roomid,timeslot,allocatedcourse,
lectid,lecturerfname,lecturerlname)
values('$currentDayID','$currentRoomID',$slot,'$course','$teacher_id','$teacherf','$teacherl')") or
								die(mysqli_error($conn));
							mysqli_query($conn, "INSERT INTO checker(courseid,slots)
values('$courseid',1)") or die(mysqli_error($conn));
							//add the course to added course array
							$addedCourseDetails = array(
								'dayid' => $currentDayID,
								'slot' => $slot,
								'teacher_id' => $teacher_id,
								'courseid' => $courseid
							);
							$clashchecker[] = $addedCourseDetails;
						} // end course not scheduled
						else { //course already scheduled atleast once
							$checksessions = mysqli_fetch_assoc($check);
							$checkSlots = $checksessions['slots']; //find number of slots
							if ($checkSlots == 1) {
								//give the course a second slot and update checker
								mysqli_query($conn, "INSERT INTO
schedule(dayid,roomid,timeslot,allocatedcourse,lectid,lecturerfname,lecturerlname)
values('$currentDayID','$currentRoomID',$slot,'$course','$teacher_id','$teacherf','$teacherl')") or
									die(mysqli_error($conn));
								mysqli_query($conn, "UPDATE checker SET slots=slots+1 WHERE courseid='$courseid' ");
								//since two sessions are done remove course from list
								unset($teacherCourses[$randomIndex]);
								$teacherCourses = array_values($teacherCourses);
							} //end give it second slot
						} //end course already scheduled atleast once
						//end schedule course
					} //close no clash will occour,schedule the course
					else { //clah discovered keep details for reschedule
						//$leftCourses = $teacherCourses[$randomIndex];
						$leftCourseDetails = array(
							'dayid' => $currentDayID,
							'slot' => $slot,
							'room' => $currentRoomID
						);
						$leftSlots[] = $leftCourseDetails;
						mysqli_query($conn, "INSERT INTO schedule(dayid,roomid,timeslot)
		values('$currentDayID','$currentRoomID',$slot)") or die(mysqli_error($conn));
						//end reserve function==========================
					} //close clash discovered
				} // close continue the slot is not filled 
			} //close if array is valid
		} //closing time slot 
	} //close available rooms
} //close fetch days
//displayResult($teacherCourses, $leftSlots)
$teacherCourses2 = $teacherCourses;
if (count($teacherCourses2) > 0) {
	foreach ($leftSlots as $lslot) {
		if (count($teacherCourses2) > 0) { //check if array is valid
			$randomIndex = array_rand($teacherCourses2);
			$randomCourse = $teacherCourses2[$randomIndex];
			//$randomCourse = $teacherCourses[array_rand($teacherCourses)];
			$teacherf = $randomCourse['firstname'];
			$teacherl = $randomCourse['lastname'];
			$course = $randomCourse['subject_title'];
			$courseid = $randomCourse['subject_id'];
			$teacher_id = $randomCourse['teacher_id'];
			$slot = $lslot['slot'];
			$currentDayID = $lslot['dayid'];
			$currentRoomID = $lslot['room'];
			//START CHECK FOR CLASS CLASH
			$classClashChecker = checkClassClash($clashchecker, $conn, $courseid, $currentDayID, $slot);
			//START CHECK FOR TEACHER CLASH
			$teacherClashChecker = checkTeacherClash($clashchecker, $teacher_id, $currentDayID, $slot);
			if (($classClashChecker == false) && ($teacherClashChecker == false)) { //no crash will occour proceed  
				$check = mysqli_query($conn, "SELECT * FROM checker WHERE courseid='$courseid'");
				if (mysqli_num_rows($check) == 0) {
					mysqli_query($conn, "UPDATE schedule SET allocatedcourse='$course', lectid='$teacher_id',
				lecturerfname='$teacherf',lecturerlname='$teacherl' WHERE dayid='$currentDayID' AND roomid='$currentRoomID' 
				AND timeslot='$slot'");
					mysqli_query($conn, "INSERT INTO checker(courseid,slots)
values('$courseid',1)") or die(mysqli_error($conn));
					//add the course to added course array
					$addedCourseDetails = array(
						'dayid' => $currentDayID,
						'slot' => $slot,
						'teacher_id' => $teacher_id,
						'courseid' => $courseid
					);
					$clashchecker[] = $addedCourseDetails;
				} // end course not scheduled
				else { //course already scheduled atleast once
					mysqli_query($conn, "UPDATE schedule SET allocatedcourse='$course', lectid='$teacher_id',
				lecturerfname='$teacherf',lecturerlname='$teacherl' WHERE dayid='$currentDayID' AND roomid='$currentRoomID' 
				AND timeslot='$slot'");
					mysqli_query($conn, "UPDATE checker SET slots=slots+1 WHERE courseid='$courseid' ");
					//since two sessions are done remove course from list
					unset($teacherCourses2[$randomIndex]);
					$teacherCourses2 = array_values($teacherCourses2);
				} //course scheduled once
			} //close no clash will occour
			else { //clash will occour
				$leftCourseDetails = array(
					'dayid' => $currentDayID,
					'slot' => $slot,
					'room' => $currentRoomID
				);
				$leftSlots2[] = $lesftCourseDetails;
			} //close clash will occour
		} //close if array is valid
	} //close  for each left slots
	$teacherCourses3 = $teacherCourses2;
	//start third attempt
	if (count($teacherCourses3) > 0) { //start third attempt
		//ALLOCATE FOR THE LAST TIME
		foreach ($leftSlots2 as $lslot) {
			if (count($teacherCourses3) > 0) { //check if array is valid
				$randomIndex = array_rand($teacherCourses3);
				$randomCourse = $teacherCourses3[$randomIndex];
				//$randomCourse = $teacherCourses[array_rand($teacherCourses)];
				$teacherf = $randomCourse['firstname'];
				$teacherl = $randomCourse['lastname'];
				$course = $randomCourse['subject_title'];
				$courseid = $randomCourse['subject_id'];
				$teacher_id = $randomCourse['teacher_id'];
				$slot = $lslot['slot'];
				$currentDayID = $lslot['dayid'];
				$currentRoomID = $lslot['room'];
				//START CHECK FOR CLASS CLASH
				$classClashChecker = checkClassClash($clashchecker, $conn, $courseid, $currentDayID, $slot);
				//START CHECK FOR TEACHER CLASH
				$teacherClashChecker = checkTeacherClash($clashchecker, $teacher_id, $currentDayID, $slot);
				if (($classClashChecker == false) && ($teacherClashChecker == false)) { //no crash will occour proceed  
					$check = mysqli_query($conn, "SELECT * FROM checker WHERE courseid='$courseid'");
					if (mysqli_num_rows($check) == 0) {
						mysqli_query($conn, "UPDATE schedule SET allocatedcourse='$course', lectid='$teacher_id',
				lecturerfname='$teacherf',lecturerlname='$teacherl' WHERE dayid='$currentDayID' AND roomid='$currentRoomID' 
				AND timeslot='$slot'");
						mysqli_query($conn, "INSERT INTO checker(courseid,slots)
values('$courseid',1)") or die(mysqli_error($conn));
						//add the course to added course array
						$addedCourseDetails = array(
							'dayid' => $currentDayID,
							'slot' => $slot,
							'teacher_id' => $teacher_id,
							'courseid' => $courseid
						);
						$clashchecker[] = $addedCourseDetails;
					} // end course not scheduled
					else { //course already scheduled atleast once
						mysqli_query($conn, "UPDATE schedule SET allocatedcourse='$course', lectid='$teacher_id',
				lecturerfname='$teacherf',lecturerlname='$teacherl' WHERE dayid='$currentDayID' AND roomid='$currentRoomID' 
				AND timeslot='$slot'");
						mysqli_query($conn, "UPDATE checker SET slots=slots+1 WHERE courseid='$courseid' ");
						//since two sessions are done remove course from list
						unset($teacherCourses3[$randomIndex]);
						$teacherCourses3 = array_values($teacherCourses3);
					} //course scheduled once
				} //close no clash will occour
			} //close if array is valid
		} //close  for each left slots
		if (count($teacherCourses3) > 0) { //failed to allocate even for the third time, reset data and regenerate
			echo "<div class=' alert alert-warning'><i class='fas fa-check-circle'></i>&nbsps;Time table generated successifully however {} courses could not be allocated. You can reset the 
			data and regenerate again or if you can allocate the remaing courses you can. Below is the list, please note that the courses might have been allocated once
			";
			echo "<ol>";
			foreach ($teacherCourses3 as $fcourse) {
				echo "<li> {$fcouse['subject_title']} </li>";
			}
			echo "</ol></div>";
		} else { //allocated third ateempt
			echo "<div class='alert alert-success'>
			<button type='button' class='close' data-dismiss='alert'>&times;</button>
			<i class='fas fa-check-circle'></i>&nbsp;Time table generated successifully in 3 attempt , all courses are allocated</div>";
		}
		//END ALLOCATE FOR THE LAST TIME
	} //end third attempt
	else { //generated second attempt
		echo "<div class='alert alert-success'>
		<button type='button' class='close' data-dismiss='alert'>&times;</button>
		<i class='fas fa-check-circle'></i>&nbsp;Time table generated successifully in 2 attempts , all courses are allocated</div>";
	} //end gegerated second attempt
} //close if teacherCourse >0 ************ 
else { //all courses allocated first attempt
	echo "<div class='alert alert-success'>
	<button type='button' class='close' data-dismiss='alert'>&times;</button>
	<i class='fas fa-check-circle'></i>&nbsp;Time table generated successifully in first attempt, all courses are allocated</div>";
}
?>