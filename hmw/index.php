<?php
require_once 'config.php';

// عملیات حذف
if (isset($_POST['delete_id'])) {
    $student_id = $_POST['delete_id'];
    
    $stmt = $pdo->prepare("SELECT * FROM students WHERE id = ?");
    $stmt->execute([$student_id]);
    $student_to_delete = $stmt->fetch();
}

// عملیات تأیید حذف
if (isset($_POST['confirm_delete'])) {
    $student_id = $_POST['student_id'];
    
    $stmt = $pdo->prepare("DELETE FROM students WHERE id = ?");
    if ($stmt->execute([$student_id])) {
        $message = "دانشجو با موفقیت حذف شد";
        $message_type = "success";
    } else {
        $message = "خطا در حذف دانشجو";
        $message_type = "danger";
    }
}

// عملیات اضافه کردن
if (isset($_POST['add_student'])) {
    $student_number = $_POST['student_number'];
    $national_code = $_POST['national_code'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $field_of_study = $_POST['field_of_study'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    
    try {
        // بررسی وجود شماره دانشجویی تکراری
        $stmt = $pdo->prepare("SELECT id FROM students WHERE student_number = ?");
        $stmt->execute([$student_number]);
        if ($stmt->fetch()) {
            $message = "این شماره دانشجویی قبلاً ثبت شده است";
            $message_type = "danger";
        } 
        // بررسی وجود کد ملی تکراری (اگر وارد شده)
        else if (!empty($national_code)) {
            $stmt = $pdo->prepare("SELECT id FROM students WHERE national_code = ?");
            $stmt->execute([$national_code]);
            if ($stmt->fetch()) {
                $message = "این کد ملی قبلاً ثبت شده است";
                $message_type = "danger";
            } else {
                // اضافه کردن با کد ملی
                $stmt = $pdo->prepare("INSERT INTO students (student_number, national_code, first_name, last_name, field_of_study, email, phone) VALUES (?, ?, ?, ?, ?, ?, ?)");
                $stmt->execute([$student_number, $national_code, $first_name, $last_name, $field_of_study, $email, $phone]);
                $message = "دانشجو با موفقیت اضافه شد";
                $message_type = "success";
            }
        } else {
            // اضافه کردن بدون کد ملی
            $stmt = $pdo->prepare("INSERT INTO students (student_number, national_code, first_name, last_name, field_of_study, email, phone) VALUES (?, NULL, ?, ?, ?, ?, ?)");
            $stmt->execute([$student_number, $first_name, $last_name, $field_of_study, $email, $phone]);
            $message = "دانشجو با موفقیت اضافه شد";
            $message_type = "success";
        }
    } catch(PDOException $e) {
        $message = "خطا در ثبت اطلاعات: " . $e->getMessage();
        $message_type = "danger";
    }
}
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>سیستم مدیریت دانشجویان</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🎓 سیستم مدیریت دانشجویان</h1>
            <p>مدیریت اطلاعات دانشجویان به صورت حرفه ای</p>
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

            <!-- فرم افزودن دانشجو -->
            <div class="form-container">
                <h2>➕ افزودن دانشجوی جدید</h2>
                <form method="POST">
                    <div class="form-group">
                        <label for="student_number">شماره دانشجویی: *</label>
                        <input type="text" id="student_number" name="student_number" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="national_code">کد ملی:</label>
                        <input type="text" id="national_code" name="national_code" 
                               pattern="[0-9]{10}" title="کد ملی باید 10 رقمی باشد"
                               maxlength="10">
                        <small>کد ملی باید 10 رقم باشد (اختیاری)</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="first_name">نام: *</label>
                        <input type="text" id="first_name" name="first_name" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="last_name">نام خانوادگی: *</label>
                        <input type="text" id="last_name" name="last_name" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="field_of_study">رشته تحصیلی:</label>
                        <input type="text" id="field_of_study" name="field_of_study">
                    </div>
                    
                    <div class="form-group">
                        <label for="email">ایمیل:</label>
                        <input type="email" id="email" name="email">
                    </div>
                    
                    <div class="form-group">
                        <label for="phone">تلفن:</label>
                        <input type="text" id="phone" name="phone">
                    </div>
                    
                    <button type="submit" name="add_student" class="btn btn-primary">ثبت دانشجو</button>
                </form>
            </div>
        </div>
    </div>

    <!-- مودال تأیید حذف -->
    <?php if (isset($student_to_delete)): ?>
    <div id="deleteModal" class="modal" style="display: block;">
        <div class="modal-content">
            <h3>⚠️ آیا مطمئن هستید؟</h3>
            <p>آیا از حذف دانشجوی زیر اطمینان دارید؟</p>
            <div style="background: #f8f9fa; padding: 15px; border-radius: 8px; margin: 15px 0;">
                <strong>شماره دانشجویی:</strong> <?php echo htmlspecialchars($student_to_delete['student_number']); ?><br>
                <?php if (!empty($student_to_delete['national_code'])): ?>
                    <strong>کد ملی:</strong> <?php echo htmlspecialchars($student_to_delete['national_code']); ?><br>
                <?php endif; ?>
                <strong>نام:</strong> <?php echo htmlspecialchars($student_to_delete['first_name']); ?> <?php echo htmlspecialchars($student_to_delete['last_name']); ?>
            </div>
            <div class="modal-buttons">
                <form method="POST" style="display: inline;">
                    <input type="hidden" name="student_id" value="<?php echo $student_to_delete['id']; ?>">
                    <button type="submit" name="confirm_delete" class="btn btn-danger">بله، حذف شود</button>
                </form>
                <button onclick="window.location.href='index.php'" class="btn btn-primary">انصراف</button>
            </div>
        </div>
    </div>
    <?php endif; ?>
</body>
</html>