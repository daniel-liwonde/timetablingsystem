         
         <thead>
                                    <tr>

                                        <th>StudentID</th>
                                        <th>Surname</th>
                                        <th>Firstname</th>
                                        <th>Phone</th>
                                        <th>Email</th>
                                        <th>Gender</th>
                                        <th>Program</th>
                                        <th width="198">Action</th>
                                    </tr>
                                </thead> <?php
		  
		                  include('connect.php');
		                   $q = $_GET['q'];
                                    $query = mysqli_query($conn,"select * from student  where id='$q'") or die(mysqli_error($conn));
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
                                    <!-- end script -->

                                    <tr class="odd gradeX">
                                        <td><?php echo $row['student_id']; ?></td>
                                        <td><?php echo $row['lastname'] ; ?></td> 
                                        <td><?php echo $row['firstname'] ; ?></td> 
                                          <td><?php echo $row['stud_pnone'] ?></td>
                                          <td><?php echo $row['stud_email']; ?></td> 
                                          <td><?php echo $row['gender']; ?></td> 
                                       
                                        <td><?php echo $p; ?></td> 
                     
                                        <td width="190">
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
                                   <div id="view<?php echo $id; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-header">
                                        </div>
                                        <div class="modal-body">
                                            <div class="alert alert-danger"><i class="icon-user icon-large"></i>STUDENT DETAILS</div>
                                            
                                            <?php 
                                        echo "<b>Phone number:</b>"." &nbsp;&nbsp; ". $row['stud_pnone'] ." ". "<br><b>Student Email:</b>"."   ". $row['stud_email']."<br>";
										 echo "<b>Student address:</b>"." &nbsp;&nbsp;  ". $row['stud_address'] ."  ". "<br><b>Birth date:</b>"."   ". $row['birth_date']."<br>";
										  echo "<b>Adimission year:</b>"."&nbsp;&nbsp;   ". $row['addm_year'] ."  ". "<br><b>Program:</b>"."   ". $row['cys']."<br><b>Semester:</b>"."   ". $row['current_sem']."<br>";
										   echo "<b>Entry qualification:</b>"." &nbsp;&nbsp;  ". $row['qualif'] ."  ". "<br><b>Study mode:</b>";if($row['mode']==1)echo "Full time<br>";else echo "Distance<br>";
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
                                <?php } ?>