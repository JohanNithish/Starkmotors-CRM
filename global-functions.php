<?php
//function for pwd encryption & decryption starts
function encrypt_decrypt($action, $string) {
    $output = false;
    $encrypt_method = "AES-256-CBC";
    $secret_key = 'AllisWEll-MIST';
    $secret_iv = 'AllisWEll-MIST';
    // hash
    $key = hash('sha256', $secret_key);
    
    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
    $iv = substr(hash('sha256', $secret_iv), 0, 16);
    if ( $action == 'encrypt' ) {
        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
    } else if( $action == 'decrypt' ) {
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }
    return $output;
}
//function for pwd encryption & decryption ends

//function for removing tags and slashes starts
function remove_slash_other_tags($text) {
	$stripslashes_result=stripslashes($text);
	$final_result=strip_tags($stripslashes_result,"<p><a><i><span><b><strong><li><ul><h1><h2><h3><h4><h5><h6><address><area><blockquote><body><br><center><button><caption><em><embed><fieldset><figure><font><footer><form><frame><frameset><head><header><hr><html><iframe><img><label><link><map><ol><optgroup><option><pre><select><small><source><style><sub><sup><table><tbody><th><tr><td><thead><tfoot><col><textarea><u><video><wbr><canvas><figcaption><audio><track><nav><meta><head><base><script>");
	//$final_result = preg_replace('/<[\/]*div[^>]*>/i', '', $stripslashes_result);
		return( $final_result );
}
//function for removing tags and slashes ends

//function for converting number (0-26) to alphabet (A-Z) starts
function number_to_charc($str)
{
$alpha = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X ', 'Y', 'Z');
$newName = '';
do {
    $str--;
    $limit = floor($str / 26);
    $reminder = $str % 26;
    $newName = $alpha[$reminder].$newName;
    $str=$limit;
} while ($str >0);
return $newName;
}
//function for converting number (0-26) to alphabet (A-Z) ends

//function for quotation id generation starts
function generate_quotation_id($Lead_ID, $Project_ID)
{
	//for getting max quote id starts
	$rows_MaxQID = mysql_fetch_object(mysql_query("SHOW TABLE STATUS WHERE `Name` = 'quotation'"));
	if($rows_MaxQID->Auto_increment > 0)
	{
		$max_quotation_id = $rows_MaxQID->Auto_increment;
	}
	else
	{
		$max_quotation_id ='0000';
	}
	//condition for leads quotation exists or not
	if($Lead_ID >0 )
	{
		$ChkQuoteSubQry = "where company_id='$Lead_ID'";
	}
	/*//condition for leads with projects quotation exists or not
	if($Lead_ID >0 && $Project_ID >0)
	{
		$ChkQuoteSubQry = "where company_id='$Lead_ID' and project_id='$Project_ID'";
	}*/
	
	//for checking already quote sent or not
	$check_quotation_exists = mysql_query("select * from quotation $ChkQuoteSubQry order by id desc");
	$already_sent_quotation_count = mysql_num_rows($check_quotation_exists);
	$already_sent_quotation_details = mysql_fetch_object($check_quotation_exists);
	//for getting current month in three letter format with uppercase
	$Current_Month = strtoupper(date('M'));
	//for getting date and changing 0 to alphabet 'K'
	$Current_Year = str_replace('0', 'K', date('Y'));
	
	if($already_sent_quotation_count >0)
	{
		$already_sent_quotation_id = $already_sent_quotation_details->id;
		$Quote_Repeat_Alphabet = number_to_charc($already_sent_quotation_count);
		$Quotation_ID = $Current_Month.'0'.$already_sent_quotation_id.$Current_Year.'/'.$Quote_Repeat_Alphabet;
	}
	else
	{
		$Quotation_ID = $Current_Month.'0'.$max_quotation_id.$Current_Year;
	}

	return $Quotation_ID;
}
//function for quotation id generation ends


//function for invoice id generation starts
function generate_invoice_id($Agency_ID, $ID_TYPE, $Invoice_Type, $invoice_date)
{
	$Current_Month = date('m',strtotime($invoice_date));
	
	if($Current_Month >3)
	{
		$Current_Year = date('Y',strtotime($invoice_date));
		$Next_Year = date('Y', strtotime($invoice_date.' +1 year'));
	}
	else
	{
		$Current_Year = date('Y',strtotime($invoice_date.' -1 year'));
		$Next_Year = date('Y', strtotime($invoice_date));
	}
	
	$year_month_from_date = date('Y-m',strtotime($invoice_date)).'-01';
	$year_month_to_date = date('Y-m-t',strtotime($invoice_date));
	
	$invoice_year_month_subquery = "and invoice_date between '$year_month_from_date' and '$year_month_to_date'";
	
	/*//for getting agency code starts
	$Get_Agency=mysql_query("select * from agency where id = '$Agency_ID' and status='1' order by id desc");
	$Agency_Details=mysql_fetch_object($Get_Agency);
	$Agency_Code=$Agency_Details->agency_short_code;
	//for getting agency code ends*/
	
	//for getting max quote id starts
	$rows_MaxIID = mysql_fetch_object(mysql_query("select max(max_invoice_id) as max_invoice_id from orders where 1=1 $invoice_year_month_subquery"));
	if($rows_MaxIID->max_invoice_id > 0)
	{
		$max_invoice_id = $rows_MaxIID->max_invoice_id;
		$max_invoice_id = $max_invoice_id + 1;
	}
	else
	{
		$max_invoice_id ='0';
		$max_invoice_id = $max_invoice_id + 1;
	}
	if($ID_TYPE == 'Inovoice_ID')
	{
		if($max_invoice_id < 1000 ) { $Max_Invoice_ID = str_pad($max_invoice_id,'6','0',STR_PAD_LEFT); } else {$Max_Invoice_ID = $max_invoice_id;}
		$Invoice_ID = $Max_Invoice_ID.strtoupper(date('M',strtotime($invoice_date))).'/'.$Current_Year.'-'.$Next_Year;
		if($Invoice_Type == '0')
		{
			$Invoice_ID = 'PF'.$Invoice_ID;
		}
	}
	
	if($ID_TYPE == 'Inovoice_ID')
	{
		return $Invoice_ID;
	}
	if($ID_TYPE == 'Max_Invoice_ID')
	{
		return $max_invoice_id;
	}
}
//function for invoice id generation ends

//function for removing spaces and special characters starts
function clean($string)
{
	$string_without_space = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
   
	$string_without_special_chars = preg_replace('/[^A-Za-z0-9\-]/', '', $string_without_space); // Removes special chars.
   
	$string_as_all_lowercase = strtolower($string_without_special_chars);

	return preg_replace('/[^A-Za-z0-9\-]/', '', $string_as_all_lowercase); // Removes special chars.
}
//function for removing spaces and special characters ends

//function for generating invoice file name starts
function generate_invoice_filename($Invoice_ID, $Company_ID, $Invoice_Type)
{
	$Invoice_ID = str_replace('/', '',$Invoice_ID);
	$Invoice_ID = str_replace('-', '',$Invoice_ID);
	
	$Current_Date = date('d-m-Y-his',time());
	//for displaying company name starts
	$Get_Company_Name=mysql_query("select * from company where id='$Company_ID'");
	$Fetch_Company_Name=mysql_fetch_object($Get_Company_Name);
	$Company_Name_Value=$Fetch_Company_Name->company_name;
	$Company_Name_Value=clean(str_replace(' ', '', $Company_Name_Value));
	//for displaying company name ends
	$Invoice_FileName = $Invoice_ID.'-'.$Invoice_Type.'-invoice-for-'.$Company_Name_Value.'-'.$Current_Date.'.pdf';
	
	return $Invoice_FileName;
}
//function for generating invoice file name ends

function generate_quotation_filename($Quotation_ID, $Company_ID, $IQuotation_Type)
{
	$Quotation_ID = str_replace('/', '',$Quotation_ID);
	$Quotation_ID = str_replace('-', '',$Quotation_ID);
	
	$Current_Date = date('d-m-Y-his',time());
	//for displaying company name starts
	$Get_Company_Name=mysql_query("select * from company where id='$Company_ID'");
	$Fetch_Company_Name=mysql_fetch_object($Get_Company_Name);
	$Company_Name_Value=$Fetch_Company_Name->company_name;
	$Company_Name_Value=clean(str_replace(' ', '', $Company_Name_Value));
	//for displaying company name ends
	$Quotation_FileName = $Quotation_ID.'-Quotation-for-'.$Company_Name_Value.'-'.$Current_Date.'.pdf';
	
	return $Quotation_FileName;
}

//function for converting numbers into words starts
function getIndianCurrency($number)
{
    $decimal = round($number - ($no = floor($number)), 2) * 100;
    $hundred = null;
    $digits_length = strlen($no);
    $i = 0;
    $str = array();
    $words = array(0 => '', 1 => 'One', 2 => 'Two',
        3 => 'Three', 4 => 'Four', 5 => 'Five', 6 => 'Six',
        7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
        10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve',
        13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen',
        16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen',
        19 => 'Nineteen', 20 => 'Twenty', 30 => 'Thirty',
        40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty',
        70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety');
    $digits = array('', 'Hundred', 'Thousand', 'Lakh', 'Crore');

    while( $i < $digits_length ) {
        $divider = ($i == 2) ? 10 : 100;
        $number = floor($no % $divider);
        $no = floor($no / $divider);
        $i += $divider == 10 ? 1 : 2;
        if ($number) {
            $plural = (($counter = count($str)) && $number > 9) ? '' : null;
            $hundred = ($counter == 1 && $str[0]) ? 'and ' : null;
            $str [] = ($number < 21) ? $words[$number].' '. $digits[$counter]. $plural.' '.$hundred:$words[floor($number / 10) * 10].' '.$words[$number % 10]. ' '.$digits[$counter].$plural.' '.$hundred;
        } else $str[] = null;
    }
    $Rupees = implode('', array_reverse($str));
    $paise = ($decimal) ? ". " . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . ' Paise' : '';
    return ($Rupees ? $Rupees . 'Rupees' : '') . $paise;
}
//function for quotation id generation ends

//function for sending sms starts
function sms($user_mobile_number, $sms_text){	
$enquiry = $sms_text;
$mobileno = $user_mobile_number;
$enquiry_msg=urlencode($enquiry);
/*$sms_api = "http://india.vtel.in/api/v3/index.php?method=sms&api_key=A0f22597fdf559eaf9642e9339ed99ec4&to=".$mobileno."&sender=WEBCBE&message=".$enquiry_msg.
"&format=php";*/
$murl=$sms_api; 
$ch = curl_init(); 
curl_setopt($ch, CURLOPT_URL, $murl); 
curl_setopt($ch, CURLOPT_HEADER, 1);  
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1); 
$response = curl_exec($ch); 
$rsep_idcomp = explode('charset=UTF-8',$response);
curl_close($ch);
$enquiry = str_replace("+", " ", $enquiry);
$rsep_id = $rsep_idcomp[1].",".$rsep_idusr[1];
return true;
}
//function for sending sms ends

function convert_sec_to_mhdy($seconds)
{
/**
* Convert number of seconds into years, days, hours, minutes and seconds
* and return an string containing those values
*
* @param integer $seconds Number of seconds to parse
* @return string
*/

$y = floor($seconds / (86400*365.25));
$d = floor(($seconds - ($y*(86400*365.25))) / 86400);
$h = gmdate('H', $seconds);
$m = gmdate('i', $seconds);
$s = gmdate('s', $seconds);

$string = '';

if($y > 0)
{
$yw = $y > 1 ? ' years ' : ' year ';
$string .= $y . $yw;
}

if($d > 0)
{
$dw = $d > 1 ? ' days ' : ' day ';
$string .= $d . $dw;
}

if($h > 0)
{
$hw = $h > 1 ? ' hours ' : ' hour ';
$string .= $h . $hw;
}

if($m > 0)
{
$mw = $m > 1 ? ' minutes ' : ' minute ';
$string .= $m . $mw;
}

if($s > 0)
{
$sw = $s > 1 ? ' seconds ' : ' second ';
$string .= $s . $sw;
}

return preg_replace('/\s+/',' ',$string);
}


function convert_sec_to_hours($seconds)
{

$hours = floor($seconds / 3600);
$minutes = floor(($seconds / 60) % 60);
//$seconds = $seconds % 60;
$converted_hour_minutes="$hours hrs : $minutes min";
return $converted_hour_minutes;

}

function image_resize($filepath, $max_width, $max_height, $resize_type, $sharpen, $save_folder_name)
{
	require_once('./image-resizer/php_image_magician.php');
	
	$ext1 = strtolower(substr(strrchr($filepath, "."), 1));
	if($ext1=='jpg') $ext1 = 'jpeg';
	$t = 'imagecreatefrom'.$ext1;
	$t = str_replace('.','',$t);
	$img = $t($filepath);
	
	$orig_width = imagesx( $img );
	$orig_height = imagesy( $img );
	$width = $orig_width;
	$height = $orig_height;
	
	# taller
	if ($height > $max_height) {
	$width = ($max_height / $height) * $width;
	$height = $max_height;
	}
	
	# wider
	if ($width > $max_width) {
	$height = ($max_width / $width) * $height;
	$width = $max_width;
	}
	
	$magicianObj = new imageLib($filepath);
	
	if($resize_type == 'resize')
	{
		$magicianObj->resizeImage($width, $height, 'auto', $sharpen);
	}
	
	if($resize_type == 'resize-crop')
	{
		$magicianObj->resizeImage($width, $height, array('crop', 'tr'), $sharpen);
	}
	
	if($resize_type == 'crop')
	{
		$magicianObj->cropImage($width, $height, 'mc');
	}
	
	$magicianObj->saveImage($save_folder_name, 80);
}

?>