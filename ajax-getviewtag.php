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

$tagobject = new Tag();
$tagresult = $tagobject->searchAllTag();

$view = "";
if ($tagresult) 
{
	$view .= 
	"
	<table class='table table-hover' id='showtagslist'>
		<thead style='background-color: #50C878'>
			<div class='row px-5'>
				<th class='col-2'>
					<b>Hashtags</b>
				</th>
				<th class='col-7'>
					<b>Description</b>
				</th>
				<th class='col-2 text-center'>
					<b>Action</b>
				</th>
			</div>
		</thead>
	";

	foreach ($tagresult as $row) 
	{
		$view .= 
		"
		<tbody>
			<div class='row px-5'>
				<td class='col-2'>
					".$row->tagname."
				</td>
				<td class='col-7'>
					".$row->tagdesc."
				</td>
				<td class='col-2 text-center'>
					<a href='#' class='editTag' data-toggle='modal' data-id='".$row->tagID."' data-target='#edittag'>Edit</a> | 
                  	<a href='#' class='deleteTag' data-toggle='modal' data-id='".$row->tagID."' data-target='#deletetag'>Delete</a>
				</td>
			</div>
		</tbody>
		";
	}
	$view .=
	"</table>";
}

echo $view;
?>