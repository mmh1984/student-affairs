
<?php
if (isset($_POST['operation'])){
	
	$op= $_POST['operation'];
	
	switch($op){
	case "save":
	save_club();
	break;
	
	case "edit":
	edit_club($_POST["id"]);
	break;
	
	case "update":
	update_club();
	break;
	
	case "delete":
	delete_club($_POST["id"]);
	break;
	}
	
}
else {
?>
<script>
$(document).ready(function(e) {
    $("#btnsaveclub").click(function(e) {
        var campus=$("#campus").val();
		var clubname=$("#clubname").val();
		var clubtype=$("#clubtype").val();
		var quota=$("#quota").val();
		
		if(clubname=='') {
			$("#info").html("Enter the club name");
		}
		else if(quota==''){
			$("#info").html("Enter quota");
			}
		else if(parseInt(quota)==false){
			$("#info").html("Quota must be a number");
		}
		else {
		$("#info").html("<img src='images/loader.gif' width='30px' height='30px'>");
	
		var operation="save";
		var datastr="operation="+ operation + "&";
		datastr+="campus="+ campus +"&";
		datastr+="clubname="+ clubname +"&";
		datastr+="clubtype="+ clubtype +"&";
		datastr+="quota="+ quota;
	
        $.ajax({
			type:"POST",
			url:"actions/addclub.php",
			data:datastr,
			cache:false,
			success:function(result){
				$("#info").html(result);
			
			},
			complete:function(result) {
				
			}
			
		});	
		}
		
    });
});

</script>

<style>
.inputshort{
width:100px;
	
}
.inputmedium{
width:400px;	
}
table {
border-collapse:collapse;
padding:0;
}
input,select {
	
}

</style>
<p id='info' style="padding:5px;color:#03C;">(*) Required</p>

<table class="table table-responsive">

	
<tr>
<th>Campus</th>
<td><select id="campus" class="form-control inputshort">
	<option value="BSB">BSB</option>
    <option value="KB">KB</option>
</select>
</tr>

<tr>
<th>*Name</th>
<td><input type="text" id="clubname" class="form-control inputmedium"></td>
</tr>

<tr>
<th>Type</th>
<td><select id="clubtype" class="form-control inputmedium">
	<option value="Sports">Sports</option>
    <option value="Youth">Youth</option>
</select></td>
</tr>

<tr>
<th>Quota</th>
<td><input type="number" id="quota" class="form-control inputshort"></td>
</tr>
<tr>
<th></th>
<td><button class="btn btn-danger pull-left" id="btnsaveclub">Save</button>&nbsp;
</td>
</tr>

</table>

<?php
}
function save_club() {
	
$campus= $_POST['campus'];
	$club= $_POST['clubname'];
	$type= $_POST['clubtype'];
	$quota= $_POST['quota'];
	
	include '../assets/connection.php';
	$query="INSERT INTO tblsaclubs(campus,clubname,type,quota) VALUES";
	$query.="('$campus','$club','$type','$quota')";
	
	if(mysqli_query($con,$query)) {
	  echo "<script> alert('club added to the list'); </script>";
	  echo "<script>window.location.href='admin.php';</script>";
	  	
	}
	else {
	 echo (die(mysqli_error($con)));	
	}	
	
	mysqli_close($con);
}

function edit_club($id) {
	include '../assets/connection.php';	
	
	$query=mysqli_query($con,"SELECT * FROM tblsaclubs WHERE id=$id");
	
	
		
		
		while($row=mysqli_fetch_array($query,MYSQLI_NUM)) {
	
	?>
    
    <script>
$(document).ready(function(e) {
    $("#btnUpdate").click(function(e) {
        var campus=$("#campus").val();
		var clubname=$("#clubname").val();
		var clubtype=$("#clubtype").val();
		var quota=$("#quota").val();
		
		if(clubname=='') {
			$("#info").html("Enter the club name");
		}
		else if(quota==''){
			$("#info").html("Enter quota");
			}
		else if(parseInt(quota)==false){
			$("#info").html("Quota must be a number");
		}
		else {
		$("#info").html("<img src='images/loader.gif' width='30px' height='30px'>");
	
		var operation="update";
		var datastr="operation="+ operation + "&";
		var id=$("#clubid").val();
		datastr+="campus="+ campus +"&";
		datastr+="clubname="+ clubname +"&";
		datastr+="clubtype="+ clubtype +"&";
		datastr+="id="+ id +"&";
		datastr+="quota="+ quota;
	
        $.ajax({
			type:"POST",
			url:"actions/addclub.php",
			data:datastr,
			cache:false,
			success:function(result){
				$("#info").html(result);
			
			},
			complete:function(result) {
				
			}
			
		});	
		}
		
    });
});

</script>

<style>
.inputshort{
width:100px;
	
}
.inputmedium{
width:400px;	
}
table {
border-collapse:collapse;
padding:0;
}
input,select {
	
}

</style>
<p id='info' style="padding:5px;color:#03C;">(*) Required</p>

<table class="table table-responsive">

	
<tr><input type="hidden" id="clubid" value="<?php echo $id; ?>" />
<th>Campus</th>
<td><select id="campus" class="form-control inputshort">
	<option value="BSB">BSB</option>
    <option value="KB">KB</option>
</select>
</tr>

<tr>
<th>*Name</th>
<td><input type="text" id="clubname" class="form-control inputmedium" value="<?php echo $row[2];?>"></td>
</tr>

<tr>
<th>Type</th>
<td><select id="clubtype" class="form-control inputmedium">
	<option value="Sports">Sports</option>
    <option value="Youth">Youth</option>
</select></td>
</tr>

<tr>
<th>Quota</th>
<td><input type="number" id="quota" class="form-control inputshort" value="<?php echo $row[4];?>"></td>
</tr>
<tr>
<th></th>
<td><button class="btn btn-danger pull-left" id="btnUpdate">Update</button>&nbsp;
</td>
</tr>

</table>
    
    <?php
	
		}
	
		mysqli_close($con);


}

function update_club() {
	
	$campus= $_POST['campus'];
	$club= $_POST['clubname'];
	$type= $_POST['clubtype'];
	$quota= $_POST['quota'];
	$id=$_POST['id'];
	include '../assets/connection.php';
	$query="UPDATE tblsaclubs SET campus='$campus',clubname='$club',type='$type',quota='$quota'";
	$query.=" WHERE id=$id";
	
	if(mysqli_query($con,$query)) {
	  echo "<script> alert('Club details updated'); </script>";
	  echo "<script>window.location.href='admin.php';</script>";
	  	
	}
	else {
	 echo (die(mysqli_error($con)));	
	}	
	
	mysqli_close($con);
}

function delete_club($id) {
	include '../assets/connection.php';
	
	$query2=mysqli_query($con,"DELETE FROM tblsamembers WHERE clubid1=$id OR clubid2=$id");
	$query="DELETE FROM tblsaclubs WHERE id=$id";
	
	
	if(mysqli_query($con,$query)) {
	  echo "<script> alert('Club deleted from the list'); </script>";
	  echo "<script>window.location.href='admin.php';</script>";
	  	
	}
	else {
	 echo (die(mysqli_error($con)));	
	}	
	
	mysqli_close($con);
}
?>