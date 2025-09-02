<?php
if(isset($_POST["image"]))
{
	$data = $_POST["image"];
	$idimg = $_POST["ID"];
	$image_array_1 = explode(";", $data);

	$image_array_2 = explode(",", $image_array_1[1]);

	$data = base64_decode($image_array_2[1]);

	$imageName = time() . '.jpg';

	file_put_contents('uploads/product-images/'.$imageName, $data);

	echo '<img src="uploads/product-images/'.$imageName.'" class="img-thumbnail" width="80px"/>';

}

?>
<script>
$('#profile_images<?=$idimg; ?>').val('product-images/<?=$imageName; ?>');
</script>