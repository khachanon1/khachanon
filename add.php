<?php
include('check.php') ;  // ตรวจสอบว่า login หรือไม่
include("connect.php") ;
include("lib/fnc.php") ;

//======== จะต้อง clear ข้อมูลที่ส่งมาก่อน 
$std_code = secureStr($_POST['txt_code']) ;
$std_name = secureStr($_POST['txt_name']) ;
$std_gpa = secureStr($_POST['txt_gpa']) ;
$std_major = secureStr($_POST['input_major']) ;

$std_pic = '' ;
// ถ้ามีการกรอกข้อมูล
if($std_code !='' && $std_name !='' && $std_gpa !='')
{
  // ถ้ามีการอัปโหลดไฟล์
  if (is_uploaded_file($_FILES['input_pic']['tmp_name'])) {
    //หานามสกุลไฟล์ที่ upload เพื่อเช็คว่าไฟล์อนุญาตให้อัปโหลดมั้ย
    $tmp = explode('.',$_FILES['input_pic']['name']) ;
    $file_ex = end($tmp) ;
    //ถ้าเป็นไฟล์ภาพที่กำหนด
    if(in_array($file_ex, array('jpg','jpeg','png'))){
      $std_pic = $std_code.'.'.$file_ex ;  // ตัวอย่างเช่น 650112112345.jpg
      // move ไฟล์จาก tmp มาไว้ที่ data/
      if(move_uploaded_file($_FILES['input_pic']['tmp_name'],'data/'.$std_pic)){
        // สร้างภาพขนาด 50x50
        resizeThumbnailImage('data/'.$std_pic,'data/sm_'.$std_pic,50,50) ;
      }
    }
  }
  // เพิ่มข้อมูลใน table student
  $sql = "insert into student set std_code='$std_code', std_name='$std_name' ,std_gpa='$std_gpa' ,std_pic='$std_pic' ,std_major='$std_major' " ;
  $rs = $conn->query($sql) ;
  // ถ้าเพิ่มข้อมูลเรียบร้อย
  if($rs){
    // header("Location:index.php") ;  // ไปหน้า index ทันที
    header("refresh:1;url=index.php") ;  // ไปหน้า index ใน 3 วินาที
    echo "เพิ่มข้อมูลเรียบร้อย" ;
    exit ;
  }
  else {
    // ถ้า rs เป็น false แสดงว่าเพิ่มข้อมูลไม่ได้ 
    header("refresh:3;url=index.php") ;  // ไปหน้า index ใน 5 วินาที
    echo "เพิ่มข้อมูลไม่สำเร็จ" ;
    exit ;
  }
}
else {
  header("refresh:2;url=index.php") ;  // ไปหน้า index ใน 3 วินาที
  echo "ข้อมูลไม่ครบ" ;
  exit ;// code...
}


?>
