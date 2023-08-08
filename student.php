<?php include('session.php'); ?>
<?php include('header.php'); ?>
<style>
 #g{ width:40px}
</style>
<body onLoad="StartTimers(;" onmousemove="ResetTimers(;">

    <div class="row-fluid">
        <div class="span12">

            <?php include('navbar.php'); ?>

            <div class="container">

                <div class="row-fluid">

                    <div class="span12" style="margin-top: 50px;">
                       <a href="add_student.php" class="btn btn-success"><i class="icon-plus-sign icon-large"></i>&nbsp;Add Existing Student</a>
                       <a href="uploade_students.php" class="btn btn-success"><i class="icon-upload-alt icon-large"></i>&nbsp;Upload Student Details</a>
                        <a href="student_archive.php" class="btn btn-success"><i class="icon-align-justify icon-large"></i>&nbsp;View Archived</a>
                       <a href="add_student_new.php" class="btn btn-success"><i class="icon-plus-sign icon-large"></i>&nbsp;Add New Student</a>
                       <p>
                        <div class="hero-unit-3" style="width:105%">
                           <?php if(isset($_SESSION['ERR'])&& ($_SESSION['ERR']!='')){?>
                             <div class="alert alert-danger"><i class="icon-remove-sign"></i>&nbsp;<?php echo $_SESSION['ERR'];$_SESSION['ERR']=''; ?></div>
                            <?php  }?>
<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example" >
                                <div class="alert alert-info">
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                    <strong><i class="icon-user icon-large"></i>&nbsp;Students Table</strong>
                                </div>
                                 <div>
                                <form method="post" action="">
                                <select name="users"  required>
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
                                        <input type="submit" value="Display" class="btn btn-success display">
                                </form>
  Or Search By Name
                                <form style="float:left">
                                <select name="users"  required onChange="showUser(this.value)">
                                            <option value="">Select Student Name </option>
                                            <?php
                                            $query = mysqli_query($conn,"select * from student order by lastname ASC");
                                            while ($row = mysqli_fetch_array($query)) {
                                                ?>
                                                <option value="<?php echo $row['id']; ?>"><?php echo $row['lastname']."&nbsp;".$row['firstname']."&nbsp; (".$row['student_id']; ?>)</option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                        
                                </form>
                               
                                </div>
                                <thead>
                                    <tr>

                                        <th>StudentID</th>
                                        <th>Surname</th>
                                        <th>Firstname</th>
                                        <th>Phone</th>
                                        <th>Email</th>
                                        <th>Gender</th>
                                        <th>Program</th>
                                        <th width="200">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
									if(isset($_POST['users'])){
									$q=$_POST['users'];
                                    $query = mysqli_query($conn,"select * from student where cys='$q'") or die(mysqli_error($conn));
                                    while ($row = mysqli_fetch_array($query)) {
                                        $student_id = $row['student_id'];
										$id=$row['id'];
										$p=$row['cys'];
										$query2 = mysqli_query($conn,"select * from course where course_id='$p'") or die(mysqli_error($conn));
										$pro=mysqli_fetch_array($query2);
                                        ?>


                                        <!-- script -->
                                    <script type="text/javascript">
                                        $(document).ready(function(){
                                                
                                            $('#e<?php echo $id; ?>').tooltip('show')
                                            $('#e<?php echo $id; ?>').tooltip('hide')
                                        });
                                    </script>
                                    <!-- end script -->
                                    <!-- script -->
                                    <script type="text/javascript">
                                        $(document).ready(function(){
                                                
                                            $('#d<?php echo $id; ?>').tooltip('show')
                                            $('#d<?php echo $id; ?>').tooltip('hide')
											
                                        });
                                    </script>
                                    <!-- end script -->
                                     <!-- script -->
                                    <script type="text/javascript">
                                        $(document).ready(function(){
                                                
                                            $('#a<?php echo $id; ?>').tooltip('show')
                                            $('#a<?php echo $id; ?>').tooltip('hide')
											
                                        });
                                    </script>
                                    <!-- end script -->
                                     <!-- script -->
                                    <script type="text/javascript">
                                        $(document).ready(function(){
                                                
                                            $('#m<?php echo $id; ?>').tooltip('show')
                                            $('#m<?php echo $id; ?>').tooltip('hide')
											
                                        });
                                    </script>
									 <script type="text/javascript">
                                        $(document).ready(function(){
                                                
                                            $('#e<?php echo $id; ?>').tooltip('show')
                                            $('#e<?php echo $id; ?>').tooltip('hide')
											
                                        });
                                    </script>
                                    <!-- end script -->

                                    <tr class="odd gradeX">
                                        <td><?php echo $row['student_id']; ?></td>
									
                                        <td><a rel="tooltip" title ="View subjects" id="e<?php echo $id ?>" href="domo.php?id=<?php echo $id; ?>"><?php echo $row['lastname'] ; ?> </a></td> 
                                        <td><?php echo $row['firstname'] ; ?></td> 
                                          <td><?php echo $row['stud_pnone'] ?></td>
                                          <td><?php echo $row['stud_email']; ?></td> 
                                          <td><?php echo $row['gender']; ?></td> 
                                       
                                        <td><?php echo $p; ?></td> 
                     
                                        <td >
                                            <a rel="tooltip"  title="Archive info" id="d<?php echo $id; ?>" href="#id<?php echo $id; ?>" role="button"  data-toggle="modal" class="btn btn-danger"><i class="icon-trash icon-large"></i></a>
                                            
                                            <a rel="tooltip"  title="Edit student info" id="e<?php echo $id; ?>" href="edit_student.php?id=<?php echo $id; ?>&fn=<?php echo $row['firstname']; ?>&ln=<?php echo $row['lastname']; ?>&st=<?php echo $row['student_id']; ?>" class="btn btn-success"><i class="icon-pencil icon-large"></i></a>
                                           <a rel="tooltip"  title="Add courses" id="a<?php echo $id; ?>" href="add_student_subject.php?id=<?php echo $id; ?>&fn=<?php echo $row['firstname']?>&uname=<?php echo $row['username']; ?>&ln=<?php echo $row['lastname'];?>" class="btn btn-success" role="button"  data-toggle="modal" ><i class="icon-large"></i><i class="icon-plus-sign-alt icon-large"></i></a>
                                           <a rel="tooltip"  title="More info" id="m<?php echo $id; ?>" href="#view<?php echo $id; ?>" role="button"  data-toggle="modal" class="btn btn-info"><i class="icon-align-justify icon-large"></i></a>
                                        </td>
                                             
                                        <!-- user delete modal -->
                                    <div id="id<?php echo $id; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-header">
                                        </div>
                                        <div class="modal-body">
                                            <div class="alert alert-danger">Are you Sure you Want to <strong>Archive</strong>&nbsp; this information?</div>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn" data-dismiss="modal" aria-hidden="true"><i class="icon-remove icon-large"></i>&nbsp;Close</button>
                                            <a href="delete_student.php?did=<?php echo $id; ?>" class="btn btn-danger"><i class="icon-trash icon-large"></i>&nbsp;Delete</a>
                                        </div>
                                    </div>
                                    <!-- end delete modal -->
                                     <!-- user delete modal -->
                                   <div id="view<?php echo $id; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-header">
                                        </div>
                                        <div class="modal-body">
                                            <div class="alert alert-danger"><i class="icon-user icon-large"></i>STUDENT DETAILS</div>
                                            
                                            <?php 
                                        echo "<b>Phone number:</b>"." &nbsp;&nbsp; ". $row['stud_pnone'] ." ". "<br><b>Student Email:</b>"."   ". $row['stud_email']."<br>";
										 echo "<b>Student address:</b>"." &nbsp;&nbsp;  ". $row['stud_address'] ."  ". "<br><b>Birth date:</b>"."   ". $row['birth_date']."<br>";
										  echo "<b>Adimission year:</b>"."&nbsp;&nbsp;   ". $row['addm_year'] ."  ". "<br><b>Program:</b>"."   ". $row['cys']."<br><b>Semester:</b>"."   ". $row['current_sem']."<br>";
										   echo "<b>Entry qualification:</b>"." &nbsp;&nbsp;  ". $row['qualif'] ."  ". "<br><b>Study mode:</b>";if($row['mode']==1)echo "Full time<br>";if($row['mode']==2)echo "Distance<br>";if($row['mode']==3)echo "Masters(BIU Undergraduate)<br>";if($row['mode']==4)echo "Masters(Non BIU Undergraduate)<br>";
										    echo "<b>Study year:</b>"." &nbsp;&nbsp;  ". $row['stud_current_year']."<br>";
										    echo "<b>Sponsor:</b>"."  &nbsp;&nbsp; ". $row['sponsor']  ."  ". "<br><b>Sponsor address:</b>"."   ". $row['sp_address']."<br>";
											echo "<b>Sponsor Email:</b>"." &nbsp;&nbsp;  ". $row['spo_email']  ."  ". "<br><b>Sponsor phone:</b>"."   ". $row['spo_phone']."<br>";
											echo "<b>Sponsor relation:</b>"." &nbsp;&nbsp;  ". $row['sp_relation']  ."  ". "<br><b>Sponsor phone:</b>"."   ". $row['spo_phone']."<br>";
									     ?> 
                                           
                                            
                                           
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn" data-dismiss="modal" aria-hidden="true"><i class="icon-remove icon-large"></i>&nbsp;Close</button>
                                           
                                        </div>
                                    </div>
                                    <!-- end delete modal -->
                                    </tr>
                                <?php } }?>
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


