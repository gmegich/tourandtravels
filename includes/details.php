<?php
declare(strict_types=1);

/**
 * Detailed itinerary / destination copy (used when DB fields are thin).
 * Mirrors the depth of East African safari planning sites like Tamu Adventures.
 */

function package_details_map(): array
{
    return [
        'classic-maasai-mara-safari' => [
            'destination_name' => 'Maasai Mara',
            'ideal_for' => 'First-time safari guests, couples, photographers',
            'highlights' => 'Dawn & afternoon game drives|Big cat tracking with expert guide|Optional hot-air balloon add-on|Sundowner experience',
            'description' => 'Three carefully paced days in Kenya’s most famous reserve. We balance early game drives with rest time so you stay sharp for wildlife — not exhausted by the road. Stay options range from mid-range camps to luxury lodges; tell us your budget and we shape the stay around it.',
            'inclusions' => 'Guided game drives|English-speaking safari guide|Park entry guidance & logistics|Bottled water on drives|Arrival meet & greet coordination',
            'exclusions' => 'International flights|Personal travel insurance|Alcoholic drinks|Hot-air balloon safari (optional extra)|Tips / gratuities',
            'itinerary' => [
                ['day' => 1, 'title' => 'Nairobi to Maasai Mara', 'body' => 'Depart Nairobi after breakfast (or meet on a scheduled flight into the Mara). Scenic drive via the Rift Valley escarpment with photo stops. Afternoon game drive on arrival. Settle into camp and evening briefing.'],
                ['day' => 2, 'title' => 'Full day in the Mara', 'body' => 'Sunrise drive when predators are most active. Midday rest at camp. Afternoon drive focusing on big cats, elephants, and riverine areas. Optional night game drive where permitted.'],
                ['day' => 3, 'title' => 'Morning drive & return', 'body' => 'Final early drive, then brunch and departure for Nairobi (or connect to Amboseli / coast extension). Drop-off at hotel, residence, or airport as arranged.'],
            ],
        ],
        'amboseli-elephant-escape' => [
            'destination_name' => 'Amboseli',
            'ideal_for' => 'Short escapes, photographers, Kilimanjaro views',
            'highlights' => 'Elephant herds on open plains|Mount Kilimanjaro backdrop|Observation Hill panorama|Birdlife around wetlands',
            'description' => 'A compact Amboseli safari ideal as a weekend break from Nairobi or a photography-focused add-on. Clear mornings often reveal Kilimanjaro above the elephants — we time drives for the best light.',
            'inclusions' => 'Guided game drives|Safari guide|Park fee support|Bottled water|Flexible Nairobi start/end',
            'exclusions' => 'Flights|Insurance|Meals unless stated in quote|Tips',
            'itinerary' => [
                ['day' => 1, 'title' => 'Nairobi to Amboseli', 'body' => 'Morning departure south toward Amboseli. Afternoon game drive across the dusty plains and swamps. Overnight near the park.'],
                ['day' => 2, 'title' => 'Sunrise plains & return', 'body' => 'Early drive for mountain views and elephant herds. Visit Observation Hill if time allows. Return to Nairobi by late afternoon.'],
            ],
        ],
        'diani-beach-break' => [
            'destination_name' => 'Diani Beach',
            'ideal_for' => 'Couples, honeymooners, post-safari unwind',
            'highlights' => 'White-sand beach time|Optional dhow / snorkeling|Colobus Conservation visit|Fresh seafood evenings',
            'description' => 'Four days on Kenya’s south coast after a safari — or as a standalone beach holiday. We arrange flights or road links, hotel recommendations, and optional water activities so your only decision is how slow to go.',
            'inclusions' => 'Flight or road link coordination|Hotel booking support|Local activity tips|WhatsApp concierge during stay',
            'exclusions' => 'Flights unless quoted|Meals & drinks|Watersports fees|Travel insurance',
            'itinerary' => [
                ['day' => 1, 'title' => 'Arrive Diani', 'body' => 'Transfer from Ukunda airstrip or Mombasa. Check in, beach time, and a light evening.'],
                ['day' => 2, 'title' => 'Coast day', 'body' => 'Free beach morning. Optional snorkeling, kite intro, or Colobus monkey sanctuary visit.'],
                ['day' => 3, 'title' => 'Leisure or day trip', 'body' => 'Optional Wasini / Kisite snorkeling day or spa and pool day at your hotel.'],
                ['day' => 4, 'title' => 'Departure', 'body' => 'Breakfast and transfer to airstrip or Mombasa for onward travel.'],
            ],
        ],
        'nairobi-city-highlights' => [
            'destination_name' => 'Nairobi',
            'ideal_for' => 'Arrival/departure days, short stopovers',
            'highlights' => 'Nairobi National Park|Giraffe Centre|Karen Blixen / Sheldrick options|City dining tips',
            'description' => 'A full private day in Nairobi designed around your flight times. Ideal when you land early or leave late and want wildlife without leaving the capital.',
            'inclusions' => 'Private city guide|Flexible itinerary|Entrance fee guidance|Bottled water',
            'exclusions' => 'Park & attraction tickets (pay on site or prepay)|Meals|Tips',
            'itinerary' => [
                ['day' => 1, 'title' => 'City safari day', 'body' => 'Morning Nairobi National Park game drive. Midday Giraffe Centre. Afternoon Karen heritage stop or elephant orphanage (seasonal schedules). Drop at hotel or airport.'],
            ],
        ],
        'mount-kenya-hiking-trek' => [
            'destination_name' => 'Mount Kenya',
            'ideal_for' => 'Fit hikers, adventure travelers',
            'highlights' => 'Guided alpine trek|Porter support|Scenic Chogoria or Naro Moru routes|Safety-first pacing',
            'description' => 'A five-day Mount Kenya trek with experienced mountain guides and porter logistics. Route choice depends on fitness and weather — we brief you clearly before you commit.',
            'inclusions' => 'Mountain guides|Porter arrangement|Park logistics support|Safety briefing',
            'exclusions' => 'Personal gear hire|Park fees if not in quote|Insurance (mandatory)|Tips',
            'itinerary' => [
                ['day' => 1, 'title' => 'Nairobi to trailhead', 'body' => 'Transfer to park gate, meet crew, begin ascent to first camp.'],
                ['day' => 2, 'title' => 'Ascend through forest & moorland', 'body' => 'Steady hiking with acclimatization focus. Overnight at higher camp.'],
                ['day' => 3, 'title' => 'High camp', 'body' => 'Reach alpine zone. Rest, hydrate, prepare for summit push if route includes it.'],
                ['day' => 4, 'title' => 'Summit attempt / scenic high point', 'body' => 'Early start for Point Lenana or agreed high point, then descend.'],
                ['day' => 5, 'title' => 'Descend & return Nairobi', 'body' => 'Final descent, certificate arrangements where applicable, transfer to Nairobi.'],
            ],
        ],
        'family-mara-adventure' => [
            'destination_name' => 'Maasai Mara',
            'ideal_for' => 'Families with children, multi-generation groups',
            'highlights' => 'Shorter game drives|Kid-friendly camps|Flexible meal stops|Family-friendly pacing',
            'description' => 'A four-day Mara safari paced for families. Shorter morning drives, lodge pools when needed, and guides who enjoy sharing wildlife stories with kids.',
            'inclusions' => 'Family-paced game drives|Guide experienced with children|Flexible schedule|Park logistics',
            'exclusions' => 'Flights|Insurance|Extra activities|Tips',
            'itinerary' => [
                ['day' => 1, 'title' => 'Travel to the Mara', 'body' => 'Comfortable transfer with snack stops. Soft afternoon drive. Settle into family rooms/tents.'],
                ['day' => 2, 'title' => 'Wildlife & downtime', 'body' => 'Morning drive, midday pool/rest, afternoon drive. Optional cultural visit.'],
                ['day' => 3, 'title' => 'Another full safari day', 'body' => 'Choose focus: cats, elephants, or scenic picnic breakfast in the bush (where allowed).'],
                ['day' => 4, 'title' => 'Return', 'body' => 'Short morning outing then return to Nairobi with flexible drop-off.'],
            ],
        ],
        'coast-honeymoon-escape' => [
            'destination_name' => 'Diani Beach',
            'ideal_for' => 'Honeymooners, anniversary couples',
            'highlights' => 'Seamless arrivals|Romantic beach stay tips|Optional candlelit dinner|Slow pacing',
            'description' => 'Five days designed for newlyweds: seamless arrivals, quiet beach hotels or villas, and optional add-ons like a private dhow sunset. Pair with a short Amboseli or Mara safari if you want wildlife first.',
            'inclusions' => 'Airport/airstrip arrival support|Stay recommendations & booking support|Honeymoon extras coordination|WhatsApp planner',
            'exclusions' => 'Flights|Meals not specified|Spa treatments|Insurance',
            'itinerary' => [
                ['day' => 1, 'title' => 'Arrive in style', 'body' => 'Meet on arrival and check in. Evening free for beach or spa.'],
                ['day' => 2, 'title' => 'Beach day', 'body' => 'Leisure morning. Optional couple’s massage or snorkeling.'],
                ['day' => 3, 'title' => 'Romance add-on', 'body' => 'Optional private dinner setup or dhow sunset cruise.'],
                ['day' => 4, 'title' => 'Free day', 'body' => 'Fully flexible — we help book any last activities.'],
                ['day' => 5, 'title' => 'Departure', 'body' => 'Transfer for flight home or safari extension.'],
            ],
        ],
        'custom-private-tour' => [
            'destination_name' => 'Custom East Africa',
            'ideal_for' => 'Travelers with specific dates, interests, or multi-country plans',
            'highlights' => 'Fully tailored routing|Mix safari + beach + culture|Cross-border options|One dedicated planner',
            'description' => 'Tell us your dates, group size, budget band, and must-sees. We reply with a clear outline: nights per park, lodge options, estimated costs, and alternatives. Ideal for Serengeti add-ons, gorilla permits planning, or corporate incentive groups.',
            'inclusions' => 'Dedicated trip planner|Custom itinerary PDF|Lodge & activity coordination|WhatsApp support throughout',
            'exclusions' => 'Depends on final plan — listed clearly in your quote',
            'itinerary' => [
                ['day' => 1, 'title' => 'Inquiry & discovery', 'body' => 'Share dates, travelers, interests, and budget. We confirm feasibility within hours.'],
                ['day' => 2, 'title' => 'Draft itinerary', 'body' => 'You receive a day-by-day outline with lodge options and rough costing.'],
                ['day' => 3, 'title' => 'Refine & confirm', 'body' => 'Adjust pace, rooms, and activities. Pay deposit to lock lodges and key bookings.'],
                ['day' => 4, 'title' => 'Pre-trip briefing', 'body' => 'Packing list, park rules, contacts, and emergency plan shared before travel.'],
                ['day' => 5, 'title' => 'On-trip support', 'body' => 'Your planner stays reachable on WhatsApp for changes while you travel.'],
                ['day' => 6, 'title' => 'Flexible middle days', 'body' => 'Safari, beach, or city blocks as designed for your group.'],
                ['day' => 7, 'title' => 'Departure', 'body' => 'Departure support and trip wrap-up. Feedback welcome for future travel.'],
            ],
        ],
    ];
}

function destination_details_map(): array
{
    return [
        'maasai-mara' => [
            'description' => 'The Maasai Mara is the northern extension of the Serengeti ecosystem — open grasslands, acacia-dotted plains, and one of the densest big-cat populations in Africa. From July to October the Great Migration often surges across the Mara River. Year-round, resident wildlife makes every visit rewarding. We plan drives around light, water sources, and your pace — not a rigid checklist.',
            'wildlife' => 'Lion|Leopard|Cheetah|Elephant|Buffalo|Wildebeest & zebra (seasonal)|Hippo|Crocodile',
            'activities' => 'Game drives|Hot-air balloon safari|Maasai village visit|Scenic flights|Photographic hides (lodge-dependent)',
            'getting_there' => '5–6 hour road transfer from Nairobi, or 45-minute scheduled flight into the Mara airstrips.',
        ],
        'amboseli' => [
            'description' => 'Amboseli is famous for elephant herds framed by Mount Kilimanjaro. Open plains, swamps, and Observation Hill create classic East African photography. Mornings are best for mountain views before clouds build.',
            'wildlife' => 'Elephant|Lion|Cheetah|Hyena|Zebra|Wildebeest|Rich birdlife',
            'activities' => 'Game drives|Observation Hill|Cultural visits|Photography focus mornings',
            'getting_there' => 'About 4 hours by road from Nairobi, or short flight to Amboseli airstrip.',
        ],
        'diani' => [
            'description' => 'Diani Beach offers powder sand, turquoise water, and a relaxed south-coast atmosphere. Ideal after safari days — or as a standalone beach holiday with optional water sports and dhow trips.',
            'wildlife' => 'Colobus monkeys|Coastal birds|Marine life on reefs',
            'activities' => 'Beach time|Snorkeling|Kite surfing|Dhow cruises|Spa & dining',
            'getting_there' => 'Fly into Ukunda (Ukunda/Diani) or transfer from Mombasa / Moi International.',
        ],
        'mombasa' => [
            'description' => 'Mombasa blends Swahili history with Indian Ocean energy. Old Town lanes, Fort Jesus, and nearby north-coast beaches make it a strong coastal hub for longer Kenya itineraries.',
            'wildlife' => 'Marine life|Coastal birds',
            'activities' => 'Fort Jesus|Old Town walking|Nyali / Bamburi beaches|Seafood dining',
            'getting_there' => 'Direct flights to Mombasa or overnight train/road from Nairobi.',
        ],
        'nairobi' => [
            'description' => 'Kenya’s capital is also a wildlife gateway: Nairobi National Park sits against the skyline. Use arrival or departure days for giraffe centres, museums, and Karen heritage before heading to the parks.',
            'wildlife' => 'Rhino|Lion|Giraffe|Buffalo|Urban birdlife',
            'activities' => 'Nairobi National Park|Giraffe Centre|Sheldrick orphanage (booking required)|City markets & dining',
            'getting_there' => 'JKIA and Wilson Airport; we arrange meet-and-greet and hotel handovers.',
        ],
        'naivasha' => [
            'description' => 'Lake Naivasha is a calm Rift Valley stop — boat rides among hippos, Crescent Island walking safari, and Hell’s Gate cycling or hiking. Perfect between Nairobi and the Mara.',
            'wildlife' => 'Hippo|Giraffe|Zebra|Fish eagles|Pelicans',
            'activities' => 'Boat safari|Crescent Island walk|Hell’s Gate|Geothermal viewpoints',
            'getting_there' => 'About 1.5–2 hours from Nairobi by road.',
        ],
        'samburu' => [
            'description' => 'Samburu’s semi-arid landscapes host the “special five”: Grevy’s zebra, reticulated giraffe, Somali ostrich, gerenuk, and Beisa oryx. Dramatic, less crowded, and culturally rich.',
            'wildlife' => 'Grevy’s zebra|Reticulated giraffe|Gerenuk|Oryx|Elephant|Lion',
            'activities' => 'Game drives|Riverine walks (guided)|Cultural visits|Photography',
            'getting_there' => 'Road via Isiolo (~5–6 hours) or scheduled flight to Samburu / Buffalo Springs airstrips.',
        ],
        'tsavo' => [
            'description' => 'Tsavo East and West form a vast wilderness of red earth, lava flows, and open horizons. Famous for red-dusted elephants and a sense of raw space few parks still offer.',
            'wildlife' => 'Red elephants|Lion|Giraffe|Zebra|Lesser kudu|Birds',
            'activities' => 'Game drives|Mzima Springs|Scenic viewpoints|Long-lens photography',
            'getting_there' => 'On the Nairobi–Mombasa corridor by road, or via local airstrips.',
        ],
        'zanzibar' => [
            'description' => 'Extend Kenya with Zanzibar’s Stone Town UNESCO heritage, spice tours, and reef-fringed beaches. We coordinate flights from Nairobi or Mombasa and hotel handovers.',
            'wildlife' => 'Marine life|Coastal birds',
            'activities' => 'Stone Town|Spice tour|Nungwi / Kendwa beaches|Snorkeling & diving',
            'getting_there' => 'Flights via Dar es Salaam, Zanzibar (ZNZ), or regional connections we arrange.',
        ],
        'uganda-tanzania' => [
            'description' => 'Cross-border journeys for gorilla trekking in Uganda or Serengeti / Ngorongoro extensions in Tanzania. We handle permits guidance, border logistics, and seamless flight or overland connections.',
            'wildlife' => 'Mountain gorilla|Chimpanzee|Serengeti migration|Ngorongoro crater wildlife',
            'activities' => 'Gorilla trekking|Serengeti drives|Crater descent|Multi-country routing',
            'getting_there' => 'Regional flights and overland links planned around permit dates.',
        ],
    ];
}

function site_faqs(): array
{
    return [
        ['q' => 'How do I start planning a trip?', 'a' => 'Send your dates, number of travelers, preferred destinations, and budget band via our booking form or WhatsApp. We reply with a clear outline and options — usually within a few hours during the day.'],
        ['q' => 'Are park fees included?', 'a' => 'It depends on the package. Your quote always lists what is included and excluded. Many itineraries include park-fee guidance and logistics; some fees are paid separately or prepaid on your behalf.'],
        ['q' => 'What kinds of trips can you plan?', 'a' => 'Safari packages (private or group joining), beach extensions, honeymoons, family holidays, Mount Kenya treks, Nairobi stopovers, and custom multi-country East Africa itineraries.'],
        ['q' => 'Can you arrange flights inside Kenya?', 'a' => 'Yes. We coordinate scheduled safari flights (for example Nairobi–Mara) and advise when flying saves time versus road links between parks.'],
        ['q' => 'Is travel insurance required?', 'a' => 'Strongly recommended for all guests, and mandatory for mountain treks. We can outline what cover to look for (medical, evacuation, trip interruption).'],
        ['q' => 'Do you offer custom and multi-country trips?', 'a' => 'Yes. Custom Private Tour covers tailored Kenya circuits plus Tanzania or Uganda extensions, including gorilla-permit timing guidance.'],
        ['q' => 'What is the best time for the Great Migration?', 'a' => 'In the Maasai Mara, river crossings are most likely July–October, but exact timing shifts yearly. We monitor conditions and adjust routing when possible.'],
        ['q' => 'How do payments and confirmation work?', 'a' => 'After you approve the itinerary, a deposit secures lodges and key bookings. Balance timing is stated in your quote. You receive a written confirmation and emergency contacts before travel.'],
    ];
}

function planning_steps(): array
{
    return [
        ['num' => '01', 'title' => 'Share your brief', 'body' => 'Dates, travelers, interests (wildlife, beach, hiking), pace, and budget. WhatsApp or the booking form both work.'],
        ['num' => '02', 'title' => 'Receive a clear plan', 'body' => 'We send a day-by-day outline with lodge tiers, activities, and an itemized estimate so nothing feels vague.'],
        ['num' => '03', 'title' => 'Refine together', 'body' => 'Swap lodges, add a balloon safari, adjust pace, or insert a beach ending — we revise until it fits.'],
        ['num' => '04', 'title' => 'Confirm & travel', 'body' => 'Deposit locks the trip. You get vouchers, contacts, and packing notes. Your planner stays on WhatsApp throughout.'],
    ];
}

function experience_cards(): array
{
    return [
        ['title' => 'Wildlife safaris', 'text' => 'Maasai Mara, Amboseli, Tsavo, Samburu — paced game drives with guides who know the land.', 'href' => 'tours.php?filter=safari', 'image' => 'https://images.unsplash.com/photo-1516426122078-c23e76319801?w=900&q=80'],
        ['title' => 'Beach escapes', 'text' => 'Diani and Mombasa coast time after safari — or a standalone sand-and-sea holiday.', 'href' => 'tours.php?filter=beach', 'image' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=900&q=80'],
        ['title' => 'Honeymoons', 'text' => 'Romantic stays and optional safari–beach combinations planned around your dates.', 'href' => 'tours.php?filter=honeymoon', 'image' => 'https://images.unsplash.com/photo-1520854221256-17451cc331bf?w=900&q=80'],
        ['title' => 'Family journeys', 'text' => 'Softer schedules, family rooms, and guides who make wildlife fun for kids.', 'href' => 'tours.php?filter=family', 'image' => 'https://images.unsplash.com/photo-1547471080-7cc2caa01a7e?w=900&q=80'],
        ['title' => 'Mountain treks', 'text' => 'Mount Kenya routes with guides, porters, and safety-first pacing.', 'href' => 'tours.php?filter=mountain', 'image' => 'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?w=900&q=80'],
        ['title' => 'Private & custom', 'text' => 'Built around your dates — including Tanzania and Uganda extensions.', 'href' => 'tour.php?slug=custom-private-tour', 'image' => 'assets/images/experiences/private-safari.jpg'],
    ];
}

function enrich_package(array $p): array
{
    $slug = (string) ($p['slug'] ?? '');
    $extra = package_details_map()[$slug] ?? null;
    if ($slug === 'custom-private-tour') {
        $local = 'assets/images/experiences/private-safari.jpg';
        if (is_file(dirname(__DIR__) . '/' . $local)) {
            $p['image_url'] = asset_url($local);
        }
    }
    if (!$extra) {
        return $p;
    }
    foreach (['description', 'ideal_for', 'destination_name'] as $key) {
        if (empty($p[$key]) && !empty($extra[$key])) {
            $p[$key] = $extra[$key];
        }
    }
    if (empty($p['inclusions']) && !empty($extra['inclusions'])) {
        $p['inclusions'] = $extra['inclusions'];
    }
    if (empty($p['exclusions']) && !empty($extra['exclusions'])) {
        $p['exclusions'] = $extra['exclusions'];
    }
    if (empty($p['highlights']) && !empty($extra['highlights'])) {
        $p['highlights'] = $extra['highlights'];
    }
    $p['itinerary'] = $extra['itinerary'] ?? [];
    if (empty($p['short_description']) && !empty($extra['description'])) {
        $p['short_description'] = substr(strip_tags((string) $extra['description']), 0, 140) . '…';
    }
    return $p;
}

function enrich_destination(array $d): array
{
    $slug = (string) ($d['slug'] ?? '');
    $extra = destination_details_map()[$slug] ?? null;
    if (!$extra) {
        return $d;
    }
    if (empty($d['description']) && !empty($extra['description'])) {
        $d['description'] = $extra['description'];
    } elseif (!empty($extra['description']) && strlen((string) ($d['description'] ?? '')) < 120) {
        $d['description'] = $extra['description'];
    }
    $d['wildlife'] = $extra['wildlife'] ?? ($d['wildlife'] ?? '');
    $d['activities'] = $extra['activities'] ?? ($d['activities'] ?? '');
    $d['getting_there'] = $extra['getting_there'] ?? ($d['getting_there'] ?? '');
    return $d;
}

function pipe_list(?string $value): array
{
    if ($value === null || trim($value) === '') {
        return [];
    }
    return array_values(array_filter(array_map('trim', explode('|', $value)), fn($x) => $x !== ''));
}
