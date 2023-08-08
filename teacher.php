<?php include('session.php'); ?>
<?php include('header.php'); ?>

<body onLoad="StartTimers();" onmousemove="ResetTimers();">

    <div class="row-fluid">
        <div class="span12">

            <?php include('navbar.php'); ?>

            <div class="container">

                <div class="row-fluid">

                    <div class="span12" style="width:107%">
                        <div class="hero-unit-3">
                            <a class="btn btn-success" <?php if (($l == 1) or ($l == 2) or ($l == 9)) { ?>href="add_teacher.php"
                                <?php } else { ?> <a href="#" onClick="alert('ACCESS DENIED')">
                                <?php } ?>
                                <i class="icon-plus-sign icon-large"></i>&nbsp;Add Lecturer
                            </a>
                            <br>
                            <br>
                            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered"
                                id="example">
                                <div class="alert alert-info">
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                    <strong><i class="icon-user icon-large"></i>&nbsp;Lecturers Table</strong>
                                </div>
                                <thead>
                                    <tr>


                                        <th>Photo</th>
                                        <th>Firstname</th>
                                        <th>Lastname</th>
                                        <th>Dept.</th>
                                        <th>Phone number</th>
                                        <th>Email</th>
                                        <th>Position</th>
                                        <?php if ($l == 9) { ?>
                                            <th>Status</th>
                                        <?php } ?>
                                        <th style="width:21%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $query = mysqli_query($conn, "select * from teacher") or die(mysqli_error($conn));
                                    while ($row = mysqli_fetch_array($query)) {
                                        $teacher_id = $row['teacher_id'];
                                        ?>
                                        <tr class="odd gradeX">

                                            <!-- script -->
                                            <script type="text/javascript">
                                                $(document).ready(function () {

                                                    $('#e<?php echo $teacher_id; ?>').tooltip('show')
                                                    $('#e<?php echo $teacher_id; ?>').tooltip('hide')
                                                });
                                            </script>
                                            <!-- end script -->
                                            <!-- script -->
                                            <script type="text/javascript">
                                                $(document).ready(function () {

                                                    $('#d<?php echo $teacher_id; ?>').tooltip('show')
                                                    $('#d<?php echo $teacher_id; ?>').tooltip('hide')
                                                    $('#f<?php echo $teacher_id; ?>').tooltip('show')
                                                    $('#f<?php echo $teacher_id; ?>').tooltip('hide')
                                                    $('#g<?php echo $teacher_id; ?>').tooltip('show')
                                                    $('#g<?php echo $teacher_id; ?>').tooltip('hide')

                                                });
                                            </script>

                                            <!-- end script -->

                                            <td width="40">
                                                <?php if ($row['location'] == '') { ?> <img class="img-rounded" src="img/log.png"
                                                    height="50" width="50">
                                            <?php } else { ?><img class="img-rounded"
                                                src="<?php echo $row['location']; ?>" height="100" width="50"><?php } ?>
                                            </td>
                                            <td>
                                                <?php echo $row['firstname']; ?>
                                            </td>
                                            <td>
                                                <?php echo $row['lastname']; ?>
                                            </td>
                                            <td>
                                                <?php echo $row['department']; ?>
                                            </td>
                                            <td>
                                                <?php echo $row['pno']; ?>
                                            </td>

                                            <td>
                                                <?php echo $row['email']; ?>
                                            </td>
                                            <td>
                                                <?php if ($row['user_level'] == 4)
                                                    echo "Lecturer";
                                                elseif ($row['user_level'] == 3)
                                                    echo "HOD";
                                                elseif ($row['user_level'] == 2)
                                                    echo "Vice chancellor";
                                                else
                                                    echo "Chancellor"; ?>
                                            </td>
                                            <?php if ($l == 9) { ?>
                                                <td>
                                                    <?php if ($row['active'] == 1)
                                                        echo "<font color='green'>Active</font>";
                                                    else
                                                        echo "<font color='red'>Deactivated</font>"; ?>
                                                <?php } ?>
                                            </td>
                                            <td width="100">
                                                <a rel="tooltip" title="Delete Teacher" id="d<?php echo $teacher_id; ?>"
                                                    href="#course_id<?php echo $teacher_id; ?>" role="button"
                                                    data-toggle="modal" class="btn btn-danger"><i
                                                        class="icon-trash icon-large"></i>&nbsp;</a>
                                                <a rel="tooltip" title="Edit Teacher" id="e<?php echo $teacher_id; ?>"
                                                    href="edit_teacher.php<?php echo '?idd=' . $teacher_id; ?>"
                                                    class="btn btn-success"><i class="icon-pencil icon-large"></i>&nbsp;</a>
                                                <a href="add_teacher_subject.php?tid=<?php echo $teacher_id; ?>&fn=<?php echo $row['firstname'] ?>&ln=<?php echo $row['lastname'] ?>"
                                                    class="btn btn-success"><i class="icon-plus-sign icon-large"></i></a>
                                                <?php if ($l == 9) { ?>
                                                    <a rel="tooltip" id="f<?php echo $teacher_id; ?>"
                                                        href="#userdel2<?php echo $teacher_id; ?>" role="button"
                                                        data-toggle="modal" class="btn btn-danger">...</a>
                                                    <a rel="tooltip" id="g<?php echo $teacher_id; ?>"
                                                        href="active_t.php?id=<?php echo $teacher_id; ?>"
                                                        class="btn btn-success">...</a>
                                                <?php } ?>
                                            </td>
                                            <!-- user delete modal -->
                                            <div id="course_id<?php echo $teacher_id; ?>" class="modal hide fade"
                                                tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                                                aria-hidden="true">
                                                <div class="modal-header">
                                                </div>
                                                <div class="modal-body">
                                                    <div class="alert alert-danger">Are you Sure you Want to
                                                        <strong>Delete</strong>&nbsp; this Teacher?</div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn" data-dismiss="modal" aria-hidden="true"><i
                                                            class="icon-remove icon-large"></i>&nbsp;Close</button>
                                                    <a href="delete_teacher.php<?php echo '?id=' . $teacher_id; ?>"
                                                        class="btn btn-danger"><i
                                                            class="icon-trash icon-large"></i>&nbsp;Delete</a>
                                                </div>
                                            </div>
                                            <!-- end delete modal -->
                                            <!-- Deactivate -->
                                            <div id="userdel2<?php echo $teacher_id; ?>" class="modal hide fade"
                                                tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                                                aria-hidden="true">
                                                <div class="modal-header">
                                                </div>
                                                <div class="modal-body">
                                                    <div class="alert alert-danger">Are you nsure you want to
                                                        <strong>Deactivate</strong>&nbsp;
                                                        <?php echo $row['firstname'] . "  " . $row['lastname']; ?>?
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn" data-dismiss="modal" aria-hidden="true"><i
                                                            class="icon-remove icon-large"></i>&nbsp;Close</button>
                                                    <a href="deactive_t.php<?php echo '?id=' . $teacher_id; ?>"
                                                        class="btn btn-danger"><i
                                                            class="icon-trash icon-large"></i>&nbsp;Deactivate</a>
                                                </div>
                                            </div>
                                            <!-- end deactive modal -->

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