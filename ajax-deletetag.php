<?php
require_once 'core/init.php';
if(Input::exists()){
	$deletetagid = escape(Input::get('deletetagid'));

	$tagobject = new Tag();
	$tagobject->deleteTag($deletetagid);
		
    $array = [
    	"condition" => "Passed"
	];

	echo json_encode($array);
}
?>