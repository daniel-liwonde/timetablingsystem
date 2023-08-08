<?php include('session.php'); ?>
<?php include('header.php'); ?>
<?php include('functions.php'); ?>
<body>
    <div class="row-fluid">
        <div class="span12">

            <?php include('navbar.php'); ?>

            <div class="container">

                <div class="row-fluid">
                    <div class="span2" style="margin-top: 50px;">
                        <!-- left nav -->
                        <ul class="nav nav-tabs nav-stacked">

                            <li class="active">
                                <a href="add_subject.php"><i class="icon-plus-sign-alt icon-large"></i>&nbsp;Add Subject</a>
                                <a href="subject.php"><i class="icon-arrow-left icon-large"></i>&nbsp;Back</a>
                            </li>


                        </ul>
                        <!-- right nav -->
                    </div>
                    <div class="span10">
                        <div class="hero-unit-3">
                            <ul class="thumbnails">
                                <li class="span7">
                                    <div class="thumbnail">
                                        <div class="alert alert-info"><i class="icon-plus-sign-alt icon-large"></i>&nbsp;Add Course Entry</div>
                                        <form class="form-horizontal" method="POST" name="frm">                                            
                                        <div class="control-group">
                                                <label class="control-label" for="inputPassword">Course Code:</label>
                                                <div class="controls">
                                                    <input type="text" name="sc" id="inputPassword" placeholder="Subject Code" required >
                                                </div>
                                            </div>
                                             <div class="control-group">
                                                <label class="control-label" for="inputPassword">Category:</label>
                                                <div class="controls">
                                                 
                                            <select name="cat"  required>
                                            <option> select category </option>
                                            
                                            <option value="0"> Undergraduate </option>
                                            <option value="1"> Diploma </option>
                                            <option value="2">Masters </option>
                                           
                                                                                      
                                          
                                        </select>
                                                </div>
                                            </div>     
                                            <div class="control-group">
                                                <label class="control-label" for="inputPassword">Course Title:</label>
                                                <div class="controls">
                                                    <input type="text" name="st" id="inputPassword" placeholder="Subject Title" required>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label" for="inputPassword">Offered Programme</label>
                                                <div class="controls">
                                                 
                                            <select name="sel"  required>
                                            <option>  </option>
                                           <?php
                                            $query = mysqli_query($conn,"select * from course");
                                            while ($row = mysqli_fetch_array($query)) {
                                                ?>
                                                <option value="<?php echo $row['course_id'];?>"><?php echo $row['cys']; ?></option>
                                                <?php
                                            }
                                            ?>
                                                                                    
                                          
                                        </select>
                                                </div>
                                            </div>        
                                            <div class="control-group">
                                                <label class="control-label" for="inputPassword">Department:</label>
                                                <div class="controls">
                                                 
                                                    <select name="dep"  required>
                                            <option>  </option>
                                            <?php
                                            $query = mysqli_query($conn,"select * from department");
                                            while ($row = mysqli_fetch_array($query)) {
                                                ?>
                                                <option value="<?php echo $row['dep_id'];?>"><?php echo $row['department']; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                                </div>
                                            </div>                                          
                                            
                                            <div class="control-group">
                                                <label class="control-label" for="inputPassword">Offered year:</label>
                                                <div class="controls">
                                                 
                                            <select name="year"  required>
                                            <option> select  </option>
                                            <option value="1"> First year </option>
                                            <option value="2">Second year  </option>
                                            <option value="3">  Third year</option>
                                            <option value="4"> Fourth year </option>
                                             
                                                                                      
                                          
                                        </select>
                                                </div>
                                            </div>                                      
                                            
                                            <div class="control-group">
                                                <label class="control-label" for="inputPassword">Offered Sem:</label>
                                                <div class="controls">
                                                 
                                            <select name="sem"  required>
                                            <option>  </option>
                                            <option value="1"> First semester </option>
                                            <option value="2">second semester </option>
                                               <option value="3">Third semester</option>                                        
                                          
                                        </select>
                                                </div>
                                            </div>        
                                            <div class="control-group">
                                                <div class="controls">

                                                    <button type="submit" name="save" class="btn btn-info"><i class="icon-save icon-large"></i>&nbsp;Save Subject</button>
                                                </div>
                                            </div>
                                        </form>

                                        <?php
                                        if (isset($_POST['save'])) {


                                            $sc = clean($conn,$_POST['sc']);
                                            $st = clean($conn,$_POST['st']);
                                            $dept = clean($conn,$_POST['dep']);
                                            $offery = clean($conn,$_POST['year']);
                                           $sem =   clean($conn,$_POST['sem']);
											 $prog =  clean($conn, $_POST['sel']);
											 $cat=  clean($conn, $_POST['cat']);
                              $duplicate=   mysqli_query($conn,"select * from subject where subject_code='$sc' or subject_title='$st'") or die (mysqli_error($conn));
							  if(mysqli_num_rows( $duplicate)>0){
							  ?>
                               <div class="alert alert-danger"><i class="icon-remove-sign"></i>&nbsp;Subject already available</div> 
                              <?php
							  }else{
								 
                                            mysqli_query($conn,"insert into subject (subject_code,subject_title,Dept, offered_year,offered_sem,prog,category) values ('$sc','$st','$dept','$offery','$sem','$prog','$cat')") or die(mysqli_error($conn));
                                            ?>
											<div class="alert alert-info"><i class="icon-tick"></i>&nbsp;Subject added <a href="subject.php">&nbsp;Back</a></div> 
											<?php
                                        }
										}
                                        ?>

                                    </div>
                                </li>

                            </ul>
                        </div>


                    </div>
                </div>

                <?php include('footer.php'); ?>
            </div>
        </div>
    </div>




</body>
</html>


