<?php
session_start();

// ตรวจสอบว่าเป็นแอดมินหรือไม่
if ($_SESSION["m_level"] != "admin") {
    // หากไม่ใช่แอดมิน ให้กลับไปที่หน้า login
    Header("Location: index.php");
    exit();
}

include("condb.php"); // รวมไฟล์การเชื่อมต่อฐานข้อมูล

// ดึงข้อมูลพนักงานทั้งหมดจากตาราง tbl_emp
$sql = "SELECT m_id, m_username, m_firstname, m_lastname, m_position, m_img, m_phone, m_email, m_level, m_datesave FROM tbl_emp";
$result = mysqli_query($condb, $sql);

// ตรวจสอบว่ามีข้อมูลพนักงานหรือไม่
if (mysqli_num_rows($result) > 0) {
    echo "<!DOCTYPE html>
    <html lang='th'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>หน้าผู้ดูแลระบบ</title>
        <style>
            body {
                font-family: 'Arial', sans-serif;
                background-color: #f4f4f4;
                margin: 0;
                padding: 0;
            }
            header {
                background-color: #333;
                color: white;
                text-align: center;
                padding: 10px;
            }
            h1, h2 {
                color: #333;
            }
            table {
                width: 100%;
                margin: 20px auto;
                border-collapse: collapse;
                background-color: #fff;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            }
            table th, table td {
                padding: 12px;
                text-align: left;
                border-bottom: 1px solid #ddd;
            }
            table th {
                background-color: #4CAF50;
                color: white;
            }
            table td img {
                border-radius: 50%;
            }
            table tr:hover {
                background-color: #f1f1f1;
            }
            a {
                color: #007BFF;
                text-decoration: none;
            }
            a:hover {
                text-decoration: underline;
            }
            .container {
                max-width: 1200px;
                margin: 0 auto;
                padding: 20px;
            }
            .button {
                background-color: #4CAF50;
                color: white;
                padding: 10px 20px;
                margin: 20px 0;
                border: none;
                cursor: pointer;
                text-decoration: none;
                border-radius: 5px;
            }
            .button:hover {
                background-color: #45a049;
            }
        </style>
    </head>
    <body>

    <header>
        <h1>ยินดีต้อนรับเข้าสู่หน้าแอดมิน</h1>
    </header>

    <div class='container'>
        <h2>ข้อมูลพนักงานทั้งหมด</h2>";

    // เพิ่มปุ่ม "เพิ่มพนักงาน"
    echo "<a href='add_employee.php' class='button'>เพิ่มพนักงาน</a>";

    // สร้างตาราง HTML เพื่อแสดงข้อมูลพนักงาน
    echo "<table>
            <tr>
                <th>ID</th>
                <th>ชื่อผู้ใช้</th>
                <th>ชื่อจริง</th>
                <th>นามสกุล</th>
                <th>ตำแหน่ง</th>
                <th>รูปภาพ</th>
                <th>เบอร์โทรศัพท์</th>
                <th>อีเมล</th>
                <th>ระดับ</th>
                <th>วันที่บันทึก</th>
                <th>การจัดการ</th>
            </tr>";

    // แสดงข้อมูลแต่ละแถวจากฐานข้อมูล
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
                <td>" . $row['m_id'] . "</td>
                <td>" . $row['m_username'] . "</td>
                <td>" . $row['m_firstname'] . "</td>
                <td>" . $row['m_lastname'] . "</td>
                <td>" . $row['m_position'] . "</td>";

        // แสดงรูปภาพถ้ามี
        if ($row['m_img']) {
            echo "<td><img src='" . $row['m_img'] . "' alt='Profile Image' width='50' height='50'></td>";
        } else {
            echo "<td>ไม่มีรูป</td>";
        }

        echo "<td>" . $row['m_phone'] . "</td>
              <td>" . $row['m_email'] . "</td>
              <td>" . $row['m_level'] . "</td>
              <td>" . $row['m_datesave'] . "</td>
              <td><a href='edit_user.php?id=" . $row['m_id'] . "'>แก้ไข</a> | <a href='delete_user.php?id=" . $row['m_id'] . "'>ลบ</a></td>
              </tr>";
    }

    echo "</table>
    </div>
    </body>
    </html>";

} else {
    echo "<p>ไม่พบข้อมูลพนักงานในระบบ</p>";
}

mysqli_close($condb); // ปิดการเชื่อมต่อฐานข้อมูล
?>
