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
            <h3 class="my-5 font-weight-light"><b>Recognition Analytics</b></h3>
        </div>
        <div class="row">
          <div class="col-12">
            <script type="text/javascript">
              $(document).ready(function(){
                function getrecognitionalyticsinfo()
                {
                  $.ajax({
                    url: "ajax-getviewrecognitionanalytics.php",
                    success:function(data){
                      $("#showrecognitionalyticsinfo").html(data);
                    }
                  });
                }
                getrecognitionalyticsinfo();
              });
            </script>
            <div class="row" id="showrecognitionalyticsinfo"></div>
          </div>
          <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
          <div class="col">
            <script type="text/javascript">
            $(document).ready(function(){
              function gettaganalyticsinfo()
              {
                $.ajax({
                  url: "ajax-getviewtaganalytics.php",
                  success:function(data){
                    $("#showtaganalyticsinfo").html(data);
                  }
                });
              }
              gettaganalyticsinfo();
            });
            </script>
            <div class="row" id="showtaganalyticsinfo"></div>
          </div>

          <div class="col">
            <script type="text/javascript">
              $(document).ready(function(){
                function getaliastoanalyticsinfo()
                {
                  $.ajax({
                    url: "ajax-getviewaliastoanalytics.php",
                    success:function(data){
                      $("#showaliastoalyticsinfo").html(data);
                    }
                  });
                }
                getaliastoanalyticsinfo();
              });
            </script>
            <div class="row" id="showaliastoalyticsinfo"></div>
          </div>
        </div>
      </div>
    </div>
	</div>
</body>

<script type="text/javascript">

$(document).ready(function(){
$("#sidebar-wrapper .active").removeClass("active");
$("#highlightforpagethreetwo").addClass("active").addClass("disabled");
document.getElementById("highlightforpagethreetwo").style.backgroundColor = "DeepSkyBlue";
});
</script>

<!-- /#wrapper -->
<?php include 'includes/form.php';?>
<?php include 'includes/footer.php';?>