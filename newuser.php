<?php


$username=$_GET['username'];
$password=$_GET['password'];
$mobile=$_GET['mobile'];
$name=$_GET['name'];

$type=$_GET['type'];
$id=$_GET['id'];
$con=@mysql_connect("localhost","root","password") or die(mysql_error());
$db=@mysql_select_db("hms",$con)or die(mysql_error());
if ($type == "users") {
	$str="insert into users(username,password,name,mobile) values('$username','$password','$name','$mobile')";
	$res=@mysql_query($str)or die(mysql_error());
	if($res>=0)
		{
		$_SESSION['user']=$username;
		if($type=="users")
		header('location: patient/dashboard.php');
		}
	else{
			$message = "Duplicate Username";
			echo "<script type='text/javascript'>alert('$message');</script>";
		}
}
else if($type == "doctors"){

	$sql="SELECT * FROM uniqueid WHERE id='$id'";
	$result=@mysql_query($sql);
	$count=@mysql_num_rows($result);

	if($count<1){echo "Not a Doctor";}
	else
	{
		$str="insert into doctors(username,password,mobile,name) values('$username','$password','$mobile','$name')";
		$res=@mysql_query($str)or die(mysql_error());
		if($res>=0)
		{
		$_SESSION['user']=$username;
			if($type=="doctors")
			header('location: doctor/dashboard.php');

		}
		else{
			$message = "Duplicate Username";
			echo "<script type='text/javascript'>alert('$message');</script>";
		}
		

	}
}
else{
	echo "Invalid Entry";
}



?>
<html>
<br>
<a href="index.html"><b>Click here to return to the main page</b></a>
</html>
