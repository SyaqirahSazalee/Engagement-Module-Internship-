
<div class="border-right" id="sidebar-wrapper">
	<style type="text/css">
		#navbar::-webkit-scrollbar {
        display: none;
        }

	    #navbar {
	      -ms-overflow-style: none; 
	      scrollbar-width: none; 
	    }

	    .border-3 {
	      border-width:5px !important;
	    }

	    .radius{
	      
	    }
    </style>
    <div class="list-group list-group-flush" id="navbar">

    	<!-- <a class="list-group-item list-group-item-action border-0 py-1 mt-2" data-toggle="collapse" href="#tabone"><h6 class="m-0"><i class='fas fa-angle-down'></i>Dashboard</h6></a>
	    <div class="collapse show" id="tabone">
	      <a href="home-dashboard?lang=<?php echo $extlg?>" class="list-group-item list-group-item-action border-0 radius py-1 pl-5" id="highlightforpageoneone">
	        <small>Dashboard</small>
	      </a>
	    </div>

	    <a class="list-group-item list-group-item-action border-0 py-1 mt-2" data-toggle="collapse" href="#tabtwo"><h6 class="m-0"><i class='fas fa-angle-down'></i>Calendar</h6></a>
	    <div class="collapse show" id="tabtwo">
	      <a href="home-calendar?lang=<?php echo $extlg?>" class="list-group-item list-group-item-action border-0 radius py-1 pl-5" id="highlightforpagetwoone">
	        <small>Calendar</small>
	      </a>
	    </div> -->

	    <a class="list-group-item list-group-item-action border-0 py-1 mt-2" data-toggle="collapse" href="#tabthree"><h6 class="m-0"><i class='fas fa-angle-down'></i>Engagement</h6></a>
	    <div class="collapse show" id="tabthree">
	    	<a href="home-engagement.php?lang=<?php echo $extlg?>" class="list-group-item list-group-item-action border-0 radius py-1 pl-5" id="highlightforpagethreeone">
	    		<small>Home</small>
	        </a>
	        <a href="analytics-engagement?lang=<?php echo $extlg?>" class="list-group-item list-group-item-action border-0 radius py-1 pl-5" id="highlightforpagethreetwo">
	        	<small>Analytics</small>
	        </a>
	        <a href="givingpoints-engagement?lang=<?php echo $extlg?>" class="list-group-item list-group-item-action border-0 radius py-1 pl-5" id="highlightforpagethreethree">
	        	<small>Giving Points</small>
	        </a>
	        <a href="hashtags-engagement?lang=<?php echo $extlg?>" class="list-group-item list-group-item-action border-0 radius py-1 pl-5" id="highlightforpagethreefour">
	        	<small>Hashtags</small>
	        </a>
	        <!-- <a href="users-engagement?lang=<?php echo $extlg?>" class="list-group-item list-group-item-action border-0 radius py-1 pl-5" id="highlightforpagethreefive">
	        	<small>Users</small>
	        </a> -->
	        <a href="history-engagement?lang=<?php echo $extlg?>" class="list-group-item list-group-item-action border-0 radius py-1 pl-5" id="highlightforpagethreesix">
				<small>History</small>
	        </a>
	    </div>
	</div>
</div>

<style type="text/css">
  .collapsing {
    transition: none !important;
  }
</style>
<script type="text/javascript">
  getnavbarview("tabone", "tabone_value");
  getnavbarview("tabtwo", "tabtwo_value");

  function getnavbarview(navbarname, navbarid){
    $('#'+navbarname+'').on('shown.bs.collapse', function () {
      localStorage.setItem(''+navbarid+'', true);
    });
    $('#'+navbarname+'').on('hidden.bs.collapse', function () {
      localStorage.setItem(''+navbarid+'', false);
    });

    var nav = localStorage.getItem(''+navbarid+'');
    if(nav === "true"){
      $('#'+navbarname+'').collapse('show');
    }else{
      $('#'+navbarname+'').collapse('hide');
    }
  }
</script>

  



