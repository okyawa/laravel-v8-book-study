『PHP フレームワーク Laravel Webアプリケーション開発 バージョン8.x対応』本のサンプルコードを写経したもの

- [サンプルコード掲載のGitHubリポジトリ一覧 | laravel-socym2021 - GitHub](https://github.com/laravel-socym2021)




---




## 初期設定

- `.env.example` をコピーして `.env` を設置し、伏せ字の部分を指定




## ローカルサーバの操作


### ローカルサーバの起動

```sh
make up
```

### ローカルサーバの停止

```sh
make down
```

### PHPのローカルサーバのシェルに入る

```sh
make shell
```

### MySQLに入る

```sh
make mysql
```

### テストの実行

#### 全てのテストを実行
```sh
make test
```

#### 特定のテストファイルだけを実行
```sh
make test path=テストファイルのパス
```




## 7-2-5 で使うwkhtmltopdfをLaravel Sail内にインストール


### rootでシェルに入る

- root用のsailコマンドを使い、コンテナ内のシェルに入る
```sh
sail root-shell
```

### ダウンロード

- https://wkhtmltopdf.org/downloads.html
- `Stable` にある `Ubuntu` で `amd64` のリンクURLをコピーし、`curl` コマンドでダウンロード
```sh
cd /usr/local/src
curl -OL https://github.com/wkhtmltopdf/packaging/releases/download/0.12.6-1/wkhtmltox_0.12.6-1.focal_amd64.deb
```


### gdebiのインストール

- debパッケージの依存関係を解決してくれる `gdebi` をインストール
```sh
apt update
apt --fix-broken install
apt install gdebi
```


### wkhtmltopdfをdebパッケージからインストール

```sh
gdebi ./wkhtmltox_0.12.6-1.focal_amd64.deb
```

- `/usr/local/bin/wkhtmltopdf` にインストールされる



