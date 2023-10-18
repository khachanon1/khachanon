<?php
include('check.php') ;  // ตรวจสอบว่า login หรือไม่
include("connect.php") ;
include('lib/fnc.php') ;
$id = secureStr($_GET['id']) ;
if($id !=''){
  //หาชื่อรูปภาพที่ต้องการลบ
  $sql0 = "select std_pic from student where id ='$id' limit 1" ;
  $rs0 = $conn->query($sql0) ;
  $row0 = $rs0->fetch_array() ;
  $std_pic = $row0['std_pic'] ;
  // เช็คไฟล์ ถ้ามีให้ลบออก
  if(file_exists('data/'.$std_pic) && $std_pic !='')
  {
    unlink('data/'.$std_pic) ; // ลบภาพต้นฉบับ
    unlink('data/sm_'.$std_pic) ; // ลบภาพย่อ
  }
  $sql = "delete from student where id ='$id' limit 1" ;
  $rs = $conn->query($sql) ;
  if($rs){
    // header("Location:index.php") ;  // ไปหน้า index ทันที
    header("refresh:1;url=index.php") ;  // ไปหน้า index ใน 3 วินาที
    echo "ลบข้อมูลเรียบร้อย" ;
    exit ;
  }
  else {
    header("refresh:2;url=index.php") ;  // ไปหน้า index ใน 5 วินาที
    echo "ลบข้อมูลไม่สำเร็จ" ;
    exit ;
  }
} else{
  header("refresh:1;url=index.php") ;  // ไปหน้า index ใน 3 วินาที
  echo "ข้อมูลไม่ครบ" ;
  exit ;// code...
}

?>
