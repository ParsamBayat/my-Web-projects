<?php
session_start();



// اطلاعات اتصال به دیتابیس
$host = 'localhost';
$dbname = 'Floor';
$username = 'root';
$password = '';



// اتصال به دیتابیس
$conn = new mysqli($host, $username, $password, $dbname);

// دریافت اطلاعات کاربر
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id='$user_id'";
$result = $conn->query($sql);
$user = $result->fetch_assoc();

// زمانی که اطلاعات وارد نشده باشد و صفحه ع.وض شود
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>پنل کاربری</title>
    <link rel="stylesheet" href="style/style2.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>خوش آمدید <?php echo $user['name']; ?>!</h1>
        </header>
        
        <div class="user-info">
            <div class="info-card">
                <h2>اطلاعات حساب کاربری</h2>
                
                <div class="info-item">
                    <span class="info-label">نام کامل:</span>
                    <span><?php echo $user['name']; ?></span>
                </div>
                
                <div class="info-item">
                    <span class="info-label">ایمیل:</span>
                    <span><?php echo $user['email']; ?></span>
                </div>
                
                <div class="info-item">
                    <span class="info-label">تاریخ عضویت:</span>
                    <span><?php echo $user['created_at']; ?></span>
                </div>
            </div>
            
            <div class="center">
                <a href="logout.php" class="btn btn-logout">خروج از حساب</a>
            </div>
        </div>
    </div>
</body>
</html>