<?php include('header.php'); ?>
<?php include('session.php'); ?>
<?php include('functions.php'); ?>
<body onLoad="StartTimers();" onmousemove="ResetTimers();">

    <div class="row-fluid">
        <div class="span12">

            <?php include('navbar.php'); ?>

            <div class="container">

                <div class="row-fluid">
                    <div class="span2">
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
                                        <div class="alert alert-info"><i class="icon-plus-sign-alt icon-large"></i>&nbsp;Edit Programme Entry</div>
                                      <?php
										$progid=$_GET['id'];
										$query = mysqli_query($conn,"select * from course where course_id='$progid'") or die(mysqli_error($conn));
                                        $row = mysqli_fetch_array($query);
										?>
                                        <form class="form-horizontal" method="POST">

                                            <div class="control-group">
                                                <label class="control-label" for="inputPassword">Programme Code:</label>
                                                <div class="controls">
                                                    <input type="text" name="cc" id="inputPassword"  value="<?php echo $row['course_id'];  ?>" required>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label" for="inputPassword">Programme Title:</label>
                                                <div class="controls">
                                                    <input type="text" name="cn" id="inputPassword"  value="<?php echo $row['cys']  ?>" required>
                                                </div>
                                            </div>
                                        
                                            <div class="control-group">
                                                <label class="control-label" for="inputPassword">Progrmme Department:</label>
                                                <div class="controls">
            
                                                    <select name="cd" >
                                                        <option></option>
                                                        <?php 
                                                        $query=mysqli_query($conn,"select * from department");
                                                        while($rows=mysqli_fetch_array($query)){
                                                            ?>
                                                        <option value="<?php echo $rows['title']; ?>"><?php echo $rows['department']; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            
                                              <div class="control-group">
                                                <label class="control-label" for="inputPassword">First year Enrollment:</label>
                                                <div class="controls">
                                                    <input type="text" name="f" id="inputPassword"  value="<?php echo $row['first']  ?>"  required>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label" for="inputPassword">Second year Exemptions:</label>
                                                <div class="controls">
                                                    <input type="text" name="s"   value="<?php echo $row['second']  ?>"id="inputPassword" required>
                                                </div>
                                            </div>
<div class="control-group">
                                                <label class="control-label" for="inputPassword">Third year Exemptions:</label>
                                                <div class="controls">
                                                    <input type="text" name="t"  value=" <?php echo $row['third']  ?>" id="inputPassword"  required>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <div class="controls">

                                                    <button type="submit" name="save" class="btn btn-info"><i class="icon-save icon-large"></i>&nbsp;Save Course</button>
                                                </div>
                                            </div>
                                        </form>

                                        <?php
                                        if (isset($_POST['save'])) {

                                            $id = $_GET['id'];
                                            $cc =clean($conn,$_POST['cc']);
                                            $cd = clean($conn,$_POST['cd']);
											$cn = clean($conn,$_POST['cn']);
                                             $f=clean($conn,$_POST['f']);
                                            $s=clean($conn,$_POST['s']);
                                             $t=clean($conn,$_POST['t']);



                                            mysqli_query($conn,"update course set course_id='$cc',first='$f', second='$s',third='$t',department='$cd',cys='$cn' where course_id='$progid'") or die(mysqli_error($conn));
                                            mysqli_query($conn, "UPDATE  subject set prog='$progid' WHERE prog='$cc'") or die(mysqli_error($conn));
                                            echo "<div class='alert alert-success'>Done</div>";
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


