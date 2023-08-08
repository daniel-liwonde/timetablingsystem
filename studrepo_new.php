<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>
    <title>Students</title>
    <?php 
	include('connect.php');
	include('functions.php');
  	// end of function databaseOutput()

if (isset($_GET['send'])) { // word output
$sems=$_GET['s'];
 if($_GET['prog']=="all")
 {
 $doc="All programmes ";
 }
  if($_GET['prog']!="all"){
  $doc=$prog;
 }
 if($_GET['gender']==1){
  $doc1="Male";
 }
 if($_GET['gender']==2){
  $doc1="Female";
 }
 if($_GET['gender']==3){
  $doc1="Male and Female";
  }
  if($_GET['mode']==1){
  $modes="Full time";
  }
  if($_GET['mode']==2){
  $modes="Distance";
  }
   if($_GET['mode']==3){
  $modes="Full time and Distance";
  }
  if($sems==1)
  $semm="Jan-June";
   if($sems==2)
  $semm="July-Dec";
  header("Content-Type:application/msexcel");
  header("Expires: 0");
  header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
  header("content-disposition: attachment;filename=New_students.xlx");

?>
<html>
<head>
</head>
  <body>
     
     <h3><center><font color="#0066FF">BLANTYRE INTERNATIONAL UNIVERSITY</font></center>
    <center><h3><?php echo $_GET['year']." ".$doc  ?> &nbsp;<?php echo $semm  ?> &nbsp;<?php echo $modes  ?> &nbsp;<?php echo $doc1  ?>&nbsp;Enrolled Students</h3></center>
    <table  width="80%" align="center" border="1">
     <tr bgcolor="#CCCCCC" >
<th>No</th>
     <th align="left">StudentID</th>
                              <th>Lastname</th>
                              <th>Firstname</th>
                                <th>Mode</th>
                                  <th>Programme</th>
                                  <th>Current Year</th>
                                  <th>Current Sem</th>
                                  <th>Admission Year</th>
								   <th>Admission Semester</th>
                                  <th>Gender</th>                               
                   </tr>
      <?php include('stud_new.php'); ?>
    </table>
  </body>
</html>
<?php

  exit; // end of word output

}
?>
