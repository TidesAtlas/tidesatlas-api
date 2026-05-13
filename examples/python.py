"""
TidesAtlas API — Python example
Install: pip install requests
Docs: https://tidesatlas.com/api/docs
"""

import requests

API_KEY = "ta_your_api_key_here"
BASE = "https://tidesatlas.com/api/v1"
HEADERS = {"X-API-Key": API_KEY}


def get_tides(port, days=3, datum=None):
    """Get tide predictions for a port."""
    params = {"port": port, "days": days}
    if datum:
        params["datum"] = datum
    r = requests.get(f"{BASE}/tides", headers=HEADERS, params=params)
    r.raise_for_status()
    return r.json()


def get_tides_by_coords(lat, lon, days=1):
    """Get tides for the nearest station to given coordinates."""
    r = requests.get(
        f"{BASE}/tides",
        headers=HEADERS,
        params={"lat": lat, "lon": lon, "days": days},
    )
    r.raise_for_status()
    return r.json()


def search_ports(query, limit=5):
    """Search for ports by name."""
    r = requests.get(
        f"{BASE}/ports",
        headers=HEADERS,
        params={"search": query, "limit": limit},
    )
    r.raise_for_status()
    return r.json()


def get_conditions(port, days=1):
    """Get weather, marine and astronomy data in one call."""
    r = requests.get(
        f"{BASE}/conditions",
        headers=HEADERS,
        params={"port": port, "days": days, "include": "weather,marine,astronomy"},
    )
    r.raise_for_status()
    return r.json()


if __name__ == "__main__":
    # Example: Get tide predictions for Brest
    data = get_tides("brest", days=2)
    print(f"Tides for {data['port']['name']} ({data['port']['country']})")
    print(f"Datum: {data['datum']['reference']}")
    for tide in data["extremes"]:
        print(f"  {tide['type']:4s}  {tide['datetime']}  {tide['height_m']}m")

    print()

    # Example: Find nearest station to coordinates
    data = get_tides_by_coords(40.7128, -74.0060)  # New York
    print(f"Nearest station: {data['port']['name']}")

    print()

    # Example: Search ports
    results = search_ports("saint-malo")
    for p in results.get("ports", []):
        print(f"  {p['name']} ({p['country']}) — {p['slug']}")
