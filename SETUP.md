# セットアップガイド

このガイドでは、XAMPPを使用してPHP Database MVC教材を起動する手順を詳しく説明します。

## 目次
1. [前提条件](#前提条件)
2. [XAMPPのインストール](#xamppのインストール)
3. [XAMPPの起動](#xamppの起動)
4. [データベースの作成](#データベースの作成)
5. [プロジェクトの配置](#プロジェクトの配置)
6. [動作確認](#動作確認)
7. [よくある質問](#よくある質問)

---

## 前提条件

- Windows 10/11
- インターネット接続(初回インストール時)
- 管理者権限(インストール時)

---

## XAMPPのインストール

### ステップ1: XAMPPのダウンロード

1. ブラウザで [https://www.apachefriends.org/jp/index.html](https://www.apachefriends.org/jp/index.html) にアクセス
2. 「Windows向けXAMPP」をクリック
3. 最新版(PHP 8.x推奨)をダウンロード

### ステップ2: インストール実行

1. ダウンロードした `xampp-windows-x64-x.x.x-x-VS16-installer.exe` を実行
2. セキュリティ警告が表示されたら「実行」をクリック
3. User Account Control(UAC)の警告が表示されたら「はい」をクリック

### ステップ3: インストール設定

1. **Select Components** 画面:
   - ☑ Apache
   - ☑ MySQL
   - ☑ PHP
   - ☑ phpMyAdmin
   - その他はオプション(任意)

2. **Installation folder** 画面:
   - デフォルト: `C:\xampp`
   - 変更可能ですが、パスに日本語や空白を含めないこと

3. **Language** 画面:
   - 「English」を選択(日本語版はありません)

4. 「Next」→「Next」→「Finish」でインストール完了

---

## XAMPPの起動

### ステップ1: XAMPP Control Panelを開く

1. スタートメニューから「XAMPP Control Panel」を検索して起動
2. または `C:\xampp\xampp-control.exe` を実行

### ステップ2: サービスの起動

1. **Apache** の行の「Start」ボタンをクリック
   - 緑色のハイライトで「Running」と表示されればOK
   
2. **MySQL** の行の「Start」ボタンをクリック
   - 緑色のハイライトで「Running」と表示されればOK

### ポート競合エラーが出た場合

**問題**: Apache起動時に「Port 80 in use」エラー

**解決策**:
```
1. XAMPP Control Panelの「Config」→「Apache (httpd.conf)」を開く
2. 「Listen 80」を「Listen 8080」に変更
3. 「ServerName localhost:80」を「ServerName localhost:8080」に変更
4. ファイルを保存してApacheを再起動
5. ブラウザで「http://localhost:8080」でアクセス
```

**問題**: MySQL起動時に「Port 3306 in use」エラー

**解決策**:
```
1. タスクマネージャーで他のMySQLサービスを停止
2. またはXAMPP Control Panelの「Config」→「my.ini」でポート変更
```

---

## データベースの作成

### 方法1: phpMyAdminを使用(推奨)

1. ブラウザで `http://localhost/phpmyadmin` にアクセス

2. 左サイドバーの「新規作成」をクリック

3. データベース作成:
   - **データベース名**: `testdb`
   - **照合順序**: `utf8mb4_general_ci`
   - 「作成」ボタンをクリック

4. SQLファイルのインポート(オプション):
   - 作成した`testdb`を選択
   - 上部メニューの「インポート」タブをクリック
   - 「ファイルを選択」から`database.sql`を選択
   - 「実行」ボタンをクリック

### 方法2: SQLファイルを直接実行

1. phpMyAdminの「SQL」タブをクリック

2. `database.sql`の内容をコピー&ペースト

3. 「実行」ボタンをクリック

---

## プロジェクトの配置

### 方法1: ファイルをコピー(初心者推奨)

1. エクスプローラーで `c:\Users\jyori\Desktop\PHP-system\php-database` フォルダを開く

2. フォルダ全体をコピー

3. `C:\xampp\htdocs\` に貼り付け

4. 最終的なパス: `C:\xampp\htdocs\php-database\`

### 方法2: PowerShellでコピー

```powershell
# PowerShellを開いて実行
Copy-Item -Recurse "c:\Users\jyori\Desktop\PHP-system\php-database" "C:\xampp\htdocs\php-database"
```

### 方法3: シンボリックリンク(上級者向け)

```powershell
# 管理者権限でPowerShellを開いて実行
New-Item -ItemType SymbolicLink -Path "C:\xampp\htdocs\php-database" -Target "c:\Users\jyori\Desktop\PHP-system\php-database"
```

**メリット**: 元のフォルダを編集すると自動的にhtdocsにも反映される

---

## 動作確認

### ステップ1: アクセス確認

ブラウザで以下のURLにアクセス:
```
http://localhost/php-database/run.php
```

### ステップ2: 接続テスト

1. フォームに以下を入力:
   - **サーバー名**: `localhost`
   - **ユーザー名**: `root`
   - **パスワード**: (空欄)
   - **データベース名**: `testdb`

2. 「接続する」ボタンをクリック

3. 「データベースに正常に接続しました!」と表示されればOK

### ステップ3: 機能テスト

1. **テーブル作成**: 「テーブルを作成」ボタンをクリック

2. **ユーザー追加**:
   - 名前: `テストユーザー`
   - メール: `test@example.com`
   - 「ユーザーを追加」ボタンをクリック

3. **データ確認**: 「ユーザー一覧を表示」ボタンをクリック

4. テーブルにデータが表示されればOK

---

## よくある質問

### Q1: 「XAMPP Control Panel」が見つからない

**A**: 
- スタートメニューで「xampp」と検索
- または直接 `C:\xampp\xampp-control.exe` を実行
- デスクトップにショートカットを作成することを推奨

### Q2: Apacheが起動しない

**A**: 
1. ポート80が他のアプリケーションで使用されていないか確認
2. Skype、IIS、Windowsの「World Wide Web Publishing Service」を停止
3. セキュリティソフトがブロックしていないか確認

### Q3: MySQLが起動しない

**A**: 
1. ポート3306が他のMySQLサービスで使用されていないか確認
2. タスクマネージャーで「MySQL」プロセスを終了
3. XAMPP Control Panelで「Config」→「my.ini」を確認

### Q4: phpMyAdminにアクセスできない

**A**: 
1. Apacheが起動しているか確認
2. URLが正しいか確認: `http://localhost/phpmyadmin`
3. ポートを変更した場合: `http://localhost:8080/phpmyadmin`

### Q5: 「データベース接続エラー」が表示される

**A**: 
1. MySQLが起動しているか確認
2. データベース名が正しいか確認(testdb)
3. phpMyAdminで`testdb`が作成されているか確認

### Q6: 日本語が文字化けする

**A**: 
1. データベースの照合順序を`utf8mb4_general_ci`に変更
2. ブラウザの文字コードをUTF-8に設定
3. PHPファイルがUTF-8(BOMなし)で保存されているか確認

---

## 🎓 次のステップ

セットアップが完了したら:

1. [README.md](README.md)で教材の使い方を確認
2. 各ファイルのコードを読んで理解を深める
3. 機能を追加してカスタマイズしてみる

---

## 🆘 サポート

問題が解決しない場合:

1. エラーメッセージをメモ
2. XAMPPのエラーログを確認: `C:\xampp\apache\logs\error.log`
3. ブラウザの開発者ツール(F12)でコンソールエラーを確認

---

**Good Luck! **
