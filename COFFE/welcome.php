<?php
// دریافت اطلاعات از URL
$name = isset($_GET['name']) ? htmlspecialchars($_GET['name']) : 'کاربر';
$email = isset($_GET['email']) ? htmlspecialchars($_GET['email']) : '';
$phone = isset($_GET['phone']) ? htmlspecialchars($_GET['phone']) : '';
$server_type = isset($_GET['server_type']) ? htmlspecialchars($_GET['server_type']) : '';
$plan = isset($_GET['plan']) ? htmlspecialchars($_GET['plan']) : '';

// تعیین نام کامل پلن
$plan_name = "";
switch ($plan) {
    case "basic":
        $plan_name = "پلن پایه (129,000 تومان)";
        break;
    case "pro":
        $plan_name = "پلن حرفه‌ای (219,000 تومان)";
        break;
    case "enterprise":
        $plan_name = "پلن سازمانی (349,000 تومان)";
        break;
    default:
        $plan_name = "نامشخص";
}

// تعیین نام کامل نوع سرور
$server_name = ($server_type == "linux") ? "سرور لینوکس" : "سرور ویندوز";
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>خوش آمدید</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="stylew.css">k
</head>
<body>
    <div class="container">
        <!-- نوار بالایی با نام کاربر -->
        <div class="user-welcome">
            <div class="welcome-text">
                <i class="fas fa-user-circle user-icon"></i>
                <h1>خوش آمدید، <?php echo $name; ?>!</h1>
            </div>
            <div class="user-actions">
                <a href="#"><i class="fas fa-cog"></i> تنظیمات حساب</a>
                <a href="#"><i class="fas fa-sign-out-alt"></i> خروج</a>
            </div>
        </div>
        
        <!-- محتوای اصلی -->
        <div class="main-content">
            <h2>اطلاعات ثبت نام شما</h2>
            
            <div class="info-card">
                <h3><i class="fas fa-info-circle"></i> اطلاعات شخصی</h3>
                <div class="info-details">
                    <div class="info-item">
                        <span class="info-label">نام کامل:</span>
                        <span class="info-value"><?php echo $name; ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">ایمیل:</span>
                        <span class="info-value"><?php echo $email; ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">شماره تماس:</span>
                        <span class="info-value"><?php echo $phone; ?></span>
                    </div>
                </div>
            </div>
            
            <div class="info-card">
                <h3><i class="fas fa-server"></i> اطلاعات سرور</h3>
                <div class="info-details">
                    <div class="info-item">
                        <span class="info-label">نوع سرور:</span>
                        <span class="info-value"><?php echo $server_name; ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">پلن انتخابی:</span>
                        <span class="info-value"><?php echo $plan_name; ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">وضعیت:</span>
                        <span class="info-value" style="color: #4CAF50;">فعال شده</span>
                    </div>
                </div>
            </div>
            
            <div class="actions">
                <a href="#" class="btn">مدیریت سرور</a>
                <a href="#" class="btn btn-outline">بازگشت به صفحه اصلی</a>
            </div>
        </div>
    </div>
</body>
</html>