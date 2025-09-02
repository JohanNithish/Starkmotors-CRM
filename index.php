<?php
ob_start();
ob_clean();
session_start();
extract($_REQUEST);
include 'dilg/cnt/join.php';
include 'global-functions.php';

$msg='';

if(isset($_SESSION['USERNAME']) || isset($_COOKIE['USERNAME'])){
$_SESSION['USERNAME'] = $_COOKIE['USERNAME'];
$_SESSION['UID'] = $_COOKIE['UID'];
$_SESSION['SName'] = $_COOKIE['CName'];
$_SESSION['Team'] = $_COOKIE['Team'];
header('location:home.php');
die();
}

if(isset($_POST['Login']))
{
$UserName=$_POST['username'];
$password=$_POST['password'];
$encrypted_password = encrypt_decrypt('encrypt', $password );
$login_select=mysqli_query($conn,"select * from  user where UserName = '$UserName' and Password = '$encrypted_password' ");
if(mysqli_num_rows($login_select)>>0){ 

$row=mysqli_fetch_array($login_select);

$status= $row['status']; 
if($status =="1"){ 

$_SESSION['USERNAME']=$row['UserName'];
$_SESSION['UID']=$row['Id'];
$_SESSION['USERTYPE']=$row['user_type'];
$_SESSION['SNAME']=$row['name'];
$_SESSION['Team']=$row['team'];
setcookie('CName',$row['name'],time()+60*60*24*30);
setcookie('USERNAME',$row['UserName'],time()+60*60*24*30);
setcookie('Team',$row['team'],time()+60*60*24*30);
setcookie('UID',$row['Id'],time()+60*60*24*30);
setcookie('USERTYPE',$row['user_type'],time()+60*60*24*30);
if($row['user_type']==0){
header('location:home.php');
}else{
header('location:add-quotation.php');
}

}
else{
$msg = "Account deactivated! Kindly contact your admin to reactivate!!!"; 
}
}
else
{
$msg = "Incorrect Username or Password";
}
}

?>

<html lang="en">

<head>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!--favicon-->
<link rel="icon" href="assets/images/Our/fav-icon-1.png" type="image/png" />
<!--plugins-->
<link href="assets/plugins/simplebar/css/simplebar.css" rel="stylesheet" />
<link href="assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet" />
<link href="assets/plugins/metismenu/css/metisMenu.min.css" rel="stylesheet" />
<!-- loader-->
<link href="assets/css/pace.min.css" rel="stylesheet" />
<script src="assets/js/pace.min.js"></script>

<link href="assets/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&amp;display=swap" rel="stylesheet">
<link href="assets/css/app.css" rel="stylesheet">
<link href="assets/css/icons.css" rel="stylesheet">
<title>Stark Motors</title>
</head>

<body class="bg-login">
<!--wrapper-->
<div class="wrapper">
<div class="section-authentication-signin d-flex align-items-center justify-content-center my-5 my-lg-0">
<div class="container-fluid">
<div class="row row-cols-1 row-cols-lg-2 row-cols-xl-3">
<div class="col mx-auto">
<div class="mb-4 text-center">
<img src="assets/images/Our/logo.png" style="width:150px;">
</div>
<div class="card">
<div class="card-body">
<div class="border p-4 rounded">
<div class="text-center">
<h3 class="">Admin Sign in</h3>

</div>

<div class="login-separater text-center mb-4"> <span>Login</span>
<hr/>
</div>

<div class="form-body">

<form action="#" class="row g-3" method="post">
<? if($msg !=''){ ?>	<div class="alert alert-danger border-0 bg-danger alert-dismissible fade show py-2">
<div class="d-flex align-items-center">
<div class="font-35 text-white"><i class="bx bxs-message-square-x"></i>
</div>
<div class="ms-3">
<h6 class="mb-0 text-white">Alerts</h6>
<div class="text-white"><?=$msg; ?></div>
</div>
</div>
<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div> <? } ?>
<div class="col-12">
<label for="inputEmailAddress" class="form-label">Enter Username</label>
<input type="text" name="username" class="form-control" id="inputEmailAddress" placeholder="Username">
</div>
<div class="col-12">
<label for="inputChoosePassword" class="form-label">Enter Password</label>
<div class="input-group" id="show_hide_password">
<input type="password" class="form-control border-end-0" id="inputChoosePassword" name="password" value="" placeholder="Enter Password"> <a href="javascript:;" class="input-group-text bg-transparent"><i class='bx bx-hide'></i></a>
</div>
</div>
<div class="col-md-6">
<div class="form-check form-switch">
<input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" checked>
<label class="form-check-label" for="flexSwitchCheckChecked">Remember Me</label>
</div>
</div>
<div class="col-md-6 text-end">	<a href="#" class="color-146236">Forgot Password ?</a>
</div>
<div class="col-12">
<div class="d-grid">

<button type="submit" class="btn btn-primary" name="Login"><i class="bx bxs-lock-open"></i>Sign in</button>
</div>
</div>
</form>
</div>
</div>
</div>
</div>
</div>
</div>
<!--end row-->
</div>
</div>
</div>

<script src="assets/js/bootstrap.bundle.min.js"></script>
<!--plugins-->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/plugins/simplebar/js/simplebar.min.js"></script>
<script src="assets/plugins/metismenu/js/metisMenu.min.js"></script>
<script src="assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
<!--Password show & hide js -->
<script>
$(document).ready(function () {
$("#show_hide_password a").on('click', function (event) {
event.preventDefault();
if ($('#show_hide_password input').attr("type") == "text") {
$('#show_hide_password input').attr('type', 'password');
$('#show_hide_password i').addClass("bx-hide");
$('#show_hide_password i').removeClass("bx-show");
} else if ($('#show_hide_password input').attr("type") == "password") {
$('#show_hide_password input').attr('type', 'text');
$('#show_hide_password i').removeClass("bx-hide");
$('#show_hide_password i').addClass("bx-show");
}
});
});
</script>
<!--app JS-->
<script src="assets/js/app.js"></script>
</body>

</html>