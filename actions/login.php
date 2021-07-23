<?php
$email= $_POST["username"];
$password=$_POST["password"];
$access=$_POST["access"];
$branch=$_POST["campus"];

include '../assets/connection.php';

if($access=='admin'){
$query=mysqli_query($con,"SELECT * FROM tblsausers WHERE username='$email' AND userpass='$password' AND level='$access'");
}
else {
	$query=mysqli_query($con,"SELECT * FROM tblsausers WHERE username='$email' AND userpass='$password' AND level='$access' AND campus='$branch'");
}
if((mysqli_num_rows($query))>0){
	
	session_start();
	$_SESSION["site"]="studentaffairs";
	$_SESSION["sauser"]=$email;
	$_SESSION["salevel"]=$access;
	echo "<script> alert('Login Successful'); </script>";
	if($access=='admin') {
		$_SESSION["campus"]="ALL";
		echo "<script> window.location.href='admin.php' </script>";	
	}
	else {
		$_SESSION["campus"]=$branch;
	echo "<script> window.location.href='committee.php' </script>";	
	}
}
else {
	echo "<p class='text-warning'>Password or email doesnt exists!</p>";
	}

?>