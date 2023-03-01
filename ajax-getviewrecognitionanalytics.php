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

$user = $resultresult->nickname;

$aliastoobject = new Alias_to();
$aliastoresult = $aliastoobject->searchToUser($user);

if($aliastoresult){
  $aliastorecognum = count($aliastoresult);
}else{
  $aliastorecognum = 0;
}

$commentaliasobject = new Comment_alias();
$commentaliasresult = $commentaliasobject->searchToUser($user);

if($commentaliasresult){
  $aliastocommentnum = count($commentaliasresult);
}else{
  $aliastocommentnum = 0;
}

$recognitionobject = new Recognition();
$recognitionresult = $recognitionobject->searchFromUserAnalytics($user);

if($recognitionresult){
  $fromtorecognum = count($recognitionresult);
}else{
  $fromtorecognum = 0;
}

$commentobject = new Comment();
$commentresult = $commentobject->searchFromUserAnalytics($user);

if($commentresult){
  $fromtocommentnum = count($commentresult);
}else{
  $fromtocommentnum = 0;
}
?>

<div class="col" style="background-color: lightpink; text-align: center;">
  <strong>Received</strong><br>
  <strong><?php echo $aliastorecognum+$aliastocommentnum; ?></strong>
</div>
<div class="col" style="background-color: lightblue;text-align: center;">
  <strong>Delivered</strong><br>
  <strong><?php echo $fromtorecognum+$fromtocommentnum; ?></strong>
</div>