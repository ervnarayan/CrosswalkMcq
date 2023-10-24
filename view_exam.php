<?php
include('class/Examination.php');
$exam = new Examination;
$exam->user_session_private();
include('header.php');

if(isset($_GET['code'])){
	$exam_status = $exam->get_exam_status($_GET['code']);
}else{
	header('location: topics.php');
}

if($exam_status == "Pending"){
	if(isset($_GET['code'])){
		if($exam->get_exam_code() == $_GET['code']){
			$exam_status = 'Started';
		}
	}
}

// $exam_id = '';
// $remaining_minutes = '';

?>
<?php if($exam_status == 'Started'){ ?>

<script type="text/javascript">
	// window.onbeforeunload = function() {
	//    return ;
	// };
</script>



<div class="row" style="margin-top:30px;">
	<div class="col-md-8">
		<div class="card">
			<div class="card-header"><?=ucfirst($exam->get_mode())?> Mode</div>
			<div class="card-body">
				<div id="single_question_area"></div>
			</div>
		</div>
		<br />
		<div id="question_navigation_area"></div>
	</div>
	<div class="col-md-4">
		<div align="center"><?=$exam->set_exam_clock(); ?></div>
		<div id="user_details_area"></div>		
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		var exam_code = "<?php echo $exam->get_exam_code(); ?>";
		load_question();
		question_navigation();

		function load_question(question_id = ''){
			$.ajax({
				url:"user_ajax_action.php",
				method:"POST",
				data:{question_id:question_id, page:'view_exam', action:'load_question'},
				success:function(data){
					$('#single_question_area').html(data);
				}
			})
		}

		$(document).on('click', '.next', function(){
			var question_id = $(this).attr('id');
			load_question(question_id);
		});

		$(document).on('click', '.previous', function(){
			var question_id = $(this).attr('id');
			load_question(question_id);
		});

		function question_navigation(){
			$.ajax({
				url:"user_ajax_action.php",
				method:"POST",
				data:{page:'view_exam', action:'question_navigation'},
				success:function(data){
					$('#question_navigation_area').html(data);
				}
			})
		}

		function load_user_details(){
			$.ajax({
				url:"user_ajax_action.php",
				method:"POST",
				data:{page:'view_exam', action:'user_detail'},
				success:function(data)
				{
					$('#user_details_area').html(data);
				}
			})
		}

		load_user_details();

		$("#exam_timer").TimeCircles({ 
			time:{
				Days:{
					show: false
				},
				Hours:{
					show: true
				}
			}
		});

		setInterval(function(){
			var remaining_second = $("#exam_timer").TimeCircles().getTime();
			if(remaining_second < 1){
				$.ajax({
					url:"user_ajax_action.php",
					method:"POST",
					data:{exam_code: exam_code, page:'view_exam', action:'finish'},
					success:function(data){
						// alert(data);
					}
				});
				alert('Exam time over!');
				location.reload();
			}
		}, 1000);

		var user_answer = [];
		$(document).on('click', '.answer_option', function(){
			var question_id = $(this).data('question_id');
			var answer_option = $(this).data('id');
			var qcount = $(this).data('count');
			user_answer[qcount] = question_id +'-'+ answer_option;
			$.ajax({
				url:"user_ajax_action.php",
				method:"POST",
				data:{user_answer:user_answer, page:'view_exam', action:'answer'},
				success:function(data){
					// alert(data);
				}
			})
		});


		$(document).on('click', '.viewAns', function(){
			$(".Qans").toggle();
		});

		$(document).on('click', '.finish', function(){
			$.ajax({
				url:"user_ajax_action.php",
				method:"POST",
				data:{exam_code: exam_code, page:'view_exam', action:'finish'},
				success:function(data){
					// alert(data);
					location.reload();
				}
			});
		});
	});
</script>



<?php } if($exam_status != 'Started'){ 
	$code = $_GET['code'];
	$exam->query = "SELECT * FROM `online_exam_table` INNER JOIN `subject` ON `subject`.`subject_id` =  `online_exam_table`.`subject_id` WHERE `online_exam_table`.`online_exam_code` = '".$code."'";
	$result = $exam->query_result();
	foreach($result as $row){
?>


<div class="card" style="margin-top:30px;">
	<div class="card-header">
		<div class="row">
			<div class="col-md-8">MCQ Result</div>
			<div class="col-md-4" align="right">
				<!-- <a href="pdf_exam_result.php?code=<?php echo $_GET["code"]; ?>" class="btn btn-danger btn-sm" target="_blank">PDF</a> -->
			</div>
		</div>
	</div>
	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-bordered table-hover">
				<tr>
					<th>Subject</th>
					<th>Date Of MCQ</th>
					<th>Total Question</th>
					<?php if($row['mcq_mode'] == "Exam"){ ?>
						<th>Score %</th>
						<th>Performance</th>
					<?php }else{ ?>
						<th><?=ucfirst($row['mcq_mode']); ?> mode</th>
					<?php } ?>	
				</tr>
				<tr>
					<td><?=$row['subject_name']?></td>
					<td><?=$row['online_exam_created_on']?></td>
					<td><?=$row['total_question']?></td>
					<?php if($row['mcq_mode'] == "Exam"){ ?>
						<td><?=$exam->percent_calculate($row['marks_obtained'], $row['total_question']); ?>%</td>
						<td><a href="performance.php?code=<?php echo $_GET["code"]; ?>">View</a></td>

					<?php }else{ ?>
						<td><?=ucfirst($row['online_exam_status']); ?></td>
					<?php } ?>	
				</tr>
			</table>
		</div>
	</div>
<?php } } ?>
</div>
</div>
</body>
</html>

