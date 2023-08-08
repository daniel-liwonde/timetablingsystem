<?php include('header.php'); ?>
<?php include('session.php'); ?>
<body>

    <div class="row-fluid">
        <div class="span12">

            <?php include('navbar.php'); ?>

            <div class="container">

                <div class="row-fluid">

                    <div class="span12" style="margin-top: 50px;">
                       <a href="add_student.php" class="btn btn-success"><i class="icon-plus-sign icon-large"></i>&nbsp;Add Student</a>
                       <a href="uploade_students.php" class="btn btn-success"><i class="icon-upload-alt icon-large"></i>&nbsp;Upload student details</a>
                        <a href="student.php" class="btn btn-success"><i class="icon-arrow-left icon-large"></i>&nbsp;Back</a>
                       <p>
                        <div class="hero-unit-3">
                           
                            
                            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
                                <div class="alert alert-info">
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                    <strong><i class="icon-user icon-large"></i>&nbsp;Students Table</strong>
                                </div>
                                <thead>
                                    <tr>

                                        <th>StudentID</th>
                                        <th>Fistname</th>
                                        <th>Lastname</th>
                                        <th>Phone</th>
                                        <th>Email</th>
                                        <th>Gender</th>
                                        <th>Program</th>
                                        <th>Admission year</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $query = mysqli_query($conn,"select * from student_archive") or die(mysqli_error($conn));
                                    while ($row = mysqli_fetch_array($query)) {
                                        $id = $row['student_id'];
										
										$p=$row['cys'];
										$query2 = mysqli_query($conn,"select * from course where course_id='$p'") or die(mysqli_error($conn));
										$pro=mysqli_fetch_array($query2);
                                        ?>


                                        <!-- script -->
                                    
                                     <!-- script -->
                                    <script type="text/javascript">
                                        $(document).ready(function(){
                                                
                                            $('#m<?php echo $id; ?>').tooltip('show')
                                            $('#m<?php echo $id; ?>').tooltip('hide')
											
                                        });
                                    </script>
                                    <!-- end script -->

                                    <tr class="odd gradeX">
                                        <td><?php echo $row['student_id']; ?></td>
                                        <td><?php echo $row['firstname'] ; ?></td> 
                                        <td><?php echo $row['lastname'] ; ?></td> 
                                          <td><?php echo $row['stud_pnone'] ?></td>
                                          <td><?php echo $row['stud_email']; ?></td> 
                                          <td><?php echo $row['gender']; ?></td>
                                           <td><?php echo $pro['course_id']; ?></td>  
                                       <td><?php echo $row['addm_year']; ?></td> 
                                       
                     
                                        
                                        <!-- user delete modal -->
                                    
                                        
                                     <!-- user delete modal -->
                                   
                                    <!-- end delete modal -->
                                    </tr>
                                <?php } ?>
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


