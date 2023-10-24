<?php include('header.php');?>
<div class="card" style="margin-top:15px;">
  <div class="card-header">
    <div class="row">
      <div class="col-md-9">
        <h5 class="panel-title">Chapter List</h5>
      </div>
      <div class="col-md-3" align="right">
        <button type="button" id="add_chapter" class="btn btn-info btn-sm">Add Chapter</button>
      </div>
    </div>  
  </div>
  <div class="card-body">
    <span id="message_operation"></span>
    <div class="table-responsive">
      <table class="table table-bordered table-striped table-hover" id="chapterList">
        <thead>
          <tr>
            <th style="width:5%">SrN</th>
            <th style="width:20%">Subject Name</th>
            <th style="width:5%">Code</th>
            <th style="width:50%">Chapter Name</th>
            <th style="width:10%">Chapter No.</th>
            <th style="width:10%">Action</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
<div class="modal" id="detailModal">
    <div class="modal-dialog modal-lg">
      <form method="post" id="chapter_form">
        <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Chapter</h5>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" id="user_details">

                <div class="form-group">
                  <div class="row">
                      <label class="col-md-4 text-right">Select Subject<span class="text-danger">*</span></label>
                      <div class="col-md-8">
                        <select name="subject_id" id="subject_id" class="form-control">
                          <option value="">Select</option>
                          <?php foreach ($exam->get_subject_list() as $row) { ?>
                            <option value="<?=$row['subject_id']; ?>"><?=$row['subject_name']; ?></option>
                          <?php } ?>
                        </select>
                      </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row get_module">
                      
                  </div>
                </div>                   
                <div class="form-group">
                  <div class="row">
                      <label class="col-md-4 text-right">Chapter Name <span class="text-danger">*</span></label>
                      <div class="col-md-8">
                        <input type="text" name="chapter_name" id="chapter_name" autocomplete="off" class="form-control" />
                      </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                      <label class="col-md-4 text-right">Chapter No. <span class="text-danger">*</span></label>
                      <div class="col-md-8">
                        <input type="text" name="chapter_number" id="chapter_number" autocomplete="off" class="form-control" />
                      </div>
                  </div>
                </div>            
            </div>
            <div class="modal-footer">
              <div class="modal-footer">
                  <input type="hidden" name="chapter_id" id="chapter_id" />
                  <input type="hidden" name="page" value="chapterList" />
                  <input type="hidden" name="action" id="action"  />
                  <input type="submit" name="button_action" id="button_action" class="btn btn-success btn-sm" value="Add Chapter" />
                  <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
              </div>
            </div>
        </div>
      </form>  
    </div>
</div>
</body>
<script type="text/javascript">
  $(document).ready(function(){
      var dataTable = $('#chapterList').DataTable({
        "processing" : true,
        "serverSide" : true,
        "order" : [],
        "ajax" : {
          url:"ajax_action.php",
          type:"POST",
          data:{action:'fetch_chapter', page:'chapterList'}
        },
        "columnDefs":[
          {
            "targets":[0],
            "orderable":false,
          },
        ],
      });

      function get_module_list(subject_id="", selected=""){
          $.ajax({
              url:"ajax_action.php",
              method:"POST",
              data:{action:'get_module', page:'chapterList', subject_id: subject_id, selected:selected},
              success:function(data){
                $(".get_module").html(data);
              }
          });   
      }      

      $('#chapter_form').parsley();

      function reset_question_form(){
        $('#chapter_form')[0].reset();
        $('#chapter_form').parsley().reset();
      }

      $("#add_chapter").click(function(){
        reset_question_form();
        $('#button_action').val('Add Chapter');
        $('#chapter_id').val('');
        $('#action').val("add_chapter");
        $('#detailModal').modal('show');
      });

      $(document).on('click', '.fetch_chapter_edit', function(){
        var chapter_id = $(this).attr('id');
        reset_question_form();
        $.ajax({
              url:"ajax_action.php",
              method:"POST",
              data:{action:'edit_chapter_fetch', page:'chapterList', chapter_id:chapter_id},
              dataType:"json",
              success:function(data){
                $('#chapter_id').val(data.chapter_id);
                $('#subject_id').val(data.subject_id);
                get_module_list(data.subject_id, data.module_id);
                $('#chapter_name').val(data.chapter_name);
                $('#chapter_number').val(data.chapter_number);
                $('#button_action').val('Edit Chapter');
                $('#action').val("edit_chapter");
                $('#detailModal').modal('show');
              }
          });
      });

      $(document).on('click', '.delete_chapter', function(){
        if(confirm("Sure! You want to delete this?")){
          var chapter_id = $(this).attr('id');
          $.ajax({
                url:"ajax_action.php",
                method:"POST",
                data:{action:'delete_chapter', page:'chapterList', chapter_id: chapter_id},
                dataType:"json",
                success:function(data){
                  if(data.success){
                    $('#message_operation').html('<div class="alert alert-danger">'+data.success+'</div>');
                    dataTable.ajax.reload();
                  }
                }
          });
        }  
      });

      $('#chapter_form').on('submit', function(event){
          event.preventDefault();
          $('#subject_id').attr('required', 'required');
          $('#module_id').attr('required', 'required');
          $('#chapter_name').attr('required', 'required');
          $('#chapter_number').attr('required', 'required');

          if($('#chapter_form').parsley().validate()){
            $.ajax({
              url:"ajax_action.php",
              method:"POST",
              data:$(this).serialize(),
              dataType:"json",
              beforeSend:function(){
                $('#button_action').attr('disabled', 'disabled');
                $('#button_action').val('Validate...');
              },
              success:function(data){
                if(data.success){
                  $('#message_operation').html('<div class="alert alert-success">'+data.success+'</div>');
                  reset_question_form();
                  dataTable.ajax.reload();
                  $('#detailModal').modal('hide');
                }
                $('#button_action').attr('disabled', false);
                $('#button_action').val($('#hidden_action').val());
              }
            });
          }
      });

      $("#subject_id").on('change',function(){
          var subject_id = $(this).val();
          get_module_list(subject_id);
      });
  });
</script>
</html>