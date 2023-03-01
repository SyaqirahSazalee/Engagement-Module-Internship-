<?php
require_once 'core/init.php';

if(Input::exists()){
	$recogID = escape(Input::get('recogID'));

	$aliasto = new Alias_to();
	$data = $aliasto->searchWithRecognition($recogID);

	if($data)
	{
		$datanum = count($data);

		$a=array();
		for ($i=0; $i < $datanum ; $i++) { 
			
			array_push($a, "@".$data[$i]->to_user);

			$arrayaliasto = implode(" ", $a);
		}
	}
	else
	{
		$arrayaliasto = null;
	}	

	echo $arrayaliasto;
}
?>
  
  