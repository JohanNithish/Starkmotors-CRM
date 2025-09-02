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

if($ID !='') {
$select_qry=mysqli_query($conn,"select * from product where id='$ID' "); 
$row_R=mysqli_fetch_array($select_qry);
foreach($row_R as $K1=>$V1) $$K1 = $V1;
}
?>

<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
<div class="breadcrumb-title pe-3">Manage Product</div>
<div class="ps-3">
<nav aria-label="breadcrumb">
<ol class="breadcrumb mb-0 p-0">
<li class="breadcrumb-item"><a href="home.php"><i class="bx bx-home-alt color-af251c"></i></a>
</li>
<li class="breadcrumb-item active" aria-current="page"><? if($ID ==''){echo "Add";}else{echo "Update";}?> Product</li>
</ol>
</nav>
</div>

</div>
<h6 class="mb-0 text-uppercase"><? if($ID ==''){echo "Add";}else{echo "Update";}?> Product</h6>
<hr/>

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
<form action="#" method="post" class="row g-3" enctype="multipart/form-data">

<div class="col-md-6">
<label for="inputFirstName" class="form-label">Product Name</label>
<input type="text" name="product" id="product" class="form-control" value="<?=$product;?>" placeholder="Product Name" required>
<input type="hidden" name="MainId" value="<?=$ID;?>">
</div>

<div class="col-md-3">
<label for="inputFirstName" class="form-label">OEM Price</label>
<input type="number" name="oem" id="oem" class="form-control" step="any" value="<?=$oem;?>" placeholder="OEM Price">
<input type="hidden" name="MainId" value="<?=$ID;?>">
</div>
<div class="col-md-3">
<label for="inputFirstName" class="form-label">Dealer Price</label>
<input type="number" name="dealer" id="dealer" class="form-control" step="any" value="<?=$dealer;?>" placeholder="Dealer Price" >
</div>
<div class="col-md-3">
<label for="inputFirstName" class="form-label">Retailer Price</label>
<input type="number" name="retailer" id="retailer" class="form-control" step="any" value="<?=$retailer;?>" placeholder="Retailer Price" >
</div>

<div class="col-md-3">
<label for="inputFirstName" class="form-label">Kw</label>
<input type="text" name="kw" id="kw" class="form-control" value="<?=$kw;?>" placeholder="Kw" >
</div>

<div class="col-md-3">
<label for="inputFirstName" class="form-label">Hp</label>
<input type="text" name="hp" id="hp" class="form-control" value="<?=$hp;?>" placeholder="Hp" >
</div>

<div class="col-md-3">
<label for="inputFirstName" class="form-label">Rpm</label>
<input type="text" name="rpm" id="rpm" class="form-control" value="<?=$rpm;?>" placeholder="Rpm" >
</div>
<div class="col-md-3">
<label for="inputFirstName" class="form-label">Volt</label>
<input type="text" name="volt" id="volt" class="form-control" value="<?=$volt;?>" placeholder="Volt" >
</div>
<div class="col-md-3">
<label for="inputFirstName" class="form-label">Type</label>
<input type="text" name="type" id="type" class="form-control" value="<?=$type;?>" placeholder="Type" >
</div>
<div class="col-md-3">
<label for="inputFirstName" class="form-label">Mounting</label>
<input type="text" name="mounting" id="mounting" class="form-control" value="<?=$mounting;?>" placeholder="Mounting" >
</div>
<div class="col-md-3">
<label for="inputFirstName" class="form-label">HSN Code</label>
<input type="text" name="hsn_code" id="hsn_code" class="form-control" value="<?=$hsn_code;?>" placeholder="HSN Code" >
</div>

<div class="col-md-3">
<label for="inputFirstName" class="form-label">INS.CL</label>
<input type="text" name="ins_cl" id="ins_cl" class="form-control" value="<?=$ins_cl;?>" placeholder="INS.CL" >
</div>

<div class="col-md-3">
<label for="inputFirstName" class="form-label">IP44/IP55</label>
<input type="text" name="degree" id="degree" class="form-control" value="<?=$degree;?>" placeholder="IP44/IP55" >
</div>

<div class="col-md-3">
<label for="inputFirstName" class="form-label">Frequency</label>
<input type="text" name="frequency" id="frequency" class="form-control" value="<?=$frequency;?>" placeholder="freq." >
</div>

<div class="col-md-3">
<label for="inputFirstName" class="form-label">Frame</label>
<input type="text" name="frame" id="frame" class="form-control" value="<?=$frame;?>" placeholder="Frame" >
</div>

<div class="col-md-3">
<label for="inputFirstName" class="form-label">Model</label>
<input type="text" name="model" id="model" class="form-control" value="<?=$model;?>" placeholder="Model" >
</div>

<div class="col-md-3">
<label for="inputFirstName" class="form-label">Efficiency</label>
<input type="text" name="efficiency" id="efficiency" class="form-control" value="<?=$efficiency;?>" placeholder="Efficiency" >
</div>

<div class="col-md-3">
<label for="inputFirstName" class="form-label">Special Requirements</label>
<input type="text" name="special_requirements" id="special_requirements" class="form-control" value="<?=$special_requirements;?>" placeholder="Reqs." >
</div>


<div class="col-md-12">
<label for="inputAddress" class="form-label width-100" >Status</label>
<div class="form-check form-check-inline">
<input class="form-check-input" type="radio" name="status" id="inlineRadio1" value="1" <? if($status =='1' || $status=='') { echo 'checked'; } ?>>
<label class="form-check-label" for="inlineRadio1">Active</label>

</div>
<div class="form-check form-check-inline">
<input class="form-check-input" type="radio" name="status" id="inlineRadio2" value="0" <? if($status =='0') { echo 'checked'; } ?>>
<label class="form-check-label" for="inlineRadio2">Inactive</label>
</div>

</div>

<div class="col-6">
<input type="submit" name="Submit" class="btn btn-primary px-5" value="<? if($ID ==''){echo "Add";}else{echo "Update";}?>" >
</div>


</form>
</div>
</div>



<?php
}
include 'template.php';
?>