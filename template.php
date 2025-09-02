<?
ob_start();
ob_clean();
session_start();
extract($_REQUEST);

$Pagename=basename($_SERVER['PHP_SELF']);
if($_SESSION['UID']=='' ) header('Location:index.php');

date_default_timezone_set('Asia/Kolkata');
$currentTime = date('Y-m-d H:i:s');

include 'dilg/cnt/join.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!--favicon-->
  <link rel="icon" href="assets/images/Our/fav-icon-1.png" type="image/png" />
     
    <?php include "top-includes.php"; ?>
   </head>
  <body>
  <!--wrapper-->
  <div class="wrapper">
 <?php include "side-bar.php";
  ?>
  <?php include "header.php"; ?>
  <div class="page-wrapper">
      <div class="page-content" <? if($Pagename == 'view-answer.php') { echo "style=
    background:#fff"; }
      ?>>
           <?php main(); ?>
         </div>
       </div>      
         <?php include "footer.php"; ?>
      </div>
     <?php include "bottom-includes.php"; ?>
   </body>
</html>