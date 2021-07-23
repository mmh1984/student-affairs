<?php
session_start();


include 'assets/connection.php';	
if($_SESSION['salevel']=='admin'){
	
	$query=mysqli_query($con,"SELECT
tblsamembers.icnumber,
tblstudents.fullname,
tblstudents.course,
tblstudents.`level`,
tblstudents.intake,
tblsamembers.clubid1,
tblsamembers.clubid2,
tblsamembers.phone,
tblsamembers.campus,
tblsamembers.dateadded,
tblsamembers.addedby

FROM
tblsamembers
INNER JOIN tblstudents ON tblsamembers.icnumber = tblstudents.icnumber");
	
	$row=mysqli_num_rows($query);
	if($row>0){
		echo "<table class='table' style='font-size:12px;' id='tabledownload'>
		<tr style='background:#036;color:#fff;'>
					<td>Select</td>
					<td>IC Number</td>
					<td>Full Name</td>
					<td>Course</td>
					<td>Level</td>
					<td>Intake</td>
					<td>Youth Club</td>
					<td>Sports Club</td>
					<td>Phone</td>
					<td>Campus</td>
					<td>Date Added</td>
					<td>Added By</td>
				</tr>
		";
		while($row=mysqli_fetch_array($query)){
		echo"
				
				<tr>
			        <td><input type='checkbox' class='clubselect' name='clubselect[]' value='$row[0]'>
					<td>$row[0]</td>
					<td>$row[1]</td>
					<td>$row[2]</td>
					<td>$row[3]</td>
					<td>$row[4]</td>
					<td>".load_name($row[5])."</td>
					<td>".load_name($row[6])."</td>
					<td>$row[7]</td>
					<td>$row[8]</td>
					<td>$row[9]</td>
					<td>$row[10]</td>
					
				</tr>
		";
			
		}
		echo "</table>";
		
		mysqli_close($con);
	}
	else {
	echo "This club has 0 members"; 	
	}
}
else{
$campus=$_POST["campus"];
$query=mysqli_query($con,"SELECT
tblsamembers.icnumber,
tblstudents.fullname,
tblstudents.course,
tblstudents.`level`,
tblstudents.intake,
tblsamembers.clubid1,
tblsamembers.clubid2,
tblsamembers.phone,
tblsamembers.campus,
tblsamembers.dateadded,
tblsamembers.addedby

FROM
tblsamembers
INNER JOIN tblstudents ON tblsamembers.icnumber = tblstudents.icnumber
WHERE
tblsamembers.campus = '$campus'

");
	
	$row=mysqli_num_rows($query);
	if($row>0){
		echo "<table class='table' style='font-size:12px;' id='tabledownload'>
		<tr style='background:#036;color:#fff;'>
					<td>Select</td>
					<td>IC Number</td>
					<td>Full Name</td>
					<td>Course</td>
					<td>Level</td>
					<td>Intake</td>
					<td>Youth Club</td>
					<td>Sports Club</td>
					<td>Phone</td>
					<td>Campus</td>
					<td>Date Added</td>
					<td>Added By</td>
				</tr>
		";
		while($row=mysqli_fetch_array($query)){
		echo"
				
				<tr>
			        <td><input type='checkbox' class='clubselect' name='clubselect[]' value='$row[0]'>
					<td>$row[0]</td>
					<td>$row[1]</td>
					<td>$row[2]</td>
					<td>$row[3]</td>
					<td>$row[4]</td>
					<td>".load_name($row[5])."</td>
					<td>".load_name($row[6])."</td>
					<td>$row[7]</td>
					<td>$row[8]</td>
					<td>$row[9]</td>
					<td>$row[10]</td>
					
				</tr>
		";
			
		}
		echo "</table>";
		
		mysqli_close($con);
	}
	else {
	echo "This club has 0 members"; 	
	}
}
function load_name($id) {
	include 'assets/connection.php';	
	$query=mysqli_query($con,"SELECT clubname FROM tblsaclubs WHERE id='$id'");
	while($row=mysqli_fetch_array($query)){
		return $row[0];
	}
	
	
}
?>