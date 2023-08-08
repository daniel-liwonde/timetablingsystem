<?php include('session.php');
include('header.php');
include('functions.php');
if (isset($_POST['publish'])) {
    $pyear = $_POST['pyear'];
    $psem = $_POST['psem'];
    mysqli_query($conn, "update publish_results set year='$pyear', sem='$psem'") or die(mysqli_error($conn));
    $p = "exams for" . $pyear . " " . "semester" . $psem . " " . "Published";
} //end 
if (isset($_POST['cancelp'])) {
    mysqli_query($conn, "update publish_results set year=0, sem=0") or die(mysqli_error($conn));
    $rev = "publish revolked! ";
}

if (isset($_POST['grant'])) {
    $query = mysqli_query($conn, "select * from access_previous") or die(mysqli_error($conn));
    if (mysqli_num_rows($query) == 0) {
        mysqli_query($conn, "insert into  access_previous (status) values('1')") or die(mysqli_error($conn));
        $grant = "Access granted";
    } else {
        mysqli_query($conn, "update access_previous set status=1") or die(mysqli_error($conn));
        $grant = "Access granted";
    }
} //end 
if (isset($_POST['ungrant'])) {
    mysqli_query($conn, "update access_previous set status=0 ") or die(mysqli_error($conn));
    $ungrant = "Access ungranted";
} //end 

if (isset($_POST['save1'])) {
    $num = $_POST['num'];
    $query = mysqli_query($conn, "select * from maxcourse_no") or die(mysqli_error($conn));
    if (mysqli_num_rows($query) == 0) {
        mysqli_query($conn, "insert into maxcourse_no(max_No) values('$num')");
        $msg = " Max course No set to" . $num;
    } else {
        mysqli_query($conn, "update maxcourse_no set max_No='$num' ");
        $msg = " max courseNo updated to" . $num;
    }
}

if (isset($_POST['qsave'])) {
    $num = $_POST['qname'];
    $ss = mysqli_query($conn, "select * from qualification where q='$num'");
    if (mysqli_num_rows($ss) > 0)
        $qmsg = $num . "already added";
    else
        $query = mysqli_query($conn, "insert into qualification(q) values('$num')") or die(mysqli_error($conn));

    $qmsg = $num . "Added";
}



if (isset($_POST['save2'])) {
    $dis = $_POST['dis'];
    $full = $_POST['full'];
    $biu = $_POST['biu'];
    $nobiu = $_POST['nobiu'];
    $year = $_POST['year'];
    $sem = $_POST['sem'];
    $query = mysqli_query($conn, "select * from student_fee_amounts where year=$year and sem=$sem") or die(mysqli_error($conn));
    if (mysqli_num_rows($query) == 0) {
        mysqli_query($conn, "insert into student_fee_amounts(distance,fulltime,biu,nobiu,year,sem) values('$dis','$full','$biu','$nobiu',      '$year','$sem')");
        $msg2 = "Distance fees set to MWK " . $dis . "and full time fees to MWK" . $full . "for year" . $year . "Sem" . $sem;
    } else {
        mysqli_query($conn, "update student_fee_amounts set fulltime='$full', distance='$dis',biu='$biu',nobiu='$nobiu' where year=$year and sem=$sem");
        $msg2 = "Distance fees updated to MWK " . number_format($dis) . " " . "Full time MWK " . number_format($full) . "Masters(Non BIU)&nbsp;" . number_format($nobiu) . " " . "Masters(BIU) MWK " . number_format($biu) . "for year" . $year . "Sem" . $sem;
    }
}

if (isset($_POST['save5'])) {
    $day = getdate();
    $set_date = $day['yday'];
    $close = $_POST['close'];
    $days = $set_date + $close;
    $grade = $_POST['mark'];
    $sem = checksem();
    $y = date('Y');
    $query = mysqli_query($conn, "select * from closing_dates where id='$grade'") or die(mysqli_error($conn));
    if (mysqli_num_rows($query) == 0) {
        mysqli_query($conn, "insert into closing_dates(id,day,year,sem) values('$grade','$days','$y','$sem')") or die(mysqli_error($conn));
        if ($grade == 1)
            $test = "assignment#1";
        elseif ($grade == 2)
            $test = "assignment#2";
        else
            $test = "EOS";
        $msg5 = $test . " Grade entry closing date set to" . $close . "days from now";
    } else {
        mysqli_query($conn, "update closing_dates set day='$days', year='$y',sem='$sem' where id='$grade'") or die(mysqli_error($conn));
        if ($grade == 1)
            $test = "assignment#1";
        elseif ($grade == 2)
            $test = "assignment#2";
        else
            $test = "EOS";
        $msg5 = $test . " Grade entry closing date set to" . $close . "days from now";
    }
}


if (isset($_POST['save4'])) {
    $from = $_POST['from'];
    $to = $_POST['to'];
    $class = $_POST['class'];
    $query = mysqli_query($conn, "select * from transcript_class where class='$class'") or die(mysqli_error($conn));
    if (mysqli_num_rows($query) == 1) {

        mysqli_query($conn, "update transcript_class set frm='$from', t='$to', class='$class' where class='$class'") or die(mysqli_error($conn));
        $msg4 = "updated";
    } else {
        mysqli_query($conn, "insert into transcript_class(frm,t,class) values('$from','$to','$class')") or die("error occoured" . mysqli_error($conn));
        $msg4 = "class added";
    }
}

if (isset($_POST['msave4'])) {
    $mfrom = $_POST['mfrom'];
    $mto = $_POST['mto'];
    $mclass = $_POST['mclass'];
    $mquery = mysqli_query($conn, "select * from transcript_class_masters where class='$mclass'") or die(mysqli_error($conn));
    if (mysqli_num_rows($mquery) == 1) {

        mysqli_query($conn, "update transcript_class_masters set frm='$mfrom', t='$mto', class='$mclass' where class='$mclass'") or die(mysqli_error($conn));
        $mmsg4 = "updated";
    } else {
        mysqli_query($conn, "insert into transcript_class_masters(frm,t,class) values('$mfrom','$mto','$mclass')") or die("error occoured" . mysqli_error($conn));
        $mmsg4 = "class added";
    }
}

if (isset($_POST['save3'])) {
    //$day=getdate();
    $set_date = 1;
    $interest = $_POST['interest'];
    $int = $interest / 100;
    $perday = $int / 365;
    $query = mysqli_query($conn, "select * from interest") or die(mysqli_error($conn));
    if (mysqli_num_rows($query) == 1) {

        mysqli_query($conn, "update interest set amount='$perday' ,year_day='$set_date'") or die(mysqli_error($conn));
        $msg3 = " interest updated to<font color='blue'>" . " " . $int . " " . "</font>percent per year&nbsp; translating to<font color='blue'> MWK" . $perday . "</font>per each overdue day";
    } else {
        mysqli_query($conn, "insert into interest(amount,year_day) values('$int','$set_date')") or die("error occoured" . mysqli_error($conn));
        $msg3 = "interest added to" . " " . $int . " " . "percent";
    }
}

if (isset($_POST['cancel'])) {
    $cmark = $_POST['cmark'];
    mysqli_query($conn, "update closing_dates set day='',sem='', year='' where id='$cmark'") or die(mysqli_error($conn));
    if ($cmark == 1)
        $test = "assignment#1";
    elseif ($cmark == 2)
        $test = "assignment#2";
    else
        $test = "EXAM";
    $cancel = $test . " Grade entry closing date Cancelled";
}
if (isset($_POST['add'])) {
    $item = mysqli_query($conn, "select * from budget_items ") or die(mysqli_error($conn));
    $no = mysqli_num_rows($item);

    $item_available = mysqli_query($conn, "select * from budget_items where item='$_POST[item]'") or die(mysqli_error($conn));
    if (mysqli_num_rows($item_available) > 0)
        $msgitem = "item already added";
    else {
        if ($no == 0)
            $ino = 1;
        else {
            $ino = 1;
            while ($lok = mysqli_fetch_array($item)) {
                $nos = $lok['id'];
                if ($nos != $ino)
                    $ino = $ino;
                else
                    $ino++;
            }
        }
        mysqli_query($conn, "insert into budget_items(id,item,description ) values('$ino','$_POST[item]','$_POST[desc]')") or die(mysqli_error($conn));
        $msgitem = "item added";
    }
}
if (isset($_POST['deactive'])) {
    mysqli_query($conn, "update interest set year_day='2'") or die(mysqli_error($conn));
    $x = "Interest facility deactivated";
}
if (isset($_POST['active'])) {
    mysqli_query($conn, "update interest set year_day='1'") or die(mysqli_error($conn));
    $x = "Interest facility activated";
}
$mm = mysqli_query($conn, "select * from interest") or die(mysqli_error($conn));
$status = mysqli_fetch_array($mm);
if (isset($_POST['set'])) {
    $y = $_POST['year'];
    $sm = $_POST['smonth'];
    $em = $_POST['emonth'];
    $sdate = $_POST['sdate'];
    $edate = $_POST['edate'];
    $y = $_POST['year'];
    $sels = mysqli_query($conn, "select * from sems") or die(mysqli_error($conn));
    if (mysqli_num_rows($sels) > 0) {
        mysqli_query($conn, "update sems set start_month='$sm',start_date='$sdate', sem_year='$y',end_moth='$em',end_date='$edate'") or die(mysqli_error($conn));
        $set = "Semester settings updated";
    } else {
        mysqli_query($conn, "insert into sems(start_month,end_moth,sem_year,start_date,end_date) values('$sm','$em','$y','$sdate','$edate')") or die(mysqli_error($conn));
        $set = "Semester settings set";
    }
}
if (isset($_POST['set2'])) {
    $x = mysqli_query($conn, "select * from agree") or die(mysqli_error($conn));
    if (mysqli_num_rows($x) == 0) {
        mysqli_query($conn, "insert into agree(x) values('1')") or die(mysqli_error($conn));
        ?>
        <script>
        alert("Done")
        </script>
        <?php
    } else {
        mysqli_query($conn, "update agree set x='1'") or die(mysqli_error($conn));
        ?>
        <script>
        alert("Updated")
        </script>
        <?php
    }
}
if (isset($_POST['set1'])) {
    mysqli_query($conn, "update agree set x='0'") or die(mysqli_error($conn));
    ?>
    <script>
    alert("updated")
    </script>
    <?php
}
if (isset($_POST['deactive2'])) {
    mysqli_query($conn, "update allowmo set uid='0'") or die(mysqli_error($conn));
    $xf = "more deactivated";
}
if (isset($_POST['active1'])) {
    mysqli_query($conn, "update allowmo set uid='1'") or die(mysqli_error($conn));
    $xf = "more activated";
}
if (isset($_POST['deactive3'])) {
    mysqli_query($conn, "update grade set entry='0'") or die(mysqli_error($conn));
    $xf2 = "grade entry deactivated";
}
if (isset($_POST['active4'])) {
    mysqli_query($conn, "update grade set entry='1'") or die(mysqli_error($conn));
    $xf2 = "entry activated";
}
if (isset($_POST['deactive7'])) {
    $sels = mysqli_query($conn, "select * from allow_temp_down") or die(mysqli_error($conn));
    if (mysqli_num_rows($sels) > 0) {
        mysqli_query($conn, "update allow_temp_down set status='0'") or die(mysqli_error($conn));
        $down = "download  deactivated";
    } else {
        mysqli_query($conn, "insert into allow_temp_down(status) values(1)") or die(mysqli_error($conn));
        $down = "download  deactivated";
    }
}
if (isset($_POST['active7'])) {
    mysqli_query($conn, "update allow_temp_down set status='1'") or die(mysqli_error($conn));
    $down = "download activated";
}
?>
<style>
.x{font-size:14px; color:#FF0000}
.m{font-size:14px}
</style>
<body onLoad="StartTimers();" onmousemove="ResetTimers();">
   <div class="row-fluid">
   <div class="span12">

            <?php include 'navbar.php'; ?>
            <div class="container">
                <div class="row-fluid">
                <div class="hero-unit-3" style="width:18.5%">
                    <div class="alert-index alert-success">
                        <i class="icon-calendar icon-large"></i>
                        <?php
                        $Today = date('y:m:d');
                        $new = date('l, F d, Y', strtotime($Today));
                        echo $new;
                        ?>
                    </div>
                </div>
                   <div class="hero-unit-1" style="width:20%">
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
                        
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-list-alt icon-large"></i>&nbsp;Reports
                             
                                <div class="pull-right">
                                    <i class="icon-double-angle-right icon-sm"></i>
                                </div>  
                            </a>
                            <ul class="dropdown-menu" style="margin-left:103%; margin-top:-15%;">
                             <li><?php if (($l == 1) or ($l == 2) or ($l == 9) or ($l == 3)) { ?><a href="reports.php">Exam</a>   </li>
<?php } else { ?>
     <li><a href="#" onClick="alert('ACCESS DENIED')">Exam</a>   </li>
                            <?php } ?>
 <li><?php if (($l == 1) or ($l == 2) or ($l == 9) or ($l == 3)) { ?><a href="ts.php">Teacher-subjects</a>   </li>
<?php } else { ?>
     <li><a href="#" onClick="alert('ACCESS DENIED')">Teacher-subjects</a>   </li>
                            <?php } ?>
                             <li><?php if (($l == 1) or ($l == 2) or ($l == 9)) { ?><a href="financials.php">Financial</a></li>
<?php } else { ?>
     <li><a href="#" onClick="alert('ACCESS DENIED')">Financials</a>   </li>
                            <?php } ?>
                              <li><a href="studentrepo.php">Students</a></li>
                              <li><?php if (($l == 1) or ($l == 2) or ($l == 9)) { ?><a href="exp.php">Expenditure</a></li>
                               <?php } else { ?>
     <li><a href="#" onClick="alert('ACCESS DENIED')">Expenditure</a>   </li>
                            <?php } ?>
                               <li><?php if (($l == 1) or ($l == 2) or ($l == 9) or ($l == 8) or ($l == 10) or ($l == 7) or ($l == 6)) { ?><a href="feez.php">Fees</a></li>
<?php } else { ?>
     <li><a href="#" onClick="alert('ACCESS DENIED')">Fees</a></li>
                            <?php } ?>
                            </ul>
                            
                            </li>                                                      
                              <li class="active">
                              <?php if (($l == 1) or ($l == 2) or ($l == 9)) { ?>
                                <a href="settings.php"><i class="icon-group icon-large"></i>&nbsp;Settings
                            <?php } else { ?>
                                <a href="#" onClick="alert('ACCESS DENIED')"><i class="icon-group icon-large"></i>&nbsp;Settings
                            <?php } ?>
                                <div class="pull-right">
                                    <i class="icon-double-angle-right icon-sm"></i>
                                </div>  
                            </a></li>
<li class="dropdown">
                        <?php if (($l == 1) or ($l == 2) or ($l == 6) or ($l == 9) or ($l == 7)) { ?>
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-envelope-alt icon-large"></i>&nbsp;Email Results
                             <?php } else { ?>
                                <a href="#" onClick="alert('ACCESS DENIED')"><i class="icon-envelope-alt icon-large"></i>&nbsp;Email Results
                            <?php } ?>
                                <div class="pull-right">
                                    <i class="icon-double-angle-right icon-sm"></i>
                                </div>  
                            </a>
                            <ul class="dropdown-menu" style="margin-left:103%; margin-top:-15%;">
                            <?php
                            while ($row = mysqli_fetch_array($subs)) { ?>
                                <li><a href="sendmail.php?pid=<?php echo $row['course_id'] ?>"><?php echo $row['cys'] ?></a></li>
                            
                             <?php } ?>
                             
                            </ul>
                            
                            </li>     
                            <li>
                             <?php if (($l == 1) or ($l == 2) or ($l == 9)) { ?>
                                <a href="results.php"><i class="icon-group icon-large"></i>&nbsp;Student results
                             <?php } else { ?>
                                <a href="#" onClick="alert('ACCESS DENIED')"><i class="icon-group icon-large"></i>&nbsp;Student results
                            <?php } ?>
                                <div class="pull-right">
                                    <i class="icon-double-angle-right icon-sm"></i>
                                </div>  
                            </a></li>
 <li>
                              <?php if (($l == 9) or ($l == 10) or ($l == 1) or ($l == 2)) { ?>
                                <a href="backup/index.php"><i class="icon-group icon-large"></i>&nbsp;Backup
                              <div class="pull-right">
                                        <i class="icon-double-angle-right icon-sm"></i>
                                    </div> 
                            <?php } ?>
                                 
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
                                       <li class="dropdown">
                        <?php if (($l == 1) or ($l == 2) or ($l == 6) or ($l == 9) or ($l == 7)) { ?>
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-book icon-large"></i>&nbsp;Genarate Transcripts
                             <?php } else { ?>
                                <a href="#" onClick="alert('ACCESS DENIED')"><i class="icon-book icon-large"></i>&nbsp;Genarate Transcripts
                            <?php } ?>
                                <div class="pull-right">
                                    <i class="icon-double-angle-right icon-sm"></i>
                                </div>  
                            </a>
                            <ul class="dropdown-menu" style="margin-left:103%; margin-top:-15%;">
                            
                            <li><a href="transcript.php">Undergraduate</a></li>
                            <li><a href="transcript_masters.php">Masters</a></li>
                            
                             
                             
                            </ul>
                            
                            </li>                
                           <li>
                            <?php if (($l == 1) or ($l == 3) or ($l == 4) or ($l == 9)) { ?>
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
                    <div class="span12" style="float:left; position: relative; margin-left:25%; margin-top:-418px; width:140%">
                        <!--slider-->
                        <div class="span6">
                        <div class="hero-unit-3" style="margin-top:-35px; overflow:auto;">
                        <div class="alert alert-info" >
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>BIU SIMS Settings</strong>&nbsp;This page allows you to make settings to the system. scroll down for more settings options
                </div>
               
                                        <form class="form-horizontal" method="POST">
                                              <fieldset>
                                             <legend>Add budget items  </legend>
                                        <div class="control-group">
                                            <label class="control-label" for="inputEmail"><font color="#0099FF">Item:</font></label>
                                            <div class="controls">
                                                <input type="text" name="item" id="inputEmail"  required placeholder="eg salary,water bill">
                                            </div>
                                        </div>  
                                        <div class="control-group">
                                            <label class="control-label" for="inputEmail"><font color="#0099FF">Description:</font></label>
                                            <div class="controls">
                                                <input type="text" name="desc" id="inputEmail" placeholder="describe the item(optional)">
                                            </div>
                                        </div>
                                        <span class="x"><?php if (isset($msgitem))
                                            echo $msgitem; ?></span>
                                        <div class="control-group">
                                            <div class="controls">
                                              
                                                <button type="submit" name="add" class="btn btn-info"><i class="icon-save icon-large"></i>&nbsp;Save Item</button>
                                            </div>
                                        </div>
                                          </fieldset>
                                    </form>
                                  
                   
                                  
                                    
                                   <font color="#0099FF">  Added items will appear down here</font>
                                    </fieldset>
                                     <div class="alert alert-info" >
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                
                                   <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example" >
                    
                                         
                                                
                                 <thead>
                                 <tr>

                               <th>ID</th>
                               <th>item</th>
                              <th>Description</th>
                                <th>Action</th>
                                                                 
                   </tr>
                    </thead>
                        <tbody>   
                           <!-- end script -->
                          
                           
                           
                          <!-- user delete modal -->
                           <?php include('bline_item.php'); ?>
                          <!-- end enter modal -->
                        </tbody>
                  </table>
                 </div>
                 <fieldset> 
                        <legend>Maxmum No of courses per student
                        <form class="form-horizontal" method="POST">
                                        <div class="control-group">
                                            <label class="control-label" for="inputEmail"><font color="#0099FF">Number</font></label>
                                            <div class="controls">
                                                <input type="text" name="num" id="inputEmail"  required style="width:40px"> 
                                            </div>
                                        </div>
                                          </legend>
                                        <div class="control-group">
                                            <div class="controls">
                                              
                                                <button type="submit" name="save1" class="btn btn-info"><i class="icon-save icon-large"></i>&nbsp;Save</button>
                                            </div>
                                        </div>
                                        <span class="x"><?php if (isset($msg))
                                            echo $msg; ?></span>
                                    </form>
                                    
                                    </fieldset>
                                    
                                     <fieldset> 
                        <legend>Qualifications
                        <form class="form-horizontal" method="POST">
                                        <div class="control-group">
                                            <label class="control-label" for="inputEmail"><font color="#0099FF">Qualification name</font></label>
                                            <div class="controls">
                                                <input type="text" name="qname" id="inputEmail"  required > 
                                            </div>
                                        </div>
                                          </legend>
                                        <div class="control-group">
                                            <div class="controls">
                                              
                                                <button type="submit" name="qsave" class="btn btn-info"><i class="icon-save icon-large"></i>&nbsp;Save</button>
                                            </div>
                                        </div>
                                        <span class="x"><?php if (isset($qmsg))
                                            echo $qmsg; ?></span>
                                    </form>
                                    
                                    </fieldset>
                                    
                                 
                        <fieldset> 
                        <legend>Fees Amounts &nbsp;(<?php echo date('Y'); ?>)
                        <form class="form-horizontal" method="POST">
                                        <div class="control-group">
                                            <label class="control-label" for="inputEmail"></label>
                                            <div class="controls">
                                                <span class="m" style="font-size:14px"> <font color="#0099FF">Distance</font></span><input type="text" name="dis" id="inputEmail"  required style="width:130px"><span class="m"> <font color="#0099FF">Full time</font></span><input type="text" name="full" id="inputEmail"  required style="width:130px">
                                            </div>
                                            <div class="controls">
                                                <span class="m" style="font-size:14px"> <font color="#0099FF">Masters(From BIU)</font></span><input type="text" name="biu" id="inputEmail"  required style="width:130px"><span class="m"> <font color="#0099FF">Masters(Non BIU)</font><input type="text" name="nobiu" id="inputEmail"  required style="width:130px">
                                                <font color="#0099FF"> <br>Year</font></span><input type="text" name="year" id="inputEmail"  required style="width:130px">
                                                <select name="sem"  required ">
                                    
                                            <option value=""> Class Semester </option>
                                             <option value="1">Jan-June </option>
                                              <option value="2">July-Dec </option>
                                               
                                            </select>
                                            
                                            </div>
                                        </div>
                                          </legend>
                                        <div class="control-group">
                                            <div class="controls">
                                              
                                                <button type="submit" name="save2" class="btn btn-info"><i class="icon-save icon-large"></i>&nbsp;Save</button>
                                            </div>
                                        </div>
                                        <span class="x"><?php if (isset($msg2))
                                            echo $msg2; ?></span>
                                    </form>
                                    
                                    </fieldset>
                        <fieldset> 
                        <legend>Late payment interest percentage.<span class="m"></span>&nbsp;<font color="#0099FF">Status:</font><?php $ac = $status['year_day'];
                        if ($ac == 1) { ?> <span class="x">Active</span><?php } else { ?><span class="x">Deactivated</span><?php } ?>
                        <form class="form-horizontal" method="POST">
                                        <div class="control-group">
                                            <label class="control-label" for="inputEmail"><font color="#0099FF">Percent per year:</font></label>
                                            <div class="controls">
                                                <input type="text" name="interest" id="inputEmail" placeholder="eg 42 for 42% per year" required> 
                                            </div>
                                        </div>
                                        <span class="x"><?php if (isset($msg3))
                                            echo $msg3; ?></span>
                                          </legend>
                                          
                                        <div class="control-group">
                                            <div class="controls">
                                              
                                                <button type="submit" name="save3" class="btn btn-info"><i class="icon-save icon-large"></i>&nbsp;Save</button>
                                            </div>
                                        </div>
                                    </form>
                                   
                                   
                                   <form action="" method="post" style="float:left; margin-right:20px">
                                    <button type="submit" name="deactive" class="btn btn-danger"><i class="icon-remove-sign" ></i>&nbsp;Deactivate Interests facility</button>
                                   </form>
                                     <form action="" method="post" style="float:left;">
                                    <button type="submit" name="active" class="btn btn-success"><i class="icon-signin icon-large"  ></i>&nbsp;Activate Interests facility</button>
                                   </form><br>
                                    <span class="x"><?php if (isset($x))
                                        echo $x; ?></span>
                                    </fieldset>
                                    
                       
                        <fieldset> 
                        <legend>Transcripts classfication (Undergraduate)
          <form class="form-horizontal" method="POST">
                                        <div class="control-group">
                                            <label class="control-label" for="inputEmail"></label>
                                            <div class="controls">
     <span class="m"> <font color="#0099FF"> Classification
                                          
                                            <input type="text" name="class" id="textfield" placeholder="eg first class, upper second etc">
                                           
                                           Average Range</font>
                                            <input type="text" name="from" id="inputEmail"  required style="width:40px" placeholder="From">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="to" id="inputEmail"  required style="width:40px" placeholder="To"></span>
                                            </div>
                          </div>
                                          </legend></legend>
<div class="control-group">           <span class="x"><?php if (isset($msg4))
    echo $msg4; ?></span>
                                            <div class="controls">
                                               
                                                <button type="submit" name="save4" class="btn btn-info"><i class="icon-save icon-large"></i>&nbsp;Save</button>
                                            </div>
                                        </div>
                                    </form>
                                    
                                    </fieldset>
                                    
                                    <fieldset> 
                        <legend>Transcripts classfication (Masters)
          <form class="form-horizontal" method="POST">
                                        <div class="control-group">
                                            <label class="control-label" for="inputEmail"></label>
                                            <div class="controls">
     <span class="m"> <font color="#0099FF"> Classification
                                          
                                            <input type="text" name="mclass" id="textfield" placeholder="eg first class, upper second etc">
                                           
                                           Average Range</font>
                                            <input type="text" name="mfrom" id="inputEmail"  required style="width:40px" placeholder="From">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="mto" id="inputEmail"  required style="width:40px" placeholder="To"></span>
                                            </div>
                          </div>
                                          </legend></legend>
<div class="control-group">           <span class="x"><?php if (isset($mmsg4))
    echo $mmsg4; ?></span>
                                            <div class="controls">
                                               
                                                <button type="submit" name="msave4" class="btn btn-info"><i class="icon-save icon-large"></i>&nbsp;Save</button>
                                            </div>
                                        </div>
                                    </form>
                                    
                                    </fieldset>
                               <fieldset> 
                        Clossing date for mark entery from today&nbsp;<font color="#0099FF">(<?php echo date('Y');
                        if (checksem() == 1)
                            echo "&nbsp;January-June Semester";
                        else
                            echo "&nbsp;July-December Semester"; ?>)</font>
                        <form class="form-horizontal" method="POST">
                                        <div class="control-group">
                                            <label class="control-label" for="inputEmail"></label>
                                            <div class="controls">
                                             <span class="m"><font color="#0099FF">Grade</span> <select name="mark" required> 
                                              <option value="">Please select</option>
                                               <option value="1">Assignment1</option>
                                              <option value="2">Assignment2</option>
                                              <option value="3">Exam</option>
                                              </select>
                                                Cossing date: <select name="close" required> 
                                               <option value="">Please select</option>
                                              <option value="1">One day from today</option>
                                               <option value="2">Two days from today</option>
                                               <option value="7">one week from today</option>
                                               <option value="14">Two weeks from today</option>
                                              
                                               </select>
                                            </div>
                                           
                                            </div>
                                            <div class="control-group">
                                            <div class="controls">
                                              
                                                <button type="submit" name="save5" class="btn btn-info"><i class="icon-save icon-large"></i>&nbsp;Save</button>
                                            </div>
                                        </div>
                                        </form>
                                         <span class="x"><?php if (isset($msg5))
                                             echo $msg5; ?></span>
                                         <form class="form-horizontal" method="POST">
                                        <div class="control-group">
                                            <label class="control-label" for="inputEmail">Cancel deadlines</label>
                                            <div class="controls">
                                             <select name="cmark" required> 
                                              <option value="">Please select</option>
                                               <option value="1">Assignment1</option>
                                              <option value="2">Assignment2</option>
                                              <option value="3">Exam</option>
                                              </select>
                                            </div>
                                           
                                            </div>
                                            <div class="control-group">
                                            <div class="controls">
                                              
                                                <button type="submit" name="cancel" class="btn btn-info"></i>&nbsp;Cancel</button>
                                            </div>
                                        </div>
                                        </form>
                                        <span class="x"><?php if (isset($cancel))
                                            echo $cancel; ?></span>
                                          </fieldset>
                                          <fieldset> 
                        <legend>Semester Settings</legend>
                                          <form class="form-horizontal" method="POST" action="">
                                        <div class="control-group">
                                            <label class="control-label" for="inputEmail">First Semester</label>
                                            <div class="controls">
                                             <select name="smonth" required style="width:120px"> 
                                              <option value="">Start Month</option>
                                               <option value="1">January</option>
                                              <option value="2">February</option>
                                              <option value="3">March</option>
                                               <option value="4">April</option>
                                                <option value="5">May</option>
                                                 <option value="6">June</option>
                                                  <option value="7">July</option>
                                                   <option value="8">August</option>
                                                    <option value="9">September</option>
                                                      <option value="10">October</option>
                                                        <option value="11">November</option>
                                                          <option value="12">Decemebr</option>
                                              </select>
                                             
                                              <select name="sdate" required style="width:120px"> 
                                              <option value="">Start Date</option>
                                               <option value="1">01</option>
                                              <option value="2">02</option>
                                              <option value="3">03</option>
                                               <option value="4">04</option>
                                                <option value="5">05</option>
                                                 <option value="6">06</option>
                                                  <option value="7">07</option>
                                                   <option value="8">08</option>
                                                    <option value="9">09</option>
                                                      <option value="10">10</option>
                                                        <option value="11">11</option>
                                                          <option value="12">12</option>
                                                          <option value="13">13</option>
                                                          <option value="14">14</option>
                                                          <option value="15">15</option>
                                                          <option value="16">16</option>
                                                          <option value="17">17</option>
                                                          <option value="18">18</option>
                                                          <option value="19">19</option>
                                                          <option value="20">20</option>
                                                          <option value="21">21</option>
                                                          <option value="22">22</option>
                                                          <option value="23">23</option>
                                                          <option value="24">24</option>
                                                          <option value="25">25</option>
                                                          <option value="26">26</option>
                                                          <option value="27">27</option>
                                                          <option value="28">28</option>
                                                          <option value="29">29</option>
                                                          <option value="30">30</option>
                                                            <option value="31">31</option>
                                              </select>
                                               <select name="emonth" required style="width:120px"> 
                                              <option value="">End Month</option>
                                               <option value="1">January</option>
                                              <option value="2">February</option>
                                              <option value="3">March</option>
                                               <option value="4">April</option>
                                                <option value="5">May</option>
                                                 <option value="6">June</option>
                                                  <option value="7">July</option>
                                                   <option value="8">August</option>
                                                    <option value="9">September</option>
                                                      <option value="10">October</option>
                                                        <option value="11">November</option>
                                                          <option value="12">Decemebr</option>
                                                        
                                              </select>
                                               <select name="edate" required style="width:120px"> 
                                              <option value="">End Date</option>
                                               <option value="1">01</option>
                                              <option value="2">02</option>
                                              <option value="3">03</option>
                                               <option value="4">04</option>
                                                <option value="5">05</option>
                                                 <option value="6">06</option>
                                                  <option value="7">07</option>
                                                   <option value="8">08</option>
                                                    <option value="9">09</option>
                                                      <option value="10">10</option>
                                                        <option value="11">11</option>
                                                          <option value="12">12</option>
                                                          <option value="13">13</option>
                                                          <option value="14">14</option>
                                                          <option value="15">15</option>
                                                          <option value="16">16</option>
                                                          <option value="17">17</option>
                                                          <option value="18">18</option>
                                                          <option value="19">19</option>
                                                          <option value="20">20</option>
                                                          <option value="21">21</option>
                                                          <option value="22">22</option>
                                                          <option value="23">23</option>
                                                          <option value="24">24</option>
                                                          <option value="25">25</option>
                                                          <option value="26">26</option>
                                                          <option value="27">27</option>
                                                          <option value="28">28</option>
                                                          <option value="29">29</option>
                                                          <option value="30">30</option>
                                                            <option value="31">31</option>
                                              </select>
                                               <input type="number" name="year" id="inputEmail" placeholder="Year eg 2016" required style="width:49px"> 
                                            </div>
                                           
                                            </div>
                                            <div class="control-group">
                                            <div class="controls">
                                              
                                                <button type="submit" name="set" class="btn btn-info"></i>&nbsp;Set</button>
                                            </div>
                                        </div>
                                        </form>

                                        <span class="x"><?php if (isset($set))
                                            echo $set;
                                        $sel2 = mysqli_query($conn, "select * from sems") or die(mysqli_error($conn));
                                        $sel = mysqli_fetch_array($sel2);
                                        echo "First semester starts" . $sel['start_date'] . "/" . $sel['start_month'] . "/" . $sel['sem_year'] . "&nbsp;And ends&nbsp" . $sel['end_date'] . "/" . $sel['end_moth'] . "/" . $sel['sem_year'];


                                        ?></span>
                                          </fieldset>
                            <form method="post">              
                       <div class="control-group">
                                            <div class="controls">
                                              
                                                <button type="submit" name="set2" class="btn btn-info"></i>&nbsp;Set</button>

                                            </div>
                                        </div>
                                        </form>

 <form method="post">              
                       <div class="control-group">
                                            <div class="controls">
                                              
                                               
<button type="submit" name="set1" class="btn btn-info"></i>&nbsp;UnSet</button>
                                            </div>
                                        </div>
                                        </form>
<span class="x"><?php if (isset($m2))
    echo $m; ?></span>
 <div class="control-group">
                                                <label class="control-label" for="inputPassword">Grant Access for Past grade Entry</label>
                                                </div>
<form method="post">              
                       <div class="control-group">
                                            <div class="controls">
                                              
                                                <button type="submit" name="grant" class="btn btn-info"></i>&nbsp;Grant acces</button>

                                            </div>
                                        </div>
                                        </form>
                                        
                                         <span class="x"><?php if (isset($grant))
                                             echo $grant; ?></span>
                                        <form method="post">              
                       <div class="control-group">
                                            <div class="controls">
                                              
                                                <button type="submit" name="ungrant" class="btn btn-info"></i>&nbsp;Ungrant</button>

                                            </div>
                                             <span class="x"><?php if (isset($ungrant))
                                                 echo $ungrant; ?></span>
                                        </div>
                                        </form>
                                        <div class="control-group">
                                                <label class="control-label" for="inputPassword">Publish results</label>
                                                <div class="controls">
           <form action="" method="post">
                        
                                       <select  name="pyear"  required style="width:120px">
                                        <option value="">select year</option>
                                        <?php $r = mysqli_query($conn, "select distinct year from results where year<>0") or die(mysqli_error($conn));
                                        while ($a = mysqli_fetch_array($r)) {
                                            ?>
                                              <option> <?php echo $a['year']; ?> </option>
                                              <?php
                                        }
                                        ?>
                                           </select>
                                            
                                       <select name="psem"  required style="width:120px">
                                            <option value="">Report Semester </option>
                                             <option value="1">Jan-June </option>
                                              <option value="2">July-Dec </option>
                                            </select>
                                        <button type="submit" name="publish" class="btn btn-success" ><i class="icon-list-alt icon-large"></i>Publish</button>
                                       
                             
                  </form>
                  <span class="x"><?php if (isset($p))
                      echo $p; ?></span>
                  </div>
                  <form action="" method="post" style="float:left;">
                                    <button type="submit" name="cancelp" class="btn btn-success"><i class="icon-signin icon-large"  ></i>&nbsp;Revoke publish results</button>
                                   </form><br>
                   <span class="x"><?php if (isset($rev))
                       echo $rev; ?></span>
                  </div>
                  <br />
<form action="" method="post" style="float:left;">
                                    <button type="submit" name="active1" class="btn btn-success"><i class="icon-signin icon-large"  ></i>&nbsp;Activate  see more grades facility</button>
                                   </form>
                                    <span class="x"><?php if (isset($xf))
                                        echo $xf; ?></span> &nbsp;&nbsp;&nbsp;
                                    
                                    <form action="" method="post" style="float:left; margin-right:20px">
                                    <button type="submit" name="deactive2" class="btn btn-danger"><i class="icon-remove-sign" ></i>&nbsp;Deactivate  see more grades facility</button>
                                   </form>
                                     
                                    
                                   
                                       <form action="" method="post">
                                    <button type="submit" name="active4" class="btn btn-success"><i class="icon-signin icon-large"  ></i>&nbsp;Activate grades entry</button>
                                   </form>&nbsp;
                                    <span class="x"><?php if (isset($f2))
                                        echo $f2; ?></span>
                                    <form action="" method="post">
                                    <button type="submit" name="deactive3" class="btn btn-danger"><i class="icon-remove-sign" ></i>&nbsp;Deactivate  grades entry facility</button>
                                   </form>
                                     
                                   
                                    <form action="" method="post" style="float:left; margin-right:20px">
                                    <button type="submit" name="active7" class="btn btn-success"><i class="icon-signin ion-large" ></i>&nbsp;Activate grade template download</button>
                                   </form>
                                     <form action="" method="post" style="float:left;">
                                    <button type="submit" name="deactive7" class="btn btn-danger"><i class="icon-remove icon-large"  ></i>&nbsp;Deactivate grade template download</button>
                                   </form><br>
                                    <span class="x"><?php if (isset($down))
                                        echo $down; ?></span>
                                    </fieldset><br><br>
                                    <div class="alert alert-danger">Remove Results</div>
                                    <form class="form-horizontal"  id="export_excel"  method="post" action="">
                        <div class="control-group">
                            <label class="control-label" for="inputEmail"></label>
                            <div class="controls">
                        
                            <select name="sub"    required>
                                            <option value="1">Delete all </option>
                                            <?php
                                            $query = mysqli_query($conn, "select * from subject order by subject_title asc");


                                            while ($row = mysqli_fetch_array($query)) {

                                                ?>
                                                    <option value="<?php echo $row['subject_code']; ?>"><?php echo $row['subject_title']; ?></option>
                                                    <?php
                                            }

                                            ?>
                                        </select>
                                        
                                        <select  name="year" id="year"  style="width:120px"  required>
                                            <option value="<?php echo date('Y') ?>"><?php echo date('Y') ?></option>
                                        <?php $r = mysqli_query($conn, "select distinct year from results where year >1 order by year desc") or die(mysqli_error($conn));
                                        while ($a = mysqli_fetch_array($r)) {
                                            ?>
                                              <option value="<?php echo $a['year']; ?>"> <?php echo $a['year']; ?> </option>
                                              <?php
                                        }
                                        ?>
                                           </select>
                                        
                                       <select name="sem"  id="sem" style="width:120px" required>
                                           <?php if (checksem() == 1) { ?>
                                                <option value="1">January-June</option>
                                                <?php
                                           } else {
                                               ?>
                                                <option value="2">July-Dec</option>
                                            
                                                 <?php
                                           }
                                           ?>
                                              <option value="1">Jan-June</option>
                                               <option value="2">July-Dec</option>
                                            </select>
                                            
                                       <br /> <br>    
                              <input  type="submit"  value="Delete" name="remove" class="form-control btn btn-danger"> 
                              </form>
                             <?php
                             if (isset($_POST['remove'])) {
                                 $sub = $_POST['sub'];
                                 $year = $_POST['year'];
                                 $sem = $_POST['sem'];
                                 if ($sub != 1) {
                                     $querycode = mysqli_query($conn, "select * from subject WHERE subject_code='$sub'") or die(mysqli_error($conn));
                                     $row = mysqli_fetch_assoc($querycode);
                                     $subID = $row['subject_id'];
                                     $query = mysqli_query($conn, "DELETE FROM results WHERE course_code='$sub' AND year='$year' AND sem='$sem'") or die(mysqli_error($conn));
                                     $delteacher_stud = mysqli_query($conn, "DELETE FROM teacher_student WHERE subject_id='$subID' AND year='$year' AND semester='$sem'") or die(mysqli_error($conn));
                                     if ($query && $delteacher_stud)
                                     ?>
                                         <div><?php echo $row['subject_title'] . "Deleted for" . $year . "Semester" . $sem; ?></div>
                                         <?php
                                 } else {
                                     $query = mysqli_query($conn, "DELETE FROM results WHERE  year='$year' AND sem='$sem'") or die(mysqli_error($conn));
                                     $delteacher_stud = mysqli_query($conn, "DELETE FROM teacher_student WHERE  year='$year' AND semester='$sem'") or die(mysqli_error($conn));
                                     if ($query && $delteacher_stud) {
                                         ?>
                                             <div><?php echo "All result Deleted for" . $year . "Semester" . $sem; ?></div>
                                             <?php
                                     } else {
                                         echo "error occoured";
                                     }
                                 }
                             }
                             ?>
                    
                        </div>
                        
                        <!-- end slider -->
                    </div>
               
                </div>
                 <br><br><br>
                
            </div>
            
        </div>
        
    </div>
    <?php include('footer.php'); ?>




</body>
</html>