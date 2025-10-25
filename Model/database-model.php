<?php
/**
 * DatabaseModel - Model層
 * データベース操作を担当するクラス
 * 
 * 役割:
 * - SQLクエリの実行
 * - データの取得・挿入・更新・削除
 * - テーブル操作
 */

class DatabaseModel {
    private $db;
    private $conn;

    /**
     * コンストラクタ
     * @param DatabaseConnection $db データベース接続オブジェクト
     */
    public function __construct($db) {
        $this->db = $db;
        $this->conn = $db->getConnection();
    }

    /**
     * usersテーブルを作成
     * @return bool 成功時true、失敗時false
     * @throws Exception テーブル作成失敗時
     */
    public function createUsersTable() {
        $sql = "CREATE TABLE IF NOT EXISTS users (
            id INT(11) AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            email VARCHAR(100) NOT NULL UNIQUE,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

        if ($this->conn->query($sql) === FALSE) {
            throw new Exception("テーブル作成エラー: " . $this->conn->error);
        }
        
        return true;
    }

    /**
     * テーブルからすべてのデータを取得
     * @param string $table テーブル名
     * @return array データの配列
     * @throws Exception クエリ失敗時
     */
    public function getAllData($table) {
        // SQLインジェクション対策: テーブル名のバリデーション
        if (!preg_match('/^[a-zA-Z0-9_]+$/', $table)) {
            throw new Exception("無効なテーブル名です");
        }

        $sql = "SELECT * FROM " . $table;
        $result = $this->conn->query($sql);
        
        if ($result === FALSE) {
            throw new Exception("データ取得エラー: " . $this->conn->error);
        }
        
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * usersテーブルにデータを挿入
     * @param string $name ユーザー名
     * @param string $email メールアドレス
     * @return int 挿入されたレコードのID
     * @throws Exception 挿入失敗時
     */
    public function insertUser($name, $email) {
        // プリペアドステートメントを使用(SQLインジェクション対策)
        $stmt = $this->conn->prepare("INSERT INTO users (name, email) VALUES (?, ?)");
        
        if ($stmt === FALSE) {
            throw new Exception("プリペアドステートメント作成エラー: " . $this->conn->error);
        }
        
        // パラメータをバインド
        $stmt->bind_param("ss", $name, $email);
        
        // 実行
        if ($stmt->execute() === FALSE) {
            throw new Exception("データ挿入エラー: " . $stmt->error);
        }
        
        $insertId = $stmt->insert_id;
        $stmt->close();
        
        return $insertId;
    }

    /**
     * IDでユーザーを検索
     * @param int $id ユーザーID
     * @return array|null ユーザーデータ、見つからない場合はnull
     * @throws Exception クエリ失敗時
     */
    public function getUserById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE id = ?");
        
        if ($stmt === FALSE) {
            throw new Exception("プリペアドステートメント作成エラー: " . $this->conn->error);
        }
        
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();
        
        return $user;
    }

    /**
     * ユーザーを更新
     * @param int $id ユーザーID
     * @param string $name 新しい名前
     * @param string $email 新しいメールアドレス
     * @return bool 成功時true
     * @throws Exception 更新失敗時
     */
    public function updateUser($id, $name, $email) {
        $stmt = $this->conn->prepare("UPDATE users SET name = ?, email = ? WHERE id = ?");
        
        if ($stmt === FALSE) {
            throw new Exception("プリペアドステートメント作成エラー: " . $this->conn->error);
        }
        
        $stmt->bind_param("ssi", $name, $email, $id);
        
        if ($stmt->execute() === FALSE) {
            throw new Exception("データ更新エラー: " . $stmt->error);
        }
        
        $stmt->close();
        return true;
    }

    /**
     * ユーザーを削除
     * @param int $id ユーザーID
     * @return bool 成功時true
     * @throws Exception 削除失敗時
     */
    public function deleteUser($id) {
        $stmt = $this->conn->prepare("DELETE FROM users WHERE id = ?");
        
        if ($stmt === FALSE) {
            throw new Exception("プリペアドステートメント作成エラー: " . $this->conn->error);
        }
        
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute() === FALSE) {
            throw new Exception("データ削除エラー: " . $stmt->error);
        }
        
        $stmt->close();
        return true;
    }
}
?>