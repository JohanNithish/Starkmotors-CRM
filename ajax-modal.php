<?
extract($_REQUEST);
include 'dilg/cnt/join.php';
date_default_timezone_set('Asia/Kolkata');
$currentDate = date('Y-m-d');
$ID = $_POST['id'];


if($_POST['act']=='product') 
{ 
if($ID !='0') {
$select_qry=mysqli_query($conn,"select * from product where id='$ID' "); 
$row_R=mysqli_fetch_array($select_qry);
foreach($row_R as $K1=>$V1) $$K1 = $V1;
}
?>
<div class="card-title d-flex align-items-center">
<div><i class="bx bxs-user me-1 font-22 color-af251c"></i>
</div>
<h5 class="mb-0 text-primary color-af251c"><? if($ID !=''){echo "Add";}else{echo "Update";}?> Product</h5>
</div>
<hr>
<form action="#" method="post" class="row g-3" enctype="multipart/form-data">

<div class="col-md-12">
<label for="inputFirstName" class="form-label">Product Name</label>
<input type="text" name="product" id="product" class="form-control" value="<?=$product;?>" placeholder="Product Name" required>
<input type="hidden" name="MainId" value="<?=$ID;?>">
</div>

<div class="col-md-4">
<label for="inputFirstName" class="form-label">OEM Price</label>
<input type="number" name="oem" id="oem" class="form-control" step="any" value="<?=$oem;?>" placeholder="OEM Price">
<input type="hidden" name="MainId" value="<?=$ID;?>">
</div>
<div class="col-md-4">
<label for="inputFirstName" class="form-label">Dealer Price</label>
<input type="number" name="dealer" id="dealer" class="form-control" step="any" value="<?=$dealer;?>" placeholder="Dealer Price" >
</div>
<div class="col-md-4">
<label for="inputFirstName" class="form-label">Retailer Price</label>
<input type="number" name="retailer" id="retailer" class="form-control" step="any" value="<?=$retailer;?>" placeholder="Retailer Price" >
</div>

<div class="col-md-4">
<label for="inputFirstName" class="form-label">Model</label>
<input type="text" name="model" id="model" class="form-control" value="<?=$model;?>" placeholder="Model" >
</div>

<div class="col-md-4">
<label for="inputFirstName" class="form-label">Kw</label>
<input type="text" name="kw" id="kw" class="form-control" value="<?=$kw;?>" placeholder="Kw" >
</div>

<div class="col-md-4">
<label for="inputFirstName" class="form-label">Hp</label>
<input type="text" name="hp" id="hp" class="form-control" value="<?=$hp;?>" placeholder="Hp" >
</div>

<div class="col-md-4">
<label for="inputFirstName" class="form-label">Rpm</label>
<input type="text" name="rpm" id="rpm" class="form-control" value="<?=$rpm;?>" placeholder="Rpm" >
</div>
<div class="col-md-4">
<label for="inputFirstName" class="form-label">Volt</label>
<input type="text" name="volt" id="volt" class="form-control" value="<?=$volt;?>" placeholder="Volt" >
</div>
<div class="col-md-4">
<label for="inputFirstName" class="form-label">Type</label>
<input type="text" name="type" id="type" class="form-control" value="<?=$type;?>" placeholder="Type" >
</div>
<div class="col-md-4">
<label for="inputFirstName" class="form-label">Mounting</label>
<input type="text" name="mounting" id="mounting" class="form-control" value="<?=$mounting;?>" placeholder="Mounting" >
</div>
<div class="col-md-4">
<label for="inputFirstName" class="form-label">HSN Code</label>
<input type="text" name="hsn_code" id="hsn_code" class="form-control" value="<?=$hsn_code;?>" placeholder="HSN Code" >
</div>

<div class="col-md-4">
<label for="inputFirstName" class="form-label">INS.CL</label>
<input type="text" name="ins_cl" id="ins_cl" class="form-control" value="<?=$ins_cl;?>" placeholder="INS.CL" >
</div>

<div class="col-md-4">
<label for="inputFirstName" class="form-label">IP44/IP55</label>
<input type="text" name="degree" id="degree" class="form-control" value="<?=$degree;?>" placeholder="IP44/IP55" >
</div>

<div class="col-md-4">
<label for="inputFirstName" class="form-label">Frequency</label>
<input type="text" name="frequency" id="frequency" class="form-control" value="<?=$frequency;?>" placeholder="freq." >
</div>

<div class="col-md-4">
<label for="inputFirstName" class="form-label">Frame</label>
<input type="text" name="frame" id="frame" class="form-control" value="<?=$frame;?>" placeholder="Frame" >
</div>


<div class="col-md-4">
<label for="inputFirstName" class="form-label">Efficiency</label>
<input type="text" name="efficiency" id="efficiency" class="form-control" value="<?=$efficiency;?>" placeholder="Efficiency" >
</div>

<div class="col-md-5">
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
<input type="submit" name="Submit" class="btn btn-primary px-5" value="<? if($ID !='0') {   echo  "Update"; } else echo "Add";?>" >
</div>


</form>

<? }
if($_POST['act']=='price') 
{ 
if($ID !='0') {
$select_qry=mysqli_query($conn,"select * from price where id='$ID' "); 
$row_R=mysqli_fetch_array($select_qry);
foreach($row_R as $K1=>$V1) $$K1 = $V1;
}
?>
<div class="card-title d-flex align-items-center">
<div><i class="bx bxs-user me-1 font-22 color-af251c"></i>
</div>
<h5 class="mb-0 text-primary color-af251c"><? if($ID !=''){echo "Add";}else{echo "Update";}?> Product Price</h5>
</div>
<hr>
<form action="#" method="post" class="row g-3" enctype="multipart/form-data">

<div class="col-md-12">
<label for="inputFirstName" class="form-label">Select Product</label>
<select class="form-select" name="product" required>
<option value="">Select Product</option>
<? 
$sql=mysqli_query($conn,"select * from  product where status='1' ORDER BY product asc"); 
while($row=mysqli_fetch_array($sql))
{
	// $sql_exists=mysqli_query($conn,"select * from  price where status='1' ORDER BY product asc"); 
?>
<option value="<?=$row['id']?>" <? if($row['id'] == $product_id) { ?>selected<? } ?> ><?=$row['product'];?></option>
<?
}
?>
</select>

</div>

<div class="col-md-6">
<label for="inputFirstName" class="form-label">OEM Price</label>
<input type="number" name="oem" id="oem" class="form-control" step="any" value="<?=$oem;?>" placeholder="OEM Price">
<input type="hidden" name="MainId" value="<?=$ID;?>">
</div>
<div class="col-md-6">
<label for="inputFirstName" class="form-label">Dealer Price</label>
<input type="number" name="dealer" id="dealer" class="form-control" step="any" value="<?=$dealer;?>" placeholder="Dealer Price" >
</div>
<div class="col-md-6">
<label for="inputFirstName" class="form-label">Retailer Price</label>
<input type="number" name="retailer" id="retailer" class="form-control" step="any" value="<?=$retailer;?>" placeholder="Retailer Price" >
</div>

<div class="col-md-6">
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
<input type="submit" name="Submit" class="btn btn-primary px-5" value="<? if($ID !='0') {   echo  "Update"; } else echo "Add";?>" >
</div>


</form>

<? }
if($_POST['act']=='customer') 
{ 
if($ID !='0') {
$select_qry=mysqli_query($conn,"select * from customer where id='$ID' "); 
$row_R=mysqli_fetch_array($select_qry);
foreach($row_R as $K1=>$V1) $$K1 = $V1;
}
?>
<div class="card-title d-flex align-items-center">
<div><i class="bx bxs-user me-1 font-22 color-af251c"></i>
</div>
<h5 class="mb-0 text-primary color-af251c"><? if($ID !=''){echo "Add";}else{echo "Update";}?> Customer</h5>
</div>
<hr>
<form action="#" method="post" class="row g-3" enctype="multipart/form-data">

<div class="col-md-4">
<label for="inputAddress" class="form-label width-100" >Customer Type</label>
<div class="form-check form-check-inline">
<input class="form-check-input" type="radio" name="customer_type" id="customer_type1" value="OEM" <? if($customer_type =='OEM' || $customer_type=='') { echo 'checked'; } ?> required>
<label class="form-check-label" for="customer_type1">OEM</label>

</div>

<div class="form-check form-check-inline">
<input class="form-check-input" type="radio" name="customer_type" id="customer_type2" value="Dealer" <? if($customer_type =='Dealer') { echo 'checked'; } ?> required>
<label class="form-check-label" for="customer_type2">Dealer</label>
</div>

<div class="form-check form-check-inline">
<input class="form-check-input" type="radio" name="customer_type" id="customer_type3" value="Retailer" <? if($customer_type =='Retailer') { echo 'checked'; } ?> required>
<label class="form-check-label" for="customer_type3">Retailer</label>
</div>

</div>

<div class="col-md-4">
<label for="inputFirstName" class="form-label">Company Name</label>
<input type="text" name="company_name" id="company_name" class="form-control" value="<?=$company_name;?>" placeholder="Company Name">
<input type="hidden" name="MainId" value="<?=$ID;?>">
</div>

<div class="col-md-4">
<label for="inputFirstName" class="form-label">Contact Person Name</label>
<input type="text" name="customer_name" id="customer_name" class="form-control" value="<?=$customer_name;?>" placeholder="Customer Name" required>
</div>

<div class="col-md-4">
<label for="inputFirstName" class="form-label">Mobile</label>
<input type="text" name="mobile" id="mobile" aria-required="true" pattern="[0-9]{10}" oninput="this.value=this.value.replace(/[^0-9]/g,'');" maxlength="10" min="10" class="form-control" value="<?=$mobile;?>" placeholder="Mobile" required >
<input type="hidden" name="old_mobile" value="<?=$mobile;?>">
</div>

<div class="col-md-4">
<label for="inputFirstName" class="form-label">Email</label>
<input type="email" name="email" id="email" class="form-control" value="<?=$email;?>" placeholder="Email" required>
</div>

<div class="col-md-4">
<label for="inputFirstName" class="form-label">GST</label>
<input type="text" name="gst" id="gst" class="form-control" value="<?=$gst;?>" placeholder="GST">
</div>
<div class="col-md-4">
<label for="inputFirstName" class="form-label">Address</label>
<textarea class="form-control" id="exampleFormControlTextarea1" name="address" placeholder="Address.."><?=$address;?></textarea>
</div>

<div class="col-md-4">
<label for="inputFirstName" class="form-label">State</label>
<select class="form-select" name="state" required>
<option value="">Select State</option>
<? 
$sql=mysqli_query($conn,"select * from  state ORDER BY state asc"); 
while($row=mysqli_fetch_array($sql))
{
?>
<option value="<?=$row['state']?>" <? if($row['state'] == $state ) { ?>selected
<? }elseif($state=='' && $row['state']=='Tamil Nadu' && $ID=='0') {
echo "selected";} ?> ><?=$row['state'];?></option>
<?
}
?>
</select>
</div>

<div class="col-md-4">
<label for="inputFirstName" class="form-label">Pin Code</label>
<input type="text" name="pin_code" id="pin_code"  aria-required="true" pattern="[0-9]{6}" oninput="this.value=this.value.replace(/[^0-9]/g,'');" maxlength="6" min="6" class="form-control" value="<?=$pin_code;?>" placeholder="Pin Code" required>
</div>

<div class="col-md-4">
<label for="inputFirstName" class="form-label">PAN</label>
<input type="text" name="pan" id="pan" class="form-control" value="<?=$pan;?>" placeholder="PAN">
</div>

<div class="col-md-4">
<label for="inputFirstName" class="form-label">Target Amount</label>
<input type="number" name="target_amount" id="target_amount" class="form-control" value="<? if($target_amount>0){echo$target_amount;} ?>" placeholder="Target" >
</div>

<div class="col-md-4">
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

<div class="col-12">
<input type="submit" name="Submit" class="btn btn-primary px-5" value="<? if($ID !='0') {   echo  "Update"; } else echo "Add";?>" >
</div>


</form>

<? }
if($_POST['act']=='brand') 
{ 
if($ID !='0') {
$select_qry=mysqli_query($conn,"select * from brand where id='$ID' "); 
$row_R=mysqli_fetch_array($select_qry);
foreach($row_R as $K1=>$V1) $$K1 = $V1;
}
?>
<div class="card-title d-flex align-items-center">
<div><i class="bx bxs-user me-1 font-22 color-af251c"></i>
</div>
<h5 class="mb-0 text-primary color-af251c"><? if($ID !=''){echo "Add";}else{echo "Update";}?> Brand</h5>
</div>
<hr>
<form action="#" method="post" class="row g-3" enctype="multipart/form-data">

<div class="col-md-12">
<label for="inputFirstName" class="form-label">Brand Name</label>
<input type="text" name="brand_name" id="brand_name" class="form-control" value="<?=$brand_name;?>" placeholder="Brand Name" required>
<input type="hidden" name="MainId" value="<?=$ID;?>">
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
<input type="submit" name="Submit" class="btn btn-primary px-5" value="<? if($ID !='0') {   echo  "Update"; } else echo "Add";?>" >
</div>


</form>

<? }

if($_POST['act']=='remarks') 
{ 
// if($ID !='0') {
// $select_qry=mysqli_query($conn,"select * from customer_remarks where customer_id='$ID' "); 
// $row_R=mysqli_fetch_array($select_qry);
// $remarks = $row_R['remarks'];
// }
?>

<div class="card-title d-flex align-items-center">
<div><i class="bx bxs-user me-1 font-22 color-af251c"></i>
</div>
<h5 class="mb-0 text-primary color-af251c">Note Remarks</h5>
</div>
<hr>
<form action="#" method="post" class="row g-3" enctype="multipart/form-data">

<div class="col-md-12">
<label for="inputFirstName" class="form-label">Remarks</label>
<textarea type="text" name="remarks" class="form-control" value="" rows="5" placeholder="Remarks.." ><?=$remarks;?></textarea> 
<input type="hidden" name="MainId" value="<?=$ID;?>">
</div>


<div class="col-6">
<input type="submit" name="Submit" class="btn btn-primary px-5" value="Add" >
</div>


</form>

<? } 
if($_POST['act']=='overall_remarks') 
{ 
$table_name=$_POST['remarks_table'];
if($ID !='0' && $table_name!='') {
$select_qry=mysqli_query($conn,"select * from ".$table_name." where id='$ID' "); 
$row_R=mysqli_fetch_array($select_qry);
}
if($table_name!='delivery_challan'){
$remarks = $row_R['remarks'];
$Title= 'Note';
}else{
$remarks = $row_R['customer_remarks'];
$Title= 'Customer';
}
?>

<div class="card-title d-flex align-items-center">
<div><i class="bx bxs-user me-1 font-22 color-af251c"></i>
</div>
<h5 class="mb-0 text-primary color-af251c"><?=$Title;?> Remarks</h5>
</div>
<hr>
<form action="#" method="post" class="row g-3" enctype="multipart/form-data">

<div class="col-md-12">
<label for="inputFirstName" class="form-label"><?=$customer;?>Remarks</label>
<textarea type="text" name="remarks" class="form-control" value="" rows="5" placeholder="Remarks.." ><?=$remarks;?></textarea> 
<input type="hidden" name="MainId" value="<?=$ID;?>">
</div>


<div class="col-6">
<input type="submit" name="Submit" class="btn btn-primary px-5" value="Update" >
</div>


</form>

<? }
if($_POST['act']=='view_remarks') {
	?>
<table id="example3" class="table table-striped table-bordered " style="width:100%;">
<thead>
<tr>
<th class="d-none">SNo</th>
<th>Date & Time</th>
<th>Remarks</th>
<th>Action</th>
</tr>
</thead>
<tbody>

<?
$sno=0;
$select_log=mysqli_query($conn,"select * from customer_remarks where customer_id='$ID' order by id desc ");
while($row_log=mysqli_fetch_array($select_log)){
	$remarks_id=$row_log['id'];
$remarks=$row_log['remarks'];
$created_date=$row_log['created_date'];
$created_time=$row_log['created_time'];

?>
<tr>
<td class="d-none"><?=$sno=$sno+1; ?></td>
<td class="w-15"><?=date("d-m-Y", strtotime($created_date));?><br><?=date('h:i A', strtotime($created_time))?></td>
<td><?=$remarks;?></td>
<td class="order-actions w-6"><a href="#" class="" data-toggle="modal" tooltip="Delete"  data-target="#customer2" onClick="if(confirm('Are you sure want to delete this?')) { window.location.href='customer-wise-report.php?act=delete&id=<?=$remarks_id ?> ' }"><i class="bx bxs-trash"></i></a>
</td>
</tr>

<?}?>
</tbody>

</table><script src="assets/plugins/datatable/js/jquery.dataTables.min.js"></script>

<script>

$(document).ready(function() {
var table = $('#example3').DataTable( {
lengthChange: false,
pageLength: 10,
buttons: [ 'copy', 'excel', 'pdf', 'print']
});
table.buttons().container()
.appendTo( '#example3_wrapper .col-md-6:eq(0)' );
} );
</script>
<? }
if($_POST['act']=='projection') 
{ 
if($ID !='0') {
$select_qry=mysqli_query($conn,"select * from sales_projection where customer_id='$ID' and projection_month='".date('F')."' and projection_year='".date('Y')."' "); 
$row_R=mysqli_fetch_array($select_qry);
$id=$row_R['id'];
$amount=$row_R['amount'];
}
?>
<div class="card-title d-flex align-items-center">
<div><i class="bx bxs-user me-1 font-22 color-af251c"></i>
</div>
<h5 class="mb-0 text-primary color-af251c"><? if($amount==''){echo "Add";}else{echo "Update";}?> Sales Projection</h5>
</div>
<hr>
<form action="#" method="post" class="row g-3" enctype="multipart/form-data">

<div class="col-md-12">
<label for="inputFirstName" class="form-label">Projection Amount <span class="text-danger">(<?=date('F');?>)</span></label>
<input type="number" name="amount" id="amount" class="form-control" value="<?=$amount;?>" placeholder="Amount" required>
<input type="hidden" name="customer_id" value="<?=$ID;?>">
<input type="hidden" name="projection_month" value="<?=date('F');?>">
<input type="hidden" name="projection_year" value="<?=date('Y');?>">
<input type="hidden" name="MenuId" value="<?=$id;?>">
</div>

<div class="col-6">
<input type="submit" name="Submit" class="btn btn-primary px-3" value="<?if($amount==''){echo"Set";}else{echo"Update";}?>" >
</div>


</form>

<? } 
if($_POST['act']=='view_services') 
{  ?>

<? 
$sel_not_deiv=mysqli_query($conn,"select * from service_product where service_id = '$ID' and status='".$_POST['table_type']."'"); 
?>
<table class="table w-100 spc-tbl">
<thead>
<tr>
<!-- <th>Date</th> -->
<th class="d-none">SNo</th>
<th>Product Name</th>
<th>Motor Serial No</th>
<th>Invoice Number</th>
<th>Warranty</th>
<th><?if($_POST['table_type']=="Not Delivered"){ ?>Est. <?}?>Deliv. Date</th>
<th>Remarks</th>
</tr>
</thead>
<tbody>
<?   
$SNo = 0;
while($row_not_deiv=mysqli_fetch_array($sel_not_deiv))
{ 
$SNo = $SNo + 1; 
$dispatch_id=$row_not_deiv['dispatch_id'];
$product_name=$row_not_deiv['product_name'];
$brand_name=$row_not_deiv['brand_name'];
$motor_num=$row_not_deiv['motor_num'];
$invoice_num=$row_not_deiv['invoice_num'];
$warranty=$row_not_deiv['warranty'];
$remarks=$row_not_deiv['remarks'];
$estimated_date=$row_not_deiv['estimated_date'];
$delivery_date=$row_not_deiv['delivery_date'];

?>
<tr>

<td class="d-none"><?=$SNo; ?></td>
<td class="w-30" ><?=$product_name;?></td>
<td class="w-15"><?=$motor_num;?></td>
<td class="w-15"><?=$invoice_num;?></td>
<td class="w-10"><?=$warranty;?></td>
<td class="w-15"><?if($_POST['table_type']=="Not Delivered"){ echo date("d-m-Y", strtotime($estimated_date));}else{ echo date("d-m-Y", strtotime($delivery_date));}?></td>
<td><?=$remarks;?></td>
</tr>
<? } ?>
</tbody>
</table>

<? }  
if($_POST['act']=='dispatch_remarks') 
{ 
if($ID !='0') {
$select_qry=mysqli_query($conn,"select * from dispatch where id='$ID' "); 
$row_R=mysqli_fetch_array($select_qry);
foreach($row_R as $K1=>$V1) $$K1 = $V1;
}
?>

<div class="card-title d-flex align-items-center">
<div><i class="bx bxs-user me-1 font-22 color-af251c"></i>
</div>
<h5 class="mb-0 text-primary color-af251c">Note Remarks</h5>
</div>
<hr>
<form action="#" method="post" class="row g-3" enctype="multipart/form-data">

<div class="col-md-12">
<label for="inputFirstName" class="form-label">Remarks</label>
<textarea type="text" name="remarks" id="editor" class="form-control" value="" rows="5" placeholder="Remarks.." ><?=$remarks;?></textarea> 
<input type="hidden" name="MainId" value="<?=$ID;?>">
</div>


<div class="col-6">
<input type="submit" name="Submit" class="btn btn-primary px-5" value="Add" >
</div>


</form>
<script>
CKEDITOR.replace( 'editor');
  minHeight: '800px'
    </script>
<? }  if($_POST['act']=='drawing') 
{  
if($ID !='0') {
$select_qry=mysqli_query($conn,"select * from dispatch where id='$ID' "); 
$row_R=mysqli_fetch_array($select_qry);
foreach($row_R as $K1=>$V1) $$K1 = $V1;
}
?>

<div class="card-title d-flex align-items-center">
<div><i class="bx bxs-user me-1 font-22 color-af251c"></i>
</div>
<h5 class="mb-0 text-primary color-af251c">Add Drawing</h5>
</div>
<hr>
<form action="#" method="post" class="row g-3" enctype="multipart/form-data">

<div class="col-md-12">
<label for="inputFirstName" class="form-label">Title</label>
<input type="text" name="title" class="form-control" value="<?=$title;?>" placeholder="Title" >
<input type="hidden" name="customer_id" value="<?=$ID;?>">
</div>
<div class="col-md-12">
<label for="inputFirstName" class="form-label">File <small class="text-danger">(Only Image or PDF)</small></label>
<input type="file" name="file" class="form-control" value="<?=$file;?>" placeholder="File" >
</div>

<div class="col-6">
<input type="submit" name="Submit" class="btn btn-primary px-5" value="Add" >
</div>


</form>
<? } ?>