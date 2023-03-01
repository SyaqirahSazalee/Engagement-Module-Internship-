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


$recognitionobject = new Recognition();
if($resultresult->corporateID){
$recognitionresult = $recognitionobject->searchWithCorporate($resultresult->corporateID);
}
else{
$recognitionresult = $recognitionobject->searchWithCompany($resultresult->companyID);
}

$view = "";
if ($recognitionresult) 
{
	foreach ($recognitionresult as $row) 
	{
		$commentobject = new Comment();
		$commentresult = $commentobject->searchCommentWithRecogID($row->recogID);

		if ($commentresult){
			$commentnum = count($commentresult);
		}else{
			$commentnum = 0;
		}

		$userobject = new User();
		$userresult = $userobject->searchByNickname($row->from_user);

		if ($userresult) {
			$profilepic = base64_encode($userresult->profilepic);
			
			$aliastoobject = new Alias_to();
			$aliastoresult = $aliastoobject -> searchWithRecognition($row->recogID);

			if ($aliastoresult) {
				$aliastonum = count($aliastoresult);

				$a=array();
				for ($i=0; $i < $aliastonum ; $i++) { 
					
					array_push($a, "@".$aliastoresult[$i]->to_user);

					$arrayaliasto = implode(" ", $a);
				}

				$tagapplyobject = new Tag_apply();
				$tagapplyresult = $tagapplyobject -> searchWithRecognition($row->recogID);

				if ($tagapplyresult) {
					$tagapplynum = count($tagapplyresult);

					$b=array();
					for ($i=0; $i < $tagapplynum ; $i++) { 
						
						array_push($b, "#".$tagapplyresult[$i]->tagname);

						$arraytagapply = implode(" ", $b);
					}

					$view .=
					"
					<div class='col-12 my-2'>
						<div class='card'>
							<div class='card-body ml-3'>
								<div class='row'>
									<img src='data:image/jpeg;base64, ".$profilepic."' class='rounded-circle' width='35' height='35' style='object-fit: cover;'>
									<b>&nbsp".$row->from_user."</b>
								</div>
								
								<div class='row mt-2'>
									<span class='badge badge-pill border border-primary text-primary'>+".$row->point."</span>&nbsp<b style='color:#50C878;'>".$arrayaliasto."</b>&nbsp<b style='color:grey;'> ".$arraytagapply."</b>&nbsp".$row->description."
								</div>

								<div class='row mt-4'>
									<button type='button' class='btn btn-primary addComment' data-toggle='modal' data-id='".$row->recogID."' data-target='#addrecogcomment'><i class='fas fa-comment'></i> <span>".$commentnum."</span>
									</button>
								</div>
							</div>
						</div>
					</div>
					";
					
				}
				else{
					$view .=
					"
					<div class='col-12 my-2'>
						<div class='card'>
							<div class='card-body ml-3'>
								<div class='row'>
									<img src='data:image/jpeg;base64, ".$profilepic."' class='rounded-circle' width='35' height='35' style='object-fit: cover;'>
									<b>&nbsp".$row->from_user."</b>
								</div>
								
								<div class='row mt-2'>
									<span class='badge badge-pill border border-primary text-primary'>+".$row->point."</span>&nbsp<b style='color:#50C878;'>".$arrayaliasto."</b>&nbsp".$row->description."
								</div>

								<div class='row mt-4'>
									<button type='button' class='btn btn-primary addComment' data-toggle='modal' data-id='".$row->recogID."' data-target='#addrecogcomment'><i class='fas fa-comment'></i> <span>".$commentnum."</span>
									</button>
								</div>
							</div>
						</div>
					</div>
					";
				}
			}
			else
			{
				$view .=
				"
				<div class='col-12 my-2'>
					<div class='card'>
						<div class='card-body ml-3'>
							<div class='row'>
								<img src='data:image/jpeg;base64, ".$profilepic."' class='rounded-circle' width='35' height='35' style='object-fit: cover;'>
								<b>&nbsp".$row->from_user."</b>
							</div>

							<div class='row mt-2'>
								<span class='badge badge-pill border border-primary text-primary'>+".$row->point."</span>&nbsp".$row->description."
							</div>

							<div class='row mt-4'>
							<button type='button' class='btn btn-primary addComment' data-toggle='modal' data-id='".$row->recogID."' data-target='#addrecogcomment'><i class='fas fa-comment'></i> <span>".$commentnum."</span>
							</button>
						</div>
						</div>
					</div>
				</div>
				";
			}
		}
	}
}

echo $view;
?>