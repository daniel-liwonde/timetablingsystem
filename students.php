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
                 <div class="hero-unit-1" style="width:20%">
                      <ul class="nav  nav-pills nav-stacked">
                        <li class="nav-header">Links</li>
                        <li>
                            <a href="student_home.php"><i class="icon-home icon-large"></i>&nbsp;Home
                                <div class="pull-right">
                                    <i class="icon-double-angle-right icon-sm"></i>
                                </div>  
                            </a>

                        </li>
                        <li class="active">
                            <a href="javascript:void(0);" onclick='$("#edit").show("slow");'><i class="icon-list-alt icon-large"></i>&nbsp;Reports
                                <div class="pull-right">
                                    <i class="icon-double-angle-right icon-sm"></i>
                                </div>  
                            </a></li>
                            
                            <div style="display:none;font: normal 12px arial; padding:10px; background: #e6f3f9; color: #0099FF;" id="edit">
                            <ul>
                             <li> <a href="exam.php">Exam</a>   </li>
                             <li><a href="finacials.php">Financial</a></li>
                              <li><a href="student.php">Students</a></li>
                            </ul>
                            <a  onclick='$("#edit").hide();' href="javascript:void(0);"><i class="icon-remove icon-large"></i></a>
                            </div>
                            
                            
                                
           <li>
                            <a href="settings.php"><i class="icon-group icon-large"></i>&nbsp;Settings
                                <div class="pull-right">
                                    <i class="icon-double-angle-right icon-sm"></i>
                                </div>  
                            </a></li>
                            <li>
                            <a href="results.php"><i class="icon-group icon-large"></i>&nbsp;Student results
                                <div class="pull-right">
                                    <i class="icon-double-angle-right icon-sm"></i>
                                </div>  
                            </a></li>
 <li>
                            <a href="transcript.php"><i class="icon-book icon-large"></i></i>&nbsp;Genarate Transcripts
                                <div class="pull-right">
                                    <i class="icon-double-angle-right icon-sm"></i>
                                </div>  
                            </a></li>
                    </ul>
                    </div>
                    <?php include "msg.php" ?>
                    <div class="span12" style="border:1px; width:78%; margin-left:22%; margin-top:-350px;">
                    
                        <!--slider-->
                        <form method="post" action="../repo.php">
                <button class="btn btn-success" type="submit" name="submit_docs"><i class="icon-plus-sign icon-large"></i>&nbsp;Export to word</button>
                <?php if (isset($_GET['sub'])) { ?>
                    <input type="hidden" value="<?php echo $_GET['sub'] ?>" name="sub" >
                    <input type="hidden" value="<?php echo $_GET['year'] ?>" name="year" >
                    <input type="hidden" value="<?php echo $_GET['sem'] ?>" name="sem" >
                <?php } ?>
                </form>
                <div class="hero-unit-3">
                <?php if (isset($msg)) { ?>
                            
                                <div class="alert alert-danger"><i class="icon-save"></i>			
                                <?php echo $msg; ?></div>
                            <?php
                }
                ?>                           
                              <div class="alert alert-info">
                        
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong><i class="icon-user icon-large"></i>&nbsp;Reports table</strong>                      </div> 
                           <div class="control-group">
                                                <label class="control-label" for="inputPassword">Enter Details Below</label>
                                                <div class="controls">
           <form action="" method="get">
                         Subject:
                                                     <select name="sub"  required>
                                            <option>  </option>
                                            <?php
                                            $query = mysqli_query($conn, "select * from subject");

                                            while ($row = mysqli_fetch_array($query)) {
                                                ?>
                                                    <option value="<?php echo $row['subject_code']; ?>"><?php echo $row['subject_title']; ?></option>
                                                    <?php
                                            }
                                            ?>
                                        </select>
                                        Exam Year:<input type="text" name="year"  id="g"  required>
                                            
                                        semester:
                                        <input type="text" name="sem"  id="g"required>
                                        include programme?<input type="checkbox" 
                                        <button type="submit" name="send" class="btn btn-success" ><i class="icon-list-alt icon-large"></i>Display</button>
                                       
                             
                  </form>
                  </div></div>
                 
                
          <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
                    
                                         
                                                
                                 <thead>
                                 <tr>

                               <th>StudentID</th>
                              <th>Firstname</th>
                              <th>Lastname</th>
                                <th>Mode</th>
                                <th>Code</th>
                                  <th>Assg#1</th>
                                  <th>Assg#2</th>
                                   <th>EOS</th>
                                   <th colspan="2">Grade</th>
                                    <th>Year</th>                                 
                   </tr>
                    </thead>
                        <tbody>   
                           <!-- end script -->
                          
                            <tr class="odd gradeX">
                           <?php databaseOutput() ?>    
                          <!-- user delete modal -->
                            
                        </tbody>
                  </table>
                 
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