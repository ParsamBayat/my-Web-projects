

<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>سیستم ثبت‌نام و ورود</title>
    <link rel="stylesheet" href="style/style.css">
</head>
<body>
    <div class="container">
        <div class="form-container">
            
            <div id="login-form">
                <h2>ورود به حساب کاربری</h2>
                
                <?php if (isset($login_error)): ?>
                    <div class="alert alert-error"><?php echo $login_error; ?></div>
                <?php endif; ?>
                
                <form action="" method="POST">
                    <div class="form-group">
                        <label for="login-email">ایمیل</label>
                        <input type="email" id="login-email" name="email" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="login-password">رمز عبور</label>
                        <input type="password" id="login-password" name="password" required>
                    </div>
                    
                    <button type="submit" name="login" class="btn">ورود</button>
                </form>
                
                <div class="switch-form">
                    <p>حساب کاربری ندارید؟ <a href="#" onclick="showRegisterForm()">ثبت‌نام کنید</a></p>
                </div>
            </div>
            
            
            <div id="register-form" style="display: none;">
                <h2>ایجاد حساب کاربری</h2>
                
                <?php if (isset($register_error)): ?>
                    <div class="alert alert-error"><?php echo $register_error; ?></div>
                <?php endif; ?>
                
                <?php if (isset($register_success)): ?>
                    <div class="alert alert-success"><?php echo $register_success; ?></div>
                <?php endif; ?>
                
                <form action="" method="POST">
                    <div class="form-group">
                        <label for="register-name">نام کامل</label>
                        <input type="text" id="register-name" name="name" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="register-email">ایمیل</label>
                        <input type="email" id="register-email" name="email" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="register-password">رمز عبور</label>
                        <input type="password" id="register-password" name="password" required>
                    </div>
                    
                    <button type="submit" name="register" class="btn">ثبت‌نام</button>
                </form>
                
                <div class="switch-form">
                    <p>قبلاً حساب کاربری داشتید؟ <a href="#" onclick="showLoginForm()">وارد شوید</a></p>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showRegisterForm() {
            document.getElementById('login-form').style.display = 'none';
            document.getElementById('register-form').style.display = 'block';
        }
        
        function showLoginForm() {
            document.getElementById('register-form').style.display = 'none';
            document.getElementById('login-form').style.display = 'block';
        }
    </script>
</body>
</html>

<?php
session_start();

// for sql connection 
// ... : please dont change dbname
$host = 'localhost';
$dbname = 'Floor';
$username = 'root';
$password = '';


$conn = new mysqli($host, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if (isset($_POST['register'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    
    $sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')";
    
    if ($conn->query($sql) === TRUE) {
        $register_success = "ثبت‌نام با موفقیت انجام شد!";
    } else {
        $register_error = "خطا در ثبت‌نام: " . $conn->error;
    }
}


if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            header("Location: dashboard.php");
            exit();
        } else {
            $login_error = "رمز عبور اشتباه است";
        }
    } else {
        $login_error = "کاربری با این ایمیل یافت نشد";
    }
}
?>