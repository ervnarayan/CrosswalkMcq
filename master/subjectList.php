<?php include('header.php');?>
<div class="card" style="margin-top:15px;">
  <div class="card-header">
    <div class="row">
      <div class="col-md-9">
        <h5 class="panel-title">Subject List</h5>
      </div>
      <div class="col-md-3" align="right">
        <button type="button" id="add_subject" class="btn btn-info btn-sm">Add Subject</button>
      </div>
    </div>  
  </div>
  <div class="card-body">
    <span id="message_operation"></span>
    <div class="table-responsive">
      <table class="table table-bordered table-striped table-hover" id="subList">
        <thead>
          <tr>
            <th style="width:5%">SrN</th>
            <th style="width:75%">Suject Name</th>
            <th style="width:10%">Suject Code</th>
            <th style="width:10%">Action</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
<div class="modal" id="detailModal">
    <div class="modal-dialog modal-lg">
      <form method="post" id="subject_form">
        <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Subject</h5>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" id="user_details">
                <div class="form-group">
                  <div class="row">
                      <label class="col-md-4 text-right">Subject Name <span class="text-danger">*</span></label>
                      <div class="col-md-8">
                        <input type="text" name="subject_name" id="subject_name" autocomplete="off" class="form-control" />
                      </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                      <label class="col-md-4 text-right">Subject Code <span class="text-danger">*</span></label>
                      <div class="col-md-8">
                        <input type="text" name="subject_code" id="subject_code" autocomplete="off" class="form-control" />
                      </div>
                  </div>
                </div>            
            </div>
            <div class="modal-footer">
              <div class="modal-footer">
                  <input type="hidden" name="subject_id" id="subject_id" />
                  <input type="hidden" name="page" value="subList" />
                  <input type="hidden" name="action" id="action"  />
                  <input type="submit" name="button_action" id="button_action" class="btn btn-success btn-sm" value="Add Subject" />
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
      var dataTable = $('#subList').DataTable({
        "processing" : true,
        "serverSide" : true,
        "order" : [],
        "ajax" : {
          url:"ajax_action.php",
          type:"POST",
          data:{action:'fetch_subject', page:'subList'}
        },
        "columnDefs":[
          {
            "targets":[2],
            "orderable":false,
          },
        ],
      });

      $('#subject_form').parsley();

      function reset_question_form(){
        $('#subject_form')[0].reset();
        $('#subject_form').parsley().reset();
      }

      $("#add_subject").click(function(){
        reset_question_form();
        $('#button_action').val('Add Subject');
        $('#subject_id').val('');
        $('#action').val("add_subject");
        $('#detailModal').modal('show');
      });

      $(document).on('click', '.fetch_subject_edit', function(){
        var subject_id = $(this).attr('id');
        reset_question_form();
        $.ajax({
              url:"ajax_action.php",
              method:"POST",
              data:{action:'edit_subject_fetch', page:'subList', subject_id:subject_id},
              dataType:"json",
              success:function(data){
                $('#subject_id').val(data.subject_id);
                $('#subject_name').val(data.subject_name);
                $('#subject_code').val(data.subject_code);
                $('#button_action').val('Edit Subject');
                $('#action').val("edit_subject");
                $('#detailModal').modal('show');
              }
          });
      });

      $(document).on('click', '.delete_subject', function(){
        if(confirm("Sure! You want to delete this?")){
          var subject_id = $(this).attr('id');
          $.ajax({
                url:"ajax_action.php",
                method:"POST",
                data:{action:'delete_subject', page:'subList', subject_id: subject_id},
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

      $('#subject_form').on('submit', function(event){
          event.preventDefault();
          $('#subject_name').attr('required', 'required');
          $('#subject_code').attr('required', 'required');
          if($('#subject_form').parsley().validate()){
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
  });
</script>
</html>