<?
ob_start();
ob_clean();
session_start();
if($_SESSION['UID']=='' ) header('Location:index.php');
include 'dilg/cnt/join.php';
date_default_timezone_set("Asia/Kolkata");
$currentTime = date('Y-m-d H:i:s');
$currentDate = date('d-m-Y');
extract($_REQUEST);

$ID = $_GET['id'];
$order_id = $ID;

$sel_rows=mysqli_query($conn,"select * from quotation where id='$ID' ");
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
if($status=="Pending"){
  $Doc_NUM="MKT/F/7.205-Rev 00-1st July 2022";
}else{
  $Doc_NUM="MKT/F/7.204-Rev 00-1st July 2022";
}
if($company_address==1)
{
$Company_address ="Stark Engineers 3/360-363, Manickampalayam, Karuvalur Main Road, Coimbatore, Tamil Nadu 641107";
$Address_2="<table class=\"no-bdr\"><tr><td style=\"text-align:left;width:40%;font-size:12px;\">&nbsp;&nbsp;<b>Stark Engineers, </b></td><td style=\"text-align:right;width:60%;font-size:12px;\"><b><small style=\"font-size:10px;\">".$Doc_NUM." </small> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></td></tr></table><br>&nbsp;&nbsp;3/360-363, Manickampalayam, Karuvalur, <br>&nbsp;&nbsp;Main Road, Coimbatore, Tamil Nadu 641107";
$Gst_address="33ADEFS5652D1Z9";
}
else{
  $Company_address ="Stark motors, 96 sitra road, Kalapatti, Coimbatore 641048";
  $Address_2="<table class=\"no-bdr\"><tr><td style=\"text-align:left;width:40%;font-size:12px;\">&nbsp;&nbsp;<b>Stark Motors, </b></td><td style=\"text-align:right;width:60%;font-size:12px;\"><b><small style=\"font-size:10px;\">".$Doc_NUM." </small> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></td></tr></table><br>&nbsp;&nbsp;96, Sitra Road, Kalapatti,<br>&nbsp;&nbsp;Coimbatore 641048,";
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

 $htmlData   .=  '<table style="padding:5px 5px;"><tr style="vertical-align: middle;"><td style="width:30%;" ><p class="adds-titl" ><a href="www.starkmotors.com" target="_blank" style="text-align:center;"><img src="assets/images/Our/logo2.png" width="95px;"></a></p></td><td width="70%" style="border:1px solid #000;"><p class="adds-titl" style="text-align:left;font-size:11px;line-height:15px;font-weight:normal;">'.$Address_2.'<br>&nbsp;&nbsp;Phone: + 91 94426 14612, + 91 98433 14612,<br>&nbsp;&nbsp;E-mail:sales@starkmotors.com<br>&nbsp;&nbsp;Landline: 0422 -2627672, 0422 -2627612, 0422 -4274969, 0422 -4385612,<br>&nbsp;&nbsp;GST:'.$Gst_address.'</p></td></tr></table>';


 $htmlData   .=  '<table style="padding:5px 5px;"><tr style="background-color:#287dcf;color:#fff"><td style="width:100%;" ><h1 style="text-align:center;font-size:14px;color:#fff;">Quote for Motors</h1></td></tr><tr><td style="width:50%;" ><p class="adds-titl" style="line-height:1.3;font-size:11px;" ><b>SQ No: SQ'.$ID.'</b><br><b>No of Items: '.$products_count.'</b></p></td><td style="width:50%;" ><p style="font-size:11px;line-height:1.4;" ><b>SQ Date: '.date('d-m-Y', strtotime($created_datetime)).' </b><br><b>Total Amount:Rs. '.$total_order_amount.' </b></p></td></tr>
                <tr><td style="width:50%;" ><p class="adds-titl" style="line-height:1.3;font-size:11px;" ><b>To,</b><br> <span>&nbsp;&nbsp;&nbsp;&nbsp;'.$company_name.''.wordwrap($address, 50, "<br />&nbsp;&nbsp;&nbsp;&nbsp;\n").' '.$state.$Pin_code.''.$GST.'</span></p></td><td style="width:50%;font-size:11px;" ><b>Contact Person Name:</b>&nbsp;&nbsp;&nbsp;'.$customer_name.'<br><b>Phone:&nbsp;&nbsp;</b>'.$mobile.'<br><b>Email:&nbsp;&nbsp;</b>'.$email.'</td></tr></table>';


$htmlData   .=  '<table style="padding:4px;"><tr class="tr-head" class="head"> 

</tr></table><br><table cellpadding="3px" style="border-collapse: collapse;
width: 100%;border: 0px solid #ddd;padding:10px 7px;text-align:center;">

<tr class="tr-head" style="background-color:#287dcf;color:#fff">
<th style="width:4.5%; font-weight: 600;font-size:11px;border: 1px solid #000;border-bottom: 1px solid #000;">#</th>  

<th style="width:25%; font-weight: 600;font-size:11px;border: 1px solid #000;border-bottom: 1px solid #000;">Product Name </th> 
<th style="width:8.4%; font-weight: 600;font-size:11px;border: 1px solid #000;border-bottom: 1px solid #000;">HSN</th>   
<th style="width:5%; font-weight: 600;text-align:center;font-size:11px;border: 1px solid #000;border-bottom: 1px solid #000;">Qty</th> 
<th style="width:9%; font-weight: 600;font-size:11px;border: 1px solid #000;border-bottom: 1px solid #000;">Rate</th>
<th style="width:11%;text-align:center; font-weight: 600;font-size:11px;border: 1px solid #000;border-bottom: 1px solid #000;">Taxable </th>   
<th style="width:5%; font-weight: 600;font-size:10px;border: 1px solid #000;border-bottom: 1px solid #000;">GST%</th> 
<th style="width:9.5%; text-align:center;font-weight: 600;font-size:11px;border: 1px solid #000;border-bottom: 1px solid #000;">Pkg</th> 
<th style="width:10.5%;text-align:center; font-weight: 600;font-size:11px;border: 1px solid #000;border-bottom: 1px solid #000;">GST </th> 
<th style="width:12.1%;text-align:center; font-weight: 600;font-size:11px;border: 1px solid #000;border-bottom: 1px solid #000;">Total </th> 

</tr>'; 
$SNo=0;
$sel_product=mysqli_query($conn,"select * from quotation_product where quotation_id='$ID' ");
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
if($row_mertics['kw']!=''){ $kw="<br>Kw-".$row_mertics['kw'];}else{$kw="";}
if($row_mertics['hp']!=''){ $hp="<br>Hp-".$row_mertics['hp'];}else{$hp="";}
if($row_mertics['rpm']!=''){ $rpm="<br>Rpm-".$row_mertics['rpm'];}else{$rpm="";}
if($row_mertics['volt']!=''){ $volt="<br>Volt-".$row_mertics['volt'];}else{$volt="";}
if($row_mertics['type']!=''){ $type="Type-".$row_mertics['type'];}else{$type="";}
if($row_mertics['mounting']!=''){ $mounting="<br>Mounting-".$row_mertics['mounting'];}else{$mounting="";}
if($row_mertics['ins_cl']!=''){ $ins_cl="<br>INS.CL-".$row_mertics['ins_cl'];}else{$ins_cl="";}
if($row_mertics['degree']!=''){ $degree="<br>Deg of Prot-".$row_mertics['degree'];}else{$degree="";}
if($row_mertics['frequency']!=''){ $frequency="<br>Freq-".$row_mertics['frequency'];}else{$degree="";}
if($row_mertics['frame']!=''){ $frame="<br>Frame-".$row_mertics['frame'];}else{$frame="";}

if($row_product['remarks']!=''){ $remarks='<span style="line-height:0.7"><br><hr></span><span style="line-height:0.7"><br></span><br>Remarks-'.$row_product['remarks'];}else{$remarks="";}
if($row_mertics['model']!=''){ $model="<br>Model-".$row_mertics['model'];}else{$model="";}
if($row_mertics['efficiency']!=''){ $efficiency="<br>Efficiency-".$row_mertics['efficiency'];}else{$efficiency="";}
if($row_mertics['special_requirements']!=''){ $special_requirements='<span style="line-height:0.7"><br><hr></span><span style="line-height:0.7"><br></span><br>Special Req.-'.$row_mertics['special_requirements'];}else{$special_requirements="";}




$htmlData .= '<tr class="tr-head" style="color:#000">
<td style="text-align:center;width:4.5%;font-size:10px;border: 1px solid #000;border-bottom: 1px solid #000;">'.$SNo.'</td> 
<td style="text-align:left;width:25%; padding: 0px;font-size:10px;border: 1px solid #000;">'.$product_name.'<br><span style="line-height:0px;"><br></span><table class="no-bdr" style="width:100%;text-align:left;border-top: 1px solid #000;">
<tr nobr="true"><td><b style="line-height:1.5;text-align:center;font-size:10px;">Specification</b></td></tr>
<tr nobr="true"><td style="width:50%;line-height:1.2;font-size:10px;border-right:1px solid #000;">'.$model.$kw.$hp.$rpm.$volt.$ins_cl.$degree.$frequency.$special_requirements.'</td><td style="width:50%;line-height:1.2;font-size:10px;">'.$type.$mounting.$frame.$efficiency.$remarks.'</td></tr>'.$estimated_delivery_date.'</table></td><td style="text-align:center;width:8.4%;font-size:10px;border: 1px solid #000;border-bottom: 1px solid #000;">'.$hsn_code.'</td>  
<td style="text-align:center;width:5%;font-size:10px;border: 1px solid #000;border-bottom: 1px solid #000;">'.$quantity.'</td> 
<td style="text-align:center;width:9%;font-size:10px;border: 1px solid #000;border-bottom: 1px solid #000;">Rs.'.$rate.'</td> 
<td style="text-align:center;width:11%;font-size:10px;border: 1px solid #000;border-bottom: 1px solid #000;">Rs.'.round($product_amount,1).'</td> 
<td style="text-align:center;width:5%;font-size:10px;border: 1px solid #000;border-bottom: 1px solid #000;">'.$Gst.'</td> 
<td style="text-align:center;width:9.5%;font-size:10px;border: 1px solid #000;border-bottom: 1px solid #000;">Rs.'.round($package_amount,1).'</td>
<td style="text-align:center;width:10.5%;font-size:10px;border: 1px solid #000;border-bottom: 1px solid #000;">'.$Gst_amount.'</td>
<td style="text-align:center;width:12.1%;font-size:10px;border: 1px solid #000;border-bottom: 1px solid #000;">Rs.'.round($total_amount,1).'</td></tr>';
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

$sel_gstTax=mysqli_query($conn,"SELECT *,COALESCE(SUM(gst_amount),0) as totalgst, COALESCE(SUM(product_amount),0) as tproductamt FROM quotation_product where quotation_id='$ID' GROUP BY gst ");


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


$htmlData .= '</table></td><td class="tb-row" style="width:39%; font-weight: normal;background-color:#fff;font-size:11px;border: 1px solid #000;border-bottom: 1px solid #000;font-size:11px;text-align:right;"><table cellpadding="7px" style="padding:8px;"><tr><td class="tb-row" style="width:60%; font-weight: normal;font-size:11px;border: 1px solid #000;border-bottom: 1px solid #000;padding:15px;background-color:#ffff92;"><b>Taxable Amount</b></td>  

<td class="tb-row" style="width:40%; font-weight: normal;font-size:11px;border: 1px solid #000;border-bottom: 1px solid #000;padding:15px;background-color:#ffff92;">Rs. '.$PRODUCT_amount.'</td></tr>';

$htmlData .= '<tr ><td class="tb-row" style="width:60%; font-weight: normal;font-size:11px;border: 1px solid #000;border-bottom: 1px solid #000;font-size:11px;text-align:right;"><b>Packing Charges</b></td>  

<td class="tb-row" style="width:40%; font-weight: normal;font-size:11px ;border: 1px solid #000;border-bottom: 1px solid #000;padding:15px;">'.$total_package_amount.'</td></tr>';

$htmlData .= '<tr ><td class="tb-row" style="width:60%; font-weight: normal;font-size:11px;border: 1px solid #000;border-bottom: 1px solid #000;font-size:11px;text-align:right;"><b>Freight Charges</b></td>  

<td class="tb-row" style="width:40%; font-weight: normal;font-size:11px ;border: 1px solid #000;border-bottom: 1px solid #000;padding:15px;">Rs.  '.$total_freight.'</td></tr>';


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

$htmlData .= '</td></tr></table>';

if($terms_condition!=''){
$htmlData   .=  '<table cellpadding="0px" style="border-spacing: 6px 5px;padding:5px 5px;border: 1px solid #000;border-bottom: 0px solid #000;">
<tr class="no-bdr" nobr="true"><td style="width:100%;font-size:12px;font" ><b>Terms & Conditions:</b></td></tr>
                 <tr class="no-bdr" nobr="true" style="padding:0px 5px;"><td style="width:100%;font-size:11px;" >'.$terms_condition.'
                </td></tr></table>';
}


// if($company_address==1)
// {
// $htmlData   .=  '<table class="no-bdr" cellpadding="5px" style="padding:15px;line-height:0;background-color:#e8e8e8;border: 2px solid #000;">
//                  <tr nobr="true"><td style="width:73%;line-height:0; border-width:0px; margin:0px;"><b class="adds-titl" style="line-height:0.5;"><br>Bank Details:</b></td>
//                  <td style="width:27%;line-height:0; border-width:0px;text-align:center;margin:0px;"><p class="adds-titl" style="line-height:0.5;font-size:9px;"><br>For Stark Engineers</p></td></tr>
// <tr nobr="true">
// <td class="adds-titl" style="width:12%;line-height:1.3;font-size:11px;" >
// Bank Name:<br>A/C Name:<br>A/C Number:
// </td>
// <td class="adds-titl" style="width:24%;line-height:1.3;font-size:11px;" >
// <b>Karur Vysya Bank<br>Stark Engineers<br>1662135000006162</b>
// </td>
// <td class="adds-titl" style="width:8%;line-height:1.3;font-size:11px;" >
// Branch:<br>IFSC:
// </td>
// <td class="adds-titl" style="width:29%;line-height:1.3;font-size:11px;" >
// <b>Kalappatti<br>KVBL0001662</b>
// </td>
// <td class="adds-titl" style="width:27%;line-height:1.3;font-size:10px;text-align:center;" >
// <p style="font-size:11px"><br></p><br>
// Authorised Signatory
// </td>
// </tr>
// </table>';}
// else{
//   $htmlData   .=  '<table class="no-bdr" cellpadding="5px" style="padding:15px;line-height:0;background-color:#e8e8e8;border: 2px solid #000;">
//                  <tr nobr="true"><td style="width:73%;line-height:0; border-width:0px; margin:0px;"><b class="adds-titl" style="line-height:0.5;"><br>Bank Details:</b></td>
//                  <td style="width:27%;line-height:0; border-width:0px;text-align:center;margin:0px;"><p class="adds-titl" style="line-height:0.5;font-size:9px;"><br>For Stark Motors</p></td></tr>
// <tr nobr="true">
// <td class="adds-titl" style="width:12%;line-height:1.3;font-size:11px;" >
// Bank Name:<br>A/C Name:<br>A/C Number:
// </td>
// <td class="adds-titl" style="width:24%;line-height:1.3;font-size:11px;" >
// <b>City Union Bank<br>Stark Motors<br>053120000014363</b>
// </td>
// <td class="adds-titl" style="width:8%;line-height:1.3;font-size:11px;" >
// Branch:<br>IFSC:
// </td>
// <td class="adds-titl" style="width:29%;line-height:1.3;font-size:11px;" >
// <b>Vilankurichi<br>CIUB0000053</b>
// </td>
// <td class="adds-titl" style="width:27%;line-height:1.3;font-size:10px;text-align:center;" >
// <p style="font-size:11px"><br></p><br>
// Authorised Signatory
// </td>
// </tr>
// </table>';
// }




if($company_address==1)
{
$htmlData   .=  '<table class="no-bdr" cellpadding="5px" style="padding:15px;line-height:2;background-color:#e8e8e8;border: 2px solid #000;">
                 <tr nobr="true"><td style="width:50%;line-height:1; border-width:0px; margin:0px;"><b class="adds-titl" style="line-height:0.5;"><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Bank Details</b><br><br><img src="assets/images/Our/qr3.png" width="120px" ></td>
                 <td style="width:50%;line-height:1; border-width:0px;text-align:right;margin:0px;"><b class="adds-titl" style="line-height:0.5;"><br>Website&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b><br><br><img src="assets/images/Our/qr2.png" width="120px" ></td></tr></table>';
}
else{
  $htmlData   .=  '<table class="no-bdr" cellpadding="5px" style="padding:15px;line-height:2;background-color:#e8e8e8;border: 2px solid #000;">
<tr nobr="true"><td style="width:50%;line-height:1; border-width:0px; margin:0px;"><b class="adds-titl" style="line-height:0.5;"><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Bank Details</b><br><br><img src="assets/images/Our/qr1.png" width="120px" ></td>
<td style="width:50%;line-height:1; border-width:0px;text-align:right;margin:0px;"><b class="adds-titl" style="line-height:0.5;"><br>Website&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b><br><br><img src="assets/images/Our/qr2.png" width="120px" ></td></tr></table>
';
}

$htmlData   .=  '</body></html>';

$pdf->writeHTML($htmlData, true, false, true, false, '');

$pdf->lastPage();
if ($pdf->GetY() < PDF_MARGIN_BOTTOM) {
    $pdf->deletePage($pdf->getPage());
}
$pdf_file_name = "<?=$customer_name;?><?=$ID;?>.pdf";


$pdf->Output($pdf_file_name, 'I');