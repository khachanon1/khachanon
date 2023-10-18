<?php
session_start() ;
include("connect.php") ; // ติดต่อฐานข้อมูล
// $conn = new mysqli('localhost','root','','php_students');
// $conn->query("set names utf8") ;

// ถ้ามีการส่งค่ามาให้ตรวจสอบในฐานข้อมูล
if(!empty($_POST['txt_login']) && !empty($_POST['txt_password'])) 
{
  
  $password = sha1($_POST['txt_password']) ; // แปลงรหัสผ่านด้วย sha1  เพราะในฐานข้อมูลเก็บแบบเข้ารหัสด้วย sha1 เหมือนกัน
  $login = $conn->escape_string($_POST['txt_login']) ;  // clear ข้อมูลป้องกัน sql injection กับ XSS

  // query login ในฐานข้อมูล ถ้าตรงกันแสดงว่ามี user ในระบบ
  $rs = $conn->query("select * from users where login='$login' and password='$password' limit 1") ;
  if($login == $rs->fetch_array()['login']) // ถ้าตรงกันแสดงว่ามีสิทธิ์เข้าใช้งาน
  {
    $_SESSION['logStatus'] = 1;  // เก็บสถานะว่ามีการ login แล้ว
    header("location:index.php") ; // เปิดหน้า index.php
  }
  else {
    echo "รหัสผ่านไม่ถูกต้อง <a href='login.php'>ย้อนกลับ</a>" ; // กรณีที่กรอก login กับ password ไม่ถูก
  }
}
else {
  echo "ข้อมูลไม่ครบ <a href='login.php'>ย้อนกลับ</a>" ; // ถ้าส่งมาไม่ครบให้แจ้งเตือน
}
?>
