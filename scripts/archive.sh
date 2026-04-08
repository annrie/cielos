#!/bin/bash
# 本番用テーマアーカイブ作成スクリプト

set -e

# 変数設定
THEME_DIR="$(cd "$(dirname "$0")/.." && pwd)"
THEME_NAME="cielos"
DATE=$(date +%Y%m%d)
ARCHIVE_DIR="${THEME_DIR}/packaged"
ARCHIVE_NAME="${THEME_NAME}-${DATE}.zip"
TEMP_DIR="${ARCHIVE_DIR}/.temp-${THEME_NAME}"

# 色付きログ
log_info() { echo -e "\033[1;34m[INFO]\033[0m $1"; }
log_success() { echo -e "\033[1;32m[SUCCESS]\033[0m $1"; }
log_error() { echo -e "\033[1;31m[ERROR]\033[0m $1"; }

# packaged ディレクトリを作成
log_info "packaged ディレクトリを準備中..."
mkdir -p "${ARCHIVE_DIR}"

# 一時ディレクトリをクリーンアップ
rm -rf "${TEMP_DIR}"
mkdir -p "${TEMP_DIR}/${THEME_NAME}"

# 本番用ファイルをコピー
log_info "本番用ファイルをコピー中..."

# PHP ファイル（ルート）
cp "${THEME_DIR}"/*.php "${TEMP_DIR}/${THEME_NAME}/" 2>/dev/null || true

# style.css（テーマ情報）
cp "${THEME_DIR}/style.css" "${TEMP_DIR}/${THEME_NAME}/" 2>/dev/null || true

# screenshot.png（あれば）
cp "${THEME_DIR}/screenshot.png" "${TEMP_DIR}/${THEME_NAME}/" 2>/dev/null || true

# nav-control.js（ルートのJS）
cp "${THEME_DIR}/nav-control.js" "${TEMP_DIR}/${THEME_NAME}/" 2>/dev/null || true

# dist/（ビルド成果物）
if [ -d "${THEME_DIR}/dist" ]; then
  cp -R "${THEME_DIR}/dist" "${TEMP_DIR}/${THEME_NAME}/"
  log_info "  - dist/ をコピー"
fi

# library/（PHP モジュール）
if [ -d "${THEME_DIR}/library" ]; then
  cp -R "${THEME_DIR}/library" "${TEMP_DIR}/${THEME_NAME}/"
  log_info "  - library/ をコピー"
fi

# languages/（翻訳ファイル）
if [ -d "${THEME_DIR}/languages" ]; then
  cp -R "${THEME_DIR}/languages" "${TEMP_DIR}/${THEME_NAME}/"
  log_info "  - languages/ をコピー"
fi

# template-parts/（テンプレートパーツ）
if [ -d "${THEME_DIR}/template-parts" ]; then
  cp -R "${THEME_DIR}/template-parts" "${TEMP_DIR}/${THEME_NAME}/"
  log_info "  - template-parts/ をコピー"
fi

# page-templates/（ページテンプレート）
if [ -d "${THEME_DIR}/page-templates" ]; then
  cp -R "${THEME_DIR}/page-templates" "${TEMP_DIR}/${THEME_NAME}/"
  log_info "  - page-templates/ をコピー"
fi

# public/（静的アセット）
if [ -d "${THEME_DIR}/public" ]; then
  cp -R "${THEME_DIR}/public" "${TEMP_DIR}/${THEME_NAME}/"
  log_info "  - public/ をコピー"
fi

# 不要ファイルを削除（念のため）
find "${TEMP_DIR}" -name ".DS_Store" -delete 2>/dev/null || true
find "${TEMP_DIR}" -name "*.map" -delete 2>/dev/null || true

# ZIP作成
log_info "ZIP アーカイブを作成中..."
cd "${TEMP_DIR}"
zip -rq "${ARCHIVE_DIR}/${ARCHIVE_NAME}" "${THEME_NAME}"

# 一時ディレクトリをクリーンアップ
rm -rf "${TEMP_DIR}"

# 結果表示
log_success "アーカイブ作成完了！"
echo ""
echo "  📦 ${ARCHIVE_DIR}/${ARCHIVE_NAME}"
echo ""

# ファイルサイズ表示
SIZE=$(du -h "${ARCHIVE_DIR}/${ARCHIVE_NAME}" | cut -f1)
echo "  サイズ: ${SIZE}"
echo ""

# 内容確認
echo "  含まれるファイル:"
unzip -l "${ARCHIVE_DIR}/${ARCHIVE_NAME}" | tail -1
