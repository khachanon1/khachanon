<?php
session_start() ;
// ถ้ายังไม่ login ให้ไปที่หน้า login.php
if($_SESSION['logStatus'] != 1)
{
    header("refresh:1;url=login.php") ;  // 
    exit ;
}

?>