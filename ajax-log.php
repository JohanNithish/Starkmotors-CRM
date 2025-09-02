<?php
extract($_REQUEST);
include 'dilg/cnt/join.php';
$ID=$_POST['id'];
$category=$_POST['category'];
date_default_timezone_set('Asia/Kolkata');
$currentTime = date('Y-m-d H:i:s');
?>
<style type="text/css">
#example_filter{
display: none;
}
</style>
<div class="table-responsive">
<table id="example" class="table table-striped table-bordered no-tbl-bdr" style="width:100%;border-collapse: separate;
    border-spacing: 0 10px;">
<thead>
<tr>
<th class="d-none">SNo</th>
<th class="d-none">Time</th>
<th class="d-none">Log Details</th>
</tr>
</thead>
<tbody>
<? 
$select_log=mysqli_query($conn,"select * from price_log where quotation_id='$ID' and category='$category' order by id desc ");
while($row_log=mysqli_fetch_array($select_log)){
		$Created_date=$created_date;
$quotation_id=$row_log['quotation_id'];
$product_name=$row_log['product_name'];
$type=$row_log['type'];
$Old_value=$row_log['old_value'];
if($Old_value!=''){
	$old_value=round($Old_value, 2);
}else{
	$old_value=0;
}
$New_value=$row_log['new_value'];
if($New_value!=''){
	$new_value=round($New_value, 2);
}else{
	$new_value=0;
}
$Total_amount=$row_log['total_amount'];
if($Total_amount!=''){
	$total_amount=round($Total_amount, 2);
}else{
	$total_amount=0;
}
$created_date=$row_log['created_date'];
$created_time=$row_log['created_time'];
if((strtotime($created_date)==strtotime(date('Y-m-d'))) && (strtotime($Created_date) != strtotime($created_date)) ){
?><tr><td class="d-none"><?=$sno=$sno+1; ?></td>
<td><h5 class="mb-0">Today<br><span class="log-date"><?=date('d-M-Y', strtotime($created_date));?></span></h5></td><td class="d-none"></td>
</tr><?
}
elseif((strtotime($created_date)==strtotime(date('Y-m-d',strtotime("-1 days")))) && (strtotime($Created_date) != strtotime($created_date))){
?><tr><td class="d-none"><?=$sno=$sno+1; ?></td>
<td><h5 class="mb-0">Yesterday<br><span class="log-date"><?=date('d-M-Y', strtotime($created_date));?></span></h5></td><td class="d-none"></td>
</tr><?
}
elseif(strtotime($Created_date) != strtotime($created_date)){
$DATE='';
?><tr><td class="d-none"><?=$sno=$sno+1; ?></td>
<td><h6 class="mb-0"><?=date('d-M-Y', strtotime($created_date));?></h6></td><td class="d-none"></td>
</tr><?
}
if($old_value!=$new_value){
if($type=='rate'){
	$Rs='₹';
}else{
	$Rs=' ';
}
if($type=='package' || $type=='gst'){
	$perc='%';
}else{
	$perc=' ';
}
if(($old_value=='' || $old_value==0) && $type=='rate'){$clrClass="bg-log-alter log-tbl-alter";
$imgNew='<div class="position-relative"><img src="assets/images/Our/new2.png" class="new-png"></div>'; 
$ClassBg='bg-log-alter';}else{$clrClass="bg-log-green log-tbl-green";
$imgNew='';
$ClassBg='bg-log-green';}
?>
<tr class="v-m">
<td class="d-none"><?=$sno=$sno+1; ?></td>
<td class="w-13 text-center <?=$ClassBg; ?>"><?=$imgNew;?><p class="mb-0"><?=date('h:i A', strtotime($created_time))?></p></td>
<td class="<?=$clrClass; ?> lh-18"><span class="mb-0 fw-500 product-clr"><?=$product_name; ?></span><br>
<p class="text-uppercase mb-0"><?=$type;?>: <?=$Rs.$old_value.$perc; ?> <i class="lni lni-arrow-right fw-bolder"></i> <span class="fw-500"><?=$Rs.$new_value.$perc; ?></span> | <?="₹".$total_amount; ?></p></td>
</tr>

<?} } ?>
</tbody>

</table>
</div>

<script>

$(document).ready(function() {
var table = $('#example').DataTable( {
lengthChange: false,
pageLength: 8,
} );
table.buttons().container()
.appendTo( '#example_wrapper .col-md-6:eq(0)' );
} );
</script>