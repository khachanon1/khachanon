<?php
include('check.php') ;  // ตรวจสอบว่า login หรือไม่
include("connect.php") ;
$id = $conn->escape_string($_GET['id']) ;
if($id !=''){
  // ดึงข้อมูลนักเรียนขึ้นมาแสดงก่อนแก้ไข
  $sql="select * from view_student where Id='$id' limit 1" ;
  $rs = $conn->query($sql) ;

  // เก็บข้อมูลนักเรียนไว้ใน $row แล้วเอา row ไปแสดงข้อมูล
  $row = $rs->fetch_array() ;
} else{
  header("refresh:3;url=index.php") ;  // ไปหน้า index ใน 3 วินาที
  echo "ข้อมูลไม่ครบ" ;
  exit ;// code...
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
    <link href="bootstrap/css/bootstrap.css" type="text/css" rel="stylesheet">
    <link href="bootstrap/css/font-awesome.css" type="text/css" rel="stylesheet">
    <link href="bootstrap/css/s2-docs.css" type="text/css" rel="stylesheet">
    <script>
    function getmajor2(){
      var x = document.getElementById("input_fac").value;
      window.location.href='index.php?fac2='+x +'&id='<?php echo $id ?> ;
    }
    </script>
  </head>
  <body>
    <div class="container">
      <div class="col-md-6">
          <h2>Edit Student</h2>
          <form  method="post" action="update.php" class="form-horizontal" enctype="multipart/form-data">
            <div class="form-group">
              <label for="txt_name" class="col-1 col-form-label">รหัสนิสิต</label>
              <div class="col-5">
                <input class="form-control"  maxlength="11" type="number" id="txt_code" name="txt_code" value="<?php echo $row['std_code'];?>" required>
              </div>
            </div>
            <div class="form-group">
              <label for="txt_name" class="col-1 col-form-label">ชื่อ</label>
              <div class="col-5">
                <input class="form-control" type="text" id="txt_name" name="txt_name" value="<?php echo $row['std_name'];?>" required>
              </div>
            </div>
            <div class="form-group">
              <label for="txt_gpa" class="col-1 col-form-label">GPA</label>
              <div class="col-5">
                <input class="form-control" type="number" max="4.00" id="txt_gpa" name="txt_gpa" value="<?php echo $row['std_gpa'];?>" required>
              </div>
            </div>
            <div class="form-group">
          <label for="txt_gpa" class="col-1 col-form-label">คณะ</label>
          <div class="col-5">
          <select name="input_fac" onchange="getmajor2();" id="input_fac" class="form-control input-sm">
            <option value=''>เลือกคณะ</option>
              <?php
              // list รายการคณะ
                  $rs0 = $conn->query("select * from faculty order by fac_name") ;
                  while($row0 = $rs0->fetch_array()){
                      $fac_id = $row0['fac_id'] ;
                      $fac_name = $row0['fac_name'] ;
                      if($fac_id == $row['fac_id']){
                        //ถ้าเป็นคณะของนักเรียนให้เลือกไว้
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
            } else
            {
              $fac = $row['fac_id'] ;
            }
              $rs0 = $conn->query("select * from major where  fac_id='$fac'  order by major_name") ;
              while($row0 = $rs0->fetch_array()){
                  $major_id = $row0['major_id'] ;
                  $major_name = $row0['major_name'] ;
                  if($major_id == $row['major_id']){
                    // ถ้าเป็นสาขาของนักเรียนให้เลือกไว้
                    echo "<option value='$major_id' selected>$major_name</option>" ;
                  }else{
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
                <input type="hidden" name="id" value="<?php echo $id;?>">
               <button class="btn btn-primary" id="bt">Submit</button>
              </div>
            </div>
          </form>
      </div>
  </div>
  </body>
</html>
