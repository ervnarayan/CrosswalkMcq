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
          <select id="subject_list" class="form-control input-lg" disabled="">
            <option value="">Select subject</option>
            <?php foreach($result as $row) { ?>              
            <option <?=($mode_sub == $row['subject_id'] ? "selected" : ""); ?> value="<?=$row['subject_id']?>"><?=$row['subject_name']?></option>                    
            <?php } ?>
          </select>          
      </div>
      <div class="col-md-2"><input type="text" placeholder="Enter Question Number.." value="<?=@$_SESSION['mcq_number']?>" class="mcqn" id="mcqn"></div>
      <div class="col-md-4 timing">
        <?php
          if(@$_SESSION['mcq_timing'] !=""){
            echo "<h6> Exam Timing :  <span> ".$_SESSION['mcq_timing']." Mins</span></h6>";
          }
        ?>
      </div>
      <div class="col-md-2 ab"><div class="mcqPlay" id="mcqPlay" ><div class="btn btn-1"><a href="javascript:;" ><p>Play MCQ</p></a></div></div></div>
    </div>

  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered table-striped table-hover" id="chapter_table">
        <thead>
          <tr>
            <th style="width:40%">Module Name</th>
            <th style="width:55%">Chapter Name</th>
            <th style="width:5%">Select</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
</body>
<script type="text/javascript">
  $(document).ready(function(){

    $('#subject_list, #module_list').parsley();

    // $('#subject_list').change(function(){
    //   $('#subject_list').attr('required', 'required');
    //   if($('#subject_list').parsley().validate()){
    //     var subject_id = $('#subject_list').val();
    //     $.ajax({
    //       url:"user_ajax_action.php",
    //       method:"POST",
    //       data:{action:'add_subject', page:'topics', subject_id:subject_id},
    //       success:function(data){
    //         if(jQuery.trim(data) == "success"){
    //             location.reload();
    //         }else{
    //            alert(data);
    //         }
    //       }
    //     });
    //   }
    // });

    $('#mcqn').keyup(function(){
        var mcqn = $('#mcqn').val();
        $.ajax({
          url:"user_ajax_action.php",
          method:"POST",
          data:{action:'add_mcqn', page:'topics', mcqn:mcqn},
          success:function(data){
              $(".timing").html(data);
          }
        });
    });

    var dataTable = $('#chapter_table').DataTable({
      "processing" : true,
      "serverSide" : true,
      "order" : [],
      "ajax" : {
        url:"user_ajax_action.php",
        type:"POST",
        data:{action:'fetch_chapter', page:'topics'}
      },
      "columnDefs":[
        {
          "targets":[0],
          "orderable":false,
        },
      ],
    });

    var chapterList = "";
    $(document).on("click", "#chapter_table input[type=checkbox]", function(){
      var mcqn = $("#mcqn").val();
      if(mcqn != ""){
        var chapter = new Array();        
        $("input[type=checkbox]:checked").each(function () {
          chapter.push(this.value);
        });
        if(mcqn >= chapter.length){
          chapterList = chapter;
        }else{
          alert("Chapter cannot exceed question number.");
          return false;
        }
      }else{
        alert("Please enter question count.");
        return false;
      }
    });
 
    $("#mcqPlay").click(function(){
      if(chapterList !== ""){
        var chapterLists = chapterList.toString();
        $.ajax({
          url:"user_ajax_action.php",
          method:"POST",
          data:{action:'create_mcq', page:'topics', chapterLists:chapterLists},
          dataType:"json",
          beforeSend:function(){
            $('.ab').html('<img src="assets/Images/loading.gif" width="35px" height="35px"/> Please wait...');            
          },
          success:function(data){
            if(data.success){
              // alert('data.success');
              window.location.href=data.href;
            }else{
              alert(data.error);

            }
          }
        });
      }else{
        alert("Subject, number of questions & chapter is required to play MCQ.");
      }
    });
  });
</script>

</html>