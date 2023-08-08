<?php

if(isset($_POST['remove']))
						   { 
						   $del= $_POST['del_id'];
						   mysqli_query($conn,"delete from teacher_student where teacher_student_id='$del'" );
						   header("location:add_student_subject.php");
						   }
						   


?>
      $student = $_GET['id'];
							$sem= checksem();
							$current_year       = date('Y');
							$student_query = mysqli_query($conn,"select * from student where id='$student'");
							$tsd= mysqli_fetch_array($student_query);
							$admyear=$tsd['addm_year'];
							//$year_diff=$current_year - $admyear;
							$currenty= $tsd['stud_current_year'];
							$up=$tsd['year_update'];
							$entry=$tsd['joined_in'];
							$entrysem=$tsd['sem'];
							if($entrysem==1)
							{
							if(($up!=$current_year) && ($sem==1) &&($currenty<4)){
							$yearnow=$currenty+1;
							if($yearnow>4) $yearnow=4;
							}
							}
							if($entrysem==2)
							{
							if(($up!=$current_year) && ($sem==2) &&($currenty<4))
							$yearnow=$currenty+1;
							if($yearnow>4) $yearnow=4;
							}
							
							
							//if($year_diff==$currenty)
							//$cyear=$currenty; else $cyear=$year_diff;	
							if(isset($yearnow)){						
							mysqli_query($conn,"update student set stud_current_year='$yearnow',year_update='$current_year' where id='$student'");
							}
							}