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

	$aliastoobject = new User();
	if($resultresult->corporateID){
		$aliastoresult = $aliastoobject -> searchPointforLeaderBoardWithCorporate($resultresult->corporateID);

	}
	else{
		$aliastoresult = $aliastoobject -> searchPointforLeaderBoardWithCompany($resultresult->companyID);

	}

?>  

	<div id="myChart" style="width:100%; max-width:600px; height:500px;"></div>

	<script>
		// Load google charts
		google.charts.load('current', {'packages':['corechart']});
		google.charts.setOnLoadCallback(drawChart);

		// Draw the chart and set the chart values
		function drawChart() {
			var data = google.visualization.arrayToDataTable([
				['Username', 'Points'],
				<?php
	            if($aliastoresult)
	            {
					foreach ($aliastoresult as $row) 
					{?>
						['<?php echo $row->nickname ?>' , <?php echo $row->point_recog ?>], 
					<?php		
					}
	            }
	            ?>
			]);

			var options = {
				title:'Leaderboard',
			};

			function getRandomColor() {
			  var letters = '0123456789ABCDEF'.split('');
			  var color = '#';
			  for (var i = 0; i < 6; i++ ) {
			    color += letters[Math.floor(Math.random() * 16)];
			  }
			  return color;
			}

			options.series={};
			for(var i = 0;i < data.getNumberOfRows();i++){
			  options.series[i]={color:getRandomColor()}
			}

			var chart = new google.visualization.BarChart(document.getElementById('myChart'));
			chart.draw(data, options);
		}
	</script>