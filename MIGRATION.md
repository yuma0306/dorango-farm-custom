# サイト改修・移行手順

WordPress 更新、ACF Pro（Flexible Content）から Gutenberg への移行、ローカル環境の Docker + Vite 化についての手順書。

## ゴール

| 項目 | 現状 | 目標 |
| --- | --- | --- |
| ローカル環境 | Gulp + 本番寄りの構成 | Docker + Vite |
| 記事本文 | ACF Pro Flexible Content（`flexible_field`） | Gutenberg ブロック |
| メタ情報など | ACF（タイトル・OGP・canonical・noindex・サムネ等） | ACF **無料版**のまま継続 |
| WordPress 本体 | 本番バージョンが古い（ローカルは 6.4.1） | 移行完了後にアップデート |
| 本番適用 | 直接上書き | 必要に応じて `web_new` を用意して入れ替え |

## 全体方針（重要）

- **DB を一発で切り替えるのではなく、記事単位で段階移行する**
- ACF に表示切替用チェックボックスを用意し、ON の記事だけ Gutenberg 本文を表示する
- WordPress 本体のアップデートは、Gutenberg 移行が落ち着いてから行う
- 本番適用前に、Docker ローカルで必ず検証する

```text
1. Docker + Vite（検証環境）
2. Gutenberg 両対応コード + 切替フラグ
3. 記事を少しずつ ACF Flexible → Gutenberg へ移行
4. 全記事移行後に ACF Pro を外して Free 化
5. WordPress / プラグイン更新
6. 本番適用
```

---

## 現状の整理（このプロジェクト）

### ACF Pro が必要な部分（本文）

- フィールド: `flexible_field`
- 出力: `getAcfArticle()` / 目次 `createToc()`（`functions/helper.php`）
- テンプレート: `single.php` など
- レイアウト例（`wp-content/themes/dorango-farm-custom/acf/`）:
  - `h2_layout` / `h3_layout` / `h4_layout`
  - `wysiwyg_layout`
  - `img_layout`
  - `dl_layout`
  - `balloon_layout`
  - `embed_layout`
  - `aspect_layout`
  - `post_layout`

### ACF 無料版で足りる部分（メタ・共通）

- `meta_title_field` などメタ系
- `canonical_field` / `og_url_field` / `og_image_field`
- `noindex_field` / `nofollow_field`
- `thumb_field`（アイキャッチ相当）

### Gutenberg の現状

- `functions/editor.php` の `allowed_block_types_all` で、ほぼ shortcode 以外を禁止している
- 本文編集は ACF Flexible 前提

---

## Phase 1: Docker + Vite 化

> 実装済み（骨格）。以下は使い方と確認項目。

### 1-1. Docker（本番ドメイン + HTTPS）

ローカルでも `https://dorango-farm.com` で開く。URL 置換は不要。

**hosts は毎回編集しない**

`/etc/hosts` に一度追加すれば永続する。本番サイトを見たいときだけコメントアウトする。

```text
127.0.0.1 dorango-farm.com
127.0.0.1 www.dorango-farm.com
```

**証明書（初回）**

```bash
brew install mkcert nss
./docker/setup-certs.sh
```

**起動**

1. Docker Desktop を起動する
2. 起動:

```bash
# Docker Desktop を起動してから
docker compose up -d

npm install
npm run build   # または npm run dev
```

- サイト: https://dorango-farm.com （Caddy）
- phpMyAdmin: http://localhost:8081
- `wordpress` + `mysql` + `caddy` + `phpMyAdmin`
- `wp-config.php` は Docker 時に DB だけ環境変数化。**WP_HOME は上書きしない**
- テーブル接頭辞は本番同様 `wp1_`

DB 投入例:

```bash
docker compose exec -T db mysql -uwordpress -pwordpress wordpress < sql/your-dump.sql
```

本番 URL のままダンプしている場合は、管理画面または WP-CLI で `localhost:8080` へ置換する。

### 1-2. Vite（Gulp 置き換え済み）

```bash
npm install
npm run dev    # 圧縮ビルドを watch
npm run build  # assets/css・assets/js へ圧縮出力
```

- 入口: `src/scss/*.scss` / `src/js/*.js`
- 出力: `wp-content/themes/dorango-farm-custom/assets/`
- CSS は開発・本番とも圧縮して `<style>` でインライン
- 画像 WebP 変換は未移植（既存 `assets/img` を利用）

### 1-3. 起動確認チェック

- [ ] `docker compose up -d` で WP が起動する
- [ ] DB ダンプ投入後、管理画面にログインできる
- [ ] トップ・記事・問い合わせが表示される
- [ ] `npm run build` 後、CSS/JS が更新される
- [ ] `npm run dev` 中に CSS/JS を変更すると圧縮ファイルが再出力される

---

## Phase 2: ACF Free 化の準備（Gutenberg 両対応）

### 2-1. 表示切替フラグを追加

ACF に True/False フィールドを追加する。

| 項目 | 値の例 |
| --- | --- |
| フィールド名 | `use_gutenberg_field` |
| ラベル | 新しい編集方式（ブロック）で表示する |
| 対象 | 記事（カスタム投稿タイプ含む、本文を Flexible で書いているもの） |

### 2-2. テンプレートを分岐する

`single.php` などで:

```php
if (get_field('use_gutenberg_field')) {
    the_content();
} else {
    getAcfArticle();
}
```

目次も同様に分岐する。

```php
if (get_field('use_gutenberg_field')) {
    // post_content 内の h2/h3 から生成
} else {
    createToc(); // 既存の ACF Flexible 版
}
```

安全策（任意）:

- フラグ ON かつ `post_content` が空の場合は旧 ACF を表示し、管理画面で警告する

### 2-3. Gutenberg を使えるようにする

- `allowed_block_types_all` を緩和し、必要なコアブロックを許可する
- 候補: `core/heading`, `core/paragraph`, `core/image`, `core/list`, `core/list-item`, `core/embed`, `core/html` など

### 2-4. ACF layout → ブロック対応

| 現在の ACF layout | Gutenberg 側の候補 |
| --- | --- |
| `h2/h3/h4_layout` | `core/heading` |
| `wysiwyg_layout` | `core/paragraph` / `core/list` など |
| `img_layout` | `core/image`（キャプション付き） |
| `embed_layout` | `core/embed` / `core/html` |
| `dl_layout` | 独自ブロック or HTML |
| `balloon_layout` | **独自ブロック推奨** |
| `aspect_layout` | 独自 or `core/embed` |
| `post_layout` | 独自ブロック推奨 |

コアだけで難しいのは、おおむね **吹き出し・定義リスト・関連記事カード**。

### 2-5. Phase 2 完了条件

- [ ] フラグ OFF の記事は従来どおり表示される
- [ ] フラグ ON の記事は Gutenberg 本文が表示される
- [ ] 目次が両方のモードで動く
- [ ] 独自ブロックが必要な見た目を再現できる
- [ ] メタタグ・OGP・サムネは従来どおり ACF で動く

---

## Phase 3: 記事の移行（段階的）

### 進め方

1. 優先度の高い記事から Gutenberg で本文を組み直す
2. プレビュー確認後、`use_gutenberg_field` を ON
3. 問題があればフラグを OFF に戻す（記事単位ロールバック）
4. 未移行記事がなくなるまで繰り返す

### 移行手段

- 記事数が少なければ: 手動で再構築（確実）
- 多ければ: 変換スクリプト / WP-CLI で Flexible → `post_content` へ半自動変換  
  ※ 必ずローカル DB でドライランしてから使う

### 運用メモ

- 管理画面で「未移行記事」を絞り込めると安心
- 新記事は最初から Gutenberg（フラグ ON）で書く運用に切り替える

### Phase 3 完了条件

- [ ] 対象記事がすべてフラグ ON
- [ ] Flexible Content を表示に使っている記事がゼロ
- [ ] 主要テンプレート・目次・内部リンクを目視確認済み

---

## Phase 4: ACF Pro → Free 化

### 手順

1. フィールドグループを整理する
   - 残す: meta / og / canonical / noindex / thumb /（必要なら切替フラグ）
   - 削除予定: `flexible_field`
2. テーマから本文用の `have_rows` / `get_sub_field` / `acf/*_layout.php` 経路を削除（または到達不能にする）
3. ローカルで ACF Pro を無効化し、ACF 無料版を有効化
4. メタ類・サムネ・管理画面編集を確認
5. 問題なければ、フラグ自体も廃止して常に `the_content()` にする（任意・最終形）

### Phase 4 完了条件

- [ ] ACF Pro なしでサイトが表示・編集できる
- [ ] Flexible Content 依存コードが残っていない
- [ ] メタタグ・OGP が正しい

---

## Phase 5: WordPress アップデート

Gutenberg 移行と ACF Free 化が安定してから実施する。

1. DB / ファイルのバックアップを取る
2. ローカルでコア更新（管理画面 or WP-CLI）
3. プラグイン更新
4. トップ・記事・フォーム・編集画面を確認
5. 問題なければ本番も同じ手順で更新

```bash
# WP-CLI 例
wp core version
wp core check-update
wp core update
wp core update-db
wp plugin update --all
wp language core update
```

### Phase 5 完了条件

- [ ] ローカルで更新後も表示・編集に問題がない
- [ ] 本番更新手順がローカルで再現できている

---

## Phase 6: 本番適用

### 基本方針

ファイル差し替えだけだと不十分なケースがある（記事データや設定が DB 側のため）。  
ただし、本手順では **記事移行を本番上で段階的に進める**前提なので、最終盤のコード適用と WP 更新が主対象になる。

### `web_new` 入れ替え（ファイル切替）

ロリポップではドキュメントルートが `~/web` の想定。

```bash
# 事前に新ファイルを配置
cp -a web web_new
# web_new 側へテーマ反映・必要ファイル配置

# メンテ中に切替
mv web web_old
mv web_new web
```

戻し:

```bash
mv web web_ng
mv web_old web
```

注意:

- `uploads` は共有するか、切替直前に同期する
- `wp-config.php` の DB 接続先を間違えない
- `.htaccess` / パーマリンクを確認する
- 環境によって symlink 切替の方が戻しやすい場合あり

### DB について

- 記事の Gutenberg 化を本番で段階実施している場合、最終切替時の DB 一括入れ替えは必須ではない
- それでも **更新直前のフルバックアップは必須**
- WP コア更新失敗時は、ファイル戻し + DB バックアップ復元をセットで行う

### 本番スモークテスト

- [ ] トップ
- [ ] 代表記事（旧移行済み / 新規）
- [ ] 目次
- [ ] OGP / meta
- [ ] 問い合わせフォーム
- [ ] 管理画面での記事編集

---

## リスクと回避策

| リスク | 回避策 |
| --- | --- |
| フラグ ON なのに本文が空 | フォールバック表示 + 公開前チェック |
| 独自見た目が再現できない | balloon / dl / post を先にブロック化 |
| ACF Free 化が早すぎる | 全記事移行完了まで Pro を残す |
| WP 更新と移行を同時にやる | 移行完了後に更新する（本手順の順序） |
| 本番で戻せない | 記事単位フラグ OFF、`web_old` 保持、DB バックアップ |

---

## 作業ログ（任意）

実施したら日付と結果を追記する。

| 日付 | Phase | 内容 | 結果 |
| --- | --- | --- | --- |
|  | 1 | Docker + Vite |  |
|  | 2 | 切替フラグ / 両対応 |  |
|  | 3 | 記事移行 |  |
|  | 4 | ACF Free 化 |  |
|  | 5 | WP アップデート |  |
|  | 6 | 本番適用 |  |
