<?php
  include('class/Examination.php');
  $exam = new Examination;
  $exam->user_session_private();
  $exam->query ="SELECT * FROM `subject` INNER JOIN `subject_assignment` ON `subject_assignment`.`subject_id` = `subject`.`subject_id` WHERE `subject_assignment`.`batch_id` = '".$_SESSION['batch_id']."' ORDER BY `subject`.`subject_id` DESC";
  $result = $exam->query_result();
  $mode_sub = $exam->get_mode_sub_id();
  include('header.php');
?>
<div class="card" style="margin-top:30px;">
  <div class="card-header">
    <div class="row">
      <div class="col-md-4">
          Subject List        
      </div>
    </div>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered table-striped table-hover" id="subList">
        <thead>
          <tr>
            <th style="width:5%">SrN</th>
            <th style="width:75%">Suject Name</th>
            <th style="width:10%">Suject Code</th>
            <th style="width:10%">Select</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
</body>
<script type="text/javascript">
  $(document).ready(function(){
    $(document).on('click','.select_subject',function(){
        var subject_id = $(this).attr('value');
        $.ajax({
          url:"user_ajax_action.php",
          method:"POST",
          data:{action:'add_subject', page:'topics', subject_id:subject_id},
          success:function(data){
            if(jQuery.trim(data) == "success"){
                window.location.href="topics.php";
            }else{
               alert(data);
            }
          }
        });
    });
    var dataTable = $('#subList').DataTable({
      "processing" : true,
      "serverSide" : true,
      "order" : [],
      "ajax" : {
        url:"user_ajax_action.php",
        type:"POST",
        data:{action:'fetch_subject', page:'subList'}
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
</html>