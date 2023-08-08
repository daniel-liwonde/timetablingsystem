<?php include('header.php'); ?>
<?php include('session.php'); ?>
<?php include('functions.php'); ?>
<body>

    <div class="row-fluid">
        <div class="span12">

            <?php include('navbar.php'); ?>

            <div class="container">

                <div class="row-fluid">

                    <div class="span12">
                    <p>
                         <a href="student.php" class="btn btn-success"><i class="icon-arrow-left icon-large"></i>&nbsp;Back</a>
                           </p>
                        <div class="hero-unit-3">
                         <?php
						             $id=$_GET['id'];
									  $fn=$_GET['fn'];
									   $ln=$_GET['ln'];
									     $st=$_GET['st'];
                                    $query = mysqli_query($conn,"select * from student where id='$id'") or die(mysqli_error($conn));
                                    $row = mysqli_fetch_array($query);
                                        $student_id = $row['id'];
										
                                        ?>
                           
                            <form class="form-horizontal" method="POST" enctype="multipart/form-data">
                                <div class="control-group">
                                <div class="alert alert-info" style="width:95%;">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    Student addmission form for&nbsp;<b><?php echo date('Y');?> </b>&nbsp;Edit student information for <?php echo $fn." ".$ln; ?> </div>
                                    <label class="control-label" for="inputEmail">RegNumber </label>
                                    <div class="controls">
                                        <input type="text" name="reg" id="inputEmail" placeholder="Reg No"  value="<?php echo $st ?>"required title="Reg number">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="inputPassword">Surname</label>
                                    <div class="controls">
                                        <input type="text" name="sname" id="inputPassword" placeholder="surname" value="<?php echo $ln ?>" required title="surname">
                                    </div>
                                </div>
                                
                                <div class="control-group">
                                    <label class="control-label" for="inputEmail">Birthdate</label>
                                    <div class="controls">
                                        <input type="text" name="db" id="inputEmail" value="<?php echo $row['birth_date'] ?>" required title="Birth date">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="title">Middle name</label>
                                    <div class="controls">
                                        <input type="text" name="midd" id="inputEmail" value="<?php echo $row['middle_name'];?>" title="middlename">
                                    </div>
                                </div>
                                 <div class="control-group">
                                    <label class="control-label"  for="postal">Student address</label>
                                    <div class="controls">
                                <input type="text" name="stud_add" value="<?php echo $row['stud_address'] ?>" required title="student address">
                                        </div>
                                        </div>
                                        
                                      <div class="control-group">
                                    <label class="control-label"  for="postal"> student City</label>
                                    <div class="controls">
                                <input type="text" name="town" value="<?php echo $row['town'] ?>" required title="Student town">
                                        </div>
                                        </div> 
                                        <div class="control-group">
                                    <label class="control-label"  for="postal">Qualification</label>
                                    <div class="controls">
                                    <input type="text" name="qualif"  id="inputEmail" required value="<?php echo $row['qualif'] ?>">
                                           
                                            </select>
                                
                                        </div>
                                        </div>
                                         <div class="control-group">
                                    <label class="control-label"  for="postal">Entry semester</label>
                                    <div class="controls">
                                   
                                   
                                         
										 <select name="entsem"  id="inputEmail" required>
                                            <option value="<?php echo $row['system_sem'] ?>"><?php if($row['system_sem']==1) echo"Jan-June"; else echo "July-Dec";?></option>
                                            <option value="1">Jan-June</option>
                                            <option value="2">July-Dec</option>
                                            
                                            </select>
                                        </div>
                                        </div>    
                                    <div style="float:left; position: absolute; margin-left:350px; margin-top:-410px;">
                                <div class="control-group">
                                    <label class="control-label" for="input01">Study Year</label>
                                    <div class="controls">
                                       <input type="number" name="cyear" value="<?php echo $row['stud_current_year'] ?>" required title="Student town">     
                                    </div>
                                </div> 
                                  <div class="control-group">
                                    <label class="control-label" for="fn">Firstname</label>
                                    <div class="controls">
                                        <input type="text" name="fn" id="inputEmail" placeholder="Firstname" value="<?php echo $fn ?>"required title="first name">
                                      </div>
                                </div>   
                                <div class="control-group">
                                    <label class="control-label" for="g">Student Gender</label>
                                    <div class="controls">
                                        <input type="text" name="gender" value="<?php echo $row['gender'] ?>" required title="gender">
                                    </div>
                                </div>  
                                <div class="control-group">
                                    <label class="control-label"  for="cp">Student Phone</label>
                                    <div class="controls">
                                <input type="text" name="phone" value="<?php echo $row['stud_pnone'] ?>" required title="student phone number">
                                        </div>
                                        </div>                       
                                
                             
                                <div class="control-group">
                                    <label class="control-label" for="email">Student Email</label>
                                    <div class="controls">
                                        <input type="email" name="email" id="inputEmail" value="<?php echo $row['stud_email'] ?>" required title="student email">
                                    </div>
                                </div>                                
                                <div class="control-group">
                                    <label class="control-label"  for="p">Nationality</label>
                                    <div class="controls">
                                <input type="text" name="nation" value="<?php echo $row['nation'] ?>" required title="student nationality">
                                        </div>
                                        </div>
                                           <div class="control-group">
                                    <label class="control-label" for="email">Year of Entry</label>
                                    <div class="controls">
                                       <input type="number" name="joined"  id="inputEmail" value="<?php echo  $row['joined_in'] ?>" required>
                                           
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label"  for="p">Admission year</label>
                                    <div class="controls">
                                <input type="text" name="admyear" value="<?php echo $row['addm_year'] ?>" required title="year of admission">
                                        </div>
                                        </div>
                                        </div>
                                
                                <div style="float:left; position: absolute; margin-left:700px; margin-top:-410px;">
                                <div class="control-group">
                                    <label class="control-label" for="input01">Sponsor Name</label>
                                    <div class="controls">
                                     <input type="text" name="gardian" id="inputEmail" value="<?php echo $row['sponsor'] ?>" title="student sponsor name">       
                                    </div>
                                </div> 
                                   <div class="control-group">
                                    <label class="control-label"  for="gadd"> Sponsor address </label>
                                    <div class="controls">
                                <input type="text" name="s_add" value="<?php echo $row['sp_address'] ?>" title="sponsor address" >
                                        </div>
                                        </div>
                              
                                <div class="control-group">
                                    <label class="control-label"  for="gphone">Sponsor phone</label>
                                    <div class="controls">
                                <input type="number" name="sphone" value="<?php echo $row['spo_phone'] ?>" title="sponsor phone">
                                        </div>
                                        </div> 
                                        <div class="control-group">
                                    <label class="control-label"  for="smail">Sponsor Email</label>
                                    <div class="controls">
                                <input type="email" name="s_mail" value="<?php echo $row['spo_email'] ?>" title="sponsor email address">
                                        </div>
                                        </div>                        
                                <div class="control-group">
                                    <label class="control-label"  for="relation">Relationship</label>
                                    <div class="controls">
                                <input type="text" name="relation" value="<?php echo $row['sp_relation'] ?>" title="sponsor relation ship to student" >
                                        </div>
                                        </div>
                                
                                        <div class="control-group">
                                    <label class="control-label" for="program">Program of study</label>
                                    <div class="controls">
                                           <?php 
                                            $courseID=$row['cys'];
                                            $coursequery = mysqli_query($conn,"select * from course where course_id='$courseID'");
                                            $courseRow=mysqli_fetch_array($coursequery);
                                            ?>
                                        <select name="prog"  required>
                                            <option value="<?php echo $courseRow['course_id']; ?>"><?php echo $courseRow['cys']; ?></option>
                                            <?php
                                            $query = mysqli_query($conn,"select * from course");
											
                                            while ($row2 = mysqli_fetch_array($query)) {
                                                ?>
                                                <option value="<?php echo $row2['course_id']; ?>"><?php echo $row2['cys']; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                 <div class="control-group">
                                    <label class="control-label"  for="study">Study mode</label>
                                    <div class="controls">
                               <select name="mode"  id="inputEmail" required>
                                            <option value="<?php echo $row['mode'] ?>"><?php  if ($row['mode']==1)echo" Full time"; elseif($row['mode']==2) echo "Distance";elseif($row['mode']==3) echo "Masters(Non Biu graduate";else echo"Masters (BIU graduate)";  ?> </option>
                                            <option value="1">Full time</option>
                                            <option value="2">Distance</option>
                                            <option value="3">Masters(BIU Undergraduate) </option>
                                            <option value="4">Masters(Non BIU) </option>
                                            </select>
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
                                $midd = clean($conn,$_POST['midd']);
								$stadd = clean($conn,$_POST['stud_add']);
								$town = clean($conn,$_POST['town']);
								$gender = clean($conn,$_POST['gender']);
                                $fn = clean($conn,$_POST['fn']);
                                $ln = clean($conn,$_POST['sname']);
                               // $sem = clean($conn,$_POST['sem']);
								$phone = clean($conn,$_POST['phone']);
								$email = clean($conn,$_POST['email']);
								$nation = clean($conn,$_POST['nation']);
								$mode = clean($conn,$_POST['mode']);
								$spo = clean($conn,$_POST['gardian']);
								$spoadd =clean($conn, $_POST['s_add']);
								$spophone = clean($conn,$_POST['sphone']);
								$spomail = clean($conn,$_POST['s_mail']);
								$rel = clean($conn,$_POST['relation']);
								$prog = clean($conn,$_POST['prog']);
								$stu_id=clean($conn,$_POST['reg']);
								$year= date('Y');
								$ensem=$_POST['entsem'];
								//$pass=GenKey();
								$s=checksem();
								$username=clean($conn,$_POST['reg']);
								$qualif=clean($conn,$_POST['qualif']);
								$joined=clean($conn,$_POST['joined']);
								$id=$_GET['id'];
								$addm_year=clean($conn,$_POST['admyear']);
								$cyear=clean($conn,$_POST['cyear']);
                                 if($ensem==$s) $upd=$year; else $upd=$addm_year;
								  if($ensem==$s) $csem=1; else  $csem=2;
								  if($mode==3 or $mode==4) $cat=1;else $cat=0;
                                /*$image = addslashes(file_get_contents($_FILES['image']['tmp_name']));
                                $image_name = addslashes($_FILES['image']['name']);
                                $image_size = getimagesize($_FILES['image']['tmp_name']);

                                move_uploaded_file($_FILES["image"]["tmp_name"], "uploads/" . $_FILES["image"]["name"]);
                                $location = "uploads/" . $_FILES["image"]["name"];*/

                                mysqli_query($conn,"update student set firstname='$fn',lastname='$ln',cys='$prog',middle_name='$midd',student_id='$stu_id',stud_email='$email',birth_date='$db',stud_address='$stadd',gender='$gender',sponsor='$spo',
								stud_pnone='$phone',spo_email='$spomail',mode='$mode',town='$town',nation='$nation',sp_relation='$rel',addm_year='$year',current_sem='$csem',sp_address='$spoadd',qualif='$qualif',
spo_phone='$spophone',joined_in='$joined',stud_current_year='$cyear',addm_year='$addm_year',update_year='$upd',system_sem='$ensem',category='$cat' where id='$id'")or die("error here".mysqli_error($conn));
	      mysqli_query($conn, "update results set student_id='$stu_id' where uid='$id'") or die(mysqli_error($conn));
	      ?>
	      <?php header("location:student.php");?>
	<div class="alert alert-info"> student information updated<?php echo $id."_".$mode ?></div>
							<?php  
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


