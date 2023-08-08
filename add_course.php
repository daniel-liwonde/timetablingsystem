<?php include('session.php'); ?>
<?php include('header.php'); ?>
<?php include('functions.php'); ?>
<body onLoad="StartTimers();" onmousemove="ResetTimers();">

    <div class="row-fluid">
        <div class="span12">

            <?php include('navbar.php'); ?>

            <div class="container">

                <div class="row-fluid">
                    <div class="span2" style="margin-top: 50px;">
                        <!-- left nav -->
                        <ul class="nav nav-tabs nav-stacked">

                            <li class="active">
                                <a href="add_course.php"><i class="icon-plus-sign-alt icon-large"></i>&nbsp;Add Course</a>
                                <a href="course.php"><i class="icon-arrow-left icon-large"></i>&nbsp;Back</a>
                            </li>


                        </ul>
                        <!-- right nav -->
                    </div>
                    <div class="span10">
                        <div class="hero-unit-3">
                            <ul class="thumbnails">
                                <li class="span7">
                                    <div class="thumbnail">
                                        <div class="alert alert-info"><i class="icon-plus-sign-alt icon-large"></i>&nbsp;Add Programme</div>

                                        <form class="form-horizontal" method="POST">

                                            <div class="control-group">
                                                <label class="control-label" for="inputPassword">Programme Code:</label>
                                                <div class="controls">
                                                    <input type="text" name="cc" id="inputPassword" placeholder="course code eg IT" required>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label" for="inputPassword">Programme Title:</label>
                                                <div class="controls">
                                                    <input type="text" name="cn" id="inputPassword" placeholder="course name" required>
                                                </div>
                                            </div>
                                        
                                            <div class="control-group">
                                                <label class="control-label" for="inputPassword">Department:</label>
                                                <div class="controls">
            
                                                    <select name="cd" required>
                                                        <option></option>
                                                        <?php 
                                                        $query=mysqli_query($conn,"select * from department");
                                                        while($row=mysqli_fetch_array($query)){
                                                            ?>
                                                        <option value="<?php echo $row['title']; ?>"><?php echo $row['department']; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                              <center>Minimum Number of courses for student to graduate depending on erollment Level</center>
                                             <div class="control-group">
                                                <label class="control-label" for="inputPassword">First year Enrollment:</label>
                                                <div class="controls">
                                                    <input type="text" name="f" id="inputPassword" placeholder="minimum No of subj to graduate" required>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label" for="inputPassword">Second year Exemptions:</label>
                                                <div class="controls">
                                                    <input type="text" name="s" id="inputPassword" placeholder="minimum No of subj to graduate" required>
                                                </div>
                                            </div>
<div class="control-group">
                                                <label class="control-label" for="inputPassword">Third year Exemptions:</label>
                                                <div class="controls">
                                                    <input type="text" name="t" id="inputPassword" placeholder="minimum No of subj to graduate" required>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <div class="controls">

                                                    <button type="submit" name="save" class="btn btn-info"><i class="icon-save icon-large"></i>&nbsp;Add Program</button>
                                                </div>
                                            </div>
                                        </form>

                                        <?php
                                        if (isset($_POST['save'])) {


                                            $cc = clean($conn,$_POST['cc']);
                                            $cd = clean($conn,$_POST['cd']);
											$cn = clean($conn,$_POST['cn']);
                                            $f=clean($conn,$_POST['f']);
                                            $s=clean($conn,$_POST['s']);
                                             $t=clean($conn,$_POST['t']);




                                            mysqli_query($conn,"insert into course (course_id,department,cys,first,second,third) values ('$cc','$cd','$cn','$f','$s','$t')") or die(mysqli_error($conn));
											
                                            header('location:course.php');
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


