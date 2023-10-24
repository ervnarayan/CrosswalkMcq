<?php
  include('Examination.php');
  $exam = new Examination;
  $exam->admin_session_public();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Login | Crosswalk MCQs Drill</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="Js/jquery.min.js"></script>
    <script src="Js/parsley.js"></script>
    <script src="Js/popper.min.js"></script>
    <script src="Js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/style.css" />
</head>
<body class="loginBg">
  <!-- <div class="jumbotron text-center" style="margin-bottom:0; padding: 0.2rem 1rem;">
      <img src="logo.png" class="img-fluid" width="300" alt="Crosswalk MCQs Drill" />
  </div> -->
  <div class="container">
      <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6" style="margin-top:20px;">
          <span id="message">
          <?php if(isset($_GET['verified'])) { echo '<div class="alert alert-success">Your email has been verified, now you can login</div>';} ?>
          </span>
          <div class="card">
            <div class="card-header">Admin Login</div>
            <div class="card-body">
              <form method="post" id="admin_login_form">
                <div class="form-group">
                  <label>Enter Email Address</label>
                  <input type="text" name="admin_email_address" id="admin_email_address" class="form-control" />
                </div>
                <div class="form-group">
                  <label>Enter Password</label>
                  <input type="password" name="admin_password" id="admin_password" class="form-control" />
                </div>
                <div class="form-group">
                  <input type="hidden" name="page" value="login" />
                  <input type="hidden" name="action" value="login" />
                  <input type="submit" name="admin_login" id="admin_login" class="btn btn-info" value="Login" />
                </div>
              </form>
              <div align="center">
                <a href="register.php">Register</a>
              </div>
            </div>
          </div>
            
        </div>
        <div class="col-md-3">

        </div>
      </div>
  </div>

</body>
</html>

<script>

$(document).ready(function(){

  $('#admin_login_form').parsley();
  $('#admin_login_form').on('submit', function(event){
    event.preventDefault();
    $('#admin_email_address').attr('required', 'required');
    $('#admin_email_address').attr('data-parsley-type', 'email');
    $('#admin_password').attr('required', 'required');
    if($('#admin_login_form').parsley().validate()){
      $.ajax({
        url:"ajax_action.php",
        method:"POST",
        data:$(this).serialize(),
        dataType:"json",
        beforeSend:function(){
          $('#admin_login').attr('disabled', 'disabled');
          $('#admin_login').val('please wait...');
        },
        success:function(data){
          if(data.success){
            location.href="index.php";
          }else{
            $('#message').html('<div class="alert alert-danger">'+data.error+'</div>');
          }
          $('#admin_login').attr('disabled', false);
          $('#admin_login').val('Login');
        }
      });
    }
  });
});
</script>