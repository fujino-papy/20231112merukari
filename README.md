# coachtechフリマ
・概要説明

自社独自のフリマアプリです

会員登録をしていない場合、出品されている商品の一覧・商品のキーワード検索と、商品詳細・コメントの閲覧が可能です。

会員登録を行うことで、商品の出品・購入、コメントと登録・お気に入り機能・ユーザー情報の登録・マイページの利用などが可能になります。

お気に入りを登録することで、商品一覧ページのマイリストタグでお気に入り商品のみ表示することも可能です。

マイページでは出品した商品と購入した商品の一覧が閲覧できます。

購入に関してはコンビニ払いとクレジットカード払いの２つが選択できます。

購入画面で直接住所変更を行うことも可能です。

![Alt text](<スクリーンショット 2023-12-22 040410.png>)

## 作成した目的
自社ブランド商品の拡販のために自社ブランド商品の出品数を確保し宣伝を狙うため

自社独自のシステムを作成しました。

## アプリケーションURL
http://localhost/

商品一覧ページが表示されます。

右上の「会員登録」をクリックすると会員登録画面に遷移するので会員登録を行ってください。

会員登録を行わなくても商品詳細やコメント等閲覧は可能です。

## 他のリポジトリ
このほかにリポジトリはありません。

## 機能一覧
・会員登録

・ログイン

・ログアウト

・商品一覧取得

・商品詳細取得

・ユーザ商品お気に入り一覧取得

・ユーザ情報取得

・ユーザ購入商品一覧取得

・ユーザ出品商品一覧取得

・プロフィール変更

・商品お気に入り追加

・商品お気に入り削除

・商品コメント追加

・商品コメント削除

・出品

・購入

・配送先変更

## 使用技術
・Laravel Framework 8.83.27

・Mysql

。stripe

## テーブル設計
![Alt text](<スクリーンショット 2023-12-22 040539.png>)

## ER図
![Alt text](<スクリーンショット 2023-12-22 045239.png>)

## 環境構築
1. 必要なソフトウェア

・PHP

・Composer

・NPM

・MySQL

2. プロジェクトのクローン

GitHubからプロジェクトをクローンします。

git clone https://github.com/fujino-papy/20231112merukari.git

3. パッケージのインストール

cd coachtech/ouyou/merukari

composer install

npm install

4. 環境変数の設定

.env.example ファイルをコピーして .env ファイルを作成し、必要な設定を行ってください。

cp .env.example .env

5. アプリケーションキーの生成

php artisan key:generate

6. データベースのマイグレーション・シーディング

php artisan migrate

php artisan db:seed

7. Stripeキーの設定

StripeのAPIキーを .env ファイルに追加してください。

STRIPE_KEY=pk_test_51ODq37H8tlSpwIEwscawyzv0ZjECOiHqmljeLWjarGb1JU8hqplWJrC0rWHSrrtQftlEXSB8vl6lwxN6R5a1cQmN00VLRoOcn5

STRIPE_SECRET=sk_test_51ODq37H8tlSpwIEwBms4lG8lVmCCibXNsSWZCgwMiOUI40j4cY3NSUix2zaWLweILnit0xH02nPzmSIY0rhy4EMJ00ActSFwj0

//テスト環境用キーです。

8. アプリケーションの起動

php artisan serve


## その他
テスト環境

Googlechrome・Microsoft Edge・Firefox

上記３種のブラウザで動作確認済み
