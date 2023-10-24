<?php
include('header.php');
$_SESSION['user_id'] = @$_GET['sid'];
$exam->query = "SELECT * FROM user_table WHERE user_id = '".$_SESSION['user_id']."'";
$result = $exam->query_result();
?>
<div class="containter" style="margin-top:15px;">
	<div class="d-flex justify-content-center">
		<span id="message"></span>
		<div class="card" style="margin-bottom: 100px;">
    		<div class="card-header"><h4>Edit Student Details</h4></div>
    		<div class="card-body">
    			<form method="post" id="profile_form">
    				<?php foreach($result as $row) { ?>
    				<script>
    				$(document).ready(function(){
    					$('#user_gender').val("<?php echo $row["user_gender"]; ?>");
    					$('#user_status').val("<?php echo $row["user_status"]; ?>");
    				});
    				</script>
    				<div class="row">
        				<div class="col-md-6">
	 					    <div class="form-group">
						        <label>Enter Name</label>
						        <input type="text" name="user_name" id="user_name" class="form-control" value="<?php echo $row["user_name"]; ?>" />
						    </div>       					
        				</div>
        				<div class="col-md-6">
	 					    <div class="form-group">
						        <label>MCQ Attempt</label>
						        <input type="text" name="mcq_attempt_counter" id="mcq_attempt_counter" class="form-control" value="<?php echo $row["mcq_attempt_counter"]; ?>" />
						    </div>       					
        				</div>	        				
    				</div>
    				<div class="row">
        				<div class="col-md-6">
						    <div class="form-group">
						        <label>Enter Email</label>
						        <input type="text" name="user_email" id="user_email" class="form-control" value="<?php echo $row["user_email_address"]; ?>" />
						    </div>
						</div>  
						<div class="col-md-6">  
						    <div class="form-group">
						        <label>Enter Mobile Number</label>
						        <input type="text" name="user_mobile_no" id="user_mobile_no" class="form-control" value="<?php echo $row["user_mobile_no"]; ?>" />
						    </div>
						</div>    
					</div>
    				<div class="row">
        				<div class="col-md-12">
						    <div class="form-group">
						        <label>Change password</label>
						        <input type="text" name="user_password" id="user_password" class="form-control" value="" placeholder="******"/>
						    </div>
						</div>  
					</div>
    				<div class="row">
        				<div class="col-md-6">
						    <div class="form-group">
						        <label>National ID</label>
						        <input type="text" name="national_id" id="national_id" class="form-control" value="<?php echo $row["user_national_type"]; ?>" />
						    </div>
						</div>  
						<div class="col-md-6">  
						    <div class="form-group">
						        <label>National ID Number</label>
						        <input type="text" name="national_id_no" id="national_id_no" class="form-control" value="<?php echo $row["user_national_no"]; ?>" />
						    </div>
						</div>    
					</div>						
    				<div class="row">
        				<div class="col-md-12">
						    <div class="form-group">
						        <label>Enter Address</label>
						        <textarea name="user_address" id="user_address" class="form-control"><?php echo $row["user_address"]; ?></textarea>
						    </div>
						</div>    
					</div>
    				<div class="row">
        				<div class="col-md-12">
						    <div class="form-group">
						        <label>Select Profile Image - </label>
						        <input type="file" name="user_image" id="user_image" accept="image/*" /><br />
						        <img src="../upload/<?php echo $row["user_image"]; ?>" class="img-thumbnail" width="250"  />
						        <input type="hidden" name="hidden_user_image" value="<?php echo $row["user_image"]; ?>" />
						    </div>
						</div>
					</div>				
    				<div class="row">
        				<div class="col-md-6">
						    <div class="form-group">
						        <label>Select Gender</label>
						        <select name="user_gender" id="user_gender" class="form-control">
						          	<option value="Male">Male</option>
						          	<option value="Female">Female</option>
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
				    <br />
				    <div class="form-group" align="center">
				        <input type="hidden" name="page" value="user" />
				        <input type="hidden" name="action" value="edit_user" />
				        <input type="hidden" name="hidden_up" value="<?php echo $row["user_password"]; ?>" />
				        <input type="hidden" name="hidden_uid" value="<?php echo $row["user_id"]; ?>" />
				        <input type="submit" name="user_profile" id="user_profile" class="btn btn-info" value="Update" />
				    </div>
				    <?php } ?>
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
	$('#profile_form').parsley();
	$('#profile_form').on('submit', function(event){
		event.preventDefault();
		$('#user_name').attr('required', 'required');
		$('#user_name').attr('data-parsley-pattern', '^[a-zA-Z ]+$');
		$('#user_address').attr('required', 'required');
		$('#user_mobile_no').attr('required', 'required');
		$('#user_mobile_no').attr('data-parsley-pattern', '^[0-9]+$');
		$('#user_image').attr('accept', 'image/*');
		if($('#profile_form').parsley().validate()){
			$.ajax({
				url:"ajax_action.php",
				method:"POST",
				data: new FormData(this),
				dataType:"json",
				contentType: false,
				cache: false,
				processData:false,				
				beforeSend:function(){
					$('#user_profile').attr('disabled', 'disabled');
					$('#user_profile').val('please wait...');
				},
				success:function(data){
					if(data.success){
						location.reload(true);
					}else{
						$('#message').html('<div class="alert alert-danger">'+data.error+'</div>');
					}
					$('#user_profile').attr('disabled', false);
					$('#user_profile').val('Updated');
				}
			});
		}
	});
});
</script>