<?php

function main() {
session_start();
extract($_REQUEST);
include 'dilg/cnt/join.php';
include 'global-functions.php';
$ID=$_GET['id'];
$act=$_GET['act'];
if($_SESSION['drawing']!='Login' ){header('Location:home.php');}
$delete_id=$_GET['delete_id'];
date_default_timezone_set('Asia/Kolkata');
$currentTime = date('Y-m-d H:i:s');
$sel_customer=mysqli_query($conn,"select * from customer where id = '$ID' order by id asc"); 
$row_customer = mysqli_fetch_array($sel_customer); 
$company_name=$row_customer['company_name'];
$customer_name=$row_customer['customer_name'];

if($act=='delete' && $delete_id>0) 
{
	$sel_documents=mysqli_query($conn,"select * from customer_drawing where id='$delete_id'  ");
	$row_documents=mysqli_fetch_array($sel_documents);
	unlink('uploads/'.$row_documents['file']);
$customer_DeleteValues = mysqli_query($conn,"delete from customer_drawing where id ='$delete_id' ");
if($customer_DeleteValues)
{
$alert_msg = 'Customer Drawing Deleted Successfully';
header('Location:view-drawing.php?id='.$ID.'&alert_msg='.$alert_msg);
}
else
{
$alert_msg = 'Could not able to delete try once again!!!';
}
}

?>
<link href="assets/css/tooltip.css" rel="stylesheet" />
<body >


<form action="#" method="post" enctype="multipart/form-data" name="form1">
<div class="row form-label">
<? if($msg !=''){ ?><div class="alert alert-success border-0 bg-success alert-dismissible fade show py-2">
<div class="d-flex align-items-center">
<div class="font-35 text-white"><i class="bx bxs-check-circle"></i>
</div>
<div class="ms-3">
<h6 class="mb-0 text-white">Success Alerts</h6>
<div class="text-white"><?=$msg; ?></div>
</div>
</div>
<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div> <? } ?>
<? if($alert_msg !=''){ ?> <div class="alert alert-danger border-0 bg-danger alert-dismissible fade show py-2">
<div class="d-flex align-items-center">
<div class="font-35 text-white"><i class="bx bxs-message-square-x"></i>
</div>
<div class="ms-3">
<h6 class="mb-0 text-white">Alerts</h6>
<div class="text-white"><?=$alert_msg; ?></div>
</div>
</div>
<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div> <? } ?>


<? $sel_document=mysqli_query($conn,"select * from customer_drawing where customer_id='$ID'  "); 
if(mysqli_num_rows($sel_document)>>0){ 
?>
<div class="col-xl-12">
	<div class="card-title justify-space-between d-flex align-items-center">
<h5 class="p-2 view-hdr rounded-2 fw-3"><?=$company_name." - <small class='fs-6'> (".$customer_name.")</small>" ?></h5>
<a href="customer-drawing-report.php" class="btn btn-danger">Back</a>
</div>

<hr>
<div class="card border-0 border-4 border-primary">
<div class="card-body p-5 pt-0"> 

<ul class="display-inline-block ps-0">
<? while($row_document=mysqli_fetch_array($sel_document)){ 
	$file_id=$row_document['id'];
$file=$row_document['file'];
$file_name=$row_document['file_name'];
$file_ext=strtolower(substr(strrchr($row_document['file'], "."), 1));
$title=$row_document['title'];
$status=$row_document['status'];
$created_datetime=$row_document['created_datetime'];
$ext = strtolower(substr(strrchr($files, "."), 1));

?>
<li class="text-center me-4 mt-4 dox-bdr">

<div>
<?=date('d-m-Y', strtotime($created_datetime))?>
</div>
<div class="position-relative d-flex flex-wrap justify-content-center align-items-end">
<a href="uploads/<?=$file;?>" target="_blank"><img src="assets/images/Our/dox.png" class="document-img" width="70px"></a>
<a href="javascript:void(0);" onClick="if(confirm('Are you sure want to delete this?')) { window.location.href='view-drawing.php?act=delete&id=<?=$ID ?>&delete_id=<?=$file_id ?> ' }" tooltip="Delete" ><small><i class="fadeIn animated bx bx-trash-alt imagetrash fs-13 mb-0 rounded-2"></i></small></a>
</div>
<? if($file_name!=''){ ?><p class="mt-2"><small><?=wordwrap($file_name, 25, "<br />\n").".pdf";?></small></p><? } ?>
<h6 class="mt-2"><?=wordwrap($title, 25, "<br />\n");?></h6>
</li>

<?}?>
</div>
</div>
</div>
<?}?>
</div>  

</div>
</form>


<script src="assets/js/app.js"></script>
<?php

}
include 'template.php';
?>