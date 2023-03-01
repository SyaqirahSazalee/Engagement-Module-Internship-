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

$userobject = new User();
if($resultresult->corporateID){
$userresult = $userobject->searchWithCorporate($resultresult->corporateID);
}else{
$userresult = $userobject->searchWithCompany($resultresult->companyID);
}

$view = "";
if($userresult){
  $view .= 
  "
  <div class='card border-success mb-3' style='width: 30%;'>
    <div class='card-body'>
      <input class='mb-2 form-control rounded-0' id='searchusers' type='text' autocomplete='off' placeholder='Search..'>
      <script type='text/javascript'>
          $(document).ready(function(){
            $('#searchusers').on('keyup', function() {
              var value = $(this).val().toLowerCase();
              $('#showaliaslist .addpostuser').filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
              });
            });
          });
      </script>

      <ul class='list-group list-group-flush' id='showaliaslist'>
          
      ";
      foreach ($userresult as $row) {
          $view .= 
          "
          <li class='list-group-item list-group-item-action addpostuser' title='@$row->nickname '>
              <div class='row'>
                ".$row->nickname."
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
  #showaliaslist {
    overflow-y: scroll;
    max-height: 200px;
  }
</style>
