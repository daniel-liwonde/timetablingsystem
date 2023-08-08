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
                   <?php include"side_nav.php"?>
                    <?php include"msg.php"?>
                    <div class="span12" style="border:1px; width:78%; margin-left:22%; margin-top:-410px;">
                    
                        <?php if(($l==1) or ($l==2)or ($l==9)) {?>
                  <form method="get" action="student_courses_export.php" style="float:left">  
                  <?php if (isset($_GET['send'])) { ?>              
                <input type="hidden" value="<?php echo $_GET['sub'] ?>" name="sub" >
               
                 <?php }?>
              <button class="btn btn-success" type="submit" name="send2"><i class="icon-plus-sign icon-large"></i>&nbsp;Export to Word</button>&nbsp;
                </form>
                 <div style="margin-bottom:5px; margin-left:17%;">
                <a href="studentrepo.php" class="btn btn-success"><li class="icon-arrow-left icon-large"></li>&nbsp;Back</a>
               </div>
                <?php }?>
                <div class="hero-unit-3">
                <?php if(isset($msg)){?>
							
							<div class="alert alert-danger"><i class="icon-save"></i>			
							<?php echo $msg;?></div>
                            <?php 
							}                           
                               ?>   
                                <form action="" method="get">                        
                              <div class="alert alert-info">
                        
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong><i class="icon-user icon-large"></i>&nbsp;Student Registered  Courses for <?php if (checksem()==1) echo"Jan-June";
                            else echo "July-Dec  ". date('Y') ?> </strong>                      </div> 
                           <div class="control-group">
                                                
                                                
                                              <div class="controls">
           <form action="" method="get">
                         
                                                     <select name="sub"  required>
                                            <option value=""> Select Programme </option>
                                            <?php
                                            $query = mysqli_query($conn,"select * from course order by course_id asc");
											
                                            while ($row = mysqli_fetch_array($query)) {
                                                ?>
                                                <option value="<?php echo $row['course_id'];?>"><?php echo $row['cys']; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                        
                                       
                                            
                                      
                                                   
                                        <button type="submit" name="send" class="btn btn-success" style="margin-top:-1%" ></i>Show</button>
                                       
                             
                  </form>
                  </div>
                  </div>
                 
          
            <form id="form1">
            <div id="dvContainer1">
          
         <table cellpadding="1" cellspacing="1" border='0' class="table table-striped table-bordered" id="example">
                    
                                         
                                                
                                 <thead>
                                 <tr>
                                     <td>No</td>
                                      <td>Details</td>
                   </tr>
                    </thead>
                        <tbody> 
                        
                           <!-- end script -->
                          
                           <?php include('myCourses.php')  ?>

                           
                          <!-- user delete modal -->
                            
                        </tbody>
                  </table>
               
						</div>
                <input type="button" value="Print Results" id="btnPrint2" class="btn btn-success" />
                </form>
					
				   
				  
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