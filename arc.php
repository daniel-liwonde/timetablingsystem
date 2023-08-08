<?php

			
			            if(isset($_GET['send'])){//open if isset
							$prog=$_GET['sub'];
							$year=$_GET['year'];
							$sem=$_GET['sem'];
							$sel=$_GET['sel'];
							$cyear=$_GET['cyear'];
		if($sel==''){ //open sel
     $query = mysqli_query($conn,"select distinct student_id,uid,firstname,surname from archive where stud_year='$cyear' and prog='$prog' and year='$year' and sem='$sem'") or die(mysqli_error($conn));
	 $total=mysqli_num_rows($query);
		 if($total>0){ //open total>0
		 ?>
         <div class="alert alert-info">Showing  <?php echo $prog;  ?>&nbsp;<?php echo $year;  ?>&nbsp;Year&nbsp;<?php echo $cyear;  ?>&nbsp;Semester &nbsp;<?php echo $sem;  ?> &nbsp;Results</div>
         <?php
		 $fail=0; $pass=0;
		  while ($row = mysqli_fetch_array($query)) {//open loop first
                           $student_id = $row['student_id'];
						  $uid = $row['uid'];
						   ?>
                           <tr style=" color:#FF0000; font-family:Cambria; font-weight:600">
                           <td >STUDENT NAMES:&nbsp;<?php echo $row['surname']?>&nbsp;&nbsp;<?php echo $row['firstname']?></td></tr>
                           <tr style="  color:#FF0000; font-family:Cambria; font-weight:600">
						   <td >REGNO: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $row['student_id']?></td><td class="3"></td></tr>
                             
                              
                                 </tr>                                 
                                  <tr>
                                 <td colspan="4"> 
                                 <table style=" width:100%; background-color:#DDD" >
                                 
                                <?php
                              $student = mysqli_query($conn,"select * from archive where uid='$uid' and year='$year' and sem='$sem' and stud_year='$cyear'") or die("here".mysqli_error($conn)); 
							 if(mysqli_num_rows( $student)==0)
							{//open if
							echo "<tr><td colspan='7'>No exam results for student in".$year ."&nbsp;Semester&nbsp;".$sem ."</td> </tr>";
							}//close if
							else
							 {// open subjects found
							 ?>
                             
							    <tr style="font-weight:bold;  text-align:center" class="alert alert-info">
                             <td align="left">SUBJECT CODE</td>
                             <td align="left">SUBJECT NAME</td>
                             <td> ASSIGN#1</td>
                             <td> ASSIGN#2 </td>
                             <td> EXAM</td>
                             <td>EOS</td>
                              <td>REMARKS</td> 
                             </tr>
                             <?php
							
						   
							$status = mysqli_query($conn,"select distinct comment from archive where uid='$uid' and year='$year' and sem='$sem' and comment='F'");
							  if(mysqli_num_rows($status)==0){$pass=$pass+1;}else {$fail=$fail+1;}
						    while($student_row = mysqli_fetch_array($student)){//open subject loop
							$cod=$student_row ['course_code'];
                          $title= mysqli_query($conn,"select * from subject where subject_code='$cod' ");
						  $ccode=mysqli_fetch_array($title);
						  
							
							 ?>
                            <tr align="center" >
							<td align="left"><?php echo $student_row['course_code']?></td>
                             <td width="210" align="left"><?php echo  $ccode['subject_title']?></td> 
                              <td><?php echo $student_row['assign_1']?> </td>
                              <td><?php echo $student_row['assign_2']?> </td>
                              <td><?php echo $student_row['EOS']?> </td>
                              <td><?php echo $student_row['fgrade']?> </td>
                              <td><?php echo $student_row['comment']?> </td>
                              
							   </tr>
                               
							<?php							
							}//close subject loop
						?>
						</table></td></tr>
							
                            <?php      
						 } //close subject found
						}//close first loop
						
						
						?>  
                          <!-- Report -->
                         
                        </tr>
                        <?php if(isset($fail)||isset($pass)){?>
                        <tr class="alert alert-danger"><td colspan="4"><b>Statistics</b></td></tr> 
                        <tr class="alert alert-danger"> <td>Total pass : <?php if(isset($pass))echo $pass;  ?>   </td><td>Total fail:<?php if(isset($fail))echo $fail; ?> </td><td>
                        Total class: &nbsp;<?php $total=$pass+$fail; if(isset($total)){echo $total;}?></td><td>  Pass Rate:<?php 
						$total=$pass+$fail; if($total==0){$total=1;}else {$total=$total;} $rate=(($pass/$total)*100); if(isset($rate)){echo round($rate,1)."%"; } ?> </td></tr>
                        <?php
						}
					    }//close total>0
						else
						{  //no results
						echo"No results found";
						}
						}//close $sel=''
						else
						{ // find individual results
						include('individual_arc.php');
						}
			           }//close if isset
					   
			            