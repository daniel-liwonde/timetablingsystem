<?php
                                      include('connect.php');
                                     include('functions.php');
                           $ss=mysqli_query($conn,"select*from interest") or die("mysq error".mysqli_error($conn));
									  $int=mysqli_fetch_array($ss);
									  $status= $int['year_day'];
								   
								   ?>
                                   <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered"  >
                                  <thead>
                                    <tr>
                                        <th width="69">StudentID</th>
                                      <th width="90" >Student Name</th>
                                      <th width="111">Amount Paid</th>
                                      <th width="54">Balance</th>               
                                      <th width="130">Last Pay Date</th>
                                      <th width="96">Exam Number</th>
                                      <th width="66">Added By</th>
                                      <th width="100">Action</th>
                                    </tr>
                                    
                                </thead>
                                <tbody>
                                        <tr class="odd gradeX">
                                
 <?php                             
		                          $q = $_GET['q'];
                                   $student=mysqli_query($conn,"select * from student where id='$q'") or die(mysqli_error($conn));
								 while($row=mysqli_fetch_array($student))
								   {
								       
								   $ID=$row['id'];
								   $mode=$row['mode'];
								   $year=date('Y');
								   $sem=checksem();
								    $student_fees=mysqli_query($conn,"select * from student_fees where id=$ID and year='$year' and sem='$sem' ") or die("error here" .mysqli_error($conn));
									$fee=mysqli_fetch_array($student_fees);
                                    if($fee)
									 $fee_added_by=mysqli_query($conn,"select* from user where user_id='$fee[user_id]' ") or die("mysq error".mysqli_error($conn));
                                     if($fee)
                                     $found=mysqli_fetch_array($fee_added_by);
									 if($fee)
									  $tFees= $fee['total_amount'];
                                    
                                        ?>
                                        


                                    <!-- script -->
                                    <script type="text/javascript">
                                        $(document).ready(function(){
                                                    
                                            $('#d<?php echo $student_ID; ?>').tooltip('show')
                                            $('#d<?php echo $student_ID; ?>').tooltip('hide')
                                        });
                                    </script>
                                    <!-- end script -->
                                     <!-- script -->
                                    <script type="text/javascript">
                                        $(document).ready(function(){
                                                    
                                            $('#a<?php echo $ID; ?>').tooltip('show')
                                            $('#a<?php echo $ID; ?>').tooltip('hide')
                                        });
                                    </script>
                                    <!-- end script -->
                                    
                                    <td><?php echo  $row['student_id']; ?></td>
                                    <td><?php echo $row['firstname']." ".$row['lastname']; ?></td>
                                    <td><?php if($fee) echo $tFees  ?></td>
                                
                                    <td><?php  if($fee) if($fee['fee_balance']) echo   number_format($fee['fee_balance'],2,'.',','); ?></td>

                                     <td><?php   if($fee) if($fee['last_pay_date']) echo  $fee['last_pay_date']; ?></td>
                                     
                                    <td><?php   if($fee) echo  $fee['exam_no']; ?></td>
                                     
                                      <td><?php   if($fee)echo  $found['lastname']; ?></td>
                                    
                                    <td>
                                        <a rel="tooltip"  title="Enter fees" id="d<?php echo  $ID; ?>" href="enterfees2.php?uid=<?php echo  $ID; ?>" class="btn btn-success"><i class="icon-plus-sign icon-large"></i></a>
                                        <a rel="tooltip"  title="Edit fees info" id="a<?php echo  $ID ?>" role="button"  href="edit_fees.php?uid=<?php echo  $ID ?>&mode=<?php  echo  $mode ?>&amount=<?php  echo  $fee['total_amount'] ?>"class="btn btn-success"><i class="icon-edit icon-large"></i></a>
                                  
                                    </td>
                                   
                                    </tr>
                                <?php
                                 
								   }
								   
                                ?>
								