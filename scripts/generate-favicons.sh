#!/usr/bin/env bash
set -euo pipefail

# Generate favicon assets from current logo/sun images.
# Run from theme root:
#   ./scripts/generate-favicons.sh

ROOT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
FAV_DIR="$ROOT_DIR/public/favicons"
IMG_DIR="$ROOT_DIR/src/assets/images"
PUBLIC_ROOT="$ROOT_DIR/../../../"

LIGHT_LOGO="$IMG_DIR/site-logo-light.png"
DARK_LOGO="$IMG_DIR/site-logo-dark.png"
SUN_LIGHT="$IMG_DIR/hero-sun-light.png"

if ! command -v magick >/dev/null 2>&1; then
  echo "Error: ImageMagick 'magick' command not found." >&2
  exit 1
fi

if [[ ! -f "$LIGHT_LOGO" || ! -f "$DARK_LOGO" || ! -f "$SUN_LIGHT" ]]; then
  echo "Error: source image(s) missing under src/assets/images." >&2
  exit 1
fi

mkdir -p "$FAV_DIR"
TMP_DIR="$(mktemp -d)"
trap 'rm -rf "$TMP_DIR"' EXIT

echo "[1/4] Generate internal master squares (temporary)..."
magick -size 1024x1024 xc:none \
  \( "$LIGHT_LOGO" -resize 900x360 \) -gravity center -composite \
  "$TMP_DIR/favicon-master-light.png"

magick -size 1024x1024 xc:none \
  \( "$DARK_LOGO" -resize 900x360 \) -gravity center -composite \
  "$TMP_DIR/favicon-master-dark.png"

echo "[2/4] Generate favicon distribution assets..."
# Tab-optimized small icon: sun mark with max occupancy.
magick -size 32x32 xc:none \
  \( "$SUN_LIGHT" -resize 31x31 \) -gravity center -composite \
  "$FAV_DIR/favicon-32x32.png"

magick -size 16x16 xc:none \
  \( "$SUN_LIGHT" -resize 15x15 \) -gravity center -composite \
  "$FAV_DIR/favicon-16x16.png"

magick "$TMP_DIR/favicon-master-light.png" -resize 96x96   "$FAV_DIR/favicon-96x96.png"
magick "$TMP_DIR/favicon-master-light.png" -resize 180x180 "$FAV_DIR/apple-touch-icon.png"
magick "$TMP_DIR/favicon-master-light.png" -resize 192x192 "$FAV_DIR/android-chrome-192x192.png"
magick "$TMP_DIR/favicon-master-light.png" -resize 512x512 "$FAV_DIR/android-chrome-512x512.png"
magick "$TMP_DIR/favicon-master-light.png" -resize 150x150 "$FAV_DIR/mstile-150x150.png"
magick "$FAV_DIR/favicon-32x32.png" -define icon:auto-resize=16,24,32,48 "$FAV_DIR/favicon.ico"

cat > "$FAV_DIR/site.webmanifest" <<'EOF'
{
  "name": "cielos",
  "short_name": "cielos",
  "icons": [
    {
      "src": "/wp-content/themes/cielos/public/favicons/android-chrome-192x192.png",
      "sizes": "192x192",
      "type": "image/png"
    },
    {
      "src": "/wp-content/themes/cielos/public/favicons/android-chrome-512x512.png",
      "sizes": "512x512",
      "type": "image/png"
    }
  ],
  "theme_color": "#0b1220",
  "background_color": "#0b1220",
  "display": "standalone"
}
EOF

cat > "$FAV_DIR/browserconfig.xml" <<'EOF'
<?xml version="1.0" encoding="utf-8"?>
<browserconfig>
  <msapplication>
    <tile>
      <square150x150logo src="/wp-content/themes/cielos/public/favicons/mstile-150x150.png"/>
      <TileColor>#0b1220</TileColor>
    </tile>
  </msapplication>
</browserconfig>
EOF

echo "[3/4] Sync root fallback icons..."
cp -f "$FAV_DIR/favicon.ico" "$PUBLIC_ROOT/favicon.ico"
cp -f "$FAV_DIR/favicon-32x32.png" "$PUBLIC_ROOT/favicon-32x32.png"
cp -f "$FAV_DIR/favicon-16x16.png" "$PUBLIC_ROOT/favicon-16x16.png"
cp -f "$FAV_DIR/apple-touch-icon.png" "$PUBLIC_ROOT/apple-touch-icon.png"

echo "[4/4] Cleanup temporary files..."
echo "Done. Generated favicon assets in: $FAV_DIR (no favicon-master files kept)"
