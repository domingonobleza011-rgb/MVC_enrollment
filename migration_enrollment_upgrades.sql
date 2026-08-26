-- ============================================================
-- EPAMNHS Enrollment System — Upgrade Migration
-- Adds: settings table (enrollment open/close + per-grade capacity),
--       LRN rate-limit attempts table, and self-heals enrollment_status
--       / reject_reason columns on any grade table that's missing them.
--
-- NOTE: The PHP code (classes/main.class.php) also self-heals all of
-- this automatically on first use via ensure_enrollment_upgrade_tables().
-- Running this file by hand is optional — it's here so the schema is
-- documented and so you can run it ahead of time instead of relying on
-- the first live request to create things.
-- ============================================================

-- ---------- Settings (key/value) ----------
CREATE TABLE IF NOT EXISTS tbl_settings (
    setting_key   VARCHAR(100) NOT NULL PRIMARY KEY,
    setting_value VARCHAR(255) NOT NULL DEFAULT '',
    updated_at    TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Seed: enrollment starts OPEN by default (matches the PHP default too,
-- this row is just here so the admin settings page has something to show
-- immediately instead of relying on the fallback default).
INSERT INTO tbl_settings (setting_key, setting_value)
VALUES ('enrollment_open', '1')
ON DUPLICATE KEY UPDATE setting_key = setting_key;

-- ---------- Per-LRN rate limiting ----------
CREATE TABLE IF NOT EXISTS tbl_lrn_attempts (
    id           INT AUTO_INCREMENT PRIMARY KEY,
    lrn          VARCHAR(50) NOT NULL,
    attempted_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_lrn_time (lrn, attempted_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------- Self-heal enrollment_status / reject_reason ----------
-- MySQL doesn't support "ADD COLUMN IF NOT EXISTS" on older 8.x versions,
-- so this uses a small stored procedure to check information_schema first.
-- Safe to run multiple times.

DELIMITER $$

DROP PROCEDURE IF EXISTS epamnhs_add_column_if_missing $$
CREATE PROCEDURE epamnhs_add_column_if_missing(
    IN p_table VARCHAR(64),
    IN p_column VARCHAR(64),
    IN p_definition VARCHAR(255)
)
BEGIN
    IF NOT EXISTS (
        SELECT 1 FROM information_schema.COLUMNS
        WHERE TABLE_SCHEMA = DATABASE()
          AND TABLE_NAME = p_table
          AND COLUMN_NAME = p_column
    ) THEN
        SET @ddl = CONCAT('ALTER TABLE ', p_table, ' ADD COLUMN ', p_column, ' ', p_definition);
        PREPARE stmt FROM @ddl;
        EXECUTE stmt;
        DEALLOCATE PREPARE stmt;
    END IF;
END $$

DELIMITER ;

CALL epamnhs_add_column_if_missing('tbl_seven',  'enrollment_status', "VARCHAR(20) NOT NULL DEFAULT 'Pending'");
CALL epamnhs_add_column_if_missing('tbl_seven',  'reject_reason',     'TEXT NULL DEFAULT NULL');
CALL epamnhs_add_column_if_missing('tbl_eight',  'enrollment_status', "VARCHAR(20) NOT NULL DEFAULT 'Pending'");
CALL epamnhs_add_column_if_missing('tbl_eight',  'reject_reason',     'TEXT NULL DEFAULT NULL');
CALL epamnhs_add_column_if_missing('tbl_nine',   'enrollment_status', "VARCHAR(20) NOT NULL DEFAULT 'Pending'");
CALL epamnhs_add_column_if_missing('tbl_nine',   'reject_reason',     'TEXT NULL DEFAULT NULL');
CALL epamnhs_add_column_if_missing('tbl_ten',    'enrollment_status', "VARCHAR(20) NOT NULL DEFAULT 'Pending'");
CALL epamnhs_add_column_if_missing('tbl_ten',    'reject_reason',     'TEXT NULL DEFAULT NULL');
CALL epamnhs_add_column_if_missing('tbl_eleven', 'enrollment_status', "VARCHAR(20) NOT NULL DEFAULT 'Pending'");
CALL epamnhs_add_column_if_missing('tbl_eleven', 'reject_reason',     'TEXT NULL DEFAULT NULL');
CALL epamnhs_add_column_if_missing('tbl_twelve', 'enrollment_status', "VARCHAR(20) NOT NULL DEFAULT 'Pending'");
CALL epamnhs_add_column_if_missing('tbl_twelve', 'reject_reason',     'TEXT NULL DEFAULT NULL');

DROP PROCEDURE IF EXISTS epamnhs_add_column_if_missing;

-- ============================================================
-- Done. New capabilities enabled by this migration + the matching PHP:
--   - tbl_settings:      enrollment_open (1/0), capacity_seven .. capacity_twelve
--   - tbl_lrn_attempts:  rolling window used for per-LRN submission rate limiting
--   - enrollment_status now also accepts 'Waitlisted' (no schema change
--     needed for that — it's just a VARCHAR(20) value like the others)
-- ============================================================
