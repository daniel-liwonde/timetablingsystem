<?php
include('connect.php');
                           $uid= $_GET['uid'];
							 $code= $_GET['ccode'];
							 $y = $_GET['year'];
							  $subid= $_GET['subid'];
							  $s=$_GET['sem'];
							 /* $k= mysqli_query($conn,"select *  from results where course_code='$code' and uid='$uid' and year=$y and sem=$s " )or die(mysqli_error($conn));
							 $h=mysqli_fetch_array($k);
							 
							 if($h['fgrade']==0){ */
						   mysqli_query($conn,"delete from teacher_student where subject_id='$subid' and uid=$uid and year='$y' and semester='$s'" )or die(mysqli_error($conn));
						   mysqli_query($conn,"delete from results where course_code='$code' and uid='$uid' and year=$y and sem=$s" ) or die(mysqli_error($conn));
                         echo json_encode(array("err"=>"Deleted"));
							 /* }
							else
							 {
						echo json_encode(array("err"=>"cant delete student has marks in that year"));		 
								 
							 } */
						   
						   
						   ?>