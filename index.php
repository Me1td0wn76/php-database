<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Database MVC - スタート</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .container {
            background-color: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            max-width: 600px;
            text-align: center;
        }
        h1 {
            color: #333;
            margin-bottom: 20px;
            font-size: 2.5em;
        }
        .emoji {
            font-size: 4em;
            margin: 20px 0;
        }
        p {
            color: #666;
            font-size: 1.1em;
            line-height: 1.6;
            margin: 20px 0;
        }
        .button {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 15px 40px;
            text-decoration: none;
            border-radius: 50px;
            font-size: 1.2em;
            font-weight: bold;
            margin: 10px;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .button:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        }
        .features {
            text-align: left;
            margin: 30px 0;
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
        }
        .features h3 {
            color: #667eea;
            margin-bottom: 15px;
        }
        .features ul {
            list-style: none;
            padding: 0;
        }
        .features li {
            padding: 8px 0;
            padding-left: 25px;
            position: relative;
        }
        .features li:before {
            content: "✓";
            position: absolute;
            left: 0;
            color: #4CAF50;
            font-weight: bold;
        }
        .links {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 2px solid #eee;
        }
        .links a {
            color: #667eea;
            text-decoration: none;
            margin: 0 10px;
            font-weight: bold;
        }
        .links a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="emoji">📚</div>
        <h1>PHP Database MVC 教材</h1>
        <p>MVCアーキテクチャを使用したPHPデータベース接続の学習プロジェクトへようこそ!</p>
        
        <div class="features">
            <h3>🎯 学習内容</h3>
            <ul>
                <li>MVCアーキテクチャの実践的な理解</li>
                <li>PHPでのデータベース接続(MySQLi)</li>
                <li>CRUD操作(作成・読取・更新・削除)</li>
                <li>プリペアドステートメント(SQLインジェクション対策)</li>
                <li>セッション管理の基礎</li>
                <li>エラーハンドリングとバリデーション</li>
            </ul>
        </div>

        <a href="run.php" class="button">🚀 アプリケーション起動</a>

        <div class="links">
            <a href="README.md" target="_blank">📖 README</a>
            <a href="SETUP.md" target="_blank">⚙️ セットアップガイド</a>
        </div>

        <p style="margin-top: 30px; font-size: 0.9em; color: #999;">
            <?php
            // PHP動作確認
            echo "PHP Version: " . phpversion() . " | ";
            echo "Server: " . $_SERVER['SERVER_SOFTWARE'];
            ?>
        </p>
    </div>
</body>
</html>
