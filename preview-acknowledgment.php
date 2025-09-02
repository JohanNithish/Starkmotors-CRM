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

$sel_rows=mysqli_query($conn,"select * from quotation where id='$ID' ");
$rows_R = mysqli_fetch_object($sel_rows);

foreach($rows_R as $K1=>$V1) $$K1 = $V1;
$select_customer=mysqli_query($conn,"select * from customer where id='$customer_id'");
$Row_customer=mysqli_fetch_array($select_customer);


$SALES_id = $ID;
$sel_rows=mysqli_query($conn,"select * from order_confirmation where id='$SALES_id' ");
$rows_R = mysqli_fetch_object($sel_rows);

foreach($rows_R as $K1=>$V1) $$K1 = $V1;
$select_customer=mysqli_query($conn,"select * from customer where id='$customer_id'");
$Row_customer=mysqli_fetch_array($select_customer);

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
if($status=="Approved"){
  $Doc_NUM="MKT/F/7.203-Rev 00-1st July 2022";
}else{
  $Doc_NUM="MKT/F/7.202-Rev 00-1st July 2022";
}
if($company_address==1)
{
$Company_address ="Stark Engineers 3/360-363, Manickampalayam, Karuvalur Main Road, Coimbatore, Tamil Nadu 641107";
$Address_2="<table class=\"no-bdr\" style=\"width:100%;\" cellspacing=\"0\"><tr><td style=\"text-align:left;width:50%;font-size:15px;\">&nbsp;&nbsp;<b>Stark Engineers, </b></td><td style=\"text-align:right;width:50%;font-size:15px;\"><b><small>".$Doc_NUM."</small> &nbsp;&nbsp;&nbsp;</b></td></tr></table>&nbsp;&nbsp;3/360-363, Manickampalayam, Karuvalur, <br>&nbsp;&nbsp;Main Road, Coimbatore, Tamil Nadu 641107";
$Gst_address="33ADEFS5652D1Z9";
}
else{
  $Company_address ="Stark motors, 96 sitra road, Kalapatti, Coimbatore 641048";
  $Address_2="<table class=\"no-bdr\" style=\"width:100%;height:0; margin:0;\" cellspacing=\"0\"><tr><td style=\"text-align:left;width:50%;font-size:15px;\">&nbsp;&nbsp;<b>Stark Motors, </b></td><td style=\"text-align:right;width:50%;font-size:15px;\"><b><small>".$Doc_NUM."  </small>&nbsp;&nbsp;&nbsp;</b></td></tr></table>&nbsp;&nbsp;96, Sitra Road, Kalapatti,<br>&nbsp;&nbsp;Coimbatore 641048,";
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
hr{
  margin:5px 0px;
}
</style>';
// if($enquiry_num!=''){
//   $Customer_PO="<br><b>Customer PO No.: ".$enquiry_num."</b>";
//   }
//   else{
//     $Customer_PO="";
//   }
if($refered_by!=''){
  $job_card_no = '<br><b>Job Card No: '.$refered_by.'</b>';
}else{
  $job_card_no = '';
}
$Type_client = "<b>Order Acknowledgment</b> - ".$enquiry_num."<br> ".
      
      "<b>The details of your order are given below: </b><br><br>";

$Type_stark = "<b>Order Acknowledgment</b> - ".$enquiry_num."<br> ".
      
      "<b>The details are given below: </b><br><br>";

      "<b>The details of your order are given below: </b><br><br>";
 $message   .=  '<table class="no-bdr" style="width: 70%;"><tr><td style="width:100%;"><table style="padding:0px;border:1px solid #000;width:100%;"><tr style="vertical-align: middle;"><td style="width:30%;" ><p class="adds-titl" style="text-align:center;"><a href="www.starkmotors.com" target="_blank" style="text-align:center;"><img src="https://crm.starkmotors.com/assets/images/Our/logo2.png" width="135px;"></a></p></td><td style="border-left:1px solid #000;color:#000;font-size:14px;"><p class="adds-titl" style="text-align:left;font-size:12px;line-height:15px;font-weight:normal;">'.$Address_2.'<br>&nbsp;&nbsp;Phone: + 91 94426 14612, + 91 98433 14612,<br>&nbsp;&nbsp;Landline: 0422 -2627672, 0422 -2627612, 0422 -4274969, 0422 -4385612,<br>&nbsp;&nbsp;E-mail:sales@starkmotors.com<br>&nbsp;&nbsp;GST:'.$Gst_address.'</p></td></tr></table>';

$message   .=  '<table style="padding:5px 5px;width:100%;border:1px solid #000;" cellspacing="0px"><tr style="background-color:#287dcf;color:#fff;width:100%;"><td style="width:100%;padding:8px 3px;text-align:center;font-size:16px;color:#fff;font-weight:700;" >ORDER ACKNOWLEDGMENT</td></tr></table><table style="padding:5px 5px;width:100%;border:1px solid #000;" cellspacing="0px"><tr><td style="width:50%;border: 1px solid #000;" ><p class="adds-titl" style="line-height:1.3;font-size:13px;margin:2px 5px;" ><b>PO No: '.$enquiry_num.'</b>'.$job_card_no.'<br><b>No of Items: '.$products_count.'</b></p></td><td style="width:50%;border: 1px solid #000;" ><p style="margin:2px 5px;font-size:13px;line-height:1.3;" ><b>PO Date: '.date('d-m-Y', strtotime($invoice_date)).' </b><br><b>Total Amount: Rs. '.$total_order_amount.'</b>'.$Customer_PO.'</p></td></tr><tr><td style="width:50%;border: 1px solid #000;" ><p class="adds-titl" style="line-height:1.4;font-size:13px;margin:2px 5px;" ><b>To,</b><br> <span>&nbsp;&nbsp;&nbsp;&nbsp;'.$company_name.''.wordwrap($address, 45, "<br />&nbsp;&nbsp;&nbsp;&nbsp;\n").' '.$state.$Pin_code.''.$GST.'</span></p></td><td style="width:50%;font-size:13px;border: 1px solid #000;" ><b style="margin:0px 0px 0px 5px;">Contact Person Name:</b>&nbsp;&nbsp;&nbsp;'.$customer_name.'<br><b style="margin:0px 0px 0px 5px;">Phone:&nbsp;&nbsp;</b>'.$mobile.'<br><b style="margin:0px 0px 0px 5px;">Email:&nbsp;&nbsp;</b>'.$email.'</td></tr></table>';

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
$sel_product=mysqli_query($conn,"select * from ordered_products where sales_id='$SALES_id' ");
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
    $estimated_delivery_date='<tr style="width:100%;line-height:1"><td>&nbsp;</td></tr><tr nobr="true" style="width:100%;line-height:1.5"><td style="border-top:1px solid #000;"><b style="line-height:1.5;text-align:left;font-size:12px;">Estimated Delivery: </b></td><td style="border-top:1px solid #000;"><span style="font-size:11px;margin:0;">'.date('d-m-Y', strtotime($estimated_delivery)).'</span></td></tr>';
  }else{
$estimated_delivery_date="";
  }
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
if($row_mertics['degree']!=''){ $degree="<br>Deg of Prot-".$row_mertics['degree'];}else{$degree="";}
if($row_mertics['frequency']!=''){ $frequency="<br>Freq-".$row_mertics['frequency'];}else{$degree="";}
if($row_product['remarks']!=''){ $remarks='<hr>Remarks-'.$row_product['remarks'];}else{$remarks="";}
if($row_mertics['model']!=''){ $model="<br>Model-".$row_mertics['model'];}else{$model="";}
if($row_mertics['efficiency']!=''){ $efficiency="<br>Efficiency-".$row_mertics['efficiency'];}else{$efficiency="";}
if($row_mertics['special_requirements']!=''){ $special_requirements='<hr>Special Req.-'.$row_mertics['special_requirements'];}else{$special_requirements="";}



$message .= '<tr class="tr-head" style="color:#000">
<td style="text-align:center;width:4.5%;font-size:12px;border: 1px solid #000;border-bottom: 1px solid #000;">'.$SNo.'</td> 
<td style="text-align:left;width:25%; line-height:1.3;padding:3px;font-size:12px;border: 1px solid #000;">'.$product_name.'<span style="line-height:0px;"><br></span><table class="no-bdr" style="width:100%;text-align:left;border-top: 1px solid #000;">
<tr nobr="true"><td><b style="line-height:2;text-align:center;font-size:12px;">Specification</b></td></tr>
<tr nobr="true"><td style="width:50%;line-height:1.2;font-size:12px;border-right:1px solid #000;">'.$model.$kw.$hp.$rpm.$volt.$ins_cl.$degree.$frequency.$special_requirements.'</td><td style="width:50%;line-height:1.2;font-size:12px;padding: 0px 5px;">'.$type.$mounting.$frame.$efficiency.$remarks.' </td></tr>'.$estimated_delivery_date.'</table></td><td style="text-align:center;width:8.4%;font-size:12px;border: 1px solid #000;border-bottom: 1px solid #000;">'.$hsn_code.'</td> 
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
    width: 100%;"><tr><td class="tb-row" style="width:61%; font-weight: normal;font-size:12px;border: 1px solid #000;border-bottom: 1px solid #000;font-size:12px;text-align:center;padding: 6px;"><p style="text-align:center; font-weight: 600;font-size:12px;border: 1px solid #000;border-bottom: 1px solid #000;margin:0 0px; padding:10px;background-color: #ffff92;"><b style="font-weight: 800;">GST Details</b></p><table style="padding:0px 7px 7px 7px;width:100%"><tbody><tr></tr><tr class="tr-head" style="background-color:#fff;color:#000">
<th style="text-align:center;width:16%; font-weight: 700;font-size:10px;border: 1px solid #000;border-bottom: 1px solid #000;"><b style="font-weight: 800;">CGST %</b></th> 
<th style="text-align:center;width:17%; font-weight: 600;font-size:9px;border: 1px solid #000;border-bottom: 1px solid #000;"><b style="font-weight: 800;">CGST</b></th>
<th style="text-align:center;width:12.5%; font-weight: 600;font-size:9px;border: 1px solid #000;border-bottom: 1px solid #000;"><b style="font-weight: 800;">'.$GST_Type.' %</b></th>
<th style="text-align:center;width:17%; font-weight: 600;font-size:9px;border: 1px solid #000;border-bottom: 1px solid #000;"><b style="font-weight: 800;">'.$GST_Type.'</b></th>
<th style="text-align:center;width:21%; font-weight: 600;font-size:9px;border: 1px solid #000;border-bottom: 1px solid #000;"><b style="font-weight: 800;">Gross<br>Bill Value</b></th>
<th style="text-align:center;width:16.5%; font-weight: 600;font-size:9px;border: 1px solid #000;border-bottom: 1px solid #000;"><b style="font-weight: 800;">Total <br>GST</b></th>

</tr>';}else{
$message .= '</table><table cellpadding="6px" style="border: 1px;
    width: 100%;"><tr><td class="tb-row" style="width:61%; font-weight: normal;font-size:12px;border: 1px solid #000;border-bottom: 1px solid #000;font-size:12px;text-align:center;padding: 6px;"><p style="text-align:center; font-weight: 600;font-size:12px;border: 1px solid #000;border-bottom: 1px solid #000;margin:0 0px; padding:10px;background-color: #ffff92;"><b style="font-weight: 800;">GST Details</b></p><table style="padding:0px 7px 7px 7px;width:100%"><tbody><tr class="tr-head" style="background-color:#fff;color:#000">
<th style="text-align:center;width:25%; font-weight: 600;font-size:9px;border: 1px solid #000;border-bottom: 1px solid #000;"><b style="font-weight: 800;">'.$GST_Type.' %</b></th>
<th style="text-align:center;width:25%; font-weight: 600;font-size:9px;border: 1px solid #000;border-bottom: 1px solid #000;"><b style="font-weight: 800;">'.$GST_Type.'</b></th>
<th style="text-align:center;width:25%; font-weight: 600;font-size:9px;border: 1px solid #000;border-bottom: 1px solid #000;"><b style="font-weight: 800;">Gross<br>Bill Value</b></th>
<th style="text-align:center;width:25%; font-weight: 600;font-size:9px;border: 1px solid #000;border-bottom: 1px solid #000;"><b style="font-weight: 800;">Total <br>GST</b></th>

</tr>';}
$sel_gstTax=mysqli_query($conn,"SELECT *,COALESCE(SUM(gst_amount),0) as totalgst, COALESCE(SUM(product_amount),0) as tproductamt FROM ordered_products where sales_id='$SALES_id' GROUP BY gst ");


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

$message .= '</tbody></table></td><td class="tb-row" style="width:39%;padding: 6px; font-weight: normal;background-color:#fff;font-size:13px;border: 1px solid #000;border-bottom: 1px solid #000;font-size:13px;text-align:right;"><table cellpadding="7px" style="padding:8px;width: 100%;"><tr><td class="tb-row" style="width:60%; font-weight: normal;font-size:13px;border: 1px solid #000;border-bottom: 1px solid #000;padding:10px;background-color:#ffff92;"><b>Taxable</b></td>  

<td class="tb-row" style="width:40%; font-weight: normal;font-size:13px;border: 1px solid #000;border-bottom: 1px solid #000;padding:10px;background-color:#ffff92;">Rs. '.$PRODUCT_amount.'</td></tr>';

$message .= '<tr ><td class="tb-row" style="width:60%; font-weight: normal;font-size:13px;border: 1px solid #000;border-bottom: 1px solid #000;font-size:13px;text-align:right;padding:10px;"><b>Packing Charges</b></td>  

<td class="tb-row" style="width:40%; font-weight: normal;font-size:13px ;border: 1px solid #000;border-bottom: 1px solid #000;padding:10px;">'.$total_package_amount.'</td></tr>';

$message .= '<tr ><td class="tb-row" style="width:60%; font-weight: normal;font-size:13px;border: 1px solid #000;border-bottom: 1px solid #000;font-size:13px;text-align:right;padding:10px;"><b>Freight Charges</b></td>  

<td class="tb-row" style="width:40%; font-weight: normal;font-size:13px ;border: 1px solid #000;border-bottom: 1px solid #000;padding:10px;">Rs. '.$total_freight.'</td></tr>';



if($state=='Tamil Nadu'){
$message .= '<tr ><td class="tb-row" style="width:60%; font-weight: normal;font-size:13px;border: 1px solid #000;border-bottom: 1px solid #000;font-size:13px;text-align:right;padding:10px;"><b>CGST</b></td>  

<td class="tb-row" style="width:40%; font-weight: normal;font-size:13px ;border: 1px solid #000;border-bottom: 1px solid #000;padding:15px;">'.$GST_amount.'</td></tr>';

$message .= '<tr ><td class="tb-row" style="width:60%; font-weight: normal;font-size:13px;border: 1px solid #000;border-bottom: 1px solid #000;font-size:13px;text-align:right;padding: 10px;"><b>SGST</b></td>  

<td class="tb-row" style="width:40%; font-weight: normal;font-size:13px ;border: 1px solid #000;border-bottom: 1px solid #000;padding:15px;">'.$GST_amount.'</td></tr>';
}else{
  $message .= '<tr ><td class="tb-row" style="width:60%; font-weight: normal;font-size:13px;border: 1px solid #000;border-bottom: 1px solid #000;font-size:13px;padding: 10px;text-align:right;"><b>IGST</b></td>  

<td class="tb-row" style="width:40%; font-weight: normal;font-size:13px ;border: 1px solid #000;border-bottom: 1px solid #000;padding:15px;">'.$Tot_GST_amount.'</td></tr>';
}

$message .= '<tr ><td class="tb-row" style="width:60%; font-weight: normal;font-size:13px;border: 1px solid #000;border-bottom: 1px solid #000;font-size:13px;text-align:right;padding:10px;"><b>Total GST</b></td>  

<td class="tb-row" style="width:40%; font-weight: normal;font-size:13px ;border: 1px solid #000;border-bottom: 1px solid #000;padding:10px;">'.$Tot_GST_amount.'</td></tr>';


$message .= '<tr ><td class="tb-row" style="width:60%; font-weight: normal;font-size:13px;border: 1px solid #000;border-bottom: 1px solid #000;font-size:13px;background-color:#ffff92;text-align:right;padding:10px;"><b>Net Amount</b></td>  

<td class="tb-row" style="width:40%; font-weight: normal;font-size:13px ;border: 1px solid #000;border-bottom: 1px solid #000;background-color:#ffff92;padding:10px;">Rs. '.$Total_order_amount.'</td></tr></table>';

$message .= '</td></tr></table>';
 
if($terms_condition!=''){
$message   .=  '<table nobr="true" cellpadding="0px" style="width:100%;border-spacing: 6px 5px;padding:5px 5px;border: 1px solid #000;border-bottom: 0px solid #000;">
<tr class="no-bdr" nobr="true"><td style="width:100%;font-size:13px; padding:5px 10px 1px;" ><b>Terms & Conditions:</b></td></tr>
                 <tr class="no-bdr"><td style="width:100%;font-size:13px; padding:5px 10px;" class="terms">'.$terms_condition.'
                </td></tr></table>';
}


// if($company_address==1)
// {
// $message   .=  '<div style="padding:0px 9px 5px 9px;line-height:0;background-color:#e8e8e8;border: 2px solid #000;">
//                  <div style="display:flex;"><div style="width:73%;line-height:0; border-width:0px; margin:0px;"><b class="adds-titl" style="line-height:0.5;"><br><br>Bank Details:</b></div>
//                  <div style="width:27%;line-height:0; border-width:0px;text-align:center;margin:0px;"><p class="adds-titl" style="line-height:0.5;font-size:11px;"><br>For Stark Engineers</p></div></div>
// <div style="display:flex;">
// <div class="" style="width:12%;line-height:1.3;font-size:13px;" >
// Bank Name:<br>A/C Name:<br>A/C Number:
// </div>
// <div class="" style="width:24%;line-height:1.3;font-size:13px;" >
// <b>Karur Vysya Bank<br>Stark Engineers<br>1662135000006162</b>
// </div>
// <div class="" style="width:8%;line-height:1.3;font-size:13px;" >
// Branch:<br>IFSC:
// </div>
// <div class="" style="width:29%;line-height:1.3;font-size:13px;" >
// <b>Kalappatti<br>KVBL0001662</b>
// </div>
// <div class="" style="width:27%;line-height:1.3;font-size:11px;text-align:center;" >
// <p style="font-size:13px;margin: 0;line-height:0.5"><br><br><br><br></p>
// Authorised Signatory
// </div>
// </div>
// </div>';}
// else{
//   $message   .=  '<div style="padding:0px 9px 5px 9px;line-height:0;background-color:#e8e8e8;border: 2px solid #000;">
//                  <div style="display:flex;"><div style="width:73%;line-height:0; border-width:0px; margin:0px;"><b class="adds-titl" style="line-height:0.5;"><br><br>Bank Details:</b></div>
//                  <div style="width:27%;line-height:0; border-width:0px;text-align:center;margin:0px;"><p class="adds-titl" style="line-height:0.5;font-size:11px;"><br><br>For Stark Motors</p></div></div>
// <div style="display:flex;">
// <div class="" style="width:12%;line-height:1.3;font-size:13px;" >
// Bank Name:<br>A/C Name:<br>A/C Number:
// </div>
// <div class="" style="width:24%;line-height:1.3;font-size:13px;" >
// <b>City Union Bank<br>Stark Motors<br>053120000014363</b>
// </div>
// <div class="" style="width:8%;line-height:1.3;font-size:13px;" >
// Branch:<br>IFSC:
// </div>
// <div class="" style="width:29%;line-height:1.3;font-size:13px;" >
// <b>Vilankurichi<br>CIUB0000053</b>
// </div>
// <div class="" style="width:27%;line-height:1.3;font-size:11px;text-align:center;" >
// <p style="font-size:13px;margin: 0;line-height:0.5"><br><br><br><br></p>
// Authorised Signatory
// </div>
// </div>
// </div>
// ';
// }



// if($company_address==1)
// {
$message   .=  '<table class="no-bdr" width="100%" cellpadding="5px" style="padding:15px;line-height:2;background-color:#e8e8e8;border: 2px solid #000;">
                 <tr nobr="true"><td style="width:50%;line-height:1; border-width:0px; margin:0px;padding: 0px 10px;"><b class="adds-titl" ><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Bank Details </b><br><br><img src="assets/images/Our/qr1.png" width="135px" ><br><br></td>
                 <td style="width:50%;line-height:1;padding: 0px 10px; border-width:0px;text-align:right;margin:0px;"><b class="adds-titl" ><br>Website&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b><br><br><img src="assets/images/Our/qr2.png" width="135px" ><br><br></td></tr></table>';
// }
// else{
//   $message   .=  '<table class="no-bdr" width="100%" cellpadding="5px" style="padding:15px;line-height:2;background-color:#e8e8e8;border: 2px solid #000;">
//                 <tr nobr="true"><td style="width:50%;line-height:1; border-width:0px; margin:0px;padding: 0px 10px;"><b class="adds-titl" ><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Bank Details </b><br><br><img src="assets/images/Our/qr1.png" width="135px" ><br><br></td>
//                 <td style="width:50%;line-height:1;padding: 0px 10px; border-width:0px;text-align:right;margin:0px;"><b class="adds-titl" ><br>Website&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b><br><br><img src="assets/images/Our/qr2.png" width="135px" ><br><br></td></tr></table>
// ';
// }
$message .='<td style="width:20%;"></td></td></tr></table>';


if(isset($_POST['Submit'])){
if($Submit=='Send Mail')
{
$message   .=  '</body></html>';
$Client_Message2='<div>
<div width="9" height="30"><br><br>&nbsp;Best regards, <br><br>    </div>
<div width="782" height="30"><strong><a href="https://starkmotors.com/" style="color:#000;">&nbsp;Stark Motors</a> </strong>
<div width="10" height="30">&nbsp;</div>
</div>';
$subject="Quotation for SQ".$QUOTATION_id;
$stark_subject="Quote for Energy Efficient Motors SQ".$QUOTATION_id;

        $to=$email;
        $stark_mail="mktg.starkmotors@gmail.com";
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= 'Sender: <noreply@starkmotors.com>' . "\r\n";
        $headers .= 'From: Stark Motors<noreply@starkmotors.com>' . "\r\n";
        $headers .= 'Bcc: <support@starkmotors.com>' . "\r\n";
        $headers .= 'Reply-To: Stark Motors <noreply@starkmotors.com>' . "\r\n";

        $Client_Message= $Type_client.$message.$Client_Message2;
        $Stark_Message= $Type_stark.$message;   
        $res1=mail($to , $subject, $Client_Message, $headers, '-fnoreply@starkmotors.com');
        $res2=mail($stark_mail , $stark_subject, $Stark_Message, $headers, '-fnoreply@starkmotors.com');
if($res2 && $res1)
{
$msg = 'Mail Send Successfully';
header('Location:list-sales.php?msg='.$msg);
}
else
{
$alert_msg = 'Could not able to send mail try once again!!!';    
}
} 
}  
?>

<body >
  <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-2">
<h6 class="mb-0 text-uppercase">Preview Acknowledgment</h6>

<div class="ms-auto">
<div class="col">
<a href="list-sales.php" class="btn btn-danger px-3 ">Back</a>
<!-- Modal -->
</div>
</div>
</div><hr/>
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
<form action="#" method="post" class="mt-3" enctype="multipart/form-data" name="form1">
<div>
  <?=$message ;?>
 <div class="col-8 mt-3 mb-5"> 
<input type="submit" name="Submit" class="btn btn-primary px-5" value="Send Mail" >
</div> 
</div>
</form>

<?php

}

include 'template.php';

?>