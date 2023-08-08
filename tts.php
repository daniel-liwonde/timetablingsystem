<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>
    <title>Fees Receipt</title>
    <?php 
include('connect.php');
include('functions.php');
// end of function
if (isset($_POST['send'])) { // word output
$uid=$_POST['uid'];
$bal=$_POST['bal'];
$amount=$_POST['amount'];
$tamount=$_POST['tamount'];
$semfee=$_POST['semfee'];
$int=$_POST['int'];
$fplusint=$_POST['total_to_pay'];
  header("Content-Type:application/msword");
  header("Expires: 0");
  header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
  header("content-disposition: attachment;filename=report.docx");
?>
<head>
</head>
  <body>
    <?php printreciept($uid,$amount,$tamount,$int,$bal,$semfee,$fplusint)    ?>
  </body>
</html>
<?php

  exit; // end of word output

}
?>
