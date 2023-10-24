<?php include('header.php'); ?>

	<div class="containter" style="margin-top:15px;margin-bottom: 100px;">
		<div class="d-flex justify-content-center">
			<br /><br />
			<div class="card">
        		<div class="card-header"><h4>Student Registration</h4></div>
        		<div class="card-body">
        			   <span id="message"></span>
                <form method="post" id="user_register_form">

                <div class="row">    
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Enter Name</label>
                      <input type="text" name="user_name" id="user_name" class="form-control" /> 
                    </div>
                  </div>                              
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Enter Email Address</label>
                      <input type="text" name="user_email_address" id="user_email_address" class="form-control" data-parsley-checkemail data-parsley-checkemail-message='Email Address already Exists' />
                    </div>                    
                  </div>
                </div>

                <div class="row">                  
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Enter Password</label>
                      <input type="password" name="user_password" id="user_password" class="form-control" />
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Enter Confirm Password</label>
                      <input type="password" name="confirm_user_password" id="confirm_user_password" class="form-control" />
                    </div>
                  </div>
                </div>

                <div class="row">                  
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>National ID Type</label>
                      <input type="text" name="national_id_type" id="national_id_type" class="form-control" />
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>National ID Number</label>
                      <input type="text" name="national_id_no" id="national_id_no" class="form-control" />
                    </div>
                  </div>
                </div>                

                <div class="row">                  
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Enter Mobile Number</label>
                      <input type="text" name="user_mobile_no" id="user_mobile_no" class="form-control" /> 
                    </div>                    
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Select Gender</label>
                      <select name="user_gender" id="user_gender" class="form-control">
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                      </select> 
                    </div>
                  </div>
                </div>

                <div class="row">                  
                  <div class="col-md-12">
                    <div class="form-group">
                      <label>Enter Address</label>
                      <textarea name="user_address" id="user_address" class="form-control"></textarea>
                    </div>
                  </div>
                </div>

                <br/>
                <div class="row">                  
                  <div class="col-md-12">
                    <div class="form-group">
                      <label>Select Profile Image</label>
                      <input type="file" name="user_image" id="user_image" />
                    </div>
                  </div>
                </div>                                                                
                <br/>
                <div class="row">                  
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Assign Batch</label>
                      <select name="user_batch" id="user_batch" class="form-control">
                          <option value="">Select Batch</option>
                      <?php  foreach ($exam->get_batch_list() as $row) { ?>
                          <option value="<?php echo $row['batch_id'] .'-'. $row['batch_code'];?>"><?=$row['batch_name'];?></option>
                      <?php } ?>

                      
                        <!-- <option value="Female">Batch 2</option> -->
                      </select> 
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Account Status</label>
                      <select name="user_status" id="user_status" class="form-control">
                        <option value="active">Active</option>
                        <option value="deactive">De-active</option>
                      </select> 
                    </div>
                  </div>
                </div>   
                  
      
                  <br/>
                  <br />


                  <div class="form-group" align="center">
                    <input type="hidden" name='page' value='user' />
                    <input type="hidden" name="action" value="register" />
                    <input type="submit" name="user_register" id="user_register" class="btn btn-info" value="Register" />
                  </div>
                </form>
        		</div>
      		</div>
      		<br /><br />
      		<br /><br />
		</div>
	</div>

</body>
</html>
<script>
$(document).ready(function(){
    window.ParsleyValidator.addValidator('checkemail', {
      validateString: function(value){
        return $.ajax({
          url:'ajax_action.php',
          method:'post',
          data:{page:'user', action:'is_valid', email:value},
          dataType:"json",
          async: false,
          success:function(data){
            return true;
          }
        });
      }
    });
    $('#user_register_form').parsley();
    $('#user_register_form').on('submit', function(event){ 
      event.preventDefault();
      $('#user_email_address').attr('required', 'required');
      $('#user_email_address').attr('data-parsley-type', 'email');
      $('#user_password').attr('required', 'required');
      $('#confirm_user_password').attr('required', 'required');
      $('#confirm_user_password').attr('data-parsley-equalto', '#user_password');
      $('#user_name').attr('required', 'required');
      $('#user_name').attr('data-parsley-pattern', '^[a-zA-Z ]+$');
      $('#user_address').attr('required', 'required');
      $('#user_mobile_no').attr('required', 'required');
      $('#user_mobile_no').attr('data-parsley-pattern', '^[0-9]+$');
      $('#user_image').attr('required', 'required');
      $('#user_image').attr('accept', 'image/*');
      if($('#user_register_form').parsley().validate()){
        $.ajax({
          url:'ajax_action.php',
          method:"POST",
          data:new FormData(this),
          dataType:"json",
          contentType:false,
          cache:false,
          processData:false,
          beforeSend:function(){
            $('#user_register').attr('disabled', 'disabled');
            $('#user_register').val('please wait...');
          },
          success:function(data){
            if(data.success){
              $('#message').html('<div class="alert alert-success">User registered successfully</div>');
              $('#user_register_form')[0].reset();
              $('#user_register_form').parsley().reset();
              $('#user_register').attr('disabled', false);
              $('#user_register').val('Register');
            }
          }
        });
      }
    });
});

</script>