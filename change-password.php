<?php

function main() {

extract($_REQUEST);
include 'dilg/cnt/join.php';
include 'global-functions.php';

$UID=$_SESSION['UID'];

$Password_encode = encrypt_decrypt('encrypt', $Password);

if(isset($_POST['Submit']))
{

$current_password=$_POST['current_password'];
$new_password=$_POST['new_password'];
$confirm_password=$_POST['confirm_password'];
$Password_encode = encrypt_decrypt('encrypt', $current_password );

if($current_password !='')
{

$Password_decode = encrypt_decrypt('encrypt', $new_password );


$password=mysqli_real_escape_string($conn,$new_password); 


$sel_userpwd=mysqli_query($conn,"select * from user where Password='$Password_encode' and id='$UID'"); 

if(mysqli_num_rows($sel_userpwd)>>0)
{
if ( strlen($new_password) < 6 or strlen($new_password) > 20 )
      {
        $error_msg="Password must be more than 6 char length and maximum 20 char length";
      }
 else {
            //for checking both password matches or not
      if ( $new_password <> $confirm_password )
      {
        $error_msg="Both passwords are not matching<BR>";
      } 
       else
      {
        if(mysqli_query($conn,"update user set Password='$Password_decode', UpdatedDate = NOW() where id='$UID'"))
      {
        $success_msg="Thanks Your password changed successfully.Please keep changing your password for better security";
      }
      }
    }

}
else
    {
        $error_msg="Please Enter Valid Current Password";
    }

}

}


?>
            <section class="content-header">
               <div class="header-icon">
                   <i class="hvr-buzz-out fa fa-list"></i>
               </div>
               <div class="header-title">
                  <h1>Change Password </h1>
                  
               </div>
            </section>
            <!-- Main content -->

              <section class="content">
               <div class="row">
                  <!-- Form controls -->
                  <div class="col-sm-12">
                     <div class="panel panel-bd lobidrag">
                       
                        <div class="panel-body">

                           <form action="#" method="post" enctype="multipart/form-data">
                            

                              <?php    if($success_msg !=''){ ?>
                            <div class=" alert alert-success alert-dismissible" role="alert">
                            
                                <strong> <?php echo $success_msg; ?></strong>

                        
                            </div><?php    } ?>

                              <?php    if($error_msg !=''){ ?>
                            <div class="alert alert-danger alert-dismissible" role="alert">
                            
                                <strong> <?php echo $error_msg; ?></strong>

                            </div><?php    } ?>
                              <div class="row">
                              <div class="col-sm-6">
                              <div class="form-group">
                                 <label>Current password </label>
                                 <input type="text" class="form-control"  id="current_password" name="current_password" required>
                              </div><br>
                              <div class="form-group">
                                 <label>New password </label>
                                 <input type="text" class="form-control" id="new_password" name="new_password"  required>
                              </div>
                            <br>
                              <div class="form-group">
                                 <label>Retype New password </label>
                                 <input type="text" class="form-control"  id="confirm_password" name="confirm_password" required>
                              </div><br>
                              
                           </div>
                           
                        </div>

                            <div class="reset-button" >
                              
                                 <!-- <a href="#" class="btn btn-success">Add</a> -->
                                 <input type="submit" name="Submit" class="submitbox btn btn-success" value="<? if($ID !='') {   echo  "Update"; } else echo "Change Password";?>" >
                              </div>
                           </form>
                        </div>
                     </div>
                  </div>
               </div>
            </section>


        

   <?php
   
}

include 'template.php';

?>
