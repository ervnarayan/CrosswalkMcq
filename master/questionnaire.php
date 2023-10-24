<?php include('header.php');?> 



<div class="modal" id="detailImportModal">
    <div class="modal-dialog modal-lg">
      <form method="post" id="questionnaire_form">
        <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Import Questionnaire</h5>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" id="user_details">
                <div class="form-group">
                  <div class="row">
                      <label class="col-md-3 text-right">Questionnaire Text <span class="text-danger">*</span></label>
                      <div class="col-md-9">
                        <input type="file" name="questionnaire_file" id="questionnaire_file" autocomplete="off" class="form-control" />
                      </div>
                  </div>
                </div>
            </div>
            <div class="modal-footer">
              <div class="modal-footer">
                  <input type="hidden" name="questionnaire_id" id="questionnaire_id" />
                  <input type="hidden" name="page" value="questionnaireList_" />
                  <input type="hidden" name="action" id="action"  />
                  <input type="submit" name="button_action_upload" id="button_action_upload" class="btn btn-success btn-sm" value="Upload" />
                  <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
              </div>
            </div>
        </div>
      </form>  
    </div>
</div>



<div class="card" style="margin-top:15px;">
  <div class="card-header">
    <div class="row">
      <div class="col-md-9">
        <h5 class="panel-title">Questionnaire List</h5>
      </div>
      <div class="col-md-3" align="right">
        <a href="javascript:;" class="btn btn-info btn-sm import"><i class="plus">+</i> Import</a>
        <a href="exportData.php" class="btn btn-info btn-sm"><i class="exp">+</i> Export</a>
        <button type="button" id="add_questionnaire" class="btn btn-info btn-sm">Add Questionnaire</button>
      </div>
    </div>  
  </div>
  <div class="card-body">
    <span id="message_operation"></span>
    <div class="table-responsive">
      <table class="table table-bordered table-striped table-hover" id="questionnaireList">
        <thead>
          <tr>
            <th style="width:5%">SrN</th>
            <th style="width:15%">Subject Name</th>
            <th style="width:10%">Chapter Code</th>
            <th style="width:50%">Questionnaire Text</th>
            <th style="width:10%">Right Option</th>
            <th style="width:10%">Action</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>



<div class="modal" id="detailModal">
    <div class="modal-dialog modal-lg">
      <form method="post" id="questionnaire_form">
        <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Questionnaire</h5>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" id="user_details">
                <div class="form-group">
                  <div class="row">
                      <label class="col-md-3 text-right">Select Subject<span class="text-danger">*</span></label>
                      <div class="col-md-9">
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
                  <div class="row get_chapter">
                    
                  </div>
                </div> 

                <div class="form-group">
                  <div class="row">
                      <label class="col-md-3 text-right">Questionnaire Text <span class="text-danger">*</span></label>
                      <div class="col-md-9">
                        <input type="text" name="questionnaire_text" id="questionnaire_text" autocomplete="off" class="form-control" />
                      </div>
                  </div>
                </div>


                <div class="form-group">
                  <div class="row">
                      <label class="col-md-3 text-right">Point I</label>
                      <div class="col-md-9">
                        <input type="text" name="point_1" id="point_1" autocomplete="off" class="form-control" />
                      </div>
                  </div>
                </div>

                <div class="form-group">
                  <div class="row">
                      <label class="col-md-3 text-right">Point II</label>
                      <div class="col-md-9">
                        <input type="text" name="point_2" id="point_2" autocomplete="off" class="form-control" />
                      </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                      <label class="col-md-3 text-right">Point III</label>
                      <div class="col-md-9">
                        <input type="text" name="point_3" id="point_3" autocomplete="off" class="form-control" />
                      </div>
                  </div>
                </div>
                                                              
                <div class="form-group">
                  <div class="row">
                      <label class="col-md-3 text-right">Point IV</label>
                      <div class="col-md-9">
                        <input type="text" name="point_4" id="point_4" autocomplete="off" class="form-control" />
                      </div>
                  </div>
                </div>

                <div class="form-group">
                  <div class="row">
                      <label class="col-md-3 text-right">Option A <span class="text-danger">*</span></label>
                      <div class="col-md-9">
                        <input type="text" name="option_a" id="option_a" autocomplete="off" class="form-control" />
                      </div>
                  </div>
                </div>

                <div class="form-group">
                  <div class="row">
                      <label class="col-md-3 text-right">Option B <span class="text-danger">*</span></label>
                      <div class="col-md-9">
                        <input type="text" name="option_b" id="option_b" autocomplete="off" class="form-control" />
                      </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                      <label class="col-md-3 text-right">Option C <span class="text-danger">*</span></label>
                      <div class="col-md-9">
                        <input type="text" name="option_c" id="option_c" autocomplete="off" class="form-control" />
                      </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                      <label class="col-md-3 text-right">Option D <span class="text-danger">*</span></label>
                      <div class="col-md-9">
                        <input type="text" name="option_d" id="option_d" autocomplete="off" class="form-control" />
                      </div>
                  </div>
                </div> 

                <div class="form-group">
                  <div class="row">
                      <label class="col-md-3 text-right">Right Option <span class="text-danger">*</span></label>
                      <div class="col-md-9">
                        <select name="correct_option" id="correct_option" class="form-control">
                          <option value="">Select</option>
                          <option value="a">A</option>
                          <option value="b">B</option>
                          <option value="c">C</option>
                          <option value="d">D</option>
                        </select>
                      </div>
                  </div>
                </div>   



            </div>
            <div class="modal-footer">
              <div class="modal-footer">
                  <input type="hidden" name="questionnaire_id" id="questionnaire_id" />
                  <input type="hidden" name="page" value="questionnaireList" />
                  <input type="hidden" name="action" id="action"  />
                  <input type="submit" name="button_action" id="button_action" class="btn btn-success btn-sm" value="Add Questionnaire" />
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
      var dataTable = $('#questionnaireList').DataTable({
        "processing" : true,
        "serverSide" : true,
        "order" : [],
        "ajax" : {
          url:"ajax_action.php",
          type:"POST",
          data:{action:'fetch_questionnaire', page:'questionnaireList'}
        },
        "columnDefs":[
          {
            "targets":[0],
            "orderable":false,
          },
        ],
      });

      function get_chapter_list(subject_id="", selected=""){
          $.ajax({
              url:"ajax_action.php",
              method:"POST",
              data:{action:'get_chapter', page:'questionnaireList', subject_id: subject_id, selected:selected},
              success:function(data){
                $(".get_chapter").html(data);
              }
          });   
      }      

      $('#questionnaire_form').parsley();

      function reset_question_form(){
        $('#questionnaire_form')[0].reset();
        $('#questionnaire_form').parsley().reset();
      }

      $("#add_questionnaire").click(function(){
        reset_question_form();
        $('#button_action').val('Add Questionnaire');
        $('#questionnaire_id').val('');
        $('#action').val("add_questionnaire");
        $('#detailModal').modal('show');
      });

      $(document).on('click', '.fetch_questionnaire_edit', function(){
        var questionnaire_id = $(this).attr('id');
        reset_question_form();
        $.ajax({
              url:"ajax_action.php",
              method:"POST",
              data:{action:'edit_questionnaire_fetch', page:'questionnaireList', questionnaire_id:questionnaire_id},
              dataType:"json",
              success:function(data){
                $('#questionnaire_id').val(data.questionnaire_id);
                $('#subject_id').val(data.subject_id);
                get_chapter_list(data.subject_id, data.chapter_id);
                $('#questionnaire_text').val(data.questionnaire_text);
                $('#point_1').val(data.point_1);
                $('#point_2').val(data.point_2);
                $('#point_3').val(data.point_3);
                $('#point_4').val(data.point_4);
                $('#option_a').val(data.option_a);
                $('#option_b').val(data.option_b);
                $('#option_c').val(data.option_c);
                $('#option_d').val(data.option_d);
                $('#correct_option').val(data.correct_option);
                $('#button_action').val('Edit Questionnaire');
                $('#action').val("edit_questionnaire");
                $('#detailModal').modal('show');
              }
          });
      });

      $(document).on('click', '.delete_questionnaire', function(){
        if(confirm("Sure! You want to delete this?")){
          var questionnaire_id = $(this).attr('id');
          $.ajax({
                url:"ajax_action.php",
                method:"POST",
                data:{action:'delete_questionnaire', page:'questionnaireList', questionnaire_id: questionnaire_id},
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

      $('#questionnaire_form').on('submit', function(event){
          event.preventDefault();
          $('#subject_id').attr('required', 'required');
          $('#module_id').attr('required', 'required');
          $('#questionnaire_name').attr('required', 'required');
          $('#questionnaire_number').attr('required', 'required');

          if($('#questionnaire_form').parsley().validate()){
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
          get_chapter_list(subject_id);
      });

      $(".import").click(function(){
        $("#detailImportModal").modal("show");
      });
  });
</script>
</html>