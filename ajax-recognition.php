<?php
require_once 'core/init.php';
$user = new User();
if(!$user->isLoggedIn()){
  Redirect::to("login.php");
}else{
  $resultresult = $user->data();
  $userlevel = $resultresult->role;
  if($resultresult->verified == false || $resultresult->superadmin == true){
    $user->logout();
    Redirect::to("login.php?error=error");
  }
}

$view = "";
if($useresult){
	$view .= 
	"
	<ul class='list-group list-group-flush' id='showuserslist'>
		<li class='list-group-item px-0'>
			<div class='row'>
				<div class='col-2'>
					<b>Name</b>
				</div>
				<div class='col-3'>
					<b>Email</b>
				</div>
				<div class='col-2'>
					<b>Job Position</b>
				</div>
				<div class='col-1'>
					<b>Role</b>
				</div>
				<div class='col-1 text-center'>
					<b>Status</b>
				</div>
				<div class='col-1 text-center'>
					<b>Points</b>
				</div>
				<div class='col-2 text-center'>
					<b>Action</b>
				</div>
			</div>
		</li>
	";
	foreach ($useresult as $row) {

		if(isset($_GET['lang'])){
	        if($_GET['lang'] == "en"){
	          if($row->role === "Chief"){
	            $role = $array['chief'];
	          }elseif($row->role === "Superior"){
	            $role = $array['superior'];
	          }elseif($row->role === "Manager"){
	            $role = $array['manager'];
	          }elseif($row->role === "Personal"){
	            $role = $array['personal'];
	          }
	        }elseif ($_GET['lang'] == "zh") {
	          if($row->role === "Chief"){
	            $role = $array['chief'];
	          }elseif($row->role === "Superior"){
	            $role = $array['superior'];
	          }elseif($row->role === "Manager"){
	            $role = $array['manager'];
	          }elseif($row->role === "Personal"){
	            $role = $array['personal'];
	          }
	        }elseif($_GET['lang'] == "bm"){
	          if($row->role === "Chief"){
	            $role = $array['chief'];
	          }elseif($row->role === "Superior"){
	            $role = $array['superior'];
	          }elseif($row->role === "Manager"){
	            $role = $array['manager'];
	          }elseif($row->role === "Personal"){
	            $role = $array['personal'];
	          }
	        }else{
	          if($row->role === "Chief"){
	            $role = $array['chief'];
	          }elseif($row->role === "Superior"){
	            $role = $array['superior'];
	          }elseif($row->role === "Manager"){
	            $role = $array['manager'];
	          }elseif($row->role === "Personal"){
	            $role = $array['personal'];
	          }
	        }
	    }

		if(isset($_GET['lang'])){
	      if($_GET['lang'] == "en"){
	        if($row->status === "Active"){
	          $status = $array['active'];
	        }else{
	          $status = $array['notactive'];
	        }
	      }elseif ($_GET['lang'] == "zh") {
	        if($row->status === "Active"){
	          $status = $array['active'];
	        }else{
	          $status = $array['notactive'];
	        }
	      }elseif($_GET['lang'] == "bm"){
	        if($row->status === "Active"){
	          $status = $array['active'];
	        }else{
	          $status = $array['notactive'];
	        }
	      }else{
	        if($row->status === "Active"){
	          $status = $array['active'];
	        }else{
	          $status = $array['notactive'];
	        }
	      }
	    }

		if($row->profilepic){
        	$pic = "data:image/jpeg;base64,".base64_encode($row->profilepic);
        }else{
        	$pic = "img/userprofile.png";
        }

		$view .= 
		"
		<li class='list-group-item px-0 searchusers all ".$role." ".$status."'>
			<div class='row'>
				<div class='col-2'>
					<img src='".$pic."' class='rounded-circle' width='30' height='30' style='object-fit: cover;''> ".$row->firstname." ".$row->lastname."
				</div>
				<div class='col-3'>
					".$row->email."
				</div>
				<div class='col-2'>
					".$row->jobposition."
				</div>
				<div class='col-1'>
					".$row->role."
				</div>
				<div class='col-1 text-center'>
					".$row->status."
				</div>
				<div class='col-1 text-center'>
					".$row->points."
				</div>
				<div class='col-2 text-center'>
					<a href='#' class='editUser' data-toggle='modal' data-id='".$row->userID."' data-target='#adminedituser'>Edit</a> | 
                  	<a href='#' class='deleteUser' data-toggle='modal' data-id='".$row->userID."' data-target='#admindeleteuser'>Delete</a>
				</div>
			</div>
		</li>
		";
	}
	$view .= 
	"
	</ul>
	";
}