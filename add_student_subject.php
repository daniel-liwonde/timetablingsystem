<?php
include('session.php');
include('header.php');
include('functions.php');
$username=$_GET['uname'];
if(isset($_POST['remove']))
						   { 
						   $uid= $_GET['id'];
						    $s= checksem();
							 $code= $_POST['co'];
							 $y       = date('Y');
							  $subid= $_POST['subid'];
						   mysqli_query($conn,"delete from teacher_student where subject_id='$subid' and uid=$uid and year='$y' and semester='$s'" )or die(mysqli_error($conn));
						   mysqli_query($conn,"delete from results where course_code='$code' and uid='$uid' and year=$y and sem=$s" ) or die(mysqli_error($conn));
                           mysqli_query($conn,"delete from courseenrollments where coursecode='$code' and studentid='$username'" ) or die(mysqli_error($conn));
						   }
				
?>
<body >

    <?php include('navbar.php'); ?>

    <div class="container">
        <div class="row-fluid">
            <div class="span3" style="width:11%;visibility:hidden;" >
                <div class="hero-unit-3" >
                 
                </div>
                </div>
                             <div class="span9" style="width:98%; margin-top:-50px;">
                             <a href="student.php" class="btn btn-success"><i class="icon-arrow-left icon-large"></i>&nbsp;Back</a>
                             <p>
                <div class="hero-unit-3">
                
                <?php     
				
				
				           if(isset( $_GET['id'])){
							   $id=$_GET['id'];
							   updyearandsem($id);
						   }
						   
						     //repeat();
                            $student = $_GET['id'];
							 //repeat($student);
							 $sem= checksem();
							 $year       = date('Y');
                             $student_subject = mysqli_query($conn,"select * from teacher_student where uid='$student' and year='$year' and semester='$sem'") or die(mysqli_error($conn));
							if(mysqli_num_rows($student_subject)>0){ ?>
 <div class="alert alert-danger">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
 Course list
    
 <table border="1" width="100%">
 
 <tr bgcolor="#999999">
                            <th>No</th><th>Course code</th><th>Course title</th><th>Teacher</th> <th>Department</th><th>Action</th></tr>
                            <?php
							$i=1;
                           while($subject_details = mysqli_fetch_array($student_subject)){
						   $teacher_id=$subject_details['teacher_id'];
						   $subject_id=$subject_details['subject_id'];
						    $repeated=$subject_details['being_repeated'];
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
                            <td align="center"><?php echo $i ?></td><td><?php echo  $subcode;  ?></td><td><?php  echo $subtitle;if($repeated==1) echo"[<font color='red'>CarryOver</font>]" ?></td><td><?php if($teacher_details) echo $teacher_details['lastname'] ?></td><td><?php echo $depts['department']; ?>                             </td><td width="40">
                          <?php if(($l==9) or ($l==2) or  ($repeated==0)){?>
						  
                          <form method="post" action="">
						   <input type="hidden" value="<?php  echo     $subcode ?>" name="co" >
                           
                              <input type="hidden" value="<?php  echo  $subject_id ?>" name="subid" >
                            <button type="submit" name="remove" class="btn btn-danger" title="Remove"><i class="icon-trash icon-large"></i></button>
                             </form>
                            <?php  }?>
                            </td></tr>
                            <?php
							$i++;
                            }
                           ?> 
                           </table>
                          
                         
                           </div>
                           <?php
						   }
						    $did=$_GET['id'];
						   $se=mysqli_query($conn,"select * from student where id='$did'");
						   $n=mysqli_fetch_array( $se);
                            ?>                        
               
                
                    <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
                        <div class="alert alert-info">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong><i class="icon-user icon-large"></i>&nbsp;Add Courses for &nbsp <span style="text-decoration:blink"><?php echo $n['firstname']."&nbsp;".$n['lastname']?>&nbsp;&nbsp; Year:<?php echo $n['stud_current_year']?>&nbsp;&nbsp; Sem:<?php echo $n['current_sem'];?></span>
                        </div>
                        <thead>
                            <tr>

                                <th width="100" >Course code</th>
                                <th>Course title</th>
                                <th>Current teacher</th>
                                 <th>Department</th>
                                  <th>Offered Year</th>
                                   <th>Offered Sem</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
							 $id = $_GET['id'];
							  $ln = $_GET['ln'];
							   $fn = $_GET['fn'];
                               $username=$_GET['uname'];
							$coursno = mysqli_query($conn,"select * from maxcourse_no") or die(mysqli_error($conn));
                            $no = mysqli_fetch_array($coursno);
                            if($no)
							$max=$no['max_No'];
							$selec=mysqli_query($conn,"select * from student where id='$id' and category='1'");
							if(mysqli_num_rows($selec)==0)								  
                            $query = mysqli_query($conn,"select * from subject where category='0'") or die(mysqli_error($conn));
							else
							$query = mysqli_query($conn,"select * from subject where category='1'") or die(mysqli_error($conn));
                            while ($row = mysqli_fetch_array($query)) {
                                $subject_id = $row['subject_id'];
								$dept=$row['Dept'];
								$teacher=$row['teacher_id'];
						        $query_dept = mysqli_query($conn,"select * from department where dep_id='$dept'") or die(mysqli_error($conn));
                                $dep = mysqli_fetch_array($query_dept);
								$query_teacher = mysqli_query($conn,"select * from teacher where teacher_id='$teacher'") or die(mysqli_error($conn));
                                $current_teacher = mysqli_fetch_array($query_teacher);
								//$disp = mysqli_query($conn,"select * from teacher_student where uid='$id' and subject_id='$subject_id'") or die(mysqli_error($conn));
                                ?>

                                   <!-- script -->
                                    <script type="text/javascript">
                                        $(document).ready(function(){
                                                
                                            $('#a<?php echo $subject_id; ?>').tooltip('show')
                                            $('#a<?php echo $subject_id; ?>').tooltip('hide')
                                        });
                                    </script>
                                    <!-- end script -->

                                 
                                <tr class="odd gradeX" id="x">
                                    <td width="50"><?php echo $row['subject_code']; ?></td>
                                    <td><?php echo $row['subject_title'] ?></td> 
                                     <td><?php if ($current_teacher) echo $current_teacher['lastname']." ".$current_teacher['firstname']; ?></td>
                                     <td><?php echo $dep['department']; ?></td>
                                       <td><?php echo $row['offered_year']; ?></td>
                                        <td><?php echo $row['offered_sem']; ?></td>
                                    <td>
                                   
                 <a rel="tooltip" title="Add Course" id="a<?php echo $subject_id; ?>" href="#subject_id<?php echo $subject_id; ?>" role="button"  data-toggle="modal" class="btn btn-info"><i class="icon-plus-sign-alt icon-large"></i></a>
                          
                                    </td>
                                    <!-- user delete modal -->
                            <div id="subject_id<?php echo $subject_id; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-header">
                                </div>
                                <div class="modal-body">
                                    <div class="alert alert-info">Are you Sure you Want to <strong>Add</strong>&nbsp;<?php echo $row['subject_title']; ?>?</div>
                                </div>
                                <div class="modal-footer">
                                    <form method="POST" action="">
                                      <input type="hidden" name="teacher_id" value="<?php echo $teacher; ?>">
                                      
                                        <input type="hidden" name="sub" value="<?php echo $row['subject_title'];?>">
                                        <input type="hidden" name="sub_id" value="<?php echo $row['subject_id'];?>">
										<input type="hidden" name="subcode" value="<?php echo $row['subject_code'];?>">
                                       <button class="btn" data-dismiss="modal" aria-hidden="true"><i class="icon-remove icon-large"></i>&nbsp;Close</button>
                                        <button name="save1"  class="btn btn-info"><i class="icon-plus icon-large"></i>&nbsp;Add</button>
                                    </form>
                                </div>
                            </div>
                            <!-- end delete modal -->

                            </tr>
                        <?php } ?>
                        <?php
                        if (isset($_POST['save1'])) {
                            $teacher_id = $_POST['teacher_id'];
                            $student = $_GET['id'];
                     		$year       = date('Y');
							$sub        = $_POST['sub'];
							$subcode        = $_POST['subcode'];
							$subject=   $_POST['sub_id'];
    
							$sem= checksem();
							//$pay = mysqli_query($conn,"select * from student_fees where id='$id' and year='$year' and sem='$sem'") or die(mysqli_error($conn));
										  
										  //$s=mysqli_num_rows($pay);	
                            $sel=mysqli_query($conn,"select* from subject where subject_id='$subject'") or die(mysqli_error($conn));
$fetc=mysqli_fetch_array($sel);


                            $number_query = mysqli_query($conn,"select * from teacher_student where uid='$student' and semester='$sem' and year='$year'") or die(mysqli_error($conn));
                            $total = mysqli_fetch_array($number_query);
                            $count = mysqli_num_rows($number_query);
                          if ($count == $max) {
                                ?>
                                <div class="alert alert-danger">
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                    Student has reached maxmum number of subjects per semester
                                </div>
                                <?php
                            } else { 
							
							$subj = mysqli_query($conn,"select * from teacher_student where uid='$student' and  subject_id='$subject' and year='$year' and semester='$sem'") or die(mysqli_error($conn));
                                 $total = mysqli_num_rows($subj);
								  if ($total > 0) {
                                ?>
                                <div class="alert alert-danger">
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                    <font color="green"><?php echo $fetc['subject_title'] ;?></font> &nbsp;already assigned
                                </div>
                                <?php
                            } /*else {
							    if($s==0)
								{
								?>
                                <div class="alert alert-danger">
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                    <font color="green"><?php echo "Cannot add &nbsp;".$fetc['subject_title'] ;?></font> &nbsp;No Installment is made
                                </div>
                                <?php		
								}*/
								else
								{
                                mysqli_query($conn,"insert into teacher_student(teacher_id,uid,year,semester,subject_id) values('$teacher_id','$student','$year','$sem','$subject')") or die(mysqli_error($conn));
								//mysqli_query($conn,"insert into results(firstname,surname,uid,sem,year,course_code) values ('$fn','$ln' ,'$student','$sem', '$year','$subcode')") or die(mysqli_error($conn));
                                $subject_title=$fetc['subject_title'];
                                mysqli_query($conn,"insert into courseenrollments(coursecode,studentid,coursename) values('$subcode','$username','$subject_title')") or die(mysqli_error($conn));
                               ?>
                               <div class="alert alert-danger">
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                     <font color="green"><?php echo $fetc['subject_title'] ;?></font> &nbsp;assigned
                                </div>
                                <?php
								//}
							  //header('location:student.php');
                            }
                        }
						}
                        ?>


                        </tbody>
                    </table>
                </div>




            </div>
        </div>
        <?php include('footer.php'); ?>
    </div>
</div>
</div>
</body>
</html>


