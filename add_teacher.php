<?php include('session.php'); ?>
<?php include('header.php'); ?>
<?php include('functions.php'); ?>

<body onLoad="StartTimers();" onmousemove="ResetTimers();">

    <div class="row-fluid">
        <div class="span12">

            <?php include('navbar.php'); ?>

            <div class="container">

                <div class="row-fluid">

                    <div class="span12" style="width:107%">
                        <div class="hero-unit-3">
                            <a href="teacher.php" class="btn btn-success"><i
                                    class="icon-arrow-left icon-large"></i>&nbsp;Back</a>
                            <br>
                            <br>
                            <form class="form-horizontal" method="post" enctype="multipart/form-data">

                                <div class="control-group">
                                    <label class="control-label" for="inputEmail">Firstname</label>
                                    <div class="controls">
                                        <input type="text" id="inputEmail" name="firstname" placeholder="Firstname"
                                            required>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="inputEmail">Lastname</label>
                                    <div class="controls">
                                        <input type="text" id="inputEmail" name="lastname" placeholder="Lastname"
                                            required>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="inputEmail">Middlename</label>
                                    <div class="controls">
                                        <input type="text" id="inputEmail" name="middlename" placeholder="Middlename">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="inputEmail">Username</label>
                                    <div class="controls">
                                        <input type="text" id="inputEmail" name="username" placeholder="Username"
                                            required>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="inputPassword">Password</label>
                                    <div class="controls">
                                        <input type="password" name="password" id="inputPassword" placeholder="Password"
                                            required>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="inputPassword">Confirm Password</label>
                                    <div class="controls">
                                        <input type="password" name="cpassword" id="inputPassword"
                                            placeholder="Password" required>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="inputPassword">User Email:</label>
                                    <div class="controls">
                                        <input type="email" name="email" id="inputPassword" placeholder="Email">
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label" for="inputPassword">Phone Number:</label>
                                    <div class="controls">
                                        <input type="number" name="pno" id="inputPassword" placeholder="phone number">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="input01">Image:</label>
                                    <div class="controls">
                                        <input type="file" name="image" class="font">
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label" for="inputPassword">Department:</label>
                                    <div class="controls">

                                        <select name="department" class="span4">
                                            <option></option>
                                            <?php
                                            $query = mysqli_query($conn, "select * from department");
                                            while ($row = mysqli_fetch_array($query)) {
                                                ?>
                                                <option value="<?php echo $row['title']; ?>"><?php echo $row['department']; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <div class="controls">

                                        <button type="submit" name="save" class="btn btn-info"><i
                                                class="icon-save icon-large"></i>&nbsp;Save</button>
                                    </div>
                                </div>

                            </form>

                            <?php
                            if (isset($_POST['save'])) {
                                $username = clean($conn, $_POST['username']);
                                $password = md5(clean($conn, $_POST['password']));
                                $cpassword = md5(clean($conn, $_POST['cpassword']));
                                $firstname = clean($conn, $_POST['firstname']);
                                $lastname = clean($conn, $_POST['lastname']);
                                $middlename = clean($conn, $_POST['middlename']);
                                $department = clean($conn, $_POST['department']);
                                $email = clean($conn, $_POST['email']);
                                $ul = 4;
                                $pno = clean($conn, $_POST['pno']);

                                $query = mysqli_query($conn, "select * from teacher where username='$username'  or email='$email' or pno='$pno'") or die(mysqli_error($conn));
                                $count = mysqli_num_rows($query);
                                if ($count == 0) {
                                    if ($cpassword == $password) {
                                        $image = clean($conn, addslashes(file_get_contents($_FILES['image']['tmp_name'])));
                                        $image_name = addslashes($_FILES['image']['name']);
                                        $image_size = getimagesize($_FILES['image']['tmp_name']);

                                        move_uploaded_file($_FILES["image"]["tmp_name"], "uploads/" . $_FILES["image"]["name"]);
                                        $location = "uploads/" . $_FILES["image"]["name"];
                                        mysqli_query($conn, "insert into teacher (username,password,firstname,lastname,middlename,department,location,email,user_level,pno)
                        values ('$username','$password','$firstname','$lastname','$middlename','$department','$location','$email','$ul','$pno')         
") or die(mysqli_error($conn));
                                        echo '<div class="alert alert-success"><i class="fa fa-check-circle"></i>&nbsp;teacher details already exist or email already registered</div>';

                                    } else {
                                        ?>

                                        <div class="alert alert-danger"><i class="icon-remove-sign"></i>&nbsp;Password missmatch
                                        </div>

                                    <?php
                                    }
                                } else {
                                    ?>

                                    <div class="alert alert-danger"><i class="icon-remove-sign"></i>&nbsp;teacher details
                                        already exist or email already registered</div>

                            <?php
                                }
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