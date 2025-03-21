# English Journal

## 📌 概要
ジャーナル作成を通じて、留学生が日々の勉強を楽しく続けられる環境を提供する学習支援ツール。
また、より日常会話や自分の気持ちを表現するための単語を増やす。単語に自分独自の温かみを作る。

## 🎯 主な機能
ジャーナル作成

日々の出来事を簡単に記録し、後から振り返れる。


語微強化

日本語から英語への変化と、より日常会話に適した単語や気持ちの表現をするための単語の増加。

進捗レポート

学習進捗を表示し、成長を可視化。

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
APP_NAME=Laravel
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_TIMEZONE=UTC
APP_URL=http://localhost

APP_LOCALE=en
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=en_US

APP_MAINTENANCE_DRIVER=file
# APP_MAINTENANCE_STORE=database

PHP_CLI_SERVER_WORKERS=4

BCRYPT_ROUNDS=12

LOG_CHANNEL=stack
LOG_STACK=single
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=sqlite
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=laravel
# DB_USERNAME=root
# DB_PASSWORD=

SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=null

BROADCAST_CONNECTION=log
FILESYSTEM_DISK=local
QUEUE_CONNECTION=database

CACHE_STORE=database
CACHE_PREFIX=

MEMCACHED_HOST=127.0.0.1

REDIS_CLIENT=phpredis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=log
MAIL_SCHEME=null
MAIL_HOST=127.0.0.1
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

VITE_APP_NAME="${APP_NAME}"


### 基本的な利用フロー
ログインする
その日の出来事を記録、日毎に記録する
ジャーナル作成
日毎の出来事の記録を見ながら、ジャーナル日本語で作成し、英語に変換する

進捗レポートを見る


## 🔧 今後の改善点




