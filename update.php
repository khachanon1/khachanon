<?php
include('check.php') ;
include("connect.php") ;
include("lib/fnc.php") ;
$std_code = secureStr($_POST['txt_code']) ;
$std_name = secureStr($_POST['txt_name']) ;
$std_gpa = secureStr($_POST['txt_gpa']) ;
$id = secureStr($_POST['id']) ;
$std_major = secureStr($_POST['input_major']) ;

if($std_code !='' && $std_name !='' && $std_gpa !=''){
  $sql = '' ;
  if (is_uploaded_file($_FILES['input_pic']['tmp_name'])) {
    //หานามสกุลไฟล์ที่ upload
    $tmp = explode('.',$_FILES['input_pic']['name']) ;
    $file_ex = end($tmp) ;
    //ถ้าเป็นไฟล์ภาพที่กำหนด
    if(in_array($file_ex, array('jpg','jpeg','png'))){
      $std_pic = $std_code.'.'.$file_ex ;  // ตัวอย่างเช่น 650112112345.jpg
      // move ไฟล์จาก tmp มาไว้ที่ data/
      if(move_uploaded_file($_FILES['input_pic']['tmp_name'],'data/'.$std_pic)){
        // สร้างภาพขนาด 50x50
        resizeThumbnailImage('data/'.$std_pic,'data/sm_'.$std_pic,50,50) ;
        $sql = ",std_pic='$std_pic' " ;
      }
    }
  }
// แก้ไขข้อมูลนักเรียน
  $sql = "update student set std_code='$std_code', std_name='$std_name' ,std_gpa='$std_gpa',std_major='$std_major' $sql where id = '$id' limit 1 " ;
  $rs = $conn->query($sql) ;
  // ถ้า rs เป็น true แสดงว่าแก้ไขข้อมูลเรียบร้อบ 
  if($rs){
    // header("Location:index.php") ;  // ไปหน้า index ทันที
    header("refresh:1;url=index.php") ;  // ไปหน้า index ใน 3 วินาที
    echo "แก้ไขข้อมูลเรียบร้อย" ;
    exit ;
  }
  else { // ถ้า rs เป็น false แสดงว่าแก้ไขไม่ได้ ถ้าเป็น false แสดงว่าคำสั่ง sql มี error ให้ตรวจสอบ โดยการ echo $conn->error ;
    header("refresh:2;url=index.php") ;  // ไปหน้า index ใน 5 วินาที
    echo "แก้ไขข้อมูลไม่สำเร็จ" ;
    exit ;
  }
}
else {
  header("refresh:2;url=index.php") ;  // ไปหน้า index ใน 3 วินาที
  echo "ข้อมูลไม่ครบ" ;
  exit ;// code...
}


?>
