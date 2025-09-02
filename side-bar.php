<?
$Pagename=basename($_SERVER['PHP_SELF']); 
?>
<div class="sidebar-wrapper" data-simplebar="true">
<div class="sidebar-header">
<div style="width: 100%;text-align: center;">
<a href="home.php" class="logo-title">	<img src="assets/images/Our/logo.png" class="logo-icon width-100 pad-10" alt="logo icon" style="width: 100px !important;margin: 0px auto;display: block;" ></a>
</div>

<div class="toggle-icon ms-auto"><i class='bx bx-arrow-to-left'></i>
</div>
</div>

<ul class="metismenu" id="menu">
<?if($_SESSION['USERTYPE']==0){?>
<li class="<? if($Pagename=='home.php') { ?>mm-active<? } ?>">
<a href="home.php">
<div class="parent-icon"><i class='bx bx-home-circle'></i>
</div>
<div class="menu-title">Dashboard</div>
</a>
</li>

<li>
<a href="javascript:;" class="has-arrow" aria-expanded="false">
<div class="parent-icon"><i class="bx bx-repeat"></i>
</div>
<div class="menu-title">Manage Master</div>
</a>
<ul>
<li class="<? if($Pagename=='manage-product.php' || $Pagename=='add-products.php') { ?>mm-active<? } ?>"> <a href="manage-product.php"><i class="bx bx-right-arrow-alt"></i>Manage Product</a>
</li>
<li class="<? if($Pagename=='manage-customer.php') { ?>mm-active<? } ?>"> <a href="manage-customer.php"><i class="bx bx-right-arrow-alt"></i>Manage Customer</a></li>
<li class="<? if($Pagename=='manage-brand.php') { ?>mm-active<? } ?>"> <a href="manage-brand.php"><i class="bx bx-right-arrow-alt"></i>Manage Brand</a></li>
</ul>
</li>
<?}?>

<li>
<a href="javascript:;" class="has-arrow" aria-expanded="false">
<div class="parent-icon"><i class="bx bx-customize"></i>
</div>
<div class="menu-title">Manage Quotation</div>
</a>
<ul>
<li class="<? if($Pagename=='add-quotation.php' || $Pagename=='preview-quotation.php') { ?>mm-active<? } ?>"> <a href="add-quotation.php"><i class="bx bx-right-arrow-alt"></i>Add Quotation</a>
</li>
<li class="<? if($Pagename=='list-quotation.php' || $Pagename=='view-quotation.php'  || $Pagename=='view-price-log.php') { ?>mm-active<? } ?>"> <a href="list-quotation.php"><i class="bx bx-right-arrow-alt"></i>List Quotation</a>
</li>

</ul>
</li>



 <li class="<? if($Pagename=='add-sales.php' || $Pagename=='list-sales.php' || $Pagename=='view-sales.php' || $Pagename=='preview-sales.php' || $Pagename=='preview-acknowledgment.php') { ?>mm-active<? } ?>">
<a href="list-sales.php">
<div class="parent-icon"><i class="lni lni-revenue"></i>
</div>
<div class="menu-title">Manage Sales</div>
</a>
</li> 


<li class="<? if($Pagename=='add-dispatch.php' || $Pagename=='list-dispatch.php' || $Pagename=='view-dispatch.php' || $Pagename=='edit-dispatch.php' ) { ?>mm-active<? } ?>">
<a href="list-dispatch.php">
<div class="parent-icon"><i class="lni lni-delivery"></i>
</div>
<div class="menu-title">Manage Dispatch</div>
</a>
</li>

<li>
<a href="javascript:;" class="has-arrow" aria-expanded="false">
<div class="parent-icon"><i class="lni lni-certificate"></i>
</div>
<div class="menu-title">Delivery Challan</div>
</a>
<ul>
<li class="<? if($Pagename=='add-delivery-challan.php') { ?>mm-active<? } ?>"> <a href="add-delivery-challan.php"><i class="bx bx-right-arrow-alt"></i>Add Returnable Delivery Challan</a>
</li>
<li class="<? if($Pagename=='add-delivery-challan-2.php') { ?>mm-active<? } ?>"> <a href="add-delivery-challan-2.php"><i class="bx bx-right-arrow-alt"></i>Add Non-Returnable Delivery Challan</a>
</li>
<li class="<? if($Pagename=='list-delivery-challan.php' || $Pagename=='view-delivery-challan.php'  || $Pagename=='delivery-inward.php') { ?>mm-active<? } ?>"> <a href="list-delivery-challan.php"><i class="bx bx-right-arrow-alt"></i>List Returnable Delivery Challan</a>
</li>
<li class="<? if($Pagename=='list-delivery-challan-2.php' || $Pagename=='view-delivery-challan-2.php') { ?>mm-active<? } ?>"> <a href="list-delivery-challan-2.php"><i class="bx bx-right-arrow-alt"></i>List Non-Returnable Delivery Challan</a>
</li>


</ul>
</li>



<li class="<? if($Pagename=='add-test-reports.php' || $Pagename=='list-test-reports.php' || $Pagename=='view-test-reports.php') { ?>mm-active<? } ?>">
<a href="list-test-reports.php">
<div class="parent-icon"><i class="lni lni-layout"></i>
</div>
<div class="menu-title">Manage Test Reports</div>
</a>
</li>


<!-- <li>
<a href="javascript:;" class="has-arrow" aria-expanded="false">
<div class="parent-icon"><i class="lni lni-layout"></i>
</div>
<div class="menu-title">Manage Test Reports</div>
</a>
<ul>
<li class="<? if($Pagename=='add-test-reports.php') { ?>mm-active<? } ?>"> <a href="add-test-reports.php"><i class="bx bx-right-arrow-alt"></i>Add Test Reports</a>
</li>
<li class="<? if($Pagename=='list-test-reports.php' || $Pagename=='view-test-reports.php') { ?>mm-active<? } ?>"> <a href="view-test-reports.php"><i class="bx bx-right-arrow-alt"></i>List Test Reports</a>

</li>
</ul>
</li> -->

<li>
<a href="javascript:;" class="has-arrow" aria-expanded="false">
<div class="parent-icon"><i class="bx bxs-wrench"></i>
</div>
<div class="menu-title">Manage Services</div>
</a>
<ul>
<li class="<? if($Pagename=='add-services.php') { ?>mm-active<? } ?>"> <a href="add-services.php"><i class="bx bx-right-arrow-alt"></i>Add Services</a>
</li>
<li class="<? if($Pagename=='list-services.php' || $Pagename=='view-services.php' || $Pagename=='add-delivery.php') { ?>mm-active<? } ?>"> <a href="list-services.php"><i class="bx bx-right-arrow-alt"></i>List Services</a>

</li>
</ul>
</li>


<?if($_SESSION['USERTYPE']==0){?>
<li>
<a href="javascript:;" class="has-arrow" aria-expanded="false">
<div class="parent-icon"><i class="lni lni-graph"></i>
</div>
<div class="menu-title">Reports</div>
</a>
<ul>
<li class="<? if($Pagename=='quotation-report.php') { ?>mm-active<? } ?>"> <a href="quotation-report.php"><i class="bx bx-right-arrow-alt"></i>Quotation Report</a>
</li>
<li class="<? if($Pagename=='sales-report.php') { ?>mm-active<? } ?>"> <a href="sales-report.php"><i class="bx bx-right-arrow-alt"></i>Sales Report</a>
</li>
<li class="<? if($Pagename=='dispatch-report.php') { ?>mm-active<? } ?>"> <a href="dispatch-report.php"><i class="bx bx-right-arrow-alt"></i>Dispatch Report</a>
</li>
<li class="<? if($Pagename=='services-report.php') { ?>mm-active<? } ?>"> <a href="services-report.php"><i class="bx bx-right-arrow-alt"></i>Service Report</a>
</li>
<li class="<? if($Pagename=='customer-wise-report.php') { ?>mm-active<? } ?>"> <a href="customer-wise-report.php"><i class="bx bx-right-arrow-alt"></i>Customer-wise Report</a>
</li>
<li class="<? if($Pagename=='brand-wise-report.php') { ?>mm-active<? } ?>"> <a href="brand-wise-report.php"><i class="bx bx-right-arrow-alt"></i>Brand-wise Report</a>
</li>

<li class="<? if($Pagename=='itemwise-quotation.php') { ?>mm-active<? } ?>"> <a href="itemwise-quotation.php"><i class="bx bx-right-arrow-alt"></i>Itemwise Quotation Report</a>
</li>

<li class="<? if($Pagename=='itemwise-sales.php') { ?>mm-active<? } ?>"> <a href="itemwise-sales.php"><i class="bx bx-right-arrow-alt"></i>Itemwise Sales Report</a>
</li>

<li class="<? if($Pagename=='delivery-challan-report.php') { ?>mm-active<? } ?>"> <a href="delivery-challan-report.php"><i class="bx bx-right-arrow-alt"></i>Delivery Challan Report</a>
</li>

<li class="<? if($Pagename=='customer-drawing-password.php' || $Pagename=='customer-drawing-report.php' || $Pagename=='view-drawing.php') { ?>mm-active<? } ?>"> <a href="customer-drawing-password.php"><i class="bx bx-right-arrow-alt"></i>Customer Drawing Report</a>
</li>

</ul>
</li>

<li>
<a href="change-password.php">
<div class="parent-icon"><i class="lni lni-keyword-research"></i>
</div>
<div class="menu-title">Change Password</div>
</a>
</li>
<?}?>
<li>
<a href="logout.php">
<div class="parent-icon"><i class="fadeIn animated bx bx-log-out"></i>
</div>
<div class="menu-title">Logout</div>
</a>
</li>
</ul>
</div>