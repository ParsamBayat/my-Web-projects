<?php
require_once 'config.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    header('Location: students.php');
    exit;
}

// گرفتن اطلاعات دانشجو
$stmt = $pdo->prepare("SELECT * FROM students WHERE id = ?");
$stmt->execute([$id]);
$student = $stmt->fetch();

if (!$student) {
    header('Location: students.php');
    exit;
}

// عملیات آپدیت
if (isset($_POST['update_student'])) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $field_of_study = $_POST['field_of_study'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    
    $stmt = $pdo->prepare("UPDATE students SET first_name = ?, last_name = ?, field_of_study = ?, email = ?, phone = ? WHERE id = ?");
    
    if ($stmt->execute([$first_name, $last_name, $field_of_study, $email, $phone, $id])) {
        header('Location: students.php?message=اطلاعات با موفقیت به روز شد&message_type=success');
        exit;
    } else {
        $message = "خطا در به روز رسانی اطلاعات";
        $message_type = "danger";
    }
}
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ویرایش دانشجو</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>✏️ ویرایش اطلاعات دانشجو</h1>
        </div>

        <div class="nav">
            <a href="index.php">صفحه اصلی</a>
            <a href="students.php">لیست دانشجویان</a>
            <a href="search.php">جستجو</a>
        </div>

        <div class="content">
            <?php if (isset($message)): ?>
                <div class="alert alert-<?php echo $message_type; ?>">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>

            <div class="form-container">
                <form method="POST">
                    <!-- فیلدهای غیرقابل تغییر -->
                    <div class="form-group">
                        <label for="student_number">شماره دانشجویی:</label>
                        <input type="text" id="student_number" value="<?php echo htmlspecialchars($student['student_number']); ?>" readonly disabled style="background-color: #f8f9fa;">
                        <small>شماره دانشجویی قابل تغییر نیست</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="national_code">کد ملی:</label>
                        <input type="text" id="national_code" value="<?php echo htmlspecialchars($student['national_code']); ?>" readonly disabled style="background-color: #f8f9fa;">
                        <small>کد ملی قابل تغییر نیست</small>
                    </div>
                    
                    <!-- فیلدهای قابل ویرایش -->
                    <div class="form-group">
                        <label for="first_name">نام:</label>
                        <input type="text" id="first_name" name="first_name" 
                               value="<?php echo htmlspecialchars($student['first_name']); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="last_name">نام خانوادگی:</label>
                        <input type="text" id="last_name" name="last_name" 
                               value="<?php echo htmlspecialchars($student['last_name']); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="field_of_study">رشته تحصیلی:</label>
                        <input type="text" id="field_of_study" name="field_of_study" 
                               value="<?php echo htmlspecialchars($student['field_of_study']); ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="email">ایمیل:</label>
                        <input type="email" id="email" name="email" 
                               value="<?php echo htmlspecialchars($student['email']); ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="phone">تلفن:</label>
                        <input type="text" id="phone" name="phone" 
                               value="<?php echo htmlspecialchars($student['phone']); ?>">
                    </div>
                    
                    <button type="submit" name="update_student" class="btn btn-success">ذخیره تغییرات</button>
                    <a href="students.php" class="btn btn-primary">بازگشت</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>