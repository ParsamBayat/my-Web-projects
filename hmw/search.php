<?php
require_once 'config.php';

$search_results = [];
$search_performed = false;

if (isset($_GET['search'])) {
    $search_term = $_GET['search_number'];
    $search_performed = true;
    
    $stmt = $pdo->prepare("SELECT * FROM students WHERE student_number = ? OR national_code = ?");
    $stmt->execute([$search_term, $search_term]);
    $search_results = $stmt->fetchAll();
}
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>جستجوی دانشجو</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🔍 جستجوی دانشجو</h1>
            <p>جستجوی اطلاعات دانشجو با شماره دانشجویی یا کد ملی</p>
        </div>

        <div class="nav">
            <a href="index.php">صفحه اصلی</a>
            <a href="students.php">لیست دانشجویان</a>
            <a href="search.php">جستجو</a>
        </div>

        <div class="content">
            <!-- فرم جستجو -->
            <div class="form-container">
                <h2>جستجوی دانشجو</h2>
                <form method="GET">
                    <div class="form-group">
                        <label for="search_number">شماره دانشجویی یا کد ملی:</label>
                        <input type="text" id="search_number" name="search_number" 
                               placeholder="شماره دانشجویی یا کد ملی را وارد کنید..." required>
                    </div>
                    <button type="submit" name="search" class="btn btn-success">جستجو</button>
                </form>
            </div>

            <!-- نتایج جستجو -->
            <?php if ($search_performed): ?>
                <div class="results-container">
                    <h3>نتایج جستجو برای "<?php echo htmlspecialchars($_GET['search_number']); ?>"</h3>
                    
                    <?php if (!empty($search_results)): ?>
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
                                    <th>عملیات</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($search_results as $student): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($student['student_number']); ?></td>
                                        <td><?php echo htmlspecialchars($student['national_code']); ?></td>
                                        <td><?php echo htmlspecialchars($student['first_name']); ?></td>
                                        <td><?php echo htmlspecialchars($student['last_name']); ?></td>
                                        <td><?php echo htmlspecialchars($student['field_of_study']); ?></td>
                                        <td><?php echo htmlspecialchars($student['email']); ?></td>
                                        <td><?php echo htmlspecialchars($student['phone']); ?></td>
                                        <td class="actions">
                                            <a href="edit.php?id=<?php echo $student['id']; ?>" class="btn btn-primary">ویرایش</a>
                                            <form method="POST" action="students.php" style="display: inline;">
                                                <input type="hidden" name="delete_id" value="<?php echo $student['id']; ?>">
                                                <button type="submit" class="btn btn-danger">حذف</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <div class="no-results">
                            <p>❌ دانشجویی با این شماره دانشجویی یا کد ملی یافت نشد.</p>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>