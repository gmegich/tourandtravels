-- Nyika Safaris — legacy MySQL schema (reference only).
-- Prefer: database/supabase_schema.sql for Supabase Postgres.
-- Import via phpMyAdmin only if you still use local MySQL.

CREATE DATABASE IF NOT EXISTS nyika_safaris
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE nyika_safaris;

-- Admins
CREATE TABLE IF NOT EXISTS admins (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(120) NOT NULL,
  email VARCHAR(190) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  role VARCHAR(40) NOT NULL DEFAULT 'admin',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Destinations
CREATE TABLE IF NOT EXISTS destinations (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(160) NOT NULL,
  slug VARCHAR(180) NOT NULL UNIQUE,
  region VARCHAR(120) DEFAULT NULL,
  country VARCHAR(80) NOT NULL DEFAULT 'Kenya',
  short_description VARCHAR(500) DEFAULT NULL,
  description TEXT,
  image_url VARCHAR(500) DEFAULT NULL,
  highlights TEXT,
  best_time VARCHAR(200) DEFAULT NULL,
  is_featured TINYINT(1) NOT NULL DEFAULT 0,
  is_active TINYINT(1) NOT NULL DEFAULT 1,
  sort_order INT NOT NULL DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Tour packages
CREATE TABLE IF NOT EXISTS packages (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(200) NOT NULL,
  slug VARCHAR(220) NOT NULL UNIQUE,
  category ENUM(
    'safari','beach','city','mountain','family','honeymoon','custom'
  ) NOT NULL DEFAULT 'safari',
  destination_id INT UNSIGNED DEFAULT NULL,
  duration_days INT UNSIGNED DEFAULT 1,
  price_from DECIMAL(12,2) NOT NULL DEFAULT 0,
  currency CHAR(3) NOT NULL DEFAULT 'KES',
  short_description VARCHAR(500) DEFAULT NULL,
  description TEXT,
  inclusions TEXT,
  exclusions TEXT,
  image_url VARCHAR(500) DEFAULT NULL,
  is_popular TINYINT(1) NOT NULL DEFAULT 0,
  is_active TINYINT(1) NOT NULL DEFAULT 1,
  sort_order INT NOT NULL DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT fk_packages_destination
    FOREIGN KEY (destination_id) REFERENCES destinations(id)
    ON DELETE SET NULL
) ENGINE=InnoDB;

-- Vehicles
CREATE TABLE IF NOT EXISTS vehicles (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(160) NOT NULL,
  slug VARCHAR(180) NOT NULL UNIQUE,
  category ENUM(
    'vellfire','safari_van','land_cruiser','transfer','chauffeur','event'
  ) NOT NULL DEFAULT 'safari_van',
  capacity INT UNSIGNED DEFAULT 4,
  price_per_day DECIMAL(12,2) DEFAULT 0,
  description TEXT,
  features TEXT,
  image_url VARCHAR(500) DEFAULT NULL,
  is_available TINYINT(1) NOT NULL DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Customers
CREATE TABLE IF NOT EXISTS customers (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(160) NOT NULL,
  email VARCHAR(190) DEFAULT NULL,
  phone VARCHAR(40) DEFAULT NULL,
  country VARCHAR(80) DEFAULT NULL,
  notes TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX idx_customers_email (email),
  INDEX idx_customers_phone (phone)
) ENGINE=InnoDB;

-- Bookings
CREATE TABLE IF NOT EXISTS bookings (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  booking_ref VARCHAR(32) NOT NULL UNIQUE,
  customer_id INT UNSIGNED DEFAULT NULL,
  package_id INT UNSIGNED DEFAULT NULL,
  destination_id INT UNSIGNED DEFAULT NULL,
  vehicle_id INT UNSIGNED DEFAULT NULL,
  travel_start DATE DEFAULT NULL,
  travel_end DATE DEFAULT NULL,
  travelers INT UNSIGNED NOT NULL DEFAULT 1,
  special_requests TEXT,
  status ENUM(
    'new','confirmed','in_progress','completed','cancelled'
  ) NOT NULL DEFAULT 'new',
  total_amount DECIMAL(12,2) DEFAULT 0,
  currency CHAR(3) NOT NULL DEFAULT 'KES',
  source VARCHAR(40) NOT NULL DEFAULT 'website',
  assigned_driver_id INT UNSIGNED DEFAULT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT fk_bookings_customer FOREIGN KEY (customer_id) REFERENCES customers(id) ON DELETE SET NULL,
  CONSTRAINT fk_bookings_package FOREIGN KEY (package_id) REFERENCES packages(id) ON DELETE SET NULL,
  CONSTRAINT fk_bookings_destination FOREIGN KEY (destination_id) REFERENCES destinations(id) ON DELETE SET NULL,
  CONSTRAINT fk_bookings_vehicle FOREIGN KEY (vehicle_id) REFERENCES vehicles(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- Drivers
CREATE TABLE IF NOT EXISTS drivers (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(160) NOT NULL,
  phone VARCHAR(40) DEFAULT NULL,
  license_no VARCHAR(80) DEFAULT NULL,
  status ENUM('available','on_trip','off_duty') NOT NULL DEFAULT 'available',
  notes TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

ALTER TABLE bookings
  ADD CONSTRAINT fk_bookings_driver
  FOREIGN KEY (assigned_driver_id) REFERENCES drivers(id)
  ON DELETE SET NULL;

-- Tour schedules
CREATE TABLE IF NOT EXISTS tour_schedules (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  package_id INT UNSIGNED DEFAULT NULL,
  booking_id INT UNSIGNED DEFAULT NULL,
  title VARCHAR(200) NOT NULL,
  start_datetime DATETIME NOT NULL,
  end_datetime DATETIME DEFAULT NULL,
  meeting_point VARCHAR(255) DEFAULT NULL,
  notes TEXT,
  status ENUM('planned','active','done','cancelled') NOT NULL DEFAULT 'planned',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT fk_schedules_package FOREIGN KEY (package_id) REFERENCES packages(id) ON DELETE SET NULL,
  CONSTRAINT fk_schedules_booking FOREIGN KEY (booking_id) REFERENCES bookings(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- Payments (M-Pesa-ready structure)
CREATE TABLE IF NOT EXISTS payments (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  booking_id INT UNSIGNED DEFAULT NULL,
  customer_id INT UNSIGNED DEFAULT NULL,
  amount DECIMAL(12,2) NOT NULL,
  currency CHAR(3) NOT NULL DEFAULT 'KES',
  method ENUM('mpesa','cash','card','bank','other') NOT NULL DEFAULT 'mpesa',
  status ENUM('pending','paid','failed','refunded') NOT NULL DEFAULT 'pending',
  mpesa_receipt VARCHAR(80) DEFAULT NULL,
  mpesa_phone VARCHAR(40) DEFAULT NULL,
  mpesa_checkout_request_id VARCHAR(100) DEFAULT NULL,
  mpesa_merchant_request_id VARCHAR(100) DEFAULT NULL,
  notes TEXT,
  paid_at DATETIME DEFAULT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT fk_payments_booking FOREIGN KEY (booking_id) REFERENCES bookings(id) ON DELETE SET NULL,
  CONSTRAINT fk_payments_customer FOREIGN KEY (customer_id) REFERENCES customers(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- Expenses (basic profit tracking)
CREATE TABLE IF NOT EXISTS expenses (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  booking_id INT UNSIGNED DEFAULT NULL,
  category VARCHAR(80) NOT NULL DEFAULT 'ops',
  description VARCHAR(255) NOT NULL,
  amount DECIMAL(12,2) NOT NULL,
  expense_date DATE NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_expenses_booking FOREIGN KEY (booking_id) REFERENCES bookings(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- Customer inquiries (contact form)
CREATE TABLE IF NOT EXISTS inquiries (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(160) NOT NULL,
  phone VARCHAR(40) DEFAULT NULL,
  email VARCHAR(190) DEFAULT NULL,
  destination VARCHAR(160) DEFAULT NULL,
  travel_start DATE DEFAULT NULL,
  travel_end DATE DEFAULT NULL,
  travelers INT UNSIGNED DEFAULT 1,
  package_interest VARCHAR(200) DEFAULT NULL,
  message TEXT,
  status ENUM('new','contacted','converted','closed') NOT NULL DEFAULT 'new',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Notification log (email/WhatsApp hooks)
CREATE TABLE IF NOT EXISTS notification_logs (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  channel ENUM('email','whatsapp','sms') NOT NULL,
  recipient VARCHAR(190) NOT NULL,
  subject VARCHAR(255) DEFAULT NULL,
  body TEXT,
  status ENUM('queued','sent','failed','skipped') NOT NULL DEFAULT 'queued',
  related_type VARCHAR(40) DEFAULT NULL,
  related_id INT UNSIGNED DEFAULT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Default admin placeholder row (password set properly by install.php)
-- Legacy MySQL schema kept for reference. Prefer database/supabase_schema.sql.
INSERT INTO admins (name, email, password_hash, role)
SELECT 'Site Admin', 'gmegichuru@gmail.com',
  '$2y$10$Herx8jVIq8Qi/.eMfH9FHuug.E/SWUZuLTc/Eeal7dp2Gd6pH37yi',
  'admin'
WHERE NOT EXISTS (
  SELECT 1 FROM admins WHERE email = 'gmegichuru@gmail.com'
);
-- Password hash is bcrypt for admin123 — prefer Supabase + install.php.
