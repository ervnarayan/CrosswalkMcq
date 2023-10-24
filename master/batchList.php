<?php include('header.php');?>
<div class="card" style="margin-top:15px;">
  <div class="card-header">
    <div class="row">
      <div class="col-md-9">
        <h5 class="panel-title">Batch List</h5>
      </div>
      <div class="col-md-3" align="right">
        <button type="button" id="add_batch" class="btn btn-info btn-sm">Add Batch</button>
      </div>
    </div>  
  </div>
  <div class="card-body">
    <span id="message_operation"></span>
    <div class="table-responsive">
      <table class="table table-bordered table-striped table-hover" id="batchList">
        <thead>
          <tr>
            <th style="width:5%">SrN</th>
            <th style="width:75%">Batch Name</th>
            <th style="width:10%">Batch Code</th>
            <th style="width:10%">Action</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
<div class="modal" id="detailModal">
    <div class="modal-dialog modal-lg">
      <form method="post" id="batch_form">
        <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Batch</h5>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" id="user_details">
                <div class="form-group">
                  <div class="row">
                      <label class="col-md-4 text-right">Batch Name <span class="text-danger">*</span></label>
                      <div class="col-md-8">
                        <input type="text" name="batch_name" id="batch_name" autocomplete="off" class="form-control" />
                      </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                      <label class="col-md-4 text-right">Batch Code <span class="text-danger">*</span></label>
                      <div class="col-md-8">
                        <input type="text" name="batch_code" id="batch_code" autocomplete="off" class="form-control" />
                      </div>
                  </div>
                </div>            

                <div class="form-group">
                  <div class="row">
                      <label class="col-md-4 text-right">Batch Start <span class="text-danger">*</span></label>
                      <div class="col-md-8">
                        <input type="text" name="batch_code" class="batch_date" autocomplete="off" class="form-control" />
                      </div>
                  </div>
                </div> 

                <div class="form-group">
                  <div class="row">
                      <label class="col-md-4 text-right">Batch End <span class="text-danger">*</span></label>
                      <div class="col-md-8">
                        <input type="text" name="batch_code" class="batch_date" autocomplete="off" class="form-control" />
                      </div>
                  </div>
                </div>                 
           
            </div>
            <div class="modal-footer">
              <div class="modal-footer">
                  <input type="hidden" name="batch_id" id="batch_id" />
                  <input type="hidden" name="page" value="batchList" />
                  <input type="hidden" name="action" id="action"  />
                  <input type="submit" name="button_action" id="button_action" class="btn btn-success btn-sm" value="Add Batch" />
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
      var dataTable = $('#batchList').DataTable({
        "processing" : true,
        "serverSide" : true,
        "order" : [],
        "ajax" : {
          url:"ajax_action.php",
          type:"POST",
          data:{action:'fetch_batch', page:'batchList'}
        },
        "columnDefs":[
          {
            "targets":[2],
            "orderable":false,
          },
        ],
      });

      $('#batch_form').parsley();

      function reset_question_form(){
        $('#batch_form')[0].reset();
        $('#batch_form').parsley().reset();
      }

      $("#add_batch").click(function(){
        reset_question_form();
        $('#button_action').val('Add Batch');
        $('#batch_id').val('');
        $('#action').val("add_batch");
        $('#detailModal').modal('show');
      });

      $(document).on('click', '.fetch_batch_edit', function(){
        var batch_id = $(this).attr('id');
        reset_question_form();
        $.ajax({
              url:"ajax_action.php",
              method:"POST",
              data:{action:'edit_batch_fetch', page:'batchList', batch_id:batch_id},
              dataType:"json",
              success:function(data){
                $('#batch_id').val(data.batch_id);
                $('#batch_name').val(data.batch_name);
                $('#batch_code').val(data.batch_code);
                $('#button_action').val('Edit Batch');
                $('#action').val("edit_batch");
                $('#detailModal').modal('show');
              }
          });
      });

      $(document).on('click', '.delete_batch', function(){
        if(confirm("Sure! You want to delete this?")){
          var batch_id = $(this).attr('id');
          $.ajax({
                url:"ajax_action.php",
                method:"POST",
                data:{action:'delete_batch', page:'batchList', batch_id: batch_id},
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

      $('#batch_form').on('submit', function(event){
          event.preventDefault();
          $('#batch_name').attr('required', 'required');
          $('#batch_code').attr('required', 'required');
          if($('#batch_form').parsley().validate()){
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

      $(".batch_date").datetimepicker({format: 'yyyy-mm-dd'});
 
  });
</script>
</html>