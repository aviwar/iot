#ALTER TABLE `user` ADD `project_title` TEXT NULL AFTER `role`;

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


ALTER TABLE `user_sensor_type`
  ADD `sensor1_low_threshold` INT(11) NOT NULL DEFAULT '0' AFTER `sensor1_pin`,
  ADD `sensor1_high_threshold` INT(11) NOT NULL DEFAULT '0' AFTER `sensor1_low_threshold`,
  ADD `sensor2_low_threshold` INT(11) NOT NULL DEFAULT '0' AFTER `sensor2_pin`,
  ADD `sensor2_high_threshold` INT(11) NOT NULL DEFAULT '0' AFTER `sensor2_low_threshold`,
  ADD `sensor3_low_threshold` INT(11) NOT NULL DEFAULT '0' AFTER `sensor3_pin`,
  ADD `sensor3_high_threshold` INT(11) NOT NULL DEFAULT '0' AFTER `sensor3_low_threshold`,
  ADD `sensor4_low_threshold` INT(11) NOT NULL DEFAULT '0' AFTER `sensor4_pin`,
  ADD `sensor4_high_threshold` INT(11) NOT NULL DEFAULT '0' AFTER `sensor4_low_threshold`,
  ADD `sensor5_low_threshold` INT(11) NOT NULL DEFAULT '0' AFTER `sensor5_pin`,
  ADD `sensor5_high_threshold` INT(11) NOT NULL DEFAULT '0' AFTER `sensor5_low_threshold`,
  ADD `sensor6_low_threshold` INT(11) NOT NULL DEFAULT '0' AFTER `sensor6_pin`,
  ADD `sensor6_high_threshold` INT(11) NOT NULL DEFAULT '0' AFTER `sensor6_low_threshold`,
  ADD `sensor7_low_threshold` INT(11) NOT NULL DEFAULT '0' AFTER `sensor7_pin`,
  ADD `sensor7_high_threshold` INT(11) NOT NULL DEFAULT '0' AFTER `sensor7_low_threshold`,
  ADD `sensor8_low_threshold` INT(11) NOT NULL DEFAULT '0' AFTER `sensor8_pin`,
  ADD `sensor8_high_threshold` INT(11) NOT NULL DEFAULT '0' AFTER `sensor8_low_threshold`;

ALTER TABLE `user` CHANGE `is_active` `is_active` TINYINT(1) NOT NULL DEFAULT '-1';


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

INSERT INTO `menu` (`menu_id`, `menu_name`, `menu_icon`, `menu_url`, `menu_order`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Home', 'fas fa-home', 'home', 1, 1, '2021-09-15 15:30:25', '2021-09-15 17:40:21'),
(2, 'Title Update', 'far fa-edit', 'title', 2, 1, '2021-09-15 15:31:02', '2021-09-15 15:31:02'),
(3, 'View IOT Data', 'fas fa-table', 'sensors', 3, 1, '2021-09-15 17:28:41', '2021-09-15 17:28:41'),
(4, 'Mobile Number Update', 'fas fa-edit', 'mobile', 4, 1, '2021-09-15 17:28:41', '2021-09-15 17:28:41'),
(5, 'Device Control', 'fas fa-tablet-alt', NULL, 5, 1, '2021-09-15 17:30:39', '2021-09-15 17:30:39'),
(6, 'Location Details', 'fas fa-map-marker-alt', 'locations', 6, 1, '2021-09-15 17:30:39', '2021-09-15 17:30:39'),
(7, 'Reset Sensor Data', 'fas fa-undo', 'reset', 7, 1, '2021-09-15 17:33:20', '2021-09-15 17:33:20'),
(8, 'Settings', 'fas fa-cog', NULL, 8, 1, '2021-09-15 17:33:20', '2021-09-15 17:33:20');

INSERT INTO `sub_menu` (`submenu_id`, `menu_id`, `submenu_name`, `submenu_icon`, `submenu_url`, `submenu_order`, `status`, `created_at`, `updated_at`) VALUES
(1, 5, 'Device On/Off Buttons', 'fa fa-toggle-on', 'device.switch', 1, 1, '2021-09-15 15:32:33', '2021-09-16 12:37:24'),
(2, 5, 'Serial Data to Device', 'fa fa-paper-plane', 'device.serialData', 2, 1, '2021-09-15 15:38:47', '2021-09-16 12:39:32'),
(3, 8, 'Sensors', 'far fa-circle', 'setting.sensor', 1, 1, '2021-09-15 17:49:54', '2021-09-15 17:49:54'),
(4, 8, 'Devices', 'far fa-circle', 'setting.device', 2, 1, '2021-09-15 17:49:54', '2021-09-15 17:49:54'),
(5, 8, 'Sensor Selection', 'far fa-circle', 'setting.sensorType', 3, 1, '2021-09-15 17:51:05', '2021-09-15 17:51:05'),
(6, 8, 'Code', 'fa fa-code', 'code', 4, 1, '2021-09-15 17:51:05', '2021-09-16 12:36:50');
