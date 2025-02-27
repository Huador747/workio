<?php
session_start();
include('condb.php');
$m_id = $_SESSION['m_id'];
$m_level = $_SESSION['m_level'];
if ($m_level != 'staff') {
    Header("Location: logout.php");
}
//query member login
$queryemp = "SELECT * FROM tbl_emp WHERE m_id=$m_id";
$resultm = mysqli_query($condb, $queryemp) or die ("Error in query: $queryemp " . mysqli_error($condb));
$rowm = mysqli_fetch_array($resultm);
//เวลาปัจจุบัน
$timenow = date('H:i:s');
$datenow = date('Y-m-d');
//เวลาที่บันทึก
$queryworkio = "SELECT MAX(workdate) as lastdate, workin, workout FROM tbl_work_io WHERE m_id=$m_id AND workdate='$datenow' ";
$resultio = mysqli_query($condb, $queryworkio) or die ("Error in query: $queryworkio " . mysqli_error($condb));
$rowio = mysqli_fetch_array($resultio);
?>
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
        margin: 0;
        padding: 0;
      }
      .jumbotron {
        background-color: #007bff;
        color: white;
        text-align: center;
        border-radius: 10px;
        padding: 30px;
      }
      .container {
        margin-top: 50px;
      }
      .profile {
        background-color: #ffffff;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.1);
      }
      .profile img {
        width: 70%;
        border-radius: 50%;
        margin-bottom: 20px;
      }
      .profile h4 {
        color: #007bff;
        font-weight: bold;
        text-align: center;
      }
      .profile b {
        display: block;
        text-align: center;
        font-size: 1.2em;
      }
      .work-form {
        background-color: #ffffff;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.1);
      }
      .form-control {
        border-radius: 20px;
        border: 1px solid #ddd;
      }
      .form-control:focus {
        border-color: #007bff;
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
      .table {
        margin-top: 30px;
      }
      .footer {
        text-align: center;
        padding: 20px;
        background-color: #f1f1f1;
        font-size: 14px;
      }
      .footer a {
        color: #007bff;
        text-decoration: none;
      }
      .footer a:hover {
        text-decoration: underline;
      }
    </style>
  </head>
  <body>
    <div class="container">
      <div class="row">
        <div class="col-12">
          <div class="jumbotron">
            <h3>Work-IO ระบบบันทึกเวลาการทำงาน</h3>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-3 col-sm-12">
          <div class="profile">
            <img src="<?php echo $rowm['m_img'];?>" alt="Profile Picture">
            <h4><?php echo $rowm['m_firstname'].' '.$rowm['m_lastname']; ?></h4>
            <b>ตำแหน่ง : <?php echo $rowm['m_position']; ?></b>
            <br><br>
            <a href="logout.php" class="btn btn-danger btn-sm">Logout</a>
          </div>
        </div>
        <div class="col-md-9 col-sm-12">
          <div class="work-form">
            <h3>ลงเวลาเข้า-ออกงาน <?php echo date('d-m-Y'); ?></h3>
            <form action="save.php" method="post" class="form-horizontal">
              <div class="form-group row">
                <div class="col-sm-4">
                  <label for="m_id">รหัสพนักงาน</label>
                  <input type="text" class="form-control" name="m_id" value="<?php echo $rowm['m_id']; ?>" readonly>
                </div>
                <div class="col-sm-4">
                  <label for="workin">เวลาเข้างาน</label>
                  <?php if(isset($rowio['workin'])){ ?>
                  <input type="text" class="form-control" name="workin" value="<?php echo $rowio['workin'];?>" disabled>
                  <?php } else { ?>
                  <input type="text" class="form-control" name="workin" value="<?php echo date('H:i:s');?>" readonly>
                  <?php } ?>
                </div>
                <div class="col-sm-4">
                  <label for="workout">เวลาออกงาน</label>
                  <?php
                    if($timenow > '17:00:00'){
                      if(isset($rowio['workout'])){ ?>
                        <input type="text" class="form-control" name="workout" value="<?php echo $rowio['workout'];?>" disabled>
                      <?php } else { ?>
                        <input type="text" class="form-control" name="workout" value="<?php echo date('H:i:s');?>" readonly>
                      <?php }
                    } else {
                      echo '<br><font color="red"> หลัง 17.00 น. </font>';
                    }
                  ?>
                </div>
              </div>
              <button type="submit" class="btn btn-primary">บันทึก</button>
            </form>
          </div>

          <h3>ประวัติการบันทึกเวลา</h3>
          <?php
            $querylist = "SELECT * FROM tbl_work_io WHERE m_id = $m_id ORDER BY workdate DESC";
            $resultlist = mysqli_query($condb, $querylist) or die ("Error:" . mysqli_error($condb));
            echo "<table class='table table-bordered table-striped'>
                    <thead>
                      <tr class='table-danger'>
                        <td>วันที่</td>
                        <td>เวลาเข้า</td>
                        <td>เวลาออก</td>
                      </tr>
                    </thead>";

            foreach ($resultlist as $value) {
                echo "<tr>";
                echo "<td>" . $value["workdate"] . "</td>";
                echo "<td>" . $value["workin"] . "</td>";
                echo "<td>" . $value["workout"] . "</td>";
                echo "</tr>";
            }
            echo '</table>';
          ?>
        </div>
      </div>
    </div>

    <div class="footer">
        <a href="https://devbanban.com/" target="_blank">https://devbanban.com/</a>
      </p>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  </body>
</html>
