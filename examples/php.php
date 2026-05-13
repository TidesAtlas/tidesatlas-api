<?php
/**
 * TidesAtlas API — PHP example
 * No dependencies required (uses curl)
 * Docs: https://tidesatlas.com/api/docs
 */

define('API_KEY', 'ta_your_api_key_here');
define('BASE_URL', 'https://tidesatlas.com/api/v1');

function tidesAtlas(string $endpoint, array $params = []): array {
    $url = BASE_URL . '/' . $endpoint;
    if ($params) {
        $url .= '?' . http_build_query($params);
    }

    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER     => ['X-API-Key: ' . API_KEY],
        CURLOPT_TIMEOUT        => 30,
    ]);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    $data = json_decode($response, true);

    if ($httpCode !== 200) {
        throw new RuntimeException("API error $httpCode: " . ($data['message'] ?? 'Unknown error'));
    }

    return $data;
}

// --- Examples ---

// Get tide predictions for Brest
$tides = tidesAtlas('tides', ['port' => 'brest', 'days' => 3]);
echo "Tides for {$tides['port']['name']} ({$tides['port']['country']})\n";
foreach ($tides['extremes'] as $t) {
    printf("  %-4s  %s  %sm\n", $t['type'], $t['datetime'], $t['height_m']);
}

// Get tides with datum conversion (Mean Sea Level)
$tidesMSL = tidesAtlas('tides', ['port' => 'brest', 'datum' => 'MSL']);
echo "\nBrest tides (MSL datum):\n";
foreach ($tidesMSL['extremes'] as $t) {
    printf("  %-4s  %sm\n", $t['type'], $t['height_m']);
}

// Search ports by name
$results = tidesAtlas('ports', ['search' => 'marseille', 'limit' => 3]);
echo "\nSearch results:\n";
foreach ($results['ports'] as $p) {
    echo "  {$p['name']} ({$p['country']}) — {$p['slug']}\n";
}

// Get weather + marine + astronomy in one call
$conditions = tidesAtlas('conditions', [
    'port'    => 'brest',
    'days'    => 1,
    'include' => 'weather,marine,astronomy',
]);
echo "\nConditions:\n";
echo "  Weather: {$conditions['weather']['daily'][0]['condition']}\n";
echo "  Waves: {$conditions['marine']['daily'][0]['wave_height_max_m']}m\n";
echo "  Sunset: {$conditions['astronomy'][0]['sunset']}\n";
