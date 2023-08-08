<?php include('session.php'); ?>
<?php include('header.php'); ?>
<?php include('functions.php'); ?>
<body>

    <div class="row-fluid">
        <div class="span12">

            <?php include('navbar.php'); ?>

            <div class="container">

                <div class="row-fluid">
                    <div class="span2">
                        <!-- left nav -->
                        <ul class="nav nav-tabs nav-stacked">

                            <li class="active">
                                <a href="add_course.php"><i class="icon-plus-sign-alt icon-large"></i>&nbsp;Edit Subject</a>
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
                                        <div class="alert alert-info"><i class="icon-plus-sign-alt icon-large"></i>&nbsp;Update subject</div>
                                        <?php
										$subid=$_GET['id'];
										$query = mysqli_query($conn,"select * from subject where subject_id='$subid'") or die(mysqli_error($conn));
                                        $row = mysqli_fetch_array($query);
										?>

                                        <form class="form-horizontal" method="POST">

                                            <div class="control-group">
                                                <label class="control-label" for="inputPassword">Subject Code:</label>
                                                <div class="controls">
                                                    <input type="text" name="sc" id="inputPassword"  value="<?php echo $row['subject_code']  ?>" required>
                                                </div>
                                            </div>
                                             <div class="control-group">
                                                <label class="control-label" for="inputPassword">Category:</label>
                                                <div class="controls">
                                                 
                                            <select name="cat"  required>
                                            <option> select category </option>
                                            <option value="0"> Undergraduate </option>
                                            <option value="1">Masters </option>
                                            <div class="control-group">
                                                <label class="control-label" for="inputPassword">Subject Title:</label>
                                                <div class="controls">
                                                    <input type="text" name="st" id="inputPassword" value="<?php  echo $row['subject_title']  ?> "required>
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
                                                <label class="control-label" for="inputPassword">Department</label>
                                                <div class="controls">
                                                 
                                                    <select name="dep"  >
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
                                            <option>  </option>
                                            <option value="1"> First year </option>
                                            <option value="2">Second year  </option>
                                            <option value="3">  Third year</option>
                                            <option value="4"> Fourth year </option> 
                                            <option value="5"> Fifth year </option>                                       
                                          
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
                                                                                    
                                          
                                        </select>
                                                </div>
                                            </div>        

                                            <div class="control-group">
                                                <div class="controls">

                                                    <button type="submit" name="save" class="btn btn-info"><i class="icon-save icon-large"></i>&nbsp;Update Subject</button>
                                                </div>
                                            </div>
                                        </form>

                                        <?php
                                        if (isset($_POST['save'])) {
                                             $sc = clean($conn, $_POST['sc']);
                                             $st =  clean($conn,$_POST['st']);
                                             $dept =  clean($conn,$_POST['dep']);
                                             $offery =  clean($conn,$_POST['year']);
                                             $sem =    clean($conn,$_POST['sem']);
											 $prog =    clean($conn,$_POST['sel']);
                                              $cat =    clean($conn,$_POST['cat']);
                                            mysqli_query($conn,"update subject set subject_code='$sc',subject_title='$st',Dept='$dept',offered_year='$offery',offered_sem='$sem',prog='$prog',category='$cat' where subject_id='$subid'") or die(mysqli_error($conn));
                                           ?>
										   <div class="alert alert-info"><i class="icon-tick"></i>&nbsp;Subject updated<a href="subject.php">&nbsp;Back</a></div> 
										   
										   <?php
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


