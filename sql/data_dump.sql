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
(37, 'Metal Detector', 'Digital', '2021-05-06 05:55:18', '2021-05-06 05:55:18'),
(38, 'Ultrasonic sensor', 'Analog', current_timestamp(), current_timestamp()),
(39, 'Humidity sensor(dht11)', 'Analog', current_timestamp(), current_timestamp());
-- --------------------------------------------------------

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`menu_name`, `menu_icon`, `menu_url`, `menu_order`) VALUES
('Dashboard', 'fas fa-tachometer-alt', 'user.dashboard', 1),
('Title Update', 'far fa-edit', 'title', 2),
('View IOT Data', 'fas fa-table', 'sensors', 3),
('No. of sensors', 'far fa-circle', 'setting.sensor', 4),
('No. of loads', 'far fa-circle', 'setting.device', 5),
('Pin Selection', 'fa fa-lock', 'setting.sensorType', 6),
('Code Download', 'fa fa-code', 'code', 7),
('Mobile Number Update', 'fas fa-edit', 'mobile', 8),
('Load Control', 'fas fa-tablet-alt', NULL, 9),
('Location Details', 'fas fa-map-marker-alt', 'locations', 10),
('Reset Sensor Data', 'fas fa-undo', 'reset', 11);

-- --------------------------------------------------------

--
-- Dumping data for table `sub_menu`
--

INSERT INTO `sub_menu` (`menu_id`, `submenu_name`, `submenu_icon`, `submenu_url`, `submenu_order`) VALUES
(9, 'Load On/Off Buttons', 'fa fa-toggle-on', 'device.switch', 1),
(9, 'Serial Data to Device', 'fa fa-paper-plane', 'device.serialData', 2);

-- --------------------------------------------------------
