<?php include('session.php'); ?>
<?php include('header.php'); ?>
<?php include('functions.php'); ?>
<body onLoad="StartTimers();" onmousemove="ResetTimers();">

    <div class="row-fluid">
        <div class="span12">

            <?php include('navbar.php'); ?>

            <div class="container">

                <div class="row-fluid">

                    <div class="span12">
                        <div class="hero-unit-3">
                            <a href="teacher.php" class="btn btn-success"><i class="icon-arrow-left icon-large"></i>&nbsp;Back</a>
                            <br>
                            <br>
                            <?php
							$get_id=$_GET['idd'];
                           $teacher_query=mysqli_query($conn,"select * from teacher where teacher_id='$get_id'")or die(mysqli_error($conn));
                           $row=mysqli_fetch_array($teacher_query);

?>                            
                            <form class="form-horizontal" method="post" enctype="multipart/form-data">
                                
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
                                    <label class="control-label" for="inputEmail">Middle name</label>
                                    <div class="controls">
                                        <input type="text" id="inputEmail" name="middlename" value="<?php echo $row['middlename']; ?>" >
                                    </div>
                                </div>
                                  <div class="control-group">
                                    <label class="control-label" for="inputEmail">Username</label>
                                    <div class="controls">
                                        <input type="text" name="user" value="<?php echo $row['username']; ?>"required>
                                    </div>
                                </div>
                                  <div class="control-group">
                                    <label class="control-label" for="inputEmail">Password</label>
                                    <div class="controls">
                                        <input type="password" id="inputEmail" name="pass" value="<?php echo $row['password']; ?>" required>
                                    </div>
</div>
<div class="control-group">
                                    <label class="control-label" for="inputPassword">Confirm Password</label>
                                    <div class="controls">
                                        <input type="password" name="cpassword" id="inputPassword" placeholder="confirm Password" required>
                                    </div>
                                </div>
                                <div class="control-group">
                                            <label class="control-label" for="inputPassword">Phone Number:</label>
                                            <div class="controls">
                                                <input type="number" name="pno" id="inputPassword" placeholder="phone number" value="<?php echo $row['pno']; ?>" required>
                                               
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label" for="inputPassword">User Email:</label>
                                            <div class="controls">
                                                <input type="email" name="email" id="inputPassword" placeholder="Email" value="<?php echo $row['email']; ?>">
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

                                        <select name="department" class="span4" required>
                                            <option value=""> select department</option>
                                            <?php
                                            $query = mysqli_query($conn,"select * from department");
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

                                        <button type="submit" name="save" class="btn btn-info"><i class="icon-save icon-large"></i>&nbsp;Save</button>
                                    </div>
                                </div>
                            
							</form>

                            <?php
                            if (isset($_POST['save'])) {
                                
                                $firstname = clean($conn,$_POST['firstname']);
                                $lastname = clean($conn,$_POST['lastname']);
                                $middlename  = clean($conn,$_POST['middlename']);
                                $department  = clean($conn,$_POST['department']);
                                $pno  = clean($conn,$_POST['pno']);
                                $user= clean($conn,$_POST['user']);
                                 $pass = md5($_POST['pass']);
								  $cpassword =  md5(clean($conn,$_POST['cpassword']));
								$email = clean($conn,$_POST['email']);
								//$level = 4;
								
	
			
			$sels=mysqli_query($conn,"select * from teacher where username='$user' and teacher_id<>'$get_id'") or die(mysqli_error($conn));
if(mysqli_num_rows($sels)>0){ echo "User name already in use";}
             else{
	        if($cpassword == $pass)
			{		
		$image = clean($conn,addslashes(file_get_contents($_FILES['image']['tmp_name'])));
$image_name= addslashes($_FILES['image']['name']);
	$image_size= getimagesize($_FILES['image']['tmp_name']);

				move_uploaded_file($_FILES["image"]["tmp_name"],"uploads/" . $_FILES["image"]["name"]);			
			$location="uploads/" . $_FILES["image"]["name"];		
			mysqli_query($conn,"update teacher set username='$user',password='$pass',firstname='$firstname',lastname='$lastname',middlename='$middlename',
			department='$department',location='$location',email='$email' ,pno='$pno' where teacher_id='$get_id'
			")or die(mysqli_error($conn));
                                        mysqli_query($conn, "update schedule set lecturerfname='$firstname',lecturerlname='$lastname' WHERE lectid='$get_id'");

                                        echo "<div class='alert alert-success'><i class='fas fa-check-circle fa-lg'></i>&nbsp;Update succeeded! click back to go back to lecturers page</div>";
			 }
							else{
							 ?>
                                                                         
                                   <div class="alert alert-danger"><i class="icon-remove-sign"></i>&nbsp;Password missmatch</div>

                                        <?php		
							}
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


