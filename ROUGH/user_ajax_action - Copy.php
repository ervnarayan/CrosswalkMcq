<?php
include('master/Examination.php');
require_once('class/class.phpmailer.php');
$exam = new Examination;
$current_datetime = date("Y-m-d") . ' ' . date("H:i:s", STRTOTIME(date('h:i:sa')));
if(isset($_POST['page'])){

	if($_POST['page'] == 'login'){
		if($_POST['action'] == 'login'){
			$exam->data = array(
				':user_email_address'	=>	$_POST['user_email_address']
			);

			$exam->query = "
			SELECT * FROM user_table 
			WHERE user_email_address = :user_email_address
			";

			$total_row = $exam->total_row();
			if($total_row > 0){
				$result = $exam->query_result();
				foreach($result as $row){
					if($row['user_email_verified'] == 'yes'){
						if(password_verify($_POST['user_password'], $row['user_password'])){
							$_SESSION['user_id'] = $row['user_id'];
							$_SESSION['batch_id'] = $row['batch_id'];
							$output = array(
								'success'	=>	true
							);
						}else{
							$output = array(
								'error'		=>	'Wrong Password'
							);
						}
					}else{
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

	if($_POST['page'] == "profile"){
		if($_POST['action'] == "profile"){
			$user_image = $_POST['hidden_user_image'];
			if($_FILES['user_image']['name'] != ''){
				$exam->filedata = $_FILES['user_image'];
				$user_image = $exam->Upload_file();
			}
			$exam->data = array(
				':user_name'				=>	$exam->clean_data($_POST['user_name']), 
				':user_gender'				=>	$_POST['user_gender'],
				':user_address'				=>	$exam->clean_data($_POST['user_address']),
				':user_mobile_no'			=>	$_POST['user_mobile_no'],
				':user_image'				=>	$user_image,
				':user_id'					=>	$_SESSION['user_id']		
			);
			$exam->query = "
			UPDATE user_table 
			SET user_name = :user_name, user_gender = :user_gender, user_address = :user_address, user_mobile_no = :user_mobile_no, user_image = :user_image 
			WHERE user_id = :user_id
			";
			$exam->execute_query();

			$output = array(
				'success'		=>	true
			);
			echo json_encode($output);
		}
	}

	if($_POST['page'] == 'index'){
		if($_POST['action'] == "set_mode"){
			if($_POST['md'] !== ''){
				$_SESSION['mode'] = $_POST['md'];
				echo "success";				
			}else{
				echo "Bad Request";
			}	
		}
	}

	if($_POST['page'] == 'subList'){

		if($_POST['action'] == 'fetch_subject'){
			$output = array();
			$exam->query ="SELECT * FROM `subject` INNER JOIN `subject_assignment` ON `subject_assignment`.`subject_id` = `subject`.`subject_id` WHERE `subject_assignment`.`batch_id` = '".$_SESSION['batch_id']."'			

						AND (";
			if(isset($_POST["search"]["value"])){
			 	$exam->query .= 'subject.subject_name LIKE "%'.$_POST["search"]["value"].'%" ';
			}
			$exam->query .= ')';
			if(isset($_POST["order"])){
				$exam->query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
			}else{
				$exam->query .= 'ORDER BY `subject`.`subject_id` DESC ';
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
				$sub_array[] = '<a href="javascript:;" class="select_subject btn btn-info" value="'.$row["subject_id"].'" >Choose</a>';
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

	}

	if($_POST['page'] == 'topics'){

		if($_POST['action'] == 'add_subject'){
			if($_POST['subject_id'] !== ''){
				$_SESSION['mode_module_id'] = "";
				$_SESSION['mode_subject_id'] = $_POST['subject_id'];
				echo "success";				
			}else{
				echo "Bad Request";
			}
		}

		if($_POST['action'] == 'add_mcqn'){
			if($_POST['mcqn'] !== ''){
				$mcqn = $exam->get_mcq_max_quest();
				if($_POST['mcqn'] <= $mcqn){
					$_SESSION['mcq_number'] = $_POST['mcqn'];
					echo $exam->get_mcq_timing($_POST['mcqn']);
				}else{
					echo "<h6>Max Question should be : ".$mcqn."</h6>";
				}
			}else{
				$_SESSION['mcq_number'] = "";
				$_SESSION['mcq_timing'] = "";
			}
		}

		if($_POST['action'] == 'fetch_chapter'){
			$output = array();
			$exam->query = "SELECT * FROM `chapter` INNER JOIN `module` ON `module`.`module_id` = `chapter`.`module_id` WHERE `chapter`.`subject_id` = '".@$_SESSION['mode_subject_id']."' 
						AND (";
			if(isset($_POST["search"]["value"])){
			 	$exam->query .= 'chapter.chapter_name LIKE "%'.$_POST["search"]["value"].'%" ';
			}
			$exam->query .= ')';
			if(isset($_POST["order"])){
				$exam->query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
			}else{
				$exam->query .= 'ORDER BY chapter.chapter_id DESC ';
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
			foreach($result as $row){
				$sub_array = array();
				$sub_array[] = html_entity_decode($row["module_name"]);					
				$sub_array[] = html_entity_decode($row["chapter_name"]);
				$sub_array[] = '<input type="checkbox" class="select_chapter" value="'.$row["chapter_id"].'" />';
				$data[] = $sub_array;
			}
			$output = array(
			 	"draw"    			=> 	intval($_POST["draw"]),
			 	"recordsTotal"  	=>  $total_rows,
			 	"recordsFiltered" 	=> 	$filterd_rows,
			 	"data"    			=> 	$data
			);
			echo json_encode($output);
		}

		if($_POST['action'] == 'create_mcq'){
			if($_POST['chapterLists'] !=""){
				$mcqn = $_SESSION['mcq_number'];
				$chapterId = explode(',', $_POST['chapterLists']);
				$chapter_count =  count($chapterId);
				$total_questionnaire_per_chapter_db_array = array(); 
				$proportion_percent = array();
				for ($i=0; $i < $chapter_count; $i++) { 
					$exam->query = "SELECT * FROM `questionnaire` WHERE `chapter_id` = '".$chapterId[$i]."'";
					$total_questionnaire_per_chapter_db_array[] = $exam->total_row();
				}
				$total_db_questionnaire =  array_sum($total_questionnaire_per_chapter_db_array);
				foreach ($total_questionnaire_per_chapter_db_array as $key => $value) {
					$proportion_percent[] = round(($mcqn * (($value / $total_db_questionnaire) * 100))/100);
				}
				$mcq_questionnaire_ids = array();
				foreach($proportion_percent as $key => $value) {
					if($value != 0){
						$exam->query = "SELECT * FROM `questionnaire` WHERE `chapter_id` = '".$chapterId[$key]."' ORDER BY RAND() LIMIT ".$value." ";
						$result = $exam->query_result();
						foreach ($result as $row) {
							$mcq_questionnaire_ids[] = $row['questionnaire_id'];
						}
					}
				}
				shuffle($mcq_questionnaire_ids);
				if(count($mcq_questionnaire_ids) == $mcqn){
					$_SESSION['mcq_questionnaire_ids'] = $mcq_questionnaire_ids;
					echo "success";
				}else{
					echo "Error found in request! Re-create MCQ Test.";
				}
			}
		}
	}


	if($_POST['page'] == 'view_exam'){

		if($_POST['action'] == 'load_question'){

		// $_SESSION['mcq_questionnaire_ids'];





			if($_POST['question_id'] == ''){
				$exam->query = "SELECT * FROM question_table WHERE online_exam_id = '".$_POST["exam_id"]."' ORDER BY question_id ASC LIMIT 1";
			}else{
				$exam->query = "SELECT * FROM question_table WHERE question_id = '".$_POST["question_id"]."' ";
			}

			$result = $exam->query_result();
			$output = '';
			foreach($result as $row){
				$output .= '<h5>'.$row["question_title"].'</h5><hr /><br /><div class="row">';
				$exam->query = "SELECT * FROM option_table WHERE question_id = '".$row['question_id']."'";
				$sub_result = $exam->query_result();
				$count = 1;

				foreach($sub_result as $sub_row){
					$output .= '
					<div class="col-md-6" style="margin-bottom:32px;">
						<div class="radio">
							<label><h6><input type="radio" name="option_1" class="answer_option" data-question_id="'.$row["question_id"].'" id-data="'.$count.'"/>&nbsp;'.$sub_row["option_title"].'</h6></label>
						</div>
					</div>
					';

					$count = $count + 1;
				}
				$output .= '</div>';
				$exam->query = "SELECT question_id FROM question_table WHERE question_id < '".$row['question_id']."' AND online_exam_id = '".$_POST["exam_id"]."' ORDER BY question_id DESC LIMIT 1";

				$previous_result = $exam->query_result();

				$previous_id = '';
				$next_id = '';

				foreach($previous_result as $previous_row){
					$previous_id = $previous_row['question_id'];
				}

				$exam->query = "SELECT question_id FROM question_table WHERE question_id > '".$row['question_id']."' AND online_exam_id = '".$_POST["exam_id"]."' ORDER BY question_id ASC LIMIT 1";
  				
  				$next_result = $exam->query_result();

  				foreach($next_result as $next_row){
					$next_id = $next_row['question_id'];
				}

				$if_previous_disable = '';
				$if_next_disable = '';

				if($previous_id == ""){
					$if_previous_disable = 'disabled';
				}
				
				if($next_id == ""){
					$if_next_disable = 'disabled';
				}

				$output .= '
					<br /><br />
				  	<div align="center">
				   		<button type="button" name="previous" class="btn btn-info btn-lg previous" id="'.$previous_id.'" '.$if_previous_disable.'>Previous</button>
				   		<button type="button" name="next" class="btn btn-warning btn-lg next" id="'.$next_id.'" '.$if_next_disable.'>Next</button>
				  	</div>
				  	<br /><br />';
			}

			echo $output;
		}

		if($_POST['action'] == 'question_navigation'){
			$exam->query = "SELECT question_id FROM question_table WHERE online_exam_id = '".$_POST["exam_id"]."' ORDER BY question_id ASC ";
			$result = $exam->query_result();
			$output = '
			<div class="card"><div class="card-header">Question Navigation</div><div class="card-body"><div class="row">';
			$count = 1;
			foreach($result as $row)	{
				$output .= '
				<div class="col-md-2" style="margin-bottom:24px;">
					<button type="button" class="btn btn-primary btn-lg question_navigation" data-question_id="'.$row["question_id"].'">'.$count.'</button>
				</div>
				';
				$count++;
			}
			$output .= '
				</div>
			</div></div>
			';
			echo $output;
		}


		if($_POST['action'] == 'answer'){
			$exam_right_answer_mark = $exam->Get_question_right_answer_mark($_POST['exam_id']);
			$exam_wrong_answer_mark = $exam->Get_question_wrong_answer_mark($_POST['exam_id']);
			$orignal_answer = $exam->Get_question_answer_option($_POST['question_id']);

			$marks = 0;

			if($orignal_answer == $_POST['answer_option']){
				$marks = '+' . $exam_right_answer_mark;
			}else{
				$marks = '-' . $exam_wrong_answer_mark;
			}

			$exam->data = array(
				':user_answer_option'	=>	$_POST['answer_option'],
				':marks'				=>	$marks
			);

			$exam->query = "UPDATE user_exam_question_answer SET user_answer_option = :user_answer_option, marks = :marks WHERE user_id = '".$_SESSION["user_id"]."' AND exam_id = '".$_POST['exam_id']."' AND question_id = '".$_POST["question_id"]."'";
			$exam->execute_query();
		}

		if($_POST['action'] == 'user_detail'){
			$exam->query = "SELECT * FROM user_table WHERE user_id = '".$_SESSION["user_id"]."'";
			$result = $exam->query_result();

			$output = '<div class="card">
				<div class="card-header">User Details</div>
				<div class="card-body">
					<div class="row">';

			foreach($result as $row){
				$output .= '
				<div class="col-md-3">
					<img src="upload/'.$row["user_image"].'" class="img-fluid" />
				</div>
				<div class="col-md-9">
					<table class="table table-bordered">
						<tr>
							<th>Name</th>
							<td>'.$row["user_name"].'</td>
						</tr>
						<tr>
							<th>'.$row["user_national_type"].'</th>
							<td>'.$row["user_national_no"].'</td>
						</tr>
						<tr>
							<th>Email ID</th>
							<td>'.$row["user_email_address"].'</td>
						</tr>
						<tr>
							<th>Phone</th>
							<td>'.$row["user_mobile_no"].'</td>
						</tr>						
						<tr>
							<th>Gendar</th>
							<td>'.$row["user_gender"].'</td>
						</tr>
					</table>
				</div>
				';
			}
			$output .= '</div></div></div>';
			echo $output;
		}


	}













	/*ROUGH ZONE*/

	if($_POST["page"] == 'enroll_exam'){
		if($_POST['action'] == 'fetch'){
			$output = array();
			$exam->query = "
			SELECT * FROM user_exam_enroll_table 
			INNER JOIN online_exam_table 
			ON online_exam_table.online_exam_id = user_exam_enroll_table.exam_id 
			WHERE user_exam_enroll_table.user_id = '".$_SESSION['user_id']."' 
			AND (";

			if(isset($_POST["search"]["value"])){
			 	$exam->query .= 'online_exam_table.online_exam_title LIKE "%'.$_POST["search"]["value"].'%" ';
			 	$exam->query .= 'OR online_exam_table.online_exam_datetime LIKE "%'.$_POST["search"]["value"].'%" ';
			 	$exam->query .= 'OR online_exam_table.online_exam_duration LIKE "%'.$_POST["search"]["value"].'%" ';
			 	$exam->query .= 'OR online_exam_table.total_question LIKE "%'.$_POST["search"]["value"].'%" ';
			 	$exam->query .= 'OR online_exam_table.marks_per_right_answer LIKE "%'.$_POST["search"]["value"].'%" ';
			 	$exam->query .= 'OR online_exam_table.marks_per_wrong_answer LIKE "%'.$_POST["search"]["value"].'%" ';
			 	$exam->query .= 'OR online_exam_table.online_exam_status LIKE "%'.$_POST["search"]["value"].'%" ';
			}

			$exam->query .= ')';

			if(isset($_POST["order"])){
				$exam->query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
			}else{
				$exam->query .= 'ORDER BY online_exam_table.online_exam_id DESC ';
			}

			$extra_query = '';

			if($_POST["length"] != -1){
			 	$extra_query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
			}

			$filterd_rows = $exam->total_row();
			$exam->query .= $extra_query;
			$result = $exam->query_result();
			$exam->query = "
			SELECT * FROM user_exam_enroll_table 
			INNER JOIN online_exam_table 
			ON online_exam_table.online_exam_id = user_exam_enroll_table.exam_id 
			WHERE user_exam_enroll_table.user_id = '".$_SESSION['user_id']."'";

			$total_rows = $exam->total_row();

			$data = array();

			foreach($result as $row){
				$sub_array = array();
				$sub_array[] = html_entity_decode($row["online_exam_title"]);
				$sub_array[] = $row["online_exam_datetime"];
				$sub_array[] = $row["online_exam_duration"] . ' Minute';
				$sub_array[] = $row["total_question"] . ' Question';
				$sub_array[] = $row["marks_per_right_answer"] . ' Mark';
				$sub_array[] = '-' . $row["marks_per_wrong_answer"] . ' Mark';
				$status = '';

				if($row['online_exam_status'] == 'Created'){
					$status = '<span class="badge badge-success">Created</span>';
				}

				if($row['online_exam_status'] == 'Started'){
					$status = '<span class="badge badge-primary">Started</span>';
				}

				if($row['online_exam_status'] == 'Completed'){
					$status = '<span class="badge badge-dark">Completed</span>';
				}

				$sub_array[] = $status;				

				if($row["online_exam_status"] == 'Started'){
					$view_exam = '<a href="view_exam.php?code='.$row["online_exam_code"].'" class="btn btn-info btn-sm">View Exam</a>';
				}
				if($row["online_exam_status"] == 'Completed'){
					$view_exam = '<a href="view_exam.php?code='.$row["online_exam_code"].'" class="btn btn-info btn-sm">View Exam</a>';
				}				
				$sub_array[] = $view_exam;
				$data[] = $sub_array;
			}

			$output = array(
			 	"draw"    			=> 	intval($_POST["draw"]),
			 	"recordsTotal"  	=>  $total_rows,
			 	"recordsFiltered" 	=> 	$filterd_rows,
			 	"data"    			=> 	$data
			);
			echo json_encode($output);
		}
	}

	if($_POST['page'] == 'register'){
		if($_POST['action'] == 'check_email'){
			$exam->query = "
			SELECT * FROM user_table 
			WHERE user_email_address = '".trim($_POST["email"])."'
			";

			$total_row = $exam->total_row();

			if($total_row == 0)
			{
				$output = array(
					'success'		=>	true
				);
				echo json_encode($output);
			}
		}

		if($_POST['action'] == 'register'){
			$user_verfication_code = md5(rand());

			$receiver_email = $_POST['user_email_address'];

			$exam->filedata = $_FILES['user_image'];

			$user_image = $exam->Upload_file();

			$exam->data = array(
				':user_email_address'	=>	$receiver_email,
				':user_password'		=>	password_hash($_POST['user_password'], PASSWORD_DEFAULT),
				':user_verfication_code'=>	$user_verfication_code,
				':user_name'			=>	$_POST['user_name'],
				':user_gender'			=>	$_POST['user_gender'],
				':user_address'			=>	$_POST['user_address'],
				':user_mobile_no'		=>	$_POST['user_mobile_no'],
				':user_image'			=>	$user_image,
				':user_created_on'		=>	$current_datetime
			);

			$exam->query = "
			INSERT INTO user_table 
			(user_email_address, user_password, user_verfication_code, user_name, user_gender, user_address, user_mobile_no, user_image, user_created_on)
			VALUES 
			(:user_email_address, :user_password, :user_verfication_code, :user_name, :user_gender, :user_address, :user_mobile_no, :user_image, :user_created_on)
			";

			$exam->execute_query();

			$subject= 'Online Examination Registration Verification';

			$body = '
			<p>Thank you for registering.</p>
			<p>This is a verification eMail, please click the link to verify your eMail address by clicking this <a href="'.$exam->home_page.'verify_email.php?type=user&code='.$user_verfication_code.'" target="_blank"><b>link</b></a>.</p>
			<p>In case if you have any difficulty please eMail us.</p>
			<p>Thank you,</p>
			<p>Online Examination System</p>
			';

			$exam->send_email($receiver_email, $subject, $body);

			$output = array(
				'success'		=>	true
			);

			echo json_encode($output);
		}
	}

	if($_POST['page'] == 'change_password'){
		if($_POST['action'] == 'change_password'){
			$exam->data = array(
				':user_password'	=>	password_hash($_POST['user_password'], PASSWORD_DEFAULT),
				':user_id'			=>	$_SESSION['user_id']
			);
			$exam->query = "
			UPDATE user_table 
			SET user_password = :user_password 
			WHERE user_id = :user_id
			";

			$exam->execute_query();
			session_destroy();
			$output = array(
				'success'		=>	'Password has been change'
			);
			echo json_encode($output);
		}
	}



	
}

?>