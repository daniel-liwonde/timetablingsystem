<?php
include('connect.php');
//require_once ('PHPWord.php');
function GenKey($length = 9)
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
function checksem()
{
$month=date('m');
$mday=date('d');
$year=date('Y');
$sel=mysqli_query($conn,"select * from  sems");
$sem1=mysqli_fetch_array($sel);
$sm=$sem1['start_month'];
$em=$sem1['end_moth'];
$sd=$sem1['start_date'];
$ed=$sem1['end_date'];
$cy=$sem1['sem_year'];
if(((($sm==$month)&&($mday>=$sd))or (($month>$sm)&&($month<$em)) or (($month==$em)&&($mday<=$ed))) &&($cy==$year))
return 1;
else
return 2;
//$month= date('m');


/*switch($month)
{ 
case   1:
  case 2:
  case 3:
  case 4:
  case 5:
  case 6:
  $sem=1;
  break;
  case 7:
  case 8:
  case 9:
  case 10:
  case 11:
  case 12:
  $sem=2;
  break;
  default: 
  $sem=0;
  }*/
//return $sem;
}					
function clean($conn,$str) {
                    $str = @trim($str);
                    if (get_magic_quotes_gpc()) {
                        $str = stripslashes($str);
                    }
                    return mysql_real_escape_string($str);
				
                }
				
				function calculateEOSmaster($ass1,$ass2,$exam)
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
					
				
				
				function repeat($repid)
				{
				$cv= mysqli_query($conn,"select * from results where uid='$repid' and comment='F' and repeated='0'") or die(mysqli_error($conn));
							  $get=mysqli_fetch_array($cv);
							  $code=$get['course_code'];
							  if($get['sem']!=checksem()){
                             $repeat_courses = mysqli_query($conn,"select * from results where uid='$repid' and comment='F' and repeated='0'") or die(mysqli_error($conn));
							if(mysqli_num_rows($repeat_courses)>0){
							$sem= checksem();
							$year       = date('Y');
                           while($courses = mysqli_fetch_array($repeat_courses)){
						   $co_code=$courses['course_code'];
						   $subjects = mysqli_query($conn,"select * from subject where subject_code= '$co_code'");
						   $subject=mysqli_fetch_array($subjects);
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
				function updyearandsem($myidz)
				{
				 $ss=checksem();
				  $cyear=date('Y');
							 //$g=false;
							 $m = mysqli_query($conn,"select * from student where id='$myidz'") or die(mysqli_error($conn));
							 $r=mysqli_fetch_array($m);
							 $entry_sem=$r['sem'];
							// $current_sem=$r['current_sem'];
							 $system_sem=$r['system_sem'];
							 $studcurrentyear=$r['stud_current_year'];
							 $sy= $studcurrentyear;
							 $updated_year=$r['update_year'];
							 $program=$r['cys'];
							 $current_ss=$r['current_sem'];
							if(($ss==$system_sem) &&  ($updated_year!=$cyear)){ 
							//if(($ss==1)&&  ($updated_year!=$cyear)){
							 $studcurrentyear=$studcurrentyear+1;
							  if(($program=='BLW')&& ($studcurrentyear>5))$studcurrentyear=5; 
							 if(($studcurrentyear>4)&& ($program!='BLW'))$studcurrentyear=4;
							 mysqli_query($conn,"update student set stud_current_year='$studcurrentyear', update_year='$cyear' where id='$myidz'") or die(mysqli_error($conn));
							 } //}
							
							/* if(($system_sem==2) && ($updated_year!=$cyear)){ 
							 if($ss==2){
							 $studcurrentyear=$studcurrentyear+1;
							 if(($program=='BLW')&& ($studcurrentyear>5)){$studcurrentyear=5;}
							 if(($studcurrentyear>4)&& ($program!='BLW')){$studcurrentyear=4;}
							  mysqli_query($conn,"update student set stud_current_year='$studcurrentyear', update_year='$cyear' where id='$student'") or die(mysqli_error($conn));
							 }}*/
							 
						     if($entry_sem == $system_sem)
							   $current_sem=checksem();
							   else{
							  if(checksem()==2)
							  $current_sem=1;
							 else
							 $current_sem=2;
							 }
							 if((($sy==4)&&($current_ss==2) && ($program!='BLW'))|| (($sy==5)&&($current_ss==2) && ( $program=='BLW')))
							  $current_sem=2;
							 mysqli_query($conn,"update student set current_sem='$current_sem' where id='$myidz'") or die(mysqli_error($conn));
							 }
							 function updALL()
				{
				 $ss=checksem();
				  $cyear=date('Y');
							 //$g=false;
							 $m = mysqli_query($conn,"select * from student") or die(mysqli_error($conn));
							while($r=mysqli_fetch_array($m)){
							$myidz=$r['id'];
							 $entry_sem=$r['sem'];
							// $current_sem=$r['current_sem'];
							 $system_sem=$r['system_sem'];
							 $studcurrentyear=$r['stud_current_year'];
							 $sy= $studcurrentyear;
							 $updated_year=$r['update_year'];
							 $program=$r['cys'];
							 $current_ss=$r['current_sem'];
							if(($ss==$system_sem) &&  ($updated_year!=$cyear)){ 
							//if(($ss==1)&&  ($updated_year!=$cyear)){
							 $studcurrentyear=$studcurrentyear+1;
							  if(($program=='BLW')&& ($studcurrentyear>5))$studcurrentyear=5; 
							 if(($studcurrentyear>4)&& ($program!='BLW'))$studcurrentyear=4;
							 mysqli_query($conn,"update student set stud_current_year='$studcurrentyear', update_year='$cyear' where id='$myidz'") or die(mysqli_error($conn));
							 } //}
							
							/* if(($system_sem==2) && ($updated_year!=$cyear)){ 
							 if($ss==2){
							 $studcurrentyear=$studcurrentyear+1;
							 if(($program=='BLW')&& ($studcurrentyear>5)){$studcurrentyear=5;}
							 if(($studcurrentyear>4)&& ($program!='BLW')){$studcurrentyear=4;}
							  mysqli_query($conn,"update student set stud_current_year='$studcurrentyear', update_year='$cyear' where id='$student'") or die(mysqli_error($conn));
							 }}*/
							 
						     if($entry_sem == $system_sem)
							   $current_sem=checksem();
							   else{
							  if(checksem()==2)
							  $current_sem=1;
							 else
							 $current_sem=2;
							 }
							 if((($sy==4)&&($current_ss==2) && ($program!='BLW'))|| (($sy==5)&&($current_ss==2) && ( $program=='BLW')))
							  $current_sem=2;
							 mysqli_query($conn,"update student set current_sem='$current_sem' where id='$myidz'") or die(mysqli_error($conn));
							 }
							 }
			function calculateinterest($sid,$month,$mday)
				{
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
				if($modest==1) $yourfees=$full; else $yourfees=$dis;
				$i=mysqli_query($conn,"select * from interest") or die(mysqli_error($conn));
				$am=mysqli_fetch_array($i);
				$rday=$am['amount'];
				$q=$yourfees/4;
				$march=31;
				$april=30;
				$may=31;
				$aug=31;
				$sept=30;
				$oct=31;
				$fee=mysqli_query($conn,"select * from student_fees where id='$sid' and year='$year' and sem='$sem'") or die(mysqli_error($conn));
				if(mysqli_num_rows($fee)==0)
				{//if fees equal zero
				if($sem==1)
				{//open sem1
				if($year%4==0) $feb=29;else $feb=28;
				if($month==1)//january
				$int=0;
				if($month==2)//feb
				$int=$mday*$rday*$q;
				if($month==3) //march
				$int=($feb+$mday)*$rday*$q;
				if($month==4)//aprial
				$int=($feb+$march+$mday)*$rday*$q;
				if($month==5)//may
				$int=($feb+$march+$april+$mday)*$rday*$q;
				}//close sem=1
				else
				{//open sem=2				
				if($month==7)//july
				$int=0;
				if($month==8)//august
				$int=$mday*$rday*$q;
				if($month==9) //sept
				$int=($aug+$mday)*$rday*$q;
				if($month==10)//oct
				$int=($aug+$sept+$mday)*$rday*$q;
				if($month==11)//nov
				$int=($aug+$sept+$oct+$mday)*$rday*$q;
				}//close sem =2
				}//close fee ==0
				else
				{//open payment found
				$row=mysqli_fetch_array($fee);
				$row2=$row['amount_paid'];
				if($sem==1){
				  
				 if($month==2){//feb
				 $rem=$q-$row2;
				 if(($rem==0)||($rem<0))
				 $int=0;else $int=$mday*$rday*$rem;
				 }
				  if($month==3){//march
				 if($row2>=(2*$q))//paid jan and feb
				 $int=0;
				 else{ //paid jan but not feb
				 $rem=(2*$q)- $row2;
				 $int=$mday*$rday*$rem;}
				 }//march closed
				  if($month==4){//aprial
				 if($row2 >= (3*$q)) //paid jan,feb march
				 $int=0;
				 else{ // paid jan, feb
				 $rem=(3*$q)- $row2; 
				 $int=$mday*$rday*$rem;}
				 }//close  aprial
				 if($month==5){//may
				 if($row2>=(4*$q))
				 $int=0;
				 else{ 
				 $rem=(4*$q)- $row2; 
				 $int=$mday*$rday*$rem;}
				 }//close may
				 }//close sem==1
				 else
				 {//open sem2
				 if($month==8){//aug
				  $rem=$q-$row2;
				 if(($rem==0)||($rem<0))
				 $int=0;else $int=$mday*$rday*$rem;                     
				 }
				 if($month==9){//sept
				 if($row2>=(2*$q))//paid july and aug
				 $int=0;
				 else {//paid july but not aug
				 $rem=(2*$q)- $row2;
				 $int=$mday*$rday*$rem;
				 }
				 }//sep closed
				 if($month==10){//oct
				 if($row2 >= (3*$q)) //paid july,aug sept
				 $int=0;
				 else{ // paid july, aug
				 $rem=(3*$q)- $row2; 
				 $int=$mday*$rday*$rem;
				 }
				 }//close  oct
				   if($month==11){//nov
				 if($row2>= (4*$q))
				  $int=0;
				 else{ 
				 $rem=(4*$q)- $row2; 
				 $int=$mday*$rday*$rem;}
				 }//close may
				 }//close sem=2
				 }//close payment found
				 if(isset($int)){
				 if($guess==2)$int=0;else  $int=$int;				
				 return $int;
				 }
				 }
		
				
 function databaseOutput() {

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
		 if($total>0){
		  while ($row = mysqli_fetch_array($query)) {
                           $student_id = $row['student_id'];
						   $results = mysqli_query($conn,"select * from subject where subject_code='$su_id'") or die(mysqli_error($conn));            
						   $results_row = mysqli_fetch_array($results);
						   ?>
						   <td><?php echo $row['student_id']?></td>
                             <td><?php echo $row['firstname']?></td> 
                             <td><?php echo $row['surname']?> </td>
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
                        <div class="alert alert-danger"><center><strong>DISTANCE STUDENTS</strong></center><br />
                        <?php echo "<b>F:</b>" .$faild."&nbsp;&nbsp;&nbsp;&nbsp;<b>P:</b>" .$passd."&nbsp;&nbsp;&nbsp;&nbsp;<b>CP:</b>" .$cps ."&nbsp;&nbsp;&nbsp;&nbsp;<b>MP:</b>" .$mps."&nbsp;&nbsp;&nbsp;&nbsp;<b>D:</b>" .$dzd; ?>&nbsp;&nbsp; <b>Total Passes:</b><?php $ss= ($passd+$cps+$mps+$dzd); echo $ss;?><b> Total Fails:</b> <?php echo $faild ?>&nbsp;&nbsp;<b>Total distance:</b><?php echo $ds  ?>&nbsp;&nbsp;<b>Pass Rate:</b> <?php if($ds==0){$ds=1;} $s= (($ss/$ds)*100); echo round($s,1)."%" ?>
                        </div>
                        <div class="alert alert-danger"><center><strong >FULLTIME STUDENTS</strong></center><br />
                        <?php echo "<b>F:</b>" .$fail."&nbsp;&nbsp;&nbsp;&nbsp;<b>P:</b>" .$pass."&nbsp;&nbsp;&nbsp;&nbsp;<b>CP:</b>" .$cpz ."&nbsp;&nbsp;&nbsp;&nbsp;<b>MP:</b>" .$mpz."&nbsp;&nbsp;&nbsp;&nbsp;<b>D:</b>" .$dz; ?> &nbsp;&nbsp; <b>Total Passes:</b><?php  echo $pass+$cpz+$mpz+$dz;?> <b>Total Fails:</b> <?php echo $fail ?>&nbsp;&nbsp;<b>Total Fulltime:</b><?php echo $ftt  ?>&nbsp;&nbsp;<b>Pass Rate:</b> <?php if($ftt==0){$ftt=1;} $v=((($pass+$cpz+$mpz+$dz)/$ftt)*100); echo round($v,1)."%" ?>
                        </div>
                       <div class="alert alert-danger"><center><strong>TOTAL CLASS STATICTICS</strong></center><br />
                        <?php echo "<b>F:</b>" .($faild+$fail)."&nbsp;&nbsp;&nbsp;&nbsp;<b>P:</b>" .($passd+$pass) ."&nbsp;&nbsp;&nbsp;&nbsp;<b>CP:</b>" .($cps+$cpz) ."&nbsp;&nbsp;&nbsp;&nbsp;<b>MP:</b>" .($mps+$mpz)."&nbsp;&nbsp;&nbsp;&nbsp;<b>D:</b>" .($dzd+$dz); ?> &nbsp;&nbsp; <b>Total Passes:</b><?php  $ps= (($pass+$cpz+$mpz+$dz)+($ss)); echo $ps;?> <b>Total Fails:</b> <?php echo $faild+$fail ?>&nbsp;&nbsp;<b>Total Class:</b><?php echo $total  ?>&nbsp;&nbsp;<b> Class Pass Rate:</b> <?php  if($total==0){$total=1;}$pp=(($ps/$total)*100); echo round($pp,1)."%" ?>
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
			
			            if(isset($_GET['send'])){//open if isset
							$prog=$_GET['sub'];
							$year=$_GET['year'];
							$sem=$_GET['sem'];
							$sel=$_GET['sel'];
							$cyear=$_GET['cyear'];
		if($sel==''){ //open sel
     $query = mysqli_query($conn,"select distinct student_id,uid,firstname,surname from results where stud_year='$cyear' and prog='$prog' and year='$year' and sem='$sem'") or die(mysqli_error($conn));
	 $total=mysqli_num_rows($query);
		 if($total>0){ //open total>0
		 ?>
         <div class="alert alert-info">Showing  <?php echo $prog;  ?>&nbsp;<?php echo $year;  ?>&nbsp;Year&nbsp;<?php echo $cyear;  ?> &nbsp;<?php  if($sem==1)echo "Jan-June"; else echo"July-Dec" ?> Semester&nbsp;Results</div>
         <?php
		 $fail=0; $pass=0;
		  while ($row = mysqli_fetch_array($query)) {//open loop first
                           $student_id = $row['student_id'];
						  $uid = $row['uid'];
						   ?>
                           <tr style=" color:#FF0000; font-family:Cambria; font-weight:600">
                           <td >STUDENT NAMES:&nbsp;<?php echo $row['surname']?>&nbsp;&nbsp;<?php echo $row['firstname']?></td></tr>
                           <tr style="  color:#FF0000; font-family:Cambria; font-weight:600">
						   <td >REGNO: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $row['student_id']?></td><td class="3"></td></tr>
                           
                            
                             
                              
                                                                 
                                  <tr>
                                 <td colspan="4"> 
                                 <table style="width:100%;">
                                 
                                <?php
                              $student = mysqli_query($conn,"select * from results where uid='$uid' and year='$year' and sem='$sem' and stud_year='$cyear'") or die("here".mysqli_error($conn)); 
							 if(mysqli_num_rows( $student)==0)
							{//open if
							echo "<tr><td colspan='7'>No exam results for student in".$year ."&nbsp;Semester&nbsp;".$sem ."</td> </tr>";
							}//close if
							else
							 {// open subjects found
							 ?>
                             
							    <tr style="font-weight:bold;  text-align:center" class="alert alert-info">
                                <td align="left">NO</td>
                             <td align="left">SUBJECT CODE</td>
                             <td align="left">SUBJECT NAME</td>
                             <td> ASSIGN1</td>
                             <td> ASSIGN2 </td>
                             <td> EXAM</td>
                             <td>OAG</td>
                              <td>REMARKS</td> 
                             </tr>
                             <?php
							
						   
							$status = mysqli_query($conn,"select distinct comment from results where uid='$uid' and year='$year' and sem='$sem' and comment='F'");
							  if(mysqli_num_rows($status)==0){$pass=$pass+1;}else {$fail=$fail+1;}
							  $i=1;
						    while($student_row = mysqli_fetch_array($student)){//open subject loop
							$cod=$student_row ['course_code'];
                          $title= mysqli_query($conn,"select * from subject where subject_code='$cod' ");
						  $ccode=mysqli_fetch_array($title);
						  
							
							 ?>
                            <tr align="center" id="disp">
                            <td align="left"><?php echo $i?></td>
							<td align="left"><?php echo $student_row['course_code']?></td>
                             <td width="210" align="left"><?php echo  $ccode['subject_title']?></td> 
                              <td><?php echo $student_row['assign_1']?> </td>
                              <td><?php echo $student_row['assign_2']?> </td>
                              <td><?php echo $student_row['EOS']?> </td>
                              <td><?php echo $student_row['fgrade']?> </td>
                              <td><?php echo $student_row['comment']?> </td>
                              
							   </tr>
                               
							<?php
							$i++;							
							}//close subject loop
						?>
						</table></td></tr>
							
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
	 function feeRepofirst($id,$amount,$tamountp,$intr,$bal,$date,$ttf,$fint)
	 {
$sel=mysqli_query($conn,"select * from student where id='$id'") or die("error ho".mysqli_error($conn));
$row=mysqli_fetch_array($sel);
$year=date('Y');
$sem=checksem();
if($sem==1)$sem="Jan-Jun"; else $sem="July-Dec";
$sid=$row['student_id'];
	 $mail=$row['spo_email'];
	 if($mail!='')
	 {
	 $message="$row[firstname]&nbsp;$row[middle_name]&nbsp;$row[lastname] FEES PAYMENT REPORT FOR  $year &nbsp; SEMESTER $sem\n
	 _________________________________________________________
	 StudentID:$sid\n
	 Amount paid: $amount\n
	 Total Amount paid: $tamountp\n
	  Total Fees For Semester:$ttf\n
	 Total Late Payment Interest:$intr\n
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
	  function feeRepoupdate($id,$am,$total,$date,$int,$bal,$ttf)
	  {
$sel=mysqli_query($conn,"select * from student where id='$id'") or die("error ho".mysqli_error($conn));
$row=mysqli_fetch_array($sel);
$sid=$row['student_id'];
$year=date('Y');
$sem=checksem();
if($sem==1)$sem="Jan-Jun"; else $sem="July -Dec";
	 $mail=$row['spo_email'];
	 if($mail!='')
	 {
	  $message="$row[firstname]&nbsp;$row[middle_name]&nbsp;$row[lastname] FEES PAYMENT REPORT FOR  $year &nbsp; SEMESTER $sem\n
	 ________________________________________________________
	  StudentID:$sid\n
	 Amount paid: $am\n
	 Total Amount paid: $total\n
	 Total Fees for Semester:$ttf\n
	 Total Late Payment Interest:$int\n
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
	 $msg="Fees Payment Information send to".$mail."<br> Information sent<br>".$message;
	 }
	 else{
	 $msg="Fees Payment Information not sent.No sponsor/parent email was found\n";
	 }
	 if(isset($msg)){
	 return $msg;
	 }
	 }
	 
	 function printreciept($id,$amount,$tamountp,$intr,$bal,$ttf,$fpint)
	 {
	 
$sel=mysqli_query($conn,"select * from student where id='$id'") or die("error ho".mysqli_error($conn));
$row=mysqli_fetch_array($sel);
$year=date('Y');
$sem2=checksem();
$sem=checksem();
if($sem==1)$sem="January-June"; else $sem="July-December";
$sid=$row['student_id'];
$this_id=$row['id'];
 $Today = date('y:m:d');
  $new = date('l, F d, Y', strtotime($Today));
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
  <tr><td rowspan="2"><img src="images/logo.png" width="50" height="50"/></td>
  <td colspan="2"><h4>BLANTYRE INTERNATIONAL UNIVERSITY</h4></td></tr>
    <tr><td colspan="2"><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;FEES PAYMENT RECIEPT</span></td>
  </tr>
  <tr><td colspan="2"></td></tr>    
  <tr><td>Student Name:</td><td colspan="2"><?php echo $row['firstname'] ."&nbsp;".$row['lastname'] ?></td></tr>
     <tr><td>Programme:</td><td colspan="2"><?php echo $row['cys'] ?>&nbsp;&nbsp;<?php  if ($row['mode']==1) echo "Full time"; else echo "Distance"; ?></td></tr>
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
              <th align="left">Interest: </th>
              <td>MWK<?php echo number_format($intr)?></td>
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
	 
	 function printreciept2($id,$am,$total,$int,$bal,$ttf)
	 {
$sel=mysqli_query($conn,"select * from student where id='$id'") or die("error ho".mysqli_error($conn));
$row=mysqli_fetch_array($sel);
$year=date('Y');
$sem2=checksem();
$sem=checksem();
if($sem==1)$sem="January-June"; else $sem="July-December";
$sid=$row['student_id'];
$this_id=$row['id'];
 $Today = date('y:m:d');
  $new = date('l, F d, Y', strtotime($Today));
  //$selc=mysqli_query($conn,"select * from student_fees where fee_balance<>'0' and sem='$sem2' and year='$year'") or die("error ho".mysqli_error($conn));
  //$num=mysqli_num_rows($selc);
   $querry=mysqli_query($conn,"select * from student_fees where id ='$this_id' and year='$year' and sem='$sem2' and exam_no<>''") or die(mysqli_error($conn));
  $exa=mysqli_fetch_array( $querry);
  $exano=$exa['exam_no'];
 
// Add image elements


	?>
<table width="915"  border="0" align="center" width="90%">
  <tr><td rowspan="2"> <img src="images/logo.png" width="50" height="50"/></td>
  <td colspan="2"><h4>BLANTYRE INTERNATIONAL UNIVERSITY</h4></td></tr>
    <tr><td colspan="2"><span >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;FEES PAYMENT RECIEPT</span></td>
  </tr>
  <tr><td colspan="2"></td></tr>    
  <tr><td>Student Name:</td><td colspan="2"><?php echo $row['firstname'] ."&nbsp;".$row['lastname'] ?></td></tr>
     <tr><td>Programme:</td><td colspan="2"><?php echo $row['cys'] ?> &nbsp;&nbsp;<?php  if ($row['mode']==1) echo "Full time"; else echo "Distance"; ?></td></tr>
      <tr><td>Payment:</td><td colspan="2">Tuition Fees</td></tr>
       <tr><td>PaymentDate:</td><td colspan="2"><?php echo $new ?></td></tr>
       <tr><td>Exam Number:</td><td colspan="2"><?php echo $exano; ?></td></tr>
        <tr><td><div style="border:2px  dotted; width:100%; font-size:10px; font-weight:bold; text-align: center; line-height:1em; ">FEES ONCE PAID ARE NEITHER REFUNDABLE NOR TRANSFERABLE</div></td>
          <td colspan="2">
          <table width="70%" border="0" align="right">
            <tr>
              <th width="392" align="left">Fees Amount:</th>
              <td width="508">MWK<?php echo number_format($ttf);?></td>
            </tr>
            <tr>
              <th  align="left"> Interest: </th>
              <td>MWK<?php echo number_format($int)?></td>
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
						
						
                        
			