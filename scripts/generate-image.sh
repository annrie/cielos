#!/bin/bash

################################################################################
# generate-image.sh
#
# Generate images using Google Gemini 3 Pro Image Preview via the REST API.
#
# USAGE:
#   ./generate-image.sh [OPTIONS]
#
# OPTIONS:
#   -p, --prompt TEXT          Text prompt describing the image to generate
#   -k, --api-key KEY          Google Gemini API key (or set GEMINI_API_KEY env var)
#   -i, --input-image FILE     Input image file to use as reference (optional)
#   -o, --output FILE          Output filename (default: generated_image-copy.jpg)
#   -a, --aspect-ratio RATIO   1:1, 2:3, 3:2, 3:4, 4:3, 4:5, 5:4, 9:16, 16:9, 21:9
#   -s, --size SIZE            Image size: 1K, 2K, or 4K
################################################################################
# Example usage for a glassmorphism-style hero image:
#./generate-image.sh \
#  -p "A person sitting at a computer desk working, modern aesthetic, purple and pink gradient lighting, glassmorphism style, soft glowing neon accents, dark background with colorful blurred blobs, elegant and minimal, professional workspace, atmospheric lighting, high quality digital art illustration" \
#  -o hero-image.png \
#  -a 4:3 \
#  -s 2K

set -euo pipefail

# Default values
PROMPT=""
API_KEY="${GEMINI_API_KEY:-}"
INPUT_IMAGE=""
OUTPUT_FILE="generated_image.png"
ASPECT_RATIO="1:1"
IMAGE_SIZE="1K"

# Valid options
VALID_ASPECT_RATIOS=("1:1" "2:3" "3:2" "3:4" "4:3" "4:5" "5:4" "9:16" "16:9" "21:9")
VALID_SIZES=("1K" "2K" "4K")

# API endpoint
API_ENDPOINT="https://generativelanguage.googleapis.com/v1beta/models/gemini-3-pro-image-preview:generateContent"

# Parse command-line arguments
while [[ $# -gt 0 ]]; do
    case $1 in
        -p|--prompt) PROMPT="$2"; shift 2 ;;
        -k|--api-key) API_KEY="$2"; shift 2 ;;
        -i|--input-image) INPUT_IMAGE="$2"; shift 2 ;;
        -o|--output) OUTPUT_FILE="$2"; shift 2 ;;
        -a|--aspect-ratio) ASPECT_RATIO="$2"; shift 2 ;;
        -s|--size) IMAGE_SIZE="$2"; shift 2 ;;
        *) echo "Error: Unknown option: $1" >&2; exit 1 ;;
    esac
done

# Validate required parameters
[[ -z "$PROMPT" ]] && { echo "Error: Prompt required (-p)" >&2; exit 1; }
[[ -z "$API_KEY" ]] && { echo "Error: API key required (-k or GEMINI_API_KEY)" >&2; exit 1; }

# Create temp files
TEMP_RESPONSE=$(mktemp)
TEMP_JSON=$(mktemp)
TEMP_PROMPT=$(mktemp)
trap "rm -f $TEMP_RESPONSE $TEMP_JSON $TEMP_PROMPT" EXIT

# Escape prompt for JSON
echo -n "$PROMPT" | jq -Rs . > "$TEMP_PROMPT"
ESCAPED_PROMPT=$(cat "$TEMP_PROMPT")

# Build JSON payload
cat > "$TEMP_JSON" <<EOF
{
  "contents": [{"parts": [{"text": $ESCAPED_PROMPT}]}],
  "generationConfig": {
    "imageConfig": {
      "aspectRatio": "$ASPECT_RATIO",
      "imageSize": "$IMAGE_SIZE"
    }
  }
}
EOF

# Make API request
HTTP_CODE=$(curl -s -w "%{http_code}" -o "$TEMP_RESPONSE" \
    -X POST "$API_ENDPOINT" \
    -H "x-goog-api-key: $API_KEY" \
    -H "Content-Type: application/json" \
    -d @"$TEMP_JSON")

[[ "$HTTP_CODE" -ne 200 ]] && { echo "Error: HTTP $HTTP_CODE"; cat "$TEMP_RESPONSE" >&2; exit 1; }

# Extract and save image
IMAGE_DATA=$(jq -r '.candidates[0].content.parts[] | select(.inlineData != null) | .inlineData.data' "$TEMP_RESPONSE" | head -n 1)
echo "$IMAGE_DATA" | base64 -d > "$OUTPUT_FILE"

echo "✓ Image saved to: $OUTPUT_FILE"