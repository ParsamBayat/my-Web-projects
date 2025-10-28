<?php
session_start();
require 'config.php';

$message = '';
$message_type = '';

if (isset($_GET['token'])) {
    $token = $_GET['token'];
    
    $stmt = $pdo->prepare("SELECT id FROM users WHERE verification_token = ? AND is_verified = FALSE");
    $stmt->execute([$token]);
    $user = $stmt->fetch();
    
    if ($user) {
        $stmt = $pdo->prepare("UPDATE users SET is_verified = TRUE, verification_token = NULL WHERE id = ?");
        $stmt->execute([$user['id']]);
        
        $message = "ایمیل شما با موفقیت تایید شد!";
        $message_type = 'success';
    } else {
        $message = "لینک تایید نامعتبر یا منقضی شده است";
        $message_type = 'error';
    }
} else {
    $message = "لینک تایید معتبر نیست";
    $message_type = 'error';
}
?>

<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تایید ایمیل</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Tahoma, Arial, sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            direction: rtl;
            padding: 20px;
        }
        
        .container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
            padding: 50px;
            text-align: center;
            max-width: 500px;
            width: 100%;
        }
        
        .icon {
            font-size: 80px;
            margin-bottom: 30px;
        }
        
        .success .icon { color: #28a745; }
        .error .icon { color: #dc3545; }
        
        h1 {
            color: #333;
            margin-bottom: 20px;
            font-size: 28px;
        }
        
        p {
            color: #666;
            margin-bottom: 30px;
            font-size: 18px;
            line-height: 1.6;
        }
        
        .btn {
            display: inline-block;
            padding: 15px 30px;
            background: linear-gradient(135deg, #a8edea, #fed6e3);
            color: #333;
            text-decoration: none;
            border-radius: 10px;
            font-weight: bold;
            transition: transform 0.2s ease;
        }
        
        .btn:hover {
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <div class="container <?php echo $message_type; ?>">
        <div class="icon">
            <?php if ($message_type == 'success'): ?>
                ✅
            <?php else: ?>
                ❌
            <?php endif; ?>
        </div>
        
        <h1>
            <?php if ($message_type == 'success'): ?>
                تبریک!
            <?php else: ?>
                خطا!
            <?php endif; ?>
        </h1>
        
        <p><?php echo $message; ?></p>
        
        <?php if ($message_type == 'success'): ?>
            <a href="login.php" class="btn">ورود به پنل کاربری</a>
        <?php else: ?>
            <a href="register.php" class="btn">بازگشت به ثبت نام</a>
        <?php endif; ?>
    </div>
</body>
</html>