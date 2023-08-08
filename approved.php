<?php
//session_start();
include('connect.php');
if(isset($_GET['amount'])){
$id=$_GET['id'];
$amount=$_GET['amount'];

$check=mysqli_query($conn,"select * from budget_line where id='$id'") or die(mysqli_error($conn));
$s=mysqli_fetch_array($check);
if($s['remander']<$amount)
{
$_COOKIE['ERR']="amount is less than total amount available MWK".$s['remander'];
header('location:home.php');
}
else
{
mysqli_query($conn,"update budget_line set remander=remander-$amount where id='$id'") or die(mysqli_error($conn));
mysqli_query($conn,"update expenses set approved='1',r_fresufal='' where source='$id'") or die(mysqli_error($conn));
header('location:home.php');
}
}
if(isset($_POST['re']))
{
$rid=$_POST['rid'];
$rf=$_POST['ref'];
$am=$_POST['am'];
if(empty($rf)){
$_COOKIE['ERR']="enter reason for refusal";
header('location:home.php');
}else{
mysqli_query($conn,"update expenses set r_fresufal='$rf', approved='2' where exp_id='$rid'") or die(mysqli_error($conn));
header('location:home.php');
}
}
?>
