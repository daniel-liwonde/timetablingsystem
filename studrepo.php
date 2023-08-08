<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>
    <title>Students</title>
    <?php 
	include('connect.php');
	//include('stud.php');
  	// end of function databaseOutput()

if (isset($_GET['send'])) { // word output
 if($_GET['year']==1)
 {
 $doc="first year ";
 }
  if($_GET['year']==2){
  $doc="second year";
 }
  if($_GET['year']==3){
  $doc="third year";
 }
 if($_GET['year']==4){
  $doc="fourth year";
 }
 if($_GET['year']==5){
  $doc="All";
 }
  header("Content-Type:application/msexcel");
  header("Expires: 0");
  header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
  header("content-disposition: attachment;filename=Students_Rerort.xlx");

?>
<html>
<head>
</head>
  <body>
     
     <h3><center><font color="#0066FF">BLANTYRE INTERNATIONAL UNIVERSITY</font></center>
    <center><h3><?php if(isset($doc))echo $doc."&nbsp;&nbsp;";if(isset($_GET['sel'])){echo $_GET['sel']."&nbsp;&nbsp;";} if(isset($_GET['sem'])&&($_GET['year']!=5)) echo "Sem&nbsp;".$_GET['sem'];?> &nbsp;Students</h3></center>
    <table  width="80%" align="center" border="1">
     <tr bgcolor="#CCCCCC" >
<th>No</th>
     <th align="left">StudentID</th>
                              <th>Lastname</th>
                              <th>Firstname</th>
                                <th>Mode</th>
                                  <th>Programme</th>
                                  <th>Year of study</th>
                                  <th>Semester</th>
                                  <th>Phone Number</th>
								  <th>Email</th> 
                                  <th>Gender</th> 
                                   <th>Postal Address</th>
								<th>Admission Year</th>								  
                   </tr>
      <?php include('stud.php'); ?>
    </table>
  </body>
</html>
<?php

  exit; // end of word output

}
?>
