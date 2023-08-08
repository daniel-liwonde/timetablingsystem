<?php include('header.php'); ?>
<?php include('session.php'); ?>
<?php include('functions.php'); ?>
<style>
#x,#y,#sel{width:120px;}

</style>

<body >
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
                    <div class="span12" style="border:1px; width:95%; margin-left:22%; margin-top:-410px;">
                    
                        <!--slider-->
                        <form method="get" action="studrepo_new.php">
						
                <button class="btn btn-success" type="submit" name="send"><i class="icon-plus-sign icon-large"></i>&nbsp;Export to Excel</button>
				<a href="exam_nos.php" class="btn btn-success"><i class="icon-plus-sign icon-large"></i>&nbsp;Exam registers</a>&nbsp;&nbsp;
				<a href="studentrepo.php" class="btn btn-success"><i class="icon-list icon-large"></i>&nbsp;View All Students Report</a>
				<a href="sublist.php" class="btn btn-success"><i class="icon-list icon-large"></i>&nbsp;Subject Student Report</a>
                <?php if(isset($_GET['send'])){?>               
                <input type="hidden" value="<?php echo $_GET['prog'] ?>" name="prog" >
				<input type="hidden" value="<?php echo $_GET['s'] ?>" name="s" >
				<input type="hidden" value="<?php echo $_GET['year'] ?>" name="year" >
                <input type="hidden" value="<?php echo $_GET['mode'] ?>" name="mode" >
                  <input type="hidden" value="<?php echo $_GET['gender'] ?>" name="gender" >
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
                                                <label class="control-label" for="inputPassword">
                                               </label>
                                                <div class="controls">
           
                       <input type="checkbox" name="General" onClick="disable()"  id="y" value="1"> &nbsp;&nbsp;Get general semester year info(Check to get history on who was in which year which semester)<br><br>
                                                    
                                         
                                           <select name="prog" >
                                                  <option  value="all">All programmes</option>   
                                            <?php $r=mysqli_query($conn,"select * from  course order by cys asc") or die(mysqli_error($conn));
										  while($a=mysqli_fetch_array($r)){
										  ?>
										  <option value="<?php echo $a['course_id'];?>"> <?php echo $a['cys'];?> </option>
                                          <?php
										  }
										   ?>
                                            </select>
                                            
                                            
                                           <select name="mode"   id="state"  >
                                            <option value="">Study Mode</option>
                                            
                                             <option value="1">Full time </option>
                                              <option value="2">Distance  </option>
                                               <option value="4">Masters  </option>
                                               <option value="3">Both   </option>
                                            </select>  
                                             <select name="gender"   id="state2" >
                                            <option value="">Select Gender</option>
                                             <option value="1">Male</option>
                                              <option value="2">Female </option>
                                              <option value="3">Both</option>
                                            </select> 
 <select  name="year"  required id="x">
      
                                        <option value="">select year</option>
                                        <?php $r=mysqli_query($conn,"select distinct year from student_fees order by year desc") or die(mysqli_error($conn));
										  while($a=mysqli_fetch_array($r)){
										  ?>
										  <option value="<?php echo $a['year'];?> "> <?php echo $a['year'];?> </option>
                                          <?php
										  }
										   ?>
                                           </select>	
                                           <select name="s"   id="x" >
                                            <option value="">Semester</option>
                                            <option value="1">Jan-June </option>
                                              <option value="2">July-Dec  </option>
                                              </select> 
                                              <select name="Year"   id="sel" style="visibility:hidden">
                                            <option value="">Student Year</option>
                                            <option value="1">1</option>
                                              <option value="2">2 </option>
                                              <option value="3">3  </option>
                                              <option value="4">4 </option>
                                              </select> 
                                             <select name="semester" id="semester" style="visibility:hidden">
                                            <option value="">Student Sem</option>
                                            <option value="1">1</option>
                                              <option value="2">2 </option>
                                              </select>
                                           
                                        <button type="submit" name="send" class="btn btn-success display" ><i class="icon-list-alt icon-large "></i>&nbsp;Display</button>
                                       
                             
                  </form>
                  </div></div>
                 
                
          <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
                    
                                         
                                                
                                 <thead>
                                 <tr>
                                <th>No</th>
                               <th>StudentID</th>
                              
                              <th>Lastname</th>
                              <th>Firstname</th>
                                <th>Mode</th>
                                  <th>Prog</th>
                                  <th>Current Year</th>
                                  <th>Current Sem</th>
                                  <th>Adm Year</th>
                                  <th>Adm sem</th>
                                  <th>Gender</th>
                                                                  
                   </tr>
                    </thead>
                        <tbody>   
                           <!-- end script -->
                          
                            <?php include('stud_new.php'); ?>
                           
                          <!-- user delete modal -->
                            
                        </tbody>
                  </table>
                 
                    <!-- end slider -->
                    <?php  //echo $msg.$y?>
                </div>
            </div>
                        
                                 
                </div>
                
                <?php  include('footer.php'); ?>
            </div>

        </div>
    </div>





</body>
</html>