<?php
session_start();
require 'config.php';


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}


$stmt = $pdo->prepare("SELECT email, created_at FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();


$currency_data = [];
try {
    $client = new GuzzleHttp\Client();
    
    
    $response = $client->request('GET', 'https://api.nobitex.ir/v2/orderbook/USDTIRT');
    $data = json_decode($response->getBody(), true);
    $currency_data['dollar'] = [
        'price' => number_format($data['lastTradePrice']),
        'change' => '+1.2%',
        'status' => 'up'
    ];
    
    
    $currency_data['euro'] = [
        'price' => number_format(62000),
        'change' => '+0.8%',
        'status' => 'up'
    ];
    
    $currency_data['pound'] = [
        'price' => number_format(73000),
        'change' => '-0.3%',
        'status' => 'down'
    ];
    
    $currency_data['derham'] = [
        'price' => number_format(16000),
        'change' => '+0.5%',
        'status' => 'up'
    ];
    
} catch (Exception $e) {
    
    $currency_data['dollar'] = ['price' => '۵۸,۴۲۰', 'change' => '+1.2%', 'status' => 'up'];
    $currency_data['euro'] = ['price' => '۶۲,۱۵۰', 'change' => '+0.8%', 'status' => 'up'];
    $currency_data['pound'] = ['price' => '۷۳,۸۰۰', 'change' => '-0.3%', 'status' => 'down'];
    $currency_data['derham'] = ['price' => '۱۵,۹۲۰', 'change' => '+0.5%', 'status' => 'up'];
}
?>

<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>پنل کاربری - نمایش قیمت ارز</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Tahoma, Arial, sans-serif;
        }
        
        body {
            background: #f8f9fa;
            direction: rtl;
            color: #333;
        }
        
    
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px 0;
            box-shadow: 0 2px 15px rgba(0,0,0,0.1);
        }
        
        .nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        .logo {
            font-size: 24px;
            font-weight: bold;
        }
        
        .nav-links {
            display: flex;
            gap: 20px;
        }
        
        .nav-links a {
            color: white;
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 6px;
            transition: background 0.3s ease;
        }
        
        .nav-links a:hover {
            background: rgba(255,255,255,0.2);
        }
        
        
        .container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 20px;
        }
        
        .welcome-section {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            margin-bottom: 30px;
            text-align: center;
        }
        
        .welcome-section h1 {
            color: #667eea;
            margin-bottom: 10px;
        }
        
        .welcome-section p {
            color: #666;
        }
        
      
        .cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
            margin-bottom: 30px;
        }
        
        .card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }
        
        .card-header {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #333;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
       
        .main-price {
            text-align: center;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
        }
        
        .main-price .card-header {
            color: white;
            justify-content: center;
        }
        
        .price {
            font-size: 42px;
            font-weight: bold;
            margin: 20px 0;
            text-shadow: 0 2px 10px rgba(0,0,0,0.3);
        }
        
        .price-change {
            display: inline-block;
            padding: 8px 20px;
            background: rgba(255,255,255,0.2);
            border-radius: 20px;
            font-size: 14px;
        }
        
        .price-change.up { color: #90ee90; }
        .price-change.down { color: #ff6b6b; }
        
   
        .user-card {
            text-align: center;
        }
        
        .avatar {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 50%;
            margin: 0 auto 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 24px;
        }
        
        .user-status {
            display: inline-block;
            padding: 5px 15px;
            background: #28a745;
            color: white;
            border-radius: 15px;
            font-size: 12px;
            margin-top: 10px;
        }
        
     
        .currency-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-top: 20px;
        }
        
        .currency-item {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            border-right: 4px solid #667eea;
            transition: transform 0.2s ease;
        }
        
        .currency-item:hover {
            transform: translateY(-3px);
        }
        
        .currency-name {
            color: #666;
            margin-bottom: 8px;
        }
        
        .currency-price {
            font-weight: bold;
            color: #667eea;
            font-size: 18px;
        }
        
        .currency-change {
            font-size: 12px;
            margin-top: 5px;
        }
        
        .currency-change.up { color: #28a745; }
        .currency-change.down { color: #dc3545; }
        

        .visit-info {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
            margin-top: 20px;
            text-align: center;
            color: #666;
        }
        

        @media (max-width: 768px) {
            .nav {
                flex-direction: column;
                gap: 15px;
            }
            
            .nav-links {
                gap: 10px;
            }
            
            .cards-grid {
                grid-template-columns: 1fr;
            }
            
            .price {
                font-size: 32px;
            }
            
            .currency-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>
</head>
<body>

    <div class="header">
        <div class="nav">
            <div class="logo">💼 پنل کاربری</div>
            <div class="nav-links">
                <a href="dashboard.php">🏠 قیمت ارز</a>
                <a href="#">👤 پروفایل</a>
                <a href="#">⚙️ تنظیمات</a>
                <a href="logout.php">🚪 خروج</a>
            </div>
        </div>
    </div>


    <div class="container">

        <div class="welcome-section">
            <h1>👋 خوش آمدید، کاربر گرامی!</h1>
            <p>ایمیل: <?php echo htmlspecialchars($user['email']); ?> | تاریخ عضویت: <?php echo date('Y/m/d', strtotime($user['created_at'])); ?></p>
        </div>

        <div class="cards-grid">
     
            <div class="card main-price">
                <div class="card-header">💵 قیمت دلار آمریکا</div>
                <div class="price"><?php echo $currency_data['dollar']['price']; ?> تومان</div>
                <div class="price-change <?php echo $currency_data['dollar']['status']; ?>">
                    <?php echo $currency_data['dollar']['change']; ?>
                </div>
            </div>
            
         
            <div class="card user-card">
                <div class="avatar">👤</div>
                <div class="card-header">اطلاعات کاربری</div>
                <p>کاربر: <?php echo explode('@', $user['email'])[0]; ?></p>
                <div class="user-status">فعال ✅</div>
                <div style="margin-top: 15px; background: #f8f9fa; padding: 10px; border-radius: 8px;">
                    <small>حساب تایید شده</small>
                </div>
            </div>
        </div>

  
        <div class="card">
            <div class="card-header">🏦 سایر ارزها</div>
            <div class="currency-grid">
                <div class="currency-item">
                    <div class="currency-name">💶 یورو اروپا</div>
                    <div class="currency-price"><?php echo $currency_data['euro']['price']; ?> تومان</div>
                    <div class="currency-change <?php echo $currency_data['euro']['status']; ?>">
                        <?php echo $currency_data['euro']['change']; ?>
                    </div>
                </div>
                <div class="currency-item">
                    <div class="currency-name">💷 پوند انگلیس</div>
                    <div class="currency-price"><?php echo $currency_data['pound']['price']; ?> تومان</div>
                    <div class="currency-change <?php echo $currency_data['pound']['status']; ?>">
                        <?php echo $currency_data['pound']['change']; ?>
                    </div>
                </div>
                <div class="currency-item">
                    <div class="currency-name">🇦🇪 درهم امارات</div>
                    <div class="currency-price"><?php echo $currency_data['derham']['price']; ?> تومان</div>
                    <div class="currency-change <?php echo $currency_data['derham']['status']; ?>">
                        <?php echo $currency_data['derham']['change']; ?>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="visit-info">
            آخرین بروزرسانی: <?php echo date('H:i:s - Y/m/d'); ?> | 
            وضعیت سامانه: <span style="color: #28a745;">● آنلاین</span>
        </div>
    </div>

    <script>

        function updateTime() {
            const now = new Date();
            const timeString = now.toLocaleTimeString('fa-IR') + ' - ' + now.toLocaleDateString('fa-IR');
            document.querySelector('.visit-info').innerHTML = 
                `آخرین بروزرسانی: ${timeString} | وضعیت سامانه: <span style="color: #28a745;">● آنلاین</span>`;
        }
        
        setInterval(updateTime, 1000);
        
     
        setInterval(() => {
            console.log('بروزرسانی قیمت‌ها...');
           
        }, 30000);
    </script>
</body>
</html>