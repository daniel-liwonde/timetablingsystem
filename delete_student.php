<?php
include('connect.php');
include('functions.php');
//session_start();
$get_id=$_GET['did'];
$sm=checksem();
$year=date('Y');
$sel2=mysqli_query($conn,"select * from student_fees where id='$get_id' and year='$year' and sem='$sm'and total_amount>0")or die(mysqli_error($conn));
if(mysqli_num_rows($sel2)>0)
{
$_COOKIE['ERR']="Can not archive student has fees payments";
header('location:student.php');
}
else
{
$sel=mysqli_query($conn,"select *from student where id='$get_id'")or die(mysqli_error($conn));
$info=mysqli_fetch_array($sel);
mysqli_query($conn,"insert into student_archive (firstname,lastname,cys,middle_name,student_id,stud_email,birth_date,stud_address,gender,sponsor,stud_pnone,spo_email,mode,town,nation,sp_relation,addm_year,sem,sp_address,spo_phone,joined_in,stud_current_year,dept,qualif)
values ('$info[firstname]','$info[lastname]','$info[cys]','$info[middle_name]','$info[student_id]','$info[stud_email]','$info[birth_date]','$info[stud_address]','$info[gender]','$info[sponsor]','$info[stud_pnone]','$info[spo_email]','$info[mode]','$info[town]','$info[nation]','$info[sp_relation]','$info[addm_year]','$info[sem]','$info[sp_address]',
'$info[spo_phone]','$info[joined_in]','$info[stud_current_year]','$info[dept]','$info[qualif]')                                    
") or die(mysqli_error($conn));
$results=mysqli_query($conn,"select * from results where uid='$get_id'") or die(mysqli_error($conn));
while($row=mysqli_fetch_array($results))
{
$id=GenKey2();
mysqli_query($conn,"insert into archive(result_id,uid,student_id,firstname,surname,course_code,assign_1,assign_2,EOS,fgrade,year,sem,comment,prog,mode,stud_year,dept) values('$id','$row[uid]','$row[student_id]','$row[firstname]','$row[surname]','$row[course_code]','$row[assign_1]','$row[assign_2]','$row[EOS]','$row[fgrade]','$row[year]','$row[sem]','$row[comment]','$row[prog]','$row[mode]','$row[stud_year]','$row[dept]')") or die(mysqli_error($conn));
}
mysqli_query($conn,"delete from results where uid='$get_id'") or die("here".mysqli_error($conn));
mysqli_query($conn,"delete from student where id='$get_id'")or die(mysqli_error($conn));
mysqli_query($conn,"delete from student_fees where id='$get_id'")or die(mysqli_error($conn));
mysqli_query($conn,"delete from teacher_student where uid='$get_id'")or die(mysqli_error($conn));
$_COOKIE['ERR']="Student archived";
header('location:student.php');
}
?>