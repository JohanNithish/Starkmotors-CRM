<?php
function main() { 
extract($_REQUEST);
include 'dilg/cnt/join.php';
include 'global-functions.php';
$ID=$_GET['id'];
date_default_timezone_set('Asia/Kolkata');
$currentTime = date('Y-m-d H:i:s');
$product = addslashes($product);
if($Submit=='Add')
{
$check_select=mysqli_query($conn,"select * from customer where mobile='$mobile' "); 
  if(mysqli_num_rows($check_select)==0){
if($target_amount==0 || $target_amount==''){
  $target_amount=0;
}
$insert_customer=mysqli_query($conn,"INSERT INTO customer set company_name = '$company_name', customer_name = '$customer_name', customer_type = '$customer_type', gst = '$gst', address = '$address', state = '$state', pin_code = '$pin_code', mobile = '$mobile', email = '$email', pan = '$pan', status = '$status', target_amount = '$target_amount', created_by = ".$_SESSION['UID'].", created_datetime = '$currentTime'");
if($insert_customer)
{
$msg = 'Customer Details Added Successfully';
header('Location:manage-customer.php?msg='.$msg);
}
else
{
$alert_msg = 'Could not able to add try once again!!!';
  header('Location:manage-customer.php?alert_msg='.$alert_msg);
}

}else{
  $alert_msg = 'Mobile number already exists!!!';
    header('Location:manage-customer.php?alert_msg='.$alert_msg);
}

}
if($Submit=='Update')
{
  if($target_amount==0|| $target_amount==''){
  $target_amount=0;
}
    $check_select=mysqli_query($conn,"select * from customer where mobile='$mobile' "); 
  if(mysqli_num_rows($check_select)==0 || $old_mobile==$mobile ){
$update_customer=mysqli_query($conn,"update customer set company_name = '$company_name', customer_name = '$customer_name', customer_type = '$customer_type', gst = '$gst', address = '$address', state = '$state', pin_code = '$pin_code', mobile = '$mobile', email = '$email', pan = '$pan', status = '$status',  target_amount = '$target_amount', modified_datetime ='$currentTime'  where id='$MainId' ");
if($update_customer)
{
$msg = 'Customer Details Updated Successfully';
header('Location:manage-customer.php?msg='.$msg);
}
else
{
$alert_msg = 'Could not able to update try once again!!!';
  header('Location:manage-customer.php?alert_msg='.$alert_msg);
}
}else{
  $alert_msg = 'Mobile number already exists!!!';
    header('Location:manage-customer.php?alert_msg='.$alert_msg);
}
}

if($act=='delete' && $ID>0) 
{
$customer_DeleteValues = mysqli_query($conn,"delete from customer where id ='$ID' ");
if($customer_DeleteValues)
{
$alert_msg = 'Customer Details Deleted Successfully';
header('Location:manage-customer.php?alert_msg='.$alert_msg);
}
else
{
$alert_msg = 'Could not able to delete try once again!!!';
header('Location:manage-customer.php?alert_msg='.$alert_msg);
}
}


if($_POST['act']=='ust')
{
   ob_clean();
   if($id != '' && $status != '')
   {
      $rs_UpdReg = mysqli_query($conn,"update customer set status = '$status' where id = '$id'");
   }
   ?>
<?
    $rs_SelReg = mysqli_query($conn,"select * from customer where id = '$id'");
   if(mysqli_num_rows($rs_SelReg)>0)
   {
      $rows_Reg = mysqli_fetch_array($rs_SelReg);
   }        
   ?>
<script>drwStatus('<?=$rows_Reg['id']?>', '<?=$rows_Reg['status']?>')</script>
<?
   exit();
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
<div class="breadcrumb-title pe-3">Manage Customer</div>
<div class="ps-3">
<nav aria-label="breadcrumb">
<ol class="breadcrumb mb-0 p-0">
<li class="breadcrumb-item"><a href="home.php"><i class="bx bx-home-alt color-af251c"></i></a>
</li>
<li class="breadcrumb-item active" aria-current="page">List Customer</li>
</ol>
</nav>
</div>
<div class="ms-auto">
<div class="col">
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleExtraLargeModal" onClick="getedit(0)">Add Customer</button>
<!-- Modal -->
</div>
</div>
</div>
<h6 class="mb-0 text-uppercase">List Customer</h6>
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
<th>Customer Type & <br>Target Amount</th>
<th>Company Details</th>
<th>Customer Details</th>
<th>Address</th>
<th>Status</th>
<th>Action</th>
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
<td><?=$customer_type; ?><br><? if($target_amount>0){echo$Target_amount;} ?></td>
<td><?if($company_name!='') echo '<b>'.$company_name.'</b>'; else echo "--"; ?>
  <?if($gst!='') echo '<br>'.$gst; if($pan!='') echo '<br>'.$pan; ?>
</td>
<td><?=$customer_name; ?><br><?=$mobile; ?><br><?=$email; ?></td>
<td><?=wordwrap($address, 30, "<br/>\n").' '.$state.$Pin_code; ?></td>
<td><div id="spSt<?=$id?>"></div>
            <script>drwStatus('<?=$id?>', '<?=$status?>')</script></td>
<td>
<div class="d-flex order-actions">
<a href="#" class="btn btn-add btn-sm" tooltip="Edit" data-bs-toggle="modal" data-bs-target="#exampleExtraLargeModal" onClick="getedit(<?=$id; ?>)"><i class="bx bxs-edit"></i></a>
<a href="#" class="ms-3" data-toggle="modal" tooltip="Delete" data-target="#customer2" onClick="if(confirm('Are you sure want to delete this?')) { window.location.href='manage-customer.php?act=delete&id=<?=$id ?> ' }"><i class="bx bxs-trash"></i></a>
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
<div class="modal-dialog modal-xl">
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
data: "id="+val+"&act=customer",
success: function(result){
$("#output").html(result);
}});
}
</script>   
<?php
}
include 'template.php';
?>