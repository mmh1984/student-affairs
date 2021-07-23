<?php
session_start();

if(!isset($_SESSION['sauser'])||!isset($_SESSION['site'])) {
	header('location:index.html');
}

else {
	if($_SESSION['salevel']!='admin') {
	header('location:index.html');
	}

	
$user=$_SESSION['sauser'];
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Kemuda Student Affairs|Login</title>
<link href="https://fonts.googleapis.com/css?family=Lato|Slabo+27px" rel="stylesheet">
<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="css/bootstrap-theme.min.css" rel="stylesheet" type="text/css">
<link href="css/custom.css" rel="stylesheet" type="text/css">
<script src="script/jquery.min.js" type="text/javascript"></script>
<script src="script/bootstrap.min.js" type="text/javascript"></script>


<script>
$(document).ready(function(e) {
	
	member_content();
	//$("#menu1").css("display","none");
	$("#menu2").css("display","none");
	$("#menu3").css("display","none");
	$("#menu4").css("display","none");
	//click the club link
    $("#clubs").click(function(e) {
      
	$("#menu1").fadeIn();
	$("#menu2").fadeOut();
	$("#menu3").fadeOut();
	$("#menu4").fadeOut();
    });
	
	//click the member link 
	$("#members").click(function(e) {
      
	$("#menu2").fadeIn();
	$("#menu1").fadeOut();
	$("#menu3").fadeOut();
	$("#menu4").fadeOut();
    });
	
	//click the member link 
	$("#changepass").click(function(e) {
      
	$("#menu2").fadeOut();
	$("#menu1").fadeOut();
	$("#menu3").fadeIn();
	$("#menu4").fadeOut();
    });
	//click the users link
	//click the member link 
	$("#users").click(function(e) {
      
	$("#menu2").fadeOut();
	$("#menu1").fadeOut();
	$("#menu3").fadeOut();
	$("#menu4").fadeIn();
	
    });
	
	//close
	$(".close").click(function(e) {
       var p=$(this).parent().parent().parent().parent().parent().attr("id");
	   var host=document.getElementById(p);
	   $(host).fadeOut();
    });
	
	
	$("#btnclose").hide();
	//add clubs
	$("#btnaddclub").click(function(e) {
		$(this).hide();
			$("#btnclose").show();
		$("#tableclub").css("display","none");
        $.ajax({
			url:"actions/addclub.php",
			cache:false,
			success:function(result){
				$("#clubcontent").html(result);
			}
			
		});
    });
	
	$("#btnclose").click(function(e) {
		$(this).hide();
		$("#btnaddclub").show();
      $("#clubcontent").html("");
	  $("#tableclub").fadeIn();
    });
	
	$("#logout").click(function(e) {
        window.location.href='logout.php';
    });
	//modal options
	
	$(".mainmodal #btnresetpassword").click(function(e) {
		var email=$("#email").val();
         edituser("reset",email);
    });
	
	$(".mainmodal #btndeleteuser").click(function(e) {
		var email=$("#email").val();
            edituser("delete",email);
    });
	
	
	$("#btnclosemodal").click(function(e) {
		$(".mainmodal").hide();
    });
	
	//main modal 2
	
	$("#adduser").click(function(e) {
		$(".mainmodal1").css("display","block");
        $(".mainmodal1").show();
    });
	
	$("#btnclosemodal1").click(function(e) {
		$(".mainmodal1").hide();
    });
	
	
	
	//save new user
	$("#btnsaveuser").click(function(e) {
        var username=$("#username").val();
		var fullname=$("#fullname").val();
		var campus=$("#campus").val();
		if(username==''||fullname=='') {
			$("#message").html("Please complete required(*) details");
			$("#message").css("display","block");
		}
		else {
			
		var str="username="+ username +"&";
			str+="fullname="+ fullname +"&";
			str+="campus="+ campus;
			
			
		$.ajax({
		type:"POST",
		url:"createuser.php",
		data:str,
		cache:false,
		success:function(result){
			if(result=='success') {
			alert("New user created");
				$(".mainmodal1").hide();
			}
			else {
			
				$(".mainmodal1 #message").html("This email is already taken");
			}
		},
		complete:function(result){
			
			$("#userlists").load(location.href + " #userlists");
		}			
		});	
		
		}
	});
	
	//edituser
	function edituser(option,user) {
		var str="option=" + option + "&";
			str+="user="+ user;
			
			
	 $.ajax({
		 	
		 	type:"POST",
			url:"edituser.php",
			data:str,
			cache:false,
			success:function(result){
				alert(result);
			},
			complete:function(result){
				$(".mainmodal").hide();
				$("#userlists").load(location.href + " #userlists");
				}
			
		});	
		
		return false;
	}
	
	//update password

$("#btnchangepass").click(function(e) {
    var oldpass=$("#oldpass").val();
	var newpass=$("#newpass").val();
	
	if(oldpass==''||newpass=='') {
		
		alert("Please complete the details");
		
	}
	else if(oldpass!=newpass){
		alert("Passwords didnt match");
	}
	
	else {
		
		var str="newpass="+ newpass
	
		$.ajax({
		type:"POST",
		url:"changepass.php",
		data:str,
		cache:false,	
		success:function(result){
			if(result=="success"){
				alert("Your password has been updated.Please login again to continue");
				window.location.href='logout.php';
			}
			else {
			alert(result);	
			}
		},
		complete:function(result){
			
		}
		});	
		
	}
});


//custom filter 

$("#btnIC").click(function(e) {

    club_filter("ic");
});

$("#btnCOURSE").click(function(e) {
      club_filter("course");
});

$("#btnIntake").click(function(e) {
      club_filter("intake");
});

$("#btncampus").click(function(e) {
      club_filter("campus");
});

$("#btnRESET").click(function(e) {
    member_content();
});

function club_filter(status){
		$("#memberlist").html("<img src='images/loader.gif' width='50px' height='50px'>");
	
	var campus=$("#campusselected").val();
	var ic=$("#filteric").val();
	var course=$("#filtercourse").val();
	var level=$("#filterlevel").val();
	var intake=$("#intake").val();
	var campus2=$("#selectcampus").val();
	var str="ic="+ ic +"&";
		str+="course="+ course +"&";
		str+="level="+ level+"&";
		str+="intake="+ intake+"&";
		str+="campus="+ campus2+"&";
		str+="filter="+status
		
	
	$.ajax({
	type:"POST",
	url:"sortadmin.php",
	data:str,
	cache:false,
	success:function(result){
			
		$("#memberlist").html(result);
	},
	complete:function(result){
		$("#loader").hide();
		$("#btnviewall").show();
	}	
		
	});

	}


	
});
//filter




//load contents
function member_content(){
		$("#memberlist").html("<img src='images/loader.gif' width='50px' height='50px'>");
	
	var campus=$("#campusselected").val();
	var str="campus="+ campus ;
	
	
	$.ajax({
	type:"POST",
	url:"clubmembers.php",
	data:str,
	cache:false,
	success:function(result){
			
		$("#memberlist").html(result);	
	},
	complete:function(result){
		$("#loader").hide();
	
	}	
		
	});
	


	}

//


function editclub(id) {
	$("#clubcontent").html("<img src='images/loader.gif' width='50px' height='50px'>");
	$("#tableclub").hide();
	$("#btnaddclub").hide();
	$("#btnclose").show();
	var op="edit";
	var str="operation="+ op +"&";
		str+="id="+id;
	 $.ajax({
		 	type:"POST",
			url:"actions/addclub.php",
			data:str,
			cache:false,
			success:function(result){
				$("#clubcontent").html(result);
			},
			complete:function(result){
				
				}
			
		});
	}
	
function deleteclub(id) {
	$("#clubcontent").html("<img src='images/loader.gif' width='50px' height='50px'>");
	$("#tableclub").hide();
	$("#btnaddclub").hide();
	$("#btnclose").show();
	var op="delete";
	var str="operation="+ op +"&";
		str+="id="+id;
	 $.ajax({
		 	type:"POST",
			url:"actions/addclub.php",
			data:str,
			cache:false,
			success:function(result){
				$("#clubcontent").html(result);
			},
			complete:function(result){
				
				}
			
		});
	}

function optionmodal(email) {
	$(".mainmodal").css("display","block");
	$("#email").val(email);
	
}

function show_members(id,name){
$("#btnshowmembers").click();
$("#clubname").html(name);

$.ajax({
type:"POST",
url:"script/functions.php",
data:{
	clubmembers:id	
},
success:function(result){
	$("#clubmembers").html(result);	
}
	
});
}
</script>
</head>


<body>
<div class="container-fluid">
<div class="row toprow">
<div class="col-md-1"><img src="images/home.png"  width="20px"></div>
<div class="col-md-5">Welcome:<?php echo $user ?></div>
<div class="col-md-6">
<div class="nav-pills  pull-right">
<ul class="nav nav-pills nav-justified text-center">
<li class="btn navpill" id="users">View Users</li>
<li class="btn navpill" id="clubs">Clubs</li>
<li class="btn navpill" id="members">Members</li>
<li class="btn navpill" id="changepass">Change Password</li>
<li class="btn navpill" id="logout">Logout</li>
</ul>
</div>
</div>
</div>
<div class="spacer"></div>


<div class="container" >
<div class="panel shadow top" id="menu1">
<div class="panel panel-heading">
<div class="row">
<div class="col-md-12"><h2 class="page-header text-primary">Clubs<span class="close">&otimes;</span></h2>
<button class="btn btn-primary pull-right" id="btnaddclub">+</button><button class="btn btn-primary pull-right" id="btnclose">cancel</button>
<br/><br/>
</div>
<div class="panel panel-body">
	<div class='displaytable'>
      <div id="clubcontent"></div>
 	   <?php
	   include 'script/functions.php';
	  load_club_admin();
	   
	   ?>
 
    </div>

</div>
<div class="panel panel-footer well text-center">
copyright &copy; <a href='http://www.kemudainstitute.com'>KEMUDA</a> 2017
</div>
</div>

</div>

</div>

<!--GROUPS-->
<div class="panel shadow top" id="menu2">
<div class="panel panel-heading">
<div class="row">
<div class="col-md-12"><h2 class="page-header text-primary">Club Members<span class="close">&otimes;</span></h2>

<br/><br/>
</div>
<div class="panel panel-body">
<kbd>Filter</kbd>
<table>
<tr>
<td style="font-weight:bold">ic-number</td>
<td><input type="text" id="filteric" placeholder='00-000000' class='inputshort' style='padding:2px;border-radius:3px;border:1px #666 inset;'>
<button id='btnIC' class='btn btn-info btn-sm'>Apply</button>
</td>
<td style="font-weight:bold">Course</td>
<td><select id="filtercourse" class="inputshort" style='padding:2px;border-radius:3px;border:1px #666 inset;'>
<?php
load_course();
 ?>
 </select>
 <strong>Level</strong>
 <select id="filterlevel" class='inputshort' style='padding:2px;border-radius:3px;border:1px #666 inset;'>
 <option value='L2'>L2</option>
 <option value='L3'>L3</option>
 <option value='L4'>L4</option>
 <option value='L5'>L5</option>
 </select>
 <button id='btnCOURSE' class='btn btn-info btn-sm'>Apply</button>
</td>
<td><button id='btnRESET' class='btn btn-default btn-sm'>Reset</button></td>
</tr>
<tr>
<td style="font-weight:bold">Intake:</td>
<td>
<select id='intake' class='inputshort' style='padding:2px;border-radius:3px;border:1px #666 inset;'>

<?php
include 'assets/connection.php';
$query=mysqli_query($con,"SELECT DISTINCT intake FROM tblstudents");
while($r=mysqli_fetch_array($query)){
echo "<option value='$r[0]'>$r[0]</option>";	
}
mysqli_close($con);
?>
</select>
 <button id='btnIntake' class='btn btn-info btn-sm'>Apply</button>
</td>



<td style="font-weight:bold">Campus:</td>
<td>
<select id='selectcampus' class='inputshort' style='padding:2px;border-radius:3px;border:1px #666 inset;'>

<option value='BSB'>BSB</option>
<option value='KB'>KB</option>

</select>
 <button id='btncampus' class='btn btn-info btn-sm'>Apply</button>
</td>
</tr>
</table>
<div class='spacer'></div>
<button class='btn btn-default pull-right' id='btndownload'>Download</button>
<div class="displaytable2">

<div id="memberlist"></div>
    
    
    
</div>

<br/>




</div>
<div class="panel panel-footer well text-center">
copyright &copy; <a href='http://www.kemudainstitute.com'>KEMUDA</a> 2017
</div>
</div>

</div>

</div>


<!--END-->

<!--CHANGE PASS-->
<div class="panel shadow top" id="menu3">
<div class="panel panel-heading">
<div class="row">
<div class="col-md-12"><h2 class="page-header text-primary">Change Password<span class="close">&otimes;</span></h2>

<br/><br/>
</div>

	<div class="panel panel-body">
     <div class='displaytable'>
     
     <table class="table table-responsive">
     	<tr>
        <th>*New Password:</td>
        <td><input type="password" id="oldpass" class='form-control inputsmall'></td>
        </th>
        <tr>
          <th>*Confirm Password:</td>
        <td><input type="password" id="newpass"  class='form-control inputsmall'></td>
        </tr>
        <tr>
        <th></th>
        <td><button id="btnchangepass" class="btn btn-default pull-left">Change</button>
        </tr>
     
     </table>
     </div>
      
      
</div>
<div class="panel panel-footer well text-center">
copyright &copy; <a href='http://www.kemudainstitute.com'>KEMUDA</a> 2017
</div>
</div>

</div>

</div>


<!--END-->

<!--view users -->
<div class="panel shadow top" id="menu4">
<div class="panel panel-heading">
<div class="row">
<div class="col-md-12"><h2 class="page-header text-primary">User List<span class="close">&otimes;</span></h2>

<br/><br/>
</div>

	<div class="panel panel-body ">
     
      <div class="displaytable">
      <button class="btn btn-default pull-right" id="adduser">Add User</button>
       <div id="userlists">
      <input type='hidden' id='email'>
      	<table class="table" >
        <tr>
        <th>Username</th>
        <th>Full Name</th>
        <th>Account Level</th>
        <th>Campus Level</th>
        <th>Option</th>
        </tr>
        <?php
		include 'assets/connection.php';
		$query=mysqli_query($con,"SELECT * FROM tblsausers ORDER BY level ASC");
		while($row=mysqli_fetch_array($query,MYSQLI_NUM)){
			echo"<tr>";
			echo "<td>$row[0]</td>";
			echo "<td>$row[2]</td>";
			echo "<td>$row[3]</td>";
			echo "<td>$row[4]</td>";
			echo "<td>
			
			<button class='btn btn-danger' onClick='optionmodal(\"$row[0]\")'>Edit</button></td>";
			
			echo "</tr>";
		}
		mysqli_close($con);
		
		?>
        </div>
        </table>
      
      </div>
      
</div>
<div class="panel panel-footer well text-center">
copyright &copy; <a href='http://www.kemudainstitute.com'>KEMUDA</a> 2017
</div>
</div>

</div>

</div>

<!--end -->

<!--user option modal -->

<!-- Logout Modal-->
<div class="mainmodal panel panel-primary">
<div class="panel-heading bg-primary">
<h3>Message<span id="btnclosemodal" class="btn btn-default pull-right small">x</span></h3>
</div>
<div class="panel-body" id="panelcontent">
<p id="messagecontent">Choose Operation</p>
<br/>
<p class="btn btn-info" id="btnresetpassword">Reset Password</p>
<p class="btn btn-danger" id="btndeleteuser" >Delete User</p>

</div>
</div>
<!--end-->

<!--add user modal -->

<div class="mainmodal1 panel panel-primary">
<div class="panel-heading bg-primary">
<h3>Add User<span id="btnclosemodal1" class="btn btn-default pull-right small">x</span></h3>
</div>
<div class="panel-body">
<p class="well text-danger" id="message"></p>
<table class="table table-responsive">
<tr>
<th>*username:</th>
<td><input type="text" id="username" class="form-control" placeholder="username"></td>
</tr>
<tr>
<th>*Full Name:</th>
<td><input type="text" id="fullname" class="form-control" placeholder="full name"></td>
</tr>
<tr>
<th>*Campus:</th>
<td><select id="campus" class="form-control">
<option value="BSB">BSB</option>
<option value="KB">KB</option>

</select></td>
</tr>

<tr>
<th>*Password</th>
<td>default("password")</td>
</tr>


</table>
<br/>
<p class="btn btn-info" id="btnsaveuser">Save</p>


</div>
</div>
</div>
</div>
<button data-toggle='modal' data-target='#membermodal' id='btnshowmembers' hidden="true">Show</button>
<div class='modal fade' id='membermodal' role='dialog'>
<div class='modal-dialog modal-lg'>
<div class='modal-content'>
<div class='modal-header'>
<h3>Club: <span id='clubname' class='text-success'>name</span></h3>

</div>
<div class='modal-body' id='clubmembers'>

</div>
<div class='modal-footer'>
<button class='btn btn-danger' data-dismiss='modal'>Close</button>
</div>
</div>
</div>
</div>

</body>
</html>
<?php
}
?>