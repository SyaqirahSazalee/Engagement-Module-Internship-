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

  $tagapplyobject = new Tag_apply();
  $tagapplyresult = $tagapplyobject -> searchTagApplyforPie();

?>

  <div id="piechart"></div>

  <script type="text/javascript">
    // Load google charts
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    // Draw the chart and set the chart values
    function drawChart() {
      var data = google.visualization.arrayToDataTable([
        ['Tagname', 'Times Used'],
      
        <?php
        if($tagapplyresult)
        {
          foreach ($tagapplyresult as $row) 
          {
            echo "['#".$row->tagname."', ".$row->number."],";
          }
        }
        ?>
      ]);

      // Optional; add a title and set the width and height of the chart
      var options = {
        'title':'Frequently Used Hashtags', 
        'width':550, 
        'height':400,
        'pieStartAngle': 135,
        'pieHole': 0.4,

      };

      // Display the chart inside the <div> element with id="piechart"
      var chart = new google.visualization.PieChart(document.getElementById('piechart'));
      chart.draw(data, options);
    }
  </script>