<?php
require_once 'core/init.php';
$userlevel = "";
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
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    
    <?php
    include 'includes/header.php';
    ?>
  </head>
  <body>
    <?php include 'includes/topbar.php';?>
    <div class="d-flex" id="wrapper">
      <?php include 'includes/navbar-new.php';?>
      <div id="page-content-wrapper">
        <div class="container-fluid" id="content"> 
          <div class="row px-2">
            <h3 class="my-5 font-weight-light"><b>Giving Points</b></h3>
          </div>
          <div class="alert alert-warning alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Warning!</strong> You can only key in Montly Allowance once a Month.
          </div>
          <div class="row px-2">
            <label>Monthly Allowance</label>
          </div>
          <div class="row px-2">
            <input type="text" id="allowance" placeholder="100">
            <small><span id="allowanceerror"></span></small>

            <div class="row px-2">
              <div class="col">
                <?php
                $meritlogobject = new Merit_log();
                $meritlogresult = $meritlogobject->searchAllOnlyMonth();

                if ($meritlogresult) {
                  foreach ($meritlogresult as $row) {
                    $month = "0".$row->month;
                  }
                } else {
                  $month = 0;
                }

                if ($month === date("m")) {
                  ?>
                  <input type="button" value="Give Allowance" class="btn btn-primary rounded-0" id="give" data-toggle="tooltip" data-placement="top" title="Monthly allowance for this month added!" disabled>
                  <?php
                } else {
                  ?>
                  <input type="button" value="Give Allowance" class="btn btn-primary rounded-0" id="give">
                  <?php
                }
                ?>
              </div>
            </div>
          </div>
          <div class="row px-2 py-4">
            <label>Exchange rate <span class='badge badge-info badge-pill'>10 points = 1 MYR</span></label>
          </div>
          <div class="my-3 tab-content">
            <?php
            include 'dashboard-userengagement.php'; 
            ?>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>

<script type="text/javascript">
  $(document).ready(function(){
    $("#sidebar-wrapper .active").removeClass("active");
    $("#highlightforpagethreethree").addClass("active").addClass("disabled");
    document.getElementById("highlightforpagethreethree").style.backgroundColor = "DeepSkyBlue";

    $('[data-toggle="tooltip"]').tooltip();   

    $("#give").click(function(){
      var point = document.getElementById("allowance").value;
      var type = "plus";
      var description = "Monthly allowance"

      var alldata={
        point:point,
        type:type,
        description:description
      };

      $.ajax({
        url: "ajax-addallowance.php",
        type: "POST",
        data: alldata,
        success:function(data){
          var obj = JSON.parse(data);
          if(obj.condition === "Passed"){
            document.getElementById("allowance").value = "";
            document.getElementById("give").disabled = true;
            getusersengagementinfo();
          }else{
            checkvalidity("allowanceerror","#allowanceerror", "#allowance", obj.point);
          }
        }
      });
    });

    function getusersengagementinfo()
    {
      $.ajax({
        url: "ajax-getviewadminusers.php?lang=<?php echo $extlg;?>",
        success:function(data){
          $("#usersengagementinfo").html(data);
        }
      });
    }
  });
</script>

<?php
include 'includes/form.php';
include 'includes/footer.php';
?>

