<?php

function main() {
extract($_REQUEST);
include 'dilg/cnt/join.php';
include 'global-functions.php';

$total_quotation=mysqli_query($conn,"SELECT COUNT(total_order_amount) AS tot_count, COALESCE(SUM(total_order_amount),0) AS value_sum FROM quotation"); 
$row_quotation=mysqli_fetch_array($total_quotation);

$pending_quotation=mysqli_query($conn,"SELECT COUNT(total_order_amount) AS pending_count, COALESCE(SUM(total_order_amount),0) AS pending_tot_amound FROM quotation WHERE status='Pending' "); 
$row_pending=mysqli_fetch_array($pending_quotation);

$total_sales=mysqli_query($conn,"SELECT COUNT(total_order_amount) AS tot_sales, COALESCE(SUM(total_order_amount),0) AS sales_amount FROM order_confirmation"); 
$row_sales=mysqli_fetch_array($total_sales);

$total_Dispatch=mysqli_query($conn,"SELECT COUNT(total_order_amount) AS tot_sales FROM order_confirmation where status='Approved' "); 

$total_unDispatch=mysqli_query($conn,"SELECT COALESCE(SUM(quantity - total_dispatch),0) as RemDispatch from ordered_products  ");
$row_Dispatch=mysqli_fetch_array($total_unDispatch);


$currentYear = date('Y');
$currentMonth = date('n');
if($currentMonth>=4){
$prvYear=$currentYear;
$currentYear=$currentYear+1;
}else{
$prvYear=$currentYear-1;
}

    
for($i=1; $i<=12; $i++)
  {
if ($i + 3 > 12) {
    $financial_month = $i - 9;
    $financial_year = $currentYear;
} else {
    $financial_month = $i + 3;
     $financial_year =$currentYear-1;
}
$month=date("M", mktime(0, 0, 0, $financial_month, 1));
$chart_total_quotation=mysqli_query($conn,"SELECT COUNT(total_order_amount) AS tot_chart, COALESCE(SUM(total_order_amount),0) AS value_sum FROM quotation where MONTH(created_datetime)='$financial_month' and YEAR(created_datetime)='$financial_year' "); 
$row_chart_quotation=mysqli_fetch_array($chart_total_quotation);

$chart_pending_quotation=mysqli_query($conn,"SELECT COUNT(total_order_amount) AS tot_chart, COALESCE(SUM(total_order_amount),0) AS value_sum FROM quotation where MONTH(created_datetime)='$financial_month' and YEAR(created_datetime)='$financial_year' and status='Pending' "); 
$row_pending_quotation=mysqli_fetch_array($chart_pending_quotation);

$chart_total_sales=mysqli_query($conn,"SELECT COUNT(total_order_amount) AS tot_chart, COALESCE(SUM(total_order_amount),0) AS value_sum FROM order_confirmation where MONTH(created_datetime)='$financial_month' and YEAR(created_datetime)='$financial_year' "); 
$row_chart_sales=mysqli_fetch_array($chart_total_sales);

$data2[]=array("label"=> $month, "y"=> $row_pending_quotation['value_sum']);
$data3[]=array("label"=> $month, "y"=> $row_chart_quotation['value_sum']);
$data4[]=array("label"=> $month, "y"=> $row_chart_sales['value_sum']);
  }
$dataPoints2 = $data2;
$dataPoints3 = $data3;
$dataPoints4 = $data4;


?>
<style type="text/css">
	.canvasjs-chart-credit{
		display: none;
	}
</style>

<div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">

<div class="col">
<div class="card radius-10 bg-success Packed">
<div class="card-body"><a href="list-quotation.php">
<div class="d-flex justify-space-between align-items-center">
<div>
<h6 class="mb-0 text-white dashboard-h">Total Quotation </h6>
<div class="d-flex gap-2 align-items-center">
<h4 class="my-1 text-white dashboard-num"><?=$row_quotation['tot_count'];?> |</h4>
<h5 class="text-white text-end m-0 dashboard-num">₹<?=round($row_quotation['value_sum'],1);?></h5>
</div>

</div>
<div class="widgets-icons bg-white"><i class="fadeIn animated text-dark bx bx-customize"></i>
</div>
</div></a>
</div>
</div>
</div>



<div class="col">
<div class="card radius-10 bg-success Shipped">
<div class="card-body"><a href="list-quotation.php?status=Pending">
<div class="d-flex justify-space-between align-items-center">
<div>
<h6 class="mb-0 text-white dashboard-h">Pending Quotation </h6>
<div class="d-flex gap-2 align-items-center">
<h4 class="my-1 text-white dashboard-num"><?=$row_pending['pending_count'];?> |</h4>
<h5 class="text-white text-end m-0 dashboard-num">₹<?=round($row_pending['pending_tot_amound'],1);?></h5>
</div>

</div>
<div class="widgets-icons bg-white"><i class="fadeIn animated text-dark bx bx-wallet"></i>
</div>
</div></a>
</div>
</div>
</div>



<div class="col">
<div class="card radius-10 bg-success Order">
<div class="card-body"><a href="list-sales.php?status=All">
<div class="d-flex justify-space-between align-items-center">
<div>
<h6 class="mb-0 text-white dashboard-h">Sales Order </h6>
<div class="d-flex gap-2  align-items-center">
<h4 class="my-1 text-white dashboard-num"><?=$row_sales['tot_sales'];?> |</h4>
<h5 class="text-white text-end m-0 dashboard-num">₹<?=round($row_sales['sales_amount'],1);?></h5>
</div>

</div>
<div class="widgets-icons bg-white"><i class="fadeIn animated text-dark bx bx-rupee"></i>
</div>
</div></a>
</div>
</div>
</div>


<div class="col">
<div class="card radius-10 bg-danger">
<div class="card-body"><a href="list-sales.php">
<div class="d-flex justify-space-between align-items-center">
<div>
<h6 class="mb-0 text-white dashboard-h">Pending Dispatch </h6>
<div class="d-flex gap-2 justify-space-between align-items-center">
<h4 class="my-1 text-white dashboard-num"><?=$row_Dispatch['RemDispatch']; ?><small class="fs-6"> items</small> </h4>
</div>

</div>
<div class="widgets-icons bg-white"><i class="fadeIn animated text-dark lni lni-delivery"></i>
</div>
</div></a>
</div>
</div>
</div>



</div>

<div id="chartContainer" class="mt-4" style="height: 400px; width: 100%;"></div>
<script src="assets/js/canvasjs.min.js"></script>

<script>
window.onload = function () {
 
var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	theme: "light2",
	title:{
		text: "<?=$prvYear." - ".$currentYear;?> Statistics",
		margin: 30
	},
	axisY:{
		includeZero: true,
		valueFormatString:	"#0,#0,##0.##"
	},
	dataPointWidth: 20,
toolTip:{
		shared: true
	},
	axisX:{
  title : "Monthly"
 },
	legend:{
		cursor: "pointer",
		verticalAlign: "bottom",
		horizontalAlign: "center",
		itemclick: toggleDataSeries
	},
	data: [{
		type: "column",
		color: "#4a2d70",  
		name: "Quotation Value",
		// indexLabel: "{y}",
		yValueFormatString: "₹#0,#0,##0.##",
		prefix: "₹",  
		showInLegend: true,
		dataPoints: <?php echo json_encode($dataPoints3, JSON_NUMERIC_CHECK); ?>
	},{
		type: "column",
		color: "#f5820c",  
		name: "Pending Quotation Value",
		// indexLabel: "{y}",
		yValueFormatString: "₹#0,#0,##0.##",
		prefix: "₹",  
		showInLegend: true,
		dataPoints: <?php echo json_encode($dataPoints2, JSON_NUMERIC_CHECK); ?>
	},{
		// visible: false,
		type: "column",
		color: "#1aa301", 
		name: "Sales Value",
		prefix: "₹", 
		// indexLabel: "{y}",
		yValueFormatString: "₹#0,#0,##0.##",
		showInLegend: true,
		dataPoints: <?php echo json_encode($dataPoints4, JSON_NUMERIC_CHECK); ?>
	}]
});
chart.render();
 
function toggleDataSeries(e){
	if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
		e.dataSeries.visible = false;
	}
	else{
		e.dataSeries.visible = true;
	}
	chart.render();
}
 
}
</script>

   <?php
   
}

include 'template.php';

?>