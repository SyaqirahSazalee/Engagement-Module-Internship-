<script type="text/javascript">
	$(document).ready(function(){
		var form = $('#addpppmonthlyplanform');
		form.on('submit', function(e){
			e.preventDefault();
			e.stopPropagation();
			// document.getElementById("submitaddmonthlyplan").innerHTML = "<span class='spinner-borderspinner-border-sm'></span> Adding";// Refer to 8)
			// document.getElementById("submitaddmonthlyplan").disabled = true; // Refer to 8)
			var plan = document.getElementById("addmonthlypppplan").value;
			var date = $('#monthlyplanmonth2').data('datepicker').getUTCDate();
			var day = new Date(date.getFullYear(), date.getMonth());
			var alldata =
			{
			month: day.getMonth()+1,
			year: day.getFullYear(),
			plan:plan
			};
			$.ajax({
				url: "ajax-addmonthlyplan.php?lang=<?php echo $extlg;?>",
				type: "POST",
				data: alldata,
				dataType:"json",
				success:function(data){
					// document.getElementById("submitaddmonthlyplan").innerHTML = "Confirm";// Refer to 8)
					// document.getElementById("submitaddmonthlyplan").disabled = false; // Refer to 8)
					if(data.condition === "Passed"){
					$("#addmonthlyplanmodal").modal("hide");
					var currentdate = $('#monthlyplanmonth2').data('datepicker').getUTCDate();
					selectmonth(currentdate); // Loader function
					}else{
						checkvalidity("addmonthlypppplanerror","#addmonthlypppplanerror", "#addmonthlypppplan", data.monthlyplan);
					}
				}
			});
		});
		// This is what we call loader which will explain in more detail at Loader section
		function selectmonth(date) {
			var months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October",
			"November", "December"];
			var day = new Date(date.getFullYear(), date.getMonth());
			$('#monthlyplanmonth2').datepicker('update', day);
			$('#monthlyplanmonth2').val(months[day.getMonth()]+' '+day.getFullYear());
			var alldata =
			{
				month: day.getMonth()+1,
				year: day.getFullYear()
			};
			$.ajax({
				url: "ajax-getviewpppmonthly.php?lang=<?php echo $extlg;?>",
				type: "POST",
				data: alldata,
				success:function(data){
					$("#showmonthlyplanview").html(data);
				}
			});
		}

		function checkvalidity(data1, data2, data3, data4){
			document.getElementById(data1).innerHTML = data4;
			if(data4 === "Required"){
				$(data2).removeClass("text-success").addClass("text-danger");
				$(data3).removeClass("border-success").addClass("border-danger");
			}else if(data4 === "Valid"){
				$(data2).removeClass("text-danger").addClass("text-success");
				$(data3).removeClass("border-danger").addClass("border-success");
			}else{
				$(data2).removeClass("text-success").addClass("text-danger");
				$(data3).removeClass("border-success").addClass("border-danger");
			}
		}

		function clearform(data1, data2, data3){
			$(data1).removeClass("text-success").removeClass("text-danger");
			document.getElementById(data2).textContent="";
			$(data3).removeClass("border-success").removeClass("border-danger");
		}
	});
</script>

<div class="modal" id="addmonthlyplanmodal">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header bg-primary">
				<h6 class="modal-title text-white">Add Monthly PPP</h6>
				<button type="button" class="close text-white" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body p-4">
				<form id="addpppmonthlyplanform">
					<textarea class='form-control' rows='5' id='addmonthlypppplan' placeholder='What planning did you plan for this
					week...'></textarea>
					<small><span id="addmonthlypppplanerror"></span></small>
					<div class="row">
						<div class="col text-right">
							<button class="btn btn-primary" type="submit" id="submitaddmonthlyplan">Confirm</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
