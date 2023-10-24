<!DOCTYPE html>
<html lang="en">
<head>
  	<title>Crosswalk MCQs Drill</title>
  	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="assets/images/favicon.png"/>
  	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/dataTables.bootstrap4.min.css">
  	<script src="assets/Js/jquery.min.js"></script>
  	<script src="assets/Js/parsley.js"></script>
  	<script src="assets/Js/popper.min.js"></script>
  	<script src="assets/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="assets/Js/dataTables.bootstrap4.min.js"></script>
  	<link rel="stylesheet" href="assets/css/style.css" />
    <link rel="stylesheet" href="assets/css/TimeCircles.css" />
    <script src="assets/Js/TimeCircles.js"></script>
</head>
<body style="overflow-y:scroll;">
  <?php if(isset($_SESSION['user_id'])) {?>
  <nav class="navbar navbar-expand-sm bg-dark navbar-dark">

  <div class="col-md-2">
    <a class="navbar-brand" href="index.php">Dashboard</a>
  </div>
  <div class="col-md-3 offset-md-7">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
    <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="collapsibleNavbar">
      <ul class="navbar-nav">

        <li class="nav-item">
          <a class="nav-link" href="javascript:;"><?=@$_SESSION['user_name']; ?> (<?=@$_SESSION['batch_code']; ?>)</a>
        </li>
        
        <!-- <li class="nav-item">
          <a class="nav-link" href="profile.php">Profile</a>
        </li> -->

        <!-- <li class="nav-item">
          <a class="nav-link" href="enroll_exam.php">Enroll Exam</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="change_password.php">Change Password</a>
        </li> -->
        <li class="nav-item">
          <a class="nav-link" href="logout.php">Logout</a>
        </li>    
      </ul>
    </div>  
  </div>

  </nav>

  <div class="container-fluid">
  <?php } ?>
