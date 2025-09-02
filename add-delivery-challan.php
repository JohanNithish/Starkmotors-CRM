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
$state = $Row_customer['state'];




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

$insert_product=mysqli_query($conn,"insert into delivery_challan set customer_id = '$customer', customer_name = '$customer_name', company_name='$company_name', customer_type='$customer_type', overall_remarks='$overall_remarks', mobile='$mobile', company_address= '$company_address', products_count='$products_count', returnable_type='Returnable', delivery_challan_number='$delivery_challan_number', reference_number='$reference_number', customer_reference_number='$customer_reference_number', transportation_mode='$transportation_mode', challan_date='$challan_date', vechile_number='$vechile_number', supply_date='$supply_date', supply_place='$supply_place', total_order_amount='$total_order_amount', eway_number='$eway_number', status='Pending', created_datetime = '$currentTime', created_by=".$_SESSION['UID']." $img_subqry");

$delivery_challan_id = $conn->insert_id;


for($i=0; $i<=$products_count; $i++)
{
if($product_name[$i] !='')
{ 

$product_amount=round(($rate[$i]*$quantity[$i]),2);
$Gst_amount=round(($product_amount*($gst[$i]/100)),2);
$gst_amount= round(($gst_amount + $Gst_amount),2);
$total_product_amount= round(($total_product_amount + $product_amount),2);
$total_amount=  round(($Gst_amount + $product_amount),2);
$total_order_amount = round(($total_order_amount+ $total_amount),2);

$rs_InsValues=mysqli_query($conn,"insert into delivery_challan_product set delivery_challan_id='$delivery_challan_id', product_name='$product_name[$i]', rate='$rate[$i]', quantity = '$quantity[$i]', product_amount = '$product_amount', gst = '$gst[$i]', gst_amount = '$Gst_amount', total_amount = '$total_amount', remarks='$remarks[$i]', created_datetime = '$currentTime', created_by=".$_SESSION['UID']."");


}
}
$update_total=mysqli_query($conn,"update delivery_challan set product_amount='$total_product_amount', gst_amount='$gst_amount', total_order_amount='$total_order_amount',  created_datetime = '$currentTime' where id='$delivery_challan_id'");
$update_settings=mysqli_query($conn,"update settings set returnable_count=returnable_count+1 ");


$email=$Row_customer['email'];
$pin_code=$Row_customer['pin_code'];
$address = addslashes($Row_customer['address']);
$gst=$Row_customer['gst'];
$PRODUCT_amount=$total_product_amount;

$GST_amount=$gst_amount/2;
if($GST_amount==0){
  $GST_amount="Rs. 0";
}
else{
$GST_amount="Rs. ".$GST_amount;
}

$Tot_GST_amount="Rs. ".$gst_amount;

$total_package_amount="Rs. ".$total_package_amount;
$Total_order_amount=$total_order_amount;

if($pin_code!=''){
  $Pin_code=" - ".$pin_code;
}
if($state=='Tamil Nadu'){
  $GST_Type="SGST";
}else{
  $GST_Type="IGST";
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



$row .= '<tr><td style="padding:3px;border:1px solid #000;width:30%;font-size:14px;"><b>No of Items:</b></td>
<td style="padding:3px;border:1px solid #000;width:20%;font-size:14px;text-align:center;"><b>'.$products_count.'</b></td>
<td style="padding:3px;border:1px solid #000;width:30%;font-size:14px;"><b>Total Amount:</b></td>
<td style="padding:3px;border:1px solid #000;width:20%;font-size:14px;text-align:center;"><b>Rs. '.$total_order_amount.'</b></td></tr>';

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


$message  .=  '<table style="padding:0px;width:100%;border:1px solid #000;" cellspacing="1px"><td style="width:75%;line-height:0.55;padding:5px;" ><h1 style="text-align:center;font-size:18px;color:#000;margin:0; ">RETURNABLE DELIVERY CHALLAN <span style="line-height:1;font-size:14px;text-align:center;font-weight:normal;"><br><br>As per rule 45 of CGST Rules 2017 and 55 of CGST Rules 2017</span></h1></td>
<td style="width:25%;"><table cellpadding="2px" cellspacing="0px" style="border:1px solid #000;width:100%;">
<tr><td style="width:20%;border:1px solid #000"></td><td style="width:80%;font-size:14px;border:1px solid #000"> Original for Receipent</td></tr>
<tr><td style="width:20%;border:1px solid #000"></td><td style="width:80%;font-size:14px;border:1px solid #000"> Duplicate of Transporter</td></tr>
<tr><td style="width:20%;border:1px solid #000"></td><td style="width:80%;font-size:14px;border:1px solid #000"> Triplicate for Supplier</td></tr>
</table> </td>
</tr>
</table>
<table cellpadding="5px" cellspacing="0px" style="width:100%;border:1px solid #000;vertical-align: top;">
<tr><td style="width:49%;" ><p class="adds-titl" style="line-height:1.3;font-size:14px;margin-top:5px;margin-bottom:0;" ><b> Consignee,</b><br> <span>&nbsp;&nbsp;&nbsp;&nbsp;'.$company_name.''.wordwrap($address, 50, "<br />&nbsp;&nbsp;&nbsp;&nbsp;\n").' '.$State.$Pin_code.'</span><span style="line-height:0.2;"></span>'.$GST_info.'<br></p></td><td style="width:51%;font-size:14px;border:1px solid #000;" >
<table  cellpadding="5px" cellspacing="1px" style="width:100%;">
'.$row.'

</table>
</td></tr></table>';




$message  .=  '<table cellpadding="3px" cellspacing="0px" style="border-collapse: collapse;
width: 100%;border: 0px solid #ddd;padding:10px 7px;text-align:center;">

<tr class="tr-head" style="background-color:#287dcf;color:#fff">
<th style="width:4.5%; font-weight: 600;font-size:14px;border: 1px solid #000;border-bottom: 1px solid #000;">#</th>  

<th style="width:28%; font-weight: 600;font-size:14px;border: 1px solid #000;border-bottom: 1px solid #000;">Description of Goods</th> 
<th style="width:8.4%; font-weight: 600;font-size:14px;border: 1px solid #000;border-bottom: 1px solid #000;">HSN</th>   
<th style="width:5%; font-weight: 600;text-align:center;font-size:14px;border: 1px solid #000;border-bottom: 1px solid #000;">Qty</th> 
<th style="width:11%; font-weight: 600;font-size:14px;border: 1px solid #000;border-bottom: 1px solid #000;">Rate</th>
<th style="width:11%;text-align:center; font-weight: 600;font-size:14px;border: 1px solid #000;border-bottom: 1px solid #000;">Taxable </th>   
<th style="width:7%; font-weight: 600;font-size:10px;border: 1px solid #000;border-bottom: 1px solid #000;">GST%</th> 

<th style="width:11%;text-align:center; font-weight: 600;font-size:14px;border: 1px solid #000;border-bottom: 1px solid #000;">GST </th> 
<th style="width:14.1%;text-align:center; font-weight: 600;font-size:14px;border: 1px solid #000;border-bottom: 1px solid #000;">Total </th> 

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

  if($gst=="0"){$Gst="--";} else{$Gst=$gst."%";}
  if($gst=="0"){$Gst_amount="--";} else{$Gst_amount="Rs.".round($gst_amount,1);}

  $sel_mertics=mysqli_query($conn,"select * from product where product = '$product_name'"); 
$row_mertics=mysqli_fetch_array($sel_mertics);
$hsn_code = $row_mertics['hsn_code'];

if($row_product['remarks']!=''){ $remarks=' - '.$row_product['remarks'];}else{$remarks="";}





$message.= '<tr class="tr-head" style="color:#000">
<td style="text-align:center;width:4.5%;font-size:14px;border: 1px solid #000;border-bottom: 1px solid #000;">'.$SNo.'</td> 
<td style="text-align:left;width:28%; padding: 0px;font-size:14px;border: 1px solid #000;">'.$product_name.$remarks.'<br><span style="line-height:0px;"><br></span></td><td style="text-align:center;width:8.4%;font-size:14px;border: 1px solid #000;border-bottom: 1px solid #000;">'.$hsn_code.'</td>  
<td style="text-align:center;width:5%;font-size:14px;border: 1px solid #000;border-bottom: 1px solid #000;">'.$quantity.'</td> 
<td style="text-align:center;width:11%;font-size:14px;border: 1px solid #000;border-bottom: 1px solid #000;">Rs.'.$rate.'</td> 
<td style="text-align:center;width:11%;font-size:14px;border: 1px solid #000;border-bottom: 1px solid #000;">Rs.'.round($product_amount,1).'</td> 
<td style="text-align:center;width:7%;font-size:14px;border: 1px solid #000;border-bottom: 1px solid #000;">'.$Gst.'</td> 
<td style="text-align:center;width:11%;font-size:14px;border: 1px solid #000;border-bottom: 1px solid #000;">'.$Gst_amount.'</td>
<td style="text-align:center;width:14.1%;font-size:14px;border: 1px solid #000;border-bottom: 1px solid #000;">Rs.'.round($total_amount,1).'</td></tr>';
}

 
if($state=='Tamil Nadu'){
$message .= '</table><table cellpadding="6px" cellspacing="0px" style="border: 1px;
    width: 100%;"><tr><td class="tb-row" style="width:61%; font-weight: normal;font-size:14px;border: 1px solid #000;border-bottom: 1px solid #000;font-size:14px;text-align:center;padding: 6px;"><p style="text-align:center; font-weight: 600;font-size:14px;border: 1px solid #000;border-bottom: 1px solid #000;margin:0 0px; padding:10px;background-color: #ffff92;"><b style="font-weight: 800;">GST Details</b></p><table cellspacing="0px" style="padding:0px;width:100%"><tbody><tr></tr><tr class="tr-head" style="background-color:#fff;color:#000">
<th style="text-align:center;width:16%; font-weight: 700;font-size:14px;border: 1px solid #000;border-bottom: 1px solid #000;padding:5px;"><b style="font-weight: 800;">CGST %</b></th> 
<th style="text-align:center;width:17%; font-weight: 600;font-size:14px;border: 1px solid #000;border-bottom: 1px solid #000;padding:5px;"><b style="font-weight: 800;">CGST</b></th>
<th style="text-align:center;width:12.5%; font-weight: 600;font-size:14px;border: 1px solid #000;border-bottom: 1px solid #000;padding:5px;"><b style="font-weight: 800;">'.$GST_Type.' %</b></th>
<th style="text-align:center;width:17%; font-weight: 600;font-size:14px;border: 1px solid #000;border-bottom: 1px solid #000;padding:5px;"><b style="font-weight: 800;">'.$GST_Type.'</b></th>
<th style="text-align:center;width:21%; font-weight: 600;font-size:14px;border: 1px solid #000;border-bottom: 1px solid #000;padding:5px;"><b style="font-weight: 800;">Gross<br>Bill Value</b></th>
<th style="text-align:center;width:16.5%; font-weight: 600;font-size:14px;border: 1px solid #000;border-bottom: 1px solid #000;padding:5px;"><b style="font-weight: 800;">Total <br>GST</b></th>

</tr>';}else{
$message .= '</table><table cellspacing="0px" cellpadding="6px" style="border: 1px;
    width: 100%;"><tr><td class="tb-row" style="width:61%; font-weight: normal;font-size:14px;border: 1px solid #000;border-bottom: 1px solid #000;font-size:14px;text-align:center;padding: 6px;"><p style="text-align:center; font-weight: 600;font-size:14px;border: 1px solid #000;border-bottom: 1px solid #000;margin:0 0px; padding:10px;background-color: #ffff92;"><b style="font-weight: 800;">GST Details</b></p><table cellspacing="0px" style="padding:0px 7px 7px 7px;width:100%"><tbody><tr class="tr-head" style="background-color:#fff;color:#000">
<th style="text-align:center;width:25%; font-weight: 600;font-size:14px;border: 1px solid #000;border-bottom: 1px solid #000;"><b style="font-weight: 800;">'.$GST_Type.' %</b></th>
<th style="text-align:center;width:25%; font-weight: 600;font-size:14px;border: 1px solid #000;border-bottom: 1px solid #000;"><b style="font-weight: 800;">'.$GST_Type.'</b></th>
<th style="text-align:center;width:25%; font-weight: 600;font-size:14px;border: 1px solid #000;border-bottom: 1px solid #000;"><b style="font-weight: 800;">Gross<br>Bill Value</b></th>
<th style="text-align:center;width:25%; font-weight: 600;font-size:14px;border: 1px solid #000;border-bottom: 1px solid #000;"><b style="font-weight: 800;">Total <br>GST</b></th>

</tr>';
}

$sel_gstTax=mysqli_query($conn,"SELECT *,COALESCE(SUM(gst_amount),0) as totalgst, COALESCE(SUM(product_amount),0) as tproductamt FROM delivery_challan_product where delivery_challan_id='$delivery_challan_id' GROUP BY gst ");


while($rows_tax=mysqli_fetch_array($sel_gstTax))
{
$cgst = round($rows_tax['totalgst']/2,2);
$cross_amt = $product_amount - $gst_amount;
$TGT = round($rows_tax['totalgst'],2);
if($gst_type == 0){
  $withouGstAmount = $rows_tax['tproductamt']; 
}else{
  $withouGstAmount = $rows_tax['tproductamt'] - $TGT; 
}

if($state=='Tamil Nadu'){
  $gstPercnt=$rows_tax['gst']/2;

$message.= '<tr class="tr-head" style="color:#000">
<td style="text-align:center;width:16%;font-size:14px;border: 1px solid #000;border-bottom: 1px solid #000;padding:3px;">'.$gstPercnt.'%</td> 
<td style="text-align:center;width:17%;font-size:14px;border: 1px solid #000;border-bottom: 1px solid #000;padding:3px;">'.$cgst.'</td> 
<td style="text-align:center;width:12.5%;font-size:14px;border: 1px solid #000;border-bottom: 1px solid #000;padding:3px;">'.$gstPercnt.'%</td> 
<td style="text-align:center;width:17%;font-size:14px;border: 1px solid #000;border-bottom: 1px solid #000;padding:3px;">'.$cgst.'</td> 
<td style="text-align:center;width:21%;font-size:14px;border: 1px solid #000;border-bottom: 1px solid #000;padding:3px;">'.$withouGstAmount.'</td> 
<td style="text-align:center;width:16.5%;font-size:14px;border: 1px solid #000;border-bottom: 1px solid #000;padding:3px;">'.$TGT.'</td></tr>';
}else{
  $gstPercnt=$rows_tax['gst'];
$igst = round($rows_tax['totalgst'],2);
  $message.= '<tr class="tr-head" style="color:#000">
<td style="text-align:center;width:25%;font-size:14px;border: 1px solid #000;border-bottom: 1px solid #000;padding:3px; ">'.$gstPercnt.'%</td> 
<td style="text-align:center;width:25%;font-size:14px;border: 1px solid #000;border-bottom: 1px solid #000;padding:3px; ">'.$igst.'</td> 
<td style="text-align:center;width:25%;font-size:14px;border: 1px solid #000;border-bottom: 1px solid #000;padding:3px; ">'.$withouGstAmount.'</td> 
<td style="text-align:center;width:25%;font-size:14px;border: 1px solid #000;border-bottom: 1px solid #000;padding:3px; ">'.$TGT.'</td></tr>';
}


}

if($overall_remarks!=''){
$Notes='<div style="text-align:justify;font-size:14px;"><strong>Notes: </strong>'.$overall_remarks.'</div>';
}

$message.= '</tbody> '.$Notes.'</table></td><td class="tb-row" style="width:39%;padding: 6px; font-weight: normal;background-color:#fff;font-size:13px;border: 1px solid #000;border-bottom: 1px solid #000;font-size:13px;text-align:right;"><table cellpadding="7px" cellspacing="0px"  style="padding:8px;width: 100%;"><tr><td class="tb-row" style="width:60%; font-weight: normal;font-size:13px;border: 1px solid #000;border-bottom: 1px solid #000;padding:5px;background-color:#ffff92;"><b>Taxable</b></td> 

<td class="tb-row" style="width:40%; font-weight: normal;font-size:14px;border: 1px solid #000;border-bottom: 1px solid #000;padding:5px;background-color:#ffff92;">Rs. '.$PRODUCT_amount.'</td></tr>';


if($state=='Tamil Nadu'){
$message.= '<tr ><td class="tb-row" style="width:60%; font-weight: normal;font-size:14px;border: 1px solid #000;border-bottom: 1px solid #000;font-size:14px;text-align:right;"><b>CGST &nbsp;</b></td>  
 
<td class="tb-row" style="width:40%; font-weight: normal;font-size:14px ;border: 1px solid #000;border-bottom: 1px solid #000;padding:5px;">'.$GST_amount.'</td></tr>';

$message.= '<tr ><td class="tb-row" style="width:60%; font-weight: normal;font-size:14px;border: 1px solid #000;border-bottom: 1px solid #000;font-size:14px;text-align:right;"><b>SGST &nbsp;</b></td>  

<td class="tb-row" style="width:40%; font-weight: normal;font-size:14px ;border: 1px solid #000;border-bottom: 1px solid #000;padding:5px;">'.$GST_amount.'</td></tr>';
}else{
  $message.= '<tr ><td class="tb-row" style="width:60%; font-weight: normal;font-size:14px;border: 1px solid #000;border-bottom: 1px solid #000;font-size:14px;text-align:right;"><b>IGST &nbsp;</b></td>  

<td class="tb-row" style="width:40%; font-weight: normal;font-size:14px ;border: 1px solid #000;border-bottom: 1px solid #000;padding:5px;">'.$Tot_GST_amount.'</td></tr>';
}
$message.= '<tr ><td class="tb-row" style="width:60%; font-weight: normal;font-size:14px;border: 1px solid #000;border-bottom: 1px solid #000;font-size:14px;text-align:right;"><b>Total GST &nbsp;</b></td>  

<td class="tb-row" style="width:40%; font-weight: normal;font-size:14px ;border: 1px solid #000;border-bottom: 1px solid #000;padding:5px;">'.$Tot_GST_amount.'</td></tr>';


$message.= '<tr ><td class="tb-row" style="width:60%; font-weight: normal;font-size:14px;border: 1px solid #000;border-bottom: 1px solid #000;font-size:14px;background-color:#ffff92;text-align:right;"><b>Grand Total &nbsp;</b></td>  

<td class="tb-row" style="width:40%; font-weight: normal;font-size:14px ;border: 1px solid #000;border-bottom: 1px solid #000;background-color:#ffff92;padding:5px;">Rs. '.$Total_order_amount.'</td></tr></table>';

$message.= '</td></tr>
</table>';

$message.= '<table cellspacing="0px" cellpadding="0px" style="width:100%;"><tr style="width:100%;">
<tr><td style="text-align:center;width:20%;padding:5px;font-size:14px;border: 1px solid #000;"><b>Total Amount in Words:&nbsp;&nbsp;&nbsp;&nbsp;</b></td><td style="text-align:center;padding:5px;width:80%;font-size:14px;border: 1px solid #000;"><span style="text-transform:uppercase;font-weight:bold;">'.getIndianCurrency($Total_order_amount).'</span></td></tr></table>';

$message.= '<table cellspacing="0px" cellpadding="0px" style="width:100%;"><tr style="width:100%;">
<td style="text-align:center;width:100%;font-size:14px;border: 1px solid #000;padding:5px;">As per above rules, Jobwork Materials are processed and return back along with Duplicate Challan and Invoice for Jobwork charges</td></tr></table>';
if($terms_condition!=''){
$message  .=  '<table cellspacing="0px" cellpadding="0px" style="border-spacing: 6px 5px;padding:5px 5px;border: 1px solid #000;border-bottom: 0px solid #000;">
<tr class="no-bdr" nobr="true"><td style="width:100%;font-size:12px;font" ><b>Terms & Conditions:</b></td></tr>
                 <tr class="no-bdr" nobr="true" style="padding:5px;"><td style="width:100%;font-size:14px;" >'.$terms_condition.'
                </td></tr></table>';
}



$ext1 = strtolower(substr(strrchr($upload_1, "."), 1));
$ext2 = strtolower(substr(strrchr($upload_2, "."), 1));
$ext3 = strtolower(substr(strrchr($upload_3, "."), 1));

if($upload_1!='' && $ext1!='pdf'){
$img.='<td style="width:33.3%;line-height:1.5; text-align:left;margin:0px;font-size:11px;">
<img src="uploads/'.$upload_1.'" width="170px"></td>';
}
if($upload_2!='' && $ext2!='pdf'){
$img.='<td style="width:33.3%;line-height:1.5; text-align:left;margin:0px;font-size:11px;">
<img src="uploads/'.$upload_2.'" width="170px"></td>';
}
if($upload_3!='' && $ext3!='pdf'){
$img.='<td style="width:33.3%;line-height:1.5; text-align:left;margin:0px;font-size:11px;">
<img src="uploads/'.$upload_3.'" width="170px"></td>';
}

$message  .=  '<table cellspacing="0px" cellpadding="5px" style="width:100%;padding:15px;line-height:0;background-color:#e8e8e8;border: 1px solid #000;">
<tr nobr="true">
<td style="width:80%;line-height:1.5; text-align:left;margin:0px;font-size:14px;">
<table cellpadding="5px" class="no-bdr" style="padding:15px;line-height:0;background-color:#e8e8e8;">
<tr nobr="true">
'.$img.'</tr>
</table>
</td>
<td style="width:20%;line-height:1.5; text-align:right;margin:0px;font-size:14px;">For '.$company_caps.'
<br>
<br>
<br>
<br>
<br>
Authorised Signatory
</td></tr>
</table>';
$message  .=  '</body></html>';

$subject="New Returnable Delivery Challan Created for ".$delivery_challan_number;
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
header('Location:list-delivery-challan.php?msg='.$msg);
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
$update_product=mysqli_query($conn,"update delivery_challan set customer_id = '$customer', customer_name = '$customer_name', company_name='$company_name', customer_type='$customer_type', overall_remarks='$overall_remarks', mobile='$mobile', company_address= '$company_address', products_count='$products_count', returnable_type='Returnable', delivery_challan_number='$delivery_challan_number', reference_number='$reference_number', customer_reference_number='$customer_reference_number', transportation_mode='$transportation_mode', challan_date='$challan_date', vechile_number='$vechile_number', supply_date='$supply_date', supply_place='$supply_place', total_order_amount='$total_order_amount', eway_number='$eway_number', modified_datetime = '$currentTime', created_by=".$_SESSION['UID']." $img_subqry where id='$ID' ");


$delivery_challan_ProductDelete = mysqli_query($conn,"delete from delivery_challan_product where delivery_challan_id ='$ID' ");


for($i=0; $i<=$products_count; $i++)
{
if($product_name[$i] !='')
{ 

$product_amount=round(($rate[$i]*$quantity[$i]),2);
$Gst_amount=round(($product_amount*($gst[$i]/100)),2);
$gst_amount= round(($gst_amount + $Gst_amount),2);
$total_product_amount= round(($total_product_amount + $product_amount),2);
$total_amount=  round(($Gst_amount + $product_amount),2);
$total_order_amount = round(($total_order_amount+ $total_amount),2);

$rs_InsValues=mysqli_query($conn,"insert into delivery_challan_product set delivery_challan_id='$ID', product_name='$product_name[$i]', rate='$rate[$i]', quantity = '$quantity[$i]', product_amount = '$product_amount', gst = '$gst[$i]', gst_amount = '$Gst_amount', total_amount = '$total_amount', remarks='$remarks[$i]', total_inward = '$total_inward[$i]', created_datetime = '$currentTime', created_by=".$_SESSION['UID']."");
}
}

$update_total=mysqli_query($conn,"update delivery_challan set product_amount='$total_product_amount', gst_amount='$gst_amount', total_order_amount='$total_order_amount', modified_datetime = '$currentTime' where id='$ID' ");

$sel_values_product=mysqli_query($conn,"select * from delivery_challan_product where quantity != total_inward and delivery_challan_id='$ID' "); 
if(mysqli_num_rows($sel_values_product)==0){
$updateChallan=mysqli_query($conn,"update delivery_challan set status = 'Received', modified_datetime='$currentTime' where  id = '$ID' ");
}

if($update_product && $rs_InsValues)
{
$msg = 'Delivery Challan Updated Successfully';
header('Location:list-delivery-challan.php?msg='.$msg);
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
$max_user_id=$row_User_Id['returnable_count'];
$delivery_challan_number ='SDC'.str_pad($max_user_id,3, "0", STR_PAD_LEFT);
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
<h5 class="text-uppercase mb-0"><?if($CountQtn>>0){ echo"Update";}else{echo "Add";}?> Returnable Delivery Challan</span></h5>
<?if($CountQtn>>0){?> <a href="list-delivery-challan.php" class="btn btn-danger">Back</a><?}?> 
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
<label for="inputLastName" class="form-label mt-20 mb-0">Select Product</label>

</div>

<div class="w-7-5">
<label for="inputLastName" class="form-label mt-20 mb-0">Rate</label>

</div>
<div class="w-6">
<label for="inputLastName" class="form-label mt-20 mb-0">Qty.</label>
</div>


<div class="w-7">
<label for="inputLastName" class="form-label mt-20 mb-0">GST (%)</label>
</div>

<div class="w-28-5">
<label for="inputLastName" class="form-label mt-20 mb-0">Remarks</label>
</div>



<div class="w-12">
<label for="inputLastName" class="form-label mt-20 mb-0">Total</label>

</div>

<div class="w-5 text-end">
<label for="inputtext" class="form-label mt-20 mb-0">Action</label>
</div>
</div>

<div class="row my-1" id="p_scents">

<div class="w-28-5">
<select class="multiple-select" name="product_name[]" id="product_name1" onchange="getPrice(this.value, '1')" required>
<option value="">Select Product</option>
<? 
$sql_product=mysqli_query($conn,"select * from  product where status='1' ORDER BY product asc"); 
while($row_product=mysqli_fetch_array($sql_product))
{
?>
<option value="<?=$row_product['product']?>" <? if($row_product['product'] == $ID) { ?>selected<? } ?> ><?=$row_product['product'];?></option>
<?
}
?>
</select>
</div>

<div class="w-7-5">
<input type="number" class="form-control p-qnt" id="rate1" name="rate[]" step="any" onchange="getTotal(1)" placeholder="Rate" required <?if($_SESSION['USERTYPE']==1){ echo "readonly";}?>>
</div>
<div class="w-6">
<input type="number" class="form-control p-qnt" id="quantity1" min="0" onchange="getTotal(1)" name="quantity[]" placeholder="Qty" required>
</div>

<div class="w-7">
<select class="form-select p-qnt" onchange="getTotal(1)" name="gst[]" id="gst1">
<option value="0">0%</option>
<option value="5">5%</option>
<option value="12">12%</option>
<option value="18" selected>18%</option>
<option value="28">28%</option>
</select>
</div>
<div class="w-28-5">
<textarea class="form-control" rows="1" id="remarks1" name="remarks[]" placeholder="Remarks"></textarea>
</div>

<div class="w-12">
<label class="ItemTotal fw-6" id="tot1">₹0.00</label>
<input type="hidden" id="tot_val1" name="total_amount[]">
</div>
<div class="w-5 text-end">
<a type="button" id="addScnt" tooltip="Add Product" class="pe-1"  style="width: auto;" ><img src="assets/images/Our/plus2.png" width="27px;"> </a>

</div>
</div>
<? } else { ?>

<div class="row g-2 mt-1 mb-2">
<div class="w-28-5">
<label for="inputLastName" class="form-label mt-20 mb-0">Select Product</label>
</div>

<div class="w-7-5">
<label for="inputLastName" class="form-label mt-20 mb-0">Rate</label>

</div>
<div class="w-6">
<label for="inputLastName" class="form-label mt-20 mb-0">Qty.</label>
</div>


<div class="w-7">
<label for="inputLastName" class="form-label mt-20 mb-0">GST (%)</label>
</div>

<div class="w-28-5">
<label for="inputLastName" class="form-label mt-20 mb-0">Remarks</label>
</div>


<div class="w-12">
<label for="inputLastName" class="form-label mt-20 mb-0">Total</label>

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
$total_inward=$row_product['total_inward'];
$remarks=$row_product['remarks'];
?>

<div class="row my-1" id="p_scents">

<div class="w-28-5">
<?if($total_inward>>0){?>
<input type="text" class="form-control"  name="product_name[]" id="product_name<?=$SNo;?>" onchange="getPrice(this.value, '<?=$SNo?>')"  value="<?=$product_name;?>" required readonly>
<?}else{?>
<select class="multiple-select" name="product_name[]" id="product_name<?=$SNo;?>" onchange="getPrice(this.value, '<?=$SNo?>')" required>
<option value="">Select Product</option>
<? 
$sql_product=mysqli_query($conn,"select * from  product where status='1' ORDER BY product asc"); 
while($row_product=mysqli_fetch_array($sql_product))
{
?>
<option value="<?=$row_product['product']?>" <? if($row_product['product'] == $product_name) { ?>selected<? } ?> ><?=$row_product['product'];?></option>
<?
}
?>
</select>
<?}?>
</div>

<div class="w-7-5">
<input type="number" class="form-control p-qnt" id="rate<?=$SNo?>" name="rate[]" step="any" onchange="getTotal(<?=$SNo?>);" placeholder="Rate" value="<?=$rate;?>" required <?if($_SESSION['USERTYPE']==1){ echo "readonly";}?>>
<input type="hidden" id="rateChange<?=$SNo?>" value="1">
</div>

<div class="w-6">
<input type="number" class="form-control p-qnt" id="quantity<?=$SNo?>" onchange="getTotal(<?=$SNo?>);" name="quantity[]" placeholder="Qty" min="<?=$total_inward;?>" value="<?=$quantity;?>" required>
<input type="hidden" name="total_inward[]" value="<?=$total_inward;?>">
</div>

<div class="w-7">
<select class="form-select p-qnt" onchange="getTotal(<?=$SNo?>);" name="gst[]" id="gst<?=$SNo?>">
<option value="0" <? if($gst == "0") { ?>selected<? } ?>>0%</option>
<option value="5" <? if($gst == "5") { ?>selected<? } ?>>5%</option>
<option value="12" <? if($gst == "12") { ?>selected<? } ?>>12%</option>
<option value="18" <? if($gst == "18") { ?>selected<? } ?>>18%</option>
<option value="28" <? if($gst == "28") { ?>selected<? } ?>>28%</option>
</select>
<input type="hidden" id="gstChange<?=$SNo?>" value="1">
</div>
<div class="w-28-5">
<textarea class="form-control" rows="1" id="remarks<?=$SNo?>" name="remarks[]" placeholder="Remarks"><?=$remarks;?></textarea>
</div>

<div class="w-12">
<label class="ItemTotal fw-6" id="tot<?=$SNo?>">₹<?=$total_amount;?></label>
<input type="hidden" id="tot_val<?=$SNo?>" name="total_amount[]" value="<?=$total_amount;?>">
</div>
<? if($SNo == 1){ ?>
<div class="w-5 text-end">
<a type="button" id="addScnt" class="pe-1" tooltip="Add Product" style="width: auto;" ><img src="assets/images/Our/plus2.png" width="27px;"> </a></div>
<?} else {  
 if($total_inward>>0){?>
<div class="w-5 text-end" id="remScnt" ><a type="button" style="width: auto;filter: grayscale(1);" class="pe-1"><img src="assets/images/Our/minus.png" width="27px;"></a></div>
<? }else{?>
<div class="w-5 text-end" id="remScnt" onclick="removeCont(this);"><a type="button" tooltip="Remove Product"  style="width: auto" class="pe-1"><img src="assets/images/Our/minus.png" width="27px;"></a></div>

 <?} } ?>

</div>
<? } ?>
<? } ?>
</div>
<hr>


<div class="col-md-12 row g-3">

<div class="col-lg-6">
      <label for="inputAddress" class="form-label">Notes</label>
      <textarea rows="4" class="form-control" name="overall_remarks"><?=stripslashes($overall_remarks);?></textarea>
</div>

<div class="col-md-6 ">
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

// function getReturnable(val) {
// if (val != 'Recivable') {
// $('.recivable_type').hide();
// } else {
// $('.recivable_type').show();
// }
// }



var scntDiv = $("#frm_scents");
var i = $("[id=p_scents]").length + 1;

$(function() {
$("#addScnt").click(function() {
$('<div class="row my-1 slide_show" id="p_scents" style="display:none"><div class="w-28-5"><select class="multiple-select" name="product_name[]" id="product_name'+i+'" onchange="getPrice(this.value, '+i+')" required><option value="">Select Product</option><? $sql_product=mysqli_query($conn,"select * from  product where status='1' ORDER BY product asc"); while($row_product=mysqli_fetch_array($sql_product)){?><option value="<?=$row_product['product']?>" <? if($row_product['product'] == $ID) { ?>selected<? } ?> ><?=$row_product['product'];?></option><?}?></select></div><div class="w-7-5"><input type="number" class="form-control  p-qnt" id="rate'+i+'" name="rate[]" step="any" onchange="getTotal('+i+');" placeholder="Rate" required <?if($_SESSION['USERTYPE']==1){ echo "readonly";}?>><input type="hidden" id="rateChange'+i+'" value="1"></div><div class="w-6"><input type="number" class="form-control p-qnt" id="quantity'+i+'" name="quantity[]" min="0" onchange="getTotal('+i+');" placeholder="Qty" required><input type="hidden" id="qtyChange'+i+'" value="1"></div><div class="w-7"><select class="form-select p-qnt" onchange="getTotal('+i+');" name="gst[]" id="gst'+i+'"><option value="0" selected>0%</option><option value="5">5%</option><option value="12">12%</option><option value="18" selected>18%</option><option value="28">28%</option></select><input type="hidden" id="gstChange'+i+'" value="1"></div><div class="w-28-5"><textarea class="form-control" rows="1" id="remarks'+i+'" name="remarks[]" placeholder="Remarks" ></textarea></div><div class="w-12"><label class="ItemTotal fw-6" id="tot'+i+'">₹0.00</label><input type="hidden" id="tot_val'+i+'" name="total_amount[]"></div><div class="w-5 text-end" id="remScnt" onclick="removeCont(this);"><a type="button" tooltip="Remove Product" style="width: auto;" class="pe-1"><img src="assets/images/Our/minus.png" width="27px;"></a></div></div>').appendTo(scntDiv);
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

function getPrice(val,row_id){
customer_type=$("#customer_type").val();
if(customer_type !=''){
$.ajax({
url: "fetch-price.php", 
type: "POST",
data: "id="+encodeURIComponent(val)+"&row_id="+row_id+"&customer_type="+customer_type,
success: function(result){
$("#rate"+row_id).val(result);
if($("#quantity"+row_id).val()!=''){
getTotal(row_id);
}
}});
}
}

function getTotal(row_id){
rate=$("#rate"+row_id).val();
quantity=$("#quantity"+row_id).val();
gst=$("#gst"+row_id).val();
total=rate*quantity;
if(gst!='0'){
tot_gst=(parseFloat(total)+((parseFloat(total)*(parseFloat(gst)/100)))).toFixed(2);
}else{
tot_gst=(total).toFixed(2);
}
$("#tot"+row_id).html('₹'+tot_gst);
$("#tot_val"+row_id).val(tot_gst);
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