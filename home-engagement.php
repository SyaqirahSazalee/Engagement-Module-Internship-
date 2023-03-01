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
include 'includes/header.php';
?>

<?php include 'includes/topbar.php';?>
<body>
	<div class="d-flex" id="wrapper">
		<?php include 'includes/navbar-new.php';?>

		<div id="page-content-wrapper">
	      	<div class="container-fluid" id="content"> 
	      		<div class="row px-2">
		      		<div class="col-8">
						<div class="row">
							<h3 class="my-5 font-weight-light"><b>Colleagues Recognition</b></h3>
							<div class="col px-4 my-5">
								<?php
								if ($resultresult->point_company<=0) {
									?>
									<button type="button" class="btn btn-light rounded-0 border-success" data-toggle="modal" data-backdrop='static' data-target="#addrecog" disabled><i class='fas fa-plus'></i> New Recognition</button>
									<?php
								} else {
									?>
									<button type="button" class="btn btn-light rounded-0 border-success" data-toggle="modal" data-backdrop='static' data-target="#addrecog"><i class='fas fa-plus'></i> New Recognition</button>
									<?php
								}
								?>
							</div>
						</div>
						<script>
				            $(document).ready(function(){

				              function getrecognitioninfo()
				              {
				                $.ajax({
				                  url: "ajax-getviewrecognition.php",
				                  success:function(data){
				                    $("#showrecognitioninfo").html(data);
				                  }
				                });
				              }
				              getrecognitioninfo();
				            });
				        </script>
				        <div class="row" id="showrecognitioninfo"></div>
				    </div>
				    <div class="col-4">
						<script>
				            $(document).ready(function(){

				              function gethometaginfo()
				              {
				                $.ajax({
				                  url: "ajax-getviewhometag.php",
				                  success:function(data){
				                    $("#showhometaginfo").html(data);
				                  }
				                });
				              }
				              gethometaginfo();
				            });
				        </script>
				        <div class="row px-2 my-5" id="showhometaginfo"></div>

				        <script>
				            $(document).ready(function(){

				              function gettrendingtaginfo()
				              {
				                $.ajax({
				                  url: "ajax-getviewtrendinghashtags.php",
				                  success:function(data){
				                    $("#showtrendingtaginfo").html(data);
				                  }
				                });
				              }
				              gettrendingtaginfo();
				            });
				        </script>
				        <div class="row px-2 my-5" id="showtrendingtaginfo"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>

<style type="text/css">
	.card-link:hover
	{
		color: red;
	}
</style>

<script type="text/javascript">
	$(document).ready(function(){
	    $("#sidebar-wrapper .active").removeClass("active");
	    $("#highlightforpagethreeone").addClass("active").addClass("disabled");
	    document.getElementById("highlightforpagethreeone").style.backgroundColor = "DeepSkyBlue";
  	});
</script>

<!-- /#wrapper -->
<?php include 'includes/footer.php';?>