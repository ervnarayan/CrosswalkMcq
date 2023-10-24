<?php
date_default_timezone_set('Asia/Kolkata');
class Examination{ 
	var $host;
	var $username;
	var $password;
	var $database;
	var $connect;
	var $home_page;
	var $query;
	var $data;
	var $statement;
	var $filedata;


	

	
	function __construct(){
		$this->host = 'localhost';
		$this->username = 'root';
		$this->password = '';
		$this->database = 'mcqs_drill';
		$this->home_page = '';
		$this->connect = new PDO("mysql:host=$this->host; dbname=$this->database", "$this->username", "$this->password");
		session_start();
	}

	function percent_calculate($d1, $d2){
		return ($d1 / $d2) * 100;
	}

	function execute_query(){
		$this->statement = $this->connect->prepare($this->query);
		$this->statement->execute($this->data);
	}

	function total_row(){
		$this->execute_query();
		return $this->statement->rowCount();
	}

	function send_email($receiver_email, $subject, $body){
		$mail = new PHPMailer;

		$mail->IsSMTP();

		$mail->Host = 'smtp host';

		$mail->Port = '587';

		$mail->SMTPAuth = true;

		$mail->Username = '';

		$mail->Password = '';

		$mail->SMTPSecure = '';

		// $mail->From = 'info@webslesson.info';
		$mail->From = '';

		// $mail->FromName = 'info@webslesson.info';
		$mail->FromName = '';

		$mail->AddAddress($receiver_email, '');

		$mail->IsHTML(true);

		$mail->Subject = $subject;

		$mail->Body = $body;

		$mail->Send();		
	}

	function redirect($page){
		header('location:'.$page.'');
		exit;
	}

	function admin_session_private(){
		if(!isset($_SESSION['admin_id'])){
			$this->redirect('login.php');
		}
	}

	function admin_session_public(){
		if(isset($_SESSION['admin_id'])){
			$this->redirect('index.php');
		}
	}

	function query_result(){
		$this->execute_query();
		return $this->statement->fetchAll();
	}

	function clean_data($data){
	 	$data = trim($data);
	  	$data = stripslashes($data);
	  	$data = htmlspecialchars($data);
	  	return $data;
	}

	function Upload_file(){
		if(!empty($this->filedata['name'])){
			$extension = pathinfo($this->filedata['name'], PATHINFO_EXTENSION);
			$new_name = uniqid() . '.' . $extension;
			$_source_path = $this->filedata['tmp_name'];
			$target_path = '../upload/' . $new_name;
			move_uploaded_file($_source_path, $target_path);
			return $new_name;
		}
	}

	function user_session_private(){
		if(!isset($_SESSION['user_id'])){
			$this->redirect('login.php');
		}
	}

	function user_session_public(){
		if(isset($_SESSION['user_id'])){
			$this->redirect('index.php');
		}
	}





	function Get_exam_question_limit($exam_id){
		$this->query = "SELECT total_question FROM online_exam_table WHERE online_exam_id = '$exam_id'";
		$result = $this->query_result();
		foreach($result as $row){
			return $row['total_question'];
		}
	}

	function Get_exam_total_question($exam_id){
		$this->query = "SELECT question_id FROM question_table WHERE online_exam_id = '$exam_id'";
		return $this->total_row();
	}

	function Is_allowed_add_question($exam_id){
		$exam_question_limit = $this->Get_exam_question_limit($exam_id);
		$exam_total_question = $this->Get_exam_total_question($exam_id);
		if($exam_total_question >= $exam_question_limit){
			return false;
		}
		return true;
	}

	function execute_question_with_last_id(){
		$this->statement = $this->connect->prepare($this->query);
		$this->statement->execute($this->data);
		return $this->connect->lastInsertId();
	}

	function Get_exam_id($exam_code){
		$this->query = "SELECT online_exam_id FROM online_exam_table WHERE online_exam_code = '$exam_code'";
		$result = $this->query_result();
		foreach($result as $row){
			return $row['online_exam_id'];
		}
	}






	/*GET LIST*/
	function get_batch_list(){
		$this->query = "SELECT * FROM `batch`";
		return $this->query_result();	
	}

	function get_subject_list(){
		$this->query = "SELECT * FROM `subject`";
		return $this->query_result();	
	}

	function get_module_list($subject_id){
		$this->query = "SELECT * FROM `module` WHERE `subject_id`='".$subject_id."'";
		return $this->query_result();	
	}

	function get_chapter_list($subject_id){
		$this->query = "SELECT * FROM `chapter` WHERE `subject_id`='".$subject_id."'";
		return $this->query_result();	
	}



	/*USER PART*/
	function get_exam_code(){
		if(isset($_SESSION['exam_code'])){
			if($_SESSION['exam_code'] !=""){
				return $_SESSION['exam_code'];
			}			
		}
	}
	
	function get_mode(){
		if(isset($_SESSION['mode'])){
			if($_SESSION['mode'] !=""){
				return $_SESSION['mode'];
			}
		}
	}	

	function get_mode_sub_id(){
		if(isset($_SESSION['mode_subject_id'])){
			if($_SESSION['mode_subject_id'] !=""){
				return $_SESSION['mode_subject_id'];
			}
		}
	}

	function get_mcq_max_quest(){
		$this->query = "SELECT `mcq_max_question` FROM `admin_table`";
		$result = $this->query_result();
		foreach($result as $row){
			return $row["mcq_max_question"];
		}
	}

	function get_mcq_timing($mcqn){
		if($this->get_mode() != "study"){
			$this->query = "SELECT `mcq_timing` FROM `admin_table`";
			$result = $this->query_result();
			foreach($result as $row){
				$timing = $row["mcq_timing"] * $mcqn;
				$_SESSION['mcq_timing'] = $timing;
				return "<h6>".ucfirst($this->get_mode())." Timing : ".$timing. " Mins</h6>";
			}
		}
	}

	function set_exam_clock(){
		if($this->get_mode() == 'exam'){
			if(@$_SESSION['mcq_timing'] != ""){
				$remaining_minutes = $_SESSION['mcq_timing'] * 60;
				return '<div id="exam_timer" data-timer="'.$remaining_minutes.'" style="max-width:400px; width: 100%; height: 200px;"></div>';
			}
		}
	}

	function insert_exam_records($user_id, $subject_id, $online_exam_duration, $total_question, $mcq_mode, $online_exam_code){
		$current_datetime = date("Y-m-d") . ' ' . date("H:i:s", STRTOTIME(date('h:i:sa')));
		$this->data = array(
			':user_id'					=>	$user_id,
			':subject_id'				=>	$subject_id,
			':online_exam_duration'		=>	$online_exam_duration,
			':total_question'			=>	$total_question,
			':online_exam_created_on'   =>  $current_datetime,
			':mcq_mode'					=>	$mcq_mode,
			':online_exam_code'			=>	$online_exam_code
		);

		$this->query = "INSERT INTO `online_exam_table` (user_id, subject_id, online_exam_duration, total_question, online_exam_created_on, mcq_mode, online_exam_code) VALUES (:user_id, :subject_id, :online_exam_duration, :total_question, :online_exam_created_on, :mcq_mode, :online_exam_code)";
		$this->execute_query();
	}

	private $mcq_user_result;

	function add_mcq_result($data){
		$_SESSION['mcq_user_result'] = $data;
	}

	function get_mcq_result(){
		return $_SESSION['mcq_user_result'];
	}

	function correct_option_field($d){
		switch ($d) {
			case 'a':
				return 'option_a';
				break;
			case 'b':
				return 'option_b';
				break;
			case 'c':
				return 'option_c';
				break;
			case 'd':
				return 'option_d';
				break;												
		}
	}

	function get_exam_status($code){
		$this->query = "SELECT `online_exam_status` FROM `online_exam_table` WHERE `online_exam_code` = '".$code."'";
		$result = $this->query_result();
		foreach($result as $row){
			return $row["online_exam_status"];
		}
	}

	function update_exam_result($marks_obtained, $user_answer){
		$this->data = array(
			':online_exam_status'	=>	'Completed',
			':user_answer'			=> 	$user_answer,
			':marks_obtained'   	=> 	$marks_obtained
		);
		$this->query = "UPDATE online_exam_table SET online_exam_status = :online_exam_status, marks_obtained = :marks_obtained, user_answer = :user_answer WHERE online_exam_code = '".$this->get_exam_code()."'";
		$this->execute_query();
	}

	function get_user_answer_records($code){
		$this->query = "SELECT `user_answer` FROM `online_exam_table` WHERE `online_exam_code` = '".$code."' AND `user_id`= '".$_SESSION['user_id']."'";
		$result = $this->query_result();
		foreach($result as $row){
			return $row["user_answer"];
		}
	}

	function get_correct_answer($question_id){
		$this->query = "SELECT * FROM `questionnaire` WHERE `questionnaire_id` = '".$question_id."'";
		$result = $this->query_result();
		foreach($result as $row){
			return $row["correct_option"];
		}
	}

	function increase_mcq_attempt_counter(){
		$this->query = "UPDATE `user_table` SET mcq_attempt_counter = mcq_attempt_counter + 1 WHERE `user_id` = '".$_SESSION['user_id']."'";
		$this->execute_query();		
	}

	function get_mcq_per_subject_limit(){
		$this->query = "SELECT `mcq_per_subject_limit` FROM `admin_table`";
		$result = $this->query_result();
		foreach($result as $row){
			return $row["mcq_per_subject_limit"];
		}
	}

	function get_mcq_user_limit(){
		$this->query = "SELECT `mcq_user_limit` FROM `admin_table`";
		$result = $this->query_result();
		foreach($result as $row){
			return $row["mcq_user_limit"];
		}		
	}

	function get_user_attempt_subject_wise($subject_id){
		$this->query = "SELECT `online_exam_id` FROM `online_exam_table` WHERE `user_id` = '".$_SESSION['user_id']."' AND `subject_id` = '".$subject_id."'";
		return $this->total_row();		
	}

	function get_user_total_mcq_attempt(){
		$this->query = "SELECT `mcq_attempt_counter` FROM `user_table` WHERE user_id = '".$_SESSION["user_id"]."'";
		$result = $this->query_result();
		foreach ($result as $row) {
			return $row['mcq_attempt_counter'];
		}
	}

	function is_attempt_valid(){
		if($this->get_user_total_mcq_attempt() < $this->get_mcq_user_limit()){
			return true;
		}
	}




}

?>