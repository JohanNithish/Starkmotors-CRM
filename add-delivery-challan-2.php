<?php
function main() { 
extract($_REQUEST);
include 'dilg/cnt/join.php';
include 'global-functions.php';
$ID=$_GET['id'];
$act=$_GET['act'];
date_default_timezone_set('Asia/Kolkata');
$currentTime = date('Y-m-d H:i:s');
$DATE = date('Y-m-d');
$TIME = date('H:i:s');
if(isset($_POST['Submit'])){

$select_customer=mysqli_query($conn,"select * from customer where id='$customer' "); 
$Row_customer=mysqli_fetch_array($select_customer);
$company_name = $Row_customer['company_name'];
$customer_name = $Row_customer['customer_name'];
$customer_type = $Row_customer['customer_type'];
$mobile = $Row_customer['mobile'];
$products_count=count($product_name);
$gst_amount = 0;
$total_gst_amount = 0;
$total_product_amount = 0;



$filename1 = $_FILES['upload_1']['name'];
$filesize1 = $_FILES['upload_1']['size'];
$ext1 = strtolower(substr(strrchr($filename1, "."), 1));
if($ext1 == 'jpg' or $ext1 == 'jpeg' or $ext1 == 'png' or $ext1 == 'webp' or $ext1 == 'pdf' or $ext1 == 'xlsx' or $ext1 == 'xlsm' or $ext1 == 'csv' or $ext1 == 'xlsb' or $ext1 == 'xltx' or $ext1 == 'xls' or $ext1 == 'xlt'  or $ext1 == 'docx')
{
      $path1 = time().''.str_replace(" ","",$filename1);
      $file_path1 = "uploads/delivery-challan/".$path1;
      $up_path1 = "delivery-challan/".$path1;
      copy($_FILES['upload_1']['tmp_name'],$file_path1);
      $img_subqry .= " , upload_1 = '$up_path1'";
}
$filename2 = $_FILES['upload_2']['name'];
$filesize2 = $_FILES['upload_2']['size'];
$ext2 = strtolower(substr(strrchr($filename2, "."), 1));
if($ext2 == 'jpg' or $ext2 == 'jpeg' or $ext2 == 'png' or $ext2 == 'webp' or $ext2 == 'pdf' or $ext2 == 'xlsx' or $ext2 == 'xlsm' or $ext2 == 'csv' or $ext2 == 'xlsb' or $ext2 == 'xltx' or $ext2 == 'xls' or $ext2 == 'xlt'  or $ext2 == 'docx')
{
      $path2 = time().''.str_replace(" ","",$filename2);
      $file_path2 = "uploads/delivery-challan/".$path2;
      $up_path2 = "delivery-challan/".$path2;
      copy($_FILES['upload_2']['tmp_name'],$file_path2);
      $img_subqry .= " , upload_2 = '$up_path2'";
}
$filename3 = $_FILES['upload_3']['name'];
$filesize3 = $_FILES['upload_3']['size'];
$ext3 = strtolower(substr(strrchr($filename3, "."), 1));
if($ext3 == 'jpg' or $ext3 == 'jpeg' or $ext3 == 'png' or $ext3 == 'webp' or $ext3 == 'pdf' or $ext3 == 'xlsx' or $ext3 == 'xlsm' or $ext3 == 'csv' or $ext3 == 'xlsb' or $ext3 == 'xltx' or $ext3 == 'xls' or $ext3 == 'xlt'  or $ext3 == 'docx')
{
      $path3 = time().''.str_replace(" ","",$filename3);
      $file_path3 = "uploads/delivery-challan/".$path3;
      $up_path3 = "delivery-challan/".$path3;
      copy($_FILES['upload_3']['tmp_name'],$file_path3);
      $img_subqry .= " , upload_3 = '$up_path3'";
}

if($Submit=='Create Challan')
{

$insert_product=mysqli_query($conn,"insert into delivery_challan set customer_id = '$customer', customer_name = '$customer_name', company_name='$company_name', customer_type='$customer_type', overall_remarks='$overall_remarks', mobile='$mobile', company_address= '$company_address', products_count='$products_count', returnable_type='Non-Returnable', delivery_challan_number='$delivery_challan_number', reference_number='$reference_number', customer_reference_number='$customer_reference_number', transportation_mode='$transportation_mode', challan_date='$challan_date', vechile_number='$vechile_number', supply_date='$supply_date', supply_place='$supply_place', total_order_amount='$total_order_amount', status='', eway_number='$eway_number', created_datetime = '$currentTime', created_by=".$_SESSION['UID']." $img_subqry");

$delivery_challan_id = $conn->insert_id;


for($i=0; $i<=$products_count; $i++)
{
if($product_name[$i] !='')
{ 

$rs_InsValues=mysqli_query($conn,"insert into delivery_challan_product set delivery_challan_id='$delivery_challan_id', product_name='$product_name[$i]', quantity = '$quantity[$i]', remarks='$remarks[$i]', created_datetime = '$currentTime', created_by=".$_SESSION['UID']."");

}
}
$update_settings=mysqli_query($conn,"update settings set non_returnable_count=non_returnable_count+1 ");


$email=$Row_customer['email'];
$pin_code=$Row_customer['pin_code'];
$address = addslashes($Row_customer['address']);
$gst=$Row_customer['gst'];
$PRODUCT_amount=$total_product_amount;



$total_package_amount="Rs. ".$total_package_amount;
$Total_order_amount=$total_order_amount;

if($pin_code!=''){
  $Pin_code=" - ".$pin_code;
}

if($gst !=''){
$GST = '<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;GST : '.$gst;
}
if($company_name !=''){
$company_name = '<b>'.$company_name.',</b><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
}
// if($status=="Pending"){
//   $Doc_NUM="MKT/F/7.205-Rev 00-1st July 2022";
// }else{
//   $Doc_NUM="MKT/F/7.204-Rev 00-1st July 2022";
// }

if($company_address==1)
{
$company_caps= 'STARK ENGINEERS';
$Company_address ="Stark Engineers 3/360-363, Manickampalayam, Karuvalur Main Road, Coimbatore, Tamil Nadu 641107";
$Address_2="<table class=\"no-bdr\"><tr><td style=\"text-align:left;width:40%;font-size:16px;\">&nbsp;&nbsp;<b>Stark Engineers, </b></td><td style=\"text-align:right;width:60%;font-size:12px;\"><b><small style=\"font-size:14px;\">".$Doc_NUM." </small> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></td></tr></table><br>&nbsp;&nbsp;3/360-363, Manickampalayam, Karuvalur, <br>&nbsp;&nbsp;Main Road, Coimbatore, Tamil Nadu - 641107";
$Gst_address="33ADEFS5652D1Z9";
}
else{
$company_caps='STARK MOTORS';
$Company_address ="Stark motors, 96 sitra road, Kalapatti, Coimbatore 641048";
$Address_2="<table class=\"no-bdr\"><tr><td style=\"text-align:left;width:40%;font-size:16px;\">&nbsp;&nbsp;<b>Stark Motors, </b></td><td style=\"text-align:right;width:60%;font-size:12px;\"><b><small style=\"font-size:14px;\">".$Doc_NUM." </small> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></td></tr></table><br>&nbsp;&nbsp;96, Sitra Road, Kalapatti,<br>&nbsp;&nbsp;Coimbatore - 641048,";
$Gst_address="33AAMFS3000L1ZC";

}

$message   =  '<style>
body{
  font-family: Roboto, sans-serif;
  font-size:16px !important;
}
.fw-500{
  font-weight: bold;
}
.tr-head {
background-color:#fff;
color:#000;

}
.head{
background-color:#287dcf;
color:#fff;
}
.tb-row{
padding:30px;
margin-bottom:20px;
}
.adds-titl{
font-size: 12px;
color:#000;

}
th, td {
  padding: 6px 23px ;
  border: 0.5px solid #000;
  font-size:8px;
}
.no-bdr td, .no-bdr tr .no-bdr th{
  border: none;
  padding: 0px;
}
.li-line li{
  line-height:1.3;
}
.terms p{
  margin:0;
}
tbody{
  vertical-align: inherit !important;
}
hr{
  margin:5px 0px;
}
</style>';

if($state!=''){
$State='<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$state;
}


if ($delivery_challan_number != '' || $transportation_mode != '') {
$row .= '<tr style="border:1px solid #000;">';
if($delivery_challan_number != ''){
$row .= '<td style="padding:3px;border:1px solid #000;width:30%;font-size:14px;"><b>Delivery Challan No</b></td>
<td style="padding:3px;border:1px solid #000;width:20%;font-size:14px;text-align:center;">'.$delivery_challan_number.'</td>';
}
if($transportation_mode != ''){
$row .= '<td style="padding:3px;border:1px solid #000;width:30%;font-size:14px;"><b>Transportation Mode</b></td>
<td style="padding:3px;border:1px solid #000;width:20%;font-size:14px;text-align:center;">'.$transportation_mode.'</td>';
}
$row .= '</tr>';
}


if($challan_date != '0000-00-00' || $vechile_number != '') {
$row .= '<tr style="border:1px solid #000;">';
if($challan_date != '0000-00-00'){
$row .= '<td style="padding:3px;border:1px solid #000;width:30%;font-size:14px;"><b>Date</b></td>
<td style="padding:3px;border:1px solid #000;width:20%;font-size:14px;text-align:center;">'.date('d-m-Y',strtotime($challan_date)).'</td>';
}
if($vechile_number != ''){
$row .= '<td style="padding:3px;border:1px solid #000;width:30%;font-size:14px;"><b>Vechile No</b></td>
<td style="padding:3px;border:1px solid #000;width:20%;font-size:14px;text-align:center;">'.$vechile_number.'</td>';
}

$row .= '</tr>';
}

if(($supply_date != '' && $supply_date != '0000-00-00') || $state != '') {
$row .= '<tr style="border:1px solid #000;">';
if($state != ''){
$row .= '<td style="padding:3px;border:1px solid #000;width:30%;font-size:14px;"><b>State</b></td>
<td style="padding:3px;border:1px solid #000;width:20%;font-size:14px;text-align:center;">'.$state.'</td>';
}
if($supply_date != '' && $supply_date != '0000-00-00'){
$row .= '<td style="padding:3px;border:1px solid #000;width:30%;font-size:14px;"><b>Supply Date</b></td>
<td style="padding:3px;border:1px solid #000;width:20%;font-size:14px;text-align:center;">'.date('d-m-Y',strtotime($supply_date)).'</td>';
}

$row .= '</tr>';
}

if($supply_place != '' || $reference_number != '') {
$row .= '<tr style="border:1px solid #000;">';
if($reference_number != ''){
$row .= '<td style="padding:3px;border:1px solid #000;width:30%;font-size:14px;"><b>Ref No</b></td>
<td style="padding:3px;border:1px solid #000;width:20%;font-size:14px;text-align:center;">'.$reference_number.'</td>';
}
if($supply_place != ''){
$row .= '<td style="padding:3px;border:1px solid #000;width:30%;font-size:14px;"><b>Supply Place</b></td>
<td style="padding:3px;border:1px solid #000;width:20%;font-size:14px;text-align:center;">'.$supply_place.'</td>';
}
$row .= '</tr>';
}

if($eway_number != '' ) {
$row .= '<tr style="border:1px solid #000;">';
if($eway_number != ''){
$row .= '<td style="padding:3px;border:1px solid #000;width:30%;font-size:14px;"><b>Eway Bill No</b></td>
<td style="padding:3px;border:1px solid #000;width:20%;font-size:14px;text-align:center;">'.$eway_number.'</td>';
}
$row .= '</tr>';
}

if($gst !=''){
$GST_info = '
<br><br>&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-size:14px"><b> GST : 
'.$gst.'
</b></span>';
}

$message  .=  '<table class="no-bdr" cellspacing="0px" style="width: 100%;"><tr><td style="width:100%;"><table style="padding:0px;border:1px solid #000;width:100%;"><tr style="vertical-align: middle;"><td style="width:30%;" ><p class="adds-titl" style="text-align:center;"><a href="https://www.starkmotors.com/" target="_blank" style="text-align:center;"><img src="https://crm.starkmotors.com/assets/images/Our/logo2.png" width="135px;"></a></p></td><td style="border-left:1px solid #000;color:#000;font-size:14px;"><p class="adds-titl" style="text-align:left;font-size:14px;line-height:15px;font-weight:normal;">'.$Address_2.'<br>&nbsp;&nbsp;Phone: + 91 94426 14612, + 91 98433 14612,<br>&nbsp;&nbsp;E-mail:sales@starkmotors.com<br>&nbsp;&nbsp;Landline: 0422 -2627672, 0422 -2627612, 0422 -4274969, 0422 -4385612,<br>&nbsp;&nbsp;GST:'.$Gst_address.'</p></td></tr></table>';


$message  .=  '<table style="padding:0px;width:100%;border:1px solid #000;" cellspacing="1px"><td style="width:100%;line-height:0.55;padding:5px;" ><h1 style="text-align:center;font-size:18px;color:#000;margin:0; ">NON-RETURNABLE DELIVERY CHALLAN </h1></td>
</tr>
</table>
<table cellpadding="5px" cellspacing="0px" style="width:100%;border:1px solid #000;vertical-align: top;">
<tr><td style="width:49%;" ><p class="adds-titl" style="line-height:1.3;font-size:14px;margin-top:5px;margin-bottom:0;" ><b> To,</b><br> <span>&nbsp;&nbsp;&nbsp;&nbsp;'.$company_name.''.wordwrap($address, 50, "<br />&nbsp;&nbsp;&nbsp;&nbsp;\n").' '.$State.$Pin_code.'</span><span style="line-height:0.2;"></span>'.$GST_info.'<br></p></td><td style="width:51%;font-size:14px;border:1px solid #000;" >
<table  cellpadding="5px" cellspacing="0px" style="width:100%;">
'.$row.'

</table>
</td></tr></table>
<table style="padding:4px;width:100%; border:1px solid #000;">
<tr>
<td style="width:100%;">
<p class="adds-titl" style="line-height:1.3;font-size:14px;margin:0;" >
Dear Sir,<br>
With reference to your DC No. <b>'.$delivery_challan_number.'</b> Dated <b>'.date('d-m-Y',strtotime($challan_date)).'</b> we are sending herewith the following goods which kindly take delivery in
</p>
</td>

</tr></table>';




$message  .=  '<table cellpadding="3px" cellspacing="0px" style="border-collapse: collapse;
width: 100%;border: 0px solid #ddd;padding:10px 7px;text-align:center;">

<tr class="tr-head" style="background-color:#287dcf;color:#fff">
<th style="width:4.5%; font-weight: 600;font-size:14px;border: 1px solid #000;border-bottom: 1px solid #000;">#</th>  

<th style="width:87%; font-weight: 600;font-size:14px;border: 1px solid #000;border-bottom: 1px solid #000;">Particulars</th> 
<th style="width:8.5%; font-weight: 600;text-align:center;font-size:14px;border: 1px solid #000;border-bottom: 1px solid #000;">Qty</th>

</tr>'; 
$SNo=0;
$sel_product=mysqli_query($conn,"select * from delivery_challan_product where delivery_challan_id='$delivery_challan_id' ");
while($row_product=mysqli_fetch_array($sel_product))
{
  $SNo=$SNo+1;
  $product_name = $row_product['product_name'];
  $brand_name = $row_product['brand_name'];
  $rate = $row_product['rate'];
  $quantity = $row_product['quantity'];
  $product_amount = $row_product['product_amount'];
  $gst = $row_product['gst'];
  $gst_amount = $row_product['gst_amount'];
  $total_amount = $row_product['total_amount'];
  $package_amount = $row_product['package_amount'];
  $package_percent = $row_product['package_percent'];
 $estimated_delivery = $row_product['estimated_delivery'];

  if($estimated_delivery!=""){
    $estimated_delivery_date='<tr nobr="true"><hr><td style="width:100%;"><b style="line-height:1.5;text-align:left;font-size:14px;">Estimated Delivery: </b><span style="font-size:14px;margin:0;">&nbsp;&nbsp;&nbsp;'.date('d-m-Y', strtotime($estimated_delivery)).'</span></td></tr>';
  }else{
$estimated_delivery_date=" ";
  }


  $sel_mertics=mysqli_query($conn,"select * from product where product = '$product_name'"); 
$row_mertics=mysqli_fetch_array($sel_mertics);
$hsn_code = $row_mertics['hsn_code'];

if($row_product['remarks']!=''){ $remarks=' - '.$row_product['remarks'];}else{$remarks="";}





$message.= '<tr class="tr-head" style="color:#000">
<td style="text-align:center;width:4.5%;font-size:14px;border: 1px solid #000;border-bottom: 1px solid #000;">'.$SNo.'</td> 
<td style="text-align:left;width:87%; padding: 0px;font-size:14px;border: 1px solid #000;">'.$product_name.$remarks.'<br><span style="line-height:0px;"><br></span></td>
<td style="text-align:center;width:8.5%;font-size:14px;border: 1px solid #000;border-bottom: 1px solid #000;">'.$quantity.'</td> 
</tr>';
}

 


$message .= '</table><table cellpadding="7px" cellspacing="0px" style="padding:0px;width:100%;border:1px solid #000;">';


$message .= '<tr ><td style="width:65%;vertical-align: middle;"><p style="font-size:14px;margin-bottom:5px;margin-top:5px;">&nbsp;Party Material Returned<br>&nbsp;No Sale Involved</p></td><td class="tb-row" style="width:20%; font-weight: normal;font-size:14px;border: 1px solid #000;border-bottom: 1px solid #000;font-size:14px;background-color:#ffff92;text-align:right;"><b>Grand Total &nbsp;</b></td>  

<td class="tb-row" style="width:15%; font-weight: normal;font-size:14px ;border: 1px solid #000;border-bottom: 1px solid #000;background-color:#ffff92;padding:15px;">Rs. '.$Total_order_amount.'</td></tr></table>';


$message.= '<table cellspacing="0px" cellpadding="0px" style="width:100%;"><tr style="width:100%;">
<tr><td style="text-align:center;width:20%;padding:5px;font-size:14px;border: 1px solid #000;"><b>Total Amount in Words:&nbsp;&nbsp;&nbsp;&nbsp;</b></td><td style="text-align:center;padding:5px;width:80%;font-size:14px;border: 1px solid #000;"><span style="text-transform:uppercase;font-weight:bold;">'.getIndianCurrency($Total_order_amount).'</span></td></tr></table>';


if($overall_remarks!=''){
$message.= '<table cellspacing="0px" cellpadding="0px" style="width:100%;"><tr style="width:100%;">
<tr><td style="text-align:center;padding:5px;width:100%;font-size:14px;border: 1px solid #000;"><span>'.$overall_remarks.'</span></td></tr></table>';

}

if($terms_condition!=''){
$message  .=  '<table cellspacing="0px" cellpadding="0px" style="border-spacing: 6px 5px;padding:5px 5px;border: 1px solid #000;border-bottom: 0px solid #000;">
<tr class="no-bdr" nobr="true"><td style="width:100%;font-size:12px;font" ><b>Terms & Conditions:</b></td></tr>
                 <tr class="no-bdr" nobr="true" style="padding:5px;"><td style="width:100%;font-size:14px;" >'.$terms_condition.'
                </td></tr></table>';
}





$message  .=  '<table cellspacing="0px" cellpadding="5px" style="width:100%;padding:5px;line-height:0;background-color:#e8e8e8;border: 1px solid #000;">
<tr nobr="true">
<td style="width:50%;line-height:1.5; text-align:left;margin:0px;font-size:14px;border-right:1px solid #000;">Received the goods in good condition
<br>
<br>
<br>
<br>
<br>
Receiver\'s Signature
</td>
<td style="width:50%;line-height:1.5; text-align:right;margin:0px;font-size:14px;">For '.$company_caps.'
<br>
<br>
<br>
<br>
<br>
Authorised Signatory
</td></tr>
</table>';
$message  .=  '</body></html>';

$subject="New Non-Returnable Delivery Challan Created for ".$delivery_challan_number;
// $to="johannithish.mistsolutions@gmail.com";
$to="mktg.starkmotors@gmail.com";
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= 'Sender: <noreply@starkmotors.com>' . "\r\n";
$headers .= 'From: Stark Motors<noreply@starkmotors.com>' . "\r\n";
$headers .= 'Bcc: <support@starkmotors.com>' . "\r\n";
$headers .= 'Reply-To: Stark Motors <noreply@starkmotors.com>' . "\r\n";

$res1=mail($to , $subject, $message, $headers, '-fnoreply@starkmotors.com');
if($insert_product && $rs_InsValues)
{
$msg = 'Delivery Challan Added Successfully';
header('Location:list-delivery-challan-2.php?msg='.$msg);
}
else
{
$alert_msg = 'Could not able to add try once again!!!';     
}
}

if($Submit=='Update Challan')
{
$sel_doc_unlink=mysqli_query($conn,"select upload_1, upload_2, upload_3 from delivery_challan where id = '$ID'"); 
$row_file = mysqli_fetch_array($sel_doc_unlink);
if($up_path1!=''){
unlink('uploads/'.$row_file['upload_1']);
}
if($up_path2!=''){
unlink('uploads/'.$row_file['upload_2']);
}
if($up_path3!=''){
unlink('uploads/'.$row_file['upload_3']);
}
$update_product=mysqli_query($conn,"update delivery_challan set customer_id = '$customer', customer_name = '$customer_name', company_name='$company_name', customer_type='$customer_type', overall_remarks='$overall_remarks', mobile='$mobile', company_address= '$company_address', products_count='$products_count', returnable_type='Non-Returnable', delivery_challan_number='$delivery_challan_number', reference_number='$reference_number', customer_reference_number='$customer_reference_number', transportation_mode='$transportation_mode', challan_date='$challan_date', vechile_number='$vechile_number', supply_date='$supply_date', supply_place='$supply_place', total_order_amount='$total_order_amount', eway_number='$eway_number', modified_datetime = '$currentTime', created_by=".$_SESSION['UID']." $img_subqry where id='$ID' ");


$delivery_challan_ProductDelete = mysqli_query($conn,"delete from delivery_challan_product where delivery_challan_id ='$ID' ");


for($i=0; $i<=$products_count; $i++)
{
if($product_name[$i] !='')
{ 

$rs_InsValues=mysqli_query($conn,"insert into delivery_challan_product set delivery_challan_id='$ID', product_name='$product_name[$i]', quantity = '$quantity[$i]', remarks='$remarks[$i]', created_datetime = '$currentTime', created_by=".$_SESSION['UID']."");
}
}



if($update_product && $rs_InsValues)
{
$msg = 'Delivery Challan Updated Successfully';
header('Location:list-delivery-challan-2.php?msg='.$msg);
}
else
{
$alert_msg = 'Could not able to updated try once again!!!';    
}
}
}

if($ID!=''){
$sel_values=mysqli_query($conn,"select * from delivery_challan where id = '$ID'"); 
$row_values=mysqli_fetch_array($sel_values);
foreach($row_values as $K1=>$V1) $$K1 = $V1;
$customer_id=$row_values['customer_id'];
$mobile=$row_values['mobile'];
$customer_type=$row_values['customer_type'];
$CountQtn = mysqli_num_rows($sel_values); 
}else{
$CountQtn = 0;
$Max_User_Id = mysqli_query($conn,"select * from settings");
$row_User_Id=mysqli_fetch_array($Max_User_Id);
$max_user_id=$row_User_Id['non_returnable_count'];
$delivery_challan_number ='SNDC'.str_pad($max_user_id,3, "0", STR_PAD_LEFT);

}
?>

<body >
<form action="#" method="post" enctype="multipart/form-data" name="form1">
<div class="row form-label">
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
</div>
<div class="row justify-content-center">
<div class="col-xl-12">
<div class="card bg-theme border-top border-0 border-4 border-primary wow fadeInUp">
<div class="card-body p-5">
<div class="d-flex justify-space-between align-items-center">
<h5 class="text-uppercase mb-0"><?if($CountQtn>>0){ echo"Update";}else{echo "Add";}?> Non-Returnable Delivery Challan</span></h5>
<?if($CountQtn>>0){?> <a href="list-delivery-challan-2.php" class="btn btn-danger">Back</a><?}?> 
</div>
<hr>
<div class="card-title g-3 row">



<div class="col-xl-6" >
<label for="inputLastName" class="form-label mt-20">Select Company / Customer</label>
<select class="single-select" data-placeholder="Choose anything" multiple="multiple" name="customer" onchange="getCustomer(this.value)" id="customer_id" required>
<? 
$sql_customer=mysqli_query($conn,"select * from  customer where status='1' ORDER BY customer_name asc"); 
while($row_customer=mysqli_fetch_array($sql_customer))
{
?>
<option value="<?=$row_customer['id']?>" <? if($row_customer['id'] == $customer_id) { ?>selected<? } ?> ><?if($row_customer['company_name']!='')echo $row_customer['company_name'].' / ';?><?=$row_customer['customer_name'];?> (<?=$row_customer['mobile'];?>)</option>
<?
}
?>
</select>
</div>
<div class="col-xl-4 d-flex gap-5" id="output">



<?if($CountQtn>>0){
?>
<div>
<label for="inputLastName" class="form-label mt-20">Customer Type</label><br>
<p><?=$customer_type;?></p>
<input type="hidden" name="cust_type" id="customer_type" value="<?=$customer_type;?>">
</div>
<div>
<label for="inputLastName" class="form-label mt-20">Mobile</label><br>
<p><?=$mobile;?></p>
</div>
<?}?>
</div>

</div>
<div id="productSection" class=" mt-4 mb-3 " <?if($CountQtn==0){echo'style="display: none;"';} ?>>

<div class="row g-3 mb-3">
<div class="col-lg-3">
<label for="inputAddress" class="form-label">Delivery Challan No.</label>
<input type="text" class="form-control" name="delivery_challan_number" value="<?=$delivery_challan_number;?>" readonly>
</div>

<div class="col-lg-3">
<label for="inputAddress" class="form-label">Reference No.</label>
<input type="text" class="form-control" name="reference_number" value="<?=$reference_number;?>" >
</div>

<div class="col-lg-3">
<label for="inputAddress" class="form-label">Customer Reference No.</label>
<input type="text" class="form-control" name="customer_reference_number" value="<?=$customer_reference_number;?>" >
</div>

<div class="col-lg-3">
<label for="inputAddress" class="form-label">Transportation Mode</label>
<input type="text" class="form-control" name="transportation_mode" value="<?=$transportation_mode;?>" >
</div>


<div class="col-lg-2">
<label for="inputAddress" class="form-label">Date</label>
<input type="date" class="form-control" name="challan_date" value="<?if($challan_date!=''){ echo $challan_date;}else{echo $DATE;}?>" >
</div>

<div class="col-lg-2">
<label for="inputAddress" class="form-label">Vechile No.</label>
<input type="text" class="form-control" name="vechile_number" value="<?=$vechile_number;?>" >
</div>

<div class="col-lg-2">
<label for="inputAddress" class="form-label">Date of Supply</label>
<input type="date" class="form-control" name="supply_date" value="<?if($supply_date!=''){ echo $supply_date;}?>" >
</div>

<div class="col-lg-3">
<label for="inputAddress" class="form-label">Eway Bill No.</label>
<input type="text" class="form-control" name="eway_number" value="<?=$eway_number;?>" >
</div>

<div class="col-lg-3">
<label for="inputAddress" class="form-label">Place of Supply</label>
<input type="text" class="form-control" name="supply_place" value="<?=$supply_place;?>" >
</div>

<div class="col-lg-4">
<label for="inputAddress" class="form-label">Upload 1 <small class="text-danger">(Image, PDF, Excel and Docs Only)</small></label>
<div class="d-flex"><input type="file" class="form-control" name="upload_1">
<? if($upload_1!=''){?><a href="uploads/<?=$upload_1; ?>" target="_blank"><img src="assets/images/Our/dox.png" class="mt-2" width="30px"></a><?}?>
</div>

</div>

<div class="col-lg-4">
<label for="inputAddress" class="form-label">Upload 2 <small class="text-danger">(Image, PDF, Excel and Docs Only)</small></label>
<div class="d-flex"><input type="file" class="form-control" name="upload_2">
<? if($upload_2!=''){?><a href="uploads/<?=$upload_2; ?>" target="_blank"><img src="assets/images/Our/dox.png" class="mt-2" width="30px"></a><?}?>
</div>
</div>

<div class="col-lg-4">
<label for="inputAddress" class="form-label">Upload 3 <small class="text-danger">(Image, PDF, Excel and Docs Only)</small></label>
<div class="d-flex">
<input type="file" class="form-control" name="upload_3">
<? if($upload_3!=''){?><a href="uploads/<?=$upload_3; ?>" target="_blank"><img src="assets/images/Our/dox.png" class="mt-2" width="30px"></a><?}?>
</div>
</div>

</div>

<div class="bg-3f663a text-center rounded-1">
<h5 class="text-white py-1">Add Product</h5>
</div>
<div class="px-2" id="Regular" >
<div id="frm_scents">
<? if($CountQtn =='0') { ?>
<div class="row g-2 mt-1 mb-2">
<div class="w-28-5">
<label for="inputLastName" class="form-label mt-20 mb-0">Product Name</label>

</div>

<div class="w-6">
<label for="inputLastName" class="form-label mt-20 mb-0">Qty.</label>
</div>


<div class="w-28-5">
<label for="inputLastName" class="form-label mt-20 mb-0">Remarks</label>
</div>




<div class="w-5 text-end">
<label for="inputtext" class="form-label mt-20 mb-0">Action</label>
</div>
</div>

<div class="row my-1" id="p_scents">

<div class="w-28-5">
<input type="text" class="form-control" id="product_name1"  name="product_name[]" placeholder="Product Name" required>
</div>

<div class="w-6">
<input type="number" class="form-control p-qnt" id="quantity1" min="0" name="quantity[]" placeholder="Qty" required>
</div>

<div class="w-28-5">
<textarea class="form-control" rows="1" id="remarks1" name="remarks[]" placeholder="Remarks"></textarea>
</div>

<div class="w-5 text-end">
<a type="button" id="addScnt" tooltip="Add Product" class="pe-1"  style="width: auto;" ><img src="assets/images/Our/plus2.png" width="27px;"> </a>

</div>
</div>
<? } else { ?>

<div class="row g-2 mt-1 mb-2">
<div class="w-28-5">
<label for="inputLastName" class="form-label mt-20 mb-0">Product Name</label>
</div>

<div class="w-6">
<label for="inputLastName" class="form-label mt-20 mb-0">Qty.</label>
</div>

<div class="w-28-5">
<label for="inputLastName" class="form-label mt-20 mb-0">Remarks</label>
</div>



<div class="w-5 text-end">
<label for="inputtext" class="form-label mt-20 mb-0">Action</label>
</div>
</div>

<? 
$SNo = 0;
$sel_product=mysqli_query($conn,"select * from delivery_challan_product where delivery_challan_id = '$ID'");
while($row_product=mysqli_fetch_array($sel_product))
{ 
$SNo = $SNo + 1; 
$product_name=$row_product['product_name'];
$brand_name=$row_product['brand_name'];
$rate=$row_product['rate'];
$quantity=$row_product['quantity'];
$gst=$row_product['gst'];
$total_amount=$row_product['total_amount'];
$estimated_delivery=$row_product['estimated_delivery'];
$package_percent=$row_product['package_percent'];
$remarks=$row_product['remarks'];
?>

<div class="row my-1" id="p_scents">

<div class="w-28-5">
<input type="text" class="form-control" id="product_name<?=$SNo?>"  name="product_name[]" placeholder="Product Name" value="<?=$product_name;?>" required>
</div>


<div class="w-6">
<input type="number" class="form-control p-qnt" id="quantity<?=$SNo?>" name="quantity[]" placeholder="Qty" min="0" value="<?=$quantity;?>" required>
<input type="hidden" id="quantityChange<?=$SNo?>" value="1">
</div>


<div class="w-28-5">
<textarea class="form-control" rows="1" id="remarks<?=$SNo?>" name="remarks[]" placeholder="Remarks"><?=$remarks;?></textarea>
</div>


<? if($SNo == 1){ ?>
<div class="w-5 text-end">
<a type="button" id="addScnt" class="pe-1" tooltip="Add Product" style="width: auto;" ><img src="assets/images/Our/plus2.png" width="27px;"> </a></div>
<?} else { ?>
<div class="w-5 text-end" id="remScnt" onclick="removeCont(this);"><a type="button" tooltip="Remove Product"  style="width: auto" class="pe-1"><img src="assets/images/Our/minus.png" width="27px;"></a></div>
<? } ?>

</div>
<? } ?>
<? } ?>
</div>
<hr>


<div class="col-md-12 row g-3">
<div class="col-lg-3">
<label for="inputAddress" class="form-label">Total Amount</label>
<input type="text" class="form-control" name="total_order_amount" oninput="this.value=this.value.replace(/[^0-9.]/g,'').replace(/(\..*)\./g,'$1');" value="<?=$total_order_amount;?>" required>
</div>
<div class="col-md-3">
  <label for="inputAddress" class="form-label width-100" >Company Name</label>
<div class="form-check form-check-inline">
<input class="form-check-input" type="radio" name="company_address" id="inlineRadio1" value="0" <? if($company_address =='0' || $company_address=='') { echo 'checked'; } ?>>
<label class="form-check-label" for="inlineRadio1">Stark Motors</label>

</div>
<div class="form-check form-check-inline">
<input class="form-check-input" type="radio" name="company_address" id="inlineRadio2" value="1" <? if($company_address =='1') { echo 'checked'; } ?>>
<label class="form-check-label" for="inlineRadio2">Stark Engineers</label>
</div>
</div>
<div class="col-lg-6">
	<label for="inputAddress" class="form-label">Notes</label>
	<textarea rows="4" class="form-control" name="overall_remarks"><?=stripslashes($overall_remarks);?></textarea>
</div>




</div>

</div>
<div class="col-12 mt-3" >
<input type="submit" name="Submit" class="btn btn-primary px-3" value="<? if($CountQtn >> 0) {   echo  "Update Challan"; } else echo "Create Challan";?>" >
</div> 




</div>
</div> </div></div></div></div></div>
</form>
</div></div>
<script src="assets/js/addmore.js"></script>
<script>
var scntDiv = $("#frm_scents");
var i = $("[id=p_scents]").length + 1;

$(function() {
$("#addScnt").click(function() {
$('<div class="row my-1 slide_show" id="p_scents" style="display:none"><div class="w-28-5"><input type="text" class="form-control" id="product_name'+i+'"  name="product_name[]" placeholder="Product Name" required></div><div class="w-6"><input type="number" class="form-control p-qnt" id="quantity'+i+'" name="quantity[]" min="0" placeholder="Qty" required><input type="hidden" id="qtyChange'+i+'" value="1"></div><div class="w-28-5"><textarea class="form-control" rows="1" id="remarks'+i+'" name="remarks[]" placeholder="Remarks" ></textarea></div><div class="w-5 text-end" id="remScnt" onclick="removeCont(this);"><a type="button" tooltip="Remove Product" style="width: auto;" class="pe-1"><img src="assets/images/Our/minus.png" width="27px;"></a></div></div>').appendTo(scntDiv);
$('.single-select').select2({
theme: 'bootstrap4',
width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
placeholder: $(this).data('placeholder'),
allowClear: Boolean($(this).data('allow-clear')),
});
$('.multiple-select').select2({
theme: 'bootstrap4',
width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
placeholder: $(this).data('placeholder'),
allowClear: Boolean($(this).data('allow-clear')),
});
$(".slide_show").slideDown(300);
i++;
return false;
});
});
function removeCont(_this) {
if (i > 1) {
$(_this).parent().remove();
}

}
</script>  
<script>
function getCustomer(val){
  $.ajax({
url: "fetch-customer.php", 
type: "POST",
data: "id="+val,
success: function(result){
$("#output").html(result);
if(result!=''){
$("#productSection").slideDown(500);
}else{
$("#productSection").slideUp(500);
}

}});
}



</script> 

 <script src="assets/plugins/ckeditor/ckeditor.js"></script>
  
    <script>


CKEDITOR.replace( 'editor');
  minHeight: '800px'
    </script>

<?php

}

include 'template.php';

?>