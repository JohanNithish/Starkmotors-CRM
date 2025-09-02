<?php
/*
//add picture 1
$filename1 = $_FILES['file1']['name'];
$filesize1 = $_FILES['file1']['size'];
if($filename1 != '')
	{
$image_info1 = getimagesize($_FILES["file1"]["tmp_name"]);
$image_width1 = $image_info1[0];
$image_height1 = $image_info1[1];

$ext1 = strtolower(substr(strrchr($filename1, "."), 1));
	$image_size1 = ($filesize1 / 1024);
	
		if($ext1 == 'jpg' or $ext1 == 'jpeg' or $ext1 == 'gif' or $ext1 == 'png')
		{
			$path1 = time().'_'.str_replace(" ","_",$filename1);
			$image_path1 = "uploads/product-images/".$path1;
			$up_path1 = "product-images/".$path1;
			copy($_FILES['file1']['tmp_name'],$image_path1);
			chmod($image_path1,0777);
			
			$img_subqry = ", image1 = '$up_path1'";
			
	// some settings
	$max_upload_width = 360;
	$max_upload_height = 360;
	
	$fld_name = 'file1';
	
// if uploaded image was JPG/JPEG
	if($_FILES[$fld_name]["type"] == "image/jpeg" || $_FILES[$fld_name]["type"] == "image/pjpeg"){	
		$image_source = imagecreatefromjpeg($_FILES[$fld_name]["tmp_name"]);
	}		
	// if uploaded image was GIF
	if($_FILES[$fld_name]["type"] == "image/gif"){	
		$image_source = imagecreatefromgif($_FILES[$fld_name]["tmp_name"]);
	}	
	// BMP doesn't seem to be supported so remove it form above image type test (reject bmps)	
	// if uploaded image was BMP
	if($_FILES[$fld_name]["type"] == "image/bmp"){	
		$image_source = imagecreatefromwbmp($_FILES[$fld_name]["tmp_name"]);
	}			
	// if uploaded image was PNG
	if($_FILES[$fld_name]["type"] == "image/x-png"){
		$image_source = imagecreatefrompng($_FILES[$fld_name]["tmp_name"]);
	}
	

	$tmb_remote_file = "uploads/product-images/".time().'_thumb_'.str_replace(" ","_",$_FILES[$fld_name]["name"]);
	$tmb_image_path1 = "product-images/".time().'_thumb_'.str_replace(" ","_",$_FILES[$fld_name]["name"]);
	imagejpeg($image_source,$tmb_remote_file,100);
	chmod($tmb_remote_file,0755);
	$img_subqry .= ", thumb_image1 = '$tmb_image_path1'";



	// get width and height of original image
	list($image_width, $image_height) = getimagesize($tmb_remote_file);
	if($image_width>$max_upload_width || $image_height >$max_upload_height){
		$proportions = $image_width/$image_height;
		if($image_width>$image_height){
			$new_width = $max_upload_width;
			//$new_height = round($max_upload_width/$proportions);
			$new_height = $max_upload_height;
		}		
		else{
			$new_height = $max_upload_height;
			//$new_width = round($max_upload_height*$proportions);
			$new_width = $max_upload_width;
		}		
		
		
		$new_image = imagecreatetruecolor($new_width , $new_height);
		$image_source = imagecreatefromjpeg($tmb_remote_file);
		
		imagecopyresampled($new_image, $image_source, 0, 0, 0, 0, $new_width, $new_height, $image_width, $image_height);
		imagejpeg($new_image,$tmb_remote_file,100);
		
		imagedestroy($new_image);
	}
	
	imagedestroy($image_source);
	
		}
}		
	
	
//add picture 2
$filename2 = $_FILES['file2']['name'];
$filesize2 = $_FILES['file2']['size'];

	if($filename2 != '')
	{
		$image_info2 = getimagesize($_FILES["file2"]["tmp_name"]);
		$image_width2 = $image_info2[0];
		$image_height2 = $image_info2[1];

		$ext2 = strtolower(substr(strrchr($filename2, "."), 1));
		$image_size2 = ($filesize2 / 1024);
		
		if($ext2 == 'jpg' or $ext2 == 'jpeg' or $ext2 == 'gif' or $ext2 == 'png')
		{
			$path2 = time().'_'.str_replace(" ","_",$filename2);
			$image_path2 = "uploads/product-images/".$path2;
			$up_path2 = "product-images/".$path2;
			copy($_FILES['file2']['tmp_name'],$image_path2);
			chmod($image_path2,0777);
			$img_subqry .= ", image2 = '$up_path2'";
		
		
			//thumb image 2
	
	// some settings
	$max_upload_width1 = 360;
	$max_upload_height1 = 360;
	
	$fld_name = 'file2';
	
// if uploaded image was JPG/JPEG
	if($_FILES[$fld_name]["type"] == "image/jpeg" || $_FILES[$fld_name]["type"] == "image/pjpeg"){	
		$image_source1 = imagecreatefromjpeg($_FILES[$fld_name]["tmp_name"]);
	}		
	// if uploaded image was GIF
	if($_FILES[$fld_name]["type"] == "image/gif"){	
		$image_source1 = imagecreatefromgif($_FILES[$fld_name]["tmp_name"]);
	}	
	// BMP doesn't seem to be supported so remove it form above image type test (reject bmps)	
	// if uploaded image was BMP
	if($_FILES[$fld_name]["type"] == "image/bmp"){	
		$image_source1 = imagecreatefromwbmp($_FILES[$fld_name]["tmp_name"]);
	}			
	// if uploaded image was PNG
	if($_FILES[$fld_name]["type"] == "image/x-png"){
		$image_source1 = imagecreatefrompng($_FILES[$fld_name]["tmp_name"]);
	}
	

	$tmb_remote_file1 = "uploads/product-images/".time().'_thumb_2_'.str_replace(" ","_",$_FILES[$fld_name]["name"]);
	$tmb_image_path2 = "product-images/".time().'_thumb_2_'.str_replace(" ","_",$_FILES[$fld_name]["name"]);
	imagejpeg($image_source1,$tmb_remote_file1,100);
	chmod($tmb_remote_file1,0755);
	$img_subqry .= ", thumb_image2 = '$tmb_image_path2'";


	// get width and height of original image
	list($image_width1, $image_height1) = getimagesize($tmb_remote_file1);
	if($image_width1>$max_upload_width1 || $image_height1 >$max_upload_height1){
		$proportions1 = $image_width1/$image_height1;
		if($image_width1>$image_height1){
			$new_width1 = $max_upload_width1;
			//$new_height = round($max_upload_width/$proportions);
			$new_height1 = $max_upload_height1;
		}		
		else{
			$new_height1 = $max_upload_height1;
			//$new_width = round($max_upload_height*$proportions);
			$new_width1 = $max_upload_width1;
		}		
		
		
		$new_image1 = imagecreatetruecolor($new_width1 , $new_height1);
		$image_source1 = imagecreatefromjpeg($tmb_remote_file1);
		
		imagecopyresampled($new_image1, $image_source1, 0, 0, 0, 0, $new_width1, $new_height1, $image_width1, $image_height1);
		imagejpeg($new_image1,$tmb_remote_file1,100);
		
		imagedestroy($new_image1);
	}
	
	imagedestroy($image_source1);
		}
		
		
	}
	
	
	//add picture 3
$filename3 = $_FILES['file3']['name'];
$filesize3 = $_FILES['file3']['size'];

	if($filename3 != '')
	{
		$image_info3 = getimagesize($_FILES["file3"]["tmp_name"]);
		$image_width3 = $image_info3[0];
		$image_height3 = $image_info3[1];

		$ext3 = strtolower(substr(strrchr($filename3, "."), 1));
		$image_size3 = ($filesize3 / 1024);
		
		if($ext3 == 'jpg' or $ext3 == 'jpeg' or $ext3 == 'gif' or $ext3 == 'png')
		{
			$path3 = time().'_'.str_replace(" ","_",$filename3);
			$image_path3 = "uploads/product-images/".$path3;
			$up_path3 = "product-images/".$path3;
			copy($_FILES['file3']['tmp_name'],$image_path3);
			chmod($image_path3,0777);
			$img_subqry .= ", image3 = '$up_path3'";
		
		
		
	//thumb image 3
	
	// some settings
	$max_upload_width3 = 360;
	$max_upload_height3 = 360;
	
	$fld_name = 'file3';
	
// if uploaded image was JPG/JPEG
	if($_FILES[$fld_name]["type"] == "image/jpeg" || $_FILES[$fld_name]["type"] == "image/pjpeg"){	
		$image_source3 = imagecreatefromjpeg($_FILES[$fld_name]["tmp_name"]);
	}		
	// if uploaded image was GIF
	if($_FILES[$fld_name]["type"] == "image/gif"){	
		$image_source3 = imagecreatefromgif($_FILES[$fld_name]["tmp_name"]);
	}	
	// BMP doesn't seem to be supported so remove it form above image type test (reject bmps)	
	// if uploaded image was BMP
	if($_FILES[$fld_name]["type"] == "image/bmp"){	
		$image_source3 = imagecreatefromwbmp($_FILES[$fld_name]["tmp_name"]);
	}			
	// if uploaded image was PNG
	if($_FILES[$fld_name]["type"] == "image/x-png"){
		$image_source3 = imagecreatefrompng($_FILES[$fld_name]["tmp_name"]);
	}
	

	$tmb_remote_file3 = "uploads/product-images/".time().'_thumb_3_'.str_replace(" ","_",$_FILES[$fld_name]["name"]);
	$tmb_image_path3 = "product-images/".time().'_thumb_3_'.str_replace(" ","_",$_FILES[$fld_name]["name"]);
	imagejpeg($image_source3,$tmb_remote_file3,100);
	chmod($tmb_remote_file3,0755);
	$img_subqry .= ", thumb_image3 = '$tmb_image_path3'";


	// get width and height of original image
	list($image_width3, $image_height3) = getimagesize($tmb_remote_file3);
	if($image_width3>$max_upload_width3 || $image_height3 >$max_upload_height3){
		$proportions3 = $image_width3/$image_height3;
		if($image_width3>$image_height3){
			$new_width3 = $max_upload_width3;

			//$new_height = round($max_upload_width/$proportions);
			$new_height3 = $max_upload_height3;
		}		
		else{
			$new_height3 = $max_upload_height3;
			//$new_width = round($max_upload_height*$proportions);
			$new_width3 = $max_upload_width3;
		}		
		
		
		$new_image3 = imagecreatetruecolor($new_width3 , $new_height3);
		$image_source3 = imagecreatefromjpeg($tmb_remote_file3);
		
		imagecopyresampled($new_image3, $image_source3, 0, 0, 0, 0, $new_width3, $new_height3, $image_width3, $image_height3);
		imagejpeg($new_image3,$tmb_remote_file3,100);
		
		imagedestroy($new_image3);
	}
	
	imagedestroy($image_source3);
		}
		
	}
	
	
	
	//add picture 4
$filename4 = $_FILES['file4']['name'];
$filesize4 = $_FILES['file4']['size'];

	if($filename4 != '')
	{
		$image_info4 = getimagesize($_FILES["file4"]["tmp_name"]);
		$image_width4 = $image_info4[0];
		$image_height4 = $image_info4[1];

		$ext4 = strtolower(substr(strrchr($filename4, "."), 1));
		$image_size4 = ($filesize4 / 1024);
		
		if($ext4 == 'jpg' or $ext4 == 'jpeg' or $ext4 == 'gif' or $ext4 == 'png')
		{
			$path4 = time().'_'.str_replace(" ","_",$filename4);
			$image_path4 = "uploads/product-images/".$path4;
			$up_path4 = "product-images/".$path4;
			copy($_FILES['file4']['tmp_name'],$image_path4);
			chmod($image_path4,0777);
			$img_subqry .= ", image4 = '$up_path4'";
		
		
		
	//thumb image 3
	
	// some settings
	$max_upload_width4 = 360;
	$max_upload_height4 = 360;
	
	$fld_name = 'file4';
	
// if uploaded image was JPG/JPEG
	if($_FILES[$fld_name]["type"] == "image/jpeg" || $_FILES[$fld_name]["type"] == "image/pjpeg"){	
		$image_source4 = imagecreatefromjpeg($_FILES[$fld_name]["tmp_name"]);
	}		
	// if uploaded image was GIF
	if($_FILES[$fld_name]["type"] == "image/gif"){	
		$image_source4 = imagecreatefromgif($_FILES[$fld_name]["tmp_name"]);
	}	
	// BMP doesn't seem to be supported so remove it form above image type test (reject bmps)	
	// if uploaded image was BMP
	if($_FILES[$fld_name]["type"] == "image/bmp"){	
		$image_source4 = imagecreatefromwbmp($_FILES[$fld_name]["tmp_name"]);
	}			
	// if uploaded image was PNG
	if($_FILES[$fld_name]["type"] == "image/x-png"){
		$image_source4 = imagecreatefrompng($_FILES[$fld_name]["tmp_name"]);
	}
	

	$tmb_remote_file4 = "uploads/product-images/".time().'_thumb_3_'.str_replace(" ","_",$_FILES[$fld_name]["name"]);
	$tmb_image_path4 = "product-images/".time().'_thumb_3_'.str_replace(" ","_",$_FILES[$fld_name]["name"]);
	imagejpeg($image_source4,$tmb_remote_file4,100);
	chmod($tmb_remote_file4,0755);
	$img_subqry .= ", thumb_image4 = '$tmb_image_path4'";


	// get width and height of original image
	list($image_width4, $image_height4) = getimagesize($tmb_remote_file4);
	if($image_width4>$max_upload_width4 || $image_height4 >$max_upload_height4){
		$proportions4 = $image_width4/$image_height4;
		if($image_width4>$image_height4){
			$new_width4 = $max_upload_width4;
			//$new_height = round($max_upload_width/$proportions);
			$new_height4 = $max_upload_height4;
		}		
		else{
			$new_height4 = $max_upload_height4;
			//$new_width = round($max_upload_height*$proportions);
			$new_width4 = $max_upload_width4;
		}		
		
		
		$new_image4 = imagecreatetruecolor($new_width4 , $new_height4);
		$image_source4 = imagecreatefromjpeg($tmb_remote_file4);
		
		imagecopyresampled($new_image4, $image_source4, 0, 0, 0, 0, $new_width4, $new_height4, $image_width4, $image_height4);
		imagejpeg($new_image4,$tmb_remote_file4,100);
		
		imagedestroy($new_image4);
	}
	
	imagedestroy($image_source4);
		}
}
*/
// $filename5 = $_FILES['file5']['name'];
// $filesize5 = $_FILES['file5']['size'];

//   if($filename5 != '')
//   {
//     $image_info5 = getimagesize($_FILES["file5"]["tmp_name"]);
//     $image_width5 = $image_info5[0];
//     $image_height5 = $image_info5[1];

//     $ext5 = strtolower(substr(strrchr($filename5, "."), 1));
//     $image_size5 = ($filesize5 / 1024);
    
//     if($ext5 == 'pdf')
//     {
//       $path5 = time().'_'.str_replace(" ","_",$filename5);
//       $image_path5 = "uploads/catlogue/".$path5;
//       $up_path5 = "catlogue/".$path5;
//       copy($_FILES['file5']['tmp_name'],$image_path5);
//       chmod($image_path5,0777);
//       $img_subqry .= ", image5 = '$up_path5'";
    
    
    
//   //thumb image 3
  
//   // some settings
//   $max_upload_width5 = 600;
//   $max_upload_height5 = 600;
  
//   $fld_name = 'file5';
  
// // if uploaded image was JPG/JPEG
   
//   // if uploaded image was GIF
//   if($_FILES[$fld_name]["type"] == "image/pdf"){  
//     $image_source5 = imagecreatefromgif($_FILES[$fld_name]["tmp_name"]);
//   } 
 
  

//   $tmb_remote_file5 = "uploads/catlogue/".time().'_thumb_5_'.str_replace(" ","_",$_FILES[$fld_name]["name"]);
//   $tmb_image_path5 = "catlogue/".time().'_thumb_5_'.str_replace(" ","_",$_FILES[$fld_name]["name"]);
//   imagejpeg($image_source5,$tmb_remote_file5,100);
//   chmod($tmb_remote_file5,0755);
//   $img_subqry .= ", thumb_image5 = '$tmb_image_path5'";


//   // get width and height of original image
//   list($image_width5, $image_height5) = getimagesize($tmb_remote_file5);
//   if($image_width5>$max_upload_width5 || $image_height5 >$max_upload_height5){
//     $proportions5 = $image_width5/$image_height5;
//     if($image_width5>$image_height5){
//       $new_width5 = $max_upload_width5;
//       //$new_height = round($max_upload_width/$proportions);
//       $new_height5 = $max_upload_height5;
//     }   
//     else{
//       $new_height5 = $max_upload_height5;
//       //$new_width = round($max_upload_height*$proportions);
//       $new_width5 = $max_upload_width5;
//     }   
    
    
//     $new_image5 = imagecreatetruecolor($new_width5 , $new_height5);
//     $image_source5 = imagecreatefromjpeg($tmb_remote_file5);
    
//     imagecopyresampled($new_image5, $image_source5, 0, 0, 0, 0, $new_width5, $new_height5, $image_width5, $image_height5);
//     imagejpeg($new_image5,$tmb_remote_file5,100);
    
//     imagedestroy($new_image5);
//   }
  
//   imagedestroy($image_source5);
//     }
// }
// add PDF 5
$filename5 = $_FILES['file5']['name'];
$filesize5 = $_FILES['file5']['size'];
 $ext5 = strtolower(substr(strrchr($filename5, "."), 1));
    $image_size5 = ($filesize5 / 1024);

  if($filename5 != '')
  {
     if($ext5 == 'pdf')
{
    $path5 = time().'_'.str_replace(" ","_",$filename5);
      $image_path5 = "uploads/catlogue/".$path5;
      $up_path5 = "catlogue/".$path5;
      copy($_FILES['file5']['tmp_name'],$image_path5);
      chmod($image_path5,0777);
      $img_subqry .= ", image5 = '$up_path5'";
    
    }
}
?>