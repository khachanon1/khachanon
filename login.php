
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
    <link href="bootstrap/css/bootstrap.css" type="text/css" rel="stylesheet">
    <link href="bootstrap/css/font-awesome.css" type="text/css" rel="stylesheet">
    <link href="bootstrap/css/s2-docs.css" type="text/css" rel="stylesheet">
  </head>
  <body>
    <div class="container">
    <div class="col-md-6">
        <h2>Login Page</h2>
        <form  method="post" action="checklogin.php" class="form-horizontal">
          <div class="form-group">
            <label for="txt_name" class="col-1 col-form-label">UserName</label>
            <div class="col-5">
              <input class="form-control" type="text" id="txt_login" name="txt_login" required="true">
            </div>
          </div>
          <div class="form-group">
            <label for="txt_gpa" class="col-1 col-form-label">Password</label>
            <div class="col-5">
              <input class="form-control" type="password" id="txt_password" name="txt_password" required="true">
            </div>
          </div>
          <div class="form-group">
            <label for="bt" class="col-1 col-form-label"></label>
            <div class="col-5">
             <button class="btn btn-primary" id="bt">Login</button>
            </div>
          </div>
        </form>
    </div>
  </div>
  </body>
</html>
