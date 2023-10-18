<?php
include('check.php') ;  // ตรวจสอบว่า login หรือไม่
include("connect.php") ;
include('lib/fnc.php');  // สำหรับเรียกในงาน function ที่เราเขียนไว้
if($_POST['action']=='search')  // ถ้ากดปุ่มค้นหา
{
  // สร้างเงื่อนไขเพื่อดึงข้อมูลมาแสดง
  $sql = array() ;
  if($_POST['q_fac'] !='')  // ถ้ามีการค้นหาด้วยคณะ
  {
    $fac_id = secureStr($_POST['q_fac']) ;
    $sql[] = " fac_id = '$fac_id' " ; 
  }
  if($_POST['q_major'] !='')  // ถ้ามีการค้นหาด้วยสาขา
  {
    $major_id = secureStr($_POST['q_major']) ;
    $sql[] = " major_id = '$major_id' " ;
  }
  if($_POST['q'] !='') // ถ้ามีการค้นหาด้วยข้อความ
  {
    $q = secureStr($_POST['q']) ;
    // like '%$q%' เงื่อนไขเป็นจริงเมื่อคำค้นหาตรงกับข้อมูลบางส่วน เช่น รักการเรียน like '%การ%' เป็นจริง
    // = '$q' เงื่อนไขเป็นจริงเมื่อคำค้นหาตรงกับข้อมูลทั้งหมด เช่น รักการเรียน = 'รักการเรียน'
    $sql[] = " std_name like '%$q%' or  std_code like '%$q%'" ; 
  }
  $condition = '' ;
  if(count($sql) > 0) // ถ้ามีเงื่อนไนค้นหา
  {
    // เอาเงื่อนไขมาต่อกันแล้วส่งไป query เช่น " fac_id = '$fac_id' and std_name like '%$q%' or  std_code like '%$q%' "
    $condition =  "where ". join(' and ', $sql) ; 
  }
}
// ดึงข้อมูลออกมาแสดง
$rs = $conn->query("select * from view_student $condition") ;
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
    <link href="bootstrap/css/bootstrap.css" type="text/css" rel="stylesheet" />
    <link href="bootstrap/css/font-awesome.css" type="text/css" rel="stylesheet" />
    <link href="bootstrap/css/s2-docs.css" type="text/css" rel="stylesheet" >
    <script>
    function del(id)
    {
      if(confirm("ยืนยันการลบข้อมูล"))
      {
        window.location = "delete.php?id="+id ;
      }
      else {
        return false ;
      }
    }
    function getmajor(){
      var x = document.getElementById("q_fac").value;
      window.location.href='index.php?fac='+x ;
    }
    function getmajor2(){
      var x = document.getElementById("input_fac").value;
      window.location.href='index.php?fac2='+x ;
    }
    </script>
  </head>
  <body>
<div class="container">
<div class="row">
  <div class="col-md-8">
<h2>Student List | <a href='logout.php'>ออกจากระบบ</a></h2>
<div class="row">
  <form name="f" action="index.php" method="post">
<div class="col-md-3">
  <select name="q_fac" onchange="getmajor();" id="q_fac" class="form-control input-sm">
  <option value=''>เลือกคณะ</option>
<?php
// list รายการคณะ
    $rs0 = $conn->query("select * from faculty order by fac_name") ;
    //วนลูป option ของ select (แสดงรายการของตัวเลือก)
    while($row0 = $rs0->fetch_array()){
        $fac_id = $row0['fac_id'] ;
        $fac_name = $row0['fac_name'] ;
        // ถ้าตรงกับคณะที่เลือกไว้ให้ทำการ selected 
        if($fac_id == $_GET['fac'] || $fac_id == $_POST['q_fac']){
          echo "<option value='$fac_id' selected>$fac_name</option>" ;
        }else{
          echo "<option value='$fac_id'>$fac_name</option>" ;
        }
    }
?>
  </select>
</div>
<div class="col-md-3">
  <select name="q_major" class="form-control input-sm">
  <option value=''>เลือกสาขา</option>
<?php
// แสดงรายการสาขาของคณะที่เลือก
// list รายการสาขา ถ้ามีการส่งค่า fac 
if($_GET['fac'] !='' || $_POST['q_fac'] !=''){
  if($_POST['q_fac'] !=''){
    $fac = secureStr($_POST['q_fac']) ;  // ต้อง มี include('lib/fnc.php') ก่อน ;
  }
  else{
    $fac = secureStr($_GET['fac']) ;  // ต้อง มี include('lib/fnc.php') ก่อน ;
  }
  //ดึงข้อมูลสาขา 
  $rs0 = $conn->query("select * from major where  fac_id='$fac'  order by major_name") ;
  // วนลูป รายการสาขา
  while($row0 = $rs0->fetch_array()){
      $major_id = $row0['major_id'] ;
      $major_name = $row0['major_name'] ;
      if($major_id  == $_POST['q_major']){
        echo "<option value='$major_id' selected>$major_name</option>" ;
      }else{
        echo "<option value='$major_id'>$major_name</option>" ;
      }
  }
}
?>    
  </select>
</div>
<div class="col-md-4">
  <div class="input-group">                        
    <input type="text" name="q" id="q" class="form-control input-sm" placeholder="Search">
    <input type="hidden" name="action" value="search">
    <div class="input-group-btn">
      <button class="btn btn-sm btn-default" id="btSearch">ค้นหา</button>
    </div>
  </div>  
</div>
  </form>
</div> <!--  end row -->

    <table class="table">
      <tr>
       <th>ภาพ</th><th>code</th><th>name</th><th>gpa</th><th>สาขา</th><th>คณะ</th><th></th>
      </tr>
<?php
  if($rs->num_rows > 0)
  {
    // วนลูป รายการของนักเรียน
    while($row = $rs->fetch_array())
    {
      // ถ้ามีอัปโหลดรูปภาพ std_pic จะไม่เป็น null
      if($row['std_pic'] !='')
      {
        // แสดงรูปภาพ
        $std_pic = "<img src='data/sm_".$row['std_pic']."'>" ;
      }
      else {
        // แสดงค่า null
        $std_pic = '' ;
      }
?>
<tr>
 <td><?php echo $std_pic ; ?></td><td><?php echo $row['std_code'] ; ?></td><td><?php echo $row['std_name'] ; ?></td><td><?php echo $row['std_gpa'] ; ?></td><td><?php echo $row['major_name'] ; ?></td><td><?php echo $row['fac_name'] ; ?></td><td><a href="edit.php?id=<?php echo $row['Id'] ; ?>"><i class='glyphicon glyphicon-pencil'>edit</i></a> | <a href="#" onclick="javascript:del('<?php echo $row['Id'];?>');"><i class='glyphicon glyphicon-trash'>delete</i></a></td>
</tr>
<?php
    }
  }
?>
    </table>
  </div>
  <div class="col-md-4">
      <h2>Insert Student</h2>
      <form  method="post" action="add.php" class="form-horizontal" enctype="multipart/form-data">
        <div class="form-group">
          <label for="txt_name" class="col-1 col-form-label">รหัสนิสิต</label>
          <div class="col-5">
            <input class="form-control"  maxlength="11" type="number" id="txt_code" name="txt_code" required>
          </div>
        </div>
        <div class="form-group">
          <label for="txt_name" class="col-1 col-form-label">ชื่อ</label>
          <div class="col-5">
            <input class="form-control" type="text" id="txt_name" name="txt_name" required>
          </div>
        </div>
        <div class="form-group">
          <label for="txt_gpa" class="col-1 col-form-label">GPA</label>
          <div class="col-5">
            <input class="form-control" type="number" max="4.00" id="txt_gpa" name="txt_gpa" required>
          </div>
        </div>
        <div class="form-group">
          <label for="txt_gpa" class="col-1 col-form-label">คณะ</label>
          <div class="col-5">
            <select name="input_fac" onchange="getmajor2();" id="input_fac" class="form-control input-sm">
            <option value=''>เลือกคณะ</option>
              <?php
              //================== ส่วนตัวเลือกสำหรับกรอกข้อมูลนักเรียน
              // list รายการคณะ
                  $rs0 = $conn->query("select * from faculty order by fac_name") ;
                  while($row0 = $rs0->fetch_array()){
                      $fac_id = $row0['fac_id'] ;
                      $fac_name = $row0['fac_name'] ;
                      if($fac_id == $_GET['fac2']){
                        echo "<option value='$fac_id' selected>$fac_name</option>" ;
                      }else{
                        echo "<option value='$fac_id'>$fac_name</option>" ;
                      }
                  }
              ?>
            </select>
          </div>
        </div>
        <div class="form-group">
          <label for="txt_gpa" class="col-1 col-form-label">สาขา</label>
          <div class="col-5">
            <select name="input_major" id="input_major" class="form-control input-sm">
            <option value=''>เลือกสาขา</option>
            <?php
            // list รายการสาขา ถ้ามีการส่งค่า fac 
            if($_GET['fac2'] !=''){
              $fac = secureStr($_GET['fac2']) ;  // ต้อง มี include('lib/fnc.php') ก่อน ;
              $rs0 = $conn->query("select * from major where  fac_id='$fac'  order by major_name") ;
              while($row0 = $rs0->fetch_array()){
                  $major_id = $row0['major_id'] ;
                  $major_name = $row0['major_name'] ;
                  echo "<option value='$major_id'>$major_name</option>" ;
              }
            }
            ?>    
            </select>
          </div>
        </div>     
        <div class="form-group">
          <label for="txt_gpa" class="col-1 col-form-label">ภาพ</label>
          <div class="col-5">
            <input type="file" name="input_pic">
          </div>
        </div>
        <div class="form-group">
          <label for="bt" class="col-1 col-form-label"></label>
          <div class="col-5">
           <button class="btn btn-primary" id="bt">Submit</button>
          </div>
        </div>
      </form>
  </div>
</div>
</div>
  </body>
</html>
