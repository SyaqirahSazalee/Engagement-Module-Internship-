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

$tagapplyobject = new Tag_apply();
$tagapplyresult = $tagapplyobject->searchTagApplyforPie();

$view = "";
if ($tagapplyresult) 
{
	$view .= 
	"
	<div class='title'><b>Trending Hashtags</b></div>
	";

	foreach ($tagapplyresult as $row) 
	{
		$view .= 
		"
		<button class='collapsible'>
			<strong style='color:grey;'>#".$row->tagname."</strong>
			<span class='badge badge-info badge-pill' style='float:right;'>".$row->number."</span>
		</button>
		";
	}
}
?>

<?php
echo $view;
?>