<?php
session_start();

if(!isset($_SESSION['sauser'])||!isset($_SESSION['site'])) {
	header('location:index.html');
}

else {
	if($_SESSION['salevel']!='committee') {
	header('location:index.html');
	}

$campus=$_SESSION["campus"];
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
	
	//download table
	//downloadtoexcel
	$("#btndownload").click(function(e) {
   
  $("#tabledownload").table2excel({
    // exclude CSS class
    exclude: ".noExl",
    name: "Worksheet Name",
    filename: "official receipt" //do not include extension
  }); 

    });
	
	$("#btnviewall").click(function(e) {
       $("#menu4").show();
		
    });
	
	$("#loader").hide();
	$("#btnviewall").hide();
	club_content("guest");
	show_non_members();
	$("#clubdetails").css("display","none");
	member_content();
	//$("#menu1").css("display","none");
	$("#menu2").css("display","none");
	$("#menu3").css("display","none");
	$("#menu4").css("display","none");
	//click the club link
    $("#clubs").click(function(e) {
  
	$("#menu1").fadeIn();
	 club_content("guest");
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
	
	//view all 
	$("#viewmembers").click(function(e) {
     $("#menu2").fadeOut();
	$("#menu1").fadeOut();
	$("#menu3").fadeOut();
	$("#menu4").fadeIn();
	member_content();
    });
	
	//search ic
	$("#searchic").click(function(e) {
		$("#clubdetails").fadeOut();
        var ic=$("#ic").val();
		var campus=$("#campus").val();
		if(ic=='') {
			alert("Please enter the ic number");
		}
		else {
			
		$("#studentdetails").html("<img src='images/loader.gif' width='50px' height='50px'>");
			
		var str="ic="+ ic + "&"
		str+="campus=" + campus;
		
		$.ajax({
		
		type:"POST",
		url:"script/functions.php",
		data:str,
		cache:false,
		success:function(result){
			if(result=='none'){
				alert("IC-NUMBER not found!");
				$("#clubdetails").fadeOut();
				$("#studentdetails").html("");
			}
			else {
			$("#clubdetails").fadeIn();
			$("#studentdetails").html(result);
			
	//initial club
	var club1initial=$("#club1:first-child").val();
	var club2initial=$("#club2:first-child").val();

	count_remaining1(club1initial);
	count_remaining2(club2initial);
			}
		},
		complete:function(result){
			
		}	
			
		});	
			
		}
    });
	
	//club selection
	$("#club1").change(function(e) {
		$("#club1qty").html("<img src='images/loader.gif' width='10px' height='10px'>");
        count_remaining1($(this).val());
    });
	$("#club2").change(function(e) {
		$("#club2qty").html("<img src='images/loader.gif' width='30px' height='30px'>");
		count_remaining2($(this).val());
        
    });
	//
	
	$("#btnsavemember").click(function(e) {
        var club1=$("#club1").val();
		var club2=$("#club2").val();
		var ic=$("#ic").val();
		var phone=$("#phone").val();
		var max1=$("#club1qty").val();
		var max2=$("#club2qty").val();
		
		
		
		if(phone=='') {
		alert('Please enter a valid phone number');	
		} 
		else {
		
		if(parseInt(max1)==0||parseInt(max2)==0){
		alert("One of the group has no available slots");	
		}
				
		$("#studentdetails").html("<img src='images/loader.gif' width='50px' height='50px'>");
		var str="icnumber=" + ic +"&"
			str+="club1=" + club1 +"&"
			str+="club2=" + club2 +"&"
			str+="phone=" + phone +"&"
		$.ajax({
		type:"POST",
		url:"members.php",
		data:str,
		cache:false,
		success:function(result){
			if(result=="success"){
			alert("Member added to the group");	
			$("#ic").val("");
		$("#phone").val("");
			}
			else {
			alert(result);	
				$("#ic").val("");
		$("#phone").val("");
			}
		},
		complete:function(result){
			$("#clubdetails").fadeOut();
				$("#studentdetails").html("");
		}		
			
		})	
			
		}
    });
	
	//close
	$(".close").click(function(e) {
       var p=$(this).parent().parent().parent().parent().parent().attr("id");
	   var host=document.getElementById(p);
	   $(host).fadeOut();
    });
	
	
	
	$("#logout").click(function(e) {
        window.location.href='logout.php';
    });
	
	
	//count remaining slots
	function count_remaining1(id) {
	
	var str="clubid="+id;
	
	$.ajax({
	type:"POST",
	url:"script/functions.php",
	data:str,
	cache:false,
	success:function(result){
		
		$("#club1qty").html(result);	
		
	}
	});
	return false;
	}
	
	function count_remaining2(id) {
	
	var str="clubid="+id;
	
	$.ajax({
	type:"POST",
	url:"script/functions.php",
	data:str,
	cache:false,
	success:function(result){
		
		$("#club2qty").html(result);	
		
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


//delete

$("#deletemember").click(function(e) {
	var selected=[];
    $('.clubselect:checked').each(function(){
   selected.push($(this).val());
});

var count=selected.length;

if(count==0) {
	alert("Select ic-number to delete");
}
else {
	var ask=confirm("Proceed with this operation?");
	var str="selected="+selected;
	if(ask==true) {
	
	$.ajax({
	type:"POST",
	url:"deletemember.php",
	data:{selected: selected},
	cache:false,
	success:function(result){
	
	
	member_content();	
	},
	complete:function(result){
		alert("Students removed from the club");
	}
	
	});
	
	
	}
	
}


});

//load members
function member_content(){
	$("#memberlist").html("<img src='images/loader.gif' width='50px' height='50px'>");
	$("#loader").show();
	$("#btndeleteuser").hide();
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
		$("#btndeleteuser").show();
	
	}	
		
	});
	


	}

//custom filter 

$("#btnIC").click(function(e) {

    club_filter("ic");
});
$("#btnIntake").click(function(e) {
      club_filter("intake");
});

$("#btnCOURSE").click(function(e) {
      club_filter("course");
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
	var str="campus="+ campus +"&";
		str+="ic="+ ic +"&";
		str+="course="+ course +"&";
		str+="level="+ level+"&";
		str+="intake="+ intake+"&";
		str+="filter="+status
		
	
	$.ajax({
	type:"POST",
	url:"sortmember.php",
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


function club_content(status){
	$("#loader").show();
	
	var campus=$("#campusselected").val();
	var str="campus="+ campus +"&";
	str+="load="+status;

	$.ajax({
	type:"POST",
	url:"script/functions.php",
	data:str,
	cache:false,
	success:function(result){
			
		$("#clubcontent").html(result);	
	},
	complete:function(result){
		$("#loader").hide();
		$("#btnviewall").show();
	}	
		
	});
	return false;
	}
	
	
	
	
	
});

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



function show_non_members(){


$.ajax({
type:"POST",
url:"script/functions.php",
data:{
	nonemembers:"nonemembers"	
},
success:function(result){
	$("#allmembers").html(result);	
}
	
});


}

function filter_student(){
	var course=$("#studentcourse").val();
	var intake=$("#studentintake").val();
	
	$.ajax({
type:"POST",
url:"script/functions.php",
data:{
	nonemembers:"nonemembers",
	course:course,
	intake:intake	
},
success:function(result){
	$("#allmembers").html(result);	
}
	
});
	
}

function add_ic(ic){
$("#ic").val(ic);
$("#searchic").click();	
}

function download_non_members(){
	
   
  $("#tblnonmembers").table2excel({
    // exclude CSS class
    exclude: ".noExl",
    name: "Worksheet Name",
    filename: "studentlist" //do not include extension
  }); 
}

function download_club_members(){
	
   
  $("#tblclubmembers").table2excel({
    // exclude CSS class
    exclude: ".noExl",
    name: "Worksheet Name",
    filename: "studentlist" //do not include extension
  }); 
}
</script>
</head>


<body>
<div class="container-fluid">
<div class="row toprow">
<div class="col-md-1"><img src="images/home.png"  width="20px"></div>
<div class="col-md-5">Welcome:<?php echo $user; ?></div>
<div class="col-md-6">
<div class="nav-pills  pull-right">
<ul class="nav nav-pills nav-justified text-center">
<li class="btn navpill" id="viewmembers">Members</li>
<li class="btn navpill" id="clubs">Clubs</li>
<li class="btn navpill" id="members">Add Members</li>
<li class="btn navpill" id="changepass">Change Password</li>
<li class="btn navpill" id="logout">Logout</li>
</ul>
</div>
</div>
</div>
<div class="spacer"></div>


<div class="container" >
<input type="hidden" id="campusselected" value="<?php echo $campus ?>">

<div class="panel shadow top" id="menu1">

<div class="panel panel-heading">
<div class="row">
<div class="col-md-12"><h2 class="page-header text-primary">Clubs<span class="close">&otimes;</span></h2>

<br/><br/>
</div>
<div class="panel panel-body">

	<div class='displaytable'>
    <img src="images/loader.gif" width='50px' height='50px' id='loader'>
      <div id="clubcontent">
 	  
 </div>
 <button class='btn btn-default' id='btnviewall'>Show members</button>
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
<div class="col-md-12"><h2 class="page-header text-primary">Add Club Members<span class="close">&otimes;</span></h2>

<br/><br/>
</div>
<div class="panel panel-body">
<div class="displaytable">
	<table class="table">
    <tr>
    <td><kbd>Enter IC-NUMBER to search:</kbd></td>
    <td><input type="text" id="ic" placeholder="00-000000" class="form-control inputsmall">
  <input type="hidden" id="campus" value="<?php echo $campus; ?>">
    </td>
    </tr>
    <tr>
    <td></td>
    <td><button id="searchic" class="btn btn-default pull-left">Search</button>
    <button  class="btn btn-default pull-left" data-toggle='modal' data-target='#allstudents'>View All Students</button>
    </tr>
    
    </table>
    <div id="studentdetails">
    
    </div>
    
    <table class="table table-responsive" id="clubdetails">
    <tr>
    <td>Phone Number</td>
    <td><input type="text" id="phone" placeholder="+(673)-0000000" class="form-control inputsmall">
  
    </td>
    </tr>
     <tr>
    <td>Youth Club</td>
    <td><select id="club1" class='form-control inputmedium'>
    <?php
	include 'script/functions.php';
	load_club("Youth",$campus);
	?>
  
    </select>
    <span class='text-info pull-left'>Remaining Slots: <span id='club1qty'></span>
  
    </span>
    </td>
    </tr>
    
    <tr>
    <td>Sports Club</td>
    <td><select id="club2" class='form-control inputmedium'>
    <?php
	
	load_club("Sports",$campus);
	?>
    
    </select>
    <span class='text-info pull-left'>Remaining Slots: <span id='club2qty'></span>
  
    </span>
    </td>
    </tr>
    
    <tr>
    <td></td>
    <td><button id="btnsavemember" class="btn btn-default pull-left">Save</button>
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

<!--club list-->

<div class="panel shadow top" id="menu4">
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
<td>Course</td>
<td><select id="filtercourse" class="inputshort" style='padding:2px;border-radius:3px;border:1px #666 inset;'>
<?php
load_course();
 ?>
 </select>
 Level
 <select id="filterlevel" class='inputshort' style='padding:2px;border-radius:3px;border:1px #666 inset;'>
 <option value='L2'>L2</option>
 <option value='L3'>L3</option>
 <option value='L4'>L4</option>
 <option value='L5'>L5</option>
 </select>
 <button id='btnCOURSE' class='btn btn-info btn-sm'>Apply</button>
</td>
<td>Intake:</td>
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

<td><button id='btnRESET' class='btn btn-default btn-sm'>Reset</button></td>
</tr>
</table>
<div class='spacer'></div>
<button class='btn btn-default pull-right' id='btndownload'>Download</button>
<div class="displaytable2">

<div id="memberlist"></div>
    
    
    
</div>

<br/>
<button class='btn btn-danger center-block' id='deletemember'>Delete</button>



</div>
<div class="panel panel-footer well text-center">
copyright &copy; <a href='http://www.kemudainstitute.com'>KEMUDA</a> 2017
</div>
</div>

</div>

</div>
<!--end-->

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

<!--end-->

<div class='modal fade' id='allstudents' role='dialog'>
<div class='modal-dialog modal-lg'>
<div class='modal-content'>
<div class='modal-header'>
<h3>Student List</h3>
<div class='well'>
Filter
<select id='studentcourse' class='inputsmall'>
	<option value='NCC'>NCC</option>
    <option value='BTEC'>BTEC</option>
    <option value='LCCI'>LCCI</option>
    <option value='OUM'>OUM</option>
    <option value='KEMUDA Certificate'>KEMUDA Certificate</option>
</select>
<select id='studentintake' class='inputsmall'>
<?php
include 'assets/connection.php';
$query=mysqli_query($con,"SELECT DISTINCT intake FROM tblstudents");
while($r=mysqli_fetch_array($query)){
echo "<option value='$r[0]'>$r[0]</option>";	
}
mysqli_close($con);
?>
</select>
<button class='btn btn-primary' onClick="filter_student()">Apply</button>
<hr/>

</div>
</div>
<div class='modal-body' id='allmembers'>

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

<script src="script/jquery.table2excel.js" type="text/javascript"></script>