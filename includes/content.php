<?php
declare(strict_types=1);

require_once __DIR__ . '/functions.php';

/**
 * Static fallback content when DB is empty / offline.
 */
function fallback_destinations(): array
{
    return [
        ['name' => 'Maasai Mara', 'slug' => 'maasai-mara', 'region' => 'Rift Valley', 'country' => 'Kenya', 'short_description' => 'Iconic savannah home of the Great Migration and big cats.', 'image_url' => 'https://images.unsplash.com/photo-1516426122078-c23e76319801?w=1600&q=80', 'is_featured' => 1],
        ['name' => 'Amboseli', 'slug' => 'amboseli', 'region' => 'South Kenya', 'country' => 'Kenya', 'short_description' => 'Elephants beneath the snowy dome of Mount Kilimanjaro.', 'image_url' => 'https://images.unsplash.com/photo-1547471080-7cc2caa01a7e?w=1600&q=80', 'is_featured' => 1],
        ['name' => 'Diani Beach', 'slug' => 'diani', 'region' => 'South Coast', 'country' => 'Kenya', 'short_description' => 'Powder-white sands, turquoise water, and coastal calm.', 'image_url' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=1600&q=80', 'is_featured' => 1],
        ['name' => 'Mombasa', 'slug' => 'mombasa', 'region' => 'Coast', 'country' => 'Kenya', 'short_description' => 'Historic island city where Swahili culture meets the Indian Ocean.', 'image_url' => 'https://images.unsplash.com/photo-1580060839134-75a5edca2e99?w=1600&q=80', 'is_featured' => 1],
        ['name' => 'Nairobi', 'slug' => 'nairobi', 'region' => 'Central', 'country' => 'Kenya', 'short_description' => 'Safari capital — wildlife parks minutes from the city skyline.', 'image_url' => 'https://images.unsplash.com/photo-1564760055775-d63b17a69c44?w=1600&q=80', 'is_featured' => 1],
        ['name' => 'Lake Naivasha', 'slug' => 'naivasha', 'region' => 'Rift Valley', 'country' => 'Kenya', 'short_description' => 'Freshwater lake of hippos, birds, and Hell\'s Gate adventures.', 'image_url' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=1600&q=80', 'is_featured' => 0],
        ['name' => 'Samburu', 'slug' => 'samburu', 'region' => 'Northern Kenya', 'country' => 'Kenya', 'short_description' => 'Semi-arid wilderness with rare northern specialists.', 'image_url' => 'https://images.unsplash.com/photo-1551632811-561732d1e306?w=1600&q=80', 'is_featured' => 0],
        ['name' => 'Tsavo', 'slug' => 'tsavo', 'region' => 'Southeast Kenya', 'country' => 'Kenya', 'short_description' => 'Vast red-earth parks famous for red elephants and open space.', 'image_url' => 'https://images.unsplash.com/photo-1488188840666-e962ff04b6e3?w=1600&q=80', 'is_featured' => 0],
        ['name' => 'Zanzibar', 'slug' => 'zanzibar', 'region' => 'Indian Ocean', 'country' => 'Tanzania', 'short_description' => 'Spice islands, Stone Town UNESCO heritage, and dream beaches.', 'image_url' => 'https://images.unsplash.com/photo-1586861635166-cdafc3f5b3b5?w=1600&q=80', 'is_featured' => 1],
        ['name' => 'Uganda & Tanzania', 'slug' => 'uganda-tanzania', 'region' => 'East Africa', 'country' => 'Regional', 'short_description' => 'Cross-border gorilla treks and Serengeti extensions.', 'image_url' => 'https://images.unsplash.com/photo-1516426122078-c23e76319801?w=1600&q=80', 'is_featured' => 0],
    ];
}

function fallback_packages(): array
{
    return [
        ['title' => 'Classic Maasai Mara Safari', 'slug' => 'classic-maasai-mara-safari', 'category' => 'safari', 'duration_days' => 3, 'price_from' => 45000, 'short_description' => 'Three days of game drives in Kenya\'s premier reserve.', 'image_url' => 'https://images.unsplash.com/photo-1516426122078-c23e76319801?w=1200&q=80', 'is_popular' => 1],
        ['title' => 'Amboseli Elephant Escape', 'slug' => 'amboseli-elephant-escape', 'category' => 'safari', 'duration_days' => 2, 'price_from' => 32000, 'short_description' => 'Kilimanjaro backdrop and legendary elephant herds.', 'image_url' => 'https://images.unsplash.com/photo-1547471080-7cc2caa01a7e?w=1200&q=80', 'is_popular' => 1],
        ['title' => 'Diani Beach Break', 'slug' => 'diani-beach-break', 'category' => 'beach', 'duration_days' => 4, 'price_from' => 38000, 'short_description' => 'Sun, sand, and coastal cuisine on Kenya\'s south coast.', 'image_url' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=1200&q=80', 'is_popular' => 1],
        ['title' => 'Nairobi City Highlights', 'slug' => 'nairobi-city-highlights', 'category' => 'city', 'duration_days' => 1, 'price_from' => 12000, 'short_description' => 'National park, giraffe centre, and Karen heritage in one day.', 'image_url' => 'https://images.unsplash.com/photo-1564760055775-d63b17a69c44?w=1200&q=80', 'is_popular' => 0],
        ['title' => 'Mount Kenya Hiking Trek', 'slug' => 'mount-kenya-hiking-trek', 'category' => 'mountain', 'duration_days' => 5, 'price_from' => 65000, 'short_description' => 'Guided trek routes with porters and mountain logistics.', 'image_url' => 'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?w=1200&q=80', 'is_popular' => 0],
        ['title' => 'Family Mara Adventure', 'slug' => 'family-mara-adventure', 'category' => 'family', 'duration_days' => 4, 'price_from' => 78000, 'short_description' => 'Family-paced game drives and kid-friendly lodges.', 'image_url' => 'https://images.unsplash.com/photo-1516426122078-c23e76319801?w=1200&q=80', 'is_popular' => 1],
        ['title' => 'Coast Honeymoon Escape', 'slug' => 'coast-honeymoon-escape', 'category' => 'honeymoon', 'duration_days' => 5, 'price_from' => 95000, 'short_description' => 'Private transfers, beach villa tips, and romantic extras.', 'image_url' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=1200&q=80', 'is_popular' => 1],
        ['title' => 'Custom Private Tour', 'slug' => 'custom-private-tour', 'category' => 'custom', 'duration_days' => 7, 'price_from' => 0, 'short_description' => 'Built around your dates, pace, and interests.', 'image_url' => 'https://images.unsplash.com/photo-1488188840666-e962ff04b6e3?w=1200&q=80', 'is_popular' => 0],
    ];
}

/** Local realistic fleet photos (always preferred over remote placeholders). */
function vehicle_image_map(): array
{
    return [
        'toyota-vellfire' => 'assets/images/vehicles/01-vellfire.jpg',
        'safari-tour-van' => 'assets/images/vehicles/02-safari-van.jpg',
        'land-cruiser-4x4' => 'assets/images/vehicles/03-land-cruiser.jpg',
        'airport-transfer' => 'assets/images/vehicles/04-airport.jpg',
        'chauffeur-service' => 'assets/images/vehicles/05-chauffeur.jpg',
        'wedding-event-fleet' => 'assets/images/vehicles/06-wedding.jpg',
    ];
}

function apply_vehicle_images(array $rows): array
{
    $map = vehicle_image_map();
    foreach ($rows as &$row) {
        $slug = (string) ($row['slug'] ?? '');
        if ($slug !== '' && isset($map[$slug]) && is_file(dirname(__DIR__) . '/' . $map[$slug])) {
            // Cache-bust so browsers don't keep old non-Kenyan plate images
            $row['image_url'] = asset_url($map[$slug]);
        }
    }
    unset($row);
    return $rows;
}

function fallback_vehicles(): array
{
    return apply_vehicle_images([
        ['name' => 'Toyota Vellfire', 'slug' => 'toyota-vellfire', 'category' => 'vellfire', 'capacity' => 6, 'price_per_day' => 18000, 'description' => 'Executive VIP van for airport runs and city transfers.', 'features' => 'Leather seats|AC|Wi-Fi option|Bottled water', 'image_url' => 'assets/images/vehicles/01-vellfire.jpg'],
        ['name' => 'Safari Tour Van', 'slug' => 'safari-tour-van', 'category' => 'safari_van', 'capacity' => 8, 'price_per_day' => 15000, 'description' => 'Pop-up roof safari van built for game drives.', 'features' => 'Pop-up roof|Charging ports|Cooler box|Experienced driver-guide', 'image_url' => 'assets/images/vehicles/02-safari-van.jpg'],
        ['name' => 'Land Cruiser 4x4', 'slug' => 'land-cruiser-4x4', 'category' => 'land_cruiser', 'capacity' => 6, 'price_per_day' => 22000, 'description' => 'Rugged 4x4 for rough tracks and remote parks.', 'features' => '4WD|High clearance|Roof hatch|Safari seating', 'image_url' => 'assets/images/vehicles/03-land-cruiser.jpg'],
        ['name' => 'Airport Transfer', 'slug' => 'airport-transfer', 'category' => 'transfer', 'capacity' => 4, 'price_per_day' => 5000, 'description' => 'JKIA and Wilson meet-and-greet with fixed rates.', 'features' => 'Flight tracking|Meet & greet|Child seats on request', 'image_url' => 'assets/images/vehicles/04-airport.jpg'],
        ['name' => 'Chauffeur Service', 'slug' => 'chauffeur-service', 'category' => 'chauffeur', 'capacity' => 3, 'price_per_day' => 12000, 'description' => 'Hourly or full-day private chauffeur in Nairobi and beyond.', 'features' => 'Professional driver|Flexible hours|Discreet service', 'image_url' => 'assets/images/vehicles/05-chauffeur.jpg'],
        ['name' => 'Wedding & Event Fleet', 'slug' => 'wedding-event-fleet', 'category' => 'event', 'capacity' => 12, 'price_per_day' => 25000, 'description' => 'Decor-ready cars and vans for weddings and corporate events.', 'features' => 'Decor coordination|Multiple vehicles|On-time logistics', 'image_url' => 'assets/images/vehicles/06-wedding.jpg'],
    ]);
}

function get_destinations(bool $featured_only = false): array
{
    $sql = 'SELECT * FROM destinations WHERE is_active = 1';
    if ($featured_only) {
        $sql .= ' AND is_featured = 1';
    }
    $sql .= ' ORDER BY sort_order, name';
    $rows = fetch_all($sql);
    if ($rows) {
        return $featured_only ? array_values(array_filter($rows, fn($r) => (int) $r['is_featured'] === 1)) ?: array_slice($rows, 0, 6) : $rows;
    }
    $all = fallback_destinations();
    return $featured_only ? array_values(array_filter($all, fn($r) => (int) $r['is_featured'] === 1)) : $all;
}

function get_packages(bool $popular_only = false): array
{
    $sql = 'SELECT * FROM packages WHERE is_active = 1';
    if ($popular_only) {
        $sql .= ' AND is_popular = 1';
    }
    $sql .= ' ORDER BY sort_order, title';
    $rows = fetch_all($sql);
    if ($rows) {
        return $rows;
    }
    $all = fallback_packages();
    return $popular_only ? array_values(array_filter($all, fn($r) => (int) $r['is_popular'] === 1)) : $all;
}

function get_vehicles(): array
{
    $rows = fetch_all('SELECT * FROM vehicles WHERE is_available = 1 ORDER BY name');
    return apply_vehicle_images($rows ?: fallback_vehicles());
}

function category_label(string $cat): string
{
    return match ($cat) {
        'safari' => 'Safari',
        'beach' => 'Beach holiday',
        'city' => 'City tour',
        'mountain' => 'Mountain / hiking',
        'family' => 'Family holiday',
        'honeymoon' => 'Honeymoon',
        'custom' => 'Custom / private',
        'vellfire' => 'Toyota Vellfire',
        'safari_van' => 'Safari van',
        'land_cruiser' => 'Land Cruiser',
        'transfer' => 'Airport transfer',
        'chauffeur' => 'Chauffeur',
        'event' => 'Wedding / event',
        default => ucfirst(str_replace('_', ' ', $cat)),
    };
}

function booking_ref(): string
{
    return 'NYK-' . strtoupper(bin2hex(random_bytes(3))) . '-' . date('ymd');
}
