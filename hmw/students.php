<?php
require_once 'config.php';

// گرفتن همه دانشجوها
$stmt = $pdo->query("SELECT * FROM students ORDER BY created_at DESC");
$students = $stmt->fetchAll();

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
    header("Location: students.php?message=" . urlencode($message) . "&message_type=" . $message_type);
    exit;
}
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لیست دانشجویان</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>👥 لیست دانشجویان</h1>
            <p>مشاهده و مدیریت اطلاعات تمام دانشجویان</p>
        </div>

        <div class="nav">
            <a href="index.php">صفحه اصلی</a>
            <a href="students.php">لیست دانشجویان</a>
            <a href="search.php">جستجو</a>
        </div>

        <div class="content">
            <?php if (isset($_GET['message'])): ?>
                <div class="alert alert-<?php echo $_GET['message_type']; ?>">
                    <?php echo htmlspecialchars($_GET['message']); ?>
                </div>
            <?php endif; ?>

            <div class="students-section">
                <div class="section-header">
                    <h2>تمام دانشجویان</h2>
                    <span class="count-badge">تعداد: <?php echo count($students); ?> دانشجو</span>
                </div>

                <?php if (empty($students)): ?>
                    <div class="no-data">
                        <p>📝 هیچ دانشجویی ثبت نشده است.</p>
                        <a href="index.php" class="btn btn-primary">افزودن دانشجوی جدید</a>
                    </div>
                <?php else: ?>
                    <table class="students-table">
                        <thead>
                            <tr>
                                <th>شماره دانشجویی</th>
                                <th>کد ملی</th>
                                <th>نام</th>
                                <th>نام خانوادگی</th>
                                <th>رشته</th>
                                <th>ایمیل</th>
                                <th>تلفن</th>
                                <th>تاریخ ثبت</th>
                                <th>عملیات</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($students as $student): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($student['student_number']); ?></td>
                                    <td><?php echo htmlspecialchars($student['national_code']); ?></td>
                                    <td><?php echo htmlspecialchars($student['first_name']); ?></td>
                                    <td><?php echo htmlspecialchars($student['last_name']); ?></td>
                                    <td><?php echo htmlspecialchars($student['field_of_study']); ?></td>
                                    <td><?php echo htmlspecialchars($student['email']); ?></td>
                                    <td><?php echo htmlspecialchars($student['phone']); ?></td>
                                    <td><?php echo date('Y/m/d', strtotime($student['created_at'])); ?></td>
                                    <td class="actions">
                                        <a href="edit.php?id=<?php echo $student['id']; ?>" class="btn btn-primary">ویرایش</a>
                                        <form method="POST" style="display: inline;">
                                            <input type="hidden" name="delete_id" value="<?php echo $student['id']; ?>">
                                            <button type="submit" class="btn btn-danger">حذف</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
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
                <strong>کد ملی:</strong> <?php echo htmlspecialchars($student_to_delete['national_code']); ?><br>
                <strong>نام:</strong> <?php echo htmlspecialchars($student_to_delete['first_name']); ?> <?php echo htmlspecialchars($student_to_delete['last_name']); ?>
            </div>
            <div class="modal-buttons">
                <form method="POST" style="display: inline;">
                    <input type="hidden" name="student_id" value="<?php echo $student_to_delete['id']; ?>">
                    <button type="submit" name="confirm_delete" class="btn btn-danger">بله، حذف شود</button>
                </form>
                <button onclick="window.location.href='students.php'" class="btn btn-primary">انصراف</button>
            </div>
        </div>
    </div>
    <?php endif; ?>
</body>
</html>