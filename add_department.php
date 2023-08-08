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
                                        <div class="alert alert-info"><i class="icon-plus-sign-alt icon-large"></i>&nbsp;Add Department Entry</div>

                                        <form class="form-horizontal" method="POST">

                                            <div class="control-group">
                                                <label class="control-label" for="inputPassword">Department Name:</label>
                                                <div class="controls">
                                                    <input type="text" name="d" id="inputPassword" placeholder="Department" required>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label" for="inputPassword">Person In Charge:</label>
                                                <div class="controls">
                                                    <input type="text" name="p" id="inputPassword" placeholder="Person In Charge" >
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label" for="inputPassword">Department code:</label>
                                                <div class="controls">
                                                    <input type="text" name="t" id="inputPassword" placeholder="code eg BIT" required>
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


                                            $d = $_POST['d'];
                                            $p = $_POST['p'];
                                            $t = $_POST['t'];


                                             $f=mysqli_query($conn,"select * from department where title='$t')") or die(mysqli_error($conn));
											 if(mysqli_num_rows($f)>0){
											?>
									<div class="alert alert-danger"><i class="icon-remove-sign"></i>Department already added</div>
                                     
                                    <?php
									}
									else{
                                            mysqli_query($conn,"insert into department (department,incharge,title) values ('$d','$p','$t')") or die(mysqli_error($conn));
                                            header('location:department.php');
                                        }}
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


