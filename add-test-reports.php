<?php
function main() { 
extract($_REQUEST);
include 'dilg/cnt/join.php';
include 'global-functions.php';
$ID=$_GET['id'];
$Act=$_GET['act'];
if($ID==""){
 header('Location:list-test-reports.php');
}
date_default_timezone_set('Asia/Kolkata');
$currentTime = date('Y-m-d H:i:s');
$currentDate = date('Y-m-d');

if($Submit=='Add')
{
$insert_report=mysqli_query($conn,"INSERT INTO test_report set dispatch_id='$ID', so_num='$so_num', machine_num='$machine_num', product='$product', type='$type', kw='$kw', hp='$hp', current='$current', rpm='$rpm', volt='$volt', customer_id='$customer_id', frequency='$frequency', efficiency='$efficiency', power_factor='$power_factor', connection='$connection', degree='$degree', duty='$duty', cd_s1_output='$cd_s1_output', ins_cl='$ins_cl', frame='$frame', ref_standard='$ref_standard', mounting='$mounting', hsn_code='$hsn_code', special_requirements='$special_requirements', direction='$direction', de_bearing='$de_bearing', nde_bearing='$nde_bearing', construction='$construction', t_box_position='$t_box_position', rotor_voltage='$rotor_voltage', rotor_current='$rotor_current', rotor_class='$rotor_class', a_c_heater='$a_c_heater', ptc='$ptc', rtd='$rtd', test_results='$test_results', test_polarity='$test_polarity', avg_res='$avg_res', amb_temp='$amb_temp', no_load_test='$no_load_test', no_load_polarity='$no_load_polarity', no_load_voltage='$no_load_voltage', no_load_current='$no_load_current', no_load_input_power='$no_load_input_power', reduced_voltage='$reduced_voltage', locked_rotor_test='$locked_rotor_test', locked_polarity='$locked_polarity', locked_voltage='$locked_voltage', locked_current1='$locked_current1', locked_current2='$locked_current2', locked_current3='$locked_current3', locked_input_power='$locked_input_power', high_voltage_test='$high_voltage_test', high_polarity='$high_polarity', high_voltage='$high_voltage', duration='$duration', remarks='$remarks', insulation_resistance_test='$insulation_resistance_test', winding='$winding', insulation_resistance='$insulation_resistance', remarks_main='$remarks_main', description='$description', checked_by='$checked_by', test_date='$test_date',  cyc='$cyc', flc='$flc', rating='$rating', phase='$phase', resistance='$resistance', min_voltage='$min_voltage', hvt='$hvt', before_hvt='$before_hvt', after_hvt='$after_hvt', volt_acw='$volt_acw', test_cw='$test_cw', no_load_v='$no_load_v', no_load_i='$no_load_i', no_load_w='$no_load_w', starting_torque='$starting_torque', starting_current='$starting_current', status = '$status', created_by = ".$_SESSION['UID'].", created_datetime = '$currentTime'");

//$rs_InsValues=mysqli_query($conn,"update dispatch set test_report= test_report + 1, modified_datetime = '$currentTime' where id='$ID' ");

if($insert_report)
{
$msg = 'Test Report Added Successfully';
header('Location:list-test-reports.php?msg='.$msg);
}
else
{
$alert_msg = 'Could not able to add try once again!!!';
}

}


if($Submit=='Update')
{
$insert_report=mysqli_query($conn,"UPDATE test_report set dispatch_id='$ID', so_num='$so_num', product='$product', type='$type', kw='$kw', hp='$hp', current='$current', rpm='$rpm', volt='$volt', machine_num='$machine_num', frequency='$frequency', customer_id='$customer_id', efficiency='$efficiency', power_factor='$power_factor', connection='$connection', degree='$degree', duty='$duty', cd_s1_output='$cd_s1_output', ins_cl='$ins_cl', frame='$frame', ref_standard='$ref_standard', mounting='$mounting', hsn_code='$hsn_code', special_requirements='$special_requirements', direction='$direction', de_bearing='$de_bearing', nde_bearing='$nde_bearing', construction='$construction', t_box_position='$t_box_position', rotor_voltage='$rotor_voltage', rotor_current='$rotor_current', rotor_class='$rotor_class', a_c_heater='$a_c_heater', ptc='$ptc', rtd='$rtd', test_results='$test_results', test_polarity='$test_polarity', avg_res='$avg_res', amb_temp='$amb_temp', no_load_test='$no_load_test', no_load_polarity='$no_load_polarity', no_load_voltage='$no_load_voltage', no_load_current='$no_load_current', no_load_input_power='$no_load_input_power', reduced_voltage='$reduced_voltage', locked_rotor_test='$locked_rotor_test', locked_polarity='$locked_polarity', locked_voltage='$locked_voltage', locked_current1='$locked_current1', locked_current2='$locked_current2', locked_current3='$locked_current3', locked_input_power='$locked_input_power', high_voltage_test='$high_voltage_test', high_polarity='$high_polarity', high_voltage='$high_voltage', duration='$duration', remarks='$remarks', insulation_resistance_test='$insulation_resistance_test', winding='$winding', insulation_resistance='$insulation_resistance', remarks_main='$remarks_main', description='$description', checked_by='$checked_by', test_date='$test_date', status = '$status', cyc='$cyc', flc='$flc', rating='$rating', phase='$phase', resistance='$resistance', min_voltage='$min_voltage', hvt='$hvt', before_hvt='$before_hvt', after_hvt='$after_hvt', volt_acw='$volt_acw', test_cw='$test_cw', no_load_v='$no_load_v', no_load_i='$no_load_i', no_load_w='$no_load_w', starting_torque='$starting_torque', starting_current='$starting_current', modified_datetime = '$currentTime' where id='$ID' ");
if($insert_report)
{
$msg = 'Test Report Added Successfully';
header('Location:list-test-reports.php?msg='.$msg);
}
else
{
$alert_msg = 'Could not able to add try once again!!!';
}

}


if($Act==''){
$select_dispatch=mysqli_query($conn,"select * from dispatch where id='$ID' ");
$row_dispatch=mysqli_fetch_array($select_dispatch);
$product=$row_dispatch['product_name'];
$customer_id=$row_dispatch['customer_id'];
$motor_num=$row_dispatch['motor_num'];
$options = explode("~", $motor_num);

$select_qry=mysqli_query($conn,"select * from product where product='$product_name' "); 
$row_R=mysqli_fetch_array($select_qry);
}else{
$select_qry=mysqli_query($conn,"select * from test_report where id='$ID' "); 
$row_report=mysqli_fetch_array($select_qry);
foreach($row_report as $K1=>$V1) $$K1 = $V1;

$select_dispatch=mysqli_query($conn,"select * from dispatch where id='".$row_report['dispatch_id']."' ");
$row_dispatch=mysqli_fetch_array($select_dispatch);
$motor_num=$row_dispatch['motor_num'];
$options = explode("~", $motor_num);
}




?>

<body >
	<div class="card bg-theme border-top border-0 border-4 border-primary wow fadeInUp">
<div class="card-body p-5">
<div class="card-title d-flex align-items-center">
<div><i class="bx bxs-user me-1 font-22 color-af251c"></i>
</div>
<h5 class="mb-0 text-primary color-af251c"><? if($ID !='' && $Act!=""){echo "Update";}else{echo "Add";}?> Test Report</h5>
</div>
<hr>

<form action="#" method="post" class="row g-3" enctype="multipart/form-data">

<div class="row form-label g-3 mt-0">
<? if($msg !=''){ ?><div class="alert alert-success border-0 bg-success alert-dismissible fade show py-2">
<div class="d-flex align-items-center">
<div class="font-35 text-white"><i class="bx bxs-check-circle"></i>
</div>
<div class="ms-3">
<h6 class="mb-0 text-white">Successfully</h6>
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
<h6 class="mb-0 text-white">Error</h6>
<div class="text-white"><?=$alert_msg; ?></div>
</div>
</div>
<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div> <? } ?>

<div class="col-md-3">
<label for="inputFirstName" class="form-label">Product Name</label>
<input type="text" name="product" id="product" class="form-control" value="<?=$product;?>" placeholder="Product Name" required>
<input type="hidden" name="customer_id" id="customer_id" class="form-control" value="<?=$customer_id;?>">

</div>

<div class="col-md-3">
<label for="inputFirstName" class="form-label">S. O. No</label>
<select class="single-select" data-placeholder="Choose anything" multiple="multiple" name="so_num" id="so_num" required>
<?
foreach ($options as $option) {?>
    <option value="<?=$option;?>" <? if($option==$so_num){echo "selected";} ?>  ><?=$option;?></option>
<?} ?>
</select>

</div>

<div class="col-md-3">
<label for="inputFirstName" class="form-label">Machine No</label>
<input type="text" name="machine_num" id="machine_num" class="form-control" value="<?=$machine_num;?>" placeholder="Machine No" required>
</div>

<div class="col-md-12 mt-0">
<hr>
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
<h6 class="mb-0 text-uppercase text-dark">NAME PLATE DATA</h6>
</div><hr class="mb-0">
</div>
<div class="col-md-3">
<label for="inputFirstName" class="form-label">Type</label>
<input type="text" name="type" id="type" class="form-control" value="<?=$type;?>" placeholder="Type" >
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
<label for="inputFirstName" class="form-label">Current</label>
<input type="text" name="current" id="current" class="form-control" value="<?=$current;?>" placeholder="Current" >
</div>

<div class="col-md-3">
<label for="inputFirstName" class="form-label">Rpm</label>
<input type="text" name="rpm" id="rpm" class="form-control" value="<?=$rpm;?>" placeholder="Rpm" >
</div>

<div class="col-md-3 Type">
<label for="inputFirstName" class="form-label">Volt</label>
<input type="text" name="volt" id="volt" class="form-control" value="<?=$volt;?>" placeholder="Volt" >
</div>


<div class="col-md-3">
<label for="inputFirstName" class="form-label">Frequency</label>
<input type="text" name="frequency" id="frequency" class="form-control" value="<?=$frequency;?>" placeholder="freq." >
</div>

<div class="col-md-3">
<label for="inputFirstName" class="form-label">Efficiency</label>
<input type="text" name="efficiency" id="efficiency" class="form-control" value="<?=$efficiency;?>" placeholder="Efficiency" >
</div>

<div class="col-md-3">
<label for="inputFirstName" class="form-label">Power Factor</label>
<input type="text" name="power_factor" id="power_factor" class="form-control" value="<?=$power_factor;?>" placeholder="Power Factor" >
</div>

<div class="col-md-3">
<label for="inputFirstName" class="form-label">Connection</label>
<input type="text" name="connection" id="connection" class="form-control" value="<?=$connection;?>" placeholder="Connection" >
</div>

<div class="col-md-3">
<label for="inputFirstName" class="form-label">IP44/IP55</label>
<input type="text" name="degree" id="degree" class="form-control" value="<?=$degree;?>" placeholder="IP44/IP55" >
</div>

<div class="col-md-3">
<label for="inputFirstName" class="form-label">Duty</label>
<input type="text" name="duty" id="duty" class="form-control" value="<?=$duty;?>" placeholder="Duty" >
</div>

<div class="col-md-3">
<label for="inputFirstName" class="form-label">CD S1 Output</label>
<input type="text" name="cd_s1_output" id="cd_s1_output" class="form-control" value="<?=$cd_s1_output;?>" placeholder="CD S1 Output" >
</div>

<div class="col-md-3">
<label for="inputFirstName" class="form-label">INS.CL</label>
<input type="text" name="ins_cl" id="ins_cl" class="form-control" value="<?=$ins_cl;?>" placeholder="INS.CL" >
</div>

<div class="col-md-3">
<label for="inputFirstName" class="form-label">Frame</label>
<input type="text" name="frame" id="frame" class="form-control" value="<?=$frame;?>" placeholder="Frame" >
</div>

<div class="col-md-3">
<label for="inputFirstName" class="form-label">Ref. Standard</label>
<input type="text" name="ref_standard" id="ref_standard" class="form-control" value="<?=$ref_standard;?>" placeholder="Ref. Standard" >
</div>


<div class="col-md-3">
<label for="inputFirstName" class="form-label">CYC</label>
<input type="text" name="cyc" id="cyc" class="form-control" value="<?=$cyc;?>" placeholder="CYC" >
</div>
<div class="col-md-3">
<label for="inputFirstName" class="form-label">FLC</label>
<input type="text" name="flc" id="flc" class="form-control" value="<?=$flc;?>" placeholder="FLC" >
</div>
<div class="col-md-3">
<label for="inputFirstName" class="form-label">Rating</label>
<input type="text" name="rating" id="rating" class="form-control" value="<?=$rating;?>" placeholder="Rating" >
</div>
<div class="col-md-3">
<label for="inputFirstName" class="form-label">Phase</label>
<input type="text" name="phase" id="phase" class="form-control" value="<?=$phase;?>" placeholder="Phase" >
</div>
<!-- <div class="col-md-3">
<label for="inputFirstName" class="form-label">Mounting</label>
<input type="text" name="mounting" id="mounting" class="form-control" value="<?=$mounting;?>" placeholder="Mounting" >
</div>

<div class="col-md-3">
<label for="inputFirstName" class="form-label">HSN Code</label>
<input type="text" name="hsn_code" id="hsn_code" class="form-control" value="<?=$hsn_code;?>" placeholder="HSN Code" >
</div>

<div class="col-md-3">
<label for="inputFirstName" class="form-label">Special Requirements</label>
<input type="text" name="special_requirements" id="special_requirements" class="form-control" value="<?=$special_requirements;?>" placeholder="Reqs." >
</div>-->
<div class="col-md-12 mt-0">
<hr>
<div class="row g-3">
<div class="col-md-3">
<label for="inputFirstName" class="form-label">Winding Resistance at 75&deg;C</label>
<input type="text" name="resistance" id="resistance" class="form-control" value="<?=$resistance;?>" placeholder="resistance" >
</div>

<div class="col-md-3">
<label for="inputFirstName" class="form-label">Minimum Starting Voltage (Volts)</label>
<input type="text" name="min_voltage" id="min_voltage" class="form-control" value="<?=$min_voltage;?>" placeholder="Minimum Starting Voltage" >
</div>
<div class="col-md-3">
<label for="inputFirstName" class="form-label">HVT at 1800V</label>
<input type="text" name="hvt" id="hvt" class="form-control" value="<?=$hvt;?>" placeholder="HVT" >
</div>


<div class="col-md-12">
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
<h6 class="mb-0 text-uppercase text-dark text-underline">Insulation Resistance</h6>
</div></div>

	<div class="col-md-3 mt-0">
<label for="inputFirstName" class="form-label">Before HVT M</label>
<input type="text" name="before_hvt" id="before_hvt" class="form-control" value="<?=$before_hvt;?>" placeholder="Before HVT M" >
</div>
<div class="col-md-3 mt-0">
<label for="inputFirstName" class="form-label">After HVT M</label>
<input type="text" name="after_hvt" id="after_hvt" class="form-control" value="<?=$after_hvt;?>" placeholder="After HVT M" >
</div>


<div class="col-md-12">
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
<h6 class="mb-0 text-uppercase text-dark text-underline">Reduced</h6>
</div></div>

	<div class="col-md-3 mt-0">
<label for="inputFirstName" class="form-label">Volt (ACW RPM)</label>
<input type="text" name="volt_acw" id="volt_acw" class="form-control" value="<?=$volt_acw;?>" placeholder="Volt (ACW RPM)" >
</div>
<div class="col-md-3 mt-0">
<label for="inputFirstName" class="form-label">Test (CW RPM)</label>
<input type="text" name="test_cw" id="test_cw" class="form-control" value="<?=$test_cw;?>" placeholder="Test (CW RPM)" >
</div>


<div class="col-md-12">
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
<h6 class="mb-0 text-uppercase text-dark text-underline">No Load</h6>
</div></div>

	<div class="col-md-3 mt-0">
<label for="inputFirstName" class="form-label">V</label>
<input type="text" name="no_load_v" id="no_load_v" class="form-control" value="<?=$no_load_v;?>" placeholder="V" >
</div>
<div class="col-md-3 mt-0">
<label for="inputFirstName" class="form-label">I</label>
<input type="text" name="no_load_i" id="no_load_i" class="form-control" value="<?=$no_load_i;?>" placeholder="I" >
</div>
<div class="col-md-3 mt-0">
<label for="inputFirstName" class="form-label">W</label>
<input type="text" name="no_load_w" id="no_load_w" class="form-control" value="<?=$no_load_w;?>" placeholder="W" >
</div>
<div class="col-md-3 mt-0">
</div>

<div class="col-md-3">
<label for="inputFirstName" class="form-label">Starting Torque (%)</label>
<input type="text" name="starting_torque" id="starting_torque" class="form-control" value="<?=$starting_torque;?>" placeholder="Starting Torque (%)" >
</div>


<div class="col-md-3">
<label for="inputFirstName" class="form-label">Starting Current AMP</label>
<input type="text" name="starting_current" id="starting_current" class="form-control" value="<?=$starting_current;?>" placeholder="Starting Current AMP" >
</div>


</div>
</div>







<div class="col-md-12 mt-0">
<hr>
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
<h6 class="mb-0 text-uppercase text-dark">OTHER DATA</h6>
</div><hr class="mb-0">
</div>


<div class="col-md-3">
<label for="inputFirstName" class="form-label">Direction</label>
<input type="text" name="direction" id="direction" class="form-control" value="<?=$direction;?>" placeholder="Direction" >
</div>

<div class="col-md-3">
<label for="inputFirstName" class="form-label">DE Bearing</label>
<input type="text" name="de_bearing" id="de_bearing" class="form-control" value="<?=$de_bearing;?>" placeholder="DE Bearing" >
</div>

<div class="col-md-3">
<label for="inputFirstName" class="form-label">NDE Bearing </label>
<input type="text" name="nde_bearing" id="nde_bearing" class="form-control" value="<?=$nde_bearing;?>" placeholder="NDE Bearing " >
</div>

<div class="col-md-3">
<label for="inputFirstName" class="form-label">Construction</label>
<input type="text" name="construction" id="construction" class="form-control" value="<?=$construction;?>" placeholder="Construction" >
</div>

<div class="col-md-3">
<label for="inputFirstName" class="form-label">T. Box Position</label>
<input type="text" name="t_box_position" id="t_box_position" class="form-control" value="<?=$t_box_position;?>" placeholder="T. Box Position" >
</div>

<div class="col-md-3">
<label for="inputFirstName" class="form-label">Rotor Voltage</label>
<input type="text" name="rotor_voltage" id="rotor_voltage" class="form-control" value="<?=$rotor_voltage;?>" placeholder="Rotor Voltage" >
</div>

<div class="col-md-3">
<label for="inputFirstName" class="form-label">Rotor Current</label>
<input type="text" name="rotor_current" id="rotor_current" class="form-control" value="<?=$rotor_current;?>" placeholder="Rotor Current" >
</div>

<div class="col-md-3">
<label for="inputFirstName" class="form-label">Rotor Class</label>
<input type="text" name="rotor_class" id="rotor_class" class="form-control" value="<?=$rotor_class;?>" placeholder="Rotor Class" >
</div>

<div class="col-md-3">
<label for="inputFirstName" class="form-label">A. C. Heater</label>
<input type="text" name="a_c_heater" id="a_c_heater" class="form-control" value="<?=$a_c_heater;?>" placeholder="A. C. Heater" >
</div>

<div class="col-md-3">
<label for="inputFirstName" class="form-label">PTC</label>
<input type="text" name="ptc" id="ptc" class="form-control" value="<?=$ptc;?>" placeholder="PTC" >
</div>

<div class="col-md-3">
<label for="inputFirstName" class="form-label">RTD</label>
<input type="text" name="rtd" id="rtd" class="form-control" value="<?=$rtd;?>" placeholder="RTD" >
</div>

<div class="col-md-12 mt-0">
<hr>
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
<h6 class="mb-0 text-uppercase text-dark">TEST RESULTS </h6>
</div><hr class="mb-0">
</div>

<div class="col-md-3">
<label for="inputFirstName" class="form-label">Test Results</label>
<input type="text" name="test_results" id="test_results" class="form-control" value="<?=$test_results;?>" placeholder="Test Results" >
</div>

<div class="col-md-3">
<label for="inputFirstName" class="form-label">Polarity & Connection</label>
<input type="text" name="test_polarity" id="test_polarity" class="form-control" value="<?=$test_polarity;?>" placeholder="Polarity & Connection" >
</div>

<div class="col-md-3">
<label for="inputFirstName" class="form-label">Avg Res <small>(Ohms)</small></label>
<input type="text" name="avg_res" id="avg_res" class="form-control" value="<?=$avg_res;?>" placeholder="Avg Res" >
</div>

<div class="col-md-3">
<label for="inputFirstName" class="form-label">Amb Temp <small>(C)</small></label>
<input type="text" name="amb_temp" id="amb_temp" class="form-control" value="<?=$amb_temp;?>" placeholder="Amb Temp" >
</div>

<div class="col-md-12 mt-0">
<hr>
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
<h6 class="mb-0 text-uppercase text-dark">NO LOAD TEST </h6>
</div><hr class="mb-0">
</div>


<div class="col-md-3">
<label for="inputFirstName" class="form-label">No Load Test</label>
<input type="text" name="no_load_test" id="no_load_test" class="form-control" value="<?=$no_load_test;?>" placeholder="No Load Test" >
</div>

<div class="col-md-3">
<label for="inputFirstName" class="form-label">Polarity and Connection</label>
<input type="text" name="no_load_polarity" id="no_load_polarity" class="form-control" value="<?=$no_load_polarity;?>" placeholder="Polarity and Connection" >
</div>

<div class="col-md-3">
<label for="inputFirstName" class="form-label">Voltage <small>(Volts)</small></label>
<input type="text" name="no_load_voltage" id="no_load_voltage" class="form-control" value="<?=$no_load_voltage;?>" placeholder="Voltage" >
</div>

<div class="col-md-3">
<label for="inputFirstName" class="form-label">Current <small>(Amp.)</small></label>
<input type="text" name="no_load_current" id="no_load_current" class="form-control" value="<?=$no_load_current;?>" placeholder="Current " >
</div>

<div class="col-md-3">
<label for="inputFirstName" class="form-label">Input Power <small>(watts)</small></label>
<input type="text" name="no_load_input_power" id="no_load_input_power" class="form-control" value="<?=$no_load_input_power;?>" placeholder="Input Power" >
</div>


<div class="col-md-12 mt-0">
<hr>
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
<h6 class="mb-0 text-uppercase text-dark">REDUCED VOLTAGE RUN UP TEST</h6>
</div><hr class="mb-0">
</div>


<div class="col-md-3">
<label for="inputFirstName" class="form-label">Reduced Voltage Run Up Test</label>
<input type="text" name="reduced_voltage" id="reduced_voltage" class="form-control" value="<?=$reduced_voltage;?>" placeholder="Reduced Voltage Run Up Test" >
</div>

<div class="col-md-12 mt-0">
<hr>
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
<h6 class="mb-0 text-uppercase text-dark">LOCKED ROTOR TEST</h6>
</div><hr class="mb-0">
</div>



<div class="col-md-3">
<label for="inputFirstName" class="form-label">Locked Rotor Test</label>
<input type="text" name="locked_rotor_test" id="locked_rotor_test" class="form-control" value="<?=$locked_rotor_test;?>" placeholder="Locked Rotor Test" >
</div>

<div class="col-md-3">
<label for="inputFirstName" class="form-label">Polarity & Connection</label>
<input type="text" name="locked_polarity" id="locked_polarity" class="form-control" value="<?=$locked_polarity;?>" placeholder="Polarity & Connection" >
</div>

<div class="col-md-3">
<label for="inputFirstName" class="form-label">Voltage <small>(Volts)</small></label>
<input type="text" name="locked_voltage" id="locked_voltage" class="form-control" value="<?=$locked_voltage;?>" placeholder="Voltage" >
</div>

<div class="col-md-3">
<label for="inputFirstName" class="form-label">Current <small>(Amp.)</small></label>
<div class="d-flex gap-2 align-items-center">1<input type="text" name="locked_current1" id="locked_current1" class="form-control" value="<?=$locked_current1;?>" placeholder="Current" ></div>
<div class="d-flex gap-2 align-items-center">2<input type="text" name="locked_current2" id="locked_current2" class="form-control mt-2" value="<?=$locked_current2;?>" placeholder="Current" ></div>
<div class="d-flex gap-2 align-items-center">3<input type="text" name="locked_current3" id="locked_current3" class="form-control mt-2" value="<?=$locked_current3;?>" placeholder="Current" ></div>
</div>

<div class="col-md-3">
<label for="inputFirstName" class="form-label">Input Power <small>(Watts)</small></label>
<input type="text" name="locked_input_power" id="locked_input_power" class="form-control" value="<?=$locked_input_power;?>" placeholder="Input Power" >
</div>


<div class="col-md-12 mt-0">
<hr>
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
<h6 class="mb-0 text-uppercase">HIGH VOLTAGE TEST</h6>
</div><hr class="mb-0">
</div>
<div class="col-md-3">
<label for="inputFirstName" class="form-label w-100">High Voltage Test</label>
<!-- <select class="form-select" name="high_voltage_test" >
<option value="Pass" <? if($high_voltage_test == "Pass" || $high_voltage_test=='') { ?>selected<? } ?> >Pass</option>
<option value="Fail" <? if($high_voltage_test == "Fail") { ?>selected<? } ?> >Fail</option>
</select> -->

<div class="form-check form-check-inline">
<input class="form-check-input" type="radio" name="high_voltage_test" id="Pass" value="Pass" <? if($high_voltage_test =='Pass' || $high_voltage_test=='') { echo 'checked'; } ?>>
<label class="form-check-label" for="Pass">Pass</label>

</div>
<div class="form-check form-check-inline">
<input class="form-check-input" type="radio" name="high_voltage_test" id="Fail" value="Fail" <? if($high_voltage_test =='Fail') { echo 'checked'; } ?>>
<label class="form-check-label" for="Fail">Fail</label>
</div>


</div>

<div class="col-md-3">
<label for="inputFirstName" class="form-label">Polarity & Connection</label>
<input type="text" name="high_polarity" id="high_polarity" class="form-control" value="<?=$high_polarity;?>" placeholder="Polarity & Connection" >
</div>

<div class="col-md-3">
<label for="inputFirstName" class="form-label">Voltage</label>
<input type="text" name="high_voltage" id="high_voltage" class="form-control" value="<?=$high_voltage;?>" placeholder="Voltage" >
</div>

<div class="col-md-3">
<label for="inputFirstName" class="form-label">Duration</label>
<input type="text" name="duration" id="duration" class="form-control" value="<?=$duration;?>" placeholder="Duration" >
</div>

<div class="col-md-3">
<label for="inputFirstName" class="form-label">Remarks</label>
<input type="text" name="remarks" id="remarks" class="form-control" value="<?=$remarks;?>" placeholder="Remarks" >
</div>

<div class="col-md-12 mt-0">
<hr>
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
<h6 class="mb-0 text-uppercase">INSULATION RESISTANCE TEST</h6>
</div><hr class="mb-0">
</div>

<div class="col-md-3">
<label for="inputFirstName" class="form-label">Insulation Resistance Test</label>
<input type="text" name="insulation_resistance_test" id="insulation_resistance_test" class="form-control" value="<?=$insulation_resistance_test;?>" placeholder="Insulation Resistance Test" >
</div>

<div class="col-md-3">
<label for="inputFirstName" class="form-label">Winding</label>
<input type="text" name="winding" id="winding" class="form-control" value="<?=$winding;?>" placeholder="Winding" >
</div>

<div class="col-md-3">
<label for="inputFirstName" class="form-label">Insulation Resistance</label>
<input type="text" name="insulation_resistance" id="insulation_resistance" class="form-control" value="<?=$insulation_resistance;?>" placeholder="Insulation Resistance" >
</div>

<div class="col-md-3">
<label for="inputFirstName" class="form-label">Remarks</label>
<textarea type="text" name="remarks_main" id="remarks_main" class="form-control" placeholder="Remarks" ><?=$remarks_main;?></textarea>
</div>

<div class="col-md-3">
<label for="inputFirstName" class="form-label">Description</label>
<textarea type="text" name="description" id="description" class="form-control" placeholder="Description" ><?=$description;?></textarea>
</div>
<div class="col-md-12 mt-0">
<hr class="mb-0">
</div>
<div class="col-md-3">
<label for="inputFirstName" class="form-label">Checked By</label>
<input type="text" name="checked_by" id="checked_by" class="form-control" value="<?=$checked_by;?>" placeholder="Checked By" required>
</div>


<div class="col-md-3">
<label for="inputFirstName" class="form-label">Test Date</label>
<input type="date" name="test_date" id="test_date" class="form-control" value="<? if($test_date==''){echo $currentDate;}else{echo $test_date;}?>" placeholder="Test Date" required>
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
<input type="submit" name="Submit" class="btn btn-primary px-5" value="<? if($ID !='0' && $Act!='') {   echo  "Update"; } else echo "Add";?>" >
</div>


</form>
</div></div>
<?php

}

include 'template.php';

?>