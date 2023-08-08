<?php
if(isset($_POST['go'])){
if($_POST['pass']!=$_POST['pass2'])
{
?>
<script language="javascript">
alert("passwords mismatched!")
window.back();
</script>
<?php
}
else
{
$pass= md5($_POST['pass']);
mysqli_query($conn,"update user set password='$pass' where user_id='$session_id'") or die(mysqli_error($conn));
header("location:logout.php");
}
}
?>