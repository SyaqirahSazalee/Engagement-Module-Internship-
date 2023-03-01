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
if($resultresult->corporateID){
$tagresult = $tagobject->searchWithCorporate($resultresult->corporateID);
}else{
$tagresult = $tagobject->searchWithCompany($resultresult->companyID);
}

$view = "";
if($tagresult){
  $view .= 
  "
  <div class='card border-success mb-3' style='width: 30%;'>
    <div class='card-body'>
      <input class='mb-2 form-control rounded-0' id='searchtags' type='text' autocomplete='off' placeholder='Search..'>
      <script type='text/javascript'>
          $(document).ready(function(){
            $('#searchtags').on('keyup', function() {
              var value = $(this).val().toLowerCase();
              $('#showtagslist .addposttag').filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
              });
            });
          });
      </script>

      <ul class='list-group list-group-flush' id='showtagslist'>
      
      ";
      foreach ($tagresult as $row) {
          $view .= 
          "
          <li class='list-group-item list-group-item-action addposttag' title='#$row->tagname '>
              <div class='row'>
                ".$row->tagname."
              </div>
          </li>
          ";  
      }
      $view .= 
      "
      </ul>
    </div>
  </div>
  ";
}


echo $view;
?>

<style type="text/css">
  #showtagslist {
    overflow-y: scroll;
    max-height: 200px;
  }
</style>
