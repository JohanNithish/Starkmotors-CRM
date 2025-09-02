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
$insert_product=mysqli_query($conn,"INSERT INTO product set product = '$product', oem = '$oem', dealer = '$dealer', retailer = '$retailer', kw='$kw', hp='$hp', rpm='$rpm', volt='$volt', type='$type', mounting='$mounting', hsn_code='$hsn_code', ins_cl='$ins_cl', degree='$degree', frequency='$frequency', frame='$frame', special_requirements='$special_requirements', efficiency='$efficiency', model='$model', status = '$status',  created_by = ".$_SESSION['UID'].", created_datetime = '$currentTime'  ");
if($insert_product)
{
$msg = 'Product Added Successfully';
header('Location:manage-product.php?msg='.$msg);
}
else
{
$alert_msg = 'Could not able to add try once again!!!';
}
}
if($Submit=='Update')
{
$update_product=mysqli_query($conn,"update product set product = '$product', oem = '$oem', dealer = '$dealer', retailer = '$retailer', kw='$kw', hp='$hp', rpm='$rpm', volt='$volt', type='$type', mounting='$mounting', hsn_code='$hsn_code', ins_cl='$ins_cl', degree='$degree', frequency='$frequency', frame='$frame', special_requirements='$special_requirements', efficiency='$efficiency', model='$model', status = '$status', modified_datetime ='$currentTime'  where id='$MainId' ");

if($update_product)
{
$msg = 'Product Updated Successfully';
header('Location:manage-product.php?msg='.$msg);
}
else
{
$alert_msg = 'Could not able to update try once again!!!';
}
}
if($act=='delete' && $ID>0) 
{
$product_DeleteValues = mysqli_query($conn,"delete from product where id ='$ID' ");
if($product_DeleteValues)
{
$alert_msg = 'Product Details Successfully';
header('Location:manage-product.php?alert_msg=$alert_msg'.$alert_msg);
}
else
{
$alert_msg = 'Could not able to delete try once again!!!';
header('Location:manage-product.php?alert_msg='.$alert_msg);
}
}


if($_POST['act']=='ust')
{
   ob_clean();
   if($id != '' && $status != '')
   {
      $rs_UpdReg = mysqli_query($conn,"update product set status = '$status' where id = '$id'");
   }
   ?>
<?
    $rs_SelReg = mysqli_query($conn,"select * from product where id = '$id'");
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
            url:'manage-product.php',
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
<div class="breadcrumb-title pe-3">Manage Product</div>
<div class="ps-3">
<nav aria-label="breadcrumb">
<ol class="breadcrumb mb-0 p-0">
<li class="breadcrumb-item"><a href="home.php"><i class="bx bx-home-alt color-af251c"></i></a>
</li>
<li class="breadcrumb-item active" aria-current="page">List Product</li>
</ol>
</nav>
</div>
<div class="ms-auto">
<div class="col">
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleExtraLargeModal" onClick="getedit(0)">Add Product</button>
<!-- Modal -->
</div>
</div>
</div>
<h6 class="mb-0 text-uppercase">List Product</h6>
<hr/>
<?  $select_product=mysqli_query($conn,"select * from product order by id desc "); 
if(mysqli_num_rows($select_product)>>0){ 
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
<th>Product<br>Name</th>
<th>OEM<br>Price</th>
<th>Dealer<br>Price</th>
<th>Retailer<br>Price</th>
<th>HSN<br>Code</th>
<th>Metrics</th>
<th>Status</th>
<th>Action</th>
</tr>
</thead>
<tbody>
<?   
$SNo = 0;
while($row_product=mysqli_fetch_array($select_product))
{ 
$SNo = $SNo + 1; 
$id=$row_product['id'];
$product=$row_product['product'];
$oem=$row_product['oem'];
$dealer=$row_product['dealer'];
$retailer=$row_product['retailer'];
$status=$row_product['status'];
$hsn_code=$row_product['hsn_code'];
$created_datetime=$row_product['created_datetime'];
if($row_product['kw']!=''){ $kw="<span class=\"fw-500\">  Kw: </span>".$row_product['kw'].",";}else{$kw="";}
if($row_product['hp']!=''){ $hp="<span class=\"fw-500\">  Hp: </span>".$row_product['hp'].",";}else{$hp="";}
if($row_product['rpm']!=''){ $rpm="<span class=\"fw-500\">  Rpm: </span>".$row_product['rpm'].",";}else{$rpm="";}
if($row_product['volt']!=''){ $volt="<span class=\"fw-500\">  Volt: </span>".$row_product['volt'].",";}else{$volt="";}
if($row_product['type']!=''){ $type="<span class=\"fw-500\">  Type: </span>".$row_product['type'].",";}else{$type="";}
if($row_product['mounting']!=''){ $mounting="<span class=\"fw-500\">  Mounting: </span>".$row_product['mounting'];}else{$mounting="";}
if($row_product['ins_cl']!=''){ $ins_cl="<span class=\"fw-500\">  INS.CL: </span>".$row_product['ins_cl'].",";}else{$ins_cl="";}
if($row_product['degree']!=''){ $degree="<span class=\"fw-500\">  IP44/IP55: </span>".$row_product['degree'].",";}else{$degree="";}
if($row_product['frequency']!=''){ $frequency="<span class=\"fw-500\">  Frequency: </span>".$row_product['frequency'].",";}else{$frequency="";}
if($row_product['frame']!=''){ $frame="<span class=\"fw-500\">  Frame: </span>".$row_product['frame'].",";}else{$frame="";}

if($row_product['model']!=''){ $model="<span class=\"fw-500\">  Model: </span>".$row_product['model'].",";}else{$model="";}
if($row_product['efficiency']!=''){ $efficiency="<span class=\"fw-500\">  Efficiency: </span>".$row_product['efficiency'].",";}else{$efficiency="";}
if($row_product['special_requirements']!=''){ $special_requirements="<span class=\"fw-500\">  Special Requirements: </span>".$row_product['special_requirements'].",";}else{$special_requirements="";}

if($kw!="" || $hp!="" || $rpm!="" || $volt!="" || $type!="" || $mounting!="" || $ins_cl!="" || $degree!="" ){
$metrics=rtrim($model.$kw.$hp,',');
$metrics.=rtrim("<br>".$rpm.$volt.$type,',');
$metrics.=rtrim("<br>".$mounting,',');
$metrics.=rtrim("<br>".$ins_cl.$degree,',');
$metrics.=rtrim("<br>".$frequency.$frame,',');
$metrics.=rtrim("<br>".$efficiency,',');
$metrics.=rtrim("<br>".$special_requirements,',');

}
else{
   $metrics="";
}
if($hsn_code==''){
   $hsn_code="--";
}
     
?>
<tr>

<td class="d-none"><?=$SNo; ?></td>
<td><?=$product; ?></td>
<td><?=$oem; ?></td>
<td><?=$dealer; ?></td>
<td><?=$retailer; ?></td>
<td><?=$hsn_code; ?></td>
<td><?=$metrics;?></td>
<td><div id="spSt<?=$id?>"></div>
            <script>drwStatus('<?=$id?>', '<?=$status?>')</script></td>
<td>
<div class="d-flex order-actions">
<a href="#" class="btn btn-add btn-sm" tooltip="Edit" data-bs-toggle="modal" data-bs-target="#exampleExtraLargeModal" onClick="getedit(<?=$id; ?>)"><i class="bx bxs-edit"></i></a>
<a href="#" class="ms-3" data-toggle="modal" tooltip="Delete" data-target="#customer2" onClick="if(confirm('Are you sure want to delete this?')) { window.location.href='manage-product.php?act=delete&id=<?=$id ?> ' }"><i class="bx bxs-trash"></i></a>
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
data: "id="+val+"&act=product",
success: function(result){
$("#output").html(result);
}});
}
</script>	
<?php
}
include 'template.php';
?>