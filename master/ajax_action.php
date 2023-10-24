<?php
//ajax_action.php
include('Examination.php'); 
require_once('../class/class.phpmailer.php');
$exam = new Examination;
$current_datetime = date("Y-m-d") . ' ' . date("H:i:s", STRTOTIME(date('h:i:sa')));

if(isset($_POST['page'])){


	if($_POST['page'] == 'admin'){
		if($_POST['action'] == 'edit_admin'){
			$admin_password = $_POST['hidden_up'];
			if($_POST['admin_password'] != ''){
				$admin_password = password_hash($_POST['admin_password'], PASSWORD_DEFAULT);
			}
			$exam->data = array(
				':admin_email_address'		=>	$_POST['admin_email_address'], 
				':admin_password'			=>	$admin_password,
				':mcq_timing'				=>	$_POST['mcq_timing'],
				':mcq_max_question'			=>	$_POST['mcq_max_question'],
				':mcq_per_subject_limit'	=>	$_POST['mcq_per_subject_limit'],
				':admin_id'					=>  $_SESSION['admin_id']
			);
			$exam->query = "UPDATE admin_table SET 
				admin_email_address = :admin_email_address, 
				admin_password = :admin_password, 
				mcq_timing = :mcq_timing, 
				mcq_max_question = :mcq_max_question, 
				mcq_per_subject_limit = :mcq_per_subject_limit
				WHERE admin_id = :admin_id";
			$exam->execute_query();
			$output = array(
				'success'		=>	true
			);
			echo json_encode($output);			
		}
	}


	if($_POST['page'] == 'login'){
		if($_POST['action'] == 'login'){
			$exam->data = array(
				':admin_email_address'	=>	$_POST['admin_email_address']
			);

			$exam->query = "
			SELECT * FROM admin_table 
			WHERE admin_email_address = :admin_email_address
			";

			$total_row = $exam->total_row();

			if($total_row > 0){
				$result = $exam->query_result();

				foreach($result as $row)
				{
					if($row['email_verified'] == 'yes')
					{
						if(password_verify($_POST['admin_password'], $row['admin_password']))
						{
							$_SESSION['admin_id'] = $row['admin_id'];
							$output = array(
								'success'	=>	true
							);
						}
						else
						{
							$output = array(
								'error'	=>	'Wrong Password'
							);
						}
					}
					else
					{
						$output = array(
							'error'		=>	'Your Email is not verify'
						);
					}
				}
			}else{
				$output = array(
					'error'		=>	'Wrong Email Address'
				);
			}

			echo json_encode($output);
		}
	}

	if($_POST['page'] == 'user'){
		if($_POST['action'] == 'fetch'){
			$output = array();
			$data = array();			
			$extra_query = '';
			$exam->query = 'SELECT * FROM `user_table` WHERE ';
			if(isset($_POST["search"]["value"])){
			 	$exam->query .= 'user_email_address LIKE "%'.$_POST["search"]["value"].'%" ';
			 	$exam->query .= 'OR user_name LIKE "%'.$_POST["search"]["value"].'%" ';
			 	$exam->query .= 'OR user_gender LIKE "%'.$_POST["search"]["value"].'%" ';
			 	$exam->query .= 'OR user_mobile_no LIKE "%'.$_POST["search"]["value"].'%" ';
			}
			if(isset($_POST["order"])){
				$exam->query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
			}else{
				$exam->query .= 'ORDER BY `user_id` DESC ';
			}
			if(@$_POST["length"] != -1){
			 	$extra_query .= 'LIMIT ' . @$_POST['start'] . ', ' . @$_POST['length'];
			}
			$filterd_rows = $exam->total_row();
			$exam->query .= $extra_query;
			$result = $exam->query_result();
			$exam->query = "SELECT * FROM `user_table`";
			$total_rows = $exam->total_row();
			foreach($result as $row){
				$sub_array = array();
				$sub_array[] = '<img src="../upload/'.$row["user_image"].'" class="img-thumbnail" width="75" />';
				$sub_array[] = $row["user_name"];
				$sub_array[] = $row["batch_code"];
				$sub_array[] = $row["user_mobile_no"];
				$sub_array[] = $row["user_email_address"];
				$sub_array[] = $row["mcq_attempt_counter"];
				if($row["user_status"] == 'active'){
					$is_email_verified = '<label class="badge badge-success">Active</label>';
				}else{
					$is_email_verified = '<label class="badge badge-danger">De-active</label>';
				}			
				$sub_array[] = $is_email_verified;
				$sub_array[] = "<a href='javascript:;' class='details' id='".$row["user_id"]."''>View</a> &nbsp;&nbsp; <a href='edit_user.php?sid=".$row["user_id"]."'>Edit</a>";	
				$data[] = $sub_array;
			}
			$output = array(
			 	"draw"    			=> 	intval(@$_POST["draw"]),
			 	"recordsTotal"  	=>  intval($total_rows),
			 	"recordsFiltered" 	=> 	intval($filterd_rows),
			 	"data"    			=> 	$data
			);
			echo json_encode($output);	
		}

		if($_POST['action'] == 'fetch_data'){
			$exam->query = "SELECT * FROM user_table WHERE user_id = '".$_POST["user_id"]."'";
			$result = $exam->query_result();
			$output = '';
			foreach($result as $row){


				$is_email_verified = '';
				if($row["user_email_verified"] == 'yes'){
					$is_email_verified = '<label class="badge badge-success">Email Verified</label>';
				}else{
					$is_email_verified = '<label class="badge badge-danger">Email Not Verified</label>';	
				}


				$output .= '
				<div class="row">
					<div class="col-md-12">
						<div align="center">
							<img src="../upload/'.$row["user_image"].'" class="img-thumbnail" width="200" />
						</div>
						<br />
						<table class="table table-bordered">
							<tr>
								<th>Name</th>
								<td>'.$row["user_name"].'</td>
							</tr>
							<tr>
								<th>Batch Code</th>
								<td>'.$row["batch_code"].'</td>
							</tr>							
							<tr>
								<th>National ID</th>
								<td>'.$row["user_national_type"].' ('.$row["user_national_no"].')</td>
							</tr>							
							<tr>
								<th>Gender</th>
								<td>'.$row["user_gender"].'</td>
							</tr>
							<tr>
								<th>Address</th>
								<td>'.$row["user_address"].'</td>
							</tr>
							<tr>
								<th>Mobile No.</th>
								<td>'.$row["user_mobile_no"].'</td>
							</tr>
							<tr>
								<th>Email</th>
								<td>'.$row["user_email_address"].'</td>
							</tr>							
						</table>
					</div>
				</div>
				';
			}	
			echo $output;			
		}	

		if($_POST['action'] == 'edit_user'){
			$user_image = $_POST['hidden_user_image'];
			if($_FILES['user_image']['name'] != ''){
				$exam->filedata = $_FILES['user_image'];
				$user_image = $exam->Upload_file();
			}
			$user_password = $_POST['hidden_up'];
			if($_POST['user_password'] != ''){
				$user_password = password_hash($_POST['user_password'], PASSWORD_DEFAULT);
			}

			$exam->data = array(
				':user_name'				=>	$exam->clean_data($_POST['user_name']), 
				':mcq_attempt_counter'		=>	$_POST['mcq_attempt_counter'],
				':user_email'				=>	$_POST['user_email'],
				':user_password'			=>	$user_password,
				':user_mobile_no'			=>	$_POST['user_mobile_no'],
				':national_id'				=>	$_POST['national_id'],
				':national_id_no'			=>	$_POST['national_id_no'],
				':user_address'				=>	$exam->clean_data($_POST['user_address']),
				':user_gender'				=>	$_POST['user_gender'],
				':user_status'				=>	$_POST['user_status'],
				':user_image'				=>	$user_image,
				':user_id'					=>	$_POST['hidden_uid']		
			);

			$exam->query = "UPDATE user_table SET 
				user_name = :user_name, 
				mcq_attempt_counter = :mcq_attempt_counter, 
				user_email_address = :user_email, 
				user_password = :user_password, 
				user_mobile_no = :user_mobile_no, 
				user_national_type = :national_id, 
				user_national_no = :national_id_no, 
				user_address = :user_address, 
				user_gender = :user_gender, 
				user_status = :user_status, 
				user_image = :user_image 

				WHERE user_id = :user_id";
			$exam->execute_query();

			$output = array(
				'success'		=>	true
			);

			echo json_encode($output);			
		}

		if($_POST['action'] == 'is_valid'){
			$exam->query = "SELECT * FROM `user_table` WHERE `user_email_address` = '".trim($_POST["email"])."'";
			$total_row = $exam->total_row();
			if($total_row == 0){
				$output = array(
					'success'		=>	true
				);
				echo json_encode($_POST["email"]);
			}
		}

		if($_POST['action'] == 'register'){
			$user_name = $_POST['user_name'];
			$user_email_address = $_POST['user_email_address'];
			$user_password = $_POST['user_password'];
			$national_id_type = $_POST['national_id_type'];
			$national_id_no = $_POST['national_id_no'];
			$user_mobile_no = $_POST['user_mobile_no'];
			$user_gender = $_POST['user_gender'];
			$user_address = $_POST['user_address'];
			$user_status = $_POST['user_status'];
			$batch = explode('-', $_POST['user_batch']);
			$user_batch_id = $batch[0];
			$user_batch_code = $batch[1];
			$exam->filedata = $_FILES['user_image'];
			$user_image = $exam->Upload_file();
			$exam->data = array(
				':user_email_address'	=>	$user_email_address,
				':user_password'		=>	password_hash($user_password, PASSWORD_DEFAULT),
				':user_name'			=>	$user_name,
				':national_id_type'		=>	$national_id_type,
				':national_id_no'		=>	$national_id_no,
				':user_status'			=>	$user_status,
				':batch_id'				=>	$user_batch_id,
				':batch_code'			=>	$user_batch_code,
				':user_gender'			=>	$user_gender,
				':user_address'			=>	$user_address,
				':user_mobile_no'		=>	$user_mobile_no,
				':user_image'			=>	$user_image,
				':user_created_on'		=>	$current_datetime
			);

			$exam->query = "INSERT INTO `user_table` 
			(user_email_address, user_password, batch_id, batch_code, user_national_type, user_national_no, user_name, user_gender, user_address, user_mobile_no, user_image, user_created_on, user_status)
			VALUES 
			(:user_email_address, :user_password, :batch_id, :batch_code, :national_id_type, :national_id_no,  :user_name, :user_gender, :user_address, :user_mobile_no, :user_image, :user_created_on, :user_status)";
			$exam->execute_query();
			// $subject= 'Online Examination Registration Verification';
			// $body = '
			// <p>Thank you for registering.</p>
			// <p>This is a verification eMail, please click the link to verify your eMail address by clicking this <a href="'.$exam->home_page.'verify_email.php?type=user&code='.$user_verfication_code.'" target="_blank"><b>link</b></a>.</p>
			// <p>In case if you have any difficulty please eMail us.</p>
			// <p>Thank you,</p>
			// <p>Online Examination System</p>
			// ';
			// $exam->send_email($receiver_email, $subject, $body);
			$output = array(
				'success'		=>	true
			);
			echo json_encode($output);
		}
	}

	if($_POST['page'] == 'subList'){
		if($_POST['action'] == 'fetch_subject'){
			$output = array();
			$exam->query ="SELECT * FROM `subject` WHERE ";
			if(isset($_POST["search"]["value"])){
			 	$exam->query .= 'subject_name LIKE "%'.$_POST["search"]["value"].'%" ';
			}
			if(isset($_POST["order"])){
				$exam->query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
			}else{
				$exam->query .= 'ORDER BY `subject_id` DESC ';
			}
			$extra_query = '';
			if($_POST["length"] != -1){
			 	$extra_query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
			}
			$filterd_rows = $exam->total_row();
			$exam->query .= $extra_query;
			$result = $exam->query_result();
			$total_rows = $exam->total_row();
			$data = array();
			$i = 1;
			foreach($result as $row){
				$sub_array = array();
				$sub_array[] = html_entity_decode($i);					
				$sub_array[] = html_entity_decode($row["subject_name"]);
				$sub_array[] = html_entity_decode($row["subject_code"]);
				$sub_array[] = "<a href='javascript:;' class='fetch_subject_edit' id='".$row["subject_id"]."''>Edit</a>  &nbsp;  <a href='javascript:;' class='delete_subject' id='".$row["subject_id"]."''>Delete</a>";
				$data[] = $sub_array;
				$i++;
			}
			$output = array(
			 	"draw"    			=> 	intval($_POST["draw"]),
			 	"recordsTotal"  	=>  $total_rows,
			 	"recordsFiltered" 	=> 	$filterd_rows,
			 	"data"    			=> 	$data
			);
			echo json_encode($output);
		}

		if($_POST['action'] == 'edit_subject_fetch'){
			$exam->query = "SELECT * FROM `subject` WHERE subject_id = '".$_POST["subject_id"]."'";
			$result = $exam->query_result();
			foreach($result as $row){
				$output['subject_id'] = $row["subject_id"];
				$output['subject_name'] = html_entity_decode($row["subject_name"]);
				$output['subject_code'] = html_entity_decode($row["subject_code"]);
			}	
			echo json_encode($output);	
		}

		if($_POST['action'] == 'add_subject'){
			$exam->data = array(
				':subject_name'		=>	$exam->clean_data($_POST['subject_name']),
				':subject_code'		=>	$exam->clean_data($_POST['subject_code'])
			);
			$exam->query = "INSERT INTO `subject` (subject_name, subject_code) VALUES (:subject_name, :subject_code)";
			$exam->execute_query($exam->data);
			$output = array(
				'success'		=>	'Subject Added'
			);
			echo json_encode($output);
		}	

		if($_POST['action'] == 'edit_subject'){
			$exam->data = array(
				':subject_name'		=>	$exam->clean_data($_POST['subject_name']),
				':subject_code'		=>	$exam->clean_data($_POST['subject_code']),
				':subject_id'		=>	$_POST['subject_id']
			);
			$exam->query = "UPDATE `subject` SET subject_name = :subject_name, subject_code = :subject_code WHERE subject_id = :subject_id";
			$exam->execute_query($exam->data);
			$output = array(
				'success'		=>	'Subject Updated'
			);
			echo json_encode($output);
		}	
		if($_POST['action'] == 'delete_subject'){
			$exam->data = array(
				':subject_id'		=>	$_POST['subject_id']
			);
			$exam->query = "DELETE FROM `subject` WHERE subject_id = :subject_id";

			$exam->execute_query($exam->data);
			$output = array(
				'success'		=>	'Subject Deleted'
			);
			echo json_encode($output);
		}
	}

	if($_POST['page'] == 'batchList'){
		if($_POST['action'] == 'fetch_batch'){
			$output = array();
			$exam->query ="SELECT * FROM `batch` WHERE ";
			if(isset($_POST["search"]["value"])){
			 	$exam->query .= 'batch_name LIKE "%'.$_POST["search"]["value"].'%" ';
			}
			if(isset($_POST["order"])){
				$exam->query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
			}else{
				$exam->query .= 'ORDER BY `batch_id` DESC ';
			}
			$extra_query = '';
			if($_POST["length"] != -1){
			 	$extra_query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
			}
			$filterd_rows = $exam->total_row();
			$exam->query .= $extra_query;
			$result = $exam->query_result();
			$total_rows = $exam->total_row();
			$data = array();
			$i = 1;
			foreach($result as $row){
				$sub_array = array();
				$sub_array[] = html_entity_decode($i);					
				$sub_array[] = html_entity_decode($row["batch_name"]);
				$sub_array[] = html_entity_decode($row["batch_code"]);
				$sub_array[] = "<a href='javascript:;' class='fetch_batch_edit' id='".$row["batch_id"]."''>Edit</a>  &nbsp;  <a href='javascript:;' class='delete_batch' id='".$row["batch_id"]."''>Delete</a>";
				$data[] = $sub_array;
				$i++;
			}
			$output = array(
			 	"draw"    			=> 	intval($_POST["draw"]),
			 	"recordsTotal"  	=>  $total_rows,
			 	"recordsFiltered" 	=> 	$filterd_rows,
			 	"data"    			=> 	$data
			);
			echo json_encode($output);
		}

		if($_POST['action'] == 'edit_batch_fetch'){
			$exam->query = "SELECT * FROM `batch` WHERE batch_id = '".$_POST["batch_id"]."'";
			$result = $exam->query_result();
			foreach($result as $row){
				$output['batch_id'] = $row["batch_id"];
				$output['batch_name'] = html_entity_decode($row["batch_name"]);
				$output['batch_code'] = html_entity_decode($row["batch_code"]);
			}	
			echo json_encode($output);	
		}

		if($_POST['action'] == 'add_batch'){
			$exam->data = array(
				':batch_name'		=>	$exam->clean_data($_POST['batch_name']),
				':batch_code'		=>	$exam->clean_data($_POST['batch_code'])
			);
			$exam->query = "INSERT INTO `batch` (batch_name, batch_code) VALUES (:batch_name, :batch_code)";
			$exam->execute_query($exam->data);
			$output = array(
				'success'		=>	'Batch Added'
			);
			echo json_encode($output);
		}	

		if($_POST['action'] == 'edit_batch'){
			$exam->data = array(
				':batch_name'		=>	$exam->clean_data($_POST['batch_name']),
				':batch_code'		=>	$exam->clean_data($_POST['batch_code']),
				':batch_id'		=>	$_POST['batch_id']
			);
			$exam->query = "UPDATE `batch` SET batch_name = :batch_name, batch_code = :batch_code WHERE batch_id = :batch_id";
			$exam->execute_query($exam->data);
			$output = array(
				'success'		=>	'Batch Updated'
			);
			echo json_encode($output);
		}	
		if($_POST['action'] == 'delete_batch'){
			$exam->data = array(
				':batch_id'		=>	$_POST['batch_id']
			);
			$exam->query = "DELETE FROM `batch` WHERE batch_id = :batch_id";

			$exam->execute_query($exam->data);
			$output = array(
				'success'		=>	'Batch Deleted'
			);
			echo json_encode($output);
		}
	}

	if($_POST['page'] == 'moduleList'){
		if($_POST['action'] == 'fetch_module'){
			$output = array();
			$exam->query ="SELECT * FROM `module` INNER JOIN `subject` ON `subject`.`subject_id` = `module`.`subject_id` WHERE ";
			if(isset($_POST["search"]["value"])){
			 	$exam->query .= '`module`.`module_name` LIKE "%'.$_POST["search"]["value"].'%" ';
			}
			if(isset($_POST["order"])){
				$exam->query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
			}else{
				$exam->query .= 'ORDER BY `module`.`module_id` DESC ';
			}
			$extra_query = '';
			if($_POST["length"] != -1){
			 	$extra_query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
			}
			$filterd_rows = $exam->total_row();
			$exam->query .= $extra_query;
			$result = $exam->query_result();
			$total_rows = $exam->total_row();
			$data = array();
			$i = 1;
			foreach($result as $row){
				$sub_array = array();
				$sub_array[] = html_entity_decode($i);					
				$sub_array[] = html_entity_decode($row["subject_name"]);
				$sub_array[] = html_entity_decode($row["module_name"]);
				$sub_array[] = $row["module_serial_number"];
				$sub_array[] = "<a href='javascript:;' class='fetch_module_edit' id='".$row["module_id"]."''>Edit</a>  &nbsp;  <a href='javascript:;' class='delete_module' id='".$row["module_id"]."''>Delete</a>";
				$data[] = $sub_array;
				$i++;
			}
			$output = array(
			 	"draw"    			=> 	intval($_POST["draw"]),
			 	"recordsTotal"  	=>  $total_rows,
			 	"recordsFiltered" 	=> 	$filterd_rows,
			 	"data"    			=> 	$data
			);
			echo json_encode($output);
		}

		if($_POST['action'] == 'edit_module_fetch'){
			$exam->query = "SELECT * FROM `module` WHERE module_id = '".$_POST["module_id"]."'";
			$result = $exam->query_result();
			foreach($result as $row){
				$output['module_id'] = $row["module_id"];
				$output['subject_id'] = $row["subject_id"];
				$output['module_name'] = html_entity_decode($row["module_name"]);
				$output['module_serial_number'] = html_entity_decode($row["module_serial_number"]);
			}	
			echo json_encode($output);	
		}

		if($_POST['action'] == 'add_module'){
			$exam->data = array(
				':subject_id'				=>	$_POST['subject_id'],
				':module_name'				=>	$exam->clean_data($_POST['module_name']),
				':module_serial_number'		=>	$exam->clean_data($_POST['module_serial_number'])
			);
			$exam->query = "INSERT INTO `module` (subject_id, module_name, module_serial_number) VALUES (:subject_id, :module_name, :module_serial_number)";
			$exam->execute_query($exam->data);
			$output = array(
				'success'		=>	'Module Added'
			);
			echo json_encode($output);
		}	

		if($_POST['action'] == 'edit_module'){
			$exam->data = array(
				':subject_id'				=>	$_POST['subject_id'],				
				':module_name'				=>	$exam->clean_data($_POST['module_name']),
				':module_serial_number'		=>	$exam->clean_data($_POST['module_serial_number']),
				':module_id'				=>	$_POST['module_id']
			);
			$exam->query = "UPDATE `module` SET subject_id = :subject_id, module_name = :module_name, module_serial_number = :module_serial_number WHERE module_id = :module_id";
			$exam->execute_query($exam->data);
			$output = array(
				'success'		=>	'Module Updated'
			);
			echo json_encode($output);
		}	
		if($_POST['action'] == 'delete_module'){
			$exam->data = array(
				':module_id'		=>	$_POST['module_id']
			);
			$exam->query = "DELETE FROM `module` WHERE module_id = :module_id";
			$exam->execute_query($exam->data);
			$output = array(
				'success'		=>	'Module Deleted'
			);
			echo json_encode($output);
		}
	}

	if($_POST['page'] == 'chapterList'){
		if($_POST['action'] == 'fetch_chapter'){
			$output = array();
			$exam->query ="SELECT * FROM `chapter` INNER JOIN `subject` ON `subject`.`subject_id` = `chapter`.`subject_id` WHERE ";
			if(isset($_POST["search"]["value"])){
			 	$exam->query .= '`chapter`.`chapter_name` LIKE "%'.$_POST["search"]["value"].'%" ';
			}
			if(isset($_POST["order"])){
				$exam->query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
			}else{
				$exam->query .= 'ORDER BY `chapter`.`chapter_id` DESC ';
			}
			$extra_query = '';
			if($_POST["length"] != -1){
			 	$extra_query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
			}
			$filterd_rows = $exam->total_row();
			$exam->query .= $extra_query;
			$result = $exam->query_result();
			$total_rows = $exam->total_row();
			$data = array();
			$i = 1;
			foreach($result as $row){
				$sub_array = array();
				$sub_array[] = html_entity_decode($i);					
				$sub_array[] = html_entity_decode($row["subject_name"]);
				$sub_array[] = html_entity_decode($row["chapter_id"]);
				$sub_array[] = html_entity_decode($row["chapter_name"]);
				$sub_array[] = $row["chapter_number"];
				$sub_array[] = "<a href='javascript:;' class='fetch_chapter_edit' id='".$row["chapter_id"]."''>Edit</a>  &nbsp;  <a href='javascript:;' class='delete_chapter' id='".$row["chapter_id"]."''>Delete</a>";
				$data[] = $sub_array;
				$i++;
			}
			$output = array(
			 	"draw"    			=> 	intval($_POST["draw"]),
			 	"recordsTotal"  	=>  $total_rows,
			 	"recordsFiltered" 	=> 	$filterd_rows,
			 	"data"    			=> 	$data
			);
			echo json_encode($output);
		}

		if($_POST['action'] == 'edit_chapter_fetch'){
			$exam->query = "SELECT * FROM `chapter` WHERE chapter_id = '".$_POST["chapter_id"]."'";
			$result = $exam->query_result();
			foreach($result as $row){
				$output['chapter_id'] = $row["chapter_id"];
				$output['subject_id'] = $row["subject_id"];
				$output['module_id']  = $row["module_id"];
				$output['chapter_name'] = html_entity_decode($row["chapter_name"]);
				$output['chapter_number'] = html_entity_decode($row["chapter_number"]);
			}	
			echo json_encode($output);	
		}

		if($_POST['action'] == 'add_chapter'){
			$exam->data = array(
				':subject_id'				=>	$_POST['subject_id'],
				':module_id'				=>	$_POST['module_id'],
				':chapter_name'				=>	$exam->clean_data($_POST['chapter_name']),
				':chapter_number'			=>	$_POST['chapter_number']
			);
			$exam->query = "INSERT INTO `chapter` (subject_id, module_id, chapter_name, chapter_number) VALUES (:subject_id, :module_id, :chapter_name, :chapter_number)";
			$exam->execute_query($exam->data);
			$output = array(
				'success'		=>	'Chapter Added'
			);
			echo json_encode($output);
		}	

		if($_POST['action'] == 'edit_chapter'){
			$exam->data = array(
				':subject_id'				=>	$_POST['subject_id'],				
				':module_id'				=>	$_POST['module_id'],				
				':chapter_name'				=>	$exam->clean_data($_POST['chapter_name']),
				':chapter_number'		=>	$exam->clean_data($_POST['chapter_number']),
				':chapter_id'				=>	$_POST['chapter_id']
			);
			$exam->query = "UPDATE `chapter` SET subject_id = :subject_id, module_id = :module_id, chapter_name = :chapter_name, chapter_number = :chapter_number WHERE chapter_id = :chapter_id";
			$exam->execute_query($exam->data);
			$output = array(
				'success'		=>	'Chapter Updated'
			);
			echo json_encode($output);
		}	

		if($_POST['action'] == 'delete_chapter'){
			$exam->data = array(
				':chapter_id'		=>	$_POST['chapter_id']
			);
			$exam->query = "DELETE FROM `chapter` WHERE chapter_id = :chapter_id";
			$exam->execute_query($exam->data);
			$output = array(
				'success'		=>	'Chapter Deleted'
			);
			echo json_encode($output);
		}

		if($_POST['action'] == 'get_module'){
			$subject_id = $_POST['subject_id'];
			$output = "";
			$output .=  '<label class="col-md-4 text-right">Select Module<span class="text-danger">*</span></label>
              <div class="col-md-8">
                <select name="module_id" id="module_id" class="form-control">
                  <option value="">Select Module</option>';
                  foreach ($exam->get_module_list($subject_id) as $row) { if($_POST['selected'] == $row["module_id"]){ $selected = "selected";}else{$selected = "";}
                   $output .= '<option value="'.$row["module_id"].'" '.$selected.'>'.$row["module_name"].' </option>';
                  }
            $output .=  '</select></div>';
			echo $output;	
		}		
	}








	if($_POST['page'] == 'questionnaireList'){


		if($_POST['action'] == 'fetch_questionnaire'){
			$output = array();
			$exam->query ="SELECT * FROM `questionnaire` INNER JOIN `subject` ON `subject`.`subject_id` = `questionnaire`.`subject_id` WHERE ";
			if(isset($_POST["search"]["value"])){
			 	$exam->query .= '`questionnaire`.`questionnaire_text` LIKE "%'.$_POST["search"]["value"].'%" ';
			 	$exam->query .= 'OR `questionnaire`.`chapter_id` LIKE "%'.$_POST["search"]["value"].'%" ';
			 	$exam->query .= 'OR `subject`.`subject_name` LIKE "%'.$_POST["search"]["value"].'%" ';
			}
			if(isset($_POST["order"])){
				$exam->query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
			}else{
				$exam->query .= 'ORDER BY `questionnaire`.`questionnaire_id` DESC ';
			}
			$extra_query = '';
			if($_POST["length"] != -1){
			 	$extra_query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
			}
			$filterd_rows = $exam->total_row();
			$exam->query .= $extra_query;
			$result = $exam->query_result();
			$total_rows = $exam->total_row();
			$data = array();
			$i = 1;
			foreach($result as $row){
				$sub_array = array();
				$sub_array[] = html_entity_decode($i);					
				$sub_array[] = html_entity_decode($row["subject_name"]);
				$sub_array[] = $row["chapter_id"];				
				$sub_array[] = html_entity_decode($row["questionnaire_text"]);
				$sub_array[] = $row["correct_option"];
				$sub_array[] = "<a href='javascript:;' class='fetch_questionnaire_edit' id='".$row["questionnaire_id"]."''>Edit</a>  &nbsp;  <a href='javascript:;' class='delete_questionnaire' id='".$row["questionnaire_id"]."''>Delete</a>";
				$data[] = $sub_array;
				$i++;
			}
			$output = array(
			 	"draw"    			=> 	intval($_POST["draw"]),
			 	"recordsTotal"  	=>  $total_rows,
			 	"recordsFiltered" 	=> 	$filterd_rows,
			 	"data"    			=> 	$data
			);
			echo json_encode($output);
		}

		if($_POST['action'] == 'edit_questionnaire_fetch'){
			$exam->query = "SELECT * FROM `questionnaire` WHERE questionnaire_id = '".$_POST["questionnaire_id"]."'";
			$result = $exam->query_result();
			foreach($result as $row){
				$output['questionnaire_id'] 	= $row["questionnaire_id"];
				$output['chapter_id'] 			= $row["chapter_id"];
				$output['subject_id'] 			= $row["subject_id"];
				$output['questionnaire_text'] 	= html_entity_decode($row["questionnaire_text"]);
				$output['point_1'] 		= html_entity_decode($row["point_1"]);
				$output['point_2'] 		= html_entity_decode($row["point_2"]);
				$output['point_3'] 		= html_entity_decode($row["point_3"]);
				$output['point_4'] 		= html_entity_decode($row["point_4"]);
				$output['option_a'] 		= html_entity_decode($row["option_a"]);
				$output['option_b'] 		= html_entity_decode($row["option_b"]);
				$output['option_c'] 		= html_entity_decode($row["option_c"]);
				$output['option_d'] 		= html_entity_decode($row["option_d"]);
				$output['correct_option'] 		= html_entity_decode($row["correct_option"]);
			}	
			echo json_encode($output);	
		}

		if($_POST['action'] == 'add_questionnaire'){
			$exam->data = array(
				':subject_id'				=>	$_POST['subject_id'],
				':module_id'				=>	$_POST['module_id'],
				':chapter_name'				=>	$exam->clean_data($_POST['chapter_name']),
				':chapter_number'			=>	$_POST['chapter_number']
			);
			$exam->query = "INSERT INTO `chapter` (subject_id, module_id, chapter_name, chapter_number) VALUES (:subject_id, :module_id, :chapter_name, :chapter_number)";
			$exam->execute_query($exam->data);
			$output = array(
				'success'		=>	'Chapter Added'
			);
			echo json_encode($output);
		}	

		if($_POST['action'] == 'edit_questionnaire'){
			$exam->data = array(
				':subject_id'				=>	$_POST['subject_id'],				
				':module_id'				=>	$_POST['module_id'],				
				':chapter_name'				=>	$exam->clean_data($_POST['chapter_name']),
				':chapter_number'		=>	$exam->clean_data($_POST['chapter_number']),
				':chapter_id'				=>	$_POST['chapter_id']
			);
			$exam->query = "UPDATE `chapter` SET subject_id = :subject_id, module_id = :module_id, chapter_name = :chapter_name, chapter_number = :chapter_number WHERE chapter_id = :chapter_id";
			$exam->execute_query($exam->data);
			$output = array(
				'success'		=>	'Chapter Updated'
			);
			echo json_encode($output);
		}	

		if($_POST['action'] == 'delete_questionnaire'){
			$exam->data = array(
				':chapter_id'		=>	$_POST['chapter_id']
			);
			$exam->query = "DELETE FROM `chapter` WHERE chapter_id = :chapter_id";
			$exam->execute_query($exam->data);
			$output = array(
				'success'		=>	'Chapter Deleted'
			);
			echo json_encode($output);
		}

		if($_POST['action'] == 'get_chapter'){
			$subject_id = $_POST['subject_id'];
			$output = "";
			$output .=  '<label class="col-md-3 text-right">Select Chapter<span class="text-danger">*</span></label>
              <div class="col-md-9">
                <select name="chapter_id" id="chapter_id" class="form-control">
                  <option value="">Select Chapter</option>';
                  foreach ($exam->get_chapter_list($subject_id) as $row) { if($_POST['selected'] == $row["chapter_id"]){ $selected = "selected";}else{$selected = "";}
                   $output .= '<option value="'.$row["chapter_id"].'" '.$selected.'>'.$row["chapter_name"].' </option>';
                  }
            $output .=  '</select></div>';
			echo $output;	
		}		
	}

















	/*ROUGH HAS TO DELETE*/

	if($_POST['page'] == 'exam'){
		if($_POST['action'] == 'fetch'){
			$exam->query = "SELECT * FROM `online_exam_table` WHERE `admin_id` = '".$_SESSION["admin_id"]."' AND ( ";
			if(isset($_POST['search']['value'])){
				$exam->query .= 'online_exam_title LIKE "%'.$_POST["search"]["value"].'%" ';

				$exam->query .= 'OR online_exam_datetime LIKE "%'.$_POST["search"]["value"].'%" ';

				$exam->query .= 'OR online_exam_duration LIKE "%'.$_POST["search"]["value"].'%" ';

				$exam->query .= 'OR total_question LIKE "%'.$_POST["search"]["value"].'%" ';

				$exam->query .= 'OR marks_per_right_answer LIKE "%'.$_POST["search"]["value"].'%" ';

				$exam->query .= 'OR marks_per_wrong_answer LIKE "%'.$_POST["search"]["value"].'%" ';

				$exam->query .= 'OR online_exam_status LIKE "%'.$_POST["search"]["value"].'%" ';
			}

			$exam->query .= ')';
			if(isset($_POST['order'])){
				$exam->query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
			}else{
				$exam->query .= 'ORDER BY online_exam_id DESC ';
			}
			$extra_query = '';
			if($_POST['length'] != -1){
				$extra_query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
			}
			$filtered_rows = $exam->total_row();
			$exam->query .= $extra_query;
			$result = $exam->query_result();
			$exam->query = "SELECT * FROM `online_exam_table`";
			$total_rows = $exam->total_row();
			$data = array();
			foreach($result as $row){
				$sub_array = array();			
				$sub_array[] = html_entity_decode($row['online_exam_title']);
				$sub_array[] = $row['online_exam_datetime'];
				$sub_array[] = $row['online_exam_duration'] . ' Minute';
				$sub_array[] = $row['total_question'] . ' Question';
				$sub_array[] = $row['marks_per_right_answer'] . ' Mark';
				$sub_array[] = '-' . $row['marks_per_wrong_answer'] . ' Mark';
				$status = '';
				$edit_button = '';
				$delete_button = '';
				$question_button = '';
				$result_button = '';

				if($row['online_exam_status'] == 'Pending'){
					$status = '<span class="badge badge-warning">Pending</span>';
				}

				if($row['online_exam_status'] == 'Created'){
					$status = '<span class="badge badge-success">Created</span>';
				}

				if($row['online_exam_status'] == 'Started'){
					$status = '<span class="badge badge-primary">Started</span>';
				}

				if($row['online_exam_status'] == 'Completed'){
					$status = '<span class="badge badge-dark">Completed</span>';
				}

				if($exam->Is_exam_is_not_started($row["online_exam_id"])){
					$edit_button = '<button type="button" name="edit" class="btn btn-primary btn-sm edit" id="'.$row['online_exam_id'].'">Edit</button>';
					$delete_button = '<button type="button" name="delete" class="btn btn-danger btn-sm delete" id="'.$row['online_exam_id'].'">Delete</button>';
				}else{
					$result_button = '<a href="exam_result.php?code='.$row["online_exam_code"].'" class="btn btn-dark btn-sm">Result</a>';
				}

				if($exam->Is_allowed_add_question($row['online_exam_id'])){
					$question_button = '<button type="button" name="add_question" class="btn btn-info btn-sm add_question" id="'.$row['online_exam_id'].'">Add Question</button>';
				}else{
					$question_button = '<a href="question.php?code='.$row['online_exam_code'].'" class="btn btn-warning btn-sm">View Question</a>';
				}
				$sub_array[] = $status;
				$sub_array[] = $question_button;
				$sub_array[] ="";
				$sub_array[] = $result_button;
				$sub_array[] = $edit_button .' ' .$delete_button;

				$data[] = $sub_array;


			}
			$json_data = array(
				"draw"            => intval( $_POST['draw'] ),
				"recordsTotal"    => intval( $total_rows ),
				"recordsFiltered" => intval( $filtered_rows ),
				"data"            => $data
			);
			echo json_encode($json_data);
		}

		if($_POST['action'] == 'Add'){
			$exam->data = array(
				':admin_id'				=>	$_SESSION['admin_id'],
				':online_exam_title'	=>	$exam->clean_data($_POST['online_exam_title']),
				':online_exam_datetime'	=>	$_POST['online_exam_datetime'] . ':00',
				':online_exam_duration'	=>	$_POST['online_exam_duration'],
				':total_question'		=>	$_POST['total_question'],
				':marks_per_right_answer'=>	$_POST['marks_per_right_answer'],
				':marks_per_wrong_answer'=>	$_POST['marks_per_wrong_answer'],
				':online_exam_created_on'=>	$current_datetime,
				':online_exam_status'	=>	'Pending',
				':online_exam_code'		=>	md5(rand())
			);

			$exam->query = "
			INSERT INTO online_exam_table 
			(admin_id, online_exam_title, online_exam_datetime, online_exam_duration, total_question, marks_per_right_answer, marks_per_wrong_answer, online_exam_created_on, online_exam_status, online_exam_code) 
			VALUES (:admin_id, :online_exam_title, :online_exam_datetime, :online_exam_duration, :total_question, :marks_per_right_answer, :marks_per_wrong_answer, :online_exam_created_on, :online_exam_status, :online_exam_code)
			";

			$exam->execute_query();

			$output = array(
				'success'	=>	'New Exam Details Added'
			);

			echo json_encode($output);
		}

		if($_POST['action'] == 'edit_fetch'){
			$exam->query = "
			SELECT * FROM online_exam_table 
			WHERE online_exam_id = '".$_POST["exam_id"]."'
			";

			$result = $exam->query_result();

			foreach($result as $row){
				$output['online_exam_title'] = $row['online_exam_title'];

				$output['online_exam_datetime'] = $row['online_exam_datetime'];

				$output['online_exam_duration'] = $row['online_exam_duration'];

				$output['total_question'] = $row['total_question'];

				$output['marks_per_right_answer'] = $row['marks_per_right_answer'];

				$output['marks_per_wrong_answer'] = $row['marks_per_wrong_answer'];
			}

			echo json_encode($output);
		}

		if($_POST['action'] == 'Edit'){
			$exam->data = array(
				':online_exam_title'	=>	$_POST['online_exam_title'],
				':online_exam_datetime'	=>	$_POST['online_exam_datetime'] . ':00',
				':online_exam_duration'	=>	$_POST['online_exam_duration'],
				':total_question'		=>	$_POST['total_question'],
				':marks_per_right_answer'=>	$_POST['marks_per_right_answer'],
				':marks_per_wrong_answer'=>	$_POST['marks_per_wrong_answer'],
				':online_exam_id'		=>	$_POST['online_exam_id']
			);

			$exam->query = "
			UPDATE online_exam_table 
			SET online_exam_title = :online_exam_title, online_exam_datetime = :online_exam_datetime, online_exam_duration = :online_exam_duration, total_question = :total_question, marks_per_right_answer = :marks_per_right_answer, marks_per_wrong_answer = :marks_per_wrong_answer  
			WHERE online_exam_id = :online_exam_id
			";

			$exam->execute_query($exam->data);

			$output = array(
				'success'	=>	'Exam Details has been changed'
			);

			echo json_encode($output);
		}

		if($_POST['action'] == 'delete'){
			$exam->data = array(
				':online_exam_id'	=>	$_POST['exam_id']
			);

			$exam->query = "
			DELETE FROM online_exam_table 
			WHERE online_exam_id = :online_exam_id
			";

			$exam->execute_query();

			$output = array(
				'success'	=>	'Exam Details has been removed'
			);

			echo json_encode($output);
		}
	}

	if($_POST['page'] == 'question'){


		if($_POST['action'] == 'Add'){
			$exam->data = array(
				':online_exam_id'		=>	$_POST['online_exam_id'],
				':question_title'		=>	$exam->clean_data($_POST['question_title']),
				':answer_option'		=>	$_POST['answer_option']
			);

			$exam->query = "
			INSERT INTO question_table 
			(online_exam_id, question_title, answer_option) 
			VALUES (:online_exam_id, :question_title, :answer_option)
			";

			$question_id = $exam->execute_question_with_last_id($exam->data);

			for($count = 1; $count <= 4; $count++)
			{
				$exam->data = array(
					':question_id'		=>	$question_id,
					':option_number'	=>	$count,
					':option_title'		=>	$exam->clean_data($_POST['option_title_' . $count])
				);

				$exam->query = "
				INSERT INTO option_table 
				(question_id, option_number, option_title) 
				VALUES (:question_id, :option_number, :option_title)
				";

				$exam->execute_query($exam->data);
			}

			$output = array(
				'success'		=>	'Question Added'
			);

			echo json_encode($output);
		}

		if($_POST['action'] == 'fetch'){
			$output = array();
			$exam_id = '';
			if(isset($_POST['code']))
			{
				$exam_id = $exam->Get_exam_id($_POST['code']);
			}
			$exam->query = "
			SELECT * FROM question_table 
			WHERE online_exam_id = '".$exam_id."' 
			AND (
			";

			if(isset($_POST['search']['value']))
			{
				$exam->query .= 'question_title LIKE "%'.$_POST["search"]["value"].'%" ';
			}

			$exam->query .= ')';

			if(isset($_POST["order"]))
			{
				$exam->query .= '
				ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' 
				';
			}
			else
			{
				$exam->query .= 'ORDER BY question_id ASC ';
			}

			$extra_query = '';

			if($_POST['length'] != -1)
			{
				$extra_query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
			}

			$filtered_rows = $exam->total_row();

			$exam->query .= $extra_query;

			$result = $exam->query_result();

			$exam->query = "
			SELECT * FROM question_table 
			WHERE online_exam_id = '".$exam_id."'
			";

			$total_rows = $exam->total_row();

			$data = array();

			foreach($result as $row){
				$sub_array = array();

				$sub_array[] = $row['question_title'];

				$sub_array[] = 'Option ' . $row['answer_option'];

				$edit_button = '';
				$delete_button = '';

				if($exam->Is_exam_is_not_started($exam_id))
				{
					$edit_button = '<button type="button" name="edit" class="btn btn-primary btn-sm edit" id="'.$row['question_id'].'">Edit</button>';

					$delete_button = '<button type="button" name="delete" class="btn btn-danger btn-sm delete" id="'.$row['question_id'].'">Delete</button>';
				}

				$sub_array[] = $edit_button . ' ' . $delete_button;

				$data[] = $sub_array;
			}

			$output = array(
				"draw"		=>	intval($_POST["draw"]),
				"recordsTotal"	=>	$total_rows,
				"recordsFiltered"	=>	$filtered_rows,
				"data"		=>	$data
			);

			echo json_encode($output);
		}

		if($_POST['action'] == 'edit_fetch'){
			$exam->query = "
			SELECT * FROM question_table 
			WHERE question_id = '".$_POST["question_id"]."'
			";

			$result = $exam->query_result();

			foreach($result as $row){
				$output['question_title'] = html_entity_decode($row['question_title']);

				$output['answer_option'] = $row['answer_option'];

				for($count = 1; $count <= 4; $count++){
					$exam->query = "
					SELECT option_title FROM option_table 
					WHERE question_id = '".$_POST["question_id"]."' 
					AND option_number = '".$count."'
					";

					$sub_result = $exam->query_result();

					foreach($sub_result as $sub_row)
					{
						$output["option_title_" . $count] = html_entity_decode($sub_row["option_title"]);
					}
				}
			}

			echo json_encode($output);
		}

		if($_POST['action'] == 'Edit'){
			$exam->data = array(
				':question_title'		=>	$_POST['question_title'],
				':answer_option'		=>	$_POST['answer_option'],
				':question_id'			=>	$_POST['question_id']
			);

			$exam->query = "
			UPDATE question_table 
			SET question_title = :question_title, answer_option = :answer_option 
			WHERE question_id = :question_id
			";

			$exam->execute_query();

			for($count = 1; $count <= 4; $count++)
			{
				$exam->data = array(
					':question_id'		=>	$_POST['question_id'],
					':option_number'	=>	$count,
					':option_title'		=>	$_POST['option_title_' . $count]
				);

				$exam->query = "
				UPDATE option_table 
				SET option_title = :option_title 
				WHERE question_id = :question_id 
				AND option_number = :option_number
				";
				$exam->execute_query();
			}

			$output = array(
				'success'	=>	'Question Edit'
			);

			echo json_encode($output);
		}
	}

	if($_POST['page'] == 'exam_enroll'){
		if($_POST['action'] == 'fetch')
		{
			$output = array();

			$exam_id = $exam->Get_exam_id($_POST['code']);

			$exam->query = "
			SELECT * FROM user_exam_enroll_table 
			INNER JOIN user_table 
			ON user_table.user_id = user_exam_enroll_table.user_id  
			WHERE user_exam_enroll_table.exam_id = '".$exam_id."' 
			AND (
			";

			if(isset($_POST['search']['value']))
			{
				$exam->query .= '
				user_table.user_name LIKE "%'.$_POST["search"]["value"].'%" 
				';
				$exam->query .= 'OR user_table.user_gender LIKE "%'.$_POST["search"]["value"].'%" ';
				$exam->query .= 'OR user_table.user_mobile_no LIKE "%'.$_POST["search"]["value"].'%" ';
				$exam->query .= 'OR user_table.user_email_verified LIKE "%'.$_POST["search"]["value"].'%" ';
			}
			$exam->query .= ') ';

			if(isset($_POST['order']))
			{
				$exam->query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
			}
			else
			{
				$exam->query .= 'ORDER BY user_exam_enroll_table.user_exam_enroll_id ASC ';
			}

			$extra_query = '';

			if($_POST['length'] != -1)
			{
				$extra_query = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
			}

			$filtered_rows = $exam->total_row();

			$exam->query .= $extra_query;

			$result = $exam->query_result();

			$exam->query = "
			SELECT * FROM user_exam_enroll_table 
			INNER JOIN user_table 
			ON user_table.user_id = user_exam_enroll_table.user_id  
			WHERE user_exam_enroll_table.exam_id = '".$exam_id."'
			";

			$total_rows = $exam->total_row();

			$data = array();

			foreach($result as $row)
			{
				$sub_array = array();
				$sub_array[] = "<img src='../upload/".$row["user_image"]."' class='img-thumbnail' width='75' />";
				$sub_array[] = $row["user_name"];
				$sub_array[] = $row["user_gender"];
				$sub_array[] = $row["user_mobile_no"];
				$is_email_verified = '';

				if($row['user_email_verified'] == 'yes')
				{
					$is_email_verified = '<label class="badge badge-success">Yes</label>';
				}
				else
				{
					$is_email_verified = '<label class="badge badge-danger">No</label>';
				}
				$sub_array[] = $is_email_verified;
				$result = '';

				if($exam->Get_exam_status($exam_id) == 'Completed')
				{
					$result = '<a href="user_exam_result.php?code='.$_POST['code'].'&id='.$row['user_id'].'" class="btn btn-info btn-sm" target="_blank">Result</a>';
				}
				$sub_array[] = $result;

				$data[] = $sub_array;
			}

			$output = array(
				"draw"				=>	intval($_POST["draw"]),
				"recordsTotal"		=>	$total_rows,
				"recordsFiltered"	=>	$filtered_rows,
				"data"				=>	$data
			);

			echo json_encode($output);
		}
	}

	if($_POST['page'] == 'exam_result'){
		if($_POST['action'] == 'fetch'){
			$output = array();
			$exam_id = $exam->Get_exam_id($_POST["code"]);
			$exam->query = "
			SELECT user_table.user_id, user_table.user_image, user_table.user_name, sum(user_exam_question_answer.marks) as total_mark  
			FROM user_exam_question_answer  
			INNER JOIN user_table 
			ON user_table.user_id = user_exam_question_answer.user_id 
			WHERE user_exam_question_answer.exam_id = '$exam_id' 
			AND (
			";

			if(isset($_POST["search"]["value"]))
			{
				$exam->query .= 'user_table.user_name LIKE "%'.$_POST["search"]["value"].'%" ';
			}

			$exam->query .= '
			) 
			GROUP BY user_exam_question_answer.user_id 
			';

			if(isset($_POST["order"]))
			{
				$exam->query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
			}
			else
			{
				$exam->query .= 'ORDER BY total_mark DESC ';
			}

			$extra_query = '';

			if($_POST["length"] != -1)
			{
				$extra_query = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
			}

			$filtered_rows = $exam->total_row();

			$exam->query .= $extra_query;

			$result = $exam->query_result();

			$exam->query = "
			SELECT 	user_table.user_image, user_table.user_name, sum(user_exam_question_answer.marks) as total_mark  
			FROM user_exam_question_answer  
			INNER JOIN user_table 
			ON user_table.user_id = user_exam_question_answer.user_id 
			WHERE user_exam_question_answer.exam_id = '$exam_id' 
			GROUP BY user_exam_question_answer.user_id 
			ORDER BY total_mark DESC
			";

			$total_rows = $exam->total_row();

			$data = array();

			foreach($result as $row)
			{
				$sub_array = array();
				$sub_array[] = '<img src="../upload/'.$row["user_image"].'" class="img-thumbnail" width="75" />';
				$sub_array[] = $row["user_name"];
				$sub_array[] = $exam->Get_user_exam_status($exam_id, $row["user_id"]);
				$sub_array[] = $row["total_mark"];
				$data[] = $sub_array;
			}

			$output = array(
				"draw"				=>	intval($_POST["draw"]),
				"recordsTotal"		=>	$total_rows,
				"recordsFiltered"	=>	$filtered_rows,
				"data"				=>	$data
			);

			echo json_encode($output);
		}
	}



}

?>