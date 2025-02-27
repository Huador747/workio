<?php
session_start();

// ตรวจสอบว่าเป็นแอดมินหรือไม่
if ($_SESSION["m_level"] != "admin") {
    Header("Location: index.php");
    exit();
}

include("condb.php"); // รวมไฟล์การเชื่อมต่อฐานข้อมูล

// ตรวจสอบว่าได้รับค่า id หรือไม่
if (isset($_GET['id'])) {
    $m_id = $_GET['id'];

    // ดึงข้อมูลพนักงานจากฐานข้อมูลโดยใช้ m_id
    $sql = "SELECT * FROM tbl_emp WHERE m_id = '$m_id'";
    $result = mysqli_query($condb, $sql);

    // ตรวจสอบว่าเจอข้อมูลหรือไม่
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
    } else {
        echo "ไม่พบข้อมูลพนักงานที่ต้องการแก้ไข!";
        exit();
    }
} else {
    echo "ไม่มีข้อมูลพนักงาน!";
    exit();
}

// ตรวจสอบการส่งฟอร์มเพื่ออัปเดตข้อมูล
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // รับค่าจากฟอร์มที่กรอก
    $username = $_POST['username'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $position = $_POST['position'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $level = $_POST['level'];

    // เช็คว่าได้อัปโหลดรูปภาพใหม่หรือไม่
    $image = $_FILES['image']['name']; // ชื่อไฟล์ที่ผู้ใช้เลือก
    $image_tmp = $_FILES['image']['tmp_name']; // ไฟล์ที่อัปโหลดชั่วคราว

    // ถ้ามีการเลือกไฟล์ใหม่
    if ($image) {
        // ตรวจสอบและสร้างโฟลเดอร์ uploads หากยังไม่มี
        if (!is_dir('uploads')) {
            mkdir('uploads', 0777, true);
        }

        // ตั้งชื่อไฟล์ใหม่ (เพื่อป้องกันการชนกับไฟล์เดิม)
        $image_new_name = "uploads/" . time() . "_" . basename($image);
        
        // ย้ายไฟล์ไปยังโฟลเดอร์ที่ต้องการ
        if (move_uploaded_file($image_tmp, $image_new_name)) {
            // หากอัปโหลดสำเร็จ ให้ใช้ชื่อไฟล์ใหม่
            $sql_update = "UPDATE tbl_emp SET 
                            m_username = '$username', 
                            m_firstname = '$firstname', 
                            m_lastname = '$lastname', 
                            m_position = '$position', 
                            m_phone = '$phone', 
                            m_email = '$email', 
                            m_level = '$level',
                            m_img = '$image_new_name' 
                            WHERE m_id = '$m_id'";
        } else {
            echo "ไม่สามารถอัปโหลดไฟล์ได้!";
            exit();
        }
    } else {
        // ถ้าไม่มีการเลือกไฟล์ใหม่ ให้ใช้รูปเดิม
        $sql_update = "UPDATE tbl_emp SET 
                        m_username = '$username', 
                        m_firstname = '$firstname', 
                        m_lastname = '$lastname', 
                        m_position = '$position', 
                        m_phone = '$phone', 
                        m_email = '$email', 
                        m_level = '$level'
                        WHERE m_id = '$m_id'";
    }

    // ทำการอัปเดตข้อมูล
    if (mysqli_query($condb, $sql_update)) {
        // แสดงข้อความสำเร็จ
        echo "<script>alert('ข้อมูลพนักงานได้รับการอัปเดตแล้ว!'); window.location.href = 'admin_dashboard.php';</script>";
        exit(); // หยุดการทำงานของสคริปต์หลังจากแสดงข้อความและเปลี่ยนเส้นทาง
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
    <title>แก้ไขข้อมูลพนักงาน</title>
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
    <h2>แก้ไขข้อมูลพนักงาน</h2>
    <form method="POST" action="edit_user.php?id=<?php echo $m_id; ?>" enctype="multipart/form-data">
    <input type="text" name="username" value="<?php echo $row['m_username']; ?>" placeholder="ชื่อผู้ใช้" required>
    <input type="text" name="firstname" value="<?php echo $row['m_firstname']; ?>" placeholder="ชื่อจริง" required>
    <input type="text" name="lastname" value="<?php echo $row['m_lastname']; ?>" placeholder="นามสกุล" required>
    <input type="text" name="position" value="<?php echo $row['m_position']; ?>" placeholder="ตำแหน่ง" required>
    <input type="text" name="phone" value="<?php echo $row['m_phone']; ?>" placeholder="เบอร์โทรศัพท์" required>
    <input type="email" name="email" value="<?php echo $row['m_email']; ?>" placeholder="อีเมล" required>
    
    <label for="image">เลือกรูปภาพใหม่:</label>
    <input type="file" name="image" accept="image/*">
    
    <select name="level" required>
        <option value="admin" <?php echo ($row['m_level'] == 'admin') ? 'selected' : ''; ?>>แอดมิน</option>
        <option value="staff" <?php echo ($row['m_level'] == 'staff') ? 'selected' : ''; ?>>ผู้ใช้</option>
    </select>
    <button type="submit">บันทึกการแก้ไข</button>
</form>

</div>

</body>
</html>
