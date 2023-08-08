<?php include('header.php'); ?>
<?php include('session.php'); ?>
<?php include('functions.php'); ?>
<body>

    <div class="row-fluid">
        <div class="span12">

            <?php include('navbar.php'); ?>

            <div class="container">

                <div class="row-fluid">

                    <div class="span12" style="margin-top: 50px;">
                    <p>
                         <a href="student.php" class="btn btn-success"><i class="icon-arrow-left icon-large"></i>&nbsp;Back</a>
                         <a href="uploade_students.php" class="btn btn-success"><i class="icon-upload-alt icon-large"></i>&nbsp;Upload student details(Undergraduate)</a>
                           </p>
                        <div class="hero-unit-3">
                           
                            <form class="form-horizontal" method="POST" enctype="multipart/form-data">
                                
                                <div class="alert alert-info" style="width:78%; margin-left:15%">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    Student addmission form for&nbsp;<b><?php echo date('Y');?>&nbsp;<?php if(checksem()==1) echo "Jan-June"; else echo "July-Dec"?>&nbsp;Sem </b>&nbsp;please fill in details  </div>                   <div class="control-group">
                                    <label class="control-label" for="inputEmail"> </label>
                                    <div class="controls">
                                        <input type="text" name="reg" id="inputEmail" placeholder="Registration number" required>
                                    </div>
                                </div>
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
                                        <input type="text" name="midd" id="inputEmail" placeholder="middle name" requi>
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
                                        
                                    <div style="float:left; position: absolute; margin-left:350px; margin-top:-359px;">
                                
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
                                        <input type="text" name="email" id="inputEmail" placeholder="student Email">
                                    </div>
                                </div>
                                
                                <div class="control-group">
                                    <label class="control-label"  for="p"></label>
                                    <div class="controls">
                               
                                 <select  name="nation"  id="inputEmail" required>
                                            <option value="">Select nation </option>
                                            
                                           <option>Malawi</option>
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
                                        <select name="join"  id="inputEmail" required>
                                            <option value="">Entry year </option>
                                            <option value="1">One</option>
                                            <option value="2">Two</option>
                                            <option value="3">Three</option>
                                            <option value="4">Four</option>
                                            <option value="5">Five</option>
                                            </select>
                                    </div>
                                    </div> 
                                      <div class="control-group">
                                    <label class="control-label"  for="postal"></label>
                                    <div class="controls">
                                   
                                    <select name="entsem"  id="inputEmail" required>
                                            <option value="">Entery sem</option>
                                            <option value="1">January-June</option>
                                             <option value="2">July-December</option>
                                           
                                            </select>
                                            
                                        </div>
                                        </div> 
                                    <div class="control-group">
                                    <label class="control-label"  for="gadd">  </label>
                                    <div class="controls">
                                <input type="text" name="addm_year" placeholder="admissionyear"  required>
                                        </div>
                                        </div> 
                                        
                                
                                <div style="float:left; position: absolute; margin-left:350px; margin-top:-417px;">
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
                                            <option value="2">Distance</option>
                                            <option value="3">Masters(BIU Undergraduate) </option>
                                            <option value="4">Masters(Non BIU) </option>
                                            
                                            </select>
                                        </div>
                                        </div>  
                                        <div class="control-group">
                                    <label class="control-label"  for="study"></label>
                                    <div class="controls">
                                <select name="cyear"  id="inputEmail" required>
                                            <option value="">Current year</option>
                                            <option value="1">First</option>
                                            <option value="2">Second</option>
                                            <option value="3">Third</option>
                                            <option value="4">Fourth</option>
                                    
                                          
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
								$join = clean($conn,$_POST['join']);
                                $midd = clean($conn,$_POST['midd']);
								$stadd = clean($conn,$_POST['stud_add']);
								$town = clean($conn,$_POST['town']);
								$gender = clean($conn,$_POST['gender']);
                                $fn = clean($conn,$_POST['fn']);
                                $ln = clean($conn,$_POST['sname']);
                                $sem = checksem();
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
								$stu_id=clean($conn,$_POST['reg']);
								//$csem=clean($conn,$_POST['csem']);
								$year= date('Y');
								//$s=checksem();
								$ensem=$_POST['entsem'];
								
								
								$cyear=clean($conn,$_POST['cyear']);
								$addm_year=clean($conn,$_POST['addm_year']);
								$qualif=clean($conn,$_POST['qualif']);
								$username=clean($conn,$_POST['reg']);
								$z=mysqli_query($conn,"select * from course where course_id='$prog'");
								$mydep=mysqli_fetch_array($z);
								$dp=$mydep['department'];
								 if($ensem==$sem) $upd=$year; else $upd=$addm_year;
								 if($sem==$ensem) $csem=1;else $csem=2;
								 if($mode==3 or $mode==4) $cat=1;else $cat=0;
								$p=mysqli_query($conn,"select * from student where student_id='$stu_id' or id='$phone'") or die(mysqli_error($conn));;
                                if( mysqli_num_rows($p)==0){
                                mysqli_query($conn,"insert into student (id,firstname,lastname,cys,middle_name,student_id,stud_email,birth_date,stud_address,gender,sponsor,stud_pnone,spo_email,mode,town,nation,sp_relation,sem,sp_address,spo_phone,joined_in,stud_current_year,dept,qualif,addm_year,update_year,current_sem,system_sem,category)
values ('$phone','$fn','$ln','$prog','$midd','$stu_id','$email','$db','$stadd','$gender','$spo','$phone','$spomail','$mode','$town','$nation','$rel','$ensem','$spoadd',
'$spophone','$join','$cyear','$dp','$qualif','$addm_year','$upd','$csem','$ensem','$cat')                                    
") or die(mysqli_error($conn));
                               
							   ?>
                               
                              <div class="alert alert-info">student details added<?php echo $sem."<>".$ensem  ?></div>
                                <?php
								}
								
								else
								{
								?>
								<div class="alert alert-danger"><i class="icon-remove-sign"></i>Student ID or phone already exist</div>
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


