<?php
function main() { 
extract($_REQUEST);
include 'dilg/cnt/join.php';
include 'global-functions.php';
$ID=$_GET['id'];
date_default_timezone_set('Asia/Kolkata');
$currentTime = date('Y-m-d H:i:s');
$DATE = date('Y-m-d');
$TIME = date('H:i:s');
if($Submit=='Create Quotation')
{
$terms_condition=addslashes($terms_condition);
$select_customer=mysqli_query($conn,"select * from customer where id='$customer' "); 
$Row_customer=mysqli_fetch_array($select_customer);
$company_name = $Row_customer['company_name'];
$customer_name = $Row_customer['customer_name'];
$customer_type = $Row_customer['customer_type'];
$mobile = $Row_customer['mobile'];
$products_count=count($product_name);


$quotation_id = $conn->insert_id;
$tot_count = 0;
$gst_amount = 0;
$total_gst_amount = 0;
$total_package_amount = 0;
$total_product_amount = 0;
for($i=0; $i<=$products_count; $i++)
{
if($product_name[$i] !='')
{ 
$tot_count = $tot_count +1;
$total_package_amount=$total_package_amount+$pkg[$i];
$product_amount=round(($rate[$i]*$quantity[$i]),2);
$Gst_amount=round(($product_amount*($gst[$i]/100)),2);
$gst_amount= round(($gst_amount + $Gst_amount),2);
$total_product_amount= round(($total_product_amount + $product_amount),2);
$package_amount=$product_amount/100*$pkg[$i];
$total_package_amount=$total_package_amount+$package_amount;
$total_order_amount = round(($total_order_amount+ $total_amount[$i]),2);

}
}


$QUOTATION_id = $quotation_id;

$sel_rows=mysqli_query($conn,"select * from quotation where id='$QUOTATION_id' ");
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


$customer_name=addslashes($Row_customer['customer_name']);
$gst=$Row_customer['gst'];
$address=addslashes($Row_customer['address']);
$pin_code=$Row_customer['pin_code'];
$state=$Row_customer['state'];
$email=$Row_customer['email'];

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
$Address_2="<table class=\"no-bdr\" style=\"width:100%;\" cellspacing=\"0\"><tr><td style=\"text-align:left;width:50%;font-size:15px;\">&nbsp;&nbsp;<b>Stark Engineers, </b></td><td style=\"text-align:right;width:50%;font-size:15px;\"><b>Document No: <small>".$Doc_NUM." &nbsp;&nbsp;&nbsp;</small></b></td></tr></table>&nbsp;&nbsp;3/360-363, Manickampalayam, Karuvalur, <br>&nbsp;&nbsp;Main Road, Coimbatore, Tamil Nadu 641107";
$Gst_address="33ADEFS5652D1Z9";
}
else{
  $Company_address ="Stark motors, 96 sitra road, Kalapatti, Coimbatore 641048";
  $Address_2="<table class=\"no-bdr\" style=\"width:100%;height:0; margin:0;\" cellspacing=\"0\"><tr><td style=\"text-align:left;width:50%;font-size:15px;\">&nbsp;&nbsp;<b>Stark Motors, </b></td><td style=\"text-align:right;width:50%;font-size:15px;\"><b>Document No: <small>".$Doc_NUM." </small>&nbsp;&nbsp;&nbsp;</b></td></tr></table>&nbsp;&nbsp;96, Sitra Road, Kalapatti,<br>&nbsp;&nbsp;Coimbatore 641048,";
  $Gst_address="33AAMFS3000L1ZC";
}

 $usr_mail = "sujithmistsolutions@gmail.com";
$Date2 =date('d-M-Y h:i A', strtotime($currentTime));



$message   =  '<style>
body{
  font-family: Roboto, sans-serif;
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
</style>';

$Type_client = "<b>Quotation Confirmation</b> - SQ".$QUOTATION_id."<br> ".
      
      "<b>The details of your quotation are given below: </b><br><br>";

$Type_stark = "<b>New Quotation Created </b> - SQ".$QUOTATION_id."<br> ".
      
      "<b>The details are given below: </b><br><br>";

 $message   .=  '<table class="no-bdr" style="width: 70%;"><tr><td style="width:100%;"><table style="padding:0px;border:1px solid #000;width:100%;"><tr style="vertical-align: middle;"><td style="width:30%;" ><p class="adds-titl" style="text-align:center;"><a href="www.starkmotors.com" target="_blank" style="text-align:center;"><img src="https://crm.starkmotors.com/assets/images/Our/logo.png" width="135px;"></a></p></td><td style="border-left:1px solid #000;color:#000;font-size:14px;"><p class="adds-titl" style="text-align:left;font-size:12px;line-height:15px;font-weight:normal;">'.$Address_2.'<br>&nbsp;&nbsp;Phone: + 91 94426 14612, + 91 98433 14612,<br>&nbsp;&nbsp;Landline: 0422 -2627672, 0422 -2627612, 0422 -4274969, 0422 -4385612,<br>&nbsp;&nbsp;E-mail:sales@starkmotors.com<br>&nbsp;&nbsp;GST:'.$Gst_address.'</p></td></tr></table>';

$message   .=  '<table style="padding:5px 5px;width:100%;border:1px solid #000;" cellspacing="0px"><tr style="background-color:#287dcf;color:#fff;width:100%;"><td style="width:50%;padding:8px 3px;text-align:right;font-size:16px;color:#fff;font-weight:700;" >QUOTATION</td><td style="width:50%;padding:8px 3px;text-align:left;font-size:16px;color:#fff;font-weight:700;" > INVOICE</td></tr><tr><td style="width:50%;border: 1px solid #000;" ><p class="adds-titl" style="line-height:1.3;font-size:13px;margin:2px 5px;" ><b>SQ No: SQ'.$QUOTATION_id.'</b><br><b>No of Items: '.$products_count.'</b></p></td><td style="width:50%;border: 1px solid #000;" ><p style="margin:2px 5px;font-size:13px;line-height:1.3;" ><b>Total Amount: Rs. '.$total_order_amount.'</b></p></td></tr><tr><td style="width:50%;border: 1px solid #000;" ><p class="adds-titl" style="line-height:1.4;font-size:13px;margin:2px 5px;" ><b>To,</b><br> <span>&nbsp;&nbsp;&nbsp;&nbsp;'.$company_name.''.wordwrap($address, 45, "<br />&nbsp;&nbsp;&nbsp;&nbsp;\n").' '.$state.$Pin_code.''.$GST.'</span></p></td><td style="width:50%;font-size:13px;border: 1px solid #000;" ><b style="margin:0px 0px 0px 5px;">Contact Person Name:</b>&nbsp;&nbsp;&nbsp;'.$customer_name.'<br><b style="margin:0px 0px 0px 5px;">Phone:&nbsp;&nbsp;</b>'.$mobile.'<br><b style="margin:0px 0px 0px 5px;">Email:&nbsp;&nbsp;</b>'.$email.'</td></tr></table>';

$message   .=  '<table cellpadding="3px" style="border-collapse: collapse;
width: 100%;border: 0px solid #ddd;padding:10px 7px;text-align:center;">

<tr class="tr-head" style="background-color:#287dcf;color:#fff">
<th style="width:4.5%; font-weight: 600;font-size:13px;border: 1px solid #000;border-bottom: 1px solid #000;">#</th>  

<th style="width:25%; font-weight: 600;font-size:13px;border: 1px solid #000;border-bottom: 1px solid #000;">Product Name </th> 
<th style="width:8.4%; font-weight: 600;font-size:13px;border: 1px solid #000;border-bottom: 1px solid #000;">HSN</th>   
<th style="width:5%; font-weight: 600;text-align:center;font-size:13px;border: 1px solid #000;border-bottom: 1px solid #000;">Qty</th> 
<th style="width:9%; font-weight: 600;font-size:13px;border: 1px solid #000;border-bottom: 1px solid #000;">Rate</th>
<th style="width:11%;text-align:center; font-weight: 600;font-size:13px;border: 1px solid #000;border-bottom: 1px solid #000;">Taxable </th>   
<th style="width:5%; font-weight: 600;font-size:12px;border: 1px solid #000;border-bottom: 1px solid #000;">GST%</th> 
<th style="width:9.5%; text-align:center;font-weight: 600;font-size:13px;border: 1px solid #000;border-bottom: 1px solid #000;">Pkg</th> 
<th style="width:10.5%;text-align:center; font-weight: 600;font-size:13px;border: 1px solid #000;border-bottom: 1px solid #000;">GST </th> 
<th style="width:12.1%;text-align:center; font-weight: 600;font-size:13px;border: 1px solid #000;border-bottom: 1px solid #000;">Total </th> 

</tr>'; 
$SNo=0;
$sel_product=mysqli_query($conn,"select * from quotation_product where quotation_id='$QUOTATION_id' ");
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
  if($gst=="0"){$Gst="--";} else{$Gst=$gst."%";}
  if($gst=="0"){$Gst_amount="--";} else{$Gst_amount="Rs.".round($gst_amount,1);}

  $sel_mertics=mysqli_query($conn,"select * from product where product = '$product_name'"); 
$row_mertics=mysqli_fetch_array($sel_mertics);
 $hsn_code = $row_mertics['hsn_code'];
if($row_mertics['kw']!=''){ $kw="Kw-".$row_mertics['kw'];}else{$kw="";}
if($row_mertics['hp']!=''){ $hp="<br>Hp-".$row_mertics['hp'];}else{$hp="";}
if($row_mertics['rpm']!=''){ $rpm="<br>Rpm-".$row_mertics['rpm'];}else{$rpm="";}
if($row_mertics['volt']!=''){ $volt="<br>Volt-".$row_mertics['volt'];}else{$volt="";}
if($row_mertics['type']!=''){ $type="Type-".$row_mertics['type'];}else{$type="";}
if($row_mertics['mounting']!=''){ $mounting="<br>Mounting-".$row_mertics['mounting'];}else{$mounting="";}
if($row_mertics['ins_cl']!=''){ $ins_cl="<br>INS.CL-".$row_mertics['ins_cl'];}else{$ins_cl="";}
if($row_mertics['degree']!=''){ $degree="<br>Degree-".$row_mertics['degree'];}else{$degree="";}
if($row_mertics['frequency']!=''){ $degree="<br>Freq-".$row_mertics['degree'];}else{$degree="";}
if($row_product['remarks']!=''){ $remarks="<br>Remarks-".$row_product['remarks'];}else{$remarks="";}



$message .= '<tr class="tr-head" style="color:#000">
<td style="text-align:center;width:4.5%;font-size:12px;border: 1px solid #000;border-bottom: 1px solid #000;">'.$SNo.'</td> 
<td style="text-align:left;width:25%; line-height:1.3;padding:3px;font-size:12px;border: 1px solid #000;">'.$product_name.'<span style="line-height:0px;"><br></span><table class="no-bdr" style="width:100%;text-align:left;border-top: 1px solid #000;">
<tr nobr="true"><td><b style="line-height:1.5;text-align:center;font-size:12px;">Specification</b></td></tr>
<tr nobr="true"><td style="width:50%;line-height:1.2;font-size:12px;border-right:1px solid #000;">'.$kw.$hp.$rpm.$volt.$ins_cl.$degree.$frequency.'</td><td style="width:50%;line-height:1.2;font-size:12px;">'.$type.$mounting.$remarks.'</td></tr></table></td><td style="text-align:center;width:8.4%;font-size:12px;border: 1px solid #000;border-bottom: 1px solid #000;">'.$hsn_code.'</td> 
<td style="text-align:center;width:5%;font-size:12px;border: 1px solid #000;border-bottom: 1px solid #000;">'.$quantity.'</td> 
<td style="text-align:center;width:9%;font-size:12px;border: 1px solid #000;border-bottom: 1px solid #000;">Rs.'.$rate.'</td> 
<td style="text-align:center;width:11%;font-size:12px;border: 1px solid #000;border-bottom: 1px solid #000;">Rs.'.$product_amount.'</td> 
<td style="text-align:center;width:5%;font-size:12px;border: 1px solid #000;border-bottom: 1px solid #000;">'.$Gst.'</td> 
<td style="text-align:center;width:9.5%;font-size:12px;border: 1px solid #000;border-bottom: 1px solid #000;">Rs.&nbsp;'.round($package_amount,1).'</td>
<td style="text-align:center;width:10.5%;font-size:12px;border: 1px solid #000;border-bottom: 1px solid #000;">'.$Gst_amount.'</td>
<td style="text-align:center;width:12.1%;font-size:12px;border: 1px solid #000;border-bottom: 1px solid #000;">Rs.'.round($total_amount,1).'</td></tr>';

}

 
if($state=='Tamil Nadu'){
$message .= '</table><table cellpadding="6px" style="border: 1px;
    width: 100%;"><tr><td class="tb-row" style="width:61%; font-weight: normal;font-size:12px;border: 1px solid #000;border-bottom: 1px solid #000;font-size:12px;text-align:center;"><p style="text-align:center; font-weight: 600;font-size:12px;border: 1px solid #000;border-bottom: 1px solid #000;margin:0 10px; padding:10px;background-color: #ffff92;"><b style="font-weight: 800;">GST Details</b></p><table style="padding:0px 7px 7px 7px;width:100%"><tbody><tr></tr><tr class="tr-head" style="background-color:#fff;color:#000">
<th style="text-align:center;width:16%; font-weight: 700;font-size:10px;border: 1px solid #000;border-bottom: 1px solid #000;"><b style="font-weight: 800;">CGST %</b></th> 
<th style="text-align:center;width:17%; font-weight: 600;font-size:9px;border: 1px solid #000;border-bottom: 1px solid #000;"><b style="font-weight: 800;">CGST</b></th>
<th style="text-align:center;width:12.5%; font-weight: 600;font-size:9px;border: 1px solid #000;border-bottom: 1px solid #000;"><b style="font-weight: 800;">'.$GST_Type.' %</b></th>
<th style="text-align:center;width:17%; font-weight: 600;font-size:9px;border: 1px solid #000;border-bottom: 1px solid #000;"><b style="font-weight: 800;">'.$GST_Type.'</b></th>
<th style="text-align:center;width:21%; font-weight: 600;font-size:9px;border: 1px solid #000;border-bottom: 1px solid #000;"><b style="font-weight: 800;">Gross<br>Bill Value</b></th>
<th style="text-align:center;width:16.5%; font-weight: 600;font-size:9px;border: 1px solid #000;border-bottom: 1px solid #000;"><b style="font-weight: 800;">Total <br>GST</b></th>

</tr>';}else{
$message .= '</table><table cellpadding="6px" style="border: 1px;
    width: 100%;"><tr><td class="tb-row" style="width:61%; font-weight: normal;font-size:12px;border: 1px solid #000;border-bottom: 1px solid #000;font-size:12px;text-align:center;"><p style="text-align:center; font-weight: 600;font-size:12px;border: 1px solid #000;border-bottom: 1px solid #000;margin:0 10px; padding:10px;background-color: #ffff92;"><b style="font-weight: 800;">GST Details</b></p><table style="padding:0px 7px 7px 7px;width:100%"><tbody><tr class="tr-head" style="background-color:#fff;color:#000">
<th style="text-align:center;width:25%; font-weight: 600;font-size:9px;border: 1px solid #000;border-bottom: 1px solid #000;"><b style="font-weight: 800;">'.$GST_Type.' %</b></th>
<th style="text-align:center;width:25%; font-weight: 600;font-size:9px;border: 1px solid #000;border-bottom: 1px solid #000;"><b style="font-weight: 800;">'.$GST_Type.'</b></th>
<th style="text-align:center;width:25%; font-weight: 600;font-size:9px;border: 1px solid #000;border-bottom: 1px solid #000;"><b style="font-weight: 800;">Gross<br>Bill Value</b></th>
<th style="text-align:center;width:25%; font-weight: 600;font-size:9px;border: 1px solid #000;border-bottom: 1px solid #000;"><b style="font-weight: 800;">Total <br>GST</b></th>

</tr>';}
$sel_gstTax=mysqli_query($conn,"SELECT *,COALESCE(SUM(gst_amount),0) as totalgst, COALESCE(SUM(product_amount),0) as tproductamt FROM quotation_product where quotation_id='$QUOTATION_id' GROUP BY gst ");


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

$message .= '<tr class="tr-head" style="color:#000">
<td style="text-align:center;width:16%;padding: 4px 0px;font-size:12px;border: 1px solid #000;border-bottom: 1px solid #000;">'.$gstPercnt.'%</td> 
<td style="text-align:center;width:17%;font-size:12px;padding: 4px 0px;border: 1px solid #000;border-bottom: 1px solid #000;">'.$cgst.'</td> 
<td style="text-align:center;width:12.5%;font-size:12px;padding: 4px 0px;border: 1px solid #000;border-bottom: 1px solid #000;">'.$gstPercnt.'%</td> 
<td style="text-align:center;width:17%;font-size:12px;padding: 4px 0px;border: 1px solid #000;border-bottom: 1px solid #000;">'.$cgst.'</td> 
<td style="text-align:center;width:21%;font-size:12px;padding: 4px 0px;border: 1px solid #000;border-bottom: 1px solid #000;">'.$withouGstAmount.'</td> 
<td style="text-align:center;width:16.5%;font-size:12px;padding: 4px 0px;border: 1px solid #000;border-bottom: 1px solid #000;">'.$TGT.'</td></tr>';}else{
$gstPercnt=$rows_tax['gst'];
$igst = round($rows_tax['totalgst'],2);
$message .= '<tr class="tr-head" style="color:#000">
<td style="text-align:center;width:25%;font-size:12px;padding: 4px 0px;border: 1px solid #000;border-bottom: 1px solid #000;">'.$gstPercnt.'%</td> 
<td style="text-align:center;width:25%;font-size:12px;padding: 4px 0px;border: 1px solid #000;border-bottom: 1px solid #000;">'.$igst.'</td> 
<td style="text-align:center;width:25%;font-size:12px;padding: 4px 0px;border: 1px solid #000;border-bottom: 1px solid #000;">'.$withouGstAmount.'</td> 
<td style="text-align:center;width:25%;font-size:12px;padding: 4px 0px;border: 1px solid #000;border-bottom: 1px solid #000;">'.$TGT.'</td></tr>';
}


}


$message .= '</tbody></table></td><td class="tb-row" style="width:39%; font-weight: normal;background-color:#fff;font-size:13px;border: 1px solid #000;border-bottom: 1px solid #000;font-size:13px;text-align:right;"><table cellpadding="7px" style="padding:8px;width: 100%;"><tr><td class="tb-row" style="width:60%; font-weight: normal;font-size:13px;border: 1px solid #000;border-bottom: 1px solid #000;padding:10px;background-color:#ffff92;"><b>Taxable</b></td>  

<td class="tb-row" style="width:40%; font-weight: normal;font-size:13px;border: 1px solid #000;border-bottom: 1px solid #000;padding:10px;background-color:#ffff92;">Rs. '.$PRODUCT_amount.'</td></tr>';

$message .= '<tr ><td class="tb-row" style="width:60%; font-weight: normal;font-size:13px;border: 1px solid #000;border-bottom: 1px solid #000;font-size:13px;text-align:right;padding:10px;"><b>Packing Charges</b></td>  

<td class="tb-row" style="width:40%; font-weight: normal;font-size:13px ;border: 1px solid #000;border-bottom: 1px solid #000;padding:10px;">'.$total_package_amount.'</td></tr>';

if($state=='Tamil Nadu'){
$htmlData .= '<tr ><td class="tb-row" style="width:60%; font-weight: normal;font-size:11px;border: 1px solid #000;border-bottom: 1px solid #000;font-size:11px;text-align:right;"><b>CGST</b></td>  

<td class="tb-row" style="width:40%; font-weight: normal;font-size:11px ;border: 1px solid #000;border-bottom: 1px solid #000;padding:15px;">'.$GST_amount.'</td></tr>';

$htmlData .= '<tr ><td class="tb-row" style="width:60%; font-weight: normal;font-size:11px;border: 1px solid #000;border-bottom: 1px solid #000;font-size:11px;text-align:right;"><b>SGST</b></td>  

<td class="tb-row" style="width:40%; font-weight: normal;font-size:11px ;border: 1px solid #000;border-bottom: 1px solid #000;padding:15px;">'.$GST_amount.'</td></tr>';
}else{
  $htmlData .= '<tr ><td class="tb-row" style="width:60%; font-weight: normal;font-size:11px;border: 1px solid #000;border-bottom: 1px solid #000;font-size:11px;text-align:right;"><b>IGST</b></td>  

<td class="tb-row" style="width:40%; font-weight: normal;font-size:11px ;border: 1px solid #000;border-bottom: 1px solid #000;padding:15px;">'.$Tot_GST_amount.'</td></tr>';
}

$message .= '<tr ><td class="tb-row" style="width:60%; font-weight: normal;font-size:13px;border: 1px solid #000;border-bottom: 1px solid #000;font-size:13px;text-align:right;padding:10px;"><b>Total GST</b></td>  

<td class="tb-row" style="width:40%; font-weight: normal;font-size:13px ;border: 1px solid #000;border-bottom: 1px solid #000;padding:10px;">'.$Tot_GST_amount.'</td></tr>';


$message .= '<tr ><td class="tb-row" style="width:60%; font-weight: normal;font-size:13px;border: 1px solid #000;border-bottom: 1px solid #000;font-size:13px;background-color:#ffff92;text-align:right;padding:10px;"><b>Net Amount</b></td>  

<td class="tb-row" style="width:40%; font-weight: normal;font-size:13px ;border: 1px solid #000;border-bottom: 1px solid #000;background-color:#ffff92;padding:10px;">Rs. '.$Total_order_amount.'</td></tr></table>';

$message .= '</td></tr></table>';
 
if($terms_condition!=''){
$message   .=  '<table nobr="true" cellpadding="0px" style="width:100%;border-spacing: 6px 5px;padding:5px 5px;border: 1px solid #000;border-bottom: 0px solid #000;">
<tr class="no-bdr" nobr="true"><td style="width:100%;font-size:13px;" ><b>Terms & Conditions:</b></td></tr>
                 <tr class="no-bdr"><td style="width:100%;font-size:13px;" class="terms">'.$terms_condition.'
                </td></tr></table>';
}

if($company_address==1)
{
$message   .=  '<div style="padding:0px 9px 5px 9px;line-height:0;background-color:#e8e8e8;border: 2px solid #000;">
                 <div style="display:flex;"><div style="width:73%;line-height:0; border-width:0px; margin:0px;"><b class="adds-titl" style="line-height:0.5;"><br><br>Bank Details:</b></div>
                 <div style="width:27%;line-height:0; border-width:0px;text-align:center;margin:0px;"><p class="adds-titl" style="line-height:0.5;font-size:11px;"><br>For Stark Engineers</p></div></div>
<div style="display:flex;">
<div class="" style="width:12%;line-height:1.3;font-size:13px;" >
Bank Name:<br>A/C Name:<br>A/C Number:
</div>
<div class="" style="width:24%;line-height:1.3;font-size:13px;" >
<b>Karur Vysya Bank<br>Stark Engineers<br>1662135000006162</b>
</div>
<div class="" style="width:8%;line-height:1.3;font-size:13px;" >
Branch:<br>IFSC:
</div>
<div class="" style="width:29%;line-height:1.3;font-size:13px;" >
<b>Kalappatti<br>KVBL0001662</b>
</div>
<div class="" style="width:27%;line-height:1.3;font-size:11px;text-align:center;" >
<p style="font-size:13px;margin: 0;line-height:0.5"><br>Digitally signed by Stark Engineers<br><br><br></p>
Authorised Signatory
</div>
</div>
</div>';}
else{
  $message   .=  '<div style="padding:0px 9px 5px 9px;line-height:0;background-color:#e8e8e8;border: 2px solid #000;">
                 <div style="display:flex;"><div style="width:73%;line-height:0; border-width:0px; margin:0px;"><b class="adds-titl" style="line-height:0.5;"><br><br>Bank Details:</b></div>
                 <div style="width:27%;line-height:0; border-width:0px;text-align:center;margin:0px;"><p class="adds-titl" style="line-height:0.5;font-size:11px;"><br>For Stark Motors</p></div></div>
<div style="display:flex;">
<div class="" style="width:12%;line-height:1.3;font-size:13px;" >
Bank Name:<br>A/C Name:<br>A/C Number:
</div>
<div class="" style="width:24%;line-height:1.3;font-size:13px;" >
<b>City Union Bank<br>Stark Motors<br>053120000014363</b>
</div>
<div class="" style="width:8%;line-height:1.3;font-size:13px;" >
Branch:<br>IFSC:
</div>
<div class="" style="width:29%;line-height:1.3;font-size:13px;" >
<b>Vilankurichi<br>CIUB0000053</b>
</div>
<div class="" style="width:27%;line-height:1.3;font-size:11px;text-align:center;" >
<p style="font-size:13px;margin: 0;line-height:0.5"><br>Digitally signed by Stark Motors<br><br><br></p>
Authorised Signatory
</div>
</div>
</div>
';
}
$message .='<td style="width:20%;"></td></td></tr></table>';

$Client_Message2='<div>
<div width="9" height="30"><br><br>&nbsp;Best regards, <br><br>    </div>
<div width="782" height="30"><strong><a href="https://starkmotors.com/" style="color:#000;">&nbsp;Stark Motors</a> </strong>
<div width="10" height="30">&nbsp;</div>
</div>';
$message   .=  '</body></html>';
$subject="Order Confirmation for SQ".$QUOTATION_id;
$stark_subject="New Quotation Created SQ".$QUOTATION_id;
$usr_mail='sujithmistsolutions@gmail.com';
$stark_mail='sujith123tws@gmail.com';

$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= 'Sender: <noreply@starkmotors.com>' . "\r\n";
$headers .= 'From: StarkMotors<noreply@starkmotors.com>' . "\r\n";
$headers .= 'Bcc: <support@starkmotors.com>' . "\r\n";
$client_headers = 'Reply-To: Stark Motors <noreply@starkmotors.com>' . "\r\n";
$stark_headers = 'Reply-To: Stark Motors <noreply@starkmotors.com>' . "\r\n";
$Client_Header=$headers.$client_headers;
$Stark_Header=$headers.$stark_headers;
$Client_Message= $Type_client.$message.$Client_Message2;
$Stark_Message= $Type_stark.$message;  


$subject = "New Order Received #AC";

$res1 = mail($usr_mail,$subject,$Client_Message,$Client_Header,'-fnoreply@starkmotors.com');
$res2=mail($stark_mail , $subject, $Stark_Message, $Stark_Header, '-fnoreply@starkmotors.com');
$msg = 'Quotation Added Successfully';
//header('Location:list-quotation.php?msg='.$msg);

}

if($Submit=='Update Quotation')
{
$select_customer=mysqli_query($conn,"select * from customer where id='$customer' "); 
$Row_customer=mysqli_fetch_array($select_customer);
$company_name = $Row_customer['company_name'];
$customer_name = $Row_customer['customer_name'];
$customer_type = $Row_customer['customer_type'];
$mobile = $Row_customer['mobile'];
$products_count=count($product_name);
$terms_condition=addslashes($terms_condition);
$update_product=mysqli_query($conn,"update quotation set customer_id = '$customer', customer_name = '$customer_name', company_name='$company_name', customer_type='$customer_type', mobile='$mobile', terms_condition='$terms_condition',  company_address= '$company_address', products_count='$products_count', status='Pending', created_by=".$_SESSION['UID']." where id='$ID' ");

$quotation_ProductDelete = mysqli_query($conn,"delete from quotation_product where quotation_id ='$ID' ");

$tot_count = 0;
$gst_amount = 0;
$total_gst_amount = 0;
$total_package_amount=0;
for($i=0; $i<=$products_count; $i++)
{
if($product_name[$i] !='')
{ 
$tot_count = $tot_count +1;
$product_amount=round(($rate[$i]*$quantity[$i]),2);
$Gst_amount=round(($product_amount*($gst[$i]/100)),2);
$gst_amount= round(($gst_amount + $Gst_amount),2);
$total_product_amount= round(($total_product_amount + $product_amount),2);
$package_amount=$product_amount/100*$pkg[$i];
$total_package_amount=$total_package_amount+$package_amount;

$total_order_amount = round(($total_order_amount+ $total_amount[$i]),2);

$rs_InsValues=mysqli_query($conn,"insert into quotation_product set quotation_id='$ID', product_name='$product_name[$i]', brand_name='$brand_name[$i]', rate='$rate[$i]', quantity = '$quantity[$i]', package_amount = '$package_amount', product_amount = '$product_amount', gst = '$gst[$i]', remarks='$remarks[$i]', package_percent = '$pkg[$i]', gst_amount = '$Gst_amount', total_amount = '$total_amount[$i]', created_datetime = '$currentTime', created_by=".$_SESSION['UID']."");
}
}

$update_total=mysqli_query($conn,"update quotation set product_amount='$total_product_amount', gst_amount='$gst_amount', total_order_amount='$total_order_amount', total_package_amount='$total_package_amount', modified_datetime = '$currentTime' where id='$ID' ");

if($update_total && $rs_InsValues)
{
$msg = 'Quotation Updated Successfully';
header('Location:list-quotation.php?msg='.$msg);
}
else
{
$alert_msg = 'Could not able to add try once again!!!';    
}
}

$sel_values=mysqli_query($conn,"select * from quotation where id = '$ID'"); 
$row_values=mysqli_fetch_array($sel_values);
$customer_id=$row_values['customer_id'];
$mobile=$row_values['mobile'];
$customer_type=$row_values['customer_type'];
$CountQtn = mysqli_num_rows($sel_values); 
$terms_condition=$row_values['terms_condition'];
$company_address=$row_values['company_address'];
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
<h5 class="text-uppercase mb-0"><?if($CountQtn>>0){ echo"Update";}else{echo "Add";}?> Quotations</span></h5>
<?if($CountQtn>>0){?> <a href="list-quotation.php" class="btn btn-danger">Back</a><?}?> 
</div>
<hr>
<div class="card-title row align-items-center">

<div class="col-xl-6" >
<label for="inputLastName" class="form-label mt-20">Select Company / Customer</label>
<select class="form-select" name="customer" onchange="getPrice(this.value, '0')" id="customer_id" required>
<option value="">Select Customer</option>
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
<p id="customer_type"><?=$customer_type;?></p>
</div>
<div>
<label for="inputLastName" class="form-label mt-20">Mobile</label><br>
<p><?=$mobile;?></p>
</div>
<?}?>
</div>



</div>
<div id="productSection" class=" mt-4 mb-3 " <?if($CountQtn==0){echo'style="display: none;"';} ?>>
<div class="bg-3f663a text-center rounded-1">
<h5 class="text-white py-1">Add Product</h5>
</div>
<div class="px-2" id="Regular" >
<div id="frm_scents">
<? if($CountQtn =='0') { ?>
<div class="row g-2 mt-1 mb-2">
<div class="w-24">
<label for="inputLastName" class="form-label mt-20 mb-0">Select Product</label>

</div>
<div class="w-15">
<label for="inputLastName" class="form-label mt-20 mb-0">Select Brand</label>

</div>
<div class="w-10">
<label for="inputLastName" class="form-label mt-20 mb-0">Rate</label>

</div>
<div class="w-6">
<label for="inputLastName" class="form-label mt-20 mb-0">Qty</label>
</div>

<div class="w-6">
<label for="inputLastName" class="form-label mt-20 mb-0">Pkg</label>
</div>

<div class="w-9">
<label for="inputLastName" class="form-label mt-20 mb-0">GST (%)</label>
</div>

<div class="w-15">
<label for="inputLastName" class="form-label mt-20 mb-0">Remarks</label>
</div>

<div class="w-10">
<label for="inputLastName" class="form-label mt-20 mb-0">Total</label>

</div>

<div class="w-5 text-end">
<label for="inputtext" class="form-label mt-20 mb-0">Action</label>
</div>
</div>

<div class="row my-1" id="p_scents">

<div class="w-24">
<select class="form-select" name="product_name[]" id="product_name1" onchange="getPrice(this.value, '1')" required>
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
<div class="w-15">
<select class="form-select" name="brand_name[]" required>
<option value="">Select Brand</option>
<? 
$sql_brand=mysqli_query($conn,"select * from  brand where status='1' ORDER BY brand_name asc"); 
while($row_brand=mysqli_fetch_array($sql_brand))
{
?>
<option value="<?=$row_brand['brand_name']?>" <? if($row_brand['brand_name'] == $ID) { ?>selected<? } ?> ><?=$row_brand['brand_name'];?></option>
<?
}
?>
</select>
</div>
<div class="w-10">
<input type="number" class="form-control p-qnt" id="rate1" name="rate[]" step="any"onkeyup="getTotal(1)" placeholder="Rate" required <?if($_SESSION['USERTYPE']==1){ echo "readonly";}?>>
</div>
<div class="w-6">
<input type="number" class="form-control p-qnt" id="quantity1" min="0" onkeyup="getTotal(1)" name="quantity[]" placeholder="Qty" required>
</div>
<div class="w-6 percent">
<input type="number" class="form-control p-qnt percent-wrapper" id="pkg1" min="0" max="99" onkeyup="getTotal(1)" value="0" name="pkg[]" placeholder="Pkg" required>
<span>%</span>
</div>
<div class="w-9 col-ms-22">
<select class="form-select p-qnt" onchange="getTotal(1)" name="gst[]" id="gst1">
<option value="0">0%</option>
<option value="5">5%</option>
<option value="12">12%</option>
<option value="18" selected>18%</option>
<option value="28">28%</option>
</select>
</div>
<div class="w-15">
<textarea class="form-control" rows="1" id="remarks1" name="remarks[]" placeholder="Remarks"></textarea>
</div>
<div class="w-10">
<label class="ItemTotal fw-6" id="tot1">₹0.00</label>
<input type="hidden" id="tot_val1" name="total_amount[]">
</div>
<div class="w-5 text-end">
<a type="button" id="addScnt" tooltip="Add Product" class="pe-1"  style="width: auto;" ><img src="assets/images/Our/plus2.png" width="27px;"> </a>

</div>
</div>
<? } else { ?>

<div class="row g-2 mt-1 mb-2">
<div class="w-24">
<label for="inputLastName" class="form-label mt-20 mb-0">Select Product</label>

</div>
<div class="w-15">
<label for="inputLastName" class="form-label mt-20 mb-0">Select Brand</label>

</div>
<div class="w-10">
<label for="inputLastName" class="form-label mt-20 mb-0">Rate</label>

</div>
<div class="w-6">
<label for="inputLastName" class="form-label mt-20 mb-0">Qty</label>
</div>

<div class="w-6">
<label for="inputLastName" class="form-label mt-20 mb-0">Pkg</label>
</div>

<div class="w-9">
<label for="inputLastName" class="form-label mt-20 mb-0">GST (%)</label>
</div>
<div class="w-15">
<label for="inputLastName" class="form-label mt-20 mb-0">Remarks</label>
</div>
<div class="w-10">
<label for="inputLastName" class="form-label mt-20 mb-0">Total</label>

</div>

<div class="w-5 text-end">
<label for="inputtext" class="form-label mt-20 mb-0">Action</label>
</div>
</div>
<? 
$SNo = 0;
$sel_product=mysqli_query($conn,"select * from quotation_product where quotation_id = '$ID'"); 
while($row_product=mysqli_fetch_array($sel_product))
{ 
$SNo = $SNo + 1; 
$product_name=$row_product['product_name'];
$brand_name=$row_product['brand_name'];
$rate=$row_product['rate'];
$quantity=$row_product['quantity'];
$gst=$row_product['gst'];
$total_amount=$row_product['total_amount'];
$package_percent=$row_product['package_percent'];
$remarks=$row_product['remarks'];
?>

<div class="row my-1" id="p_scents">

<div class="w-24">
<select class="form-select" name="product_name[]" id="product_name<?=$SNo;?>" onchange="getPrice(this.value, '<?=$SNo?>')" required>
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
</div>
<div class="w-15">
<select class="form-select" name="brand_name[]" required>
<option value="">Select Brand</option>
<? 
$sql_brand=mysqli_query($conn,"select * from  brand where status='1' ORDER BY brand_name asc"); 
while($row_brand=mysqli_fetch_array($sql_brand))
{
?>
<option value="<?=$row_brand['brand_name']?>" <? if($row_brand['brand_name'] == $brand_name) { ?>selected<? } ?> ><?=$row_brand['brand_name'];?></option>
<?
}
?>
</select>
</div>
<div class="w-10">
<input type="number" class="form-control p-qnt" id="rate<?=$SNo?>" name="rate[]" step="any" onchange="addRate(<?=$SNo?>,this.value,'rate')" onkeyup="getTotal(<?=$SNo?>)" placeholder="Rate" value="<?=$rate;?>" required <?if($_SESSION['USERTYPE']==1){ echo "readonly";}?>>
<input type="hidden" id="rateChange<?=$SNo?>" value="1">
</div>

<div class="w-6">
<input type="number" class="form-control p-qnt" id="quantity<?=$SNo?>" onchange="addRate(<?=$SNo?>,this.value,'quantity')" onkeyup="getTotal(<?=$SNo?>)" name="quantity[]" placeholder="Qty" min="0" value="<?=$quantity;?>" required>
<input type="hidden" id="quantityChange<?=$SNo?>" value="1">
</div>
<div class="w-6 percent">
<input type="number" class="form-control p-qnt" id="pkg<?=$SNo?>" value="<?=$package_percent; ?>" min="0" max="99" onchange="addRate(<?=$SNo?>,this.value,'package')" onkeyup="getTotal(<?=$SNo?>)" name="pkg[]" placeholder="Pkg" required>
<input type="hidden" id="packageChange<?=$SNo?>" value="1">
<span>%</span>
</div>
<div class="w-9">
<select class="form-select p-qnt" onchange="getTotal(<?=$SNo?>);addRate(<?=$SNo?>,this.value,'gst');" name="gst[]" id="gst<?=$SNo?>">
<option value="0" <? if($gst == "0") { ?>selected<? } ?>>0%</option>
<option value="5" <? if($gst == "5") { ?>selected<? } ?>>5%</option>
<option value="12" <? if($gst == "12") { ?>selected<? } ?>>12%</option>
<option value="18" <? if($gst == "18") { ?>selected<? } ?>>18%</option>
<option value="28" <? if($gst == "28") { ?>selected<? } ?>>28%</option>
</select>
<input type="hidden" id="gstChange<?=$SNo?>" value="1">
</div>
<div class="w-15">
<textarea class="form-control" rows="1" id="remarks<?=$SNo?>" name="remarks[]" placeholder="Remarks"><?=$remarks;?></textarea>
</div>

<div class="w-10">
<label class="ItemTotal fw-6" id="tot<?=$SNo?>">₹<?=$total_amount;?></label>
<input type="hidden" id="tot_val<?=$SNo?>" name="total_amount[]" value="<?=$total_amount;?>">
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
<div class="col-md-12 row">
<div class="col-lg-6">
	<label for="inputAddress" class="form-label">Terms & Conditions</label>
	<textarea id="editor" name="terms_condition"><?if($terms_condition==''){?>Fitted with SKF/FAG bearings<br>
Insulation Class F<br>
Degree Of Protection : IP55<br>
Construction Material : CI/AL available<br>
Payment : Against Proforma invoice<br>
Delivery : 1 week<br>
Freight : TO Pay basis<br>
Goods once sold will not be taken back<?}else{echo stripslashes($terms_condition);}?></textarea>
</div>

<div class="col-md-6 ">
	<label for="inputAddress" class="form-label width-100 mt-3" >Company Name</label>
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
<div class="col-12 mt-3">
<input type="submit" name="Submit" class="btn btn-primary px-3" value="<? if($CountQtn >> 0) {   echo  "Update Quotation"; } else echo "Create Quotation";?>" >
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
$('<div class="row my-1 slide_show" id="p_scents" style="display:none"><div class="w-24"><select class="form-select" name="product_name[]" id="product_name'+i+'" onchange="getPrice(this.value, '+i+'<? if($ID!=''){echo", \'new_product\'";}?>)" required><option value="">Select Product</option><? $sql_product=mysqli_query($conn,"select * from  product where status='1' ORDER BY product asc"); while($row_product=mysqli_fetch_array($sql_product)){?><option value="<?=$row_product['product']?>" <? if($row_product['product'] == $ID) { ?>selected<? } ?> ><?=$row_product['product'];?></option><?}?></select></div><div class="w-15"><select class="form-select" name="brand_name[]" required><option value="">Select Brand</option><? $sql_brand=mysqli_query($conn,"select * from  brand where status='1' ORDER BY brand_name asc"); while($row_brand=mysqli_fetch_array($sql_brand)){?><option value="<?=$row_brand['brand_name']?>" <? if($row_brand['brand_name'] == $ID) { ?>selected<? } ?> ><?=$row_brand['brand_name'];?></option><?}?></select></div><div class="w-10"><input type="number" class="form-control  p-qnt" id="rate'+i+'" name="rate[]" step="any" onchange="addRate('+i+',this.value,\'rate\')" onkeyup="getTotal('+i+')" placeholder="Rate" required <?if($_SESSION['USERTYPE']==1){ echo "readonly";}?>><input type="hidden" id="rateChange'+i+'" value="1"></div><div class="w-6"><input type="number" class="form-control p-qnt" onkeyup="getTotal('+i+')" id="quantity'+i+'" name="quantity[]" min="0" onchange="addRate('+i+',this.value,\'quantity\')" placeholder="Qty" required><input type="hidden" id="qtyChange'+i+'" value="1"></div><div class="w-6 percent"><input type="number" class="form-control p-qnt" id="pkg'+i+'" min="0" max="99" onkeyup="getTotal('+i+')" name="pkg[]" value="0" onchange="addRate('+i+',this.value,\'package\')" placeholder="Pkg" required><span>%</span><input type="hidden" id="pkgChange'+i+'" value="1"></div><div class="w-9"><select class="form-select p-qnt" onchange="getTotal('+i+');addRate('+i+',this.value,\'gst\')" name="gst[]" id="gst'+i+'"><option value="0" selected>0%</option><option value="5">5%</option><option value="12">12%</option><option value="18" selected>18%</option><option value="28">28%</option></select><input type="hidden" id="gstChange'+i+'" value="1"></div><div class="w-15"><textarea class="form-control" rows="1" id="remarks'+i+'" name="remarks[]" placeholder="Remarks" ></textarea></div><div class="w-10"><label class="ItemTotal fw-6" id="tot'+i+'">₹0.00</label><input type="hidden" id="tot_val'+i+'" name="total_amount[]"></div><div class="w-5 text-end" id="remScnt" onclick="removeCont(this);"><a type="button" tooltip="Remove Product" style="width: auto;" class="pe-1"><img src="assets/images/Our/minus.png" width="27px;"></a></div></div>').appendTo(scntDiv);
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

function getPrice(val,row_id,is_new){
customer_type=$("#customer_type").html();
if(customer_type !=''){
$.ajax({
url: "fetch-price.php", 
type: "POST",
data: "id="+val+"&row_id="+row_id+"&customer_type="+customer_type,
success: function(result){
if(row_id==0){
$("#output").html(result);
if(result!=''){
$("#productSection").slideDown(500);
}else{
$("#productSection").slideUp(500);
}
}else{
$("#rate"+row_id).val(result);
if(is_new!=''){
addRate(row_id,result,'rate')
}
if(($("#quantity"+row_id).val())!=''){
getTotal(row_id);
}
}
}});
}
}

function getTotal(row_id){
rate=$("#rate"+row_id).val();
quantity=$("#quantity"+row_id).val();
pkg=$("#pkg"+row_id).val();
gst=$("#gst"+row_id).val();
total=rate*quantity;
if(gst!='0'){
tot_gst=(parseFloat(total)+((parseFloat(total)*(parseFloat(gst)/100)))).toFixed(2);
}else{
tot_gst=(total).toFixed(2);
}
if(pkg!='0' && pkg!='' ){
	tot_gst=(parseFloat(tot_gst)+(parseFloat(total)/100*parseFloat(pkg))).toFixed(2);
}
$("#tot"+row_id).html('₹'+tot_gst);
$("#tot_val"+row_id).val(tot_gst);
}
</script> 
<?if($ID!=''){?>
<script> 
function addRate(row_id,val,type){
table_type=$("#"+type+"Change"+row_id).val();
total_value=$("#tot_val"+row_id).val();
product_name=$("#product_name"+row_id).val();
id=<?=$ID;?>;
$.ajax({
url: "ajax-price-log.php", 
type: "POST",
data: "id="+id+"&product_name="+product_name+"&table_type="+table_type+"&total_value="+total_value+"&type="+type+"&new_value="+val+"&category=0",
success: function(result){
$("#"+type+"Change"+row_id).val('2');
}

});
}
</script> 
<?}?>
 <script src="assets/plugins/ckeditor/ckeditor.js"></script>
  
    <script>
CKEDITOR.replace( 'editor');
  minHeight: '800px'
    </script>

<?php

}

include 'template.php';

?>