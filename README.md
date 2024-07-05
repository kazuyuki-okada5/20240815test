アプリケーション名

### メルカリ風フリマアプリ

### サービス名
coachtechフリマ
![TOP画像](./src/images/top-image.png)

## 制作背景と目的

自社ブランドの商品を出品する

### 概要説明
 　使用者の区分は3つに分けられ、1.来訪者（Visitors）、2.会員登録者（Users）、3.管理者（Admins）となり各区分で利用できる機能は下記「機能一覧表」参照して下さい。

機能一覧
| NO.  | 項目            | 役割                                    | 権限                   |
| ----- | -------------- | -------------------------------------- | --------------------- |
|   1  | 会員登録         | アカウントを登録                          | 来訪者                 |
|   2  | 商品閲覧         | 販売した全ての商品を閲覧                   | 来訪者+会員登録者+管理者  |
|   3  | 販売中商品閲覧    | 販売中の商人を閲覧                        | 来訪者+会員登録者+管理者  |
|   4  | 商品詳細閲覧      | 商品の詳細を閲覧                         | 来訪者+会員登録者+管理者 |
|   5  | 商品コメント閲覧  | 商品に対するやり取りを閲覧                  | 来訪者+会員登録者+管理者 |
|   6  | 商品検索         | 検索バーで商品検索                        | 来訪者+会員登録者+管理者 |
|   7  | ログイン         | アカウントの利用を開始                    | 会員登録者+管理者      |
|   8  | ログアウト       | アカウントの利用を終了                     | 会員登録者+管理者       |
|   9  | マイページ作成    | アカウント詳細を作成                      | 会員登録者+管理者       |
|  10  | マイページ表示    | アカウント詳細を表示                      | 会員登録者+管理者       |
|  11  | マイページ編集    | アカウント詳細を編集                      | 会員登録者+管理者       |
|  12  | 商品マイリスト閲覧 | お気に入り登録した商品一覧表示             | 会員登録者+管理者       |
|  13  | 出品した商品表示   | ログイン者が出品した商品一覧表示           | 会員登録者+管理者       |
|  14  | 購入した商品表示   | ログイン者が購入した商品一覧表示           | 会員登録者+管理者       |
|  15  | 出品             | 商品を出品する                          | 会員登録者+管理者       |
|  16  | 購入             | 商品を購入する                          | 会員登録者+管理者       |
|  17  | 商品コメント作成   | 商品に対してコメントを追加                | 会員登録者+管理者       |
|  18  | 支払い方法変更     | クレジットカード、コンビニ、銀行振込から選択 | 会員登録者+管理者       |
|  19  | 配送先変更        | 任意の配送先に変更することができる          | 会員登録者+管理者       |
|  18  | お気に入り登録/削除 | 商品をマイリストに登録/削除               | 会員登録者+管理者      |
|  19  | 商品コメント削除   | コメントを削除                          | 管理者                |
|  20  | ユーザー削除       | アカウントを削除                        | 管理者                |
|  21  | メール送信        | アカウント登録者全員にメール送信           | 管理者                |
|  22  | ユーザー一覧表示   | アカウント登録者全員を閲覧                | 管理者                |

注記
　NO. 5：コメントはNO.4商品詳細閲覧画面何の吹き出しアイコンをクリックすると表示します。
　NO. 6：商品検索後も検索ワードは枠内で維持されたままになります。
　NO.15：出品時のカテゴリーは最大3つまで選択可能です
　NO.19：配送先はデフォルトでアカウントの住所が入力されています。（アカウント詳細を作成していない場合は未記載）
　　　　　変更する場合は変更先住所登録後、配送先を指定し直してから購入して下さい。