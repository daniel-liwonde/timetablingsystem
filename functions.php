<?php
include('connect.php');
//require_once ('PHPWord.php');
function checksem()
{
include('connect.php');
$current_month=date('m');
$day=getdate();
$month_day=date('d');
$year=date('Y');
 $year_day= $day['yday'];
$sel=mysqli_query($conn,"select * from  sems");
$sem1=mysqli_fetch_array($sel);
if($sem1 )
{
$start_month=$sem1['start_month'];
$end_month=$sem1['end_moth'];
$start_day=$sem1['start_date'];
$end_day=$sem1['end_date'];
$current_year=$sem1['sem_year'];
if(((($start_month==$current_month)&&($month_day>=$start_day))or (($current_month>$start_month)&&($current_month<$end_month)) or (($current_month==$end_month)&&($month_day<=$end_day))) &&($current_year==$year) || ($year_day<197))
return 1;
else
return 2;
}
}
function GenKey($length = 5)
{
  $password = "";
  $possible = "123456789ABCDEFGHJKLMNOPQRSTUVWXYZ"; 
  
  $i = 0; 
    
  while ($i < $length) { 

    
    $char = substr($possible, mt_rand(0, strlen($possible)-1), 1);
       
    
    if (!strstr($password, $char)) { 
      $password .= $char;
      $i++;
    }

  }

  return $password;

}
function GenKey2($length = 20)
{
  $password = "";
  $possible = "0123456789abcdefghijklmnopqrstuvwxyz"; 
  
  $i = 0; 
    
  while ($i < $length) { 

    
    $char = substr($possible, mt_rand(0, strlen($possible)-1), 1);
       
    
    if (!strstr($password, $char)) { 
      $password .= $char;
      $i++;
    }

  }

  return $password;
  }
  function Gen($length = 10)
{
  $password = "";
  $possible = "0123456789"; 
  
  $i = 0; 
    
  while ($i < $length) { 

    
    $char = substr($possible, mt_rand(0, strlen($possible)-1), 1);
       
    
    if (!strstr($password, $char)) { 
      $password .= $char;
      $i++;
    }

  }

  return $password;

}
function checkPayment($student_ID)
{
include('connect.php');  
$sem=checksem();
$year=date('Y');    
$sel2=mysqli_query($conn,"select * from student_fees where id='$student_ID' and year='$year' and sem='$sem' and amount_paid <>'0'")or die("here".mysqli_error($conn));
if(mysqli_num_rows($sel2)==0)
return 0;
else
return 1;
}

function grant_access()
{
include('connect.php');
$queryq = mysqli_query($conn,"select * from grade") or die(mysqli_error($conn));
    $r=mysqli_fetch_array($queryq);
	if($r)
    if($r['entry']==1)
    	return 1;
    else
    	return 0;
}
function grant_temp_access()
{
include('connect.php');
$queryq = mysqli_query($conn,"select * from  allow_temp_down") or die(mysqli_error($conn));
    $r=mysqli_fetch_array($queryq);
	if($r){
    if($r['status']==1)
    	return 1;
	}
    else
    	return 0;
}
function check_publication()
{
    include('connect.php');
$cyear=date('Y');
$csem=checksem();
if(($csem)==1){ $exam_sem_num =2; $exam_num_year = $cyear-1;}else{$exam_sem_num =1; $exam_num_year = $cyear;}    
$query3 = mysqli_query($conn,"select * from publish_results") or die(mysqli_error($conn));
			 $preqry3=mysqli_fetch_array($query3);
           if(($preqry3['year']== $exam_num_year) && ($preqry3['sem']== $exam_sem_num)) 
          return 1;
          else
          return 0;
}
function clean($con,$str) {
                    $str = @trim($str);
            
                        $str = stripslashes($str);
                    
                    return mysqli_real_escape_string($con,$str);
				
                }
				
				function calculateEOS($ass1,$ass2,$exam)
				{
				$eos= ((($ass1+$ass2)/200)*40)+(($exam/100)*60);
				return $eos;
				}
				function rateEOS($teos)
				{
				$result;
				if($teos >74.4)
				$result="D";
				else if($teos >64.4)
				$result="CP";
				else if($teos >54.4)
				$result="P";
				else if($teos >=44.9)
				$result="MP";
				else
				$result="F";
				return $result;
				}
				function calculateEOSmasters($ass1,$ass2,$exam)
				{
				$eos= ((($ass1+$ass2)/200)*50)+(($exam/100)*50);
				return $eos;
				}
				function rateEOSmasters($teos)
				{
				$result;
				if($teos >74.4)
				$result="D";
				else if($teos >64.4)
				$result="CP";
				else if($teos >54.4)
				$result="P";
				else if($teos >49.4)
				$result="MP";
				else
				$result="F";
				return $result;
				}
					
				
				
				
				function repeat2()
				{
				    include('connect.php');
				$cv= mysqli_query($conn,"select * from results where comment='F' and repeated='0'") or die(mysqli_error($conn));
							 while($get=mysqli_fetch_array($cv)){
							  $code=$get['course_code'];
							  $id=$get['uid'];
							  if($get['sem']!=checksem()){
                             $repeat_courses = mysqli_query($conn,"select * from results where uid='$id' and comment='F' and repeated='0'") or die(mysqli_error($conn));
							if(mysqli_num_rows($repeat_courses)>0){
							$sem= checksem();
							$year       = date('Y');
                           $courses = mysqli_fetch_assoc($repeat_courses);
						   $co_code=$courses['course_code'];
						   $subjects = mysqli_query($conn,"select * from subject where subject_code= '$co_code'");
						   while($subject=mysqli_fetch_array($subjects)){
						   $subid= $subject['subject_id'];
						   $teacher=$subject['teacher_id'];
						   $id=$courses['uid'];
						   $y=$courses['year'];
						   $s=$courses['sem'];
						    mysqli_query($conn,"insert into teacher_student(teacher_id,uid,year,semester,subject_id,being_repeated) values('$teacher','$id','$year','$sem','$subid','1')") or die(mysqli_error($conn));	
							mysqli_query($conn,"update results set repeated='1' where uid='$id' and sem='$s' and year='$y' and course_code='$co_code'");
						
				}
				}
				}
				}
				}
				
				
				function repeat($repid)
				{
					include('connect.php');
					$sem=checksem();
				    if($sem==1){
					$tsem=2; $t =date('Y')-1; $tyear=$t;}
						else{
							$tsem=1; $tyear = date('Y');
						}
					
							 // if($get['sem']!=checksem()){
                             $repeat_courses = mysqli_query($conn,"select * from results where uid='$repid' and comment='F'  and sem=$tsem and year=$tyear") or die(mysqli_error($conn));
							if(mysqli_num_rows($repeat_courses)>0){
							
						        $detail = mysqli_query($conn,"select * from student where id='$repid'") or die(mysqli_error($conn));
								$find=mysqli_fetch_array($detail);
								 $fname=	$find['firstname'];
						         $lname=	$find['lastname'];
								      $prog=	$find['cys'];
						         $idz=$find['student_id'];
							     $year       = date('Y');
								 $dept= $find['dept'];
								 $cyear=$find['stud_current_year'];
								 $csem=$find['current_sem'];
								 $mode=$find['mode'];
                           while($courses = mysqli_fetch_array($repeat_courses)){
						   $co_code=$courses['course_code'];
						
						   
						 
						   $subjects = mysqli_query($conn,"select * from subject where subject_code= '$co_code'");
						   $subject=mysqli_fetch_array($subjects);
						   $subid= $subject['subject_id'];
						   $teacher=$subject['teacher_id'];
						   $id=$courses['uid'];
						   $y=$courses['year'];
						   $s=$courses['sem'];
						   $dup= mysqli_query($conn,"SELECT * FROM teacher_student WHERE teacher_id= '$teacher' AND uid='$id' and year='$year' and semester='$sem' and subject_id='$subid'") or die(mysqli_error($conn));	
						   if(mysqli_num_rows($dup)==0){
						    mysqli_query($conn,"insert into teacher_student(teacher_id,uid,year,semester,subject_id,being_repeated) values('$teacher','$id','$year','$sem','$subid','1')") or die(mysqli_error($conn));	
							mysqli_query($conn,"update results set repeated='1' where uid='$id' and sem='$tsem' and year='$tyear' and course_code='$co_code'");
						    mysqli_query($conn,"insert into results(studsem,dept,prog,mode,uid,sem,firstname,surname,student_id,comment,course_code,year,stud_year) values('$csem','$dept','$prog','$mode','$id','$sem','$fname','$lname','$idz','F','$co_code','$year','$cyear')");
						   }
				
				}
				}
				//}
				}
				function updyearandsem($myidz)
				{
					include('connect.php');
				  $cyear=date('Y');
							 $student = $myidz;
							 $ss=checksem();
							
							 $m = mysqli_query($conn,"select * from student where id='$student'") or die(mysqli_error($conn));
							 $r=mysqli_fetch_array($m);
							
							 $system_sem=$r['system_sem'];
							 $studcurrentyear=$r['stud_current_year'];
							 $sy= $studcurrentyear;
							 $updated_year=$r['update_year'];
							 $program=$r['cys'];
							 $current_ss=$r['current_sem'];
							if(($ss==$system_sem) &&  ($updated_year!=$cyear)){ 
						
							 $studcurrentyear=$studcurrentyear+1;
							  if(($program=='BLW')&& ($studcurrentyear>5))$studcurrentyear=5; 
							 if(($studcurrentyear>4)&& ($program!='BLW'))$studcurrentyear=4;
							 mysqli_query($conn,"update student set stud_current_year='$studcurrentyear', update_year='$cyear' where id='$student'") or die(mysqli_error($conn));
							 } 
							
							 
						     if($ss==$system_sem)
							   $current_sem=1;
							   else
							 $current_sem=2;
							 
							 if((($sy==4)&&($current_ss==2) && ($program!='BLW'))|| (($sy==5)&&($current_ss==2) && ( $program=='BLW')))
							  $current_sem=2;
							 mysqli_query($conn,"update student set current_sem='$current_sem' where id='$student'") or die(mysqli_error($conn));
							 }
							 
				
			function calculateinterest($sid,$month,$mday)
				{
					include('connect.php');
				$sem=checksem();			
				//$month=date('m');
				//$mday=date('d');
				$year=date('Y');
				$status=mysqli_query($conn,"select * from interest") or die(mysqli_error($conn));
				$check=mysqli_fetch_array($status);
				$guess=$check['year_day'];
				$stmode=mysqli_query($conn,"select * from student where id='$sid'") or die(mysqli_error($conn));
				$mode=mysqli_fetch_array($stmode);
				$modest=$mode['mode'];
				$duefee=mysqli_query($conn,"select * from student_fee_amounts") or die(mysqli_error($conn));
				$fees=mysqli_fetch_array($duefee);
				$dis=$fees['distance'];
				$full=$fees['fulltime'];
				$biu=$fees['biu'];
				$nobiu=$fees['nobiu'];
				if($modest==1) $yourfees=$full; 
				if($modest==2) $yourfees=$dis;
				if($modest==3) $yourfees=$biu; 
				if($modest==4) $yourfees=$nobiu; 
				$i=mysqli_query($conn,"select * from interest") or die(mysqli_error($conn));
				$am=mysqli_fetch_array($i);
				$rday=$am['amount'];
				$q=$yourfees/4;
				if($year%4==0) $feb=29;else $feb=28;
				$feb= $feb*$rday*$q;
				$march=31*$rday*($q*2);
				$april=30*$rday*($q*3);
				$may=31*$rday*($q*4);
				$june=30;
				$aug=31*$rday*$q;
				$sept=30*$rday*($q*2);
				$oct=31*$rday*($q*3);
				$nov=30*$rday*($q*4);
				if($year%4==0) $feb2=29;else $feb2=28;
		         $march2=31;
				 $april2=30;
				 $may2=31;
				 $aug2=31;
				 $sept2=30;
				 $oct2=31;
				 $nov2=30;
				
				
				$fee=mysqli_query($conn,"select * from student_fees where id='$sid' and year='$year' and sem='$sem'") or die(mysqli_error($conn));
				if(mysqli_num_rows($fee)==0)
				{//if fees equal zero
				if($sem==1)
				{//open sem1
				
				if($month==1)//january
				$int=0;
				if($month==2)//feb
				$int=$mday*$rday*$q;
				if($month==3) //march
				{
				$current=$mday*$rday*($q*2);
				$int=$feb+$current;
				}
				if($month==4)//aprial
				{
				$current=$mday*$rday*($q*3);
				$int=$feb+$march+$current;
				}
				if($month==5)//may
				{
				$current=$mday*$rday*($q*4);
				$int=$feb+$march+$april+$current;
				}
				if($month==6)//june
				{
				$current=$mday*$rday*($q*4);
				$int=$feb+$march+$april+$may+$current;
				}
				}//close sem=1
				else
				{//open sem=2				
				if($month==7)//july
				$int=0;
				if($month==8)//august
				$int=$mday*$rday*$q;
				if($month==9) //sept
				{
				$current=$mday*$rday*($q*2);
				$int=$aug+$current;
				}
				if($month==10)//oct
				{
				$current=$mday*$rday*($q*3);
				$int=$aug+$sept+$current;
				}
				if($month==11)//nov
				{
				$current=$mday*$rday*($q*4);
				$int=$aug+$sept+$oct+$current;
				}
				if($month==12)//dec
				{
				$current=$mday*$rday*($q*4);
				$int=$aug+$sept+$oct+$nov+$current;
				}
				}//close sem =2
				}//close fee ==0
				else
				{//open payment found
				$row=mysqli_fetch_array($fee);
				$row2=$row['total_amount'];
				$pday=$row['pay_day'];
				$pmonth=$row['pmonth'];
				if($sem==1){
				  if($month==1){//jan
				 $int=0;
				 }
				 if($month==2){//feb
				 $rem=$q-$row2;
				 if(($rem==0)||($rem<0))
				 $int=0;else $int=$mday*$rday*$rem;
				 }
				  if($month==3){//march
				 if($row2>=(2*$q))//paid jan and feb
				 $int=0;
				 else{ //paid fully jan but not feb
				 $rem=(2*$q)- $row2;
				 if($pmonth==1)//paid jan
				 {
				 $prvdays=$feb2*$rday*$rem;
				 $current=$mday*$rday*($q+$rem);
				 $int=$prvdays+$current;
				 }
				 else{ //paid in feb
				$prvdays=($feb2-$pday)*$rday*$rem;		 
				$current=$mday*$rday*($q+$rem);
                $int=$prvdays+$current;				
				 }
				 }
				 }//march closed
				  if($month==4){//aprial
				 if($row2 >= (3*$q)) //paid jan,feb, march
				 $int=0;
				 else{ // have interest
				 //$rem=(3*$q)- $row2;
				 if($pmonth==1){//paid jan
				 $rem=$q-$row2;
				 if($rem>0)
				 $febint=$feb2*$rday*$rem;
			     else
					$febint=0;
                 $rem=($q*2)-$row2;	
                  if($rem>0)				 
				 $marchint=$march2*$rday*$rem;
			 else
				$marchint=0; 
			   $rem=($q*3)-$row2;
                if($rem>0)			   
				 $apint= $mday*$rday*$rem;
			 else
				  $apint=0;
			     $int=$febint+$marchint+$apint;
				 }
				 else if($pmonth==2){//paid in feb
				 $rem= $q-$row2;
				 if($rem>0)
                   $febint=($feb2-$pday)*$rem*$rday;
                   else	
                $febint =0;	
			      $rem= ($q*2)-$row2;
				   if($rem>0)
                $marchint=$march2*$rday*$rem;
                 else	
                $marchint=0;
			     $rem=(3*$q)- $row2;
				 if($rem>0)
                $current=$mday*$rday*$rem;
                  else
              $current=0;					  
				 $int= $febint+$marchint+$current;
				 }//close feb
				 else{ //paid in march
				   $rem=(2*$q)- $row2;
				 if($rem>0)
					$marchdays= ($march2-$pday)*$rem*$rday;
				else
					$marchdays=0;
                    
					$rem=(3*$q)- $row2;
				 if($rem>0)
                $current=$mday*$rday*$rem;
                  else
              $current=0;
		       $int= $marchdays+$current;
				 }//close march					
				 }//close have interest
				 }//close  aprial
				 if(($month==5)or ($month==6)){//may or june
				 if($row2>=(4*$q))//no interest
				 $int=0;
				 else{ //has interest
				 //$rem=(4*$q)- $row2; 
				 if($pmonth==1)//paid in jan
				 {//open 1 
				$rem=$q-$row2;
				 if($rem>0)
				 $febint=$feb2*$rday*$rem;//feb
			     else
					$febint=0;
                 $rem=($q*2)-$row2;	
                  if($rem>0)				 
				 $marchint=$march2*$rday*($q+$rem);//march
			 else
				$marchint=0; 
			   $rem=($q*3)-$row2;
                if($rem>0)			   
				 $apint= $april2*$rday*(($q*2)+$rem);//april
			 else
				  $apint=0;
			  
			  $rem=($q*4)-$row2;
                if($rem>0)			   
				 $mayint= $mday*$rday*(($q*3)+$rem);//april
			 else
			$mayint=0;
			  
			     $int=$febint+$marchint+$apint+$mayint;  
				 }//close1
				 else if($pmonth==2){ //paid in feb
					 {//open2 
					$rem= $q-$row2;
				 if($rem>0)
                   $febint=($feb2-$pday)*$rem*$rday;
                   else	
                $febint =0;	
			      $rem= ($q*2)-$row2;
				   if($rem>0)
                $marchint=$march2*$rday*($q+$rem);
                 else	
                $marchint=0;
			     $rem=(3*$q)- $row2;
				 if($rem>0)
                $current=$mday*$rday*(($q*2)+$rem);
                  else
              $current=0;					  
				 $int= $febint+$marchint+$current;	  
					 }//close2
				            }//close paid in feb
				  else if($pmonth==3){ //paid in march
				$rem=(2*$q)- $row2;
				 if($rem>0)
					$marchdays= ($march2-$pday)*$rem*$rday;//march bal
				else
					$marchdays=0;
					$rem=(3*$q)- $row2;
				 if($rem>0)
                $app=$april2*$rday*($q+$rem);//appril int
                  else
              $app=0;
		       $rem=(4*$q)- $row2;
				 if($rem>0)
                $current=$mday*$rday*(($q*2)+$rem);//appril int
                  else
             $current=0;
		       
                    $int= $marchdays+$app+$current;
				  }//close paid in march
				 else{ // last paid in april
				  $rem=(4*$q)- $row2;
				   if($rem>0)
					$aprildays= ($april2-$pday)*$rday*$rem;
					else
						$aprildays=0;
					$current=$mday*$rday*($q+$rem);
				    $int=$aprildays+$current;
				 }//paid last in april
				 }//close has interest
				 }//close may or june
				 }//close sem==1
				 else
				 {//open sem2
				 if($month==7){//july
				 $int=0;
				 }
				 if($month==8){//aug
				 $rem=$q-$row2;
				 if(($rem==0)||($rem<0))
				 $int=0;else $int=$mday*$rday*$rem;
				 }
				  if($month==9){//sept
				 if($row2>=(2*$q))//paid july and aug
				 $int=0;
				 else{ //paid fully july but not aug
				 $rem=(2*$q)- $row2;
				 if($pmonth==7)//paid july
				 {
				 $prvdays=$aug2*$rday*$rem;
				 $current=$mday*$rday*$rem;
				 $int=$prvdays+$current;
				 }
				 else{ //paid in aug
				$prvdays=($aug2-$pday)*$rday*$rem;		 
				$current=$mday*$rday*$rem;
                $int=$prvdays+$current;				
				 }
				 }
				 }//SEPT closed
				  if($month==10){//aprial
				 if($row2 >= (3*$q)) //paid jan,feb, march
				 $int=0;
				 else{ // have interest
				 //$rem=(3*$q)- $row2;
				 if($pmonth==7){//paid july
				 $rem=$q-$row2;
				 if($rem>0)
				 $AUGint=$aug2*$rday*$rem;
			     else
					$AUGint=0;
                 $rem=($q*2)-$row2;	
                  if($rem>0)				 
				 $SEPint=$sept2*$rday*$rem;
			 else
				$SEPint=0; 
			   $rem=($q*3)-$row2;
                if($rem>0)			   
				 $OCTint= $mday*$rday*$rem;
			 else
				  $OCTint=0;
			     $int=$AUGint+$SEPint+$OCTint;
				 }
				 else if($pmonth==8){//paid in aug
				 $rem= $q-$row2;//AUG REM
				 if($rem>0)
                   $AUGint=($aug2-$pday)*$rem*$rday;
                   else	
                $AUGint =0;	
			      $rem= ($q*2)-$row2;//SEPT REM
				   if($rem>0)
                $SEPint=$sept2*$rday*$rem;
                 else	
                $SEPint=0;
			     $rem=(3*$q)- $row2;
				 if($rem>0)
                $current=$mday*$rday*$rem;
                  else
              $current=0;					  
				 $int= $AUGint+$SEPint+$current;
				 }//close aug
				 else{ //paid in sept
				   $rem=(2*$q)- $row2;
				 if($rem>0)
					$SEPdays= ($sept2-$pday)*$rem*$rday;
				else
					$SEPdays=0;
					$rem=(3*$q)- $row2;
				 if($rem>0)
                $current=$mday*$rday*$rem;
                  else
              $current=0;
		       $int= $SEPdays+$current;
				 }//close sept				
				 }//close have interest
				 }//close  oct
				 if(($month==11) or ($month==12)){//nov/dec
				 if($row2>=(4*$q))//no interest
				 $int=0;
				 else{ //has interest
				 //$rem=(4*$q)- $row2; 
				 if($pmonth==7)//paid in july
				 {//open PAID IN JULY-NOW IN NOV
				$rem=$q-$row2;
				 if($rem>0)
				 $AUGint=$aug2*$rday*$rem;//aug int-PAY JUL
			     else
					$AUGint=0;
                 $rem=($q*2)-$row2;	//SEP INT-PAY JUL
                  if($rem>0)				 
				 $SEPint=$sept2*$rday*$rem;//SEP
			 else
				$SEPint=0; 
			   $rem=($q*3)-$row2; //OCT BAL-PAY JUL
                if($rem>0)			   
				 $OCTint= $oct2*$rday*$rem;//OCT INT-PAY JUL
			 else
				  $OCTint=0; //NO OCT INT-PAY JUL
			  
			  $rem=($q*4)-$row2; //NOV REM-PAY JUL
                if($rem>0)			   
				 $NOVint= $mday*$rday*$rem;//NOV INT-PAY JUL
			 else
			$NOVint=0; //NO INT IN NOV-PAY JUL
			  
			     $int=$AUGint+$SEPint+$OCTint+$NOVint;  //TOTAL INT IN NOV -PAYED JUL
				 }//close1-PAYED JUL
				 else if($pmonth==8) //PAID LAST IN AUG-NOW IN NOV
					 {//open PAID AUG -NOW IN NOV 
					$rem= $q-$row2;//AUG REM
				 if($rem>0)
                   $AUGint=($aug2-$pday)*$rem*$rday;//AUG INT MINUS DAYS ALREADY PAID
                   else	
                $AUGint =0;	
			      $rem= ($q*2)-$row2;//SEPT BAL
				   if($rem>0)
                $SEPint=$sept2*$rday*$rem;//SEPT INT 
                 else	
                $SEPint=0;// NO SEPT 
			     $rem=(3*$q)- $row2;// OCT BAL-PAID AUG
				 if($rem>0)
					 $OCTint=$oct2*$rday*$rem;//OCT INT -PAID AUG
				 else
					 $OCTint=0;
				 $rem=(4*$q)- $row2;// OCT BAL-PAID AUG
				   if($rem>0)
                $current=$mday*$rday*$rem;//OCT INT-PAID AUG
                  else
              $current=0;					  
				 $int= $AUGint+$SEPint+$OCTint+$current;//TOTAL INT -PAID AUG	  
					 }//close PAID AUG NOW IN NOV
				           
				  else if($pmonth==9){ //PAID LAST IN SEP-NOW IN NOV
				$rem=(2*$q)- $row2;
				 if($rem>0)
					$SEPint= ($sept2-$pday)*$rem*$rday;//sept bal
				else
					$SEPint=0;
					$rem=(3*$q)- $row2;// OCT BAL PAID SEP LAST
				 if($rem>0)
                $OCTint=$oct2*$rday*($q+$rem);//oct int
                  else
              $OCTint=0;
		       $rem=(4*$q)- $row2;
				 if($rem>0)
                $current=$mday*$rday*$rem;//oct int
                  else
             $current=0;
		       
                    $int= $SEPint+$OCTint+$current;// TOTAL INT IN NOV
				  }//close paid in sept
				 else{ // last paid in oct
				  $rem=(3*$q)- $row2;
				   if($rem>0)
					$OCTint= ($oct2-$pday)*$rday*$rem;
					else
						$OCTint=0;
					$current=$mday*$rday*($q+$rem);
				    $int=$OCTint+$current;//TOTAL INT IN NOV
				 }//paid last in oct
				 }//close has interest
				 }//close nov
				 }//close sem=2
				 }//close payment found
				 if(isset($int)){
				 if($guess==2)$int=0;else  $int=$int;				
				 return $int;
				 }
				 }
 function databaseOutput() {
	 include('connect.php');

		 if(isset($_GET['send'])){
							$su_id=$_GET['sub'];
							$year=$_GET['year'];
							$sem=$_GET['sem'];
     $query = mysqli_query($conn,"select * from results where course_code='$su_id' and year='$year' and sem='$sem'") or die(mysqli_error($conn));
	 $total=mysqli_num_rows($query);
	  $f = mysqli_query($conn,"select * from results where course_code='$su_id' and year='$year' and sem='$sem' and comment='F' and mode='1'") or die(mysqli_error($conn));
	  $fail=mysqli_num_rows($f);
	  $d = mysqli_query($conn,"select * from results where course_code='$su_id' and year='$year' and sem='$sem' and mode='2'") or die(mysqli_error($conn));
	     $ds=mysqli_num_rows($d);
		 $ft = mysqli_query($conn,"select * from results where course_code='$su_id' and year='$year' and sem='$sem' and mode='1'") or die(mysqli_error($conn));
	     $ftt=mysqli_num_rows($ft);
	   $p = mysqli_query($conn,"select * from results where course_code='$su_id' and year='$year' and sem='$sem' and comment='P' and mode='1'") or die(mysqli_error($conn));
	    $pass=mysqli_num_rows($p);
	    $cp = mysqli_query($conn,"select * from results where course_code='$su_id' and year='$year' and sem='$sem' and comment='CP' and mode='1'") or die(mysqli_error($conn));
	     $cpz=mysqli_num_rows($cp);
		  $mp = mysqli_query($conn,"select * from results where course_code='$su_id' and year='$year' and sem='$sem' and comment='MP' and mode='1'") or die(mysqli_error($conn));
	     $mpz=mysqli_num_rows( $mp);
		 $d = mysqli_query($conn,"select * from results where course_code='$su_id' and year='$year' and sem='$sem' and comment='D' and mode='1'") or die(mysqli_error($conn));
	     $dz=mysqli_num_rows($d);
		  $fd = mysqli_query($conn,"select * from results where course_code='$su_id' and year='$year' and sem='$sem' and comment='F' and mode='2'") or die(mysqli_error($conn));
	  $faild=mysqli_num_rows( $fd);
	   $pd = mysqli_query($conn,"select * from results where course_code='$su_id' and year='$year' and sem='$sem' and comment='P' and mode='2'") or die(mysqli_error($conn));
	    $passd=mysqli_num_rows($pd);
	    $cpd = mysqli_query($conn,"select * from results where course_code='$su_id' and year='$year' and sem='$sem' and comment='CP' and mode='2'") or die(mysqli_error($conn));
	     $cps=mysqli_num_rows($cpd);
		  $mpd = mysqli_query($conn,"select * from results where course_code='$su_id' and year='$year' and sem='$sem' and comment='MP' and mode='2'") or die(mysqli_error($conn));
	     $mps=mysqli_num_rows( $mpd);
		 $dd = mysqli_query($conn,"select * from results where course_code='$su_id' and year='$year' and sem='$sem' and comment='D' and mode='2'") or die(mysqli_error($conn));
	     $dzd=mysqli_num_rows($dd);
		  $masF = mysqli_query($conn,"select * from results where course_code='$su_id' and year='$year' and sem='$sem' and comment='F' and category='1'") or die(mysqli_error($conn));
	  $msF=mysqli_num_rows($masF);
	   $masP = mysqli_query($conn,"select * from results where course_code='$su_id' and year='$year' and sem='$sem' and comment='P' and category='1'") or die(mysqli_error($conn));
	    $msP=mysqli_num_rows($masP);
	    $masCP = mysqli_query($conn,"select * from results where course_code='$su_id' and year='$year' and sem='$sem' and comment='CP' and category='1'") or die(mysqli_error($conn));
	     $msCP=mysqli_num_rows($masCP);
		  $masMP = mysqli_query($conn,"select * from results where course_code='$su_id' and year='$year' and sem='$sem' and comment='MP' and category='1'") or die(mysqli_error($conn));
	     $msMP=mysqli_num_rows($masMP);
		 $masD = mysqli_query($conn,"select * from results where course_code='$su_id' and year='$year' and sem='$sem' and comment='D' and category='1'") or die(mysqli_error($conn));
		 $msD=mysqli_num_rows($masD);
		  $Tmas = mysqli_query($conn,"select * from results where course_code='$su_id' and year='$year' and sem='$sem' and category='1'") or die(mysqli_error($conn));
	  $Tms=mysqli_num_rows($Tmas);
		 if($total>0){
		  while ($row = mysqli_fetch_array($query)) {
                           $student_id = $row['student_id'];
						    $uid = $row['uid'];
							 $teacher_students = mysqli_query($conn,"select * from student where id='$uid'") or die(mysqli_error($conn));
                           $student_row = mysqli_fetch_array($teacher_students);
						   $results = mysqli_query($conn,"select * from subject where subject_code='$su_id'") or die(mysqli_error($conn));            
						   $results_row = mysqli_fetch_array($results);
						   ?>
						   <td><?php echo $student_row ['student_id']; ?></td>
                                    <td> <?php echo   $student_row ['lastname']; ?></td>
                                    <td><?php echo    $student_row ['firstname']; ?></td>
                              <td><?php if ($row['mode']==1) echo 'F';  if ($row['mode']==2) echo 'D';?></td> 
                             <td> <?php echo $row ['course_code']?></td>  
                              <td><?php echo $row['assign_1']?> </td> 
                              <td> <?php echo $row['assign_2'] ?></td> 
                    <td><?php echo $row['EOS'] ?></td>
                    <td><?php echo $row['fgrade'] ?></td>
                              <td><?php echo $row['comment'] ?></td>
                                 <td><?php echo $row['year']; ?></td>
                                 </tr>
                        <?php } 
						
						
						?>
                        
						<div class="alert alert-info"><strong style="color:#FF0000; text-transform:uppercase;"><center><?php echo $results_row['subject_title']."&nbsp;&nbsp;".$year. "&nbsp;&nbsp;";if($sem==1)echo "Jan-June";else echo "July-Dec"?>&nbsp;SEMESTER  &nbsp;SUMMARY</strong></center><br>
                         <?php if ( $results_row['category']!=1){?>
                        <div class="alert alert-danger"><center><strong>DISTANCE STUDENTS</strong></center><br />
                        <?php echo "<b>F:</b>" .$faild."&nbsp;&nbsp;&nbsp;&nbsp;<b>P:</b>" .$passd."&nbsp;&nbsp;&nbsp;&nbsp;<b>CP:</b>" .$cps ."&nbsp;&nbsp;&nbsp;&nbsp;<b>MP:</b>" .$mps."&nbsp;&nbsp;&nbsp;&nbsp;<b>D:</b>" .$dzd; ?>&nbsp;&nbsp; <b>Total Passes:</b><?php $ss= ($passd+$cps+$mps+$dzd); echo $ss;?><b> Total Fails:</b> <?php echo $faild ?>&nbsp;&nbsp;<b>Total distance:</b><?php echo $ds  ?>&nbsp;&nbsp;<b>Pass Rate:</b> <?php if($ds==0){$ds=1;} $s= (($ss/$ds)*100); echo round($s,1)."%" ?>
                        </div>
                        <div class="alert alert-danger"><center><strong >FULLTIME STUDENTS</strong></center><br />
                        <?php echo "<b>F:</b>" .$fail."&nbsp;&nbsp;&nbsp;&nbsp;<b>P:</b>" .$pass."&nbsp;&nbsp;&nbsp;&nbsp;<b>CP:</b>" .$cpz ."&nbsp;&nbsp;&nbsp;&nbsp;<b>MP:</b>" .$mpz."&nbsp;&nbsp;&nbsp;&nbsp;<b>D:</b>" .$dz; ?> &nbsp;&nbsp; <b>Total Passes:</b><?php  echo $pass+$cpz+$mpz+$dz;?> <b>Total Fails:</b> <?php echo $fail ?>&nbsp;&nbsp;<b>Total Fulltime:</b><?php echo $ftt  ?>&nbsp;&nbsp;<b>Pass Rate:</b> <?php if($ftt==0){$ftt=1;} $v=((($pass+$cpz+$mpz+$dz)/$ftt)*100); echo round($v,1)."%" ?>
                        </div>
                       <div class="alert alert-danger"><center><strong>TOTAL CLASS STATICTICS</strong></center><br />
                        <?php echo "<b>F:</b>" .($faild+$fail)."&nbsp;&nbsp;&nbsp;&nbsp;<b>P:</b>" .($passd+$pass) ."&nbsp;&nbsp;&nbsp;&nbsp;<b>CP:</b>" .($cps+$cpz) ."&nbsp;&nbsp;&nbsp;&nbsp;<b>MP:</b>" .($mps+$mpz)."&nbsp;&nbsp;&nbsp;&nbsp;<b>D:</b>" .($dzd+$dz); ?> &nbsp;&nbsp; <b>Total Passes:</b><?php  $ps= (($pass+$cpz+$mpz+$dz)+($ss)); echo $ps;?> <b>Total Fails:</b> <?php echo $faild+$fail ?>&nbsp;&nbsp;<b>Total Class:</b><?php echo $total  ?>&nbsp;&nbsp;<b> Class Pass Rate:</b> <?php  if($total==0){$total=1;}$pp=(($ps/$total)*100); echo round($pp,1)."%" ?>
                        <?php }
						 
						 else
						 {
						 ?>
						 <div class="alert alert-danger"><strong>CLASS STATICTICS</strong><br />
                        <?php echo "<b>F:</b>" .($msF) ."&nbsp;&nbsp;&nbsp;&nbsp;<b>MP:</b>" .($msMP) ."&nbsp;&nbsp;&nbsp;&nbsp;<b>P:</b>" .($msP) ."&nbsp;&nbsp;&nbsp;&nbsp;<b>CP:</b>" .($msCP)."&nbsp;&nbsp;&nbsp;&nbsp;<b>D:</b>" .($msD); ?> &nbsp;&nbsp; <b>Total Passes:</b><?php  $pss= ($msP+$msMP+$msCP+$msD); echo $pss;?> <b>Total Fails:</b> <?php echo $msF ?>&nbsp;&nbsp;<b>Total Class:</b><?php echo $Tms  ?>&nbsp;&nbsp;<b> Class Pass Rate:</b> <?php  if($Tms==0){$Tms=1;}$pp=(($pss/$Tms)*100); echo round($pp,1)."%" ?>
                        </div>
						<?php 
						 }
						 ?>
                        </div>
                                    <button title="close" type="button" class="close" data-dismiss="alert">&times;</button>
                                    <br />
                                    </div>
                                    <?PHP 
									}
									else{ 
									
									 echo"<div class='alert alert-danger'><i class='icon-remove-sign'></i>&nbsp;No results found</div>";
									}
									}
									}
			
			
				
			function outputresults()
			{ //open function
			include('connect.php');
			
			            if(isset($_GET['send'])){//open if isset
							$prog=$_GET['sub'];;
							$year=$_GET['year'];
							$sem=$_GET['sem'];
							$sel=$_GET['sel'];
							$cyear=$_GET['cyear'];
					
                            $Today = date('y:m:d');
                            $new = date('l, F d, Y', strtotime($Today));
                           
                           
		if($sel==''){ //open sel
      if($cyear==5)
     $query = mysqli_query($conn,"select distinct uid , stud_year,student_id,firstname,studsem,surname from results where  prog='$prog' and year='$year' and sem='$sem' ") or die(mysqli_error($conn));
	else
$query = mysqli_query($conn,"select distinct  uid ,stud_year,studsem,student_id,firstname,surname from results where  prog='$prog' and year='$year' and sem='$sem' and stud_year='$cyear'") or die(mysqli_error($conn));
 $total=mysqli_num_rows($query);
		 if($total>0){ //open total>0
		 ?>
         <div class="alert alert-info"><center>Showing  <?php echo $prog;  ?>&nbsp;Year&nbsp;<?php if($cyear==5) echo "1-4&nbsp;&nbsp;"; else echo $cyear;  if($sem==1)echo "Jan-June"; else echo"July-Dec"; ?> Semester&nbsp;Results<center></div>
         <?php
		 $fail=0; $pass=0;
		
		  while ($row = mysqli_fetch_array($query)) {//open loop first
                           $student_id = $row['student_id'];
						  $uid = $row['uid'];
						  $student2 = mysqli_query($conn,"select * from student_fees where id='$uid' and year='$year' and sem='$sem'and fee_balance=0") or die("here".mysqli_error($conn)); 
		  $NUM=mysqli_fetch_assoc($student2);
						   ?>
                          
<tr>
<td colspan="4"> 
<table border="0" style=" font-family:Cambria; width:90%" align="left">          
<tr>
<td colspan="4" align="center"><h2  style="color:#000000; font-family:Cambria; font-weight:600;">MALAWI COLLEGE OF ACCOUNTANCY</h2></td></tr>
                           <td colspan="4" align="center"><h5><font face="Times New Roman, Times, serif"><span style="border-bottom:1px solid;"><?php echo $year;  ?>&nbsp;<?php  if($sem==1)echo "January-June"; else echo"July-December" ?> End Of Semester Examination Results</span></font></h5></td>
						   </tr>
                           
                           <tr>
						   <td align="left" width="190">Student Names:</td><td><?php echo $row['surname']?>&nbsp;&nbsp;<?php echo $row['firstname']?></td>
						   </tr>
                           <tr>
						   <td align="left">Registration No:</td><td><?php echo $row['student_id']?></td>
						  </tr>
						  <tr>
						   <td align="left">Programme:</td><td><?php echo $prog;?></td>
						  </tr>
						  <tr>  <td align="left">Student Year:</td><td><?php echo $row['stud_year']?></td>
						   </tr>
                           <tr>
						   <td align="left">Student Semester:</td><td><?php echo $row['studsem']?></td>
						  </tr>
						   <tr>
						   <td align="left">Exam Number:</td><td><?php if($NUM) echo $NUM['exam_no']?></td>
						  </tr>
                           <tr>
						   <td align="left">&nbsp;</td><td></td>
						  </tr>
                           </table>
						   </td>
						   </tr>
                             
                             
                                                                 
                                  <tr>
                                 <td colspan="4"> 
                                 <table style="width:100%;">
                                 
                                <?php
                                 if($cyear==5)
                              $student = mysqli_query($conn,"select * from results where uid='$uid' and year='$year' and sem='$sem'") or die("here".mysqli_error($conn)); 
                            else
		$student = mysqli_query($conn,"select * from results where uid='$uid' and year='$year' and sem='$sem'and stud_year='$cyear'") or die("here".mysqli_error($conn)); 					
 if(mysqli_num_rows($student)==0)
							{//open if
							echo "<tr><td colspan='7'>No exam results for student in".$year ."&nbsp;Semester&nbsp;".$sem ."</td> </tr>";
							}//close if
							else
							 {// open subjects found
                               
							   if(mysqli_num_rows($student2)==0){
								?>
								<div class="alert alert-info" style="width:40%"><i class="icon icon-remove-circle"></i>&nbsp;Student should consult the accounts office</div>
								<?php
							  }
							  else
							   { //open paid
                                 $student3 = mysqli_query($conn,"select * from student_fees where id='$uid' and year='$year' and sem='$sem' and fee_balance >0 ") or die("here".mysqli_error($conn));
                                                             if(mysqli_num_rows($student3)>0) {
																?>
                                                             <div class="alert alert-info" style="width:40%"><i class="icon icon-remove-circle"></i>&nbsp;Student should consult the accounts office</div>
															 <?php
															}
                                                              else
                                                               {//open no balance
                                                            ?>
                             
							    <tr style="font-weight:bold;  text-align:center" class="alert alert-info">
                                <td align="left">NO</th>
                             <th align="left" width="120">Course Code</th>
                             <th align="left" width="220">Course Name</th>
                      <td>CW1</td>
                             <td>CW2</td>
                             <td> Exam</td>
                             <th>EOS</td>
                              <th>Grade</th> 
                             </tr>
                             <?php
							
						   					 
							$status = mysqli_query($conn,"select distinct comment from results where uid='$uid' and year='$year' and sem='$sem' and comment='F'");
							  if(mysqli_num_rows($status)==0){$pass=$pass+1;}else {$fail=$fail+1;}
							  $i=1;
						    while($student_row = mysqli_fetch_array($student)){//open subject loop
							$cod=$student_row ['course_code'];
                          $title= mysqli_query($conn,"select * from subject where subject_code='$cod' ");
						  $ccode=mysqli_fetch_array($title);
						  $ent=$student_row ['byw'];
						  $by= mysqli_query($conn,"select * from teacher where teacher_id='$ent' ");
						  if(mysqli_num_rows($by)==0)
						$by= mysqli_query($conn,"select * from user where user_id='$ent' ");
						  $d=mysqli_fetch_array($by);
						  $f=$d['firstname'];
						   $h=$d['lastname'];
						  
							if($i<7){
							 ?>
							   
                                    <!-- end script -->
                            <tr align="center" id="disp">
							<script type="text/javascript">
                                        $(document).ready(function(){
                                                
                                            $('#e<?php echo $ent; ?>').tooltip('show')
                                            $('#e<?php echo $ent; ?>').tooltip('hide')
											$('#f<?php echo $ent; ?>').tooltip('show')
                                            $('#f<?php echo $ent; ?>').tooltip('hide')
											$('#g<?php echo $ent; ?>').tooltip('show')
                                            $('#g<?php echo $ent; ?>').tooltip('hide')
                                        });
                                    </script>
                            <td align="left"><?php echo $i?></td>
							<td align="left"><?php echo $student_row['course_code']?></td>
                             <td  align="left"><?php echo  $ccode['subject_title']?></td> 
                               <td><span rel="tooltip" id="e<?php echo $ent?>"  title="<?php echo"Entered by:".$f."  ".$h;?>"><?php echo $student_row['assign_1'];?></span> </td>
                              <td><span rel="tooltip" id="f<?php echo $ent?>"  title="<?php echo"Entered by:".$f."  ".$h;?>"><?php echo $student_row['assign_2']?> </span></td>
                              <td><span rel="tooltip" id="g<?php echo $ent?>" title="<?php echo"Entered by:".$f."  ".$h;?>"><?php echo $student_row['EOS']?></span> </td>
                              <td><?php echo $student_row['fgrade']?> </td>
                              <td><?php if($student_row['assign_1']==0 or $student_row['assign_2']==0 or $student_row['EOS']==0) echo "N/A"; else echo $student_row['comment']?> </td>
                              
							   </tr>
							   
                               
							<?php
							}                          
							$i++;
                                                        
                                                          }//clse subject loop
														  ?>
								
							   <?php
							   $student4 = mysqli_query($conn,"select * from results where uid='$uid' and year='$year' and sem='$sem' and comment='F' ") or die("here".mysqli_error($conn)); 
                         if(mysqli_num_rows($student4)==0)
                          {$well="Pass and Proceed"; $v=1;}
					  elseif(mysqli_num_rows($student4)>=3){$well="Repeat Semester";$v=2;}else {$well="Proceed CARRY:"; $v=3;}
							   ?>
							  

													
							   <td colspan="7" align="left"><b> Remarks:</b> &nbsp; &nbsp; &nbsp;      <?php echo $well;?>
                                    <?php   
									if($v==3)
									{
										echo'<ol>'	;
									while($rs=mysqli_fetch_array($student4))
									{
									$cc=$rs['course_code'];	
									$title= mysqli_query($conn,"select * from subject where subject_code='$cc' ");
                                     $su=mysqli_fetch_array($title)	;
									 $sname= $su['subject_title'];
                                     echo'<li>'. $sname .'</li>';
								 
									}
                                    echo'</ol>'	;								
									}
									
									?>
									



							   </td></tr>
							   <?php
							   
                                                           }//close no balance
														   }//close paid						
							
						?>
						
						</table></td>
						



							
                            <?php      
						 } //close subject found
						}//close first loop
						
						
						?>  
                          <!-- Report -->
                         
                        </tr>
                        <?php if(isset($fail)||isset($pass)){?>
                        <tr class="alert alert-danger"><td colspan="4"><b>Statistics</b></td></tr> 
                        <tr class="alert alert-danger"> <td>Total pass : <?php if(isset($pass))echo $pass;  ?>   </td><td>Total fail:<?php if(isset($fail))echo $fail; ?> </td><td>
                        Total class: &nbsp;<?php $total=$pass+$fail; if(isset($total)){echo $total;}?></td><td>  Pass Rate:<?php 
						$total=$pass+$fail; if($total==0){$total=1;}else {$total=$total;} $rate=(($pass/$total)*100); if(isset($rate)){echo round($rate,1)."%"; } ?> </td></tr>
                        <?php
						}
					    }//close total>0
						else
						{  //no results
						echo"No results found";
						}
						}//close $sel=''
						else
						{ // find individual results
						include('individual.php');
						}
			           }//close if isset
					   
			            }//close function
						
						
				
			function outputresults2()
			{ //open function
			include('connect.php');
			            if(isset($_GET['send'])){//open if isset
							$prog=$_GET['sub'];
							$year=$_GET['year'];
							$sem=$_GET['sem'];
							$sel=$_GET['sel'];
							$cyear=$_GET['cyear'];
					
                            $Today = date('y:m:d');
                            $new = date('l, F d, Y', strtotime($Today));
                           
                           
		if($sel==''){ //open sel
      if($cyear==5)
     $query = mysqli_query($conn,"select distinct stud_year,student_id,uid,firstname,studsem,surname from results where  prog='$prog' and year='$year' and sem='$sem' ") or die(mysqli_error($conn));
	else
$query = mysqli_query($conn,"select distinct stud_year,studsem,student_id,uid,firstname,surname from results where  prog='$prog' and year='$year' and sem='$sem' and stud_year='$cyear'") or die(mysqli_error($conn));
 $total=mysqli_num_rows($query);
		 if($total>0){ //open total>0
		 ?>
         <div class="alert alert-info"><center>Showing  <?php echo $prog;  ?>&nbsp;Year&nbsp;<?php if($cyear==5) echo "1-4&nbsp;&nbsp;"; else echo $cyear;  if($sem==1)echo "Jan-June"; else echo"July-Dec"; ?> Semester&nbsp;Results<center></div>
         <?php
		 $fail=0; $pass=0;
		 
		  while ($row = mysqli_fetch_array($query)) {//open loop first
                           $student_id = $row['student_id'];
						  $uid = $row['uid'];
						 $student2 = mysqli_query($conn,"select * from student_fees where id='$uid' and year='$year' and sem='$sem'and fee_balance=0") or die("here".mysqli_error($conn)); 
		  $NUM=mysqli_fetch_assoc($student2);
						   ?>
                          
<tr>
<td colspan="4"> 
<table border="0" style=" font-family:Cambria; width:90%" align="left">          
<tr>
<td colspan="4" align="center"><h2  style="color:#000000; font-family:Cambria; font-weight:600;">BLANTYRE INTERNATIONAL UNIVERSITY</h2></td></tr>
                           <td colspan="4" align="center"><h5><font face="Times New Roman, Times, serif"><span style="border-bottom:1px solid;"><?php echo $year;  ?>&nbsp;<?php  if($sem==1)echo "January-June"; else echo"July-December" ?> End Of Semester Examination Results</span></font></h5></td>
						   </tr>
                           
                           <tr>
						   <td align="left" width="190">Student Names:</td><td><?php echo $row['surname']?>&nbsp;&nbsp;<?php echo $row['firstname']?></td>
						   </tr>
                           <tr>
						   <td align="left">Registration No:</td><td><?php echo $row['student_id']?></td>
						  </tr>
						  <tr>
						   <td align="left">Programme:</td><td><?php echo $prog;?></td>
						  </tr>
						  <tr>  <td align="left">Student Year:</td><td><?php echo $row['stud_year']?></td>
						   </tr>
                           <tr>
						   <td align="left">Student Semester:</td><td><?php echo $row['studsem']?></td>
						  </tr>
						   <tr>
						   <td align="left">Exam Number:</td><td><?php echo $NUM['exam_no']?></td>
						  </tr>
                           <tr>
						   <td align="left">&nbsp;</td><td></td>
						  </tr>
                           </table>
						   </td>
						   </tr>
                             
                             
                                                                 
                                  <tr>
                                 <td colspan="4"> 
                                 <table style="width:100%;">
                                 
                                <?php
                                 if($cyear==5)
                              $student = mysqli_query($conn,"select * from results where uid='$uid' and year='$year' and sem='$sem'") or die("here".mysqli_error($conn)); 
                            else
		$student = mysqli_query($conn,"select * from results where uid='$uid' and year='$year' and sem='$sem'and stud_year='$cyear'") or die("here".mysqli_error($conn)); 					
 if(mysqli_num_rows($student)==0)
							{//open if
							echo "<tr><td colspan='7'>No exam results for student in".$year ."&nbsp;Semester&nbsp;".$sem ."</td> </tr>";
							}//close if
							else
							 {// open subjects found
                                $student2 = mysqli_query($conn,"select * from student_fees where id='$uid' and year='$year' and sem='$sem'and fee_balance=0 and user_id=5") or die("here".mysqli_error($conn)); 
							   if(mysqli_num_rows($student2)==0){
							   echo "<span align='center' >Please consult the accounts office</span>";
							  }
							  else
							   { //open paid
                                 $student3 = mysqli_query($conn,"select * from student_fees where id='$uid' and year='$year' and sem='$sem' and fee_balance >0") or die("here".mysqli_error($conn));
                                                           /*   if(mysqli_num_rows($student3)>0) {
                                                             echo "<span>Please consult the accounts office</span>";
															}
                                                              else
                                                               {//open no balance */
                                                            ?>
                             
							    <tr style="font-weight:bold;  text-align:center" class="alert alert-info">
                                <td align="left">NO</th>
                            
                             <th align="left" width="120">Course Code</th>
                             <th align="left" width="220">Course Name</th>
                      <td> CW1</td>
                             <td>CW2</td>
                             <td> Exam</td>
                             <th>EOS</td>
                              <th>Grade</th>  
                             </tr>
                             <?php
							
						   					 
							$status = mysqli_query($conn,"select distinct comment from results where uid='$uid' and year='$year' and sem='$sem' and comment='F'");
							  if(mysqli_num_rows($status)==0){$pass=$pass+1;}else {$fail=$fail+1;}
							  $i=1;
						    while($student_row = mysqli_fetch_array($student)){//open subject loop
							$cod=$student_row ['course_code'];
                          $title= mysqli_query($conn,"select * from subject where subject_code='$cod' ");
						  $ccode=mysqli_fetch_array($title);
						  $ent=$student_row ['byw'];
						  $by= mysqli_query($conn,"select * from teacher where teacher_id='$ent' ");
						  if(mysqli_num_rows($by)==0)
						$by= mysqli_query($conn,"select * from user where user_id='$ent' ");
						  $d=mysqli_fetch_array($by);
						  $f=$d['firstname'];
						   $h=$d['lastname'];
						  
							
							 ?>
							   
                                    <!-- end script -->
                            <tr align="center" id="disp">
							<script type="text/javascript">
                                        $(document).ready(function(){
                                                
                                            $('#e<?php echo $ent; ?>').tooltip('show')
                                            $('#e<?php echo $ent; ?>').tooltip('hide')
											$('#f<?php echo $ent; ?>').tooltip('show')
                                            $('#f<?php echo $ent; ?>').tooltip('hide')
											$('#g<?php echo $ent; ?>').tooltip('show')
                                            $('#g<?php echo $ent; ?>').tooltip('hide')
                                        });
                                    </script>
                            <td align="left"><?php echo $i?></td>
							<td align="left"><?php echo $student_row['course_code']?></td>
                             <td  align="left"><?php echo  $ccode['subject_title']?></td> 
                               <td><span rel="tooltip" id="e<?php echo $ent?>"  title="<?php echo"Entered by:".$f."  ".$h;?>"><?php echo $student_row['assign_1'];?></span> </td>
                              <td><span rel="tooltip" id="f<?php echo $ent?>"  title="<?php echo"Entered by:".$f."  ".$h;?>"><?php echo $student_row['assign_2']?> </span></td>
                              <td><span rel="tooltip" id="g<?php echo $ent?>" title="<?php echo"Entered by:".$f."  ".$h;?>"><?php echo $student_row['EOS']?></span> </td>
                              <td><?php echo $student_row['fgrade']?> </td>
                              <td><?php if($student_row['assign_1']==0 or $student_row['assign_2']==0 or $student_row['EOS']==0 ) echo "N/A"; else echo $student_row['comment']?> </td>
                              
							   </tr>
							   
                               
							<?php
							                          
							$i++;
                                                        
                                                          }//clse subject loop
														  ?>
								
							   <?php
							   
							   $student4 = mysqli_query($conn,"select * from results where uid='$uid' and year='$year' and sem='$sem' and comment='F'") or die("here".mysqli_error($conn)); 
                         if(mysqli_num_rows($student4)==0)
                          {$well="Pass and Proceed"; $v=1;}
					  elseif(mysqli_num_rows($student4)>=3){$well="Repeat Semester";$v=2;}else {$well="Proceed CARRY:"; $v=3;}
							   ?>
							  

													
							   <td colspan="7" align="left"><b>Remarks:</b> &nbsp; &nbsp; &nbsp;      <?php echo $well;?>
                                    <?php   
									if($v==3)
									{
										echo'<ol>'	;
									while($rs=mysqli_fetch_array($student4))
									{
									$cc=$rs['course_code'];	
									$title= mysqli_query($conn,"select * from subject where subject_code='$cc' ");
                                     $su=mysqli_fetch_array($title)	;
									 $sname= $su['subject_title'];
                                     echo'<li>'. $sname .'</li>';
								 
									}
                                    echo'</ol>'	;								
									}
									
									?>



							   </td></tr>
							   <?php
							   
                                                          // }//close no balance
														   }//close paid						
							
						?>
						
						</table></td>
						



</tr>

							
                            <?php      
						 } //close subject found
						}//close first loop
						
						
						?>  
                          <!-- Report -->
                         
                        </tr>
                        <?php if(isset($fail)||isset($pass)){?>
                        <tr class="alert alert-danger"><td colspan="4"><b>Statistics</b></td></tr> 
                        <tr class="alert alert-danger"> <td>Total pass : <?php if(isset($pass))echo $pass;  ?>   </td><td>Total fail:<?php if(isset($fail))echo $fail; ?> </td><td>
                        Total class: &nbsp;<?php $total=$pass+$fail; if(isset($total)){echo $total;}?></td><td>  Pass Rate:<?php 
						$total=$pass+$fail; if($total==0){$total=1;}else {$total=$total;} $rate=(($pass/$total)*100); if(isset($rate)){echo round($rate,1)."%"; } ?> </td></tr>
                        <?php
						}
					    }//close total>0
						else
						{  //no results
						echo"No results found";
						}
						}//close $sel=''
						else
						{ // find individual results
						include('individual.php');
						}
			           }//close if isset
					   
			            }//close function
						
						function sendresults($id,$coid)
						{
							include('connect.php');
						$year=date('Y');
						$sem=checksem();
						 $student = mysqli_query($conn,"select * from results where uid='$id' and year='$year' and sem='$sem' and course_code='$coid'") or die(mysqli_error($conn));
						 $row=mysqli_fetch_array( $student);
						 $assgn1=$row['assign_1'];
						  $assgn2=$row['assign_2'];
						   $eos=$row['EOS'];
						    $fgrade=$row['fgrade'];
							$mail_sent=$row['email_sent'];
							 $syear=$row['stud_year'];
							 $comment=$row['comment'];
							 if($comment=='F') $remark="FAIL";else $remark="PASS";
							$sub_details = mysqli_query($conn,"select * from subject  where subject_code='$coid'") or die(mysqli_error($conn));
							$subs=mysqli_fetch_array($sub_details);
							$subname=	$subs['subject_title'];
							$student_details = mysqli_query($conn,"select * from student  where id='$id'") or die(mysqli_error($conn));
							$detail=mysqli_fetch_array($student_details);
							$fname=$detail['firstname'];
							$lname=$detail['lastname'];
							$sid=$detail['student_id'];
							$spo_mail=$detail['spo_email'];
							if($sem==1)$s="Jan-Jun"; else $s="July-Dec";
							if($spo_mail !='')
							{
							if($mail_sent==0){
							$message = 
"$year &nbsp; &nbsp; EXAM RESULTS FOR $fname $lname ...\n
__________________________________________________
StudentID: $sid \n
Academic Year: $year\n
Semester: $s\n
Student Current year: $syear\n
Subject: $subname\n
Subject Code: $coid\n
Assignment1 Grade: $assgn1\n
Assignment2 Grade: $assgn2\n
Final Exam: $eos\n
Final Grade: $fgrade\n
REMARKS: $remark\n

Thank You

BIU ADMINSTRATION
______________________________________________________
THIS IS AN AUTOMATED RESPONSE. 
***DO NOT RESPOND TO THIS EMAIL****
";

	mail($spo_mail, "Exam results", $message,
    "From: \"BIU student Information management System|Developed by D liwonde,Email:liwonde.d@gmail.com \" <info@biu.ac.mw>\r\n" .
     "X-Mailer: PHP/" . phpversion());
	 mysqli_query($conn,"update results set email_sent='1' where uid='$id' and year='$year' and sem='$sem' and course_code='$coid'") or die(mysqli_error($conn));
	 $msg="Final Grade Entered.Results have been send to parent or sponsor. Email:".$spo_mail." &nbsp;&nbsp;subject:".$subname;
	 
	 }
	 }
	 else{
	  $msg="final grade entered email not send to parent.No email address found for &nbsp;".$fname; 
	 }
	 if(isset($msg)){
	 return $msg;
	 }
	 }
	 					function recoverPass($em)
						{
							include('connect.php');
						 $lect = mysqli_query($conn,"select * from teacher where email='$em' ") or die(mysqli_error($conn));
						 $row=mysqli_fetch_array($lect);
					$mail=	$row['email'];
					$uname= $row['username'];
					$pword= $row['password'];
						 $name= $row['lastname'];
						 $tid= $row['teacher_id'];
							if($mail !='')
							{
							$message = 
"$name,  below are your login credentials...\n
__________________________________________________
Username: $uname \n
If you have forgotten the password click sims.biu-edu.com/resetPassword.php?&id=$tid
SIMS | BY D.LIWONDE\n

Thank You\n

______________________________________________________
THIS IS AN AUTOMATED RESPONSE. 
***DO NOT RESPOND TO THIS EMAIL****
";

	mail($mail, "Login details Recovery", $message,
    "From: \"SIMS |Developed by D liwonde,Email:liwonde.d@gmail.com \" <dliwonde@biu-edu.com>\r\n" .
     "X-Mailer: PHP/" . phpversion());
	 $msg="Details emailed to".$mail;
	 }
	 else{
	  $msg="Failed to send login details.No email address found for &nbsp;".$name; 
	 }
	 if(isset($msg)){
	 return $msg;
	 }
	 }
	 
	 
	 
	 
	 function feeRepofirst($id,$amount,$tamountp,$bal,$date,$ttf,$fint)
	 {
		 include('connect.php');
$sel=mysqli_query($conn,"select * from student where id='$id'") or die("error ho".mysqli_error($conn));
$row=mysqli_fetch_array($sel);
$year=date('Y');
$sem=checksem();
if($sem==1)$sem="Jan-Jun"; else $sem="July-Dec";
$sid=$row['student_id'];
	 $mail=$row['spo_email'];
	 if($mail!='')
	 {
		//$headrs= array("MIME-Version"=>"1.0","Content-Type"=>"text/thml;charset=UTF-8",
		//"From"=>"info@biu-edu.com","Reply-To"=>"info@biu-edu.com",
	 //);

	 $message="$row[firstname]&nbsp;$row[middle_name]&nbsp;$row[lastname] FEES PAYMENT REPORT FOR  $year &nbsp; SEMESTER $sem\n
	 _________________________________________________________
	 StudentID:$sid\n
	 Amount paid: $amount\n
	 Total Amount paid: $tamountp\n
	  Total Fees For Semester:$ttf\n
	Total amount To Be Paid:$fint\n
	 Balance: $bal\n
	 Paid On: $date\n
	 BIU ADMINSTRATION\n
	 THANKS.
	 __________________
	  THIS IS AN AUTOMATED RESPONSE. 
***DO NOT RESPOND TO THIS EMAIL****
";
	mail($mail, "FEES PAYMENT", $message,
    "From: \"BIU student Information management System|Developed by D liwonde,Email:liwonde.d@gmail.com \" BIU Email:<info@biu.ac.mw>\r\n" .
     "X-Mailer: PHP/" . phpversion()); 
	 $msg="Fees Payment Information send to".$mail."<br> Information sent&nbsp;".$message;
	 }
	 else{
	 $msg="Fees Payment Information not sent.No sponsor/parent email was found";
	 }
	  if(isset($msg)){
	 return $msg;
	 }
	 
	 }
	 function display_carry_overs($student)
				{
					include('connect.php');
					$cv= mysqli_query($conn,"select * from results where uid='$student' and comment='F' and repeated='0'");
							  if(mysqli_num_rows($cv)>0){ 
							  $get=mysqli_fetch_array($cv);
							  if($get['sem']!=checksem()){
                             $repeat_courses = mysqli_query($conn,"select * from results where uid='$student' and comment='F' and repeated='0'");
							if(mysqli_num_rows($repeat_courses)>0){ 
                                              ?>
  <div class="alert alert-info">
 It shows that you are failed the following Courses and 
 will be added to your course list for this semester
 <button type="button" class="close" data-dismiss="alert">&times;</button>
						   <br>
                           </div>
                            <tr bgcolor="#999999">
                           <th>No</th> <th>Code</th><th>Course title</th><th> Failed in</th> <th>semester</th></tr>
                            <?php
							$sem= checksem();
							$year       = date('Y');
							$j;
                           while($courses = mysqli_fetch_array($repeat_courses)){
						   $co_code=$courses['course_code'];
						   $subjects = mysqli_query($conn,"select * from subject where subject_code= '$co_code'");
						   $subject=mysqli_fetch_array($subjects);
						   $subid= $subject['subject_id'];
						   $teacher=$subject['teacher_id'];
						   $id=$courses['uid'];
						   $y=$courses['year'];
						   $s=$courses['sem'];
						   mysqli_query($conn,"insert into teacher_student(teacher_id,uid,year,semester,subject_id,being_repeated) values('$teacher','$id','$year','$sem','$subid','1')") or die(mysql_error($conn));
						  
							mysqli_query($conn,"update results set repeated='1' where uid='$id' and sem='$s' and year='$y' and course_code='$co_code'");
							?>
                            <tr>
                            <td><?php echo $j ?></td><td><?php echo $co_code ?></td><td><?php  echo $subject['subject_title']; ?></td><td><?php echo $y; ?></td><td><?php echo $s; ?></td>
                            </tr>
                            <?php
							$j++;
                            }
						     }
							 else
								 echo"<span class='text-success'>No carryovers as of now</span><br>";
							  }
							  }
				              }
			function display_carry_overs_stud($student)
				{
					include('connect.php');
					     $sem= checksem();
							$year       = date('Y');
					 $student_subject = mysqli_query($conn,"select * from teacher_student where
					 uid='$student' and year='$year' and semester='$sem' and being_repeated=1") or die(mysqli_error($conn));
					 $j=1;
					 while($subject_details = mysqli_fetch_array($student_subject)){
						   $teacher_id=$subject_details['teacher_id'];
						   $subject_id=$subject_details['subject_id'];
						 
						   $uid= $subject_details['uid'];
						  
						   $subect_teacher = mysqli_query($conn,"select * from teacher where teacher_id= $teacher_id");
						   $teacher_details=mysqli_fetch_array($subect_teacher);
						   $subjects = mysqli_query($conn,"select * from subject where subject_id=$subject_id");
						   $subject_details=mysqli_fetch_array($subjects);
						   $dep= $subject_details['Dept'];
						  $depart = mysqli_query($conn,"select * from department where dep_id= '$dep'");
						  $depts=mysqli_fetch_array($depart);
						   $subcode=  $subject_details['subject_code'];
						   $subtitle= $subject_details['subject_title'];
							?>
                            <tr>
                            <td><?php echo $j ?></td><td><?php echo $subcode ?></td><td><?php  echo $subtitle; ?></td><td><?php echo $teacher_details['lastname'] ." ".$teacher_details['firstname']; ?></td><td><?php echo $dept; ?></td>
                            </tr>
                            <?php
							$j++;
                            }
						     
				              }				  
							  
							  
							  
	  function feeRepoupdate($id,$am,$total,$date,$int,$bal,$ttf)
	  {
		  include('connect.php');
$sel=mysqli_query($conn,"select * from student where id='$id'") or die("error ho".mysqli_error($conn));
$row=mysqli_fetch_array($sel);
$sid=$row['student_id'];
$year=date('Y');
$sem=checksem();
if($sem==1)$sem="Jan-Jun"; else $sem="July -Dec";
	 $mail=$row['spo_email'];
	 if($mail!='')
	 {
	  $message="$row[firstname]\t$row[middle_name]\t$row[lastname] FEES PAYMENT REPORT FOR  $year \t  $sem SEMESTER\n
	 ________________________________________________________
	  StudentID:$sid\n
	 Amount paid: $am\n
	 Total Amount paid: $total\n
	 Total Fees for Semester:$ttf\n
	 Balance: $bal\n
	 
	 
	 Paid On: $date\n
	 BIU ADMINSTRATION\n
	 THANKS.
	 __________________
	  THIS IS AN AUTOMATED RESPONSE. 
***DO NOT RESPOND TO THIS EMAIL****\n
Sender: BIU SIMS | Developed by D. Liwonde
";
	mail($mail, "BIU FEES PAYMENT", $message,
    "From: BIU student Information management System|Developed by D liwonde,Email:liwonde.d@gmail.com  BIU Email:<registrar@biu-edu.com>\r\n" .
     "X-Mailer: PHP/" . phpversion()); 
	 $msg="Fees Payment Information send to".$mail."<br> Information sent<br>".$message;
	 }
	 else{
	 $msg="Fees Payment Information not sent.No sponsor/parent email was found\n";
	 }
	 if(isset($msg)){
	 return $msg;
	 }
	 }
	 
	 function printreciept($id,$amount,$tamountp,$intr,$bal,$ttf,$fpint,$new)
	 {
	 include('connect.php');
$sel=mysqli_query($conn,"select * from student where id='$id'") or die("error ho".mysqli_error($conn));
$row=mysqli_fetch_array($sel);
$year=date('Y');
$sem2=checksem();
$sem=checksem();
if($sem==1)$sem="January-June"; else $sem="July-December";
$sid=$row['student_id'];
$this_id=$row['id'];
 $Today = date('y:m:d');
 // $new = date('l, F d, Y', strtotime($Today));
  //$selc=mysqli_query($conn,"select * from student_fees where fee_balance<>'0' and sem='$sem2' and year='$year'") or die("error ho".mysqli_error($conn));
  //$num=mysqli_num_rows($selc);
   $querry=mysqli_query($conn,"select * from student_fees where id ='$this_id'and year='$year' and sem='$sem2' and exam_no<>''") or die(mysqli_error($conn));
  $exa=mysqli_fetch_array( $querry);
  $exano=$exa['exam_no'];
   //require_once 'PHPWord.php';

// New Word Document


// New portrait section


// Add image elements
	?>
<table width="915"  border="0" align="center" width="90%">
  <tr><td rowspan="2"><img src="img/logo_small.png" width="50" height="50"/></td>
  <td colspan="2"><h4>Malawi College of Accountancy</h4></td></tr>
    <tr><td colspan="2"><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;FEES PAYMENT RECIEPT</span></td>
  </tr>
  <tr><td colspan="2"></td></tr>    
  <tr><td>Student Name:</td><td colspan="2"><?php echo $row['firstname'] ."&nbsp;".$row['lastname'] ?></td></tr>
     <tr><td>Programme:</td><td colspan="2"><?php echo $row['cys'] ?> &nbsp;&nbsp;<?php  if ($row['mode']==1) echo "Full time";  if ($row['mode']==2) echo "Distance"; if ($row['mode']==3) echo "(BIU Undergraduate)";  if ($row['mode']==4) echo "(Non BIU Undergraduate)"; ?></td></tr>
      <tr><td>Payment:</td><td colspan="2">Tuition Fees</td></tr>
       <tr><td>PaymentDate:</td><td colspan="2"><?php echo $new ?></td></tr>
       <tr><td>Exam Number:</td><td colspan="2"><?php echo $exano; ?></td></tr>
        <tr><td><div style="border:2px  dotted; width:100%; font-size:10px; font-weight:bold; text-align: center; line-height:1em; ">FEES ONCE PAID ARE NEITHER REFUNDABLE NOR TRANSFERABLE</div></td>
          <td colspan="2">
          <table width="70%" border="0" align="right">
            <tr>
              <th width="392" align="left">Fees Amount</th>
              <td width="508">MWK<?php echo number_format($ttf);?></td>
            </tr>
            <tr>
              <th align="left">Total Amount:</th>
              <td>MWK<?php echo number_format($fpint); ?></td>
            </tr>
            <tr>
              <th align="left">Amount Paid:</th>
              <td>MWK<?php echo number_format($amount) ?></td>
            </tr>
            <tr>
              <th align="left">Total Payment:</th>
              <td>MWK<?php echo number_format($tamountp) ?></td>
            </tr>
            <tr>
              <th align="left">Balance:</th>
              <td>MWK<?php echo number_format($bal);?></td>
            </tr>
          </table></td>
      </tr>
      <tr><td><table  style="border:2px #000000 solid"><tr><td style="border-right:2px solid #000000">Cash&nbsp;</td><td>Cheque</td></tr></table></td><td colspan="2"><div style="border-bottom:2px  dotted">No:&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;Bank&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;Branch&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp;&nbsp;&nbsp; &nbsp;</div></td></tr>
    <tr><td colspan="3"><div style="border-bottom:1px; float:left; width:40%"><b>Semester:</b><?php echo $sem?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b> Year:</b>&nbsp;&nbsp;<?php echo $year?></div></td></tr>
      <tr><td colspan="3"><div style="border-bottom:2px  dotted; float:left; width:100%"><b>Signed Cashier:</b>&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;<b>Accounts:</b>&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp; </div></td></tr>  
    </table>
	<?php
	 }
	 
	 function printreciept2($id,$am,$total,$bal,$ttf,$new)
	 {
		 include('connect.php');
$sel=mysqli_query($conn,"select * from student where id='$id'") or die("error ho".mysqli_error($conn));
$row=mysqli_fetch_array($sel);
$year=date('Y');
$sem2=checksem();
$sem=checksem();
if($sem==1)$sem="January-June"; else $sem="July-December";
$sid=$row['student_id'];
$this_id=$row['id'];
 $Today = date('y:m:d');
  //$new = date('l, F d, Y', strtotime($Today));
  //$selc=mysqli_query($conn,"select * from student_fees where fee_balance<>'0' and sem='$sem2' and year='$year'") or die("error ho".mysqli_error($conn));
  //$num=mysqli_num_rows($selc);
   $querry=mysqli_query($conn,"select * from student_fees where id ='$this_id' and year='$year' and sem='$sem2' and exam_no<>''") or die(mysqli_error($conn));
  $exa=mysqli_fetch_array( $querry);
  if($exa)
  $exano=$exa['exam_no'];
 
// Add image elements


	?>
<table width="915"  border="0" align="center" width="90%">
  <tr><td rowspan="2"> <img src="img/logo.png" width="50" height="50"/></td>
  <td colspan="2"><h4>Malawi College of Accountancy</h4></td></tr>
    <tr><td colspan="2"><span >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;FEES PAYMENT RECIEPT</span></td>
  </tr>
  <tr><td colspan="2"></td></tr>    
  <tr><td>Student Name:</td><td colspan="2"><?php echo $row['firstname'] ."&nbsp;".$row['lastname'] ?></td></tr>
     <tr><td>Programme:</td><td colspan="2"><?php echo $row['cys'] ?> &nbsp;&nbsp;<?php  if ($row['mode']==1) echo "Full time";  if ($row['mode']==2) echo "Distance"; if ($row['mode']==3) echo "(BIU Undergraduate)";  if ($row['mode']==4) echo "(Non BIU Undergraduate)"; ?></td></tr>
      <tr><td>Payment:</td><td colspan="2">Tuition Fees</td></tr>
       <tr><td>PaymentDate:</td><td colspan="2"><?php echo $new ?></td></tr>
       <tr><td>Exam Number:</td><td colspan="2"><?php if($exa)echo $exano; ?></td></tr>
        <tr><td><div style="border:2px  dotted; width:100%; font-size:10px; font-weight:bold; text-align: center; line-height:1em; ">FEES ONCE PAID ARE NEITHER REFUNDABLE NOR TRANSFERABLE</div></td>
          <td colspan="2">
          <table width="70%" border="0" align="right">
            <tr>
              <th width="392" align="left">Fees Amount:</th>
              <td width="508">MWK<?php echo number_format($ttf);?></td>
            </tr>
            
            <tr>
              <th  align="left">Amount Paid:</th>
              <td>MWK<?php echo number_format($am) ?></td>
            </tr>
            <tr>
              <th align="left">Total Payment:</th>
              <td>MWK<?php echo number_format($total) ?></td>
            </tr>
            <tr>
              <th align="left">Balance:</th>
              <td>MWK<?php echo number_format($bal); ?></td>
            </tr>
          </table></td>
      </tr>
      <tr><td><table  style="border:2px #000000 solid"><tr><td style="border-right:2px solid #000000">Cash&nbsp;</td><td>Cheque</td></tr></table></td><td colspan="2"><div style="border-bottom:2px dotted ">No:&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;Bank&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;Branch&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp;&nbsp;&nbsp; &nbsp;</div></td></tr>
    <tr><td colspan="3"><div style="border-bottom:1px ;  float:left; width:40%"><b>Semester:</b><?php echo $sem?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b> Year:</b>&nbsp;&nbsp;<?php echo $year?></div></td></tr>
      <tr><td colspan="3"><div style="border-bottom:2px dotted; float:left; width:100%"><b>Signed Cashier:</b>&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;<b>Accounts:</b>&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp; </div></td></tr>  
    </table>
	<?php
	 }
	 ?>
						
						
                        
			