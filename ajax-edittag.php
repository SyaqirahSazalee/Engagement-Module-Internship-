<?php
require_once 'core/init.php';

if(Input::exists()){
	$edittagid = escape(Input::get('edittagid'));
	$tagname = escape(Input::get('edittagname'));
	$tagdesc = escape(Input::get('edittagdesc'));
		
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

	$tagdescerror = exists($tagdesc);

	$condition = condition($tagnameerror, $tagdescerror);

	if($condition === "Passed"){

		$tagobject = new Tag();
		$tagobject->updateTag(array(
			'tagname' => $tagname,
			'tagdesc' => $tagdesc,
		),$edittagid,"tagID");
		
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