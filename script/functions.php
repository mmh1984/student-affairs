<?php
session_start();
if(isset($_POST["ic"])){
	$ic=$_POST["ic"];
	$campus=$_POST["campus"];
	search_ic($ic,$campus);
} 
if(isset($_POST["nonemembers"])){
	load_none_members();
}

if(isset($_POST["clubmembers"])){
	load_members();
}

if(isset($_POST["load"])){
	$campus=$_POST["campus"];

	if(($_POST["load"])=="guest"){
		
	load_club_guest($campus);	
	}
}
if(isset($_POST["clubid"])){

$id=$_POST["clubid"];

echo get_max($id)-count_members($id);	
	
}

function load_none_members(){
	include '../assets/connection.php';	
	
	$campus=$_SESSION['campus'];
	if(isset($_POST['course']) && isset($_POST['intake'])){ 

$course=$_POST['course'];
$intake=$_POST['intake'];
$query=mysqli_query($con,"SELECT
tblstudents.campus,
tblstudents.icnumber,
tblstudents.fullname,
tblstudents.course,
tblstudents.`level`,
tblstudents.intake
FROM
tblstudents
WHERE
tblstudents.icnumber NOT IN (SELECT icnumber FROm tblsamembers WHERE icnumber is not null)

AND tblstudents.course='$course' AND tblstudents.intake='$intake' AND tblstudents.campus='$campus';

"); 

	}
else {
	$query=mysqli_query($con,"SELECT
tblstudents.campus,
tblstudents.icnumber,
tblstudents.fullname,
tblstudents.course,
tblstudents.`level`,
tblstudents.intake
FROM
tblstudents
WHERE
tblstudents.icnumber NOT IN (SELECT icnumber FROm tblsamembers WHERE icnumber is not null)
AND tblstudents.campus='$campus'

"); 

}

$count=mysqli_num_rows($query);
if($count==0){
echo "<p>No members yet</p>";	
}
else{
	
	echo "<p class='alert alert-info'>Click on IC number to add</p>";
	echo "<p>Total members:$count</p>";
	echo"<button class='btn btn-default pull-right' onClick=\"download_non_members()\">Download</button>";
echo "<table class='table table-responsive table-condensed table-striped' id='tblnonmembers'>
<tr>
<th>Campus</th>
<th>IC</th>
<th>Full Name</th>
<th>Course</th>
<th>Level</th>
<th>Intake</th>";

while($row=mysqli_fetch_array($query)){

echo"<tr>
	
	<td>$row[0]</td>
	<td><button class='btn btn-primary' onclick='add_ic(\"$row[1]\")' data-dismiss='modal'>$row[1]</button></td>
	<td>$row[2]</td>
	<td>$row[3]</td>
	<td>$row[4]</td>
	<td>$row[5]</td>
	
	</tr>";	
}
echo "</table>";
mysqli_close($con);
}
}


function load_members(){
	$campus=$_SESSION['campus'];
	include '../assets/connection.php';	
$id=$_POST['clubmembers'];
$query=mysqli_query($con,"SELECT
tblstudents.icnumber,
tblstudents.fullname,
tblstudents.intake,
tblstudents.`level`,
tblsamembers.campus,
tblsamembers.dateadded,
tblsamembers.addedby,
tblsamembers.phone
FROM
tblsamembers
INNER JOIN tblstudents ON tblsamembers.icnumber = tblstudents.icnumber
WHERE tblsamembers.clubid1='$id' OR tblsamembers.clubid2='$id' AND tblsamembers.campus='$campus'
ORDER BY INTAKE DESC

"); 



$count=mysqli_num_rows($query);
if($count==0){
echo "<p>No members yet</p>";	
}
else{
	echo "<p>Total members:$count</p>";
	echo"<button class='btn btn-default pull-right' onClick=\"download_club_members()\">Download</button>";
echo "<table class='table table-responsive table-condensed table-striped' id='tblclubmembers'>
<tr>
<th>IC Number</th>
<th>Name</th>
<th>Intake</th>
<th>Level</th>
<th>Campus</th>
<th>Date Added</th>
<th>Added By</th>
<th>Phone</th>";

while($row=mysqli_fetch_array($query)){

echo"<tr>
	<td>$row[0]</td>
	<td>$row[1]</td>
	<td>$row[2]</td>
	<td>$row[3]</td>
	<td>$row[4]</td>
	<td>$row[5]</td>
	<td>$row[6]</td>
	<td>$row[7]</td>
	</tr>";	
}
echo "</table>";
mysqli_close($con);
}
}

function load_club_admin() {
include 'assets/connection.php';	
	
	$query=mysqli_query($con,"Select * from tblsaclubs");


	echo "<span class='text-muted'>Click on the club title to show members</span>";
	echo "<table class='table table-bordered table-condensed table-striped' id='tableclub'>
        <tr>
        <th>Campus</th>
		<th>Name</th>
        <th>Type</th>
        <th>Quota</th>
		<th>Members</th>
		<th>Action</th>
        </tr>";
		
		
		while($row=mysqli_fetch_array($query,MYSQLI_NUM)) {
			echo "<tr>
				   <td>$row[1]</td>
				   <td align='left'><button class='btn-success' onclick='show_members(\"$row[0]\",\"$row[2]\")'>$row[2]</button></td>
				   <td>$row[3]</td>
				   <td>$row[4]</td>
				   <td>".count_members2($row[0])."</td>
				   <td><button class='btn btn-info btn-sm' onclick='editclub($row[0])'>Edit</button>&nbsp;<button class='btn btn-danger btn-info btn-sm' onclick='deleteclub($row[0])'>Delete</button></td>
				   </tr>";
		}
		echo "</table>";
		mysqli_close($con);
}


function load_club_guest($campus) {
		
include '../assets/connection.php';	
	
	$query=mysqli_query($con,"Select * from tblsaclubs WHERE campus='$campus'");

	
	echo "<table class='table table-bordered table-condensed table-striped' id='tableclub'>
        <tr>
        <th>Campus</th>
		<th>Name</th>
        <th>Type</th>
        <th>Quota</th>
		 <th>Members</th>
		
        </tr>";
		
		
		while($row=mysqli_fetch_array($query,MYSQLI_NUM)) {
			echo "<tr>
				   <td>$row[1]</td>
				  <td align='left'><button class='btn-success' onclick='show_members(\"$row[0]\",\"$row[2]\")'>$row[2]</button></td>
				   <td>$row[3]</td>
				   <td>$row[4]</td>
				   <td>".count_members($row[0])."</td>
				  
				   </tr>";
		}
		echo "</table>";
		mysqli_close($con);
}


function count_members($id) {
	include '../assets/connection.php';	
	
	$query=mysqli_query($con,"SELECT * FROM tblsamembers WHERE clubid1=$id or clubid2=$id");

	$count=mysqli_num_rows($query);
	if($count>0) {
		mysqli_close($con);
	return $count;
		
	}
	else {
	return 0;	
	}
	
	
}
function count_members2($id) {
	include 'assets/connection.php';	
	
	$query=mysqli_query($con,"SELECT * FROM tblsamembers WHERE clubid1=$id or clubid2=$id");

	$count=mysqli_num_rows($query);
	if($count>0) {
		mysqli_close($con);
	return $count;
		
	}
	else {
	return 0;	
	}
	
	
}
function get_max($id) {
	include '../assets/connection.php';	
	
	$query=mysqli_query($con,"SELECT quota FROM tblsaclubs WHERE id=$id");
	
	if(mysqli_num_rows($query)>0){
	
	while($row=mysqli_fetch_array($query,MYSQLI_NUM)){
		$count=$row[0];
	}
	
	mysqli_close($con);
	return $count;
	}
	else {
	return 0;	
	}
	
}

function search_ic($ic,$campus) {
	include '../assets/connection.php';	
	
	$ic=mysqli_real_escape_string($con,$ic);
	$query=mysqli_query($con,"SELECT * FROM tblstudents WHERE icnumber='$ic' AND campus='$campus'");
	$count=mysqli_num_rows($query);
	
	if($count >0){
		echo "<table class='table table-condensed'>
				<tr style='background:#036;color:#fff;'>
				<td>Full Name</td>
				<td>Course</td>
				<td>Level</td>
				<td>Intake</td>
				
				</tr>";
		while($row=mysqli_fetch_array($query)) {
			
			echo "<tr>
				<td>$row[3]</td>
				<td>$row[4]</td>
				<td>$row[5]</td>
				<td>$row[6]</td>
				
				</tr>";
		}
		echo "</table>";
		
	}
	else {
	echo "none";	
	}
	
	mysqli_close($con);
	return $count;
	
}

function load_club($type,$campus) {
	include 'assets/connection.php';	
	
	$query=mysqli_query($con,"SELECT * FROM tblsaclubs WHERE type='$type' and campus='$campus' AND quota > 0");
	
	while($row=mysqli_fetch_array($query,MYSQLI_NUM)) {
	echo "<option value='$row[0]'>$row[2]</option>";
	}
	mysqli_close($con);
	
}

function load_course() {
	include 'assets/connection.php';	
	
	$query=mysqli_query($con,"SELECT DISTINCT(course) FROM tblstudents");
	
	while($row=mysqli_fetch_array($query,MYSQLI_NUM)) {
	echo "<option value='$row[0]'>$row[0]</option>";
	}
	mysqli_close($con);
}

?>