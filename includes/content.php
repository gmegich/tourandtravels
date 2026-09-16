<?php
declare(strict_types=1);

require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/details.php';

/**
 * Static fallback content when DB is empty / offline.
 */
function fallback_destinations(): array
{
    $rows = [
        ['name' => 'Maasai Mara', 'slug' => 'maasai-mara', 'region' => 'Rift Valley', 'country' => 'Kenya', 'short_description' => 'Iconic savannah home of the Great Migration and big cats.', 'image_url' => 'https://images.unsplash.com/photo-1516426122078-c23e76319801?w=1600&q=80', 'highlights' => 'Great Migration|Big five|Hot-air balloon safari|Maasai villages', 'best_time' => 'July–October (migration); year-round game viewing', 'is_featured' => 1],
        ['name' => 'Amboseli', 'slug' => 'amboseli', 'region' => 'South Kenya', 'country' => 'Kenya', 'short_description' => 'Elephants beneath the snowy dome of Mount Kilimanjaro.', 'image_url' => 'https://images.unsplash.com/photo-1547471080-7cc2caa01a7e?w=1600&q=80', 'highlights' => 'Kilimanjaro views|Elephant herds|Observation Hill|Birdlife', 'best_time' => 'June–October & January–February', 'is_featured' => 1],
        ['name' => 'Diani Beach', 'slug' => 'diani', 'region' => 'South Coast', 'country' => 'Kenya', 'short_description' => 'Powder-white sands, turquoise water, and coastal calm.', 'image_url' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=1600&q=80', 'highlights' => 'Snorkeling|Dhow cruises|Colobus monkeys|Beach clubs', 'best_time' => 'December–March & July–October', 'is_featured' => 1],
        ['name' => 'Mombasa', 'slug' => 'mombasa', 'region' => 'Coast', 'country' => 'Kenya', 'short_description' => 'Historic island city where Swahili culture meets the Indian Ocean.', 'image_url' => 'https://images.unsplash.com/photo-1580060839134-75a5edca2e99?w=1600&q=80', 'highlights' => 'Fort Jesus|Old Town|Nyali Beach|Seafood', 'best_time' => 'Year-round; driest Dec–Mar', 'is_featured' => 1],
        ['name' => 'Nairobi', 'slug' => 'nairobi', 'region' => 'Central', 'country' => 'Kenya', 'short_description' => 'Safari capital — wildlife parks minutes from the city skyline.', 'image_url' => 'assets/images/destinations/nairobi.jpg', 'highlights' => 'Nairobi National Park|Giraffe Centre|Karen Blixen|City dining', 'best_time' => 'Year-round', 'is_featured' => 1],
        ['name' => 'Lake Naivasha', 'slug' => 'naivasha', 'region' => 'Rift Valley', 'country' => 'Kenya', 'short_description' => 'Freshwater lake of hippos, birds, and Hell\'s Gate adventures.', 'image_url' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=1600&q=80', 'highlights' => 'Boat safari|Crescent Island|Hell\'s Gate|Geothermal views', 'best_time' => 'Year-round', 'is_featured' => 0],
        ['name' => 'Samburu', 'slug' => 'samburu', 'region' => 'Northern Kenya', 'country' => 'Kenya', 'short_description' => 'Semi-arid wilderness with rare northern specialists.', 'image_url' => 'https://images.unsplash.com/photo-1551632811-561732d1e306?w=1600&q=80', 'highlights' => 'Special five|Ewaso Nyiro River|Samburu culture', 'best_time' => 'June–October & December–March', 'is_featured' => 0],
        ['name' => 'Tsavo', 'slug' => 'tsavo', 'region' => 'Southeast Kenya', 'country' => 'Kenya', 'short_description' => 'Vast red-earth parks famous for red elephants and open space.', 'image_url' => 'https://images.unsplash.com/photo-1488188840666-e962ff04b6e3?w=1600&q=80', 'highlights' => 'Red elephants|Mzima Springs|Yatta Plateau', 'best_time' => 'June–October', 'is_featured' => 0],
        ['name' => 'Zanzibar', 'slug' => 'zanzibar', 'region' => 'Indian Ocean', 'country' => 'Tanzania', 'short_description' => 'Spice islands, Stone Town UNESCO heritage, and dream beaches.', 'image_url' => 'assets/images/destinations/zanzibar.jpg', 'highlights' => 'Stone Town|Nungwi|Spice tours|Snorkeling', 'best_time' => 'June–October & December–February', 'is_featured' => 1],
        ['name' => 'Uganda & Tanzania', 'slug' => 'uganda-tanzania', 'region' => 'East Africa', 'country' => 'Regional', 'short_description' => 'Cross-border gorilla treks and Serengeti extensions.', 'image_url' => 'https://images.unsplash.com/photo-1516426122078-c23e76319801?w=1600&q=80', 'highlights' => 'Gorilla trekking|Serengeti|Ngorongoro|Multi-country logistics', 'best_time' => 'Depends on itinerary', 'is_featured' => 0],
    ];
    return array_map('enrich_destination', $rows);
}

function fallback_packages(): array
{
    $rows = [
        ['title' => 'Classic Maasai Mara Safari', 'slug' => 'classic-maasai-mara-safari', 'category' => 'safari', 'duration_days' => 3, 'price_from' => 45000, 'short_description' => 'Three days of game drives in Kenya\'s premier reserve.', 'image_url' => 'https://images.unsplash.com/photo-1516426122078-c23e76319801?w=1200&q=80', 'is_popular' => 1],
        ['title' => 'Amboseli Elephant Escape', 'slug' => 'amboseli-elephant-escape', 'category' => 'safari', 'duration_days' => 2, 'price_from' => 32000, 'short_description' => 'Kilimanjaro backdrop and legendary elephant herds.', 'image_url' => 'https://images.unsplash.com/photo-1547471080-7cc2caa01a7e?w=1200&q=80', 'is_popular' => 1],
        ['title' => 'Diani Beach Break', 'slug' => 'diani-beach-break', 'category' => 'beach', 'duration_days' => 4, 'price_from' => 38000, 'short_description' => 'Sun, sand, and coastal cuisine on Kenya\'s south coast.', 'image_url' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=1200&q=80', 'is_popular' => 1],
        ['title' => 'Nairobi City Highlights', 'slug' => 'nairobi-city-highlights', 'category' => 'city', 'duration_days' => 1, 'price_from' => 12000, 'short_description' => 'National park, giraffe centre, and Karen heritage in one day.', 'image_url' => 'assets/images/destinations/nairobi.jpg', 'is_popular' => 0],
        ['title' => 'Mount Kenya Hiking Trek', 'slug' => 'mount-kenya-hiking-trek', 'category' => 'mountain', 'duration_days' => 5, 'price_from' => 65000, 'short_description' => 'Guided trek routes with porters and mountain logistics.', 'image_url' => 'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?w=1200&q=80', 'is_popular' => 0],
        ['title' => 'Family Mara Adventure', 'slug' => 'family-mara-adventure', 'category' => 'family', 'duration_days' => 4, 'price_from' => 78000, 'short_description' => 'Family-paced game drives and kid-friendly lodges.', 'image_url' => 'https://images.unsplash.com/photo-1516426122078-c23e76319801?w=1200&q=80', 'is_popular' => 1],
        ['title' => 'Coast Honeymoon Escape', 'slug' => 'coast-honeymoon-escape', 'category' => 'honeymoon', 'duration_days' => 5, 'price_from' => 95000, 'short_description' => 'Seamless arrivals, beach villa tips, and romantic extras.', 'image_url' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=1200&q=80', 'is_popular' => 1],
        ['title' => 'Custom Private Tour', 'slug' => 'custom-private-tour', 'category' => 'custom', 'duration_days' => 7, 'price_from' => 0, 'short_description' => 'Built around your dates, pace, and interests.', 'image_url' => 'assets/images/experiences/private-safari.jpg', 'is_popular' => 0],
    ];
    return array_map('enrich_package', $rows);
}

/** Local destination photos when remote URLs break */
function destination_image_map(): array
{
    return [
        'nairobi' => 'assets/images/destinations/nairobi.jpg',
        'zanzibar' => 'assets/images/destinations/zanzibar.jpg',
        'tsavo' => 'assets/images/destinations/tsavo.jpg',
    ];
}

function apply_destination_images(array $rows): array
{
    $map = destination_image_map();
    foreach ($rows as &$row) {
        $slug = (string) ($row['slug'] ?? '');
        if ($slug !== '' && isset($map[$slug]) && is_file(dirname(__DIR__) . '/' . $map[$slug])) {
            $row['image_url'] = asset_url($map[$slug]);
        }
    }
    unset($row);
    return $rows;
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
        $rows = apply_destination_images(array_map('enrich_destination', $rows));
        return $featured_only ? array_values(array_filter($rows, fn($r) => (int) $r['is_featured'] === 1)) ?: array_slice($rows, 0, 6) : $rows;
    }
    $all = apply_destination_images(fallback_destinations());
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
        $rows = array_map('enrich_package', $rows);
        return $rows;
    }
    $all = fallback_packages();
    return $popular_only ? array_values(array_filter($all, fn($r) => (int) $r['is_popular'] === 1)) : $all;
}

function get_package_by_slug(string $slug): ?array
{
    $slug = trim($slug);
    if ($slug === '') {
        return null;
    }
    $row = fetch_one('SELECT * FROM packages WHERE slug = ? AND is_active = 1 LIMIT 1', [$slug]);
    if ($row) {
        return enrich_package($row);
    }
    foreach (fallback_packages() as $p) {
        if (($p['slug'] ?? '') === $slug) {
            return $p;
        }
    }
    return null;
}

function get_destination_by_slug(string $slug): ?array
{
    $slug = trim($slug);
    if ($slug === '') {
        return null;
    }
    $row = fetch_one('SELECT * FROM destinations WHERE slug = ? AND is_active = 1 LIMIT 1', [$slug]);
    if ($row) {
        $enriched = [enrich_destination($row)];
        return apply_destination_images($enriched)[0] ?? null;
    }
    foreach (apply_destination_images(fallback_destinations()) as $d) {
        if (($d['slug'] ?? '') === $slug) {
            return $d;
        }
    }
    return null;
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
        default => ucfirst(str_replace('_', ' ', $cat)),
    };
}

function booking_ref(): string
{
    return 'NYK-' . strtoupper(bin2hex(random_bytes(3))) . '-' . date('ymd');
}
