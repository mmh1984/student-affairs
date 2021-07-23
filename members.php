<?php
include "assets/connection.php";
session_start();
$campus=$_SESSION["campus"];
$user=$_SESSION["sauser"];
$club1=$_POST["club1"];
$club2=$_POST["club2"];
$ic=$_POST["icnumber"];
$phone=$_POST["phone"];
$date=date('Y-m-d');

if((check_member($ic))=="yes") {
	echo "Error! this student is already added to the system";
}
else {

$query="INSERT INTO tblsamembers(icnumber,clubid1,clubid2,phone,campus,dateadded,addedby)";
$query.=" VALUES('$ic',$club1,$club2,'$phone','$campus','$date','$user')";

if(mysqli_query($con,$query)) {
echo "success";	
}
else {
	echo (die(mysqli_error($con)));	
}
mysqli_close($con);
}

function check_member($ic) {
	include "assets/connection.php";
	$query=mysqli_query($con,"SELECT * FROM tblsamembers WHERE icnumber='$ic'");
	$count=mysqli_num_rows($query);
	if($count>0) {
	return "yes";	
	}
	else {
	return "no";	
	}
	mysqli_close($con);
}
?>