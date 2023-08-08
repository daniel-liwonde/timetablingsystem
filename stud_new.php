<?php

function allprog_bothmode_bothgender($year,$sem,$accYear,$accSem,$General)
{
include('connect.php');  
if($General==1)
{//open general
$stud_history= mysqli_query($conn,"select DISTINCT uid,studsem,year, stud_year, sem,surname, firstname,student_id from results where   year='$year' and stud_year='$accYear' and sem='$sem' and studsem='$accSem'") or die(mysqli_error($conn));  
$i=1;
while($row=mysqli_fetch_array($stud_history))
{//open while loop
 ?>
<tr class="odd gradeX" align="left">  <td><?php echo $i;?> </td>                               
                                       <td align="left"><?php echo $row['student_id']?> </td>
 										<td><?php echo $row['surname']?> </td>
                                          <td><?php echo $row['firstname']?> </td>
                                           <td> </td>
                                          <td><?php echo $row['prog']?> </td>
                                          <td><?php echo $row['stud_year']?> </td>
                                          <td><?php echo $row['studsem']?> </td>
                                           <td><?php echo $row['year']?> </td>
                                          <td><?php if ($row['sem']==1)echo "Jan-June"; else echo "July-Dec"; ?> </td>
                                          <td> </td>
 </tr>
<?php
$i++;
}//close while loop 
}//close general
else
{//open no general
$sel=mysqli_query($conn,"select * from student where   addm_year='$year' and system_sem='$sem'  ") or die(mysqli_error($conn));
$i=1;
while($row=mysqli_fetch_array($sel)){//open loop
?>
<tr class="odd gradeX" align="left">  <td><?php echo $i;?> </td>                               
                                       <td align="left"><?php echo $row['student_id']?> </td>
 										<td><?php echo $row['lastname']?> </td>
                                          <td><?php echo $row['firstname']?> </td>
                                           <td><?php if($row['mode']==1) echo "F";else echo "D";?> </td>
                                          <td><?php echo $row['cys']?> </td>
                                          <td><?php echo $row['stud_current_year']?> </td>
                                          <td><?php echo $row['current_sem']?> </td>
                                           <td><?php echo $row['addm_year']?> </td>
                                          <td><?php if ($row['sem']==1)echo "Jan-June"; else echo "July-Dec"; ?> </td>
                                          <td><?php echo $row['gender']?> </td>
                                        
 </tr>
<?php
$i++;
}//close while loop
}//close no general
}//close function
function prog_bothmode_bothgender($year,$sem,$p)
{
include('connect.php');   
$sel=mysqli_query($conn,"select * from student where   addm_year='$year' and system_sem='$sem' and cys='$p'") or die(mysqli_error($conn));
$i=1;
while($row=mysqli_fetch_array($sel)){//open loop
?>
<tr class="odd gradeX" align="center">  <td><?php echo $i;?> </td>                               
                                       <td align="left"><?php echo $row['student_id']?> </td>
 										<td><?php echo $row['lastname']?> </td>
                                          <td><?php echo $row['firstname']?> </td>
                                           <td><?php if($row['mode']==1) echo "F";else echo "D";?> </td>
                                          <td><?php echo $row['cys']?> </td>
                                          <td><?php echo $row['stud_current_year']?> </td>
                                          <td><?php echo $row['current_sem']?> </td>
                                           <td><?php echo $row['addm_year']?> </td>
                                          <td><?php if ($row['sem']==1)echo "Jan-June"; else echo "July-Dec"; ?> </td>
                                          <td><?php echo $row['gender'] ?></td>
                                        
 </tr>
<?php
$i++;
//}//close loop
}//close else
}//close if fees=1
function allprog_bothmode_female($year,$sem)
{
include('connect.php');    
$sel=mysqli_query($conn,"select * from student where   addm_year='$year' and system_sem='$sem' and gender='Female'") or die(mysqli_error($conn));
$i=1;
while($row=mysqli_fetch_array($sel)){//open loop
?>
<tr class="odd gradeX" align="center">  <td><?php echo $i;?> </td>                               
                                       <td align="left"><?php echo $row['student_id']?> </td>
 										<td><?php echo $row['lastname']?> </td>
                                          <td><?php echo $row['firstname']?> </td>
                                           <td><?php if($row['mode']==1) echo "F";else echo "D";?> </td>
                                          <td><?php echo $row['cys']?> </td>
                                          <td><?php echo $row['stud_current_year']?> </td>
                                          <td><?php echo $row['current_sem']?> </td>
                                           <td><?php echo $row['addm_year']?> </td>
                                          <td><?php if ($row['sem']==1)echo "Jan-June"; else echo "July-Dec"; ?> </td>
                                          <td><?php echo $row['gender']?> </td>
                                        
 </tr>
<?php
$i++;
//}//close loop
}//close else
}//close if fees=1
function allprog_bothmode_male($year,$sem)
{
include('connect.php');   
$sel=mysqli_query($conn,"select * from student where   addm_year='$year' and sem='$sem' and gender='Male'") or die(mysqli_error($conn));
$i=1;
while($row=mysqli_fetch_array($sel)){//open loop
?>
<tr class="odd gradeX" align="center">  <td><?php echo $i;?> </td>                               
                                       <td align="left"><?php echo $row['student_id']?> </td>
 										<td><?php echo $row['lastname']?> </td>
                                          <td><?php echo $row['firstname']?> </td>
                                           <td><?php if($row['mode']==1) echo "F";else echo "D";?> </td>
                                          <td><?php echo $row['cys']?> </td>
                                          <td><?php echo $row['stud_current_year']?> </td>
                                          <td><?php echo $row['current_sem']?> </td>
                                          <td><?php echo $row['addm_year']?> </td>
                                          <td><?php if ($row['sem']==1)echo "Jan-June"; else echo "July-Dec"; ?> </td>
                                          <td><?php echo $row['gender']?> </td>
                                        
 </tr>
<?php
$i++;
//}//close loop
}//close else
}//close if fees=1
function allprog_bothmode_female_distance($y,$sem)
{
include('connect.php');    
$sel=mysqli_query($conn,"select * from student where   addm_year='$y' and system_sem='$sem' and gender='Female' and mode=2") or die(mysqli_error($conn));
$i=1;
while($row=mysqli_fetch_array($sel)){//open loop
?>
<tr class="odd gradeX" align="center">  <td><?php echo $i;?> </td>                               
                                       <td align="left"><?php echo $row['student_id']?> </td>
 										<td><?php echo $row['lastname']?> </td>
                                          <td><?php echo $row['firstname']?> </td>
                                           <td><?php if($row['mode']==1) echo "F";else echo "D";?> </td>
                                          <td><?php echo $row['cys']?> </td>
                                          <td><?php echo $row['stud_current_year']?> </td>
                                          <td><?php echo $row['current_sem']?> </td>
                                          <td><?php echo $row['addm_year']?> </td>
                                          <td><?php if ($row['sem']==1)echo "Jan-June"; else echo "July-Dec"; ?> </td>
                                          <td><?php echo $row['gender']?> </td>
                                        
 </tr>
<?php
$i++;
//}//close loop
}//close else
}//close if fees=1
function allprog_bothmode_male_distance($y,$sem)
{
include('connect.php');   
$sel=mysqli_query($conn,"select * from student where   addm_year='$y' and system_sem='$sem' and gender='Male' and mode=2") or die(mysqli_error($conn));
$i=1;
while($row=mysqli_fetch_array($sel)){//open loop
?>
<tr class="odd gradeX" align="center">  <td><?php echo $i;?> </td>                               
                                       <td align="left"><?php echo $row['student_id']?> </td>
 										<td><?php echo $row['lastname']?> </td>
                                          <td><?php echo $row['firstname']?> </td>
                                           <td><?php if($row['mode']==1) echo "F";else echo "D";?> </td>
                                          <td><?php echo $row['cys']?> </td>
                                          <td><?php echo $row['stud_current_year']?> </td>
                                          <td><?php echo $row['current_sem']?> </td>
                                           <td><?php echo $row['addm_year']?> </td>
                                          <td><?php if ($row['sem']==1)echo "Jan-June"; else echo "July-Dec"; ?> </td>
                                          <td><?php echo $row['gender']?> </td>
                                        
 </tr>
<?php
$i++;
//}//close loop
}//close else
}//close if fees=1
function allprog_male_full($y,$sem)
{
 include('connect.php');   
$sel=mysqli_query($conn,"select * from student where   addm_year='$y' and system_sem='$sem' and gender='Male' and mode=1") or die(mysqli_error($conn));
$i=1;
while($row=mysqli_fetch_array($sel)){//open loop
?>
<tr class="odd gradeX" align="center">  <td><?php echo $i;?> </td>                               
                                       <td align="left"><?php echo $row['student_id']?> </td>
 										<td><?php echo $row['lastname']?> </td>
                                          <td><?php echo $row['firstname']?> </td>
                                           <td><?php if($row['mode']==1) echo "F";else echo "D";?> </td>
                                          <td><?php echo $row['cys']?> </td>
                                          <td><?php echo $row['stud_current_year']?> </td>
                                          <td><?php echo $row['current_sem']?> </td>
                                           <td><?php echo $row['addm_year']?> </td>
                                          <td><?php if ($row['sem']==1)echo "Jan-June"; else echo "July-Dec"; ?> </td>
                                          <td><?php echo $row['gender']?> </td>
                                        
 </tr>
<?php
$i++;
//}//close loop
}//close else
}//close if fees=1
function allprog_female_full($y,$sem)
{
include('connect.php');    
$sel=mysqli_query($conn,"select * from student where   addm_year='$y' and system_sem='$sem' and gender='Female' and mode=1") or die(mysqli_error($conn));
$i=1;
while($row=mysqli_fetch_array($sel)){//open loop
?>
<tr class="odd gradeX" align="center">  <td><?php echo $i;?> </td>                               
                                       <td align="left"><?php echo $row['student_id']?> </td>
 										<td><?php echo $row['lastname']?> </td>
                                          <td><?php echo $row['firstname']?> </td>
                                           <td><?php if($row['mode']==1) echo "F";else echo "D";?> </td>
                                          <td><?php echo $row['cys']?> </td>
                                          <td><?php echo $row['stud_current_year']?> </td>
                                          <td><?php echo $row['current_sem']?> </td>
                                          <td><?php echo $row['addm_year']?> </td>
                                          <td><?php if ($row['sem']==1)echo "Jan-June"; else echo "July-Dec"; ?> </td>
                                          <td><?php echo $row['gender']?> </td>
                                        
 </tr>
<?php
$i++;
//}//close loop
}//close else
}//close if fees=1

function allprog_distance_all($y,$sem)
{
 include('connect.php');   
$sel=mysqli_query($conn,"select * from student where   addm_year='$y' and system_sem='$sem'  and mode=2") or die(mysqli_error($conn));
$i=1;
while($row=mysqli_fetch_array($sel)){//open loop
?>
<tr class="odd gradeX" align="center">  <td><?php echo $i;?> </td>                               
                                       <td align="left"><?php echo $row['student_id']?> </td>
 										<td><?php echo $row['lastname']?> </td>
                                          <td><?php echo $row['firstname']?> </td>
                                           <td><?php if($row['mode']==1) echo "F";else echo "D";?> </td>
                                          <td><?php echo $row['cys']?> </td>
                                          <td><?php echo $row['stud_current_year']?> </td>
                                          <td><?php echo $row['current_sem']?> </td>
                                          <td><?php echo $row['addm_year']?> </td>
                                          <td><?php if ($row['sem']==1)echo "Jan-June"; else echo "July-Dec"; ?> </td>
                                          <td><?php echo $row['gender']?> </td>
                                        
 </tr>
<?php
$i++;
//}//close loop
}//close else
}
function allprog_full_all($y,$sem)
{
 include('connect.php');   
$sel=mysqli_query($conn,"select * from student where   addm_year='$y' and system_sem='$sem'  and mode=1") or die(mysqli_error($conn));
$i=1;
while($row=mysqli_fetch_array($sel)){//open loop
?>
<tr class="odd gradeX" align="center">  <td><?php echo $i;?> </td>                               
                                       <td align="left"><?php echo $row['student_id']?> </td>
 										<td><?php echo $row['lastname']?> </td>
                                          <td><?php echo $row['firstname']?> </td>
                                           <td><?php if($row['mode']==1) echo "F";else echo "D";?> </td>
                                          <td><?php echo $row['cys']?> </td>
                                          <td><?php echo $row['stud_current_year']?> </td>
                                          <td><?php echo $row['current_sem']?> </td>
                                           <td><?php echo $row['addm_year']?> </td>
                                          <td><?php if ($row['sem']==1)echo "Jan-June"; else echo "July-Dec"; ?> </td>
                                          <td><?php echo $row['gender']?> </td>
                                        
 </tr>
<?php
$i++;
//}//close loop
}//close else
}//close if fees=1
function prog_distance_all($y,$sem,$pro)
{
 include('connect.php');   
$sel=mysqli_query($conn,"select * from student where   addm_year='$y' and system_sem='$sem'  and mode=2 and cys='$pro'") or die(mysqli_error($conn));
$i=1;
while($row=mysqli_fetch_array($sel)){//open loop
?>
<tr class="odd gradeX" align="center">  <td><?php echo $i;?> </td>                               
                                       <td align="left"><?php echo $row['student_id']?> </td>
 										<td><?php echo $row['lastname']?> </td>
                                          <td><?php echo $row['firstname']?> </td>
                                           <td><?php if($row['mode']==1) echo "F";else echo "D";?> </td>
                                          <td><?php echo $row['cys']?> </td>
                                          <td><?php echo $row['stud_current_year']?> </td>
                                          <td><?php echo $row['current_sem']?> </td>
                                           <td><?php echo $row['addm_year']?> </td>
                                          <td><?php if ($row['sem']==1)echo "Jan-June"; else echo "July-Dec"; ?> </td>
                                          <td><?php echo $row['gender']?> </td>
                                        
 </tr>
<?php
$i++;
//}//close loop
}//close else
}
function prog_full_all($y,$sem,$pro)
{
 include('connect.php');   
$sel=mysqli_query($conn,"select * from student where   addm_year='$y' and system_sem='$sem'  and mode=1 and cys='$pro'") or die(mysqli_error($conn));
$i=1;
while($row=mysqli_fetch_array($sel)){//open loop
?>
<tr class="odd gradeX" align="center">  <td><?php echo $i;?> </td>                               
                                       <td align="left"><?php echo $row['student_id']?> </td>
 										<td><?php echo $row['lastname']?> </td>
                                          <td><?php echo $row['firstname']?> </td>
                                           <td><?php if($row['mode']==1) echo "F";else echo "D";?> </td>
                                          <td><?php echo $row['cys']?> </td>
                                          <td><?php echo $row['stud_current_year']?> </td>
                                          <td><?php echo $row['current_sem']?> </td>
                                          <td><?php echo $row['addm_year']?> </td>
                                          <td><?php if ($row['sem']==1)echo "Jan-June"; else echo "July-Dec"; ?> </td>
                                          <td><?php echo $row['gender']?> </td>
                                        
 </tr>
<?php
$i++;
//}//close loop
}//close else
}
function prog_distance_female($y,$sem,$pro)
{
 include('connect.php');   
$sel=mysqli_query($conn,"select * from student where   addm_year='$y' and system_sem='$sem'  and mode=2 and cys='$pro' and gender='Female'") or die(mysqli_error($conn));
$i=1;
while($row=mysqli_fetch_array($sel)){//open loop
?>
<tr class="odd gradeX" align="center">  <td><?php echo $i;?> </td>                               
                                       <td align="left"><?php echo $row['student_id']?> </td>
 										<td><?php echo $row['lastname']?> </td>
                                          <td><?php echo $row['firstname']?> </td>
                                           <td><?php if($row['mode']==1) echo "F";else echo "D";?> </td>
                                          <td><?php echo $row['cys']?> </td>
                                          <td><?php echo $row['stud_current_year']?> </td>
                                          <td><?php echo $row['current_sem']?> </td>
                                           <td><?php echo $row['addm_year']?> </td>
                                          <td><?php if ($row['sem']==1)echo "Jan-June"; else echo "July-Dec"; ?> </td>
                                          <td><?php echo $row['gender']?> </td>
                                        
 </tr>
<?php
$i++;
//}//close loop
}//close else
}
function prog_full_female($y,$sem,$pro)
{
 include('connect.php');   
$sel=mysqli_query($conn,"select * from student where   addm_year='$y' and system_sem='$sem'  and mode=1 and cys='$pro' and gender='Female'") or die(mysqli_error($conn));
$i=1;
while($row=mysqli_fetch_array($sel)){//open loop
?>
<tr class="odd gradeX" align="center">  <td><?php echo $i;?> </td>                               
                                       <td align="left"><?php echo $row['student_id']?> </td>
 										<td><?php echo $row['lastname']?> </td>
                                          <td><?php echo $row['firstname']?> </td>
                                           <td><?php if($row['mode']==1) echo "F";else echo "D";?> </td>
                                          <td><?php echo $row['cys']?> </td>
                                          <td><?php echo $row['stud_current_year']?> </td>
                                          <td><?php echo $row['current_sem']?> </td>
                                          <td><?php echo $row['addm_year']?> </td>
                                          <td><?php if ($row['sem']==1)echo "Jan-June"; else echo "July-Dec"; ?> </td>
                                          <td><?php echo $row['gender']?> </td>
                                        
 </tr>
<?php
$i++;
//}//close loop
}//close else
}
function prog_full_male($y,$sem,$pro)
{
  include('connect.php'); 
$sel=mysqli_query($conn,"select * from student where   addm_year='$y' and system_sem='$sem'  and mode=1 and cys='$pro' and gender='Male'") or die(mysqli_error($conn));
$i=1;
while($row=mysqli_fetch_array($sel)){//open loop
?>
<tr class="odd gradeX" align="center">  <td><?php echo $i;?> </td>                               
                                       <td align="left"><?php echo $row['student_id']?> </td>
 										<td><?php echo $row['lastname']?> </td>
                                          <td><?php echo $row['firstname']?> </td>
                                           <td><?php if($row['mode']==1) echo "F";else echo "D";?> </td>
                                          <td><?php echo $row['cys']?> </td>
                                          <td><?php echo $row['stud_current_year']?> </td>
                                          <td><?php echo $row['current_sem']?> </td>
                                           <td><?php echo $row['addm_year']?> </td>
                                          <td><?php if ($row['sem']==1)echo "Jan-June"; else echo "July-Dec"; ?> </td>
                                          <td><?php echo $row['gender']?> </td>
                                        
 </tr>
<?php
$i++;
//}//close loop
}//close else
}
function prog_distance_male($y,$sem,$pro)
{
  include('connect.php');  
$sel=mysqli_query($conn,"select * from student where   addm_year='$y' and system_sem='$sem'  and mode=2 and cys='$pro' and gender='Male'") or die(mysqli_error($conn));
$i=1;
while($row=mysqli_fetch_array($sel)){//open loop
?>
<tr class="odd gradeX" align="center">  <td><?php echo $i;?> </td>                               
                                       <td align="left"><?php echo $row['student_id']?> </td>
 										<td><?php echo $row['lastname']?> </td>
                                          <td><?php echo $row['firstname']?> </td>
                                           <td><?php if($row['mode']==1) echo "F";else echo "D";?> </td>
                                          <td><?php echo $row['cys']?> </td>
                                          <td><?php echo $row['stud_current_year']?> </td>
                                          <td><?php echo $row['current_sem']?> </td>
                                          <td><?php echo $row['addm_year']?> </td>
                                          <td><?php if ($row['sem']==1)echo "Jan-June"; else echo "July-Dec"; ?> </td>
                                          <td><?php echo $row['gender']?> </td>
                                        
 </tr>
<?php
$i++;
//}//close loop
}//close else
}
 function prog_bothmode_male($y,$sem,$pro)
{
 include('connect.php');   
$sel=mysqli_query($conn,"select * from student where   addm_year='$y' and system_sem='$sem'   and cys='$pro' and gender='Male'") or die(mysqli_error($conn));
$i=1;
while($row=mysqli_fetch_array($sel)){//open loop
?>
<tr class="odd gradeX" align="center">  <td><?php echo $i;?> </td>                               
                                       <td align="left"><?php echo $row['student_id']?> </td>
 										<td><?php echo $row['lastname']?> </td>
                                          <td><?php echo $row['firstname']?> </td>
                                           <td><?php if($row['mode']==1) echo "F";else echo "D";?> </td>
                                          <td><?php echo $row['cys']?> </td>
                                          <td><?php echo $row['stud_current_year']?> </td>
                                          <td><?php echo $row['current_sem']?> </td>
                                          <td><?php echo $row['addm_year']?> </td>
                                          <td><?php if ($row['sem']==1)echo "Jan-June"; else echo "July-Dec"; ?> </td>
                                          <td><?php echo $row['gender']?> </td>
                                        
 </tr>
<?php
$i++;
//}//close loop
}//close else
}
function prog_bothmode_female($y,$sem,$pro)
{
 include('connect.php');   
$sel=mysqli_query($conn,"select * from student where   addm_year='$y' and system_sem='$sem' and gender='Female'  and cys='$pro'") or die(mysqli_error($conn));
$i=1;
while($row=mysqli_fetch_array($sel)){//open loop
?>
<tr class="odd gradeX" align="left">  <td><?php echo $i;?> </td>                               
                                       <td align="left"><?php echo $row['student_id']?> </td>
 										<td><?php echo $row['lastname']?> </td>
                                          <td><?php echo $row['firstname']?> </td>
                                           <td><?php if($row['mode']==1) echo "F";else echo "D";?> </td>
                                          <td><?php echo $row['cys']?> </td>
                                          <td><?php echo $row['stud_current_year']?> </td>
                                          <td><?php echo $row['current_sem']?> </td>
                                          <td><?php echo $row['addm_year']?> </td>
                                          <td><?php if ($row['sem']==1)echo "Jan-June"; else echo "July-Dec"; ?> </td>
                                          <td><?php echo $row['gender']?> </td>
                                        
 </tr>
<?php
$i++;
//}//close loop
}//close else
}
if(isset($_GET['send']))
{// if send
//$year= $_GET['addmyear'];
$sems=$_GET['s'];
$y=$_GET['year'];
if(isset($_GET['General']))
{
$General= $_GET['General'];
$accYear= $_GET['accYear'];
$accSem= $_GET['accSemester'];
}
else
{
 $accYear= "";
$accSem= "";
$General="";
}
//$sem= $_GET['sem'];
//$cyear= $_GET['year'];
$mode= $_GET['mode'];
$prog= $_GET['prog'];
$gender= $_GET['gender'];
if($prog=="all"){
if($gender==3 and $mode==3)
allprog_bothmode_bothgender($y,$sems, $accYear,$accSem,$General);	
if($gender==2 && $mode==3)
allprog_bothmode_female($y,$sems);
if( $gender==1 && $mode==3)
allprog_bothmode_male($y,$sems);
if($gender==2 && $mode==2)
allprog_bothmode_female_distance($y,$sems);
if($gender==2 && $mode==1)
allprog_female_full($y,$sems);
if(($gender==1) && ($mode==1))
allprog_male_full($y,$sems);
if(($gender==1) && ($mode==2))
allprog_bothmode_male_distance($y,$sems);
if(($gender==3) && ($mode==2))
allprog_distance_all($y,$sems);
if(($gender==3) && ($mode==1))
allprog_full_all($y,$sems);
}

else
{
if(($gender==3) && ($mode==2))	
prog_distance_all($y,$sems,$prog);
if(($gender==3) && ($mode==1))	
prog_full_all($y,$sems,$prog);
if(($gender==1) && ($mode==1))		
prog_full_male($y,$sems,$prog);	
if(($gender==2) && ($mode==1))
prog_full_female($y,$sems,$prog)	;
if(($gender==2) && ($mode==2))
prog_distance_female($y,$sems,$prog);
if(($gender==1) &&( $mode==2))
prog_distance_male($y,$sems,$prog);
if(($gender==3) && ($mode==3))
prog_bothmode_bothgender($y,$sems,$prog);
if(($gender==1) && ($mode==3))
prog_bothmode_male($y,$sems,$prog);
if(($gender==2) && ($mode==3))
prog_bothmode_female($y,$sems,$prog);
}
}

?>
