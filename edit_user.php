<?php include('header.php'); ?>
<?php include('session.php'); ?>
<?php include('functions.php'); ?>
<body onLoad="StartTimers();" onmousemove="ResetTimers();">

    <div class="row-fluid">
        <div class="span12">

            <?php include('navbar.php'); ?>

            <div class="container">

                <div class="row-fluid">

                    <div class="span12">
                        <div class="hero-unit-3">
                            <a href="user.php" class="btn btn-success"><i class="icon-arrow-left icon-large"></i>&nbsp;Back</a>
                            <br>
                            <br>
                            <?php
							$get_id=$_GET['id'];
                           $teacher_query=mysqli_query($conn,"select * from user where user_id='$get_id'")or die(mysqli_error($conn));
                           $row=mysqli_fetch_array($teacher_query);
?>
                            <form class="form-horizontal" method="post" enctype="multipart/form-data">
                                <div class="control-group">
                                            <label class="control-label" for="inputEmail">Username:</label>
                                            <div class="controls">
                                                <input type="text" name="un" id="inputEmail" placeholder="Username" required>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label" for="inputPassword">Password:</label>
                                            <div class="controls">
                                                <input type="password" name="p" id="inputPassword" placeholder="Password" required>
                                            </div>
                                        </div>
                                <div class="control-group">
                                    <label class="control-label" for="inputEmail">Firstname</label>
                                    <div class="controls">
                                        <input type="text" id="inputEmail" name="firstname" value="<?php echo $row['firstname']; ?>" required>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="inputEmail">Lastname</label>
                                    <div class="controls">
                                        <input type="text" id="inputEmail" name="lastname" value="<?php echo $row['lastname']; ?>" required>
                                    </div>
                                </div>
                                
                                <div class="control-group">
                                            <label class="control-label" for="inputPassword">Phone Number:</label>
                                            <div class="controls">
                                                <input type="number" name="pno" id="inputPassword" placeholder="phone number" value="<?php echo $row['pno']; ?>"required>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label" for="inputPassword">User Email:</label>
                                            <div class="controls">
                                                <input type="email" name="email" id="inputPassword" placeholder="Email" value="<?php echo $row['email']; ?>">
                                            </div>
                                        </div>
                                        

                                
                                <div class="control-group">
                                    <div class="controls">

                                        <button type="submit" name="save" class="btn btn-info"><i class="icon-save icon-large"></i>&nbsp;Update</button>
                                    </div>
                                </div>
                            
							</form>

                            <?php
                            if (isset($_POST['save'])) {
                                
                                $firstname = clean($conn,$_POST['firstname']);
                                $lastname = clean($conn,$_POST['lastname']);
                               
                               $un = clean($conn,$_POST['un']);
                               $p = clean($conn,$_POST['p']);
$p2=md5($p);
                                $pno = clean($conn,$_POST['pno']);
								$email = clean($conn,$_POST['email']);
								
								
			
			
			
			mysqli_query($conn,"update user set username='$un',password='$p2', firstname='$firstname',lastname='$lastname',email='$email' ,pno='$pno' where user_id='$get_id'
			")or die(mysqli_error($conn));

                                header('location:user.php');
                            }
                            ?>
                        </div>

                    </div>
                </div>
                <?php include('footer.php'); ?>
            </div>
        </div>
    </div>





</body>
</html>


