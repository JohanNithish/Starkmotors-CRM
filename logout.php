<?php

session_start();
if ($_SESSION['USERTYPE'] == 0) {
setcookie('CName',$_SESSION['SNAME'],60);
setcookie('UID',$_SESSION['UID'],60);
setcookie('USERTYPE',$_SESSION['USERTYPE'],60);
setcookie('USERNAME',$_SESSION['USERNAME'],60);
// unset($_COOKIE['USER_ID']);
unset($_SESSION['UID']);
unset($_SESSION['SNAME']);
unset($_SESSION['USERTYPE']);
unset($_SESSION['USERNAME']);
header('Location:index.php');
}
if ($_SESSION['USERTYPE'] == 1 || $_SESSION['USERTYPE'] == 2) {
session_start();
setcookie('CName',$_SESSION['SNAME'],60);
setcookie('UID',$_SESSION['UID'],60);
setcookie('USERTYPE',$_SESSION['USERTYPE'],60);
setcookie('USERNAME',$_SESSION['USERNAME'],60);
// unset($_COOKIE['USER_ID']);
unset($_SESSION['UID']);
unset($_SESSION['SNAME']);
unset($_SESSION['USERTYPE']);
unset($_SESSION['USERNAME']);
header('Location:index.php');	
}
?>