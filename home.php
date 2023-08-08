<?php
include('session.php');
include('header.php');  
include('functions.php'); 
$year=date('Y');
$sem=checksem();
$se=mysqli_query($conn,"select * from expenses where year='$year' and exp_sem='$sem' and approved='0'") or die("here".mysqli_error($conn));
$subs=mysqli_query($conn,"select * from course") or die("here".mysqli_error($conn));
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
                        <li class="active">
                            <a href="home.php"><i class="icon-home icon-large"></i>&nbsp;Home
                                <div class="pull-right">
                                    <i class="icon-double-angle-right icon-sm"></i>
                                </div>  
                            </a>

                        </li>
                        <li class="dropdown">
                        
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-list-alt icon-large"></i>&nbsp;Reports
                             
                                <div class="pull-right">
                                    <i class="icon-double-angle-right icon-sm"></i>
                                </div>  
                            </a>
                            <ul class="dropdown-menu" style="margin-left:103%; margin-top:-15%;">
                             <li><?php if(($l==1)or ($l==2)or($l==9) or ($l==3)) {?><a href="reports.php">Exam</a>   </li>
<?php  } else {?>
 <li><a href="#" onClick="alert('ACCESS DENIED')">Exam</a>   </li>
                            <?php }?>
 <li><?php if(($l==1)or ($l==2)or($l==9) or ($l==3)) {?><a href="ts.php">Teacher-subjects</a>   </li>
<?php  } else {?>
 <li><a href="#" onClick="alert('ACCESS DENIED')">Teacher-subjects</a>   </li>
                            <?php }?>
                             <li><?php if(($l==1)or ($l==2)or($l==9)){?><a href="financials.php">Financial</a></li>
<?php  } else {?>
 <li><a href="#" onClick="alert('ACCESS DENIED')">Financials</a>   </li>
                            <?php }?>
                              <li><a href="studentrepo.php">Students</a></li>
                              <li><?php if(($l==1)or ($l==2)or($l==9)) {?><a href="exp.php">Expenditure</a></li>
                               <?php  } else {?>
 <li><a href="#" onClick="alert('ACCESS DENIED')">Expenditure</a>   </li>
                            <?php }?>
                               <li><?php if(($l==1)or ($l==2)or($l==9) or($l==8)or ($l==10)or ($l==7) or($l==6)){?><a href="feez.php">Fees</a></li>
<?php  } else {?>
 <li><a href="#" onClick="alert('ACCESS DENIED')">Fees</a></li>
                            <?php }?>
                            </ul>
                            
                            </li>                                                      
                              <li>
                              <?php if(($l==1)or($l==2) or($l==9))  {?>
                            <a href="settings.php"><i class="icon-group icon-large"></i>&nbsp;Settings
                            <?php } else{?>
                            <a href="#" onClick="alert('ACCESS DENIED')"><i class="icon-group icon-large"></i>&nbsp;Settings
                            <?php }?>
                                <div class="pull-right">
                                    <i class="icon-double-angle-right icon-sm"></i>
                                </div>  
                            </a></li>
<li class="dropdown">
                        <?php if(($l==1) or ($l==2)or ($l==6)or ($l==9)or ($l==7)) {?>
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
                             <?php if(($l==1) or ($l==2) or ($l==9)) {?>
                            <a href="results.php"><i class="icon-group icon-large"></i>&nbsp;Student results
                             <?php } else{?>
                            <a href="#" onClick="alert('ACCESS DENIED')"><i class="icon-group icon-large"></i>&nbsp;Student results
                            <?php }?>
                                <div class="pull-right">
                                    <i class="icon-double-angle-right icon-sm"></i>
                                </div>  
                            </a></li>
 <li>
                              
                            <a href="timetable.php"><i class="icon-calendar icon-large"></i>&nbsp;Generate Timetable
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
                                       <li class="dropdown">
                        <?php if(($l==1) or ($l==2)or ($l==6)or ($l==9)or ($l==7)) {?>
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-book icon-large"></i>&nbsp;Genarate Transcripts
                             <?php } else{?>
                            <a href="#" onClick="alert('ACCESS DENIED')"><i class="icon-book icon-large"></i>&nbsp;Genarate Transcripts
                            <?php }?>
                                <div class="pull-right">
                                    <i class="icon-double-angle-right icon-sm"></i>
                                </div>  
                            </a>
                            <ul class="dropdown-menu" style="margin-left:103%; margin-top:-15%;">
                            
							<li><a href="transcript.php">Undergraduate</a></li>
                            <li><a href="transcript_masters.php">Masters</a></li>
							
							 
                             
                            </ul>
                            
                            </li>                
                           <li>
							<?php if(($l==1)  or ($l==3)or ($l==4) or ($l==9)) {?>
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
                    <div class="span12" style="border:1px; width:78%; margin-left:22%; margin-top:-410px;">
                        <!--slider-->
                         <?php 
				if((mysqli_num_rows($se)>0) &&($l==1)){
				?>
                <div class="hero-unit-3"> 
                     
                    <div class="alert alert-info">
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                    <strong><i class="icon-user icon-large"></i>&nbsp;You have a lists of expenditure request waiting approval</strong>
                                </div>                    
          <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example" >
                    
                                        
                                                
                                 <thead>
                                 <tr>

                               <th>Item</th>
                              <th>Amount(MWK)</th>
                              <th>Description</th>
                              <th>Requested Date</th>
                               <th>Year</th>
                                <th >Sem</th>
                                <th>Action</th>                                          
                   </tr>
                    </thead>
                        <tbody>   
                           <!-- end script -->
                          
                            <?php include('exp_request.php');
							
							
							
							 ?>
                       <?php
							  if(isset($_SESSION['ERR'])){?>
							<div class="alert alert-danger"> <?php echo $_SESSION['ERR']; unset($_SESSION['ERR']);?></a>
                                            <a  onclick='$(".alert").hide();' href="javascript:void(0);" style="margin-left:100%">x</a>
							<?php
							}
							
							 ?>
                           
							 
							 
                          
                          
                            
                        </tbody>
                  </table>
                 
                    <!-- end slider -->
                </div>
                <?php
				
				}
			 ?>
            </div>
                        
                             
                </div>
                
                <?php  include('footer.php'); ?>
            </div>

        </div>
    </div>
<?php ?>
</body>
</html>