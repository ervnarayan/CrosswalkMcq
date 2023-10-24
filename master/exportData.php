<?php 
date_default_timezone_set('Asia/Kolkata');
include('Examination.php');
$exam = new Examination;
$exam->admin_session_private();
// Load the database configuration file 
// include_once 'dbConfig.php'; 
 
$filename = "questionnaire_" . date('Y-m-d') . ".csv"; 
$delimiter = ","; 
 
// Create a file pointer 
$f = fopen('php://memory', 'w'); 
 
// Set column headers 
$fields = array('Questionnaire ID', 'Subject Code', 'Chapter Code', 'Questionnaire Text', 'Point I', 'Point II', 'Point III', 'Point IV', 'Image', 'Option A', 'Option B', 'Option C', 'Option D', 'Right Option', 'Explaination Text'); 
fputcsv($f, $fields, $delimiter); 
 
// Get records from the database 
$exam->query = "SELECT * FROM `questionnaire` ORDER BY `questionnaire_id` ASC"; 
$result = $exam->query_result();

if($exam->total_row() > 0){ 

	foreach ($result as $row) {
        $lineData = array($row['questionnaire_id'], $row['subject_id'], $row['chapter_id'], $row['questionnaire_text'], $row['point_1'], $row['point_2'], $row['point_3'], $row['point_4'], $row['q_image'], $row['option_a'], $row['option_b'], $row['option_c'], $row['option_d'], $row['correct_option'], $row['explaination_text']); 
        fputcsv($f, $lineData, $delimiter); 
	}

} 
 
// Move back to beginning of file 
fseek($f, 0); 
 
// Set headers to download file rather than displayed 
header('Content-Type: text/csv'); 
header('Content-Disposition: attachment; filename="' . $filename . '";'); 
 
// Output all remaining data on a file pointer 
fpassthru($f); 
 
// Exit from file 
exit();