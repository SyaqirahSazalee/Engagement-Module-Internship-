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
	<h4><span class='badge badge-warning'>".$resultresult->point_company." points to give away</span></h4>
	<h4><span class='badge badge-info'>".$resultresult->point_recog." points to redeem</span></h4>
	<div class='title'><b>Company Value Hahtags</b></div>
	";

	foreach ($tagresult as $row) 
	{
		$view .= 
		"
		<button type='button' class='collapsible'><strong>#".$row->tagname."</strong></button>
		<div class='content'>
			<p>".$row->tagdesc."</p>
		</div>
		";
	}
}
?>

<script>
var coll = document.getElementsByClassName("collapsible");
var i;

for (i = 0; i < coll.length; i++) {
  coll[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var content = this.nextElementSibling;
    if (content.style.display === "block") {
      content.style.display = "none";
    } else {
      content.style.display = "block";
    }
  });
}
</script>

<style>
	.title {
		padding: 14px;
		width: 100%;
		border: 1px solid grey;
		text-align: left;
		font-size: 17px;
	}

	.collapsible {
		background-color: #E4E4E4;
		color: green;
		cursor: pointer;
		padding: 14px;
		width: 100%;
		border: none;
		text-align: left;
		outline: none;
		font-size: 15px;
	}

	.collapsible:hover {
		background-color: #ffff;
	}

	.content {
		padding: 0 18px;
		display: none;
		overflow: hidden;
	}
</style>

<?php
echo $view;
?>