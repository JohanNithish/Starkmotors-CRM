<?php
function main() { 
session_start();
extract($_REQUEST);
include 'dilg/cnt/join.php';
include 'global-functions.php';
$ID=$_GET['id'];
date_default_timezone_set('Asia/Kolkata');
$currentTime = date('Y-m-d H:i:s');
if($_SESSION['drawing']=='' ){header('Location:home.php');}

if($Submit=='Add')
{
$title = addslashes($title);
$filename11 = $_FILES['file']['name'];
$filesize11 = $_FILES['file']['size'];
if($filename11 !=''){
$ext1 = strtolower(substr(strrchr($filename11, "."), 1));
if($ext1 == 'pdf' || $ext1 == 'jpg' || $ext1 == 'png' || $ext1 == 'jpeg' || $ext1 == 'webp'){
$image_size1 = ($filesize11 / 1024);
      $path1 = time().''.str_replace(" ","",$filename11);
      $file_path1 = "uploads/customer-drawing/".$path1;
      $up_path1 = "customer-drawing/".$path1;
      copy($_FILES['file']['tmp_name'],$file_path1);
      $file_name=pathinfo($filename11, PATHINFO_FILENAME);
      $img_subqry = " , file = '$up_path1', file_name = '$file_name'";

$insert_customer=mysqli_query($conn,"INSERT INTO customer_drawing set customer_id = '$customer_id', title = '$title',  status = '1',  created_by = ".$_SESSION['UID'].", created_datetime = '$currentTime' $img_subqry");
if($insert_customer)
{
$msg = 'Customer Drawing Added Successfully';
header('Location:view-drawing.php?id='.$customer_id.'&msg='.$msg);
}
else
{
$alert_msg = 'Could not able to add try once again!!!';
  // header('Location:manage-customer.php?alert_msg='.$alert_msg);
}
}else
{
$alert_msg = 'Use only Image or PDF';
}
}

}



?>
<script language="javascript">

function chStatus(id,st){
            $.ajax({
            url:'manage-customer.php',
            data:'act=ust&id='+id+"&status="+st,      
            type:'POST',
            success:function(data){  
            drwStatus(id, st)
            }        
         });
}</script>
 <script>
function drwStatus(id, St){

   if(St=='1'){
     
      document.getElementById("spSt"+id).innerHTML = '<span style="cursor:pointer" onclick="chStatus(\''+id+'\',\'0\')" title="Click To Change Active" class="btn btn-success padx-5 radius-30">Active</span>';
   }  
   else{
       document.getElementById("spSt"+id).innerHTML = '<span style="cursor:pointer" onclick="chStatus(\''+id+'\',\'1\')" title="Click To change Inactive" class="btn btn-danger padx-5 radius-30">Inactive</span>';
     
   }
}
 </script>



<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
<div class="breadcrumb-title pe-3">Reports</div>
<div class="ps-3">
<nav aria-label="breadcrumb">
<ol class="breadcrumb mb-0 p-0">
<li class="breadcrumb-item"><a href="home.php"><i class="bx bx-home-alt color-af251c"></i></a>
</li>
<li class="breadcrumb-item active" aria-current="page">Customer Drawing Report</li>
</ol>
</nav>
</div>
</div>
<hr/>
<?  $select_customer=mysqli_query($conn,"select * from customer order by id desc "); 
if(mysqli_num_rows($select_customer)>>0){ 
?>
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
<div class="card">
<div class="card-body">
<div class="table-responsive">
<table id="example" class="table table-striped table-bordered" style="width:100%">
<thead>
<tr>
<!-- <th>Date</th> -->
<th class="d-none">SNo</th>
<th>Customer Type</th>
<th>Company Details</th>
<th>Customer Details</th>
<th>Add</th>
<th>View</th>
</tr>
</thead>
<tbody>
<?   
$SNo = 0;
while($row_customer=mysqli_fetch_array($select_customer))
{ 
$SNo = $SNo + 1; 
$id=$row_customer['id'];
$company_name=$row_customer['company_name'];
$customer_name=$row_customer['customer_name'];
$customer_type=$row_customer['customer_type'];
$gst=$row_customer['gst'];
$address=$row_customer['address'];
$mobile=$row_customer['mobile'];
$email=$row_customer['email'];
$pan=$row_customer['pan'];
$state=$row_customer['state'];
$pin_code=$row_customer['pin_code'];
$created_datetime=$row_customer['created_datetime'];
$status=$row_customer['status'];
$target_amount=$row_customer['target_amount'];
if($target_amount!=''){
  $Target_amount="₹".$target_amount;
}    
if($pin_code!=''){
  $Pin_code=" - ".$pin_code;
}  
// if($state!=''){
//   $state="<br>".$state;
// }   
?>
<tr>

<td class="d-none"><?=$SNo; ?></td>
<td><?=$customer_type; ?></td>
<td><?if($company_name!='') echo '<b>'.$company_name.'</b>'; else echo "--"; ?>
  <?if($gst!='') echo '<br>'.$gst; if($pan!='') echo '<br>'.$pan; ?>
</td>
<td><?=$customer_name; ?><br><?=$mobile; ?><br><?=$email; ?></td>

<td>
<a href="#" class="btn btn-add btn-sm" tooltip="Add" data-bs-toggle="modal" data-bs-target="#exampleExtraLargeModal" onClick="getedit(<?=$id; ?>)"><img src="assets/images/Our/plus2.png" width="27px;"></a>
</td>
<td>
<div class="d-flex order-actions">
<a href="view-drawing.php?id=<?=$id;?>" class="btn btn-add btn-sm" tooltip="View"><i class="lni lni-eye"></i></a>
</div>
</td>
</tr>
<? } ?>
</tbody>
</table>
</div>
</div>
</div>
<? } else { echo "No Records Found";  } ?>

<div class="modal fade" id="exampleExtraLargeModal" tabindex="-1" aria-hidden="true">
<div class="modal-dialog modal-x">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
<div class="card border-top border-0 border-4 border-primary">
<div class="card-body p-5">

<div id="output"></div>
</div>
</div>
</div>

</div>
</div>
</div>



<script>
function getedit(val){

$.ajax({
url: "ajax-modal.php", 
type: "POST",
data: "id="+val+"&act=drawing",
success: function(result){
$("#output").html(result);
}});
}
</script>   
<?php
}
include 'template.php';
?>