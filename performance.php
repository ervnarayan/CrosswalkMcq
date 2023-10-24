<?php
include('class/Examination.php');
$exam = new Examination;
$exam->user_session_private();
include('header.php');

if(isset($_GET['code'])){
	$code = $_GET['code'];
}else{
	header('location: topics.php');
}

// if($exam_status == "Pending"){
// 	if(isset($_GET['code'])){
// 		if($exam->get_exam_code() == $_GET['code']){
// 			$exam_status = 'Started';
// 		}
// 	}
// }


?>


<div class="card" style="margin-top:30px;">
  <div class="card-header">
    <div class="row">
      <div class="col-md-4">
          Exam Performance Report      
      </div>
    </div>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered table-striped table-hover" id="EReport">
        <thead>
          <tr>
            <th style="">SrN</th>
            <th style="">Question</th>
            <th style="">Option A</th>
            <th style="">Option B</th>
            <th style="">Option C</th>
            <th style="">Option D</th>
            <th style="">Your Answer</th>
            <th style="">Correct Answer</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>

<script type="text/javascript">
  $(document).ready(function(){
  	var code = "<?php echo $code; ?>";
    var dataTable = $('#EReport').DataTable({
      "processing" : true,
      "serverSide" : true,
      "order" : [],
      "ajax" : {
        url:"user_ajax_action.php",
        type:"POST",
        data:{action:'load_result', page:'performance', code: code}
      },
      "columnDefs":[
        {
          "targets":[0],
          "orderable":false,
        },
      ],
    });
  });
</script>





































































</div>
</body>
</html>

