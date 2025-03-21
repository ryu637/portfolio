# GUILD

## 📌 概要


## 🎯 主な機能


## 🛠 使用技術
- **フロントエンド:** HTML / CSS / JavaScript / Bootstrap 
- **バックエンド:** PHP / Laravel 
- **データベース:** MySQL
- **その他:** Font Awesome / Chart js

## 📥 インストール方法
```bash
# リポジトリをクローン
git clone https://github.com/Kenta2360/guild-app.git
cd guild-app

# 1. 依存関係をインストール (Laravelのパッケージ)
composer install

# 2. 環境設定ファイルを作成
cp .env.example .env

# 3. アプリケーションキーを生成
php artisan key:generate

# 4. 設定をクリアして反映
php artisan config:clear
php artisan cache:clear

# 6. npm 依存関係をインストール (フロントエンド)
npm install && npm run dev

# 7. (必要なら) 本番環境用のビルド
npm run build

# 8. 開発サーバーを起動
php artisan serve
```

## 📊 ERD（データベース設計）
このプロジェクトのデータベース構造は以下の通りです。



## ⚙️ 環境設定 (.env)
以下の環境変数を `.env` に設定してください。


## 💡 使用方法

### 基本的な利用フロー



## 🔧 今後の改善点



