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

if(Input::exists()){
	$tagname = escape(Input::get('addtagname'));
	$tagdesc = escape(Input::get('addtagdesc'));
	$corporateID = $resultresult->corporateID;
	$companyID = $resultresult->companyID;
		
	function exists($data){
		if(empty($data)){
			return "Required";
		}else{
			return "Valid";
		}
	}


	function condition($data1, $data2){
		if($data1 === "Valid" && $data2 === "Valid"){
			return "Passed";
		}else{
			return "Failed";
		}
	}

	$tagnameerror = exists($tagname);
	if($tagnameerror === "Valid"){
		if (!preg_match("/^[a-zA-Z# ]*$/", $tagname)) {
		  $tagnameerror = "Only letters and white space allowed";
		}else{
			$tagnameerror = "Valid";
		}
	}

	$tagdescerror = exists($tagdesc);
	if($tagdescerror === "Valid"){
		if (!preg_match("/^[a-zA-Z., ]*$/", $tagdesc)) {
		  $tagdescerror = "Only letters and white space allowed";
		}else{
			$tagdescerror = "Valid";
		}
	}

	// $companyIDerror = exists($companyID);

	$condition = condition($tagnameerror, $tagdescerror);

	if($condition === "Passed"){

		$tagobject = new Tag();
		$tagobject->addTag(array(
				'corporateID' => $corporateID,
				'companyID' => $companyID,
				'tagname' => $tagname,
				'tagdesc' => $tagdesc
			));
		$array = [
				"condition" => $condition,
			];
		
	}else{
		$array = [
			"condition" => $condition,
			"tagname" => $tagnameerror,
			"tagdesc" => $tagdescerror,
		];
	}
	echo json_encode($array);
}
?>