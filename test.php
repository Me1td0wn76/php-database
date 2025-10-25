<?php
/**
 * テストスクリプト
 * MVCの各コンポーネントが正しく動作するかテストする
 */

// エラー表示を有効化
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<html><head><meta charset='UTF-8'><title>PHPテスト</title>";
echo "<style>
    body { font-family: Arial, sans-serif; padding: 20px; background: #f5f5f5; }
    .test { background: white; padding: 15px; margin: 10px 0; border-radius: 5px; }
    .success { border-left: 5px solid #4CAF50; }
    .error { border-left: 5px solid #f44336; }
    h1 { color: #333; }
    h2 { color: #666; margin-top: 20px; }
    pre { background: #f8f8f8; padding: 10px; border-radius: 3px; overflow-x: auto; }
</style></head><body>";

echo "<h1>PHP Database MVC - テスト</h1>";

// 1. PHP基本情報
echo "<h2>1. PHP環境チェック</h2>";
echo "<div class='test success'>";
echo "<strong>PHP Version:</strong> " . phpversion() . "<br>";
echo "<strong>Server:</strong> " . $_SERVER['SERVER_SOFTWARE'] . "<br>";
echo "<strong>Document Root:</strong> " . $_SERVER['DOCUMENT_ROOT'] . "<br>";
echo "<strong>Current File:</strong> " . __FILE__;
echo "</div>";

// 2. 必要な拡張機能チェック
echo "<h2>2. 必要な拡張機能チェック</h2>";
$extensions = ['mysqli', 'mbstring', 'session'];
foreach ($extensions as $ext) {
    $loaded = extension_loaded($ext);
    $class = $loaded ? 'success' : 'error';
    $status = $loaded ? '✓ 有効' : '✗ 無効';
    echo "<div class='test $class'><strong>$ext:</strong> $status</div>";
}

// 3. ファイル存在チェック
echo "<h2>3. 必要なファイルの存在チェック</h2>";
$files = [
    'run.php' => 'メイン画面(View)',
    'Controller/database-connection.php' => 'データベース接続(Controller)',
    'Model/database-model.php' => 'データベースモデル(Model)',
    'Service/database-service.php' => 'ビジネスロジック(Service)',
    'database.sql' => 'SQLファイル',
    'config.php' => '設定ファイル'
];

foreach ($files as $file => $desc) {
    $exists = file_exists($file);
    $class = $exists ? 'success' : 'error';
    $status = $exists ? '✓ 存在' : '✗ 不在';
    echo "<div class='test $class'><strong>$desc ($file):</strong> $status</div>";
}

// 4. クラス読み込みテスト
echo "<h2>4. クラス読み込みテスト</h2>";
try {
    if (file_exists('Controller/database-connection.php')) {
        require_once 'Controller/database-connection.php';
        echo "<div class='test success'>✓ DatabaseConnection クラス読み込み成功</div>";
    }
    
    if (file_exists('Model/database-model.php')) {
        require_once 'Model/database-model.php';
        echo "<div class='test success'>✓ DatabaseModel クラス読み込み成功</div>";
    }
    
    if (file_exists('Service/database-service.php')) {
        require_once 'Service/database-service.php';
        echo "<div class='test success'>✓ DatabaseService クラス読み込み成功</div>";
    }
} catch (Exception $e) {
    echo "<div class='test error'>✗ クラス読み込みエラー: " . $e->getMessage() . "</div>";
}

// 5. データベース接続テスト(オプション)
echo "<h2>5. データベース接続テスト</h2>";
echo "<div class='test'>";
echo "<p>以下の情報でデータベース接続を試みます:</p>";
echo "<pre>";
echo "Host: localhost\n";
echo "User: root\n";
echo "Database: testdb";
echo "</pre>";

try {
    $testConn = new mysqli('localhost', 'root', '', 'testdb');
    if ($testConn->connect_error) {
        throw new Exception($testConn->connect_error);
    }
    echo "<div class='success' style='margin-top: 10px; padding: 10px;'>";
    echo "✓ データベース接続成功!<br>";
    echo "MySQL Version: " . $testConn->server_info;
    echo "</div>";
    $testConn->close();
} catch (Exception $e) {
    echo "<div class='error' style='margin-top: 10px; padding: 10px;'>";
    echo "✗ データベース接続失敗: " . $e->getMessage() . "<br>";
    echo "<small>※ phpMyAdminで 'testdb' データベースを作成してください</small>";
    echo "</div>";
}
echo "</div>";

// 6. セッション機能テスト
echo "<h2>6. セッション機能テスト</h2>";
try {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $_SESSION['test_var'] = 'セッション動作中';
    echo "<div class='test success'>✓ セッション機能: 正常</div>";
    echo "<div class='test'>セッションID: " . session_id() . "</div>";
} catch (Exception $e) {
    echo "<div class='test error'>✗ セッションエラー: " . $e->getMessage() . "</div>";
}

// 7. 書き込み権限チェック
echo "<h2>7. ディレクトリ権限チェック</h2>";
$writable = is_writable('.');
$class = $writable ? 'success' : 'error';
$status = $writable ? '✓ 書き込み可能' : '✗ 書き込み不可';
echo "<div class='test $class'><strong>現在のディレクトリ:</strong> $status</div>";

// まとめ
echo "<h2>8. テスト結果まとめ</h2>";
echo "<div class='test success'>";
echo "<h3>✓ 次のステップ:</h3>";
echo "<ol>";
echo "<li>phpMyAdminで 'testdb' データベースを作成</li>";
echo "<li><a href='run.php'>run.php</a> にアクセスしてアプリケーションを起動</li>";
echo "<li>データベース接続フォームから接続テスト</li>";
echo "<li>テーブル作成とデータ操作を試す</li>";
echo "</ol>";
echo "</div>";

echo "<div style='margin-top: 30px; text-align: center;'>";
echo "<a href='index.php' style='padding: 10px 20px; background: #667eea; color: white; text-decoration: none; border-radius: 5px; margin: 5px;'>ホームへ</a> ";
echo "<a href='run.php' style='padding: 10px 20px; background: #4CAF50; color: white; text-decoration: none; border-radius: 5px; margin: 5px;'>アプリ起動</a>";
echo "</div>";

echo "</body></html>";
?>
