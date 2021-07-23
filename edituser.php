<?php
session_start();
$user=$_SESSION['sauser'];
$level=$_SESSION['salevel'];

if((!isset($_SESSION['site'])) && ($level!='admin')){
	header('location:index.html');
}
else {
$username=$_POST['user'];
$option=$_POST['option'];

include 'assets/connection.php';
$query="";
switch($option) {
	case "reset":
	$query="UPDATE tblsausers SET userpass='password' WHERE username='$username'";
	break;
	
	case "delete":
	$query="DELETE FROM tblsausers WHERE username='$username'";
	break;
	
}	

if(mysqli_query($con,$query)) {
	echo "Successfully performed the operation";	
}

else {
	echo(die(mysqli_error($con)));	
}
mysqli_close($con);
}

?>