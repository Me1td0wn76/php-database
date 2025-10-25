<?php
/**
 * DatabaseConnection - Controller層
 * データベース接続を管理するクラス
 * 
 * 役割:
 * - データベースへの接続確立
 * - 接続エラーハンドリング
 * - コネクションの管理
 */

class DatabaseConnection {
    private $servername;
    private $username;
    private $password;
    private $dbname;
    public $conn;

    /**
     * コンストラクタ
     * @param string $servername サーバー名
     * @param string $username ユーザー名
     * @param string $password パスワード
     * @param string $dbname データベース名
     */
    public function __construct($servername, $username, $password, $dbname) {
        $this->servername = $servername;
        $this->username = $username;
        $this->password = $password;
        $this->dbname = $dbname;
        $this->connect();
    }

    /**
     * データベース接続を確立
     * @throws Exception 接続失敗時
     */
    private function connect() {
        // MySQLi接続の作成
        $this->conn = new mysqli(
            $this->servername, 
            $this->username, 
            $this->password, 
            $this->dbname
        );
        
        // 接続エラーチェック
        if ($this->conn->connect_error) {
            throw new Exception("接続失敗: " . $this->conn->connect_error);
        }
        
        // 文字コード設定(UTF-8)
        $this->conn->set_charset("utf8mb4");
    }

    /**
     * 接続を取得
     * @return mysqli データベース接続
     */
    public function getConnection() {
        return $this->conn;
    }

    /**
     * 接続を閉じる
     */
    public function close() {
        if ($this->conn) {
            $this->conn->close();
        }
    }

    /**
     * デストラクタ
     * オブジェクト破棄時に自動的に接続を閉じる
     */
    public function __destruct() {
        $this->close();
    }
}
?>