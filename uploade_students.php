<?php
include('session.php');
include('header.php');
include('functions.php');
$user_query = mysqli_query($conn, "select * from teacher where teacher_id='$session_id'") or die(mysqli_error($conn));
$user_row = mysqli_fetch_array($user_query);

//$course_row = mysqli_fetch_array($course_query);
//$get_id = $_GET['id'];
set_include_path(get_include_path() . PATH_SEPARATOR . 'Classes/');
include 'PHPExcel/IOFactory.php';

// This is the file path to be uploaded.
if (isset($_POST['Upload'])) { // if isset open
    if ($_FILES["d"]["error"] > 0) { //open
        $msg = "Return Code: " . $_FILES["d"]["error"] . "<br />";
    } //closed
    else { //open second
        if (file_exists($_FILES["d"]["name"])) { //open
            unlink($_FILES["d"]["name"]);
        } //closed
        $filename = basename($_FILES['d']['name']);
        $newname = "students/" . $filename;
        if (file_exists($newname)) { //open
            $msg = "file already exist in the directory";
        } //closed
        else { // open no file in direc
//Attempt to move the uploaded file to it's new place
            if ((move_uploaded_file($_FILES['d']['tmp_name'], $newname))) { //open if uploaded
                $inputFileName = $newname;
                try { //open
                    $objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
                } //closed
                catch (Exception $e) { //open
                    die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . $e->getMessage());
                } //closed


                $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
                $arrayCount = count($allDataInSheet); // Here get total count of row in that Excel sheet

                $y = date('Y');
                $ss = checksem();
                for ($i = 2; $i <= $arrayCount; $i++) { //open for
                    $reg = clean($conn, trim($allDataInSheet[$i]["F"]));
                    $fn = clean($conn, trim($allDataInSheet[$i]["B"]));
                    $ln = clean($conn, trim($allDataInSheet[$i]["A"]));
                    //$middle = trim($allDataInSheet[$i]["D"]);
                    $phone = clean($conn, trim($allDataInSheet[$i]["L"]));
                    $email = clean($conn, trim($allDataInSheet[$i]["M"]));
                    $address = clean($conn, trim($allDataInSheet[$i]["K"]));
                    $birth = clean($conn, trim($allDataInSheet[$i]["G"]));
                    $gender = clean($conn, trim($allDataInSheet[$i]["D"]));
                    $j_in_year = clean($conn, trim($allDataInSheet[$i]["H"]));
                    $c_sem = clean($conn, trim($allDataInSheet[$i]["I"]));
                    $mode = clean($conn, trim($allDataInSheet[$i]["E"]));
                    $qualif = clean($conn, trim($allDataInSheet[$i]["N"]));
                    $city = clean($conn, trim($allDataInSheet[$i]["O"]));
                    $nation = clean($conn, trim($allDataInSheet[$i]["P"]));
                    $program = clean($conn, trim($allDataInSheet[$i]["C"]));
                    //$depart = trim($allDataInSheet[$i]["Q"]);
                    $sponsor = clean($conn, trim($allDataInSheet[$i]["Q"]));
                    $srelation = clean($conn, trim($allDataInSheet[$i]["R"]));
                    $sphone = clean($conn, trim($allDataInSheet[$i]["S"]));
                    $semail = clean($conn, trim($allDataInSheet[$i]["T"]));
                    $admyear = clean($conn, trim($allDataInSheet[$i]["V"]));
                    $sadd = clean($conn, trim($allDataInSheet[$i]["U"]));
                    $curreny_year = clean($conn, trim($allDataInSheet[$i]["J"]));

                    $z = mysqli_query($conn, "select * from course where course_id='$program'");
                    $mydep = mysqli_fetch_array($z);
                    $dp = $mydep['department'];
                    $s = mysqli_query($conn, "select * from student where student_id='" . $reg . "'") or die(mysqli_error($conn));
                    if (mysqli_num_rows($s) > 0) {
                        $msg = "some students are already registered cant contnue" . $reg;

                    } else {
                        $insertTable = mysqli_query($conn, "insert into student (firstname,lastname,cys,student_id,stud_email,birth_date,stud_address,gender,sponsor,stud_pnone,spo_email,mode,town,nation,sp_relation,addm_year,sem,current_sem,system_sem,sp_address,spo_phone,joined_in,stud_current_year,dept,qualif,update_year) values('" . $fn . "','" . $ln . "','" . $program . "','" . $reg . "','" . $email . "','" . $birth . "','" . $address . "','" . $gender . "','" . $sponsor . "','" . $phone . "','" . $semail . "','" . $mode . "','" . $city . "','" . $nation . "','" . $srelation . "','" . $admyear . "','1','" . $c_sem . "','$ss','" . $sadd . "','" . $sphone . "','" . $j_in_year . "','" . $curreny_year . "','$dp','" . $qualif . "','$y')") or die(mysqli_error($conn));
                    } //closed
                } //close for
                $msg = 'details uploaded. ';
            }
        } //close no file in direc
    } //close second
} //if isset closed
$subjects = mysqli_query($conn, "select * from subject where teacher_id='$session_id'") or die(mysqli_error($conn));
?>

<body>
<div class="row-fluid">
        <div class="span12" >
    <?php include('navbar.php'); ?>

    <div class="container">
        <div class="row-fluid">
            <div class="span3">
                <div class="hero-unit-3">
                    <div class="alert-index alert-success">
                        <i class="icon-calendar icon-large"></i>
                        <?php
                        $Today = date('y:m:d');
                        $new = date('l, F d, Y', strtotime($Today));
                        echo $new;
                        ?>
                    </div>
                </div>
                <div class="hero-unit-1">
                    <ul class="nav  nav-pills nav-stacked">
                        <li class="nav-header">Links</li>
                        <li>
                            <a href="home.php"><i class="icon-home icon-large"></i>&nbsp;Home
                                <div class="pull-right">
                                    <i class="icon-double-angle-right icon-sm"></i>
                                </div>  
                            </a>

                        </li>
                        <li class="dropdown">
                        <?php if (($l == 1) or $l == 2) { ?>
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-list-alt icon-large"></i>&nbsp;Reports
                             <?php } else { ?>
                                <a href="#" onClick="alert('ACCESS DENIED')"><i class="icon-list-alt icon-large"></i>&nbsp;Reports
                            <?php } ?>
                                <div class="pull-right">
                                    <i class="icon-double-angle-right icon-sm"></i>
                                </div>  
                            </a>
                            <ul class="dropdown-menu" style="margin-left:103%; margin-top:-15%;">
                             <li> <a href="reports.php">Exam</a>   </li>
                             <li><a href="financials.php">Financial</a></li>
                              <li><a href="studentrepo.php">Students</a></li>
                              <li><a href="exp.php">Expenditure</a></li>
                               <li><a href="feez.php">Fees</a></li>
                            </ul>
                            
                            </li>                                                      
                              <li>
                              <?php if (($l == 1) or $l == 2) { ?>
                                <a href="settings.php"><i class="icon-group icon-large"></i>&nbsp;Settings
                            <?php } else { ?>
                                <a href="#" onClick="alert('ACCESS DENIED')"><i class="icon-group icon-large"></i>&nbsp;Settings
                            <?php } ?>
                                <div class="pull-right">
                                    <i class="icon-double-angle-right icon-sm"></i>
                                </div>  
                            </a></li>
                            <li>
                            <?php if (($l == 1) or ($l == 2) or ($l == 6)) { ?>
                                <a href="results.php"><i class="icon-group icon-large"></i>&nbsp;Student results
                             <?php } else { ?>
                                <a href="#" onClick="alert('ACCESS DENIED')"><i class="icon-group icon-large"></i>&nbsp;Student results
                            <?php } ?>
                                <div class="pull-right">
                                    <i class="icon-double-angle-right icon-sm"></i>
                                </div>  
                            </a></li>
                            
 <li>
                            <a href="#a"  data-toggle="modal" ><i class="icon-group icon-large"></i>&nbsp;Update account 
                                <div class="pull-right">
                                    <i class="icon-double-angle-right icon-sm"></i>
                                </div>  
                            </a> </li>
                            <!-- user delete modal -->
                                    <div id="a" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-header">
                                        </div>
                                        <form class="form-horizontal" method="post">
                                        <div class="modal-body">
                                            <div class="alert alert-danger">Update password</div>
                                            
                                            
                                             
                                             <label> Password:<input type="text" name="pass" id="inputEmail"  value="<?php echo $us['password'] ?>" required></label>
                                             Confirm: &nbsp;&nbsp;<input type="text" name="pass2" id="inputEmail"  required>
                                            
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn" data-dismiss="modal" aria-hidden="true"><i class="icon-remove icon-large"></i>&nbsp;Close</button>
                                            <button type="submit" name="go" class="btn btn-info"><i class="icon-signin icon-large"></i>&nbsp;Update</button>
                                        </div>
                                    </div>
                                     </form>
                                    <!-- end delete modal --> 
                                     <?php include('update.php'); ?>
                                      <li> 
                                       <?php if (($l == 1) or ($l == 2) or ($l == 6)) { ?>
                                <a href="transcript.php"><i class="icon-book icon-large"></i></i>&nbsp;Genarate Transcripts
                             <?php } else { ?>
                                <a href="#" onClick="alert('ACCESS DENIED')"><i class="icon-group icon-large"></i>&nbsp;Genarate Transcripts
                            <?php } ?>
                                <div class="pull-right">
                                    <i class="icon-double-angle-right icon-sm"></i>
                                </div>  
                            </a></li>
                            <li>
                           
                            <?php if (($l == 1) or ($l == 2) or ($l == 3) or ($l == 4)) { ?>
                                <a href="../teacher_home.php"><i class="icon-group icon-large"></i>&nbsp;Enter Grades
                               <?php } else { ?>
                                <a href="#" onClick="alert('ACCESS DENIED')"><i class="icon-group icon-large"></i>&nbsp;Enter Grades
                            <?php } ?>
                                <div class="pull-right">
                                    <i class="icon-double-angle-right icon-sm"></i>
                                </div>  
                            </a></li>
                            
                    </ul>
                </div>

            </div>
            <div class="span9">
              
               
                 <a href="studentsuploadtemp.xlsx" class="btn btn-success" style="margin-top: 28px;position:absolute"><i class="icon-list icon-large" ></i>&nbsp;Download Upload Template</a> 
                <div class="hero-unit-3" style="margin-top: 85px;">
                    <div class="alert alert-info">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong><i class="icon-upload-alt icon-large"></i>&nbsp;Upload A File</strong>
                    </div>


                    <form class="form-horizontal" action=" " method="post" enctype="multipart/form-data" >
                        <div class="control-group">
                            <label class="control-label" for="inputEmail">File</label>
                            <div class="controls">
                               <input type="file" name="d" class="input-xlarge" required> 
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="controls">

                                <button name="Upload" type="submit" value="Upload" class="btn" /><i class="icon-upload-alt"></i>&nbsp;Upload</button>
                                <br><br>
                                 <?php if (isset($msg)) { ?>
                
                    
                                        <div class="alert alert-info" style="margin-left:-120px;"><strong style="color:#FF0000" ><?php echo $msg; ?></strong>
                                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                                        </div>
                               
                                   <?php } ?>
               
                            </div>
                        </div>
                    </form>
                    <!-- end slider -->
                </div>
            </div>

        </div>
        <?php include('footer.php'); ?>
    </div>
</div>
</div>






</body>
</html>


