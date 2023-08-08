<?php include('header.php'); ?>
<?php include('session.php'); ?>
<?php include('functions.php'); ?>
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
                      <?php  include('side_nav.php')  ?>
                    <?php include"msg.php"?>
                    <div class="span12" style="border:1px; width:88%; margin-left:22%; margin-top:-410px;">
                    
                        <!--slider-->
                        <form method="get" action="list.php">
                <button class="btn btn-success" type="submit" name="send"><i class="icon-plus-sign icon-large"></i>&nbsp;Export to Excel</button> 
                <?php if(isset($_GET['send'])){?>
                <input type="hidden" value="<?php echo $_GET['subject'] ?>" name="subject" >
                <input type="hidden" value="<?php echo $_GET['mode'] ?>" name="mode" >
                 
                <?php }?>
               
                </form> 
                <div class="hero-unit-3">
                <?php if(isset($msg)){?>
							
							<div class="alert alert-danger"><i class="icon-save"></i>			
							<?php echo $msg;?></div>
                            <?php 
							}                           
                               ?>                           
                              <div class="alert alert-info">
                        
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong><i class="icon-user icon-large"></i>&nbsp;Student Reports</strong>                      </div> 
                           <div class="control-group">
                           <form action="" method="get" name="frm">
                                               
                                                <div class="controls">
           
                       
                                                     <select name="subject"  required>
                                           <option value="">Please select subject</option>
                                           <?php
                                         $sel=mysqli_query($conn,"select * from subject order by subject_title asc");
                                          while($row=mysqli_fetch_assoc($sel))
                                        {
?>
                               <option value="<?php echo $row['subject_id']  ?>"><?php echo $row['subject_title']  ?></option>
                                   <?php
                                         }

?>
                                        </select>
                                         <select name="mode"  required>
                                          <option value="">Please select mode of study</option>
                                           <option value="1"> Fulltimers</option> 
                                           <option value="2">Distance leaners</option> 
                                            <option value="4">Masters</option> 
                                          <option value="3">All modes</option> 
</select>
                                        <button type="submit" style="margin-top:-7px;" name="send" class="btn btn-success"><i class="icon-list-alt icon-large"></i>Display</button>
                                       
                             
                  </form>
                  </div></div>
                 <?Php
                  if(isset($_GET['send']))
{
$thisub=$_GET['subject'];
$sh=mysqli_query($conn,"select * from subject where subject_id='$thisub'");
$subn=mysqli_fetch_assoc($sh);
{?>
<div class="alert alert-info">
                        
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong><i class="icon-user icon-large"></i>&nbsp;Showing &nbsp;<font color="green"><?php if($_GET['mode']==1) echo "Fulltime";if($_GET['mode']==2) echo "Distance" ?></font>&nbsp; Students doing<font color="green" >&nbsp; <?php echo $subn['subject_title'] ?>&nbsp;</font><?php if(checksem()==1) echo "Jan-June"; else echo "July-Dec" ?>&nbsp; Semester &nbsp;<?php  echo date('Y')?></strong>                      </div> 
                           <?php }} ?>
                
          <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example" >
                    
                                         
                                                
                                 <thead>
                                 <tr>
                                <th>No</th>
                               <th>StudentID</th>
<th>Lastname</th>
                              <th>Firstname</th>
                              
                                <th>Mode</th>
                                  <th>Prog</th>
                                  <th>Year</th>
                                  <th>Sem</th>
                                  <th>Phone</th>
                                  <th>Email</th>
                                  <th>Gender</th>
                                                                  
                   </tr>
                    </thead>
                        <tbody>   
                           <!-- end script -->
                          
                            <?php include('studlic.php'); ?>
                           
                          <!-- user delete modal -->
                            
                        </tbody>
                  </table>
                 
                    <!-- end slider -->
                </div>
            </div>
                        
                                 
                </div>
                
                <?php  include('footer.php'); ?>
            </div>

        </div>
    </div>





</body>
</html>