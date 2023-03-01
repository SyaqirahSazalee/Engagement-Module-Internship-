<?php
require_once 'core/init.php';

if(Input::exists()){
	$recogID = escape(Input::get('recogID'));

	$comment = new Comment();
	$data = $comment->searchCommentWithRecogID($recogID);

    $array = [
      'description' => $data->description

  	];
	

	echo json_encode($array);
}
?>
  
  