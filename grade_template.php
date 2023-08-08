<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>
    <title>Students</title>
    <?php 
	include('connect.php');
	//include('header.php');
	include('functions.php');
  	// end of function databaseOutput()

if (isset($_GET['send'])) { // word output
$subid=$_GET['subject'];
$year= $_GET['year'];
$sem=$_GET['sem'];
   $subsel=mysqli_query($conn,"select * from subject where subject_id='$subid'")or die(mysqli_error($conn));
   $rows=mysqli_fetch_array($subsel);
   $course_title=$rows['subject_title'];
  header("Content-Type:application/xls");
  header("Expires: 0");
  header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
  header("content-disposition: attachment;filename=".$course_title."_Grades_Upload_Temp.xls");

?>
<html>
<head>

</head>
  <body>
 <p><font color ="green"><h3><?php echo $course_title; ?>(<?php if($sem==1) echo "Jan-June". "  " . $year; else echo "July-Dec" . "  " . $year?>)</h3></p>
   <table  width="400" align="left" border="1" >
                    
                                 <thead>
                                 <tr align="left" bgcolor="DDDDDD">
                               <th>Student ID</th>
                                <th>Lastname</th>
                                 <th>Firstname</th>
                                  <th>Course Work1</th>
                                  <th>Course Work2</th>
                                  <th>Exam</th>
                                  <th> EOS </th>
                   </tr>
                    </thead>
                        <tbody> 
                           <!-- end script -->
                           <?php include('stud_grade_upload_temp.php')  ?>
                          <!-- user delete modal -->
                        </tbody>
                        
                  </table>
                  <table  width="400" align="left" border="0" >
                      <tr>
                        <td></td><td colspan="6">&nbsp; </td> 
                      </tr>
                      
                      <tr> 
                      <td></td><td colspan="6">Enter grades for &nbsp; <font color ="red"><b><?php echo $course_title; ?></b></font> ONLY. Please <font color ="red">DONT EDIT(but can delete a record you dont have any grade for)</font> or <font color ="red">ADD or REMOVE ROWS </font><br> to this template, you (will disturb formulae) just enter the grades. <br>Save this file as <font color ="red">Excel workbook(xlsx)</font> before uploading into <font color ="green">SIMS</font>  otherwise it will not upload to SIMS</td>
                      </tr>
                    </table>  
                   
  </body>
</html>
<?php

  exit; // end of word output
}
?>
