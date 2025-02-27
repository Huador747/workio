<?php
session_start();

// ตรวจสอบว่าเป็นแอดมินหรือไม่
if ($_SESSION["m_level"] != "admin") {
    Header("Location: index.php");
    exit();
}

include("condb.php"); // รวมไฟล์การเชื่อมต่อฐานข้อมูล

// ตรวจสอบการส่งฟอร์ม
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // รับค่าจากฟอร์ม
    $username = $_POST['username'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $position = $_POST['position'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $level = $_POST['level'];
    $password = sha1($_POST['password']); // เข้ารหัสรหัสผ่านด้วย sha1
    $img = "";  // สามารถเพิ่มการอัพโหลดรูปภาพได้ในภายหลัง

    // คำสั่ง SQL สำหรับการเพิ่มข้อมูลพนักงานใหม่
    $sql = "INSERT INTO tbl_emp (m_username, m_firstname, m_lastname, m_position, m_phone, m_email, m_level, m_password, m_img) 
            VALUES ('$username', '$firstname', '$lastname', '$position', '$phone', '$email', '$level', '$password', '$img')";

    if (mysqli_query($condb, $sql)) {
        echo "เพิ่มพนักงานสำเร็จ!";
        Header("Location: admin_dashboard.php"); // กลับไปยังหน้าแอดมินหลังจากเพิ่มข้อมูล
    } else {
        echo "เกิดข้อผิดพลาด: " . mysqli_error($condb);
    }

    mysqli_close($condb); // ปิดการเชื่อมต่อฐานข้อมูล
}

?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เพิ่มพนักงาน</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #333;
        }
        form input, form select, form button {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>เพิ่มพนักงานใหม่</h2>
    <form method="POST" action="add_employee.php">
        <input type="text" name="username" placeholder="ชื่อผู้ใช้" required>
        <input type="text" name="firstname" placeholder="ชื่อจริง" required>
        <input type="text" name="lastname" placeholder="นามสกุล" required>
        <input type="text" name="position" placeholder="ตำแหน่ง" required>
        <input type="text" name="phone" placeholder="เบอร์โทรศัพท์" required>
        <input type="email" name="email" placeholder="อีเมล" required>
        <input type="password" name="password" placeholder="รหัสผ่าน" required>
        <select name="level" required>
            <option value="admin">แอดมิน</option>
            <option value="staff">ผู้ใช้</option>
        </select>
        <button type="submit">เพิ่มพนักงาน</button>
    </form>
</div>

</body>
</html>