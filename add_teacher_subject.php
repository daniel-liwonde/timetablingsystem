<?php
include('session.php');
include('header.php');
$teacher_id = $_GET['tid'];
?>

<body onLoad="StartTimers();" onmousemove="ResetTimers();">

    <?php include('navbar.php'); ?>

    <div class="container">
        <div class="row-fluid">
            <div class="span3" style="width:11%;visibility:hidden;">
                <div class="hero-unit-3">

                </div>
            </div>
            <div class="span9" style="width:107%; margin-top:-50px;">
                <div class="hero-unit-3">
                    <p> <a href="teacher.php" class="btn btn-success"><i
                                class="icon-arrow-left icon-large"></i>&nbsp;Back</a></p>

                    <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered"
                        id="example">
                        <div class="alert alert-info">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong><i class="icon-user icon-large"></i>&nbsp;Assign subjects to&nbsp;&nbsp;<font
                                    color="green">
                                    <?php echo $_GET['ln'] . "&nbsp" . $_GET['fn']; ?>
                                </font></strong>
                        </div>
                        <thead>
                            <tr>

                                <th width="100">Subject code</th>
                                <th>Subject title</th>
                                <th>Current teacher</th>
                                <th>Department</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = mysqli_query($conn, "select * from subject") or die(mysqli_error($conn));
                            while ($row = mysqli_fetch_array($query)) {
                                $subject_id = $row['subject_id'];
                                $dept = $row['Dept'];
                                $teacher = $row['teacher_id'];
                                $query_dept = mysqli_query($conn, "select * from department where dep_id='$dept'") or die(mysqli_error($conn));
                                $dep = mysqli_fetch_array($query_dept);
                                $query_teacher = mysqli_query($conn, "select * from teacher where teacher_id='$teacher'") or die(mysqli_error($conn));
                                $current_teacher = mysqli_fetch_array($query_teacher);
                                ?>


                                <!-- script -->
                                <script type="text/javascript">
                                    $(document).ready(function () {

                                        $('#e<?php echo $student_id; ?>').tooltip('show')
                                        $('#e<?php echo $student_id; ?>').tooltip('hide')
                                    });
                                </script>
                                <!-- end script -->
                                <!-- script -->
                                <script type="text/javascript">
                                    $(document).ready(function () {

                                        $('#a<?php echo $subject_id; ?>').tooltip('show')
                                        $('#a<?php echo $subject_id; ?>').tooltip('hide')
                                    });
                                </script>
                                <!-- end script -->


                                <tr class="odd gradeX">
                                    <td width="50">
                                        <?php echo $row['subject_code']; ?>
                                    </td>
                                    <td>
                                        <?php echo $row['subject_title'] ?>
                                    </td>
                                    <td>
                                        <?php if ($current_teacher)
                                            echo $current_teacher['lastname'] . " " . $current_teacher['firstname']; ?>
                                    </td>
                                    <td>
                                        <?php echo $dep['department']; ?>
                                    </td>


                                    <td width="50">
                                        <a rel="tooltip" title="Add subject" id="a<?php echo $subject_id; ?>"
                                            href="#subject_id<?php echo $subject_id; ?>" role="button" data-toggle="modal"
                                            class="btn btn-info"><i class="icon-plus-sign-alt icon-large"></i></a>

                                    </td>
                                    <!-- user delete modal -->
                                    <div id="subject_id<?php echo $subject_id; ?>" class="modal hide fade" tabindex="-1"
                                        role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-header">
                                        </div>
                                        <div class="modal-body">
                                            <div class="alert alert-info">Are you Sure you Want to
                                                <strong>Add</strong>&nbsp; this Subject?
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <form method="POST">
                                                <input type="hidden" name="teacher_id" value="<?php echo $teacher_id; ?>">
                                                <input type="hidden" name="subject_id" value="<?php echo $subject_id; ?> ">
                                                <button class="btn" data-dismiss="modal" aria-hidden="true"><i
                                                        class="icon-remove icon-large"></i>&nbsp;Close</button>
                                                <button name="save1" class="btn btn-info"><i
                                                        class="icon-plus icon-large"></i>&nbsp;Add</button>
                                            </form>
                                        </div>
                                    </div>
                                    <!-- end delete modal -->

                                </tr>
                            <?php } ?>
                            <?php
                            if (isset($_POST['save1'])) {
                                $teacher_id = $_POST['teacher_id'];
                                $subject_id = $_POST['subject_id'];
                                $sub_query = mysqli_query($conn, "select * from subject where subject_id='$subject_id'") or die(mysqli_error($conn));
                                $subd = mysqli_fetch_array($sub_query);
                                $error_query = mysqli_query($conn, "select * from subject where teacher_id='$teacher_id' and subject_id='$subject_id'") or die(mysqli_error($conn));
                                $error_row = mysqli_fetch_array($error_query);
                                $count = mysqli_num_rows($error_query);
                                $subName = $subd['subject_title'];

                                if ($count > 0) {
                                    ?>
                                    <div class="alert alert-danger">
                                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                                        Subject Already Assigned to <b>
                                            <font color="green">
                                                <?php echo $_GET['fn'] . "&nbsp;" . $_GET['ln']; ?>
                                            </font>
                                        </b </div>
                                        <?php
                                } else {
                                    $fn = $_GET['fn'];
                                    $ln = $_GET['ln'];
                                    mysqli_query($conn, "update subject set teacher_id='$teacher_id' where subject_id='$subject_id'") or die(mysqli_error($conn));
                                    mysqli_query($conn, "update teacher_student set teacher_id='$teacher_id' where subject_id='$subject_id'") or die(mysqli_error($conn));
                                    mysqli_query($conn, "update schedule set lectid='$teacher_id',lecturerfname='$fn',lecturerlname='$ln' where allocatedcourse='$subName'") or die(mysqli_error($conn));
                                    ?>
                                        <div class="alert alert-success">
                                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                                            <?php echo $subd['subject_title']; ?>&nbsp;Assigned to<b>
                                                <font color="green">
                                                    <?php echo $_GET['fn'] . "&nbsp;" . $_GET['ln']; ?>
                                                </font>
                                            </b>
                                        </div>
                                        <?php
                                }
                            }
                            ?>


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