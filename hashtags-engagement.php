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
<body>
	<?php include 'includes/topbar.php';?>

	<div class="d-flex" id="wrapper">
    <?php include 'includes/navbar-new.php';?>

    <div id="page-content-wrapper">
      <div class="container-fluid" id="content"> 
          <div class="row px-2">
              <h3 class="my-5 font-weight-light"><b>Company Value Hashtags and Description</b></h3>
              <div class="col px-4 my-5">
                <button type="button" class="btn btn-light rounded-0 border-success" data-toggle="modal" data-backdrop='static' data-target="#addtag"><i class='fas fa-plus'></i> New Hashtag</button>
              </div>
          </div>

          <script>
            $(document).ready(function(){

              function gettaginfo()
              {
                $.ajax({
                  url: "ajax-getviewtag.php",
                  success:function(data){
                    $("#showtaginfo").html(data);
                  }
                });
              }
              gettaginfo();
            });
          </script>
          <div id="showtaginfo"></div>
      </div>
    </div>
	</div>
</body>

<script type="text/javascript">
  $(document).ready(function(){
     $("#sidebar-wrapper .active").removeClass("active");
     $("#highlightforpagethreefour").addClass("active").addClass("disabled");
     document.getElementById("highlightforpagethreefour").style.backgroundColor = "DeepSkyBlue";
  });
</script>

<!-- /#wrapper -->
<?php include 'includes/footer.php';?>