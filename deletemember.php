<?php


$selected=$_POST["selected"];

$x= count($selected);

for($i=0;$i<$x;$i++) {
	delete_member($selected[$i]);	
}

function delete_member($ic) {
	
	include 'assets/connection.php';
	$query=mysqli_query($con,"DELETE FROM tblsamembers WHERE icnumber='$ic'");
	mysqli_close($con);
	
}

?>