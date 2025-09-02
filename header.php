<header>
<div class="topbar d-flex align-items-center">
<nav class="navbar navbar-expand">
<div class="mobile-toggle-menu"><i class='bx bx-menu'></i>
</div>
<? 
if($Pagename == 'view-task.php'){ 
$UserMobileIds = $_GET['id'];
$select_usermobile=mysqli_query($conn,"select * from  registration where phone_number = '$UserMobileIds' ");
$row_usermobile=mysqli_fetch_array($select_usermobile)
?>
<div class="txt-cent" id="submit" name="smt"  style=" margin-left: 10px;" ><a href="task-user.php" class="btn btn-danger" style="margin-top: 10px;">Back</a>
</div>
<p class="text-task"><?=$row_usermobile['name']; ?> <span class="md-none"> - <?=$row_usermobile['phone_number']; ?></span> - <?=$row_usermobile['team']; ?></p>
<? } ?>

<div class="top-menu ms-auto">
<ul class="navbar-nav align-items-center">
<li class="nav-item dropdown dropdown-large">
<div class="dropdown-menu dropdown-menu-end">
<div class="header-notifications-list">
</div>
</div>
</li>
<li class="nav-item dropdown dropdown-large">
<div class="dropdown-menu dropdown-menu-end">
<div class="header-message-list">
</div>
</div>
</li>
</ul>
</div>

<?if($Pagename!='view-sales.php' && $Pagename!='view-quotation.php'  && $Pagename!='view-dispatch.php' && $Pagename!='view-services.php'){?>
<div class="user-box dropdown">
<a class="d-flex align-items-center nav-link dropdown-toggle dropdown-toggle-nocaret" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
<!-- <img src="assets/images/avatars/avatar-2.png" class="user-img" alt="user avatar"> -->
<div class="user-info ps-3">

<p class="user-name mb-0"><?=$_SESSION['SNAME'];?></p>

<!-- <p class="designattion mb-0">Web Designer</p> -->
</div>
</a>
<ul class="dropdown-menu dropdown-menu-end">
<!-- <li><a class="dropdown-item" href="home.php"><i class='bx bx-home-circle'></i><span>Dashboard</span></a>
</li> -->

<li><a class="dropdown-item" href="logout.php"><i class='bx bx-log-out-circle'></i><span>Logout</span></a>
</li>
</ul>
</div>
<?}else{?>
	<a href="<?=$_SERVER["HTTP_REFERER"];?>" class="btn btn-danger">Back</a>
<?}?>
</nav>
</div>
</header>