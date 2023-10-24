<?php
    include('Examination.php');
    $exam = new Examination;
    $exam->admin_session_private();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  	<title>Crosswalk MCQs Drill Administrator</title>
  	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="images/favicon.png"/>

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/dataTables.bootstrap4.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="Js/popper.min.js"></script>
    <script src="Js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="Js/dataTables.bootstrap4.min.js"></script>
    <script src="Js/parsley.js"></script>

  	<link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/bootstrap-datetimepicker.css" />
    <script src="Js/bootstrap-datetimepicker.js"></script>
</head>
<body>
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
        <div class="col-md-3">
            <a class="navbar-brand" href="index.php"><img src="logo.png" class="img-fluid" width="120px" alt="" /></a>
        </div>

        <div class="col-md-6 offset-md-3">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="collapsibleNavbar">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="batchList.php">Batch</a></li>
                    <li class="nav-item"><a class="nav-link" href="subjectList.php">Subject</a></li>
                    <li class="nav-item"><a class="nav-link" href="moduleList.php">Module</a></li>
                    <li class="nav-item"><a class="nav-link" href="chapterList.php">Chapter</a></li>
                    <li class="nav-item"><a class="nav-link" href="questionnaire.php">Questionnaire</a></li>
                    <li class="nav-item"><a class="nav-link" href="user.php">Students</a></li>
                    <li class="nav-item"><a class="nav-link" href="myAccount.php">My Account</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>   
                </ul>
            </div> 
        </div>         
    </nav>
	<div class="container-fluid">