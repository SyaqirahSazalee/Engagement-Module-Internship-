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

$to_user = $resultresult->nickname;

$meritassignobject = new Merit_assign();
$meritassignresult = $meritassignobject->searchToUser($to_user);


$view = "";
if ($meritassignresult) 
{
	
	$view .= 
	"
	<br>Recognition Received
	<table class='table table-hover my-2'>
		<thead style='background-color: #50C878'>
			<div class='row px-5'>
				<th class='col-3'>
					<b>From</b>
				</th>
				<th class='col-5'>
					<b>Description</b>
				</th>
				<th class='col-2 text-center'>
					<b>Point</b>
				</th>
				<th class='col-2 text-center'>
					<b>Posted on</b>
				</th>
			</div>
		</thead>	";
	
	foreach ($meritassignresult as $row) 
	{
		$logID = $row->logID;

		$meritlogobject = new Merit_log();
		$meritlogresult = $meritlogobject->searchWithLog($logID);

		if ($meritlogresult) 
		{
			$a = array();
			foreach ($meritlogresult as $row2) {

				array_push($a, $row2->from_user);

				$arrayfromuser = implode(" | ", $a);
			}

			$view .= 
			"
			<tbody>
				<div class='row px-5'>
					<td class='col-3'>
						".$arrayfromuser."
					</td>
					<td class='col-5'>
						".$row2->description."
					</td>
					<td class='col-2 text-center' style='color:green'>
						+".$row2->point."
					</td>
					<td class='col-2 text-center'>
						".$row2->create_at."
					</td>
				</div>
			</tbody>
			";
		}
	}
	$view .=
	"</table>";
}

echo $view;
?>