<?php include('session.php'); ?>
<?php include('header.php'); ?>
<?php include('functions.php'); ?>
<?php include('mdl_connect.php'); ?>
<body>

    <div class="row-fluid">
        <div class="span12">

            <?php include('navbar.php'); ?>

            <div class="container">

                <div class="row-fluid">

                    <div class="span12" style="margin-top: 50px;">
                    <p>
                         <a href="student.php" class="btn btn-success"><i class="icon-arrow-left icon-large"></i>&nbsp;Back</a>
                         <a href="uploade_students.php" class="btn btn-success"><i class="icon-upload-alt icon-large"></i>&nbsp;Upload student details(undergraduate)</a>
                           </p>
                        <div class="hero-unit-3">
                           
                            <form class="form-horizontal" method="POST" enctype="multipart/form-data">
                               
                                <div class="alert alert-info" style="width:78%; margin-left:15%">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                  <b> New Student</b> addmission form for&nbsp;<b><?php echo date('Y');?>&nbsp;<?php if(checksem()==1) echo "Jan-June"; else echo "July-Dec"?>&nbsp;Sem </b>&nbsp;please fill in details  </div>
                                   
                                <div class="control-group">
                                    <label class="control-label" for="inputPassword"></label>
                                    <div class="controls">
                                        <input type="text" name="sname" id="inputPassword" placeholder="surname" required>
                                    </div>
                                </div>
                                
                                <div class="control-group">
                                    <label class="control-label" for="inputEmail"></label>
                                    <div class="controls">
                                        <input type="text" name="db" id="inputEmail" placeholder="birth date-day/month/year" required>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="title"></label>
                                    <div class="controls">
                                        <input type="text" name="midd" id="inputEmail" placeholder="middle name">
                                    </div>
                                </div>
                                 <div class="control-group">
                                    <label class="control-label"  for="postal"></label>
                                    <div class="controls">
                                <input type="text" name="stud_add" placeholder="student address" required>
                                        </div>
                                        </div>
                                        
                                      <div class="control-group">
                                    <label class="control-label"  for="postal"></label>
                                    <div class="controls">
                                <input type="text" name="town" placeholder="student City/Town/district" required>
                                        </div>
                                        </div>  
                                        <div class="control-group">
                                    <label class="control-label"  for="postal"></label>
                                    <div class="controls">
                                   
                                    <select name="qualif"  id="inputEmail" required>
                                            <option value="">Entry Qualification</option>
                                            <?php
											$q=mysqli_query($conn,"select * from qualification");
											while($r=mysqli_fetch_array($q))
											{
											?>
                                            <option><?Php  echo $r['q']  ?></option>
                                            
                                            <?php
											}
											
											?>
                                            </select>
                                            
                                            
                                        </div>
                                        </div>
                                            
                                       
                                    <div style="float:left; position: absolute; margin-left:350px; margin-top:-305px;">
                                
                                  <div class="control-group">
                                    <label class="control-label" for="fn"></label>
                                    <div class="controls">
                                        <input type="text" name="fn" id="inputEmail" placeholder="Firstname" required>
                                      </div>
                                </div>   
                                <div class="control-group">
                                    <label class="control-label" for="g"></label>
                                    <div class="controls">
                                        <select name="gender"  id="inputEmail" required>
                                            <option value=""> Select gender </option>
                                            <option>Male</option>
                                            <option>Female</option>
                                            </select>
                                    </div>
                                </div>  
                                <div class="control-group">
                                    <label class="control-label"  for="cp"></label>
                                    <div class="controls">
                                <input type="number" name="phone" placeholder="student Phone" required>
                                        </div>
                                        </div>                       
                                
                                <div class="control-group">
                                    <label class="control-label" for="email"></label>
                                    <div class="controls">
                                        <input type="email" name="email" id="inputEmail" placeholder="student Email" >
                                    </div>
                                </div>
                                
                                <div class="control-group">
                                    <label class="control-label"  for="p"></label>
                                    <div class="controls">
                               
                                 <select  name="nation"  id="inputEmail" required>
                                            <option value="">Select nation </option>
                                            
                                           <option value="MW">Malawi</option>
                                           <option>Zambia</option>
                                           <option>Mocambique</option>
                                           <option>Tanzania</option>
                                           <option>Uganda</option>
                                           <option>South Africa</option>
                                           <option>Zimbabwe</option>
                                           <option>DRC</option>
                                           <option>Dutch</option>
                                           <option>Kenya</option>
                                           <option>Nigeria</option>
                                           <option>Zaire</option>
                                           <option>Namibia</option>
                                           <option>Afghanistan</option>
                                           <option>Tunisia</option>
                                          <option>Algeria</option>
                                           <option>Burundi</option>
                                           <option>Macedonia</option>
                                            <option>Madagascar</option>
                                            <option>Botswana </option>
                                            <option>Malaysia </option>
                                            <option >Angola</option>
                                            <option>Mali</option>
                                            <option>UK</option>
                                             <option>America</option>
                                              <option>Britain</option>
                                            <option >Marocco</option>
                                            <option>Swazland</option>
                                             <option>Jamica</option>
                                             <option>Japan</option>
                                            <option >Mauritias</option>
                                            <option >Other(edit after add to specify)</option>
                                            </select>
                                        </div>
                                        </div>
                                       
                                        <div class="control-group">
                                    <label class="control-label" for="g"></label>
                                    <div class="controls">
                                       <select name="enter" required>
                                            <option value="">Year Of Entry </option>
                                            <option value="1">One</option>
                                            <option value="2">Two</option>
                                            <option value="3">Three</option>
                                            <option value="4">Four</option>
                                            <option value="5">Five</option>
                                            </select>
                                    </div>
                                    </div> 
                                   
                                
                                <div style="float:left; position: absolute; margin-left:350px; margin-top:-320px;">
                                <div class="control-group">
                                    <label class="control-label" for="input01"></label>
                                    <div class="controls">
                                     <input type="text" name="gardian" id="inputEmail" placeholder="Sponsor name" >       
                                    </div>
                                </div> 
                                   <div class="control-group">
                                    <label class="control-label"  for="gadd">  </label>
                                    <div class="controls">
                                <input type="text" name="s_add" placeholder="Sponsor address" >
                                        </div>
                                        </div>
                              
                                <div class="control-group">
                                    <label class="control-label"  for="gphone"></label>
                                    <div class="controls">
                                <input type="number" name="sphone" placeholder="Sponsor phone" >
                                        </div>
                                        </div> 
                                        <div class="control-group">
                                    <label class="control-label"  for="smail"></label>
                                    <div class="controls">
                                <input type="email" name="s_mail" placeholder="sponsor email" >
                                        </div>
                                        </div>                        
                                <div class="control-group">
                                    <label class="control-label"  for="relation"></label>
                                    <div class="controls">
                                <input type="text" name="relation" placeholder="sponsor relationship to student" >
                                        </div>
                                        </div>
                                
                                        <div class="control-group">
                                    <label class="control-label" for="program"></label>
                                    <div class="controls">

                                        <select name="prog"  required>
                                            <option value="">select program </option>
                                            <?php
                                            $query = mysqli_query($conn,"select * from course");
                                            while ($row = mysqli_fetch_array($query)) {
                                                ?>
                                                <option value="<?php echo $row['course_id']; ?>"><?php echo $row['cys']; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                 <div class="control-group">
                                    <label class="control-label"  for="study"></label>
                                    <div class="controls">
                                <select name="mode"  id="inputEmail" required>
                                            <option value="">mode-please select </option>
                                            <option value="1">Full time</option>
                                            <option value="2">Week-End</option>
                                            <option value="3">Diploma</option>
                                            <option value="4">Masters </option>
                                            </select>
                                        </div>
                                        </div>  
                                                            
                                </div>                    
                                </div>
                                <div class="control-group">
                                    <div class="controls">
                                    
                                        <button type="submit" name="submit" class="btn btn-info"><i class="icon-save icon-large"></i>&nbsp;Save</button>
                                    </div>
                                </div>
                            </form>
                            <?php
                            if (isset($_POST['submit'])) {
                                $db = clean($conn,$_POST['db']);
								$enteryear = clean($conn,$_POST['enter']);
                                $midd = clean($conn,$_POST['midd']);
								$stadd = clean($conn,$_POST['stud_add']);
								$town = clean($conn,$_POST['town']);
								$gender = clean($conn,$_POST['gender']);
                                $fn = clean($conn,$_POST['fn']);
                                $ln = clean($conn,$_POST['sname']);
                                //$sem = checksem();
								$phone = clean($conn,$_POST['phone']);
								$email = clean($conn,$_POST['email']);
								$nation = clean($conn,$_POST['nation']);
								$mode = clean($conn,$_POST['mode']);
								$spo = clean($conn,$_POST['gardian']);
								$spoadd = clean($conn,$_POST['s_add']);
								$spophone = clean($conn,$_POST['sphone']);
								$spomail = clean($conn,$_POST['s_mail']);
								$rel =clean($conn, $_POST['relation']);
								$prog = clean($conn,$_POST['prog']);
                                $password = "Biu2000";
								//$stu_id=clean($conn,$_POST['reg']);
								//$systemsem= checksem();
								$year= date('Y');
								$s=checksem();
								//$cyear=clean($conn,$_POST['cyear']);
								$addm_year = $year;
								$qualif=clean($conn,$_POST['qualif']);
								
								$z=mysqli_query($conn,"select * from course where course_id='$prog'");
								$mydep=mysqli_fetch_array($z);
								$dp=$mydep['department'];
								
								$r=mysqli_query($conn,"select * from student where addm_year='$year' and system_sem='$s' ") or die(mysqli_error($conn));	
								$count=mysqli_num_rows($r);
								//echo $count;
								if($count==0){$num=1;}else {$num=$count+1;}
								if($num<10) $new="00".$num;elseif($num<100) $new="0".$num; else $new=$num;
								if(($mode==1) || ($mode==2)){
								$new_reg= $year."/".$s."/".$new;
                                
								}
								else
								{
								$new_reg= "MA".$year."/".$s."/".$new;
								}
								if($mode==3 or $mode==4) $cat=1;else $cat=0;
                                $mdl_username= $year.$s.$new;
                                $pass= md5($password);
								$p=mysqli_query($conn,"select * from student where student_id='$new_reg'  or stud_pnone='$phone'") or die(mysqli_error($conn));
                                if( mysqli_num_rows($p)==0){
                                mysqli_query($conn,"insert into student (id,username,password,firstname,lastname,cys,middle_name,student_id,
                                stud_email,birth_date,stud_address,gender,sponsor,stud_pnone,spo_email,mode,town,nation,sp_relation,
                                sp_address,spo_phone,joined_in,stud_current_year,dept,qualif,addm_year,update_year,current_sem,
                                system_sem,category)
values ('$mdl_username','$mdl_username','$pass','$fn','$ln','$prog','$midd','$new_reg','$email',
'$db','$stadd','$gender','$spo','$phone','$spomail','$mode','$town','$nation','$rel','$spoadd',
'$spophone','$enteryear','$enteryear','$dp','$qualif','$addm_year','$year',1,'$s','$cat')                                    
") or die(mysqli_error($conn));
//inserting in moodle db

//end moodle
                               
							   ?>
                               
                              <div class="alert alert-info">student details added:<br> Reg Number:<?php  echo 	$new_reg ?><br>Username:
							  <?php  echo 	$mdl_username ?><br>Default Password: Biu2000
							  </div>
                                <?php
								}
								
								else
								{
									$d=mysqli_fetch_array($p);
									$pn=$d['stud_pnone'];
									
									$sid=$d['student_id'];
								    $na=$d['firstname'];
								?>
								<div class="alert alert-danger"><i class="icon-remove-sign"></i>Student already exist: RegNo<?php  echo 	$sid?> Phone:<?php  echo 	$pn?>,Name:<?php  echo 	$na?></div>
                                <?php
								}
							  
                            }
                            ?>


                        </div>

                    </div>
                </div>
               
<?php include('footer.php'); ?>
            </div>
        </div>
    </div>





</body>
</html>


