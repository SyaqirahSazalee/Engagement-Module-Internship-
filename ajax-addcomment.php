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
	$recogID = escape(Input::get('addrecogcommentid'));
	$addrecogcommentdesc = escape(Input::get('addrecogcommentdesc'));
	$description = escape(Input::get('comment'));
	$point = escape(Input::get('point'));
	$aliasto = Input::get('commentaliasto');
	$tagapply = Input::get('commenttagapply');
	$aliastonum = escape(Input::get('commentaliastonum'));
	$tagapplynum = escape(Input::get('commenttagapplynum'));
	$senderuserid = $resultresult->userID;
	$sendercurrentpoint = $resultresult->point_company;
	
		
	function exists($data){
		if(empty($data)){
			return "Please enter amount, recipient and comment description";
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

	$addrecogcommentdescerror = exists($addrecogcommentdesc);
	if ($addrecogcommentdescerror === "Valid") {
		$pattern1 = "/\+(\w+)/";
		if (!preg_match($pattern1, $addrecogcommentdesc)) {
			$addrecogcommentdescerror = "Please enter amount, recipient and comment description";
		}

		$pattern2 = "/@(\w+)/";
		if(!preg_match($pattern2, $addrecogcommentdesc)){
			$addrecogcommentdescerror = "Please enter amount, recipient and comment description";
		}

		$pattern4 = "/\+(\w+)|@(\w+)|#(\w+)|\s+/";
		if(!preg_replace($pattern4, "", $addrecogcommentdesc)){
			$addrecogcommentdescerror = "Please enter amount, recipient and comment description";
		}

	}

	$condition = condition($addrecogcommentdescerror);

	if($condition === "Passed"){

		//add data into database comment table
		$commentobject = new Comment();
		$commentobject->addComment(array(
			"corporateID" => $corporateID,
			"companyID" => $companyID,
			"recogID" => $recogID,
			"userID" => $senderuserid,
			"from_user" => $nickname,
			"description" => $description,
			"point" => $point,
			"create_at" => date("Y-m-d H:i:s")
		));
		$array = [
			"condition" => $condition,
		];

		// fetch latest ID  for comment
		$lastinsertcommentid = $commentobject -> lastinsertid();

		// add merit log for latest comment
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

		// looping if user tagged in comment more than 1
		for ($i=0; $i < $aliastonum; $i++) {

			// search user tagged in
			$userobject = new User();
			$userresult = $userobject->searchByNickname($aliasto[$i]);

			if ($userresult) {

				$recipientuserid = $userresult->userID;
				$recipientcurrentpoint = $userresult->point_recog;
				
				//add data into database comment_alias table
				$commentaliasobject = new Comment_alias();
				$commentaliasobject->addComment_alias(array(
					"commentID" => $lastinsertcommentid,
					"userID" => $recipientuserid,
					"to_user" => $aliasto[$i]
				));
				$array = [
					"condition" => $condition,
				];

				// update recipient point received from comment in point_recog column (user table)
				$userobject->update(array(
					'point_recog' => $recipientcurrentpoint+$point
				),$recipientuserid, "userID");
				
				$array = [
					"condition" => $condition,
				];

				// add merit assign 
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

		// looping if tag used in comment more than 1
		for ($i=0; $i < $tagapplynum; $i++) { 

			//add data into database comment_tag table
			$commenttagobject = new Comment_tag();
			$commenttagobject->addComment_tag(array(
				"commentID" => $lastinsertcommentid,
				"tagname" => $tagapply[$i]
			));
			$array = [
				"condition" => $condition,
			];
		}

		// update sender point in point_company column (user table)
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
			"description" => $addrecogcommentdescerror,
		];
	}
	echo json_encode($array);
}
?>