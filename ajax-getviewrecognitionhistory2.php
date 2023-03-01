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

$from_user = $resultresult->nickname;

$meritlogobject = new Merit_log();
$meritlogresult = $meritlogobject->searchFromUser($from_user);

$view = "";
if ($meritlogresult) 
{
	
	$view .= 
	"
	<br>Recognition Delivered
	<table class='table table-hover my-2'>
		<thead style='background-color: #50C878'>
			<div class='row px-5'>
				<th class='col-3'>
					<b>To</b>
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
	
	foreach ($meritlogresult as $row) 
	{
		if($row->description!=="Monthly allowance"){
			$logID = $row->logID;
		

			$meritassignobject = new Merit_assign();
			$meritassignresult = $meritassignobject->searchWithLog($logID);

			if ($meritassignresult) 
			{
				$a = array();
				foreach ($meritassignresult as $row2) {

					array_push($a, $row2->to_user);

					$arraytouser = implode(" | ", $a);
				}

				$view .= 
				"
				<tbody>
					<div class='row px-5'>
						<td class='col-3'>
							".$arraytouser."
						</td>
						<td class='col-5'>
							".$row->description."
						</td>
						<td class='col-2 text-center' style='color:red'>
							-".$row->point."
						</td>
						<td class='col-2 text-center'>
							".$row->create_at."
						</td>
					</div>
				</tbody>
				";
			}
		}
	}
	$view .=
	"</table>";
}

echo $view;
?>