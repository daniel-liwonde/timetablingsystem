<?php include('header.php'); ?>
<?php include('session.php'); ?>
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
                                <a href="add_department.php"><i class="icon-plus-sign-alt icon-large"></i>&nbsp;Add Department</a>
                                <a href="department.php"><i class="icon-arrow-left icon-large"></i>&nbsp;Back</a>
                            </li>


                        </ul>
                        <!-- right nav -->
                    </div>
                    <div class="span10">
                        <div class="hero-unit-3">
                            <ul class="thumbnails">
                                <li class="span7">
                                    <div class="thumbnail">
                                        <div class="alert alert-info"><i class="icon-plus-sign-alt icon-large"></i>&nbsp;Edit Department </div>
                                      <?php
										$depid=$_GET['id'];
										$query = mysqli_query($conn,"select * from department where dep_id='$depid'") or die(mysqli_error($conn));
                                        $row = mysqli_fetch_array($query);
										?>
                                        <form class="form-horizontal" method="POST">

                                            <div class="control-group">
                                                <label class="control-label" for="inputPassword">Department Name:</label>
                                                <div class="controls">
                                                    <input type="text" name="d" id="inputPassword" value="<?php echo $row['department'] ?>" required>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label" for="inputPassword">Department head:</label>
                                                <div class="controls">
                                                    <input type="text" name="p" id="inputPassword" value="<?php echo $row['incharge'] ?>" >
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label" for="inputPassword">Department code:</label>
                                                <div class="controls">
                                                    <input type="text" name="t" id="inputPassword" value="<?php echo $row['title'] ?>" required>
                                                </div>
                                            </div>

                                            <div class="control-group">
                                                <div class="controls">

                                                    <button type="submit" name="save" class="btn btn-info"><i class="icon-save icon-large"></i>&nbsp;Save Department</button>
                                                </div>
                                            </div>
                                        </form>

                                        <?php
                                        if (isset($_POST['save'])) {
                                            $d = clean($conn,$_POST['d']);
                                            $p =  clean($conn,$_POST['p']);
                                            $t = clean($conn, $_POST['t']);
                                            mysqli_query($conn,"update department set department='$d',incharge='$p',title='$t' where dep_id='$depid'") or die(mysqli_error($conn));
                                            header('location:department.php');
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


