<?php
include('connect.php');
require_once('ttFunctions.php');
$leftSlots = array();
$leftSlots2 = array();
$clashchecker = array();
$sem = showCurrentSem($conn);
if ($sem == 0) {
	echo "<div class='alert alert-warning'>
		<button type='button' class='close' data-dismiss='alert'>&times;</button>
		<i class='fas fa-check-circle'></i>&nbsp; Please set the current semester under settings</div>";
} else {
	$num = findMaxSchedule($conn);
	$sql = "SELECT * FROM subject
         
        INNER JOIN teacher ON subject.teacher_id=teacher.teacher_id  WHERE subject.ext=0 AND subject.allocated!=2";
	$result = mysqli_query($conn, $sql);
	$teacherCourses = array();

	while ($row = mysqli_fetch_assoc($result)) {
		$teacherCourses[] = $row;
	}
	//get courses already scheduled into $clashchecker
	$getCoursesScheduled = mysqli_query($conn, "SELECT * FROM schedule WHERE sem='$sem'") or die(mysqli_error($conn));
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
					$dept = $randomCourse['prog'];
					$slot = $i;
					// find slots ,days and rooms already filled and skip them


					$findCoursesAlreadyScheduled = mysqli_query($conn, "SELECT timeslot FROM schedule WHERE dayid='$currentDayID' and timeslot='$slot'
				and roomid='$currentRoomID' and sem='$sem'");
					if (mysqli_num_rows($findCoursesAlreadyScheduled) == 0) { //continue the slot is not filled 
						//START CHECK FOR CLASS CLASH
						$classClashChecker = checkClassClash($clashchecker, $conn, $courseid, $currentDayID, $slot);
						//START CHECK FOR TEACHER CLASH
						$teacherClashChecker = checkTeacherClash($clashchecker, $teacher_id, $currentDayID, $slot, $sem);
						if (($classClashChecker == false) && ($teacherClashChecker == false)) { //no crash will occour proceed  
							//schedule course
							$check = mysqli_query($conn, "SELECT * FROM checker WHERE courseid='$courseid' and sem='$sem'");
							if (mysqli_num_rows($check) == 0) { // picked course is not scheduled give it the first slot
								//check room capacity before assigning
								if (checkRoomCompatibility($conn, $currentRoomID, $courseid) == 1) {

									$num = $num + 1;
									mysqli_query($conn, "INSERT INTO schedule(scheduleid,dayid,roomid,timeslot,allocatedcourse,
lectid,lecturerfname,lecturerlname,dept,sem)
values('$num','$currentDayID','$currentRoomID',$slot,'$course','$teacher_id','$teacherf','$teacherl','$dept','$sem')") or
										die(mysqli_error($conn));
									mysqli_query($conn, "INSERT INTO checker(courseid,slots,sem)
values('$courseid',1,'$sem')") or die(mysqli_error($conn));
									//add the course to added course array
									$addedCourseDetails = array(
										'dayid' => $currentDayID,
										'slot' => $slot,
										'teacher_id' => $teacher_id,
										'courseid' => $courseid,
										'sem' => $sem
									);
									$clashchecker[] = $addedCourseDetails;
								} //end check room capacity
								else { //keep the course for reschedule
									$leftCourseDetails = array(
										'dayid' => $currentDayID,
										'slot' => $slot,
										'room' => $currentRoomID,
										'sem' => $sem
									);
									$leftSlots[] = $leftCourseDetails;
									$num = $num + 1;
									mysqli_query($conn, "INSERT INTO schedule(scheduleid,dayid,roomid,timeslot,sem)
		values('$num','$currentDayID','$currentRoomID',$slot,'$sem')") or die(mysqli_error($conn));
								} //end keep course for reschedule
							} // end course not scheduled
							else { //course already scheduled atleast once
								$checksessions = mysqli_fetch_assoc($check);
								$checkSlots = $checksessions['slots']; //find number of slots
								if ($checkSlots == 1) {
									//give the course a second slot and update checker

									if (checkRoomCompatibility($conn, $currentRoomID, $courseid) == 1) { //check room capacity
										$num = $num + 1;
										mysqli_query($conn, "INSERT INTO
schedule(scheduleid,dayid,roomid,timeslot,allocatedcourse,lectid,lecturerfname,lecturerlname,dept,sem)
values('$num','$currentDayID','$currentRoomID',$slot,'$course','$teacher_id','$teacherf','$teacherl','$dept','$sem')") or
											die(mysqli_error($conn));
										mysqli_query($conn, "UPDATE checker SET slots=slots+1 WHERE courseid='$courseid' and sem='$sem' ");
										//since two sessions are done remove course from list
										unset($teacherCourses[$randomIndex]);
										$teacherCourses = array_values($teacherCourses);
									}
									//end check room capacity
									else { //keep course for reschedule
										$leftCourseDetails = array(
											'dayid' => $currentDayID,
											'slot' => $slot,
											'room' => $currentRoomID,
											'sem' => $sem
										);
										$leftSlots[] = $leftCourseDetails;
										$num = $num + 1;
										mysqli_query($conn, "INSERT INTO schedule(scheduleid,dayid,roomid,timeslot,sem)
		values('$num','$currentDayID','$currentRoomID',$slot,'$sem')") or die(mysqli_error($conn));
									} //end keep course for reschedule
								} //end give it second slot
							} //end course already scheduled atleast once
							//end schedule course
						} //close no clash will occour,schedule the course
						else { //clah discovered keep details for reschedule
							//$leftCourses = $teacherCourses[$randomIndex];
							$leftCourseDetails = array(
								'dayid' => $currentDayID,
								'slot' => $slot,
								'room' => $currentRoomID,
								'sem' => $sem
							);
							$leftSlots[] = $leftCourseDetails;
							$num = $num + 1;
							mysqli_query($conn, "INSERT INTO schedule(scheduleid,dayid,roomid,timeslot,sem)
		values('$num','$currentDayID','$currentRoomID',$slot,'$sem')") or die(mysqli_error($conn));
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
				$dept = $randomCourse['prog'];
				$slot = $lslot['slot'];
				$currentDayID = $lslot['dayid'];
				$currentRoomID = $lslot['room'];

				if (checkRoomCompatibility($conn, $currentRoomID, $courseid) == 1) { //check room capacity
					//START CHECK FOR CLASS CLASH

					$classClashChecker = checkClassClash($clashchecker, $conn, $courseid, $currentDayID, $slot);
					//START CHECK FOR TEACHER CLASH
					$teacherClashChecker = checkTeacherClash($clashchecker, $teacher_id, $currentDayID, $slot, $sem);
					if (($classClashChecker == false) && ($teacherClashChecker == false)) { //no crash will occour proceed  
						$check = mysqli_query($conn, "SELECT * FROM checker WHERE courseid='$courseid' and sem='$sem'");
						if (mysqli_num_rows($check) == 0) {
							mysqli_query($conn, "UPDATE schedule SET allocatedcourse='$course', lectid='$teacher_id',
				lecturerfname='$teacherf',lecturerlname='$teacherl', dept='$dept' WHERE dayid='$currentDayID' AND roomid='$currentRoomID' 
				AND timeslot='$slot' AND sem='$sem'");
							mysqli_query($conn, "INSERT INTO checker(courseid,slots,sem)
values('$courseid',1,'$sem')") or die(mysqli_error($conn));
							//add the course to added course array
							$addedCourseDetails = [
								'dayid' => $currentDayID,
								'slot' => $slot,
								'teacher_id' => $teacher_id,
								'courseid' => $courseid,
								'sem' => $sem
							];
							$clashchecker[] = $addedCourseDetails;
						} // end course not scheduled
						else { //course already scheduled atleast once
							mysqli_query($conn, "UPDATE schedule SET allocatedcourse='$course', lectid='$teacher_id',
				lecturerfname='$teacherf',lecturerlname='$teacherl',dept='$dept' WHERE dayid='$currentDayID' AND roomid='$currentRoomID' 
				AND timeslot='$slot' AND sem='$sem'");
							mysqli_query($conn, "UPDATE checker SET slots=slots+1 WHERE courseid='$courseid' AND sem='$sem' ");
							//since two sessions are done remove course from list
							unset($teacherCourses2[$randomIndex]);
							$teacherCourses2 = array_values($teacherCourses2);
						} //course scheduled once
					} //close no clash will occour
					else { //clash will occour
						$leftCourseDetails = array(
							'dayid' => $currentDayID,
							'slot' => $slot,
							'room' => $currentRoomID,
							'sem' => $sem
						);
						$leftSlots2[] = $leftCourseDetails;
					} //close clash will occour
				} //end check room capacity
				else { //keep course for reschedule
					$leftCourseDetails = array(
						'dayid' => $currentDayID,
						'slot' => $slot,
						'room' => $currentRoomID,
						'sem' => $sem
					);
					$leftSlots2[] = $leftCourseDetails;
				} //close keep slot for reschedules
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
					$dept = $randomCourse['prog'];
					$slot = $lslot['slot'];
					$currentDayID = $lslot['dayid'];
					$currentRoomID = $lslot['room'];
					if (checkRoomCompatibility($conn, $currentRoomID, $courseid) == 1) { //check room capacity
						//START CHECK FOR CLASS CLASH
						$classClashChecker = checkClassClash($clashchecker, $conn, $courseid, $currentDayID, $slot);
						//START CHECK FOR TEACHER CLASH
						$teacherClashChecker = checkTeacherClash($clashchecker, $teacher_id, $currentDayID, $slot, $sem);
						if (($classClashChecker == false) && ($teacherClashChecker == false)) { //no crash will occour proceed  
							$check = mysqli_query($conn, "SELECT * FROM checker WHERE courseid='$courseid' and sem='$sem'");
							if (mysqli_num_rows($check) == 0) {
								mysqli_query($conn, "UPDATE schedule SET allocatedcourse='$course', lectid='$teacher_id',
				lecturerfname='$teacherf',lecturerlname='$teacherl',dept='$dept' WHERE dayid='$currentDayID' AND roomid='$currentRoomID' 
				AND timeslot='$slot'and sem='$sem'");
								mysqli_query($conn, "INSERT INTO checker(courseid,slots,sem)
values('$courseid',1,'$sem')") or die(mysqli_error($conn));
								//add the course to added course array
								$addedCourseDetails = array(
									'dayid' => $currentDayID,
									'slot' => $slot,
									'teacher_id' => $teacher_id,
									'courseid' => $courseid,
									'sem' => $sem
								);
								$clashchecker[] = $addedCourseDetails;
							} // end course not scheduled
							else { //course already scheduled atleast once
								mysqli_query($conn, "UPDATE schedule SET allocatedcourse='$course', lectid='$teacher_id',
				lecturerfname='$teacherf',lecturerlname='$teacherl' WHERE dayid='$currentDayID' AND roomid='$currentRoomID' 
				AND timeslot='$slot',dept='$dept' and sem='$sem'");
								mysqli_query($conn, "UPDATE checker SET slots=slots+1 WHERE courseid='$courseid' and sem='$sem'");
								//since two sessions are done remove course from list
								unset($teacherCourses3[$randomIndex]);
								$teacherCourses3 = array_values($teacherCourses3);
							} //course scheduled once
						} //close no clash will occour
					} //close  check room capacity
				} //close if array is valid
			} //close  for each left slots
			if (count($teacherCourses3) > 0) { //failed to allocate even for the third time, reset data and regenerate
				$leftstill = (count($teacherCourses3));
				echo "<div class=' alert alert-warning'><i class='fas fa-check-circle'></i>&nbsps;Time table generated successifully however $leftstill courses could not be allocated. You can reset the 
			data and regenerate again or if you can allocate the remaing courses manually you can. Below is the list, please note that the courses might have been allocated once
			";
				echo "<ol>";
				foreach ($teacherCourses3 as $fcourse) {
					echo "<li> {$fcouse['subject_title']} </li>";
				}
				echo "</ol></div>";
			} else { //allocated  all courses third atempt
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
}
?>