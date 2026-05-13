#!/bin/bash
# TidesAtlas API — cURL examples
# Docs: https://tidesatlas.com/api/docs

API_KEY="ta_your_api_key_here"
BASE="https://tidesatlas.com/api/v1"

echo "=== Tide predictions (Brest, 3 days) ==="
curl -s -H "X-API-Key: $API_KEY" \
  "$BASE/tides?port=brest&days=3" | python3 -m json.tool

echo ""
echo "=== Tides by coordinates (nearest station) ==="
curl -s -H "X-API-Key: $API_KEY" \
  "$BASE/tides?lat=48.65&lon=-2.0&days=1" | python3 -m json.tool

echo ""
echo "=== Tides with MSL datum ==="
curl -s -H "X-API-Key: $API_KEY" \
  "$BASE/tides?port=brest&datum=MSL" | python3 -m json.tool

echo ""
echo "=== Search ports ==="
curl -s -H "X-API-Key: $API_KEY" \
  "$BASE/ports?search=sydney&limit=3" | python3 -m json.tool

echo ""
echo "=== Weather forecast ==="
curl -s -H "X-API-Key: $API_KEY" \
  "$BASE/weather?port=brest&days=1" | python3 -m json.tool

echo ""
echo "=== Marine forecast ==="
curl -s -H "X-API-Key: $API_KEY" \
  "$BASE/marine?port=brest&days=1" | python3 -m json.tool

echo ""
echo "=== All conditions in one call ==="
curl -s -H "X-API-Key: $API_KEY" \
  "$BASE/conditions?port=brest&days=1&include=weather,marine,astronomy" | python3 -m json.tool

echo ""
echo "=== List countries ==="
curl -s -H "X-API-Key: $API_KEY" \
  "$BASE/countries" | python3 -m json.tool | head -20
