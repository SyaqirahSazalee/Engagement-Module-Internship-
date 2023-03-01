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
	$addrecogdesc = escape(Input::get('addrecogdesc'));
	$description = escape(Input::get('description'));
	$point = escape(Input::get('point'));
	$aliasto = Input::get('aliasto');
	$tagapply = Input::get('tagapply');
	$aliastonum = escape(Input::get('aliastonum'));
	$tagapplynum = escape(Input::get('tagapplynum'));
	$senderuserid = $resultresult->userID;
	$sendercurrentpoint = $resultresult->point_company;
		
	function exists($data){
		if(empty($data)){
			return "Please enter amount, recipient and post description";
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

	$addrecogdescerror = exists($addrecogdesc);
	if ($addrecogdescerror === "Valid") {
		$pattern1 = "/\+(\w+)/";
		if (!preg_match($pattern1, $addrecogdesc)) {
			$addrecogdescerror = "Please enter amount, recipient and post description";
		} else{
			if ($point>$sendercurrentpoint) {
				$addrecogdescerror = "You only have ".$sendercurrentpoint." points to give away";
			}
		}

		$pattern2 = "/@(\w+)/";
		if(!preg_match($pattern2, $addrecogdesc)){
			$addrecogdescerror = "Please enter amount, recipient and post description";
		}

		$pattern4 = "/\+(\w+)|@(\w+)|#(\w+)|\s+/";
		if(!preg_replace($pattern4, "", $addrecogdesc)){
			$addrecogdescerror = "Please enter amount, recipient and post description";
		}
	}

	$condition = condition($addrecogdescerror);

	if($condition === "Passed"){

		//add data into database recognition table
		$recognitionobject = new Recognition();
		$recognitionobject->addRecognition(array(
			"corporateID" => $corporateID,
			"companyID" => $companyID,
			"userID" => $senderuserid,
			"from_user" => $nickname,
			"description" => $description,
			"point" => $point,
			"create_at" => date("Y-m-d H:i:s")
		));
		$array = [
			"condition" => $condition,
		];

		//fetch latest ID from recognition table
		$lastinsertrecogid = $recognitionobject -> lastinsertid();

		// add latest recognition submitted to merit log
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

		// fetch latest ID merit log
		$lastinsertmeritlogid = $meritlogobject -> lastinsertid();

		// looping if user tagged in more than 1
		for ($i=0; $i < $aliastonum; $i++) {

			// search user tagged in recognition (recipient)
			$userobject = new User();
			$userresult = $userobject->searchByNickname($aliasto[$i]);

			if ($userresult) {

				// fetch details of recipient
				$recipientuserid = $userresult->userID;
				$recipientcurrentpoint = $userresult->point_recog;

				//add data into database alias_to table
				$aliastoobject = new Alias_to();
				$aliastoobject->addAlias_to(array(
					"recogID" => $lastinsertrecogid,
					"userID" => $recipientuserid,
					"to_user" => $aliasto[$i]
				));
				$array = [
					"condition" => $condition,
				];

				// update point_recog based on received point from recognition (addition to point)
				$userobject->update(array(
					'point_recog' => $recipientcurrentpoint+$point
				),$recipientuserid, "userID");
				
				$array = [
					"condition" => $condition,
				];

				// add recipient to merit assign
				$meritassignobject = new Merit_assign();
				$meritassignobject->addMerit_assign(array(
					"logID" => $lastinsertmeritlogid,
					"to_user" => $aliasto[$i]
				));
				$array = [
					"condition" => $condition,
				];

			}
		}

		// looping if tag apply more than 1
		for ($i=0; $i < $tagapplynum; $i++) { 

			//add data into database tag_apply table
			$tagapplyobject = new Tag_apply();
			$tagapplyobject->addTag_apply(array(
				"recogID" => $lastinsertrecogid,
				"tagname" => $tagapply[$i]
			));
			$array = [
				"condition" => $condition,
			];
		}

		// update point_company based on delivered point in recognition (deduction to point)
		$userobject = new User();
		$userobject->update(array(
			'point_company' => $sendercurrentpoint-($point*$aliastonum)
		),$senderuserid, "userID");
		
		$array = [
			"condition" => $condition,
		];

		
	}else{
		$array = [
			"condition" => $condition,
			"description" => $addrecogdescerror,

		];
	}
	echo json_encode($array);
}
?>