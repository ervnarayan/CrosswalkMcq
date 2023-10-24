<?php
  include('class/Examination.php');
  $exam = new Examination;
  $exam->user_session_private();
  include('header.php');
?>


<div class="row home" style="margin-top:30px;">
  <div class="col-md-2"></div>
  <div class="col-md-8">
    <div id="user_details_area"></div>    
  </div>
  <div class="col-md-2"></div>
  <div class="col-md-2"></div>
  <div class="col-md-8">
    <div class="wrapper">
      <div class="btn btn-2">
        <a href="javascript:;" class="mode" mode="study"><p>Study Mode</p></a>
      </div>
      <div class="btn btn-3">
        <a href="javascript:;" class="mode" mode="exam"><p>Exam Mode</p></a>
      </div>
    </div>
  </div>
  <div class="col-md-2"></div>
</div>
</div>
</body>
<script type="text/javascript">
  $(document).ready(function(){
    $('.mode').click(function(){
        var md = $(this).attr('mode');
        $.ajax({
          url:"user_ajax_action.php",
          method:"POST",
          data:{action:'set_mode', page:'index', md:md},
          success:function(data){
            if(jQuery.trim(data) == "success"){
                window.location.href="subjectList.php";
            }else{
               alert(data);
            }
          }
        });
    });

    function load_user_details(){
      $.ajax({
        url:"user_ajax_action.php",
        method:"POST",
        data:{page:'index', action:'user_detail'},
        success:function(data)
        {
          $('#user_details_area').html(data);
        }
      })
    } 
    load_user_details();   
  });
</script>
</html>