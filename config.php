<?php
/**
 * 設定ファイル
 * データベース接続情報などを一元管理
 */

// データベース設定
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'testdb');

// アプリケーション設定
define('APP_NAME', 'PHP Database MVC 教材');
define('APP_VERSION', '1.0.0');

// 開発環境設定
define('DEBUG_MODE', true);

// タイムゾーン設定
date_default_timezone_set('Asia/Tokyo');

// エラー表示設定
if (DEBUG_MODE) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

// 文字コード設定
mb_internal_encoding('UTF-8');
mb_http_output('UTF-8');
?>
