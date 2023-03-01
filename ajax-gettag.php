<?php
require_once 'core/init.php';

if(Input::exists()){
	$tagID = escape(Input::get('tagID'));

	$tag = new Tag();
	$data = $tag->searchOnly($tagID);


	
    $array = [
      'tagID' => $data->tagID,
      'tagname' => $data->tagname,
      'tagdesc' => $data->tagdesc

  	];
	

	echo json_encode($array);
}
?>
  
  