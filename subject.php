<?php include('session.php'); ?>
<?php include('header.php'); ?>
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
                                <a  href="add_subject.php"><i class="icon-plus-sign-alt icon-large"></i>&nbsp;Add Course</a>
                            </li>


                        </ul>
                        <!-- right nav -->
                    </div>
                    <div class="span10">

                        <div class="hero-unit-3">
                            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
                                <div class="alert alert-info">
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                    <strong><i class="icon-user icon-large"></i>&nbsp;Course Table</strong>
                                </div>
                                <thead>
                                    <tr>

                                        <th>Course Code</th>
                                        <th>Course Title</th>
                                        <th>Department</th>
                                         <th>Programme</th>
                                        <th>Year</th>
                                        <th>Sem</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $query = mysqli_query($conn,"select * from subject") or die(mysqli_error($conn));
                                    while ($row = mysqli_fetch_array($query)) {
                                        $subject_id = $row['subject_id'];
										$deps=$row['Dept'];
										$query2 = mysqli_query($conn,"select * from department where dep_id='$deps'") or die(mysqli_error($conn));
										$row2 = mysqli_fetch_array($query2)
                                        ?>
                                        <tr class="odd gradeX">


                                            <!-- script -->
                                    <script type="text/javascript">
                                        $(document).ready(function(){
                                            
                                            $('#e<?php echo $subject_id; ?>').tooltip('show')
                                            $('#e<?php echo $subject_id; ?>').tooltip('hide')
                                        });
                                    </script>
                                    <!-- end script -->
                                    <!-- script -->
                                    <script type="text/javascript">
                                        $(document).ready(function(){
                                            
                                            $('#d<?php echo $subject_id; ?>').tooltip('show')
                                            $('#d<?php echo $subject_id; ?>').tooltip('hide')
                                        });
                                    </script>
                                    <!-- end script -->

                                    <td><?php echo $row['subject_code']; ?></td> 
                                    <td><?php echo $row['subject_title']; ?></td>
                                        <td><?php echo $row2['department']; ?></td> 
                                         <td><?php if($row['category']==0) echo $row['prog'];else echo "Masters" ?></td> 
                                    <td><?php echo $row['offered_year']; ?></td> 
                                    <td><?php echo $row['offered_sem']; ?></td> 
                                   


                                    <td width="100">
                                        <a rel="tooltip"  title="Delete Subject" id="d<?php echo $subject_id; ?>"  href="#subject_id<?php echo $subject_id; ?>" role="button"  data-toggle="modal" class="btn btn-danger"><i class="icon-trash icon-large"></i></a>
                                        <a rel="tooltip"  title="Edit Subject" id="e<?php echo $subject_id; ?>"   href="edit_subject.php?id=<?php echo $subject_id; ?>" class="btn btn-success"><i class="icon-pencil icon-large"></i></a>
                                    </td>
                                    <!-- user delete modal -->
                                    <div id="subject_id<?php echo $subject_id; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-header">
                                        </div>
                                        <div class="modal-body">
                                            <div class="alert alert-danger">Are you Sure you Want to <strong>Delete</strong>&nbsp; this Course?</div>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn" data-dismiss="modal" aria-hidden="true"><i class="icon-remove icon-large"></i>&nbsp;Close</button>
                                            <a href="delete_subject.php<?php echo '?id=' . $subject_id; ?>" class="btn btn-danger"><i class="icon-trash icon-large"></i>&nbsp;Delete</a>
                                        </div>
                                    </div>
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


