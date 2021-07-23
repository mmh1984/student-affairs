<?php
session_start();
$username=$_SESSION["sauser"];
include "assets/connection.php";


$newpass=$_POST["newpass"];

$query=mysqli_query($con,"UPDATE tblsausers SET userpass='$newpass' WHERE username='$username'");

if($query) {
 echo "success";	
}
else {
 echo (die(mysqli_error($con)));	
}

mysqli_close($con);

?>