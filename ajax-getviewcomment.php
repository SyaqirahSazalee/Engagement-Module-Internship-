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

$recogID = escape(Input::get('recogID'));

$commentobject = new Comment();
$commentresult = $commentobject->searchCommentWithRecogID($recogID);

$view = "";
if($commentresult){
  $view .= 
  "
  <div class='card mb-3' style='width: 100%;'>
    <div class='card-body'>
      <ul class='list-group list-group-flush' id='showcommentlist'>
      ";
      foreach ($commentresult as $row) {
        $userobject = new User();
        $userresult = $userobject->searchByNickname($row->from_user);

        if ($userresult) {
          $profilepic = base64_encode($userresult->profilepic);

          $commentaliasobject = new Comment_alias();
          $commentaliasresult = $commentaliasobject -> searchWithComment($row->commentID);

          if ($commentaliasresult) {
            $commentaliasnum = count($commentaliasresult);

            $a=array();
            for ($i=0; $i < $commentaliasnum ; $i++) { 
              
              array_push($a, "@".$commentaliasresult[$i]->to_user);

              $arraycommentalias = implode(" ", $a);
            }

            $commenttagobject = new Comment_tag();
            $commenttagresult = $commenttagobject -> searchWithComment($row->commentID);

            if ($commenttagresult) {
              $commenttagnum = count($commenttagresult);

              $b=array();
              for ($i=0; $i < $commenttagnum ; $i++) { 
                
                array_push($b, "#".$commenttagresult[$i]->tagname);

                $arraycommenttag = implode(" ", $b);
              }

              $view .= 
              "
              <li class='list-group-item list-group-item-action'>
                  <div class='row'>
                    <img src='data:image/jpeg;base64, ".$profilepic."' class='rounded-circle' width='35' height='35' style='object-fit: cover;'>
                    <b>&nbsp".$row->from_user."</b>
                  </div>
                  <div class='row mt-2'>
                    <span class='badge badge-pill border border-primary text-primary'>+".$row->point."</span>&nbsp<b style='color:#50C878;'>".$arraycommentalias."</b>&nbsp<b style='color:grey;'> ".$arraycommenttag."</b>&nbsp".$row->description."
                  </div>
              </li>
              ";
            }else{
              $view .= 
              "
              <li class='list-group-item list-group-item-action'>
                  <div class='row'>
                    <img src='data:image/jpeg;base64, ".$profilepic."' class='rounded-circle' width='35' height='35' style='object-fit: cover;'>
                    <b>&nbsp".$row->from_user."</b>
                  </div>
                  <div class='row mt-2'>
                    <span class='badge badge-pill border border-primary text-primary'>+".$row->point."</span>&nbsp<b style='color:#50C878;'>".$arraycommentalias."</b>&nbsp".$row->description."
                  </div>
              </li>
              ";
            }
          }
        }
      }
      $view .= 
      "
      </ul>
    </div>
  </div>
  ";
}

// echo json_encode($view);
echo $view;
?>

<style type="text/css">
  #showcommentlist {
    overflow-y: scroll;
    max-height: 300px;
  }
</style>
