-- ================================================
-- PHP Database MVC 教材用 SQLファイル
-- ================================================
-- このファイルをphpMyAdminで実行することで、
-- データベースとテーブルを自動的に作成できます
-- ================================================

-- データベースの作成
CREATE DATABASE IF NOT EXISTS testdb
CHARACTER SET utf8mb4
COLLATE utf8mb4_general_ci;

-- データベースを選択
USE testdb;

-- usersテーブルの作成
CREATE TABLE IF NOT EXISTS users (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_email (email),
    INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- サンプルデータの挿入(オプション)
-- 以下のコメントを外すとサンプルデータが挿入されます
/*
INSERT INTO users (name, email) VALUES
('山田太郎', 'yamada@example.com'),
('佐藤花子', 'sato@example.com'),
('鈴木一郎', 'suzuki@example.com'),
('田中美咲', 'tanaka@example.com'),
('高橋健太', 'takahashi@example.com');
*/

-- テーブル情報の確認
DESCRIBE users;

-- データベースの確認
SELECT 'データベースとテーブルが正常に作成されました！' AS status;
