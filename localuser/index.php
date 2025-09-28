<?php

$host = "localhost";
$user = "root"; 
$pass = "";
$dbname = "melli_db";


$db_error = false;
$conn = null;

try {
    $conn = new mysqli($host, $user, $pass, $dbname);
    if ($conn->connect_error) {
        $db_error = true;
    }
} catch (Exception $e) {
    $db_error = true;
}


function isMelliCode($codeMelli) {
    if (is_numeric($codeMelli) && strlen($codeMelli) == 10) {
        $first_number = (int)substr($codeMelli, 0, 1);
        $counter = 0;
        $s = 0;
        
        for ($i = 0; $i < 9; $i++) {
            $num = (int)substr($codeMelli, $i, 1);
            if ($num == $first_number) {
                $counter++;
            }
            $s += $num * (10 - $i);
        }
        
        $r = $s % 11;
        if ($r > 1) {
            $r = 11 - $r;
        }
        
        $lastDigit = (int)substr($codeMelli, 9, 1);
        
        if ($r == $lastDigit && $counter < 9) {
            return true;
        }
    }
    
    return false;
}


$showResult = false;
$isValid = false;
$codeMelli = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['codeMelli'])) {
    $codeMelli = $_POST['codeMelli'];
    $isValid = isMelliCode($codeMelli);
    $showResult = true;
    
    
    if (!$db_error && $conn) {
        try {
            $stmt = $conn->prepare("INSERT INTO melli_codes (code, valid) VALUES (?, ?)");
            $stmt->bind_param("si", $codeMelli, $isValid);
            $stmt->execute();
        } catch (Exception $e) {
           
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>اعتبارسنجی کد ملی ایران</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>✅ اعتبارسنجی کد ملی ایران</h1>
            <p>کد ملی ۱۰ رقمی خود را وارد کنید تا صحت آن بررسی شود</p>
        </div>
        
        <?php if ($db_error): ?>
            <div class="db-status">
                ⚠️ اتصال به دیتابیس برقرار نیست
            </div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="input-group">
                <label for="codeMelli">کد ملی:</label>
                <input type="text" id="codeMelli" name="codeMelli" class="input-field" 
                       placeholder="مثال: 1234567890" maxlength="10" required
                       value="<?php echo htmlspecialchars($codeMelli); ?>">
            </div>
            
            <button type="submit" class="btn">بررسی اعتبار کد ملی</button>
        </form>
        
        <?php if ($showResult): ?>
            <div class="result <?php echo $isValid ? 'valid' : 'invalid'; ?>">
                <h3><?php echo $isValid ? '✅ کد ملی معتبر است' : '❌ کد ملی نامعتبر است'; ?></h3>
                <p>کد ملی وارد شده: <strong><?php echo htmlspecialchars($codeMelli); ?></strong></p>
                
                <?php if (!$isValid): ?>
                    <p style="margin-top:10px;">لطفاً یک کد ملی ۱۰ رقمی معتبر وارد کنید.</p>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        
        <div class="footer">
            <p>By ParsaBayat$</p>
        </div>
    </div>
</body>
</html>