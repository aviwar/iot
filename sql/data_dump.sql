--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`menu_id`, `menu_name`, `menu_icon`, `menu_url`, `menu_order`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Dashboard', 'fas fa-tachometer-alt', 'user.dashboard', 1, 1, '2021-09-15 15:30:25', '2021-09-18 13:12:03'),
(2, 'Title Update', 'far fa-edit', 'title', 2, 1, '2021-09-15 15:31:02', '2021-09-15 15:31:02'),
(3, 'View IOT Data', 'fas fa-table', 'sensors', 3, 1, '2021-09-15 17:28:41', '2021-09-15 17:28:41'),
(4, 'Mobile Number Update', 'fas fa-edit', 'mobile', 4, 1, '2021-09-15 17:28:41', '2021-09-15 17:28:41'),
(5, 'Device Control', 'fas fa-tablet-alt', NULL, 5, 1, '2021-09-15 17:30:39', '2021-09-15 17:30:39'),
(6, 'Location Details', 'fas fa-map-marker-alt', 'locations', 6, 1, '2021-09-15 17:30:39', '2021-09-15 17:30:39'),
(7, 'Reset Sensor Data', 'fas fa-undo', 'reset', 7, 1, '2021-09-15 17:33:20', '2021-09-15 17:33:20'),
(8, 'Settings', 'fas fa-cog', NULL, 8, 1, '2021-09-15 17:33:20', '2021-09-15 17:33:20');

-- --------------------------------------------------------

--
-- Dumping data for table `sensor_type`
--

INSERT INTO `sensor_type` (`sensor_type_id`, `sensor_name`, `sensor_type`, `created_at`, `updated_at`) VALUES
(1, 'Water level sensor', 'Analog', '2021-05-06 05:55:18', '2021-05-06 05:55:18'),
(2, 'Soil moisture sensor', 'Analog', '2021-05-06 05:55:18', '2021-05-06 05:55:18'),
(3, 'Rain drop detection sensor', 'Analog', '2021-05-06 05:55:18', '2021-05-06 05:55:18'),
(4, 'Fuel level sensor', 'Analog', '2021-05-06 05:55:18', '2021-05-06 05:55:18'),
(5, 'Oil level sensor', 'Analog', '2021-05-06 05:55:18', '2021-05-06 05:55:18'),
(6, 'Flex sensor', 'Analog', '2021-05-06 05:55:18', '2021-05-06 05:55:18'),
(7, 'Pulse sensor', 'Analog', '2021-05-06 05:55:18', '2021-05-06 05:55:18'),
(8, 'Heart beat sensor', 'Analog', '2021-05-06 05:55:18', '2021-05-06 05:55:18'),
(9, 'Temperature sensor', 'Analog', '2021-05-06 05:55:18', '2021-05-06 05:55:18'),
(10, 'Flame sensor', 'Analog', '2021-05-06 05:55:18', '2021-05-06 05:55:18'),
(11, 'Thermistor', 'Analog', '2021-05-06 05:55:18', '2021-05-06 05:55:18'),
(12, 'Fire detection sensor', 'Analog', '2021-05-06 05:55:18', '2021-05-06 05:55:18'),
(13, 'Thermal sensor', 'Analog', '2021-05-06 05:55:18', '2021-05-06 05:55:18'),
(14, 'MEMS', 'Analog', '2021-05-06 05:55:18', '2021-05-06 05:55:18'),
(15, 'Force sensor', 'Analog', '2021-05-06 05:55:18', '2021-05-06 05:55:18'),
(16, 'ECG sensor', 'Analog', '2021-05-06 05:55:18', '2021-05-06 05:55:18'),
(17, 'Current sensor', 'Analog', '2021-05-06 05:55:18', '2021-05-06 05:55:18'),
(18, 'Voltage sensor', 'Analog', '2021-05-06 05:55:18', '2021-05-06 05:55:18'),
(19, 'EMG sensor', 'Analog', '2021-05-06 05:55:18', '2021-05-06 05:55:18'),
(20, 'LDR sensor', 'Analog', '2021-05-06 05:55:18', '2021-05-06 05:55:18'),
(21, 'Blood Pressure sensor', 'Analog', '2021-05-06 05:55:18', '2021-05-06 05:55:18'),
(22, 'IR sensor', 'Digital', '2021-05-06 05:55:18', '2021-05-06 05:55:18'),
(23, 'Hall effect sensor', 'Digital', '2021-05-06 05:55:18', '2021-05-06 05:55:18'),
(24, 'Gas sensor', 'Analog', '2021-05-06 05:55:18', '2021-05-06 05:55:18'),
(25, 'Alcohol sensor', 'Analog', '2021-05-06 05:55:18', '2021-05-06 05:55:18'),
(26, 'Smoke sensor', 'Analog', '2021-05-06 05:55:18', '2021-05-06 05:55:18'),
(27, 'CO2 sensor', 'Analog', '2021-05-06 05:55:18', '2021-05-06 05:55:18'),
(28, 'Air Quality sensor', 'Analog', '2021-05-06 05:55:18', '2021-05-06 05:55:18'),
(29, 'Sound sensor', 'Digital', '2021-05-06 05:55:18', '2021-05-06 05:55:18'),
(30, 'Breath sensor', 'Digital', '2021-05-06 05:55:18', '2021-05-06 05:55:18'),
(31, 'Respiratory sensor', 'Digital', '2021-05-06 05:55:18', '2021-05-06 05:55:18'),
(32, 'Vibration sensor', 'Digital', '2021-05-06 05:55:18', '2021-05-06 05:55:18'),
(33, 'Eye blink Sensor', 'Digital', '2021-05-06 05:55:18', '2021-05-06 05:55:18'),
(34, 'PIR sensor', 'Digital', '2021-05-06 05:55:18', '2021-05-06 05:55:18'),
(35, 'Tilt sensor', 'Digital', '2021-05-06 05:55:18', '2021-05-06 05:55:18'),
(36, 'Proximity sensor', 'Digital', '2021-05-06 05:55:18', '2021-05-06 05:55:18'),
(37, 'Metal Detector', 'Digital', '2021-05-06 05:55:18', '2021-05-06 05:55:18');

-- --------------------------------------------------------

--
-- Dumping data for table `sub_menu`
--

INSERT INTO `sub_menu` (`submenu_id`, `menu_id`, `submenu_name`, `submenu_icon`, `submenu_url`, `submenu_order`, `status`, `created_at`, `updated_at`) VALUES
(1, 5, 'Device On/Off Buttons', 'fa fa-toggle-on', 'device.switch', 1, 1, '2021-09-15 15:32:33', '2021-09-16 12:37:24'),
(2, 5, 'Serial Data to Device', 'fa fa-paper-plane', 'device.serialData', 2, 1, '2021-09-15 15:38:47', '2021-09-16 12:39:32'),
(3, 8, 'Sensors', 'far fa-circle', 'setting.sensor', 1, 1, '2021-09-15 17:49:54', '2021-09-15 17:49:54'),
(4, 8, 'Devices', 'far fa-circle', 'setting.device', 2, 1, '2021-09-15 17:49:54', '2021-09-15 17:49:54'),
(5, 8, 'Sensor Selection', 'far fa-circle', 'setting.sensorType', 3, 1, '2021-09-15 17:51:05', '2021-09-15 17:51:05'),
(6, 8, 'Code', 'fa fa-code', 'code', 4, 1, '2021-09-15 17:51:05', '2021-09-16 12:36:50');

-- --------------------------------------------------------
