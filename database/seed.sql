-- Seed data for Nyika Safaris (legacy MySQL). Prefer database/supabase_seed.sql.
USE nyika_safaris;

-- Destinations (admin: gmegichuru@gmail.com / admin123 via install.php)

INSERT INTO destinations (name, slug, region, country, short_description, description, image_url, highlights, best_time, is_featured, sort_order) VALUES
('Maasai Mara', 'maasai-mara', 'Rift Valley', 'Kenya',
 'Iconic savannah home of the Great Migration and big cats.',
 'The Maasai Mara National Reserve is Kenya''s most celebrated safari destination — endless grasslands, predator action, and Maasai culture.',
 'https://images.unsplash.com/photo-1516426122078-c23e76319801?w=1600&q=80',
 'Great Migration|Big five|Hot-air balloon safari|Maasai villages',
 'July–October (migration); year-round game viewing', 1, 1),
('Amboseli', 'amboseli', 'South Kenya', 'Kenya',
 'Elephants beneath the snowy dome of Mount Kilimanjaro.',
 'Amboseli National Park offers classic views of Kilimanjaro, large elephant herds, and open plains perfect for photography.',
 'https://images.unsplash.com/photo-1547471080-7cc2caa01a7e?w=1600&q=80',
 'Kilimanjaro views|Elephant herds|Observation Hill|Swarms of birds',
 'June–October & January–February', 1, 2),
('Diani Beach', 'diani', 'South Coast', 'Kenya',
 'Powder-white sands, turquoise water, and coastal calm.',
 'Diani is Kenya''s premier beach escape — palm-lined shores, water sports, and relaxed resorts south of Mombasa.',
 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=1600&q=80',
 'Snorkeling|Dhow cruises|Colobus monkeys|Beach clubs',
 'December–March & July–October', 1, 3),
('Mombasa', 'mombasa', 'Coast', 'Kenya',
 'Historic island city where Swahili culture meets the Indian Ocean.',
 'Explore Old Town, Fort Jesus, spice markets, and nearby north-coast beaches from Kenya''s coastal hub.',
 'https://images.unsplash.com/photo-1580060839134-75a5edca2e99?w=1600&q=80',
 'Fort Jesus|Old Town|Nyali Beach|Seafood',
 'Year-round; driest Dec–Mar', 1, 4),
('Nairobi', 'nairobi', 'Central', 'Kenya',
 'Safari capital — wildlife parks minutes from the city skyline.',
 'Nairobi blends urban energy with nature: Nairobi National Park, giraffe centres, museums, and nightlife.',
 'assets/images/destinations/nairobi.jpg',
 'Nairobi National Park|Giraffe Centre|Karen Blixen|City dining',
 'Year-round', 1, 5),
('Lake Naivasha', 'naivasha', 'Rift Valley', 'Kenya',
 'Freshwater lake of hippos, birds, and Hell''s Gate adventures.',
 'A peaceful Rift Valley stop with boat rides, Crescent Island walking safari, and Hell''s Gate cycling.',
 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=1600&q=80',
 'Boat safari|Crescent Island|Hell''s Gate|Geothermal views',
 'Year-round', 0, 6),
('Samburu', 'samburu', 'Northern Kenya', 'Kenya',
 'Semi-arid wilderness with rare northern specialists.',
 'See Grevy''s zebra, reticulated giraffe, and Somali ostrich in dramatic northern landscapes.',
 'https://images.unsplash.com/photo-1551632811-561732d1e306?w=1600&q=80',
 'Special five|Ewaso Nyiro River|Samburu culture',
 'June–October & December–March', 0, 7),
('Tsavo', 'tsavo', 'Southeast Kenya', 'Kenya',
 'Vast red-earth parks famous for red elephants and open space.',
 'Tsavo East & West form one of Africa''s largest protected areas — raw, spacious, and rewarding.',
 'https://images.unsplash.com/photo-1488188840666-e962ff04b6e3?w=1600&q=80',
 'Red elephants|Mzima Springs|Yatta Plateau|Mzima Springs',
 'June–October', 0, 8),
('Zanzibar', 'zanzibar', 'Indian Ocean', 'Tanzania',
 'Spice islands, Stone Town UNESCO heritage, and dream beaches.',
 'Extend your Kenya safari with Zanzibar''s culture, reefs, and turquoise lagoons.',
 'assets/images/destinations/zanzibar.jpg',
 'Stone Town|Nungwi|Spice tours|Snorkeling',
 'June–October & December–February', 1, 9),
('Uganda & Tanzania', 'uganda-tanzania', 'East Africa', 'Regional',
 'Cross-border gorilla treks and Serengeti extensions.',
 'We arrange seamless multi-country itineraries: Bwindi gorillas, Serengeti, Ngorongoro, and more.',
 'https://images.unsplash.com/photo-1516426122078-c23e76319801?w=1600&q=80',
 'Gorilla trekking|Serengeti|Ngorongoro|Multi-country logistics',
 'Depends on itinerary', 0, 10)
ON DUPLICATE KEY UPDATE name = VALUES(name);

-- Packages
INSERT INTO packages (title, slug, category, destination_id, duration_days, price_from, short_description, description, inclusions, image_url, is_popular, sort_order)
SELECT 'Classic Maasai Mara Safari', 'classic-maasai-mara-safari', 'safari', d.id, 3, 45000,
  'Three days of game drives in Kenya''s premier reserve.',
  'Dawn and afternoon drives, park fees guidance, and comfortable lodge or camp stays.',
  'Transport|Park fees guidance|Driver-guide|Bottled water',
  'https://images.unsplash.com/photo-1516426122078-c23e76319801?w=1200&q=80', 1, 1
FROM destinations d WHERE d.slug = 'maasai-mara'
ON DUPLICATE KEY UPDATE title = VALUES(title);

INSERT INTO packages (title, slug, category, destination_id, duration_days, price_from, short_description, description, inclusions, image_url, is_popular, sort_order)
SELECT 'Amboseli Elephant Escape', 'amboseli-elephant-escape', 'safari', d.id, 2, 32000,
  'Kilimanjaro backdrop and legendary elephant herds.',
  'Ideal short safari from Nairobi with superb photography light.',
  'Transport|Park entry support|Guide|Water',
  'https://images.unsplash.com/photo-1547471080-7cc2caa01a7e?w=1200&q=80', 1, 2
FROM destinations d WHERE d.slug = 'amboseli'
ON DUPLICATE KEY UPDATE title = VALUES(title);

INSERT INTO packages (title, slug, category, destination_id, duration_days, price_from, short_description, description, inclusions, image_url, is_popular, sort_order)
SELECT 'Diani Beach Break', 'diani-beach-break', 'beach', d.id, 4, 38000,
  'Sun, sand, and coastal cuisine on Kenya''s south coast.',
  'Transfers, beach hotel recommendations, and optional water sports.',
  'Airport/road transfer options|Local concierge tips',
  'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=1200&q=80', 1, 3
FROM destinations d WHERE d.slug = 'diani'
ON DUPLICATE KEY UPDATE title = VALUES(title);

INSERT INTO packages (title, slug, category, destination_id, duration_days, price_from, short_description, description, inclusions, image_url, is_popular, sort_order)
SELECT 'Nairobi City Highlights', 'nairobi-city-highlights', 'city', d.id, 1, 12000,
  'National park, giraffe centre, and Karen heritage in one day.',
  'Perfect arrival or departure day with private vehicle and guide.',
  'Private vehicle|Guide|Entrance fee support',
  'assets/images/destinations/nairobi.jpg', 0, 4
FROM destinations d WHERE d.slug = 'nairobi'
ON DUPLICATE KEY UPDATE title = VALUES(title);

INSERT INTO packages (title, slug, category, destination_id, duration_days, price_from, short_description, description, inclusions, image_url, is_popular, sort_order)
SELECT 'Mount Kenya Hiking Trek', 'mount-kenya-hiking-trek', 'mountain', NULL, 5, 65000,
  'Guided trek routes with porters and mountain logistics.',
  'Chogoria or Naro Moru approaches with safety-first guiding.',
  'Guides|Porters arrangement|Park logistics support',
  'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?w=1200&q=80', 0, 5
ON DUPLICATE KEY UPDATE title = VALUES(title);

INSERT INTO packages (title, slug, category, destination_id, duration_days, price_from, short_description, description, inclusions, image_url, is_popular, sort_order)
SELECT 'Family Mara Adventure', 'family-mara-adventure', 'family', d.id, 4, 78000,
  'Family-paced game drives and kid-friendly lodges.',
  'Softer itineraries, flexible meal stops, and safe vehicles.',
  'Family vehicle|Guide|Flexible pacing',
  'https://images.unsplash.com/photo-1516426122078-c23e76319801?w=1200&q=80', 1, 6
FROM destinations d WHERE d.slug = 'maasai-mara'
ON DUPLICATE KEY UPDATE title = VALUES(title);

INSERT INTO packages (title, slug, category, destination_id, duration_days, price_from, short_description, description, inclusions, image_url, is_popular, sort_order)
SELECT 'Coast Honeymoon Escape', 'coast-honeymoon-escape', 'honeymoon', d.id, 5, 95000,
  'Private transfers, beach villa tips, and romantic extras.',
  'Diani or Watamu with optional sunset dhow cruise.',
  'Private transfers|Concierge|Celebration touches',
  'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=1200&q=80', 1, 7
FROM destinations d WHERE d.slug = 'diani'
ON DUPLICATE KEY UPDATE title = VALUES(title);

INSERT INTO packages (title, slug, category, destination_id, duration_days, price_from, short_description, description, inclusions, image_url, is_popular, sort_order)
VALUES ('Custom Private Tour', 'custom-private-tour', 'custom', NULL, 7, 0,
  'Built around your dates, pace, and interests.',
  'Tell us your dream itinerary — safari, coast, mountain, or multi-country — and we craft it privately.',
  'Dedicated planner|Private vehicle options|Flexible routing',
  'assets/images/experiences/private-safari.jpg', 0, 8)
ON DUPLICATE KEY UPDATE title = VALUES(title);

-- Vehicles
INSERT INTO vehicles (name, slug, category, capacity, price_per_day, description, features, image_url) VALUES
('Toyota Vellfire', 'toyota-vellfire', 'vellfire', 6, 18000,
 'Executive VIP van for airport runs and city transfers.',
 'Leather seats|AC|Wi-Fi option|Bottled water',
 'assets/images/vehicles/01-vellfire.jpg'),
('Safari Tour Van', 'safari-tour-van', 'safari_van', 8, 15000,
 'Pop-up roof safari van built for game drives.',
 'Pop-up roof|Charging ports|Cooler box|Experienced driver-guide',
 'assets/images/vehicles/02-safari-van.jpg'),
('Land Cruiser 4x4', 'land-cruiser-4x4', 'land_cruiser', 6, 22000,
 'Rugged 4x4 for rough tracks and remote parks.',
 '4WD|High clearance|Roof hatch|Safari seating',
 'assets/images/vehicles/03-land-cruiser.jpg'),
('Airport Transfer', 'airport-transfer', 'transfer', 4, 5000,
 'JKIA and Wilson meet-and-greet with fixed rates.',
 'Flight tracking|Meet & greet|Child seats on request',
 'assets/images/vehicles/04-airport.jpg'),
('Chauffeur Service', 'chauffeur-service', 'chauffeur', 3, 12000,
 'Hourly or full-day private chauffeur in Nairobi and beyond.',
 'Professional driver|Flexible hours|Discreet service',
 'assets/images/vehicles/05-chauffeur.jpg'),
('Wedding & Event Fleet', 'wedding-event-fleet', 'event', 12, 25000,
 'Decor-ready cars and vans for weddings and corporate events.',
 'Decor coordination|Multiple vehicles|On-time logistics',
 'assets/images/vehicles/06-wedding.jpg')
ON DUPLICATE KEY UPDATE name = VALUES(name), image_url = VALUES(image_url);

INSERT INTO drivers (name, phone, license_no, status) VALUES
('James Otieno', '+254711000001', 'DL-KE-10021', 'available'),
('Grace Wanjiku', '+254711000002', 'DL-KE-10045', 'available'),
('Peter Kiprop', '+254711000003', 'DL-KE-10102', 'on_trip')
ON DUPLICATE KEY UPDATE name = VALUES(name);
