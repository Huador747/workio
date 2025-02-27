<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <title>ระบบบันทึกเวลาการทำงาน by devbanban.com</title>
    <style>
      /* Custom styles */
      body {
        background-color: #f8f9fa;
        font-family: 'Arial', sans-serif;
      }
      .jumbotron {
        background-color: #007bff;
        color: white;
        font-weight: bold;
        border-radius: 10px;
        padding: 50px 0;
      }
      .container {
        margin-top: 50px;
      }
      .login-form {
        background-color: #ffffff;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.1);
      }
      .login-form h4 {
        font-size: 1.8em;
        color: #007bff;
        font-weight: bold;
      }
      .form-control {
        border-radius: 20px;
        border: 1px solid #ddd;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
        transition: all 0.3s ease;
      }
      .form-control:focus {
        border-color: #007bff;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24), 0 0 0 0.2rem rgba(38, 143, 255, 0.25);
      }
      .btn-primary {
        background-color: #007bff;
        border: none;
        border-radius: 20px;
        width: 100%;
        padding: 12px;
        font-size: 1.2em;
        transition: background-color 0.3s ease;
      }
      .btn-primary:hover {
        background-color: #0056b3;
      }
      .footer {
        text-align: center;
        padding: 20px;
        background-color: #f1f1f1;
        font-size: 14px;
        position: fixed;
        bottom: 0;
        width: 100%;
      }
      .footer a {
        color: #007bff;
        text-decoration: none;
      }
      .footer a:hover {
        text-decoration: underline;
      }
      .card {
        border-radius: 10px;
      }
      .card-body {
        padding: 30px;
      }
    </style>
  </head>
  <body>
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-6 col-sm-12">
          <div class="card">
            <div class="card-body">
              <h4 class="text-center mb-4">เข้าสู่ระบบ</h4>
              <form action="authen.php" method="post">
                <div class="form-group">
                  <label for="m_username">รหัสพนักงาน</label>
                  <input type="text" class="form-control" id="m_username" name="m_username" placeholder="กรุณากรอกรหัสพนักงาน" minlength="2" required>
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">รหัสผ่าน</label>
                  <input type="password" class="form-control" id="exampleInputPassword1" name="m_password" placeholder="กรุณากรอกรหัสผ่าน" minlength="2" required>
                </div>
                <button type="submit" class="btn btn-primary">เข้าสู่ระบบ</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <a href="https://devbanban.com/" target="_blank">https://devbanban.com/</a></p>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  </body>
</html>
