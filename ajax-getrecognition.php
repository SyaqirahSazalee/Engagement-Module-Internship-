<?php
require_once 'core/init.php';

if(Input::exists()){
	$recogID = escape(Input::get('recogID'));

	$recognition = new Recognition();
	$data = $recognition->searchOnly($recogID);

    $array = [
      'recogID' => $data->recogID,
      'from_user' => $data->from_user,
      'description' => $data->description

  	];
	

	echo json_encode($array);
}
?>
  
  