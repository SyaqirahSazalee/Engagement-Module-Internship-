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
            <h3 class="my-5 font-weight-light"><b>Recognition History</b></h3>
        </div>
        <!-- <div class="row"> -->
          <!-- <div class="col-6"> -->
            <select id="tt" >
              <option value="tb0">All</option>
              <option value="tb1">Received</option>
              <option value="tb2">Delivered</option>
            </select>
            <div id="tbl_div">
              <div id="tb1">
                  <script>
                    $(document).ready(function(){

                      function getrecognitionhistoryinfo()
                      {
                        $.ajax({
                          url: "ajax-getviewrecognitionhistory.php",
                          success:function(data){
                            $("#showrecognitionhistory").html(data);
                          }
                        });
                      }
                      getrecognitionhistoryinfo();
                    });
                  </script>
                  <div id="showrecognitionhistory"></div>
              </div>

              <div id="tb2">
                 <script>
                  $(document).ready(function(){

                    function getrecognitionhistoryinfo2()
                    {
                      $.ajax({
                        url: "ajax-getviewrecognitionhistory2.php",
                        success:function(data){
                          $("#showrecognitionhistory2").html(data);
                        }
                      });
                    }
                    getrecognitionhistoryinfo2();
                  });
                </script>
                <div id="showrecognitionhistory2"></div>
              </div>
            </div>
          <!-- </div> -->
        <!-- </div> -->
      </div>
    </div>
  </div>
</body>

<script>
$(document).ready(function(){
  $("#tt").change( function ()
  {
      dhi = $("#tt").val();
      if(dhi=='tb0')
      {
        $('#tb1').css('display','block');
        $('#tb2').css('display','block');
      }
      else if(dhi=='tb1')
      {
        $('#tb1').css('display','block');
        $('#tb2').css('display','none');
      }
      else if(dhi=='tb2')
      {
        $('#tb1').css('display','none');
        $('#tb2').css('display','block');
      }
      // $('#tbl_div div').css('display','none');
      // $('#'+dhi).css('display','block');
  });
});
</script>

<script type="text/javascript">

$(document).ready(function(){
$("#sidebar-wrapper .active").removeClass("active");
$("#highlightforpagethreesix").addClass("active").addClass("disabled");
document.getElementById("highlightforpagethreesix").style.backgroundColor = "DeepSkyBlue";
});

</script>

<!-- /#wrapper -->
<?php include 'includes/form.php';?>
<?php include 'includes/footer.php';?>