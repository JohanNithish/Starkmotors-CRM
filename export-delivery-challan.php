<?
ob_start();
ob_clean();
session_start();
if($_SESSION['UID']=='' ) header('Location:index.php');
include 'dilg/cnt/join.php';
include 'global-functions.php';
date_default_timezone_set("Asia/Kolkata");
$currentTime = date('Y-m-d H:i:s');
$currentDate = date('d-m-Y');
extract($_REQUEST);

$ID = $_GET['id'];
$order_id = $ID;

$sel_rows=mysqli_query($conn,"select * from delivery_challan where id='$ID' ");
$rows_R = mysqli_fetch_object($sel_rows);

foreach($rows_R as $K1=>$V1) $$K1 = $V1;
$PRODUCT_amount=$product_amount;

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
$select_customer=mysqli_query($conn,"select * from customer where id='$customer_id'");
$row_customer=mysqli_fetch_array($select_customer);
$company_name=$row_customer['company_name'];
$customer_type=$row_customer['customer_type'];
$customer_name=addslashes($row_customer['customer_name']);
$gst=$row_customer['gst'];
$address=addslashes($row_customer['address']);
$mobile=$row_customer['mobile'];
$email=$row_customer['email'];
$pin_code=$row_customer['pin_code'];
$state=$row_customer['state'];
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
$Address_2="<table class=\"no-bdr\"><tr><td style=\"text-align:left;width:40%;font-size:12px;\">&nbsp;&nbsp;<b>Stark Engineers, </b></td><td style=\"text-align:right;width:60%;font-size:12px;\"><b><small style=\"font-size:10px;\">".$Doc_NUM." </small> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></td></tr></table><br>&nbsp;&nbsp;3/360-363, Manickampalayam, Karuvalur, <br>&nbsp;&nbsp;Main Road, Coimbatore, Tamil Nadu - 641107";
$Gst_address="33ADEFS5652D1Z9";
}
else{
$company_caps='STARK MOTORS';
$Company_address ="Stark motors, 96 sitra road, Kalapatti, Coimbatore 641048";
$Address_2="<table class=\"no-bdr\"><tr><td style=\"text-align:left;width:40%;font-size:12px;\">&nbsp;&nbsp;<b>Stark Motors, </b></td><td style=\"text-align:right;width:60%;font-size:12px;\"><b><small style=\"font-size:10px;\">".$Doc_NUM." </small> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></td></tr></table><br>&nbsp;&nbsp;96, Sitra Road, Kalapatti,<br>&nbsp;&nbsp;Coimbatore - 641048,";
$Gst_address="33AAMFS3000L1ZC";

}
require_once('tcpdf/tcpdf.php'); 

class MYPDF extends TCPDF { 
public function Header() {
}

public function Footer() {
// Position at 25 mm from bottom
$this->SetY(-15);
// Set font
$this->SetFont('helvetica', 'I', 8);

$this->Cell(0, 0, $GLOBALS['Company_address'], 0, 0, 'C');


$this->Ln();
$this->Cell(0,0,'Landline: 0422-4274969, 0422-4385612, Website: www.starkmotors.com Email: satish@starkmotors.com', 0, false, 'C', 0, '', 0, false, 'T', 'M');

// Page number
$this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
}


}
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);

$pdf->SetTitle('Stark Motors');

$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

$pdf->SetMargins(PDF_MARGIN_LEFT-9, PDF_MARGIN_TOP-23, PDF_MARGIN_RIGHT-9);

$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

$pdf->SetFont('helvetica', '', 15); 

$pdf->AddPage();


$htmlData   .=  '<style>
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
line-height: 10px !important;
font-size: 12px;
color:#000;

}
th, td {
  padding: 15px;
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
</style>';

if($OrderDate >= $Dates){
$product_amount = $product_amount + $discount_amount;
}
else{
$product_amount = $product_amount;
}


if($state!=''){
$State='<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$state;
}


if ($delivery_challan_number != '' || $transportation_mode != '') {
$row .= '<tr>';
if($delivery_challan_number != ''){
$row .= '<td style="width:30%;font-size:10px;"><b>Delivery Challan No</b></td>
<td style="width:20%;font-size:10px;text-align:center;">'.$delivery_challan_number.'</td>';
}
if($transportation_mode != ''){
$row .= '<td style="width:30%;font-size:10px;"><b>Transportation Mode</b></td>
<td style="width:20%;font-size:10px;text-align:center;">'.$transportation_mode.'</td>';
}
if($transportation_mode == '' || $delivery_challan_number == ''){
$row .= '<td style="width:50%;"></td>';
}
$row .= '</tr>';
}



if($challan_date != '0000-00-00' || $vechile_number != '') {
$row .= '<tr>';
if($challan_date != '0000-00-00'){
$row .= '<td style="width:30%;font-size:10px;"><b>Date</b></td>
<td style="width:20%;font-size:10px;text-align:center;">'.date('d-m-Y',strtotime($challan_date)).'</td>';
}
if($vechile_number != ''){
$row .= '<td style="width:30%;font-size:10px;"><b>Vechile No</b></td>
<td style="width:20%;font-size:10px;text-align:center;">'.$vechile_number.'</td>';
}
if($challan_date == '0000-00-00' || $vechile_number == ''){
$row .= '<td style="width:50%;"></td>';
}
$row .= '</tr>';
}

if($supply_date != '0000-00-00' || $state != '') {
$row .= '<tr>';
if($state != ''){
$row .= '<td style="width:30%;font-size:10px;"><b>State</b></td>
<td style="width:20%;font-size:10px;text-align:center;">'.$state.'</td>';
}
if($supply_date != '0000-00-00'){
$row .= '<td style="width:30%;font-size:10px;"><b>Supply Date</b></td>
<td style="width:20%;font-size:10px;text-align:center;">'.date('d-m-Y',strtotime($supply_date)).'</td>';
}
if($supply_date == '0000-00-00' || $state == ''){
$row .= '<td style="width:50%;"></td>';
}
$row .= '</tr>';
}

if($supply_place != '' || $reference_number != '') {
$row .= '<tr>';
if($reference_number != ''){
$row .= '<td style="width:30%;font-size:10px;"><b>Ref No</b></td>
<td style="width:20%;font-size:10px;text-align:center;">'.$reference_number.'</td>';
}
if($supply_place != ''){
$row .= '<td style="width:30%;font-size:10px;"><b>Supply Place</b></td>
<td style="width:20%;font-size:10px;text-align:center;">'.$supply_place.'</td>';
}
if($supply_place == '' || $reference_number == ''){
$row .= '<td style="width:50%;"></td>';
}
$row .= '</tr>';
}


$row .= '<tr><td style="width:30%;font-size:10px;"><b>No of Items:</b></td>
<td style="width:20%;font-size:11px;text-align:center;"><b>'.$products_count.'</b></td>
<td style="width:30%;font-size:10px;"><b>Total Amount:</b></td>
<td style="width:20%;font-size:11px;text-align:center;"><b>Rs. '.$total_order_amount.'</b></td></tr>';


if($eway_number != '') {
$row .= '<tr>';
if($eway_number != ''){
$row .= '<td style="width:30%;font-size:10px;"><b>Eway Bill No.</b></td>
<td style="width:20%;font-size:10px;text-align:center;">'.$eway_number.'</td>';
}

$row .= '<td style="width:50%;"></td>';

$row .= '</tr>';
}

if($gst !=''){
$GST_info = '
<br><br>&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-size:11px"><b> GST : 
'.$gst.'
</b></span>';
}

 $htmlData   .=  '<table style="padding:5px 5px;"><tr style="vertical-align: middle;"><td style="width:30%;" ><p class="adds-titl" ><a href="www.starkmotors.com" target="_blank" style="text-align:center;"><img src="assets/images/Our/logo2.png" width="95px;"></a></p></td><td width="70%" style="border:1px solid #000;"><p class="adds-titl" style="text-align:left;font-size:11px;line-height:15px;font-weight:normal;">'.$Address_2.'<br>&nbsp;&nbsp;Phone: + 91 94426 14612, + 91 98433 14612,<br>&nbsp;&nbsp;E-mail:sales@starkmotors.com<br>&nbsp;&nbsp;Landline: 0422 -2627672, 0422 -2627612, 0422 -4274969, 0422 -4385612,<br>&nbsp;&nbsp;GST:'.$Gst_address.'</p></td></tr></table>';


$htmlData   .=  '<table cellpadding="0px"><tr style="background-color:#fff;color:#000"><td style="width:75%;line-height:0.55;" ><br><h1 style="text-align:center;font-size:14px;color:#000;">RETURNABLE DELIVERY CHALLAN <span style="line-height:1;font-size:11px;text-align:center;font-weight:normal;"><br><br>As per rule 45 of CGST Rules 2017 and 55 of CGST Rules 2017</span></h1></td>
<td style="width:25%;"><table cellpadding="2px">
<tr><td style="width:20%;"></td><td style="width:80%;font-size:10px;"> Original for Receipent</td></tr>
<tr><td style="width:20%;"></td><td style="width:80%;font-size:10px;"> Duplicate of Transporter</td></tr>
<tr><td style="width:20%;"></td><td style="width:80%;font-size:10px;"> Triplicate for Supplier</td></tr>
</table> </td>
</tr>
</table>
<table cellpadding="0px">
<tr><td style="width:49%;" ><p class="adds-titl" style="line-height:1.3;font-size:11px;" ><span style="line-height:0.2;"><br></span><b> Consignee,</b><br> <span>&nbsp;&nbsp;&nbsp;&nbsp;'.$company_name.''.wordwrap($address, 50, "<br />&nbsp;&nbsp;&nbsp;&nbsp;\n").' '.$State.$Pin_code.'</span><span style="line-height:0.2;"></span>'.$GST_info.'<br></p></td><td style="width:51%;font-size:11px;" >
<table style="padding:5px 5px;">
'.$row.'








</table>
</td></tr></table>';






$htmlData   .=  '<table style="padding:4px;"><tr class="tr-head" class="head"> 

</tr></table><br><table cellpadding="3px" style="border-collapse: collapse;
width: 100%;border: 0px solid #ddd;padding:10px 7px;text-align:center;">

<tr class="tr-head" style="background-color:#287dcf;color:#fff">
<th style="width:4.5%; font-weight: 600;font-size:11px;border: 1px solid #000;border-bottom: 1px solid #000;">#</th>  

<th style="width:28%; font-weight: 600;font-size:11px;border: 1px solid #000;border-bottom: 1px solid #000;">Description of Goods</th> 
<th style="width:8.4%; font-weight: 600;font-size:11px;border: 1px solid #000;border-bottom: 1px solid #000;">HSN</th>   
<th style="width:5%; font-weight: 600;text-align:center;font-size:11px;border: 1px solid #000;border-bottom: 1px solid #000;">Qty</th> 
<th style="width:11%; font-weight: 600;font-size:11px;border: 1px solid #000;border-bottom: 1px solid #000;">Rate</th>
<th style="width:11%;text-align:center; font-weight: 600;font-size:11px;border: 1px solid #000;border-bottom: 1px solid #000;">Taxable </th>   
<th style="width:7%; font-weight: 600;font-size:10px;border: 1px solid #000;border-bottom: 1px solid #000;">GST%</th> 

<th style="width:11%;text-align:center; font-weight: 600;font-size:11px;border: 1px solid #000;border-bottom: 1px solid #000;">GST </th> 
<th style="width:14.1%;text-align:center; font-weight: 600;font-size:11px;border: 1px solid #000;border-bottom: 1px solid #000;">Total </th> 

</tr>'; 
$SNo=0;
$sel_product=mysqli_query($conn,"select * from delivery_challan_product where delivery_challan_id='$ID' ");
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
    $estimated_delivery_date='<tr nobr="true"><hr><td style="width:100%;"><b style="line-height:1.5;text-align:left;font-size:10px;">Estimated Delivery: </b><span style="font-size:10px;margin:0;">&nbsp;&nbsp;&nbsp;'.date('d-m-Y', strtotime($estimated_delivery)).'</span></td></tr>';
  }else{
$estimated_delivery_date=" ";
  }

  if($gst=="0"){$Gst="--";} else{$Gst=$gst."%";}
  if($gst=="0"){$Gst_amount="--";} else{$Gst_amount="Rs.".round($gst_amount,1);}

  $sel_mertics=mysqli_query($conn,"select * from product where product = '$product_name'"); 
$row_mertics=mysqli_fetch_array($sel_mertics);
$hsn_code = $row_mertics['hsn_code'];

if($row_product['remarks']!=''){ $remarks=' - '.$row_product['remarks'];}else{$remarks="";}





$htmlData .= '<tr class="tr-head" style="color:#000">
<td style="text-align:center;width:4.5%;font-size:10px;border: 1px solid #000;border-bottom: 1px solid #000;">'.$SNo.'</td> 
<td style="text-align:left;width:28%; padding: 0px;font-size:10px;border: 1px solid #000;">'.$product_name.$remarks.'<br><span style="line-height:0px;"><br></span></td><td style="text-align:center;width:8.4%;font-size:10px;border: 1px solid #000;border-bottom: 1px solid #000;">'.$hsn_code.'</td>  
<td style="text-align:center;width:5%;font-size:10px;border: 1px solid #000;border-bottom: 1px solid #000;">'.$quantity.'</td> 
<td style="text-align:center;width:11%;font-size:10px;border: 1px solid #000;border-bottom: 1px solid #000;">Rs.'.$rate.'</td> 
<td style="text-align:center;width:11%;font-size:10px;border: 1px solid #000;border-bottom: 1px solid #000;">Rs.'.round($product_amount,1).'</td> 
<td style="text-align:center;width:7%;font-size:10px;border: 1px solid #000;border-bottom: 1px solid #000;">'.$Gst.'</td> 
<td style="text-align:center;width:11%;font-size:10px;border: 1px solid #000;border-bottom: 1px solid #000;">'.$Gst_amount.'</td>
<td style="text-align:center;width:14.1%;font-size:10px;border: 1px solid #000;border-bottom: 1px solid #000;">Rs.'.round($total_amount,1).'</td></tr>';
}

 
if($state=='Tamil Nadu'){
$htmlData .= '</table><table cellpadding="6px" style="padding:10px;"><tr><td class="tb-row" style="width:61%; font-weight: normal;font-size:12px;border: 1px solid #000;border-bottom: 1px solid #000;font-size:12px;text-align:center;"><table style="padding:7px;"><tr class="tr-head" style="background-color:#ffff92;color:#000"><th style="text-align:center; font-weight: 600;font-size:12px;border: 1px solid #000;border-bottom: 1px solid #000;"><b>GST Details</b></th></tr><tr class="tr-head" style="background-color:#fff;color:#000">
<th style="text-align:center;width:16%; font-weight: 600;font-size:9px;border: 1px solid #000;border-bottom: 1px solid #000;"><b>CGST %</b></th> 
<th style="text-align:center;width:17%; font-weight: 600;font-size:9px;border: 1px solid #000;border-bottom: 1px solid #000;"><b>CGST</b></th>
<th style="text-align:center;width:12.5%; font-weight: 600;font-size:9px;border: 1px solid #000;border-bottom: 1px solid #000;"><b>SGST %</b></th>
<th style="text-align:center;width:17%; font-weight: 600;font-size:9px;border: 1px solid #000;border-bottom: 1px solid #000;"><b>SGST</b></th>
<th style="text-align:center;width:21%; font-weight: 600;font-size:9px;border: 1px solid #000;border-bottom: 1px solid #000;"><b>Gross<br>Bill Value</b></th>
<th style="text-align:center;width:16.5%; font-weight: 600;font-size:9px;border: 1px solid #000;border-bottom: 1px solid #000;"><b>Total <br>GST</b></th>

</tr>';
}else{
  $htmlData .= '</table><table cellpadding="6px" style="padding:10px;"><tr><td class="tb-row" style="width:61%; font-weight: normal;font-size:12px;border: 1px solid #000;border-bottom: 1px solid #000;font-size:12px;text-align:center;"><table style="padding:7px;"><tr class="tr-head" style="background-color:#ffff92;color:#000"><th style="text-align:center; font-weight: 600;font-size:12px;border: 1px solid #000;border-bottom: 1px solid #000;"><b>GST Details</b></th></tr><tr class="tr-head" style="background-color:#fff;color:#000">
<th style="text-align:center;width:25%; font-weight: 600;font-size:9px;border: 1px solid #000;border-bottom: 1px solid #000;"><b>IGST %</b></th>
<th style="text-align:center;width:25%; font-weight: 600;font-size:9px;border: 1px solid #000;border-bottom: 1px solid #000;"><b>IGST</b></th>

<th style="text-align:center;width:25%; font-weight: 600;font-size:9px;border: 1px solid #000;border-bottom: 1px solid #000;"><b>Gross<br>Bill Value</b></th>
<th style="text-align:center;width:25%; font-weight: 600;font-size:9px;border: 1px solid #000;border-bottom: 1px solid #000;"><b>Total <br>GST</b></th>

</tr>';
}

$sel_gstTax=mysqli_query($conn,"SELECT *,COALESCE(SUM(gst_amount),0) as totalgst, COALESCE(SUM(product_amount),0) as tproductamt FROM delivery_challan_product where delivery_challan_id='$ID' GROUP BY gst ");


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

$htmlData .= '<tr class="tr-head" style="color:#000">
<td style="text-align:center;width:16%;font-size:10px;border: 1px solid #000;border-bottom: 1px solid #000;">'.$gstPercnt.'%</td> 
<td style="text-align:center;width:17%;font-size:10px;border: 1px solid #000;border-bottom: 1px solid #000;">'.$cgst.'</td> 
<td style="text-align:center;width:12.5%;font-size:10px;border: 1px solid #000;border-bottom: 1px solid #000;">'.$gstPercnt.'%</td> 
<td style="text-align:center;width:17%;font-size:10px;border: 1px solid #000;border-bottom: 1px solid #000;">'.$cgst.'</td> 
<td style="text-align:center;width:21%;font-size:10px;border: 1px solid #000;border-bottom: 1px solid #000;">'.$withouGstAmount.'</td> 
<td style="text-align:center;width:16.5%;font-size:10px;border: 1px solid #000;border-bottom: 1px solid #000;">'.$TGT.'</td></tr>';
}else{
  $gstPercnt=$rows_tax['gst'];
$igst = round($rows_tax['totalgst'],2);
  $htmlData .= '<tr class="tr-head" style="color:#000">
<td style="text-align:center;width:25%;font-size:10px;border: 1px solid #000;border-bottom: 1px solid #000;">'.$gstPercnt.'%</td> 
<td style="text-align:center;width:25%;font-size:10px;border: 1px solid #000;border-bottom: 1px solid #000;">'.$igst.'</td> 
<td style="text-align:center;width:25%;font-size:10px;border: 1px solid #000;border-bottom: 1px solid #000;">'.$withouGstAmount.'</td> 
<td style="text-align:center;width:25%;font-size:10px;border: 1px solid #000;border-bottom: 1px solid #000;">'.$TGT.'</td></tr>';
}


}

if($overall_remarks!=''){
$Notes='<div style="text-align:justify;"><strong>Notes: </strong>'.$overall_remarks.'</div>';
}

$htmlData .= '</table> '.$Notes.'</td><td class="tb-row" style="width:39%; font-weight: normal;background-color:#fff;font-size:11px;border: 1px solid #000;border-bottom: 1px solid #000;font-size:11px;text-align:right;"><table cellpadding="7px" style="padding:8px;"><tr><td class="tb-row" style="width:60%; font-weight: normal;font-size:11px;border: 1px solid #000;border-bottom: 1px solid #000;padding:15px;background-color:#ffff92;"><b>Taxable Amount</b></td>  

<td class="tb-row" style="width:40%; font-weight: normal;font-size:11px;border: 1px solid #000;border-bottom: 1px solid #000;padding:15px;background-color:#ffff92;">Rs. '.$PRODUCT_amount.'</td></tr>';


if($state=='Tamil Nadu'){
$htmlData .= '<tr ><td class="tb-row" style="width:60%; font-weight: normal;font-size:11px;border: 1px solid #000;border-bottom: 1px solid #000;font-size:11px;text-align:right;"><b>CGST</b></td>  

<td class="tb-row" style="width:40%; font-weight: normal;font-size:11px ;border: 1px solid #000;border-bottom: 1px solid #000;padding:15px;">'.$GST_amount.'</td></tr>';

$htmlData .= '<tr ><td class="tb-row" style="width:60%; font-weight: normal;font-size:11px;border: 1px solid #000;border-bottom: 1px solid #000;font-size:11px;text-align:right;"><b>SGST</b></td>  

<td class="tb-row" style="width:40%; font-weight: normal;font-size:11px ;border: 1px solid #000;border-bottom: 1px solid #000;padding:15px;">'.$GST_amount.'</td></tr>';
}else{
  $htmlData .= '<tr ><td class="tb-row" style="width:60%; font-weight: normal;font-size:11px;border: 1px solid #000;border-bottom: 1px solid #000;font-size:11px;text-align:right;"><b>IGST</b></td>  

<td class="tb-row" style="width:40%; font-weight: normal;font-size:11px ;border: 1px solid #000;border-bottom: 1px solid #000;padding:15px;">'.$Tot_GST_amount.'</td></tr>';
}
$htmlData .= '<tr ><td class="tb-row" style="width:60%; font-weight: normal;font-size:11px;border: 1px solid #000;border-bottom: 1px solid #000;font-size:11px;text-align:right;"><b>Total GST</b></td>  

<td class="tb-row" style="width:40%; font-weight: normal;font-size:11px ;border: 1px solid #000;border-bottom: 1px solid #000;padding:15px;">'.$Tot_GST_amount.'</td></tr>';


$htmlData .= '<tr ><td class="tb-row" style="width:60%; font-weight: normal;font-size:11px;border: 1px solid #000;border-bottom: 1px solid #000;font-size:11px;background-color:#ffff92;text-align:right;"><b>Grand Total</b></td>  

<td class="tb-row" style="width:40%; font-weight: normal;font-size:11px ;border: 1px solid #000;border-bottom: 1px solid #000;background-color:#ffff92;padding:15px;">Rs. '.$Total_order_amount.'</td></tr></table>';

$htmlData .= '</td></tr><tr><td style="text-align:center;width:20%;font-size:10px;border: 1px solid #000;"><b>Total Amount in Words:&nbsp;&nbsp;&nbsp;&nbsp;</b></td><td style="text-align:center;width:80%;font-size:10px;border: 1px solid #000;"><span style="text-transform:uppercase;font-weight:bold;">'.getIndianCurrency($Total_order_amount).'</span></td></tr>
<tr>
<td style="text-align:center;width:100%;font-size:10px;border: 1px solid #000;">As per above rules, Jobwork Materials are processed and return back along with Duplicate Challan and Invoice for Jobwork charges</td></tr></table>';


if($terms_condition!=''){
$htmlData   .=  '<table cellpadding="0px" style="border-spacing: 6px 5px;padding:5px 5px;border: 1px solid #000;border-bottom: 0px solid #000;">
<tr class="no-bdr" nobr="true"><td style="width:100%;font-size:12px;font" ><b>Terms & Conditions:</b></td></tr>
                 <tr class="no-bdr" nobr="true" style="padding:0px 5px;"><td style="width:100%;font-size:11px;" >'.$terms_condition.'
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
if($img!=''){
$images='<table cellpadding="5px" class="no-bdr" style="padding:15px;line-height:0;background-color:#e8e8e8;">
<tr nobr="true">
'.$img.'</tr>
</table>';
}
$htmlData   .=  '<table cellpadding="5px" style="padding:15px;line-height:0;background-color:#e8e8e8;border: 1px solid #000;">
<tr nobr="true">
<td style="width:80%;line-height:1.5; text-align:left;margin:0px;font-size:11px;">
'.$images.'

</td>
<td style="width:20%;line-height:1.5; text-align:right;margin:0px;font-size:11px;"><br>For '.$company_caps.'
<br>
<br>
<br>
<br>
<br>
Authorised Signatory
</td></tr>
</table>';



// if($company_address==1)
// {
// $htmlData   .=  '<table class="no-bdr" cellpadding="5px" style="padding:15px;line-height:2;background-color:#e8e8e8;border: 2px solid #000;">
//                  <tr nobr="true"><td style="width:50%;line-height:1; border-width:0px; margin:0px;"><b class="adds-titl" style="line-height:0.5;"><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Bank Details</b><br><br><img src="assets/images/Our/qr3.png" width="120px" ></td>
//                  <td style="width:50%;line-height:1; border-width:0px;text-align:right;margin:0px;"><b class="adds-titl" style="line-height:0.5;"><br>Website&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b><br><br><img src="assets/images/Our/qr2.png" width="120px" ></td></tr></table>';
// }
// else{
//   $htmlData   .=  '<table class="no-bdr" cellpadding="5px" style="padding:15px;line-height:2;background-color:#e8e8e8;border: 2px solid #000;">
// <tr nobr="true"><td style="width:50%;line-height:1; border-width:0px; margin:0px;"><b class="adds-titl" style="line-height:0.5;"><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Bank Details</b><br><br><img src="assets/images/Our/qr1.png" width="120px" ></td>
// <td style="width:50%;line-height:1; border-width:0px;text-align:right;margin:0px;"><b class="adds-titl" style="line-height:0.5;"><br>Website&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b><br><br><img src="assets/images/Our/qr2.png" width="120px" ></td></tr></table>
// ';
// }

$htmlData   .=  '</body></html>';

$pdf->writeHTML($htmlData, true, false, true, false, '');

$pdf->lastPage();
if ($pdf->GetY() < PDF_MARGIN_BOTTOM) {
    $pdf->deletePage($pdf->getPage());
}
$pdf_file_name = "<?=$customer_name;?><?=$ID;?>.pdf";


$pdf->Output($pdf_file_name, 'I');