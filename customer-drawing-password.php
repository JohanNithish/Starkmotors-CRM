<?php

function main() {

extract($_REQUEST);
include 'dilg/cnt/join.php';
include 'global-functions.php';

$msg='';

if($_SESSION['drawing']=='Login' ){header('Location:customer-drawing-report.php');}

if(isset($_POST['Login']))
{
$password=$_POST['password'];
if($password =="stark@612"){ 
$_SESSION['drawing']="Login";
header('location:customer-drawing-report.php');
}
else
{
$msg = "Incorrect Password";
}
}


?>
            
            <!-- Main content -->

              <section class="content">
               <div class="row justify-content-center">
                  <!-- Form controls -->
                  <div class="col-sm-4 card bg-theme border-top border-0 border-4 border-primary wow fadeInUp">
                     <div class="panel panel-bd lobidrag pt-3 pb-4">
                       <div class="content-header">
               <div class="header-icon">
                   <i class="hvr-buzz-out fa fa-list"></i>
               </div>
               <div class="header-title">
                  <h1 class="text-center">Verify </h1>
                  
               </div>
            </div>
                        <div class="panel-body mt-3">

                           <form action="#" class="row g-3" method="post">
<? if($msg !=''){ ?>  <div class="alert alert-danger border-0 bg-danger alert-dismissible fade show py-2">
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
<label for="inputChoosePassword" class="form-label">Enter Password</label>
<div class="input-group" id="show_hide_password">
<input type="password" class="form-control border-end-0" id="inputChoosePassword" name="password" value="" placeholder="Enter Password"> <a href="javascript:;" class="input-group-text bg-transparent"><i class='bx bx-hide'></i></a>
</div>
</div>


<div class="col-12">
<div class="d-grid">

<button type="submit" class="btn btn-primary" name="Login">Submit</button>
</div>
</div>
</form>
                        </div>
                     </div>
                  </div>
               </div>
            </section>
<script src="assets/js/jquery.min.js"></script>

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
        

   <?php
   
}

include 'template.php';

?>
