CREATE TABLE IF NOT EXISTS clicks (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  canal ENUM('whatsapp','instagram') NOT NULL,
  source VARCHAR(80) DEFAULT NULL,
  pagina VARCHAR(255) DEFAULT NULL,
  ip VARCHAR(45) DEFAULT NULL,
  user_agent VARCHAR(255) DEFAULT NULL,
  created_at DATETIME NOT NULL,
  PRIMARY KEY (id),
  KEY idx_clicks_canal_created (canal, created_at),
  KEY idx_clicks_created (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
