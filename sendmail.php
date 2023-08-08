<?php include('header.php'); ?>
<?php include('session.php'); ?>
<?php include('functions.php');
$subs=mysqli_query($conn,"select * from course") or die("here".mysqli_error($conn)); 
if(isset($_POST['send'])){
$user_id=$_POST['sid'];
$smail=$_POST['smail'];
$y=date('Y');
$s=checksem();
$dd = mysqli_query($conn,"select * from results where uid='$user_id' and sem='$s' and year='$y'") or die("here".mysqli_error($conn));
$d=mysqli_fetch_array($dd);
						   //$sel=mysqli_query($conn,"select * from student where id='$uid') or die(mysqli_error($conn));
						   //$detail=mysqli_fetch_array()
							$fname=$d['firstname'];
							$lname=$d['surname'];
							$sid=$d['student_id'];
							$cyear=$d['stud_year'];
							$csem=$d['studsem'];
							$years=$d['year'];
							$i=1;$m='#FFFFFF';
							if($s==1) $ss="January-June";else $ss="July-December";
							$message = "<center><img  src='img/log.png'></center>";
$message.="<font color='#0099FF'><center>BLANTYRE INTERNATIONAL UNIVERSITY</font><br> \nExam Results for $lname $fname \n</center>";
$message .="YEAR: $y\n 
ACADEMIC SEMESTER:$ss\n
STUDENT YEAR: $cyear\n
STUDENT SEMESTER:$csem\n";
$message .="<table border='0' align='center'> <tr bgcolor='#00CCFF' style='color:#ffffff'> <th>No</th><th>Subject Code</th><th> Subject Title</th><th>Assignment1</th><th>Assignment2</th><th>Exam</th><th>Final Grade</th><th>Remarks</th></tr>";
 $students = mysqli_query($conn,"select * from results where uid='$user_id' and year='$y' and sem='$s' ") or die( "error".mysqli_error($conn));
 while($row=mysqli_fetch_array($students)){
 if($i%2==0)$m='#DDD';else $m='#FFFFFF';
 $code=$row['course_code'];
$selec=mysqli_query($conn,"select* from subject where subject_code='$code'") or die(mysqli_error($conn));
$subdetails=mysqli_fetch_array($selec);
$subt=$subdetails['subject_title'];
$ass1=$row['assign_1'];
$ass2=$row['assign_2'];
$eos=$row['EOS'];
$fgrade=$row['fgrade'];
$com=$row['comment'];
$message .="<tr bgcolor='$m' align='center'>
<td>$i</td><td>$code</td><td>$subt </td><td>$ass1</td><td>$ass2</td><td>$eos</td><td>$fgrade</td><td>$com</td></tr>";
$i++;
}
$message .="</table>\n";
mysqli_query($conn,"update results set email_sent='1' where year='$y' and sem='$s' and uid='$user_id'")or die("errs".mysqli_error($conn));
$sels=mysqli_query($conn,"select * from teacher_student where uid='$user_id' and year='$y' and semester='$s'")  or die("errs".mysqli_error($conn));
$regcount=mysqli_num_rows($sels);
$sels2=mysqli_query($conn,"select * from results where uid='$user_id' and year='$y' and sem='$s'")  or die(mysqli_error($conn));
$didcount=mysqli_num_rows($sels2);
$sels2=mysqli_query($conn,"select * from results where uid='$user_id' and  year='$y' and sem='$s' and comment='F'")  or die(mysqli_error($conn));
$check=mysqli_num_rows($sels2);
if(($check>0)||($didcount<$regcount)) $res="FAILED"; else $res= "PASSED";
 if($didcount<$regcount) $all= "<font color='red'>Student did not do all registered subjects</font>\n"; else $all= "<font color='red'>Student did all registered subjects</font>\n";
$message .="<font color='#008000'><center>EXAM RESULTS:</font> <font color='red'>$res<br></font></center>\n";
$message .="<font color='#008000'><center>REMARKS:</font> <font color='red'>$all<br></font><center>\n";
$message.="\n<center> BIU ADMINISTRATION\n<br>_______________________________<br> THIS IS AN AUTOMATED RESPONSE.<br>***DO NOT RESPOND TO THIS EMAIL****<center>";
//$message=Results($user_id,$s,$y);

$headers ="MEMI-Version:1.0"."\r\n";
$headers .="Content-type:text/html;Charset=UTF-8"."\r\n";
$headers .="Content-type:text/html;Charset=UTF-8"."\r\n";
$headers .="From: BIU Student information Management System | Developed by Daniel Liwonde(liwonde.d@gmail.com)"."\r\n";
$checkmail=mail($smail,"EXAM RESULTS",$message,$headers);
if($checkmail==true)
$msg="Email sent to".$smail;
else
echo "Problem encountered sending email.Email not sent";
}
?>
<body onLoad="StartTimers();" onmousemove="ResetTimers();">
    <div class="row-fluid">
        <div class="span12">

            <?php include 'navbar.php'; ?>
            <div class="container">
            
                <div class="row-fluid">
                <div class="hero-unit-3" style="width:18.5%">
                    <div class="alert-index alert-success">
                        <i class="icon-calendar icon-large"></i>
                        <?php
                        $Today = date('y:m:d');
                        $new = date('l, F d, Y', strtotime($Today));
                        echo $new;
                        ?>
                    </div>
                </div>
                 <div class="hero-unit-1" style="width:20%">
                      <ul class="nav  nav-pills nav-stacked">
                        <li class="nav-header">Links</li>
                        <li>
                            <a href="home.php"><i class="icon-home icon-large"></i>&nbsp;Home
                                <div class="pull-right">
                                    <i class="icon-double-angle-right icon-sm"></i>
                                </div>  
                            </a>

                        </li>
                        <li class="dropdown">
                        <?php if(($l==1) or $l==2) {?>
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-list-alt icon-large"></i>&nbsp;Reports
                             <?php } else{?>
                            <a href="#" onClick="alert('ACCESS DENIED')"><i class="icon-list-alt icon-large"></i>&nbsp;Reports
                            <?php }?>
                                <div class="pull-right">
                                    <i class="icon-double-angle-right icon-sm"></i>
                                </div>  
                            </a>
                            <ul class="dropdown-menu" style="margin-left:103%; margin-top:-15%;">
                             <li> <a href="reports.php">Exam</a>   </li>
                             <li><a href="financials.php">Financial</a></li>
                              <li><a href="studentrepo.php">Students</a></li>
                              <li><a href="exp.php">Expenditure</a></li>
                               <li><a href="feez.php">Fees</a></li>
                            </ul>
                            
                            </li>                                                      
                              <li>
                              <?php if(($l==1) or $l==2) {?>
                            <a href="settings.php"><i class="icon-group icon-large"></i>&nbsp;Settings
                            <?php } else{?>
                            <a href="#" onClick="alert('ACCESS DENIED')"><i class="icon-group icon-large"></i>&nbsp;Settings
                            <?php }?>
                                <div class="pull-right">
                                    <i class="icon-double-angle-right icon-sm"></i>
                                </div>  
                            </a></li>
                            <li class="dropdown active">
                        <?php if($l==1 or $l==2 or $l==7 or $l==9) {?>
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-envelope-alt icon-large"></i>&nbsp;Email Results
                             <?php } else{?>
                            <a href="#" onClick="alert('ACCESS DENIED')"><i class="icon-envelope-alt icon-large"></i>&nbsp;Email Results
                            <?php }?>
                                <div class="pull-right">
                                    <i class="icon-double-angle-right icon-sm"></i>
                                </div>  
                            </a>
                            <ul class="dropdown-menu" style="margin-left:103%; margin-top:-15%;">
                            <?php     
							while($row=mysqli_fetch_array($subs)){ ?>
							<li><a href="sendmail.php?pid=<?php echo  $row['course_id']   ?>"><?php echo $row['cys']  ?></a></li>
							
							 <?php   }?>
                             
                            </ul>
                            
                            </li>     
                             
                            <li>
                            <?php if(($l==1) or ($l==2) or ($l==6)) {?>
                            <a href="results.php"><i class="icon-group icon-large"></i>&nbsp;Student results
                             <?php } else{?>
                            <a href="#" onClick="alert('ACCESS DENIED')"><i class="icon-group icon-large"></i>&nbsp;Student results
                            <?php }?>
                                <div class="pull-right">
                                    <i class="icon-double-angle-right icon-sm"></i>
                                </div>  
                            </a></li>
                            
 <li>
                            <a href="#a"  data-toggle="modal" ><i class="icon-group icon-large"></i>&nbsp;Update account 
                                <div class="pull-right">
                                    <i class="icon-double-angle-right icon-sm"></i>
                                </div>  
                            </a> </li>
                            <!-- user delete modal -->
                                    <div id="a" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-header">
                                        </div>
                                        <form class="form-horizontal" method="post">
                                        <div class="modal-body">
                                            <div class="alert alert-danger">Update password</div>
                                            
                                            
                                             
                                             <label> Password:<input type="text" name="pass" id="inputEmail"  value="<?php echo $us['password'] ?>" required></label>
                                             Confirm: &nbsp;&nbsp;<input type="text" name="pass2" id="inputEmail"  required>
                                            
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn" data-dismiss="modal" aria-hidden="true"><i class="icon-remove icon-large"></i>&nbsp;Close</button>
                                            <button type="submit" name="go" class="btn btn-info"><i class="icon-signin icon-large"></i>&nbsp;Update</button>
                                        </div>
                                    </div>
                                     </form>
                                    <!-- end delete modal --> 
                                     <?php include('update.php');  ?>
                                      <li> 
                                       <?php if(($l==1) or ($l==2) or ($l==6)) {?>
                            <a href="transcript.php"><i class="icon-book icon-large"></i></i>&nbsp;Genarate Transcripts
                             <?php } else{?>
                            <a href="#" onClick="alert('ACCESS DENIED')"><i class="icon-group icon-large"></i>&nbsp;Genarate Transcripts
                            <?php }?>
                                <div class="pull-right">
                                    <i class="icon-double-angle-right icon-sm"></i>
                                </div>  
                            </a></li>
                            <li>
                           
							<?php if(($l==1) or ($l==2) or ($l==3)or ($l==4)) {?>
                            <a href="../teacher_home.php"><i class="icon-group icon-large"></i>&nbsp;Enter Grades
                               <?php } else{?>
                            <a href="#" onClick="alert('ACCESS DENIED')"><i class="icon-group icon-large"></i>&nbsp;Enter Grades
                            <?php }?>
                                <div class="pull-right">
                                    <i class="icon-double-angle-right icon-sm"></i>
                                </div>  
                            </a></li>
                            
                    </ul>

                    </div>
                    <?php include"msg.php"?>
                    <div class="span12" style="border:1px; width:78%; margin-left:22%; margin-top:-423px;">
                    
                     
            
                <div class="hero-unit-3">
                <?php if(isset($msg)){?>
							
							<div class="alert alert-danger"><i class="icon-envelope-alt icon-large"></i>			
							<?php echo $msg;?></div>
                            <?php 
							}                           
                               ?> 
                                  
                                <form action="" method="post">                        
                              <div class="alert alert-info">
                        
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong><i class="icon-envelope-alt icon-large"></i>&nbsp;Send Exam Results Emails For</strong> <font color="#008000"><?php $mys=mysqli_query($conn,"select * from course where course_id ='$_GET[pid]'");$query=mysqli_fetch_array($mys);echo $query['cys'];    ?></font>    Students                  
                            </div> 
                           
                <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">    
          
           
              <thead>
                                    <tr>

                                        <th>StudentID</th>
                                        <th>Fistname</th>
                                        <th>Lastname</th>
                                        <th>Phone</th>
                                        <th>Email</th>
                                        <th>Gender</th>
                                        <th>Program</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
          
          <?php
									if(isset($_GET['pid'])){
									$q=$_GET['pid'];
									$year=date('Y');
									$sem=checksem();
                                    $query = mysqli_query($conn,"select * from student where cys='$q' and spo_email<>''") or die(mysqli_error($conn));
                                    while ($row = mysqli_fetch_array($query)) {
                                        $student_id = $row['student_id'];
										$id=$row['id'];
										$mymail=mysqli_query($conn,"select * from results where uid='$id' and year='$year' and sem='$sem' and email_sent='1'")or die(mysqli_error($conn));
										if(mysqli_num_rows($mymail)==0){
										
                                        ?>


                                       
                                     
                                     <!-- script -->
                                    <script type="text/javascript">
                                        $(document).ready(function(){
                                                
                                            $('#e<?php echo $id; ?>').tooltip('show')
                                            $('#e<?php echo $id; ?>').tooltip('hide')
											
                                        });
                                    </script>
                                    <!-- end script -->

                                    <tr class="odd gradeX">
                                        <td><?php echo $row['student_id']; ?></td>
                                        <td><?php echo $row['firstname'] ; ?></td> 
                                        <td><?php echo $row['lastname'] ; ?></td> 
                                          <td><?php echo $row['stud_pnone'] ?></td>
                                          <td><?php echo $row['spo_email']; ?></td> 
                                          <td><?php echo $row['gender']; ?></td> 
                                       
                                        <td><?php echo $q; ?></td> 
                     
                                        <td >
                                           <form action="" method="post">
                                            <input type="hidden" value="<?php echo $id    ?>" name="sid">
                                            <input type="hidden" value="<?php echo $row['spo_email'];    ?>" name="smail">
                                            <button type="submit" class="btn btn-success" name="send"><i class="icon-signin icon-large"></i>&nbsp;Send</button>
                                            </form>
                                          
                                        </td>
                                             
                                      
                                  
                                    </tr>
                                <?php }} }?>
                                </tbody>
                            </table>
                             
						
					
				   
				  
                    <!-- end slider -->
                   </div> 
                </div>
            </div>
                        
                             
                
                <?php  include('footer.php'); ?>
            </div>

        </div>
    </div>





</body>
</html>