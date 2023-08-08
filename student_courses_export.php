<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>
    <title>Students</title>
    <?php 
	include('connect.php');
	//include('header.php');
	include('functions.php');
  	// end of function databaseOutput()

if (isset($_GET['send2'])) { // word output
$subid=$_GET['sub'];
   $subsel=mysqli_query($conn,"select * from course where course_id='$subid'")or die(mysqli_error($conn));
   $rows=mysqli_fetch_array($subsel);
   $course_title=$rows['cys'];
  header("Content-Type:application/msWord");
  header("Expires: 0");
  header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
  header("content-disposition: attachment;filename=".$course_title."Student_Courses.doc");

?>
<html>
<head>

</head>
  <body>
     <center><b><h3>Blantyre International University</h3></b></center><p>Registered Course List for <?php echo $course_title ?> <?php  if(checksem()==1) echo "January-June &nbsp;".date('Y');else  echo "July-December &nbsp;".date('Y');?>  &nbsp; Students</p>
   
   <table  width="90%" align="center" border="1" >
                    
                                 <thead>
                                 <tr align="center" bgcolor="DDDDDD">
                               <th align="left">No</th>
                               <th>Student Details and  Registered Courses</th>
                   </tr>
                    </thead>
                        <tbody> 
                           <!-- end script -->
                           <?php include('myCourses.php')  ?>
                          <!-- user delete modal -->
                        </tbody>
                  </table>
  </body>
</html>
<?php

  exit; // end of word output
}
?>
