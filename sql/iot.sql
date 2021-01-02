CREATE TABLE `user` (
  `user_id` INT(11) NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(50) NOT NULL,
  `password` VARCHAR(150) NOT NULL,
  `email` VARCHAR(100) DEFAULT NULL,
  `mobile` VARCHAR(25) DEFAULT NULL,
  `role` VARCHAR(25) DEFAULT NULL,
  `auth_token` VARCHAR(64) DEFAULT NULL,
  `forgot_pass_token` VARCHAR(64) DEFAULT NULL,
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `unique_user` (`username`)
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

CREATE TABLE `device` (
  `device_id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) NOT NULL,
  `device1` BOOLEAN NOT NULL DEFAULT 0,
  `device2` BOOLEAN NOT NULL DEFAULT 0,
  `device3` BOOLEAN NOT NULL DEFAULT 0,
  `device4` BOOLEAN NOT NULL DEFAULT 0,
  `device5` BOOLEAN NOT NULL DEFAULT 0,
  `device6` BOOLEAN NOT NULL DEFAULT 0,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`device_id`),
  UNIQUE KEY `unique_device` (`user_id`)
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

CREATE TABLE `device_setting` (
  `device_setting_id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) NOT NULL,
  `device_count` INT(11) DEFAULT NULL,
  `device1` VARCHAR(50) DEFAULT NULL,
  `device2` VARCHAR(50) DEFAULT NULL,
  `device3` VARCHAR(50) DEFAULT NULL,
  `device4` VARCHAR(50) DEFAULT NULL,
  `device5` VARCHAR(50) DEFAULT NULL,
  `device6` VARCHAR(50) DEFAULT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`device_setting_id`),
  UNIQUE KEY `unique_device_setting` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
