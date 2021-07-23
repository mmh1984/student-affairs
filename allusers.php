<?php
session_start();

if(!isset($_SESSION['user']) || (!isset($_SESSION['level']))){
	
	header("location:index.html");
	
}
else {
	if($_SESSION['level']!='administrator'){
	header("location:index.html");
	}
	$username=$_SESSION['user'];
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Search</title>
<link href="https://fonts.googleapis.com/css?family=Lato|Slabo+27px" rel="stylesheet">
<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
<link href="css/custom.css" rel="stylesheet" type="text/css"/>
<script src="script/jquery.min.js" type="text/javascript"></script>
<script src="script/bootstrap.min.js" type="text/javascript"></script>
<script>

$(document).ready(function(e) {
	
	$("#message").css("display","none");
    $("#btnclose,.mainmodal1 #btnclose").click(function(e) {
        $(".mainmodal").css("display","none");
		$(".mainmodal1").css("display","none");  
    });
	
	$(".mainmodal #btnresetpassword").click(function(e) {
		var email=$("#email").val();
          window.location.href="edituser.php?option=reset&email="+email;
    });
	
	$(".mainmodal #btndeleteuser").click(function(e) {
		var email=$("#email").val();
          window.location.href="edituser.php?option=delete&email="+email;
    });
	
	$("#adduser").click(function(e) {
        $(".mainmodal1").css("display","block");
    });
	
	
	$("#btnsaveuser").click(function(e) {
        var email=$("#newemail").val();
		var level=$("#userlevel").val();
		var name=$("#name").val();
		if(email==''||name=='') {
			$("#message").html("Please complete required(*) details");
			$("#message").css("display","block");
		}
		else {
			
		var str="email="+ email +"&";
			str+="name="+name+"&";
			str+="level="+level;
			
		$.ajax({
		type:"POST",
		url:"createuser.php",
		data:str,
		cache:false,
		success:function(result){
			if(result=='success') {
			$(".mainmodal1 #message").css("display","block");
				$(".mainmodal1 #message").html("<a href='allusers.php' class='btn btn-primary'>New user created</a>");
				
					$(".mainmodal1 #message").nextAll().remove();
				
			}
			else {
				$(".mainmodal1 #message").css("display","block");
				$(".mainmodal1 #message").html("This email is already taken");
			}
		}			
			
		});
		
		}
		
		return false;
    });
	
});

function redirectPage(url){
	window.location.href=url;
}

function optionmodal(email) {
	$(".mainmodal").css("display","block");
	$("#email").val(email);
	
}


	
</script>
</head>


<section>
  <div class="container" id="searchdiv">
    <div class="panel panel-primary">
      <div class="panel panel-heading">
        <div class="btn-group btn-group-sm pull-right">
 
  <div class="btn-group btn-group-sm">
    <button type="button" class="btn btn-primary" onClick="redirectPage('adminuser.php')">Back</button>
   
  </div>
</div>
<h2>User List</h2>
      </div>
      <div class="panel panel-body">
      <button class="btn btn-default media-right" id="adduser">Add User</button>
      <div class="table table-condensed">
      	<table class="table">
        <tr>
        <th>Email</th>
        <th>Full Name</th>
        <th>Account Level</th>
        <th>Option</th>
        </tr>
        <?php
		include 'assets/connection.php';
		$query=mysqli_query($con,"SELECT * FROM tblusers");
		while($row=mysqli_fetch_array($query,MYSQLI_NUM)){
			echo"<tr>";
			echo "<td>$row[0]</td>";
			echo "<td>$row[2]</td>";
			echo "<td>$row[3]</td>";
			echo "<td><input type='hidden' id='email'  /></td>";
			echo "<td><button class='btn btn-danger' onClick='optionmodal(\"$row[0]\")'>Edit</button></td>";
			
			echo "</tr>";
		}
		mysqli_close($con);
		
		?>
        </table>
      
      </div>
      
      
      </div>
        <div class="panel-footer text-center">
 
<kbd class="bg-primary logininfo">Logged as: <?php echo $username ?></kbd>
<br/><br/>
<mark class="text-info">Copyright@kemuda 2017</mark>
  </div>
      </div>
    </div>
  </div>
  </div>
</section>


<!-- Logout Modal-->
<div class="mainmodal panel panel-primary">
<div class="panel-heading bg-primary">
<h3>Message<span id="btnclose" class="btn btn-default pull-right small">x</span></h3>
</div>
<div class="panel-body" id="panelcontent">
<p id="messagecontent">Choose Operation</p>
<br/>
<p class="btn btn-info" id="btnresetpassword">Reset Password</p>
<p class="btn btn-danger" id="btndeleteuser" >Delete User</p>

</div>
</div>

<!-- Logout Modal-->
<div class="mainmodal1 panel panel-primary">
<div class="panel-heading bg-primary">
<h3>Message<span id="btnclose" class="btn btn-default pull-right small">x</span></h3>
</div>
<div class="panel-body">
<p class="well text-danger" id="message"></p>
<table class="table table-responsive">
<tr>
<th>*Full Name:</th>
<td><input type="text" id="name" class="form-control" placeholder="FULL NAME"></td>
</tr>
<tr>
<th>*Email:</th>
<td><input type="email" id="newemail" class="form-control" placeholder="email@kemudainstitute.com" value="email@kemudainstitute.com"></td>
</tr>

<tr>
<th>*Password</th>
<td>default("password")</td>
</tr>

<tr>
<th>Userlevel</th>
<td><select id="userlevel" class="form-control">
	<option value="administrator">Administrator</option>
    <option value="accounts">Account User</option>

</select></td>
</tr>
</table>
<br/>
<p class="btn btn-info" id="btnsaveuser">Save</p>


</div>
</div>

</html>

<?php
}
?>