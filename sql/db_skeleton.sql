CREATE TABLE `device` (
  `device_id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) NOT NULL,
  `device1` TINYINT(1) NOT NULL DEFAULT 0,
  `device2` TINYINT(1) NOT NULL DEFAULT 0,
  `device3` TINYINT(1) NOT NULL DEFAULT 0,
  `device4` TINYINT(1) NOT NULL DEFAULT 0,
  `device5` TINYINT(1) NOT NULL DEFAULT 0,
  `device6` TINYINT(1) NOT NULL DEFAULT 0,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`device_id`),
  UNIQUE KEY `unique_device` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `device_serial_data` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) NOT NULL,
  `serial_data` TEXT,
  `is_published` TINYINT(1) NOT NULL DEFAULT 0,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `device_setting` (
  `device_setting_id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) NOT NULL,
  `device_count` INT(11) DEFAULT NULL,
  `device1_name` VARCHAR(50) DEFAULT NULL,
  `device2_name` VARCHAR(50) DEFAULT NULL,
  `device3_name` VARCHAR(50) DEFAULT NULL,
  `device4_name` VARCHAR(50) DEFAULT NULL,
  `device5_name` VARCHAR(50) DEFAULT NULL,
  `device6_name` VARCHAR(50) DEFAULT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`device_setting_id`),
  UNIQUE KEY `unique_device_setting` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `location` (
  `location_id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) NOT NULL,
  `longitude` VARCHAR(50) NOT NULL,
  `latitude` VARCHAR(50) NOT NULL,
  `address` TEXT,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`location_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `menu` (
  `menu_id` INT(11) NOT NULL AUTO_INCREMENT,
  `menu_name` VARCHAR(50) NOT NULL,
  `menu_icon` VARCHAR(50) NOT NULL,
  `menu_url` VARCHAR(50) NULL,
  `menu_order` INT(5) NOT NULL,  
  `status` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`menu_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `sensor` (
  `sensor_id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) NOT NULL,
  `sensor1` VARCHAR(50) DEFAULT NULL,
  `sensor2` VARCHAR(50) DEFAULT NULL,
  `sensor3` VARCHAR(50) DEFAULT NULL,
  `sensor4` VARCHAR(50) DEFAULT NULL,
  `sensor5` VARCHAR(50) DEFAULT NULL,
  `sensor6` VARCHAR(50) DEFAULT NULL,
  `sensor7` VARCHAR(50) DEFAULT NULL,
  `sensor8` VARCHAR(50) DEFAULT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`sensor_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `sensor_setting` (
  `sensor_setting_id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) NOT NULL,
  `sensor_count` INT(11) DEFAULT NULL,
  `sensor1_name` VARCHAR(50) DEFAULT NULL,
  `sensor2_name` VARCHAR(50) DEFAULT NULL,
  `sensor3_name` VARCHAR(50) DEFAULT NULL,
  `sensor4_name` VARCHAR(50) DEFAULT NULL,
  `sensor5_name` VARCHAR(50) DEFAULT NULL,
  `sensor6_name` VARCHAR(50) DEFAULT NULL,
  `sensor7_name` VARCHAR(50) DEFAULT NULL,
  `sensor8_name` VARCHAR(50) DEFAULT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`sensor_setting_id`),
  UNIQUE KEY `unique_sensor_setting` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `sensor_type` (
  `sensor_type_id` INT(11) NOT NULL AUTO_INCREMENT,
  `sensor_name` VARCHAR(50) NOT NULL,
  `sensor_type` ENUM('Analog','Digital') NOT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`sensor_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `sub_menu` (
  `submenu_id` INT(11) NOT NULL AUTO_INCREMENT,
  `menu_id` int(11) NOT NULL,
  `submenu_name` VARCHAR(50) NOT NULL,
  `submenu_icon` VARCHAR(50) NULL,
  `submenu_url` VARCHAR(50) NOT NULL,
  `submenu_order` INT(5) NOT NULL,  
  `status` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`submenu_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `user` (
  `user_id` INT(11) NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(50) NOT NULL,
  `password` VARCHAR(150) NOT NULL,
  `email` VARCHAR(100) DEFAULT NULL,
  `mobile` VARCHAR(25) DEFAULT NULL,
  `role` VARCHAR(25) DEFAULT NULL,
  `project_title` TEXT NULL,
  `auth_token` VARCHAR(64) DEFAULT NULL,
  `forgot_pass_token` VARCHAR(64) DEFAULT NULL,
  `is_active` TINYINT(1) NOT NULL DEFAULT -1,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `unique_user` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `user_sensor_type` (
  `user_sensor_type_id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) NOT NULL,
  `sensor1_name` INT(11) DEFAULT NULL,
  `sensor1_pin` VARCHAR(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sensor1_low_threshold` INT(11) NOT NULL DEFAULT 0,
  `sensor1_high_threshold` INT(11) NOT NULL DEFAULT 0,
  `sensor2_name` INT(11) DEFAULT NULL,
  `sensor2_pin` VARCHAR(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sensor2_low_threshold` INT(11) NOT NULL DEFAULT 0,
  `sensor2_high_threshold` INT(11) NOT NULL DEFAULT 0,
  `sensor3_name` INT(11) DEFAULT NULL,
  `sensor3_pin` VARCHAR(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sensor3_low_threshold` INT(11) NOT NULL DEFAULT 0,
  `sensor3_high_threshold` INT(11) NOT NULL DEFAULT 0,
  `sensor4_name` INT(11) DEFAULT NULL,
  `sensor4_pin` VARCHAR(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sensor4_low_threshold` INT(11) NOT NULL DEFAULT 0,
  `sensor4_high_threshold` INT(11) NOT NULL DEFAULT 0,
  `sensor5_name` INT(11) DEFAULT NULL,
  `sensor5_pin` VARCHAR(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sensor5_low_threshold` INT(11) NOT NULL DEFAULT 0,
  `sensor5_high_threshold` INT(11) NOT NULL DEFAULT 0,
  `sensor6_name` INT(11) DEFAULT NULL,
  `sensor6_pin` VARCHAR(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sensor6_low_threshold` INT(11) NOT NULL DEFAULT 0,
  `sensor6_high_threshold` INT(11) NOT NULL DEFAULT 0,
  `sensor7_name` INT(11) DEFAULT NULL,
  `sensor7_pin` VARCHAR(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sensor7_low_threshold` INT(11) NOT NULL DEFAULT 0,
  `sensor7_high_threshold` INT(11) NOT NULL DEFAULT 0,
  `sensor8_name` INT(11) DEFAULT NULL,
  `sensor8_pin` VARCHAR(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sensor8_low_threshold` INT(11) NOT NULL DEFAULT 0,
  `sensor8_high_threshold` INT(11) NOT NULL DEFAULT 0,
  `is_published` TINYINT(1) NOT NULL DEFAULT 0,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_sensor_type_id`),
  UNIQUE KEY `unique_user_sensor_type` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
