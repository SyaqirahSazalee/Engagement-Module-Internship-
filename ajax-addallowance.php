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
	$corporateID = $resultresult->corporateID;
	if($resultresult->corporateID){
		$nickname = $resultresult->nickname;
		$corporateID = $resultresult->corporateID;
		$companyID = $resultresult->companyID;
	}else{
		$nickname = $resultresult->nickname;
		$companyID = $resultresult->companyID;
	}
	$point = escape(Input::get('point'));
	$description = escape(Input::get('description'));
		
	function exists($data){
		if(empty($data)){
			return "Required";
		}else{
			return "Valid";
		}
	}


	function condition($data1){
		if($data1 === "Valid"){
			return "Passed";
		}else{
			return "Failed";
		}
	}

	$pointerror = exists($point);

	$condition = condition($pointerror);

	if($condition === "Passed"){

		// add merit log after adding monthly allowance
		$meritlogobject = new Merit_log();
		$meritlogobject->addMerit_log(array(
			"from_user" => $nickname,
			"point" => $point,
			"description" => $description,
			"create_at" => date("Y-m-d H:i:s")
		));
		$array = [
			"condition" => $condition,
		];

		// fetch latest ID for merit log 
		$lastinsertmeritlogid = $meritlogobject -> lastinsertid();

		// fetch only user under corporate/company to give allowance
		$userobject = new User();
		if($resultresult->corporateID){
		$userresult = $userobject->searchWithCorporate($resultresult->corporateID);
		}
		else{
		$userresult = $userobject->searchWithCompany($resultresult->companyID);
		}

		if($userresult){
			foreach ($userresult as $row) {
				// adding allowance to current point for each user
				$newpoint = $point;

				// update user point from company
				$userobject = new User();
				$userobject->update(array(
					"point_company" => $newpoint
				), $row->userID, "userID");

				$array = [
					"condition" => $condition,
				];

				// add merit assign from admin to all user under corporate/company
				$meritassignobject = new Merit_assign();
				$meritassignobject->addMerit_assign(array(
					"logID" => $lastinsertmeritlogid,
					"to_user" => $row->nickname
				));
				$array = [
					"condition" => $condition,
				];
			}
		}
		
	}else{
		$array = [
			"condition" => $condition,
			"point" => $pointerror,
		];
	}
	echo json_encode($array);
}
?>