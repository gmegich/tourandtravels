-- Nyika Safaris — Supabase (Postgres) schema
-- Paste into Supabase Dashboard → SQL Editor → New query → Run
-- Do NOT create a database; Supabase already provides "postgres".

-- Updated timestamps helper
CREATE OR REPLACE FUNCTION set_updated_at()
RETURNS TRIGGER AS $$
BEGIN
  NEW.updated_at = CURRENT_TIMESTAMP;
  RETURN NEW;
END;
$$ LANGUAGE plpgsql;

-- Admins
CREATE TABLE IF NOT EXISTS admins (
  id SERIAL PRIMARY KEY,
  name VARCHAR(120) NOT NULL,
  email VARCHAR(190) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  role VARCHAR(40) NOT NULL DEFAULT 'admin',
  created_at TIMESTAMPTZ NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMPTZ NOT NULL DEFAULT CURRENT_TIMESTAMP
);

DROP TRIGGER IF EXISTS trg_admins_updated_at ON admins;
CREATE TRIGGER trg_admins_updated_at
  BEFORE UPDATE ON admins
  FOR EACH ROW EXECUTE PROCEDURE set_updated_at();

-- Destinations
CREATE TABLE IF NOT EXISTS destinations (
  id SERIAL PRIMARY KEY,
  name VARCHAR(160) NOT NULL,
  slug VARCHAR(180) NOT NULL UNIQUE,
  region VARCHAR(120) DEFAULT NULL,
  country VARCHAR(80) NOT NULL DEFAULT 'Kenya',
  short_description VARCHAR(500) DEFAULT NULL,
  description TEXT,
  image_url VARCHAR(500) DEFAULT NULL,
  highlights TEXT,
  best_time VARCHAR(200) DEFAULT NULL,
  is_featured SMALLINT NOT NULL DEFAULT 0,
  is_active SMALLINT NOT NULL DEFAULT 1,
  sort_order INT NOT NULL DEFAULT 0,
  created_at TIMESTAMPTZ NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMPTZ NOT NULL DEFAULT CURRENT_TIMESTAMP
);

DROP TRIGGER IF EXISTS trg_destinations_updated_at ON destinations;
CREATE TRIGGER trg_destinations_updated_at
  BEFORE UPDATE ON destinations
  FOR EACH ROW EXECUTE PROCEDURE set_updated_at();

-- Tour packages
CREATE TABLE IF NOT EXISTS packages (
  id SERIAL PRIMARY KEY,
  title VARCHAR(200) NOT NULL,
  slug VARCHAR(220) NOT NULL UNIQUE,
  category VARCHAR(40) NOT NULL DEFAULT 'safari'
    CHECK (category IN ('safari','beach','city','mountain','family','honeymoon','custom')),
  destination_id INT DEFAULT NULL REFERENCES destinations(id) ON DELETE SET NULL,
  duration_days INT DEFAULT 1,
  price_from NUMERIC(12,2) NOT NULL DEFAULT 0,
  currency CHAR(3) NOT NULL DEFAULT 'KES',
  short_description VARCHAR(500) DEFAULT NULL,
  description TEXT,
  inclusions TEXT,
  exclusions TEXT,
  image_url VARCHAR(500) DEFAULT NULL,
  is_popular SMALLINT NOT NULL DEFAULT 0,
  is_active SMALLINT NOT NULL DEFAULT 1,
  sort_order INT NOT NULL DEFAULT 0,
  created_at TIMESTAMPTZ NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMPTZ NOT NULL DEFAULT CURRENT_TIMESTAMP
);

DROP TRIGGER IF EXISTS trg_packages_updated_at ON packages;
CREATE TRIGGER trg_packages_updated_at
  BEFORE UPDATE ON packages
  FOR EACH ROW EXECUTE PROCEDURE set_updated_at();

-- Vehicles
CREATE TABLE IF NOT EXISTS vehicles (
  id SERIAL PRIMARY KEY,
  name VARCHAR(160) NOT NULL,
  slug VARCHAR(180) NOT NULL UNIQUE,
  category VARCHAR(40) NOT NULL DEFAULT 'safari_van'
    CHECK (category IN ('vellfire','safari_van','land_cruiser','transfer','chauffeur','event')),
  capacity INT DEFAULT 4,
  price_per_day NUMERIC(12,2) DEFAULT 0,
  description TEXT,
  features TEXT,
  image_url VARCHAR(500) DEFAULT NULL,
  is_available SMALLINT NOT NULL DEFAULT 1,
  created_at TIMESTAMPTZ NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMPTZ NOT NULL DEFAULT CURRENT_TIMESTAMP
);

DROP TRIGGER IF EXISTS trg_vehicles_updated_at ON vehicles;
CREATE TRIGGER trg_vehicles_updated_at
  BEFORE UPDATE ON vehicles
  FOR EACH ROW EXECUTE PROCEDURE set_updated_at();

-- Customers
CREATE TABLE IF NOT EXISTS customers (
  id SERIAL PRIMARY KEY,
  name VARCHAR(160) NOT NULL,
  email VARCHAR(190) DEFAULT NULL,
  phone VARCHAR(40) DEFAULT NULL,
  country VARCHAR(80) DEFAULT NULL,
  notes TEXT,
  created_at TIMESTAMPTZ NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMPTZ NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE INDEX IF NOT EXISTS idx_customers_email ON customers(email);
CREATE INDEX IF NOT EXISTS idx_customers_phone ON customers(phone);

DROP TRIGGER IF EXISTS trg_customers_updated_at ON customers;
CREATE TRIGGER trg_customers_updated_at
  BEFORE UPDATE ON customers
  FOR EACH ROW EXECUTE PROCEDURE set_updated_at();

-- Drivers (before bookings FK for assigned_driver_id)
CREATE TABLE IF NOT EXISTS drivers (
  id SERIAL PRIMARY KEY,
  name VARCHAR(160) NOT NULL,
  phone VARCHAR(40) DEFAULT NULL,
  license_no VARCHAR(80) DEFAULT NULL,
  status VARCHAR(40) NOT NULL DEFAULT 'available'
    CHECK (status IN ('available','on_trip','off_duty')),
  notes TEXT,
  created_at TIMESTAMPTZ NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMPTZ NOT NULL DEFAULT CURRENT_TIMESTAMP
);

DROP TRIGGER IF EXISTS trg_drivers_updated_at ON drivers;
CREATE TRIGGER trg_drivers_updated_at
  BEFORE UPDATE ON drivers
  FOR EACH ROW EXECUTE PROCEDURE set_updated_at();

-- Bookings
CREATE TABLE IF NOT EXISTS bookings (
  id SERIAL PRIMARY KEY,
  booking_ref VARCHAR(32) NOT NULL UNIQUE,
  customer_id INT DEFAULT NULL REFERENCES customers(id) ON DELETE SET NULL,
  package_id INT DEFAULT NULL REFERENCES packages(id) ON DELETE SET NULL,
  destination_id INT DEFAULT NULL REFERENCES destinations(id) ON DELETE SET NULL,
  vehicle_id INT DEFAULT NULL REFERENCES vehicles(id) ON DELETE SET NULL,
  travel_start DATE DEFAULT NULL,
  travel_end DATE DEFAULT NULL,
  travelers INT NOT NULL DEFAULT 1,
  special_requests TEXT,
  status VARCHAR(40) NOT NULL DEFAULT 'new'
    CHECK (status IN ('new','confirmed','in_progress','completed','cancelled')),
  total_amount NUMERIC(12,2) DEFAULT 0,
  currency CHAR(3) NOT NULL DEFAULT 'KES',
  source VARCHAR(40) NOT NULL DEFAULT 'website',
  assigned_driver_id INT DEFAULT NULL REFERENCES drivers(id) ON DELETE SET NULL,
  created_at TIMESTAMPTZ NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMPTZ NOT NULL DEFAULT CURRENT_TIMESTAMP
);

DROP TRIGGER IF EXISTS trg_bookings_updated_at ON bookings;
CREATE TRIGGER trg_bookings_updated_at
  BEFORE UPDATE ON bookings
  FOR EACH ROW EXECUTE PROCEDURE set_updated_at();

-- Tour schedules
CREATE TABLE IF NOT EXISTS tour_schedules (
  id SERIAL PRIMARY KEY,
  package_id INT DEFAULT NULL REFERENCES packages(id) ON DELETE SET NULL,
  booking_id INT DEFAULT NULL REFERENCES bookings(id) ON DELETE SET NULL,
  title VARCHAR(200) NOT NULL,
  start_datetime TIMESTAMPTZ NOT NULL,
  end_datetime TIMESTAMPTZ DEFAULT NULL,
  meeting_point VARCHAR(255) DEFAULT NULL,
  notes TEXT,
  status VARCHAR(40) NOT NULL DEFAULT 'planned'
    CHECK (status IN ('planned','active','done','cancelled')),
  created_at TIMESTAMPTZ NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMPTZ NOT NULL DEFAULT CURRENT_TIMESTAMP
);

DROP TRIGGER IF EXISTS trg_tour_schedules_updated_at ON tour_schedules;
CREATE TRIGGER trg_tour_schedules_updated_at
  BEFORE UPDATE ON tour_schedules
  FOR EACH ROW EXECUTE PROCEDURE set_updated_at();

-- Payments (M-Pesa-ready structure)
CREATE TABLE IF NOT EXISTS payments (
  id SERIAL PRIMARY KEY,
  booking_id INT DEFAULT NULL REFERENCES bookings(id) ON DELETE SET NULL,
  customer_id INT DEFAULT NULL REFERENCES customers(id) ON DELETE SET NULL,
  amount NUMERIC(12,2) NOT NULL,
  currency CHAR(3) NOT NULL DEFAULT 'KES',
  method VARCHAR(40) NOT NULL DEFAULT 'mpesa'
    CHECK (method IN ('mpesa','cash','card','bank','other')),
  status VARCHAR(40) NOT NULL DEFAULT 'pending'
    CHECK (status IN ('pending','paid','failed','refunded')),
  mpesa_receipt VARCHAR(80) DEFAULT NULL,
  mpesa_phone VARCHAR(40) DEFAULT NULL,
  mpesa_checkout_request_id VARCHAR(100) DEFAULT NULL,
  mpesa_merchant_request_id VARCHAR(100) DEFAULT NULL,
  notes TEXT,
  paid_at TIMESTAMPTZ DEFAULT NULL,
  created_at TIMESTAMPTZ NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMPTZ NOT NULL DEFAULT CURRENT_TIMESTAMP
);

DROP TRIGGER IF EXISTS trg_payments_updated_at ON payments;
CREATE TRIGGER trg_payments_updated_at
  BEFORE UPDATE ON payments
  FOR EACH ROW EXECUTE PROCEDURE set_updated_at();

-- Expenses (basic profit tracking)
CREATE TABLE IF NOT EXISTS expenses (
  id SERIAL PRIMARY KEY,
  booking_id INT DEFAULT NULL REFERENCES bookings(id) ON DELETE SET NULL,
  category VARCHAR(80) NOT NULL DEFAULT 'ops',
  description VARCHAR(255) NOT NULL,
  amount NUMERIC(12,2) NOT NULL,
  expense_date DATE NOT NULL,
  created_at TIMESTAMPTZ NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- Customer inquiries (contact form)
CREATE TABLE IF NOT EXISTS inquiries (
  id SERIAL PRIMARY KEY,
  name VARCHAR(160) NOT NULL,
  phone VARCHAR(40) DEFAULT NULL,
  email VARCHAR(190) DEFAULT NULL,
  destination VARCHAR(160) DEFAULT NULL,
  travel_start DATE DEFAULT NULL,
  travel_end DATE DEFAULT NULL,
  travelers INT DEFAULT 1,
  package_interest VARCHAR(200) DEFAULT NULL,
  message TEXT,
  status VARCHAR(40) NOT NULL DEFAULT 'new'
    CHECK (status IN ('new','contacted','converted','closed')),
  created_at TIMESTAMPTZ NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMPTZ NOT NULL DEFAULT CURRENT_TIMESTAMP
);

DROP TRIGGER IF EXISTS trg_inquiries_updated_at ON inquiries;
CREATE TRIGGER trg_inquiries_updated_at
  BEFORE UPDATE ON inquiries
  FOR EACH ROW EXECUTE PROCEDURE set_updated_at();

-- Notification log (email/WhatsApp hooks)
CREATE TABLE IF NOT EXISTS notification_logs (
  id SERIAL PRIMARY KEY,
  channel VARCHAR(40) NOT NULL
    CHECK (channel IN ('email','whatsapp','sms')),
  recipient VARCHAR(190) NOT NULL,
  subject VARCHAR(255) DEFAULT NULL,
  body TEXT,
  status VARCHAR(40) NOT NULL DEFAULT 'queued'
    CHECK (status IN ('queued','sent','failed','skipped')),
  related_type VARCHAR(40) DEFAULT NULL,
  related_id INT DEFAULT NULL,
  created_at TIMESTAMPTZ NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- Optional: allow anon/authenticated access via PostgREST later.
-- For this PHP site, the service connects with the DB password (PDO),
-- so RLS can stay disabled on these tables, or you can enable RLS and
-- grant only to your backend role. Default: no RLS policies (tables public
-- to the postgres role used by PDO).

-- Placeholder admin (password set by install.php to ADMIN_DEFAULT_PASSWORD)
INSERT INTO admins (name, email, password_hash, role)
SELECT 'Site Admin', 'gmegichuru@gmail.com',
  '$2y$10$Herx8jVIq8Qi/.eMfH9FHuug.E/SWUZuLTc/Eeal7dp2Gd6pH37yi',
  'admin'
WHERE NOT EXISTS (
  SELECT 1 FROM admins WHERE email = 'gmegichuru@gmail.com'
);
-- Hash above is bcrypt for: admin123 — run install.php to refresh if needed.
