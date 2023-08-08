<?php include('header.php'); ?>
<?php include('session.php'); ?>
<?php include('functions.php'); ?>
<body onLoad="StartTimers();" onmousemove="ResetTimers();">

    <div class="row-fluid">
        <div class="span12">

            <?php include('navbar.php'); ?>

            <div class="container">

                <div class="row-fluid">
                    <div class="span2" style="margin-top: 50px;">
                        <!-- left nav -->
                        <ul class="nav nav-tabs nav-stacked">

                            <li class="active">
                                <a href="add_user.php"><i class="icon-plus-sign-alt icon-large"></i>&nbsp;Add User</a>
                                <a href="user.php"><i class="icon-arrow-left icon-large"></i>&nbsp;Back</a>
                            </li>


                        </ul>
                        <!-- right nav -->
                    </div>
                    <div class="span10">

					<div class="hero-unit-3">
                        <ul class="thumbnails">
                            <li class="span7">
                                <div class="thumbnail">
                                    <div class="alert alert-info"><i class="icon-plus-sign-alt icon-large"></i>&nbsp;Add User Account</div>

                                    <form class="form-horizontal" method="POST">
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
                                            <label class="control-label" for="inputPassword">FirstName:</label>
                                            <div class="controls">
                                                <input type="text" name="fn" id="inputPassword" placeholder="FirstName" required>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label" for="inputPassword">LastName:</label>
                                            <div class="controls">
                                                <input type="text" name="ln" id="inputPassword" placeholder="LastName" required>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label" for="inputPassword">User Email:</label>
                                            <div class="controls">
                                                <input type="email" name="email" id="inputPassword" placeholder="Email" required>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label" for="inputPassword">Phone Number:</label>
                                            <div class="controls">
                                                <input type="number" name="pno" id="inputPassword" placeholder="phone number" required>
                                            </div>
                                        </div>
                                        
                                        <div class="control-group">
                                            <div class="controls">

                                                <button type="submit" name="save" class="btn btn-info"><i class="icon-save icon-large"></i>&nbsp;Save User</button>
                                            </div>
                                        </div>
                                    </form>

                                    <?php
                                    if (isset($_POST['save'])) {

                                        $un = clean($conn,$_POST['un']);
                                        $p = md5(clean($conn,$_POST['p']));
                                        $fn = clean($conn,$_POST['fn']);
                                        $ln = clean($conn,$_POST['ln']);
										   $ul = 7;
										$email = clean($conn,$_POST['email']);
										$pno = clean($conn,$_POST['pno']);
                                         $query = mysqli_query($conn,"select * from user where username='$un' or email='$email' or pno='$pno'") or die(mysqli_error($conn));
                              $count = mysqli_num_rows($query);
							  if($count==0){
                                        mysqli_query($conn,"insert into user (user_id,username,password,firstname,lastname,email,user_level,pno) values ('$pno','$un','$p','$fn','$ln','$email','$ul','$pno')")or die(mysqli_error($conn));
                                        header('location:user.php');
										}
										else
										{
										?>
                                                                         
                                   <div class="alert alert-danger"><i class="icon-remove-sign"></i>&nbsp;Username phone number or email already registered</div>

                                        <?php
										}
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


