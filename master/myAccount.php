<?php
include('header.php');
$exam->query = "SELECT * FROM `admin_table` WHERE admin_id = '".$_SESSION['admin_id']."'";
$result = $exam->query_result();
?>
<div class="containter" style="margin-top:15px;">
	<div class="d-flex justify-content-center">
		<span id="message"></span>
		<div class="card" style="margin-bottom: 100px;">
    		<div class="card-header"><h5>My Account</h5></div>
    		<div class="card-body">
    			<form method="post" id="admin_profile">


    				<?php foreach($result as $row) { ?>

    				<div class="row">
        				<div class="col-md-12">
						    <div class="form-group">
						        <label>Enter Email</label>
						        <input type="text" name="admin_email_address" id="admin_email_address" class="form-control" value="<?php echo $row["admin_email_address"]; ?>" />
						    </div>
						</div>    
					</div>

    				<div class="row">
        				<div class="col-md-12">
						    <div class="form-group">
						        <label>Change password</label>
						        <input type="text" name="admin_password" id="admin_password" class="form-control" value="" placeholder="******"/>
						    </div>
						</div>  
					</div>

    				<div class="row">
        				<div class="col-md-6">
	 					    <div class="form-group">
						        <label>Timing Per Question</label>
						        <input type="text" name="mcq_timing" id="mcq_timing" class="form-control" value="<?php echo $row["mcq_timing"]; ?>" />
						    </div>       					
        				</div>
        				<div class="col-md-6">
						    <div class="form-group">
						        <label>Per Subject Limit</label>
						        <input type="text" name="mcq_per_subject_limit" id="mcq_per_subject_limit" class="form-control" value="<?php echo $row["mcq_per_subject_limit"]; ?>" />
						    </div>
						</div>         				
    				</div>

    				<div class="row">
         				<div class="col-md-12">
	 					    <div class="form-group">
						        <label>MCQ Max Attempt</label>
						        <input type="text" name="mcq_max_question" id="mcq_max_question" class="form-control" value="<?php echo $row["mcq_max_question"]; ?>" />
						    </div>       					
        				</div>	
						<!-- <div class="col-md-6">  
						    <div class="form-group">
						        <label>Per User Limit</label>
						        <input type="text" name="mcq_user_limit" id="mcq_user_limit" class="form-control" value="<?php echo $row["mcq_user_limit"]; ?>" />
						    </div>
						</div> -->    
					</div>	

				    <br />

				    <div class="form-group" align="center">
				        <input type="hidden" name="page" value="admin" />
				        <input type="hidden" name="action" value="edit_admin" />
				        <input type="hidden" name="hidden_up" value="<?php echo $row["admin_password"]; ?>" />
				        <input type="hidden" name="hidden_uid" value="<?php echo $row["admin_id"]; ?>" />
				        <input type="submit" name="admin_profile_btn" id="admin_profile_btn" class="btn btn-info" value="Update" />
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
	$('#admin_profile').parsley();

	$('#admin_profile').on('submit', function(event){
		event.preventDefault();

		$('#admin_email_address').attr('required', 'required');
		$('#mcq_timing').attr('required', 'required');
		// $('#mcq_timing').attr('data-parsley-pattern', '^[a-zA-Z ]+$');
		$('#mcq_max_question').attr('required', 'required');
		$('#mcq_per_subject_limit').attr('required', 'required');

		if($('#admin_profile').parsley().validate()){
			$.ajax({
				url:"ajax_action.php",
				method:"POST",
				data: new FormData(this),
				dataType:"json",
				contentType: false,
				cache: false,
				processData:false,				
				beforeSend:function(){
					$('#admin_profile_btn').attr('disabled', 'disabled');
					$('#admin_profile_btn').val('please wait...');
				},
				success:function(data){
					if(data.success){
						location.reload(true);
					}else{
						$('#message').html('<div class="alert alert-danger">'+data.error+'</div>');
					}
					$('#admin_profile_btn').attr('disabled', false);
					$('#admin_profile_btn').val('Updated');
				}
			});
		}
	});
});
</script>