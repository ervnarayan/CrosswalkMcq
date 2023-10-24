<?php include('header.php');?>
<div class="card" style="margin-top:15px;">
  <div class="card-header">
    <div class="row">
      <div class="col-md-9">
        <h5 class="panel-title">Module List</h5>
      </div>
      <div class="col-md-3" align="right">
        <button type="button" id="add_module" class="btn btn-info btn-sm">Add Module</button>
      </div>
    </div>  
  </div>
  <div class="card-body">
    <span id="message_operation"></span>
    <div class="table-responsive">
      <table class="table table-bordered table-striped table-hover" id="moduleList">
        <thead>
          <tr>
            <th style="width:5%">SrN</th>
            <th style="width:25%">Subject Name</th>
            <th style="width:50%">Module Name</th>
            <th style="width:10%">Serial No.</th>
            <th style="width:10%">Action</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
<div class="modal" id="detailModal">
    <div class="modal-dialog modal-lg">
      <form method="post" id="module_form">
        <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Module</h5>
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
                  <div class="row">
                      <label class="col-md-4 text-right">Module Name <span class="text-danger">*</span></label>
                      <div class="col-md-8">
                        <input type="text" name="module_name" id="module_name" autocomplete="off" class="form-control" />
                      </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                      <label class="col-md-4 text-right">Module Serial <span class="text-danger">*</span></label>
                      <div class="col-md-8">
                        <input type="text" name="module_serial_number" id="module_serial_number" autocomplete="off" class="form-control" />
                      </div>
                  </div>
                </div>            
            </div>
            <div class="modal-footer">
              <div class="modal-footer">
                  <input type="hidden" name="module_id" id="module_id" />
                  <input type="hidden" name="page" value="moduleList" />
                  <input type="hidden" name="action" id="action"  />
                  <input type="submit" name="button_action" id="button_action" class="btn btn-success btn-sm" value="Add Module" />
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
      var dataTable = $('#moduleList').DataTable({
        "processing" : true,
        "serverSide" : true,
        "order" : [],
        "ajax" : {
          url:"ajax_action.php",
          type:"POST",
          data:{action:'fetch_module', page:'moduleList'}
        },
        "columnDefs":[
          {
            "targets":[0],
            "orderable":false,
          },
        ],
      });

      $('#module_form').parsley();

      function reset_question_form(){
        $('#module_form')[0].reset();
        $('#module_form').parsley().reset();
      }

      $("#add_module").click(function(){
        reset_question_form();
        $('#button_action').val('Add Module');
        $('#module_id').val('');
        $('#action').val("add_module");
        $('#detailModal').modal('show');
      });

      $(document).on('click', '.fetch_module_edit', function(){
        var module_id = $(this).attr('id');
        reset_question_form();
        $.ajax({
              url:"ajax_action.php",
              method:"POST",
              data:{action:'edit_module_fetch', page:'moduleList', module_id:module_id},
              dataType:"json",
              success:function(data){
                $('#module_id').val(data.module_id);
                $('#subject_id').val(data.subject_id);
                $('#module_name').val(data.module_name);
                $('#module_serial_number').val(data.module_serial_number);
                $('#button_action').val('Edit Module');
                $('#action').val("edit_module");
                $('#detailModal').modal('show');
              }
          });
      });

      $(document).on('click', '.delete_module', function(){
        if(confirm("Sure! You want to delete this?")){
          var module_id = $(this).attr('id');
          $.ajax({
                url:"ajax_action.php",
                method:"POST",
                data:{action:'delete_module', page:'moduleList', module_id: module_id},
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

      $('#module_form').on('submit', function(event){
          event.preventDefault();
          $('#subject_id').attr('required', 'required');
          $('#module_name').attr('required', 'required');
          $('#module_serial_number').attr('required', 'required');

          if($('#module_form').parsley().validate()){
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