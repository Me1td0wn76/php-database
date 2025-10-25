<?php
/**
 * DatabaseService - Service層
 * ビジネスロジックを担当するクラス
 * 
 * 役割:
 * - データの検証
 * - ビジネスルールの適用
 * - Model層とView層の仲介
 * - 複雑な処理のオーケストレーション
 */

class DatabaseService {
    private $dbModel;

    /**
     * コンストラクタ
     * @param DatabaseModel $dbModel データベースモデル
     */
    public function __construct($dbModel) {
        $this->dbModel = $dbModel;
    }

    /**
     * usersテーブルを作成
     * @return bool 成功時true
     */
    public function createUsersTable() {
        return $this->dbModel->createUsersTable();
    }

    /**
     * すべてのユーザーを取得
     * @return array ユーザーデータの配列
     */
    public function getAllUsers() {
        return $this->dbModel->getAllData('users');
    }

    /**
     * 新しいユーザーを追加
     * @param string $name ユーザー名
     * @param string $email メールアドレス
     * @return int 挿入されたユーザーのID
     * @throws Exception バリデーションエラーまたは挿入エラー時
     */
    public function insertUser($name, $email) {
        // ビジネスロジック: データの検証
        $this->validateUserData($name, $email);
        
        // メールアドレスの正規化(小文字化)
        $email = strtolower(trim($email));
        $name = trim($name);
        
        // Model層にデータを渡す
        return $this->dbModel->insertUser($name, $email);
    }

    /**
     * ユーザーデータの検証
     * @param string $name ユーザー名
     * @param string $email メールアドレス
     * @throws Exception バリデーションエラー時
     */
    private function validateUserData($name, $email) {
        // 名前の検証
        if (empty($name) || strlen($name) < 2) {
            throw new Exception("名前は2文字以上である必要があります");
        }
        
        if (strlen($name) > 100) {
            throw new Exception("名前は100文字以下である必要があります");
        }
        
        // メールアドレスの検証
        if (empty($email)) {
            throw new Exception("メールアドレスは必須です");
        }
        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("有効なメールアドレスを入力してください");
        }
        
        if (strlen($email) > 100) {
            throw new Exception("メールアドレスは100文字以下である必要があります");
        }
    }

    /**
     * IDでユーザーを検索
     * @param int $id ユーザーID
     * @return array|null ユーザーデータ
     */
    public function getUserById($id) {
        if (!is_numeric($id) || $id < 1) {
            throw new Exception("無効なユーザーIDです");
        }
        
        return $this->dbModel->getUserById($id);
    }

    /**
     * ユーザー情報を更新
     * @param int $id ユーザーID
     * @param string $name 新しい名前
     * @param string $email 新しいメールアドレス
     * @return bool 成功時true
     */
    public function updateUser($id, $name, $email) {
        // IDの検証
        if (!is_numeric($id) || $id < 1) {
            throw new Exception("無効なユーザーIDです");
        }
        
        // データの検証
        $this->validateUserData($name, $email);
        
        // データの正規化
        $email = strtolower(trim($email));
        $name = trim($name);
        
        return $this->dbModel->updateUser($id, $name, $email);
    }

    /**
     * ユーザーを削除
     * @param int $id ユーザーID
     * @return bool 成功時true
     */
    public function deleteUser($id) {
        // IDの検証
        if (!is_numeric($id) || $id < 1) {
            throw new Exception("無効なユーザーIDです");
        }
        
        return $this->dbModel->deleteUser($id);
    }

    /**
     * ユーザー統計情報を取得
     * @return array 統計情報
     */
    public function getUserStatistics() {
        $users = $this->getAllUsers();
        
        return [
            'total_users' => count($users),
            'latest_user' => !empty($users) ? end($users) : null,
            'user_emails' => array_column($users, 'email')
        ];
    }
}
?>