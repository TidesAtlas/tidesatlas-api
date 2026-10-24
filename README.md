# TidesAtlas API

Worldwide tide predictions, marine forecasts and astronomical data for 13,000+ ports in 180 countries.

**Base URL:** `https://tidesatlas.com/api/v1`

**Documentation:** [tidesatlas.com/api/docs](https://tidesatlas.com/en/api/docs)

**Dashboard:** [tidesatlas.com/api/dashboard](https://tidesatlas.com/api/dashboard)

---

## Features

- **Tide predictions** for 13,000+ ports across 180 countries
- **Tidal coefficients** (French coefficient scale, 20-120)
- **Weather forecasts** — temperature, wind, precipitation, UV index
- **Marine data** — wave height, swell, wave direction, sea state
- **Astronomy** — sunrise, sunset, moon phase, illumination
- **Multiple datums** — LAT, MSL, MLLW, MHW, MHHW, and more
- **Real-time observations** for French REFMAR stations

## Quick start

1. **Sign up** at [tidesatlas.com/api/register](https://tidesatlas.com/api/register) (50 free credits, no credit card)
2. Copy your API key from the dashboard
3. Make your first call:

```bash
curl -H "X-API-Key: YOUR_KEY" \
  "https://tidesatlas.com/api/v1/tides?port=brest&days=3"
```

## Endpoints

| Endpoint | Description |
|----------|-------------|
| `GET /tides` | High & low tide times, heights, and coefficients |
| `GET /ports` | Search ports by name, coordinates, or country |
| `GET /countries` | List all countries with port counts |
| `GET /weather` | Weather forecast (1-7 days) |
| `GET /marine` | Wave & swell forecast (1-7 days) |
| `GET /astronomy` | Sunrise, sunset, moon phase |
| `GET /conditions` | Weather + marine + astronomy in one call |
| `GET /history` | Historical tide & weather data |

## Authentication

Pass your API key in the `X-API-Key` header:

```
X-API-Key: ta_your_api_key_here
```

## Examples

Full working examples in multiple languages:

- [Python](examples/python.py)
- [JavaScript / Node.js](examples/javascript.mjs)
- [PHP](examples/php.php)
- [cURL](examples/curl.sh)

## Response example

```json
{
  "port": {
    "name": "Brest",
    "slug": "brest",
    "country": "France",
    "region": "Brittany"
  },
  "datum": {
    "reference": "LAT",
    "available": ["LAT", "MSL", "MLLW", "MHW", "MLW", "MHHW", "MTL"]
  },
  "extremes": [
    {
      "datetime": "2026-05-13T05:18:00+02:00",
      "height_m": 6.79,
      "type": "high"
    },
    {
      "datetime": "2026-05-13T11:45:00+02:00",
      "height_m": 0.82,
      "type": "low"
    }
  ]
}
```

## Datum conversion

Request heights in any supported reference frame:

```bash
# Heights relative to Mean Sea Level
curl -H "X-API-Key: KEY" \
  "https://tidesatlas.com/api/v1/tides?port=brest&datum=MSL"

# Heights relative to Mean Lower Low Water (US standard)
curl -H "X-API-Key: KEY" \
  "https://tidesatlas.com/api/v1/tides?port=seattle&datum=MLLW"
```

## Rate limits

| Plan | Requests | Price |
|------|----------|-------|
| Free | 50 one-time credits | $0 |
| Hobby | 500/day | $4.99/mo |
| Starter | 1,000/day | $9/mo |
| Pro | 10,000/day | $29/mo |
| Business | 50,000/day | $79/mo |

Rate limit headers are included in every response:

```
X-RateLimit-Limit: 500
X-RateLimit-Remaining: 347
X-RateLimit-Reset: 1715644800
```

## Data sources

- **Tide predictions:** Harmonic analysis using TICON-4 and FES2022 tidal constituents
- **Weather:** NOAA GFS via Open-Meteo (CC BY 4.0)
- **Marine:** Copernicus Marine / ECMWF via Open-Meteo (CC BY 4.0)
- **Astronomy:** Computed from solar/lunar ephemeris

## Status

API status page: [tidesatlas.com/api/status](https://tidesatlas.com/api/status)

## Support

- Email: support@tidesatlas.com
- Issues: [GitHub Issues](https://github.com/tidesatlas/tidesatlas-api/issues)

## License

This repository contains documentation and example code only. The examples are released under the [MIT License](LICENSE). The API itself is a commercial service — see [Terms of Use](https://tidesatlas.com/en/legal).
