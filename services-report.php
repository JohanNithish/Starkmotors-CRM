<?php
function main() { 
extract($_REQUEST);
include 'dilg/cnt/join.php';
include 'global-functions.php';
$ID=$_GET['id'];
$Status=$_GET['status'];

date_default_timezone_set('Asia/Kolkata');
$currentTime = date('Y-m-d H:i:s');
$currentDate = date("Y-m-d");
if($act=='delete' && $ID>0) 
{
$services_DeleteValues = mysqli_query($conn,"delete from service where id ='$ID' ");
$services_ProductDelete = mysqli_query($conn,"delete from service_product where service_id ='$ID' ");
if($services_DeleteValues && $services_ProductDelete)
{
$alert_msg = 'Services Details Successfully';
header('Location:list-services.php?alert_msg='.$alert_msg);
}
else
{
$alert_msg = 'Could not able to delete try once again!!!';
header('Location:list-services.php?alert_msg='.$alert_msg);
}
}

if($status==''){
	$subquery_1 = " and status='In' ";
	$status="In";
}elseif($status=='All'){
	$subquery_1 = " ";
}else{
	$subquery_1 = " and status='$status' ";
}

if($fromDate !='' && $endDate !='')
{
$subquery_2 .=" and (date(service_date) BETWEEN '".$fromDate."' and '".$endDate."') order by id desc ";
}
else{
if (date("m") >= 4) {
    $fromDate = date("Y") . "-04-01";
    $endDate  = (date("Y") + 1) . "-03-31";
} else {
    $fromDate = (date("Y") - 1) . "-04-01";
    $endDate  = date("Y") . "-03-31";
}
$subquery_2 .=" and (date(service_date) BETWEEN '".$fromDate."' and '".$endDate."') order by id desc ";
}

 $select_Services=mysqli_query($conn,"select * from service where 1=1 $subquery_1 $subquery_2"); 

//  $select_total_services=mysqli_query($conn,"select (select count(status) from service_product where 1=1 $subquery_2) as TotalService, (select count(status) from service_product where 1=1 $subquery_1 $subquery_2) as ServiceVal ");
//  echo "select (select count(status) from service_product where 1=1 $subquery_2) as TotalService, (select count(status) from service_product where 1=1 $subquery_1 $subquery_2) as ServiceVal ";
// $row_total_services=mysqli_fetch_array($select_total_services);
// $TotalService=$row_total_services['TotalService'];
// $ServiceVal=$row_total_services['ServiceVal'];

// if($status=='All'){
// }else{
// "<h5>Total ".$status.": <small>".$ServiceVal."/".$TotalService."</small></h5>";
// }
?>

	
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
<div class="breadcrumb-title pe-3">Reports</div>
<div class="ps-3">
<nav aria-label="breadcrumb">
<ol class="breadcrumb mb-0 p-0">
<li class="breadcrumb-item"><a href="home.php"><i class="bx bx-home-alt color-af251c"></i></a>
</li>
<li class="breadcrumb-item active" aria-current="page">List Services</li>
</ol>
</nav>
</div>
</div>

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


<form action="services-report.php" class="" method="post">
<div class="d-flex gap-2">
<div class="mb-20">

<label for="inputAddress" class="form-label width-100" >Status</label>
<div class="form-check form-check-inline">
<input class="form-check-input" type="radio" name="status" onchange="getDate(this.value)" id="inlineRadio1" value="In" <? if($status =='In') { echo 'checked'; } ?>>
<label class="form-check-label" for="inlineRadio1">In</label>

</div>
<div class="form-check form-check-inline">
<input class="form-check-input" type="radio" name="status" id="inlineRadio2" onchange="getDate(this.value)" value="Out" <? if($status =='Out') { echo 'checked'; } ?>>
<label class="form-check-label" for="inlineRadio2">Out </label>
</div>

<div class="form-check form-check-inline">
<input class="form-check-input" type="radio" name="status" id="inlineRadio3" onchange="getDate(this.value)" value="All" <? if($status =='All') { echo 'checked'; } ?>>
<label class="form-check-label" for="inlineRadio3">All</label>
</div>

</div>
<div class="col-md-2 mb-20">
<label class="form-label">From Date</label>
<input type="date" class="result form-control" value="<?=$fromDate; ?>" id="fromDate" name="fromDate" required>

</div>
<div class="col-md-2 mb-20">
<label class="form-label">To Date</label>
<input type="date" class="result form-control" value="<?=$endDate; ?>" id="endDate"  name="endDate" required>

</div>

<div class="col-md-3 mb-20 align-self-end">
<input type="submit" class="btn btn-primary px-3" name="Submit" value="Submit">

</div>
</div> 
</form>
<div class="pb-3 d-flex gap-4"><?=$Show_Status;?></div>

<? 
if(mysqli_num_rows($select_Services)>>0){ 
?>
<div class="card srch-top">
<div class="card-body">
<div class="table-responsive">
<table id="example2" class="table table-striped table-bordered" style="width:100%">
<thead>
<tr>
<!-- <th>Date</th> -->
<th class="d-none">SNo</th>
<th>Service Date</th>
<th>Service ID</th>
<th>Customer Details</th>
<th>No. of In</th>
<th>No. of Out</th>
</tr>
</thead>
<tbody>
<?   
$SNo = 0;
while($row_services=mysqli_fetch_array($select_Services))
{ 
$SNo = $SNo + 1; 
$id=$row_services['id'];
$customer_name=$row_services['customer_name'];
$company_name=$row_services['company_name'];
$mobile=$row_services['mobile'];
$customer_type=$row_services['customer_type'];
$products_count=$row_services['products_count'];
$status=$row_services['status'];
$total_delivery=$row_services['total_delivery'];
$service_date=$row_services['service_date'];
$created_datetime=$row_services['created_datetime'];
   $remProduct=$products_count-$total_delivery;
?>
<tr>

<td class="d-none"><?=$SNo; ?></td>
<td class="w-10"><?=date("d-m-Y", strtotime($service_date));?></td>
<td>SRV<?=$id;?></td>

<td><?if($company_name!='')echo "<b>".$company_name."</b><br>"; ?><?=$customer_name; ?><br><?=$mobile; ?><br><?=$customer_type; ?></td>
<td><?=$remProduct;?> <?if($remProduct>>'1')echo "Items"; else echo "Item"; ?>
<? if($remProduct>>'0'){ ?>
	<a type="button" class="ms-1 text-dark" tooltip="In Products" data-bs-toggle="modal" data-bs-target="#exampleExtraLargeModal" onclick="getdetails(<?=$id;?>,'Not Delivered')"><i class="bx bx-info-circle"></i></a><?}?>
</td>
<td><?=$total_delivery;?> <?if($total_delivery>>'1')echo "Items"; else echo "Item"; ?>
<? if($total_delivery>>'0'){ ?>
	<a type="button" class="ms-1 text-dark" tooltip="Out Products" data-bs-toggle="modal" data-bs-target="#exampleExtraLargeModal" onclick="getdetails(<?=$id;?>,'Delivered')"><i class="bx bx-info-circle"></i></a>
	<?}?>
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
<div class="modal-header d-flex justify-space-between align-items-center">
<h5 class="mb-0" id="model-heading"></h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
<div class="card border-top border-0 border-4 border-primary">
<div class="card-body px-2 pb-2 pt-2">

<div id="output"></div>
</div>
</div>
</div>

</div>
</div>
</div>






<script>
function getdetails(val,table_type){
$("#model-heading").html(table_type);
$.ajax({
url: "ajax-modal.php", 
type: "POST",
data: "id="+val+"&act=view_services&table_type="+table_type,
success: function(result){
$("#output").html(result);
}});
}
</script>

<?php
}
include 'template.php';
?>