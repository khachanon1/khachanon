<?php
session_start() ;
$_SESSION['logStatus'] = '' ;  // ล้างข้อมูล
header("refresh:1;url=login.php") ;  // 
exit ;
?>