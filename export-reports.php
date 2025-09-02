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

$select_qry=mysqli_query($conn,"select * from test_report where id='$ID' "); 
$row_R=mysqli_fetch_array($select_qry);
foreach ($row_R as $K1 => $V1) {
    $$K1 = ($V1 !== "") ? $V1 : 'NA';
}

$Company_address ="Routine Test Certificate 3ph Ind. Motor";
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
$this->Cell(0,0,'Landline: 0422-4274969, 0422-4385612, Website: www.starkmotors.com Email:  sales@starkmotors.com', 0, false, 'C', 0, '', 0, false, 'T', 'M');

// Page number
$this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'M', 'M');
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


// if($enquiry_num!=''){
//   $Customer_PO="<br><b>Customer PO No.: ".$enquiry_num."</b>";
//   }
//   else{
//     $Customer_PO="";
//   }
 $htmlData   .=  '<table style="padding:5px 5px;"><tr style="vertical-align: middle;"><td style="width:30%;" ><p class="adds-titl" ><a href="www.starkmotors.com" target="_blank" style="text-align:center;"><img src="assets/images/Our/logo2.png" width="90px;"></a></p></td><td width="70%" style="border:.1px solid #8e8e8e;"><p class="adds-titl" style="text-align:left;font-size:16px;line-height:15px;font-weight:bold;">Routine Test Certificate 3ph Ind. Motor</p><p class="adds-titl" style="text-align:left;font-size:14px;line-height:1px;font-weight:normal;">Machine No: <small style="font-size:11px">'.$machine_num.'</small></p><p class="adds-titl" style="text-align:left;font-size:14px;line-height:1px;font-weight:normal;">Customer Part Code: <small style="font-size:11px">'.$product.'</small></p><p class="adds-titl" style="text-align:left;font-size:14px;line-height:1px;font-weight:normal;">S. O. No: <small style="font-size:11px">'.$so_num.'</small></p></td></tr></table>';

// PROFORMA ENTRANCE
// SALES ACKNOWLEDGEMENT
$htmlData   .=  '<table style="padding:5px 5px;"><tr style="background-color:#fff;color:#000"><td style="width:100%;" ><h1 style="text-align:left;font-size:14px;color:#000;">NAME PLATE DATA:</h1></td></tr><tr><td style="width:33.3%;" ><p class="adds-titl" style="line-height:1.6;font-size:11px;" ><b>Type: &nbsp;</b> '.$type.'<br><b>KW/HP: &nbsp;</b> '.$kw.'/'.$hp.'<b><br>Current: &nbsp;</b> '.$current.'<br><b>Voltage: &nbsp;</b> '.$volt.'<br><b>Speed: &nbsp;</b> '.$rpm.'<br><b>CYC: &nbsp;</b> '.$cyc.'<br><b>Phase: &nbsp;</b> '.$phase.'</p></td><td style="width:33.3%;" ><p style="font-size:11px;line-height:1.6;" ><b>Frequency: &nbsp;</b> '.$frequency.'<br><b>Efficiency: &nbsp;</b> '.$efficiency.'<br><b>Power Factor: &nbsp;</b> '.$power_factor.'<br><b>Connection: &nbsp;</b>  '.$connection.'<br><b>Protection: &nbsp;</b> '.$degree.'<br><b>FLC: &nbsp;</b> '.$flc.'</p></td><td style="width:33.3%;" ><p style="font-size:11px;line-height:1.6;" ><b>Duty: &nbsp;</b> '.$duty.'<br><b>CD S1 Output: &nbsp;</b> '.$cd_s1_output.'<br><b>Ins. Cl.: &nbsp;</b> '.$ins_cl.'<br><b>Frame: &nbsp;</b>  '.$frame.'<br><b>Ref. Standard : &nbsp;</b> '.$ref_standard.'<br><b>Rating : &nbsp;</b> '.$rating.'</p></td></tr></table>';

$htmlData   .=  '<table style="padding:5px 5px;"><tr><td style="width:33.3%;" ><p class="adds-titl" style="line-height:1.6;font-size:11px;" ><b>Winding Resistance at 75°C: &nbsp;&nbsp;</b> '.$resistance.'</p></td><td style="width:33.3%;" ><p style="font-size:11px;line-height:1.6;" ><b>Minimum Starting Voltage (Volts): &nbsp;&nbsp;</b> '.$min_voltage.'</p></td><td style="width:33.3%;" ><p style="font-size:11px;line-height:1.6;" ><b>HVT at 1800V: &nbsp;</b> '.$hvt.'</p></td></tr>
<tr><td style="width:33.3%;" ><table style="border:.1px solid #8e8e8e;line-height:1"><tr><td style="width:100%"><p class="adds-titl" style="line-height:2.1;font-size:11px;text-align:center" ><b>Insulation Resistance</b> </p></td></tr><tr><td style="width:50%"><p class="adds-titl" style="line-height:2.1;font-size:11px;" ><b>Before HVT M  &nbsp;</b> </p></td><td style="width:50%"><p class="adds-titl" style="line-height:2.1;font-size:11px;" ><b>After HVT M  &nbsp;</b> </p></td></tr><tr><td><p class="adds-titl" style="line-height:2.1;font-size:11px;" >'.$before_hvt.'</p></td><td><p class="adds-titl" style="line-height:2.1;font-size:11px;" >'.$after_hvt.'</p></td></tr></table></td><td style="width:33.3%;" ><table style="border:.1px solid #8e8e8e;line-height:1"><tr><td style="width:100%"><p class="adds-titl" style="line-height:2.1;font-size:11px;text-align:center" ><b>Reduced</b> </p></td></tr><tr><td style="width:50%"><p class="adds-titl" style="line-height:2.1;font-size:11px;" ><b>Volt (ACW RPM)  &nbsp;</b> </p></td><td style="width:50%"><p class="adds-titl" style="line-height:2.1;font-size:11px;" ><b>Test (CW RPM)  &nbsp;</b> </p></td></tr><tr><td><p class="adds-titl" style="line-height:2.1;font-size:11px;" >'.$volt_acw.'</p></td><td><p class="adds-titl" style="line-height:2.1;font-size:11px;" >'.$test_cw.'</p></td></tr></table></td><td style="width:33.3%;" ><table style="border:.1px solid #8e8e8e;line-height:1"><tr><td style="width:100%"><p class="adds-titl" style="line-height:2.1;font-size:11px;text-align:center" ><b>No Load</b> </p></td></tr><tr><td style="width:33.3%"><p class="adds-titl" style="line-height:2.1;font-size:11px;" ><b>V  &nbsp;</b> </p></td><td style="width:33.3%"><p class="adds-titl" style="line-height:2.1;font-size:11px;" ><b>I  &nbsp;</b> </p></td><td style="width:33.3%"><p class="adds-titl" style="line-height:2.1;font-size:11px;" ><b>W  &nbsp;</b> </p></td></tr><tr><td><p class="adds-titl" style="line-height:2.1;font-size:11px;" >'.$no_load_v.'</p></td><td><p class="adds-titl" style="line-height:2.1;font-size:11px;" >'.$no_load_i.'</p></td><td><p class="adds-titl" style="line-height:2.1;font-size:11px;" >'.$no_load_w.'</p></td></tr></table></td></tr>

<tr><td style="width:50%;" ><p class="adds-titl" style="line-height:1.6;font-size:11px;" ><b>Starting Torque (%): &nbsp;&nbsp;</b> '.$starting_torque.'</p></td><td style="width:50%;" ><p style="font-size:11px;line-height:1.6;" ><b>Starting Current AMP: &nbsp;&nbsp;</b> '.$starting_current.'</p></td></tr>
</table>';


$htmlData   .=  '<table style="padding:5px 5px;"><tr style="background-color:#fff;color:#000"><td style="width:100%;" ><h1 style="text-align:left;font-size:14px;color:#000;">OTHER DATA:&nbsp;</h1></td></tr><tr><td style="width:33.3%;" ><p class="adds-titl" style="line-height:1.6;font-size:11px;" ><b>Direction: &nbsp;&nbsp;</b> '.$direction.'<br><b>DE Bearing: &nbsp;</b> '.$de_bearing.'<b><br>NDE Bearing: &nbsp;</b> '.$nde_bearing.'<br><b>Construction: &nbsp;&nbsp;</b> '.$construction.'</p></td><td style="width:33.3%;" ><p style="font-size:11px;line-height:1.6;" ><b>T. Box Position: &nbsp;</b> '.$t_box_position.'<br><b>Rotor Voltage: &nbsp;</b> '.$rotor_voltage.'<br><b>Rotor Current: &nbsp;</b> '.$rotor_current.'</p></td><td style="width:33.3%;" ><p style="font-size:11px;line-height:1.6;" ><b>Rotor Class: &nbsp;</b> '.$rotor_class.'<br><b>A. C. Heater: &nbsp;</b>  '.$a_c_heater.'<br><b>PTC: &nbsp;</b> '.$ptc.'<br><b>RTD: &nbsp;</b> '.$rtd.'</p></td></tr></table>';

$htmlData   .=  '<table style="padding:5px 5px;"><tr style="background-color:#fff;color:#000"><td style="width:100%;" ><h1 style="text-align:left;font-size:14px;color:#000;">TEST RESULTS: <small style="font-size:11px;">'.$test_results.'</small></h1></td></tr><tr><td style="width:33.3%;" ><table style="border:.1px solid #8e8e8e;line-height:1"><tr><td><p class="adds-titl" style="line-height:2.1;font-size:11px;" ><b>Polarity & Connection  &nbsp;</b> </p></td></tr><tr><td><p class="adds-titl" style="line-height:2.1;font-size:11px;" >'.$test_polarity.'</p></td></tr></table></td><td style="width:33.3%;" ><table style="border:.1px solid #8e8e8e;line-height:1"><tr><td><p class="adds-titl" style="line-height:2.1;font-size:11px;" ><b>Avg Res(Ohms)  &nbsp;</b> </p></td></tr><tr><td><p class="adds-titl" style="line-height:2.1;font-size:11px;" >'.$avg_res.'</p></td></tr></table></td><td style="width:33.3%;" ><table style="border:.1px solid #8e8e8e;line-height:1"><tr><td><p class="adds-titl" style="line-height:2.1;font-size:11px;" ><b>Amb Temp(c) &nbsp;</b> </p></td></tr><tr><td><p class="adds-titl" style="line-height:2.1;font-size:11px;" >'.$amb_temp.'</p></td></tr></table></td></tr></table>';


$htmlData   .=  '<table style="padding:5px 5px;"><tr style="background-color:#fff;color:#000"><td style="width:100%;" ><h1 style="text-align:left;font-size:14px;color:#000;"> NO LOAD TEST : <small style="font-size:11px;">'.$no_load_test.'</small></h1></td></tr><tr><td style="width:25%;" ><table style="border:.1px solid #8e8e8e;line-height:1"><tr><td><p class="adds-titl" style="line-height:2.1;font-size:11px;" ><b>Polarity & Connection &nbsp;</b> </p></td></tr><tr><td><p class="adds-titl" style="line-height:2.1;font-size:11px;" >'.$no_load_polarity.'</p></td></tr></table></td><td style="width:25%;" ><table style="border:.1px solid #8e8e8e;line-height:1"><tr><td><p class="adds-titl" style="line-height:2.1;font-size:11px;" ><b>Voltage(Volts) &nbsp;</b> </p></td></tr><tr><td><p class="adds-titl" style="line-height:2.1;font-size:11px;" >'.$no_load_voltage.'</p></td></tr></table></td><td style="width:25%;" ><table style="border:.1px solid #8e8e8e;line-height:1"><tr><td><p class="adds-titl" style="line-height:2.1;font-size:11px;" ><b>Current(Amp.) &nbsp;</b> </p></td></tr><tr><td><p class="adds-titl" style="line-height:2.1;font-size:11px;" >'.$no_load_current.'</p></td></tr></table></td><td style="width:25%;" ><table style="border:.1px solid #8e8e8e;line-height:1"><tr><td><p class="adds-titl" style="line-height:2.1;font-size:11px;" ><b>Input Power (watts) &nbsp;</b> </p></td></tr><tr><td><p class="adds-titl" style="line-height:2.1;font-size:11px;" >'.$no_load_input_power.'</p></td></tr></table></td></tr></table>';



$htmlData   .=  '<table style="padding:5px 5px;"><tr style="background-color:#fff;color:#000"><td style="width:100%;margin:0" ><h1 style="text-align:left;font-size:14px;color:#000;line-height:20px;margin:0"> REDUCED VOLTAGE RUN UP TEST :  <small style="font-size:11px;">   '.$reduced_voltage.'</small></h1></td></tr><tr><td><p class="adds-titl" style="line-height:2.1;font-size:11px;" ><b>Locked Rotor Test :   &nbsp;</b>   '.$locked_rotor_test.'</p></td></tr><tr><td style="width:25%;" ><table style="border:.1px solid #8e8e8e;line-height:1"><tr><td><p class="adds-titl" style="line-height:2.1;font-size:11px;" ><b>Polarity & Connection &nbsp;</b> </p></td></tr><tr><td><p class="adds-titl" style="line-height:2.1;font-size:11px;" >'.$locked_polarity.'</p></td></tr></table></td><td style="width:25%;" ><table style="border:.1px solid #8e8e8e;line-height:1"><tr><td><p class="adds-titl" style="line-height:2.1;font-size:11px;" ><b>Voltage(Volts) &nbsp;</b> </p></td></tr><tr><td><p class="adds-titl" style="line-height:2.1;font-size:11px;" >'.$locked_voltage.'</p></td></tr></table></td><td style="width:25%;" ><table style="border:.1px solid #8e8e8e;line-height:1"><tr><td><p class="adds-titl" style="line-height:2.1;font-size:11px;" ><b>Current(Amp.) &nbsp;</b> </p></td></tr><tr><td width="33.3%"><p class="adds-titl" style="line-height:2.1;font-size:11px;" >'.$locked_current1.'</p></td><td width="33.3%"><p class="adds-titl" style="line-height:2.1;font-size:11px;" >'.$locked_current2.'</p></td><td width="33.3%"><p class="adds-titl" style="line-height:2.1;font-size:11px;" >'.$locked_current3.'</p></td></tr></table></td><td style="width:25%;" ><table style="border:.1px solid #8e8e8e;line-height:1"><tr><td><p class="adds-titl" style="line-height:2.1;font-size:11px;" ><b>Input Power (watts) &nbsp;</b> </p></td></tr><tr><td><p class="adds-titl" style="line-height:2.1;font-size:11px;" >'.$locked_input_power.'</p></td></tr></table></td></tr></table>';


$htmlData   .=  '<table style="padding:5px 5px;"><tr style="background-color:#fff;color:#000"><td style="width:100%;" ><h1 style="text-align:left;font-size:14px;color:#000;"> HIGH VOLTAGE TEST :  <small style="font-size:11px;">   '.$high_voltage_test.'</small></h1></td></tr><tr><td style="width:25%;" ><table style="border:.1px solid #8e8e8e;line-height:1"><tr><td><p class="adds-titl" style="line-height:2.1;font-size:11px;" ><b>Polarity & Connection &nbsp;</b> </p></td></tr><tr><td><p class="adds-titl" style="line-height:2.1;font-size:11px;" >'.$high_polarity.'</p></td></tr></table></td><td style="width:25%;" ><table style="border:.1px solid #8e8e8e;line-height:1"><tr><td><p class="adds-titl" style="line-height:2.1;font-size:11px;" ><b>Voltage &nbsp;</b> </p></td></tr><tr><td><p class="adds-titl" style="line-height:2.1;font-size:11px;" >'.$high_voltage.'</p></td></tr></table></td><td style="width:25%;" ><table style="border:.1px solid #8e8e8e;line-height:1"><tr><td><p class="adds-titl" style="line-height:2.1;font-size:11px;" ><b>Duration &nbsp;</b> </p></td></tr><tr><td><p class="adds-titl" style="line-height:2.1;font-size:11px;" >'.$duration.'</p></td></tr></table></td><td style="width:25%;" ><table style="border:.1px solid #8e8e8e;line-height:1"><tr><td><p class="adds-titl" style="line-height:2.1;font-size:11px;" ><b>Remarks &nbsp;</b> </p></td></tr><tr><td><p class="adds-titl" style="line-height:2.1;font-size:11px;" >'.$remarks.'</p></td></tr></table></td></tr><tr style="boder:0px solid #000"><td width="100%"><p class="adds-titl" style="line-height:2.1;font-size:11px;" ><b>Insulation Resistance Test:     &nbsp;&nbsp;</b>   '.$insulation_resistance_test.'</p></td></tr><tr><td style="width:50%;" ><table style="border:.1px solid #8e8e8e;line-height:1"><tr><td><p class="adds-titl" style="line-height:2.1;font-size:11px;" ><b>Winding &nbsp;</b> </p></td></tr><tr><td><p class="adds-titl" style="line-height:2.1;font-size:11px;" >'.$winding.'</p></td></tr></table></td><td style="width:50%;" ><table style="border:.1px solid #8e8e8e;line-height:1"><tr><td><p class="adds-titl" style="line-height:2.1;font-size:11px;" ><b>Insulation Resistance &nbsp;</b> </p></td></tr><tr><td><p class="adds-titl" style="line-height:2.1;font-size:11px;" >'.$insulation_resistance.'</p></td></tr></table></td></tr><tr><td width="100%"><p class="adds-titl" style="line-height:1.6;font-size:11px;" ><b>Remarks:  &nbsp;</b>'.$remarks_main.' </p></td></tr><tr><td width="100%"><p class="adds-titl" style="line-height:1.6;font-size:11px;" ><b>Description:   &nbsp;</b> '.$description.' </p></td></tr><tr><td width="50%"><p class="adds-titl" style="line-height:1.6;font-size:11px;" ><b>CHECKED BY:  &nbsp;</b>'.$checked_by.' </p></td><td width="50%"><p class="adds-titl" style="line-height:1.6;font-size:11px;" ><b>TEST DATE:  &nbsp;</b>'.date("d-m-Y", strtotime($test_date)).' </p></td></tr></table>';



$htmlData   .=  '</body></html>';

$pdf->writeHTML($htmlData, true, false, true, false, '');
$pdf->lastPage();
if ($pdf->GetY() < PDF_MARGIN_BOTTOM) {
    $pdf->deletePage($pdf->getPage());
}
$pdf_file_name = "<?=$customer_name;?><?=$ID;?>.pdf";

$pdf->Output($pdf_file_name, 'I');