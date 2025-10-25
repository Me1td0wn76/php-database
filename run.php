<?php
/**
 * run.php - メインエントリーポイント(View)
 * MVCモデルを使用したPHPデータベース接続の教材
 */

// 必要なファイルを読み込み
require_once 'Controller/database-connection.php';
require_once 'Model/database-model.php';
require_once 'Service/database-service.php';

// エラー表示設定(開発環境用)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// セッション開始
session_start();

// メッセージの初期化
$message = '';
$error = '';
$users = [];

// POSTリクエストの処理
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['connect'])) {
        // データベース接続処理
        try {
            $servername = $_POST["servername"] ?? 'localhost';
            $username = $_POST["username"] ?? 'root';
            $password = $_POST["password"] ?? '';
            $dbname = $_POST["dbname"] ?? 'testdb';

            // Controller層: データベース接続
            $dbConnection = new DatabaseConnection($servername, $username, $password, $dbname);
            
            // Model層: データベース操作
            $dbModel = new DatabaseModel($dbConnection);
            
            // Service層: ビジネスロジック
            $dbService = new DatabaseService($dbModel);
            
            // セッションに保存
            $_SESSION['db_service'] = serialize($dbService);
            $_SESSION['connected'] = true;
            
            $message = "データベースに正常に接続しました!";
        } catch (Exception $e) {
            $error = "接続エラー: " . $e->getMessage();
        }
    } elseif (isset($_POST['create_table'])) {
        // テーブル作成処理
        if (isset($_SESSION['db_service'])) {
            $dbService = unserialize($_SESSION['db_service']);
            try {
                $dbService->createUsersTable();
                $message = "usersテーブルを作成しました!";
            } catch (Exception $e) {
                $error = "テーブル作成エラー: " . $e->getMessage();
            }
        }
    } elseif (isset($_POST['insert_user'])) {
        // ユーザー挿入処理
        if (isset($_SESSION['db_service'])) {
            $dbService = unserialize($_SESSION['db_service']);
            try {
                $name = $_POST['name'] ?? '';
                $email = $_POST['email'] ?? '';
                
                if (!empty($name) && !empty($email)) {
                    $dbService->insertUser($name, $email);
                    $message = "ユーザーを追加しました!";
                } else {
                    $error = "名前とメールアドレスを入力してください。";
                }
            } catch (Exception $e) {
                $error = "挿入エラー: " . $e->getMessage();
            }
        }
    } elseif (isset($_POST['show_users'])) {
        // ユーザー一覧取得
        if (isset($_SESSION['db_service'])) {
            $dbService = unserialize($_SESSION['db_service']);
            try {
                $users = $dbService->getAllUsers();
                $message = "ユーザー一覧を取得しました!";
            } catch (Exception $e) {
                $error = "取得エラー: " . $e->getMessage();
            }
        }
    } elseif (isset($_POST['disconnect'])) {
        // 切断処理
        session_destroy();
        $message = "データベースから切断しました。";
    }
}

$isConnected = isset($_SESSION['connected']) && $_SESSION['connected'];
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Database MVC Example</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            max-width: 900px;
            margin: 50px auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
            border-bottom: 3px solid #4CAF50;
            padding-bottom: 10px;
        }
        h2 {
            color: #555;
            margin-top: 30px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #666;
            font-weight: bold;
        }
        input[type="text"],
        input[type="password"],
        input[type="email"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin: 5px 5px 5px 0;
        }
        button:hover {
            background-color: #45a049;
        }
        button.danger {
            background-color: #f44336;
        }
        button.danger:hover {
            background-color: #da190b;
        }
        button.info {
            background-color: #2196F3;
        }
        button.info:hover {
            background-color: #0b7dda;
        }
        .message {
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
        .mvc-info {
            background-color: #e7f3ff;
            padding: 15px;
            border-left: 4px solid #2196F3;
            margin: 20px 0;
        }
        .section {
            margin-top: 30px;
            padding: 20px;
            background-color: #fafafa;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>PHP Database MVC 教材</h1>
        
        <div class="mvc-info">
            <h3>MVCモデルについて</h3>
            <ul>
                <li><strong>Model (Model/database-model.php)</strong>: データベース操作の処理</li>
                <li><strong>View (run.php)</strong>: ユーザーインターフェース(このページ)</li>
                <li><strong>Controller (Controller/database-connection.php)</strong>: データベース接続管理</li>
                <li><strong>Service (Service/database-service.php)</strong>: ビジネスロジック層</li>
            </ul>
        </div>

        <?php if ($message): ?>
            <div class="message success"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="message error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <?php if (!$isConnected): ?>
            <!-- データベース接続フォーム -->
            <div class="section">
                <h2>データベース接続</h2>
                <form method="post" action="">
                    <div class="form-group">
                        <label for="servername">サーバー名:</label>
                        <input type="text" id="servername" name="servername" value="localhost" required>
                    </div>
                    <div class="form-group">
                        <label for="username">ユーザー名:</label>
                        <input type="text" id="username" name="username" value="root" required>
                    </div>
                    <div class="form-group">
                        <label for="password">パスワード:</label>
                        <input type="password" id="password" name="password" value="">
                    </div>
                    <div class="form-group">
                        <label for="dbname">データベース名:</label>
                        <input type="text" id="dbname" name="dbname" value="testdb" required>
                    </div>
                    <button type="submit" name="connect">接続する</button>
                </form>
            </div>
        <?php else: ?>
            <!-- データベース操作メニュー -->
            <div class="section">
                <h2>データベースに接続中</h2>
                <form method="post" action="" style="display: inline;">
                    <button type="submit" name="disconnect" class="danger">切断する</button>
                </form>
            </div>

            <div class="section">
                <h2>テーブル作成</h2>
                <p>usersテーブルを作成します(id, name, email, created_at)</p>
                <form method="post" action="">
                    <button type="submit" name="create_table" class="info">テーブルを作成</button>
                </form>
            </div>

            <div class="section">
                <h2>ユーザー追加</h2>
                <form method="post" action="">
                    <div class="form-group">
                        <label for="name">名前:</label>
                        <input type="text" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">メールアドレス:</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <button type="submit" name="insert_user">ユーザーを追加</button>
                </form>
            </div>

            <div class="section">
                <h2>ユーザー一覧表示</h2>
                <form method="post" action="">
                    <button type="submit" name="show_users" class="info">ユーザー一覧を表示</button>
                </form>

                <?php if (!empty($users)): ?>
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>名前</th>
                                <th>メールアドレス</th>
                                <th>作成日時</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($user['id']); ?></td>
                                    <td><?php echo htmlspecialchars($user['name']); ?></td>
                                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                                    <td><?php echo htmlspecialchars($user['created_at']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>