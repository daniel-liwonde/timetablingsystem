<?php include('header.php'); ?>
<?php include('session.php'); ?>
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
                                <a  href="add_user.php"><i class="icon-plus-sign-alt icon-large"></i>&nbsp;Add User</a>
                            </li>


                        </ul>
                        <!-- right nav -->
                    </div>
                    <div class="span10">

                        <div class="hero-unit-3" style="width:100%">
                            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
                                <div class="alert alert-info">
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                    <strong><i class="icon-user icon-large"></i>&nbsp;User Table</strong>
                                </div>
                                <thead>
                                    <tr>
                                    <th >Firstname</th>
                                      <th >Lastname</th>
                                        <th >Position</th>
                                      <th >Phone number</th>
                                      <th >Email</th>
									  <?php if ($l==9){?>
									  <th>Status</th>
									  <?php }?>
                                      <th>Action</th>
                                  </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $query = mysqli_query($conn,"select * from user") or die(mysqli_error($conn));
                                    while ($row = mysqli_fetch_array($query)) {
                                        $user_id = $row['user_id'];
                                        ?>
                                        <tr class="odd gradeX">
                                            
                                                         <!-- script -->
                                    <script type="text/javascript">
                                        $(document).ready(function(){
                                            
                                            $('#e<?php echo $user_id; ?>').tooltip('show')
                                            $('#e<?php echo $user_id; ?>').tooltip('hide')
                                        });
                                    </script>
                                    <!-- end script -->
                                    <!-- script -->
                                    <script type="text/javascript">
                                        $(document).ready(function(){
                                            
                                            $('#d<?php echo $user_id; ?>').tooltip('show')
                                            $('#d<?php echo $user_id; ?>').tooltip('hide')
											 $('#f<?php echo $user_id; ?>').tooltip('show')
											  $('#f<?php echo $user_id; ?>').tooltip('hide')
											   $('#g<?php echo $user_id; ?>').tooltip('show')
                                            $('#g<?php echo $user_id; ?>').tooltip('hide')
											
                                        });
                                    </script>
                                    
                                    <!-- end script -->
                                            <td><?php echo $row['firstname']; ?></td> 
                                            <td><?php echo $row['lastname']; ?></td> 
                                            <td><?php if($row['user_level']==5) echo "Accountant"; if($row['user_level']==9) echo "System admin";if($row['user_level']==10) echo "IT Technician";   if($row['user_level']==8) echo "Cashier";if($row['user_level']==6) echo "Registrar"; if($row['user_level']==7) echo "Assistant Registrar";  if($row['user_level']==4) echo "Account assistant"; if($row['user_level']==5) echo "Accountant";?></td> 
                                            <td><?php echo $row['pno']; ?></td> 
                                            <td><?php echo $row['email']; ?></td> 
											<?php if ($l==9){?>
											<td><?php if($row['active']==1)echo "<font color='green'>Active</font>"; else echo "<font color='red'>Deactivated</font>"; ?>      <?php }?></td> 
                                            <td>
 <a rel="tooltip"  title="Delete User" id="d<?php echo $user_id; ?>" href="#userdel<?php echo $user_id; ?>" role="button"  data-toggle="modal" class="btn btn-danger"><i class="icon-trash icon-large"></i></a>
                                                <a rel="tooltip"  title="Edit User" id="e<?php echo $user_id; ?>" href="edit_user.php?id=<?php echo $user_id; ?>" class="btn btn-success"><i class="icon-pencil icon-large"></i></a>
												<?php if ($l==9){?>
                                                  <a rel="tooltip"  id="f<?php echo $user_id; ?>" href="#userdel2<?php echo $user_id; ?>" role="button"  data-toggle="modal" class="btn btn-danger">...</a>
                                                  <a rel="tooltip"   id="g<?php echo $user_id; ?>" href="active.php?id=<?php echo $user_id; ?>" class="btn btn-success">...</a>
                                                 <?php }?>
                                            </td>
                                            <!-- user delete modal -->
                                    <div id="userdel<?php echo $user_id; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-header">
                                        </div>
                                        <div class="modal-body">
                                            <div class="alert alert-danger">Are you Sure you Want to <strong>Delete</strong>&nbsp;<?php echo $row['firstname'] . "  " . $row['lastname']; ?>?</div>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn" data-dismiss="modal" aria-hidden="true"><i class="icon-remove icon-large"></i>&nbsp;Close</button>
                                            <a href="delete_user.php<?php echo '?id=' . $user_id; ?>" class="btn btn-danger"><i class="icon-trash icon-large"></i>&nbsp;Delete</a>
                                        </div>
                                    </div>
                                    <!-- end delete modal -->
									<!-- user delete modal -->
                                    <div id="userdel2<?php echo $user_id; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-header">
                                        </div>
                                        <div class="modal-body">
                                            <div class="alert alert-danger">Are you nsure you want to <strong>Deactivate</strong>&nbsp;<?php echo $row['firstname'] . "  " . $row['lastname']; ?>?</div>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn" data-dismiss="modal" aria-hidden="true"><i class="icon-remove icon-large"></i>&nbsp;Close</button>
                                            <a href="deactive.php<?php echo '?id=' . $user_id; ?>" class="btn btn-danger"><i class="icon-trash icon-large"></i>&nbsp;Deactivate</a>
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


