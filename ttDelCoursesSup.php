<?php
require_once("connect.php");
if(isset($_GET['cname']))
{
$cid=$_GET['cname'];
$done=mysqli_query($conn,"SELECT * FROM examschedulesup WHERE scheduleid='$cid'") or die(mysqli_error($conn));
$name=mysqli_fetch_assoc($done);
echo $name['course'];
}
if(isset($_GET['cid']))
{
$cid=$_GET['cid'];
$done=mysqli_query($conn,"DELETE FROM examschedulesup WHERE scheduleid='$cid'");
if(mysqli_affected_rows($conn)>0)
{
    echo "Done";
}
else
echo"failed to delete";
}
?>
