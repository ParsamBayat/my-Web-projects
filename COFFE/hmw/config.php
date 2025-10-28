<?php

define('DB_HOST', 'localhost');
define('DB_NAME', 'lolup');
define('DB_USER', 'root');
define('DB_PASS', '');


define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_USER', 'Mohammdamir249@gmail.com');
define('SMTP_PASS', 'lrcy vjhe yqbe jvlq');
define('SMTP_PORT', 587);


try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("خطا در اتصال به دیتابیس: " . $e->getMessage());
}

// end??
?>
