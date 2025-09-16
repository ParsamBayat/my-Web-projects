<?php
// اگر فرم ارسال شده
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // دریافت اطلاعات از فرم
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $server_type = htmlspecialchars($_POST['server-type']);
    $plan = htmlspecialchars($_POST['plan']);
    
    // هدایت به صفحه welcome.php با اطلاعات کاربر
    header("Location: welcome.php?name=" . urlencode($name) . "&email=" . urlencode($email) . "&phone=" . urlencode($phone) . "&server_type=" . urlencode($server_type) . "&plan=" . urlencode($plan));
    exit();
}
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ثبت نام سرور مجازی</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="logo">
                <h1>ثبت نام سرور مجازی</h1>
                <p>اطلاعات خود را وارد نمایید</p>
            </div>
            
            <form action="register.php" method="POST">
                <div class="input-group">
                    <label for="name">نام کامل</label>
                    <i class="fas fa-user"></i>
                    <input type="text" id="name" name="name" placeholder="نام کامل خود را وارد کنید" required>
                </div>
                
                <div class="input-group">
                    <label for="email">ایمیل</label>
                    <i class="fas fa-envelope"></i>
                    <input type="email" id="email" name="email" placeholder="ایمیل خود را وارد کنید" required>
                </div>
                
                <div class="input-group">
                    <label for="phone">شماره تماس</label>
                    <i class="fas fa-phone"></i>
                    <input type="tel" id="phone" name="phone" placeholder="شماره تماس خود را وارد کنید" required>
                </div>
                
                <div class="input-group">
                    <label for="server">نوع سرور</label>
                    <div class="server-type">
                        <div class="server-option" onclick="selectServer('linux')">
                            <i class="fab fa-linux"></i>
                            <div>سرور لینوکس</div>
                        </div>
                        <div class="server-option" onclick="selectServer('windows')">
                            <i class="fab fa-windows"></i>
                            <div>سرور ویندوز</div>
                        </div>
                    </div>
                    <input type="hidden" id="server-type" name="server-type" value="" required>
                </div>
                
                <div class="input-group">
                    <label for="plan">پلن مورد نظر</label>
                    <i class="fas fa-server"></i>
                    <select id="plan" name="plan" required>
                        <option value="">پلن را انتخاب کنید</option>
                        <option value="basic">پلن پایه (ماهیانه 129,000 تومان)</option>
                        <option value="pro">پلن حرفه‌ای (ماهیانه 219,000 تومان)</option>
                        <option value="enterprise">پلن سازمانی (ماهیانه 349,000 تومان)</option>
                    </select>
                </div>
                
                <div class="input-group">
                    <label for="password">رمز عبور</label>
                    <i class="fas fa-lock"></i>
                    <input type="password" id="password" name="password" placeholder="رمز عبور خود را وارد کنید" required>
                </div>
                
                <button type="submit" class="btn">ثبت نام و پرداخت</button>
            </form>
            
            <div class="divider"></div>
            
            <div class="links">
                <a href="#"><i class="fas fa-file-contract"></i> قوانین و مقررات</a>
                <a href="#"><i class="fas fa-user-circle"></i> ورود به حساب</a>
                <a href="#"><i class="fas fa-key"></i> بازیابی رمز عبور</a>
            </div>
        </div>
        
        <div class="copyright">
            © 2023 کلیه حقوق محفوظ است
        </div>
    </div>

    <script>
        function selectServer(type) {
            document.querySelectorAll('.server-option').forEach(opt => {
                opt.classList.remove('selected');
            });
            
            document.querySelector(`.server-option:nth-child(${type === 'linux' ? 1 : 2})`).classList.add('selected');
            document.getElementById('server-type').value = type;
        }
        
        document.querySelector('form').addEventListener('submit', function(e) {
            if(!document.getElementById('server-type').value) {
                e.preventDefault();
                alert('لطفا نوع سرور را انتخاب کنید');
            }
        });
    </script>
</body>
</html>