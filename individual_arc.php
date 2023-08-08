 <?php
 $query = mysqli_query($conn,"select * from archive where stud_year='$cyear'  and sem='$sem' and student_id='$sel'") or die(mysqli_error($conn));
	 $total=mysqli_num_rows($query);
	   
		 if($total>0){
		 ?>
         <div class="alert alert-info">Showing  <?php echo $prog;  ?>&nbsp;<?php echo $year;  ?>&nbsp;Year&nbsp;<?php echo $cyear;  ?>&nbsp;Semester &nbsp;<?php echo $sem;  ?> &nbsp;Results  &nbsp;<b><?php //echo $n['surname']  ?>&nbsp;&nbsp;<?php //echo $n['firstname']?></b> </div>
                                    
                                  <tr>
                                 <td colspan="4"> 
                                 <table style=" width:100%; background-color:#DDD" >
                                 
                              
                             
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
							$years;
						  
							$status = mysqli_query($conn,"select distinct comment from archive where stud_year='$cyear'  and sem='$sem' and student_id='$sel' and comment='F'");
							 if(mysqli_num_rows($status)==0){$pas="PASSED";}else {$pas="FAILED";}
						    while($student_row = mysqli_fetch_array($query)){
							$cod=$student_row ['course_code'];
                          $title= mysqli_query($conn,"select * from subject where subject_code='$cod' ");
						  $ccode=mysqli_fetch_array($title);
						   $name=$student_row['surname'];
						    $fname=$student_row['firstname'];
							 $iname=$student_row['student_id'];
							 $years=$student_row['year'];
							 // if(mysqli_num_rows($status)==0){$pas="PASSED";}else {$pas="FAILED
							  							 
							 ?>
                            <tr align="center" >
							<td align="left"><?php echo $student_row['course_code']?></td>
                             <td width="210" align="left"><?php echo  $ccode['subject_title']?></td> 
                              <td><?php echo $student_row['assign_1'];?> </td>
                              <td><?php echo $student_row['assign_2']?> </td>
                              <td><?php echo $student_row['EOS']?> </td>
                              <td><?php echo $student_row['fgrade']?> </td>
                              <td><?php echo $student_row['comment']?> </td>
                              
							   </tr>
                               
							<?php
							
							}
							
						?>
						</table></td></tr>
							<tr class="alert alert-danger"><td colspan="4"><b><font color="#666666"><?php echo $iname."&nbsp;&nbsp;". $name."&nbsp;&nbsp;". $fname."</font>";if(isset($pas)){echo "<font color='#FF0000'> &nbsp;".$pas;} echo "&nbsp;&nbsp;Year:".$years;?></font></b></td></tr>
                            <?php      
						 }
						 else
						 {
						 echo "no results for student in sem".$sem."Year:".$year;
						 } 
						
						
						
						?>  
                       