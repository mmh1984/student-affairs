<?php
session_start();
$user=$_SESSION['sauser'];
$level=$_SESSION['salevel'];

if((!isset($_SESSION['site'])) && ($level!='admin')){
	header('location:index.html');
}

else {
	include 'assets/connection.php';
	$username=$_POST['username'];
	$fullname=$_POST['fullname'];
	$campus=$_POST['campus'];
	$str="INSERT INTO tblsausers (username,userpass,fullname,level,campus) ";
	$str.="VALUES('$username','password','$fullname','committee','$campus')";
	if(mysqli_query($con,$str)) {
		echo "success";
	}
	else {
		echo (die(mysqli_error($con)));	
	}
}
?>