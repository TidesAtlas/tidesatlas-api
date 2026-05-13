/**
 * TidesAtlas API — JavaScript / Node.js example
 * No dependencies required (uses native fetch, Node 18+)
 * Docs: https://tidesatlas.com/api/docs
 */

const API_KEY = "ta_your_api_key_here";
const BASE = "https://tidesatlas.com/api/v1";

async function tidesAtlas(endpoint, params = {}) {
  const url = new URL(`${BASE}/${endpoint}`);
  Object.entries(params).forEach(([k, v]) => url.searchParams.set(k, v));

  const res = await fetch(url, {
    headers: { "X-API-Key": API_KEY },
  });

  if (!res.ok) {
    const err = await res.json().catch(() => ({}));
    throw new Error(`${res.status}: ${err.message || res.statusText}`);
  }

  return res.json();
}

// --- Examples ---

// Get tide predictions for Brest, 3 days
const tides = await tidesAtlas("tides", { port: "brest", days: 3 });
console.log(`Tides for ${tides.port.name} (${tides.port.country})`);
for (const t of tides.extremes) {
  console.log(`  ${t.type.padEnd(4)}  ${t.datetime}  ${t.height_m}m`);
}

// Get tides by coordinates (nearest station)
const nearest = await tidesAtlas("tides", { lat: 48.65, lon: -2.0 });
console.log(`\nNearest station: ${nearest.port.name}`);

// Search ports
const ports = await tidesAtlas("ports", { search: "sydney", limit: 3 });
for (const p of ports.ports) {
  console.log(`  ${p.name} (${p.country}) — ${p.slug}`);
}

// Get full conditions (weather + marine + astronomy)
const conditions = await tidesAtlas("conditions", {
  port: "brest",
  days: 1,
  include: "weather,marine,astronomy",
});
console.log(`\nWeather: ${conditions.weather.daily[0].condition}`);
console.log(`Waves: ${conditions.marine.daily[0].wave_height_max_m}m`);
console.log(`Sunset: ${conditions.astronomy[0].sunset}`);
