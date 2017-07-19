<?php
session_start();
?>
<?php

$username=$_GET['username'];
$password=$_GET['password'];
$type=$_GET['type'];
$con=@mysql_connect("localhost","root","password") or die(mysql_error());
$db=@mysql_select_db("hms",$con)or die(mysql_error());

$sql="SELECT * FROM ".$type." WHERE username='$username' and password='$password'";
$result=@mysql_query($sql);

$count=@mysql_num_rows($result);

if($count<1){
header('location: index.html');
}
else
	{
		$_SESSION['user']=$username;
		if($type=="users")
		header('location: patient/dashboard.php');

		if($type=="doctors")
		header('location: doctor/dashboard.php');
		

	}

?>
