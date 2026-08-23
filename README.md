## dorango-farm-custom

### 初回セットアップ

#### hosts

`/etc/hosts`

```text
127.0.0.1 dorango-farm.com
127.0.0.1 www.dorango-farm.com
```

#### 証明書

```bash
brew install mkcert nss
./docker/setup-certs.sh
```

### 起動

```bash
docker compose up -d
npm install
npm run build
```

| URL | |
| --- | --- |
| https://dorango-farm.com | サイト |
| http://localhost:8081 | phpMyAdmin |

#### 開発（watch）

```bash
# 既に起動中なら Ctrl+C で止めてから
docker compose up -d
npm run dev
```

→ https://dorango-farm.com

CSS / JS は本番と同じく圧縮して `assets/` に出力する。変更したらブラウザをリロードする。

#### 停止

```bash
docker compose down
```

### 本番 DB → ローカル

#### 1. サーバーでダンプ

```bash
ssh lolipop
mysqldump -h mysql135.phy.lolipop.lan -u LAA1032812 -p LAA1032812-xv5kw6 > ~/dump-prod.sql
ls -lh ~/dump-prod.sql
exit
```

#### 2. Mac へ転送

```bash
rsync -avz lolipop:dump-prod.sql ~/code/dorango-farm-custom/sql/dump-prod.sql
ls -lh ~/code/dorango-farm-custom/sql/dump-prod.sql
```

#### 3. Docker に投入

```bash
cd ~/code/dorango-farm-custom

docker compose exec -T db mysql -uwordpress -pwordpress -e "
DROP DATABASE IF EXISTS wordpress;
CREATE DATABASE wordpress CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
"

docker compose exec -T db mysql -uwordpress -pwordpress wordpress \
  < sql/dump-prod.sql
```

#### 4. 確認

https://dorango-farm.com/
