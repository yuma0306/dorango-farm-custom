#!/usr/bin/env bash
set -euo pipefail

ROOT_DIR="$(cd "$(dirname "$0")/.." && pwd)"
CERT_DIR="$ROOT_DIR/docker/certs"

if ! command -v mkcert >/dev/null 2>&1; then
	echo "brew install mkcert nss && mkcert -install"
	exit 1
fi

mkdir -p "$CERT_DIR"
cd "$CERT_DIR"
mkcert -install
mkcert -cert-file dorango-farm.com.pem -key-file dorango-farm.com-key.pem \
	dorango-farm.com www.dorango-farm.com localhost 127.0.0.1 ::1

echo "done: $CERT_DIR"
