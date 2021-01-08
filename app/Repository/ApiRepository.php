<?php
namespace Iot\Repository;

use Iot\Util\Db;
use PDO;

class ApiRepository
{
    protected $db;

    public function __construct(Db $db)
    {
        $this->db = $db;
    }

    public function addSensor($data)
    {
        $dbConn = $this->db->getConnection();
        $query = $dbConn->prepare(
            "INSERT INTO sensor(
                user_id, sensor1, sensor2, sensor3, sensor4,
                sensor5, sensor6, sensor7, sensor8
            )
            VALUES (
                :userId, :sensor1, :sensor2, :sensor3, :sensor4,
                :sensor5, :sensor6, :sensor7, :sensor8
            )"
        );
        $query->bindValue(':userId', $data['userId'], PDO::PARAM_INT);
        $query->bindValue(':sensor1', $data['sensor1'] ?? '', PDO::PARAM_STR);
        $query->bindValue(':sensor2', $data['sensor2'] ?? '', PDO::PARAM_STR);
        $query->bindValue(':sensor3', $data['sensor3'] ?? '', PDO::PARAM_STR);
        $query->bindValue(':sensor4', $data['sensor4'] ?? '', PDO::PARAM_STR);
        $query->bindValue(':sensor5', $data['sensor5'] ?? '', PDO::PARAM_STR);
        $query->bindValue(':sensor6', $data['sensor6'] ?? '', PDO::PARAM_STR);
        $query->bindValue(':sensor7', $data['sensor7'] ?? '', PDO::PARAM_STR);
        $query->bindValue(':sensor8', $data['sensor8'] ?? '', PDO::PARAM_STR);
        $query->execute();

        return $dbConn->lastInsertId();
    }

    public function getSensorData($userId, $date)
    {
        $dbConn = $this->db->getConnection();
        $data['userId'] = $userId;

        $sql = 'SELECT * FROM sensor WHERE user_id=:userId';
        if (!empty($date)) {
            $sql .= ' AND DATE(created_at)=:date';
            $data['date'] = $date;
        }

        $query = $dbConn->prepare($sql);
        $query->execute($data);

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function resetSensorData($userId)
    {
        $dbConn = $this->db->getConnection();
        $query = $dbConn->prepare('DELETE FROM `sensor` WHERE user_id=:userId');
        $query->bindValue(':userId', $userId, PDO::PARAM_INT);

        return $query->execute();
    }

    public function addDevice($data)
    {
        $sql = 'INSERT INTO device (';
        $valueSql = ' VALUES (';
        $duplicateSql = ' ON DUPLICATE KEY UPDATE ';
        foreach ($data as $key => $value) {
            $sql .= "$key, ";
            $valueSql .= ":$key, ";
            $duplicateSql .= "$key=VALUES($key), ";
        }

        $sql .= 'updated_at ) ';
        $valueSql .= 'now())';
        $duplicateSql = rtrim($duplicateSql, ', ');

        $dbConn = $this->db->getConnection();
        $query = $dbConn->prepare($sql . $valueSql . $duplicateSql);

        return $query->execute($data);
    }

    public function addDeviceSerialData($data)
    {
        $dbConn = $this->db->getConnection();
        $query = $dbConn->prepare(
            "INSERT INTO device_serial_data(user_id, serial_data)
            VALUES (:userId, :serialData)"
        );
        $query->bindValue(':userId', $data['userId'], PDO::PARAM_INT);
        $query->bindValue(':serialData', $data['serialData'] ?? '', PDO::PARAM_STR);
        $query->execute();

        return $dbConn->lastInsertId();
    }

    public function getDeviceSerialData($userId)
    {
        $dbConn = $this->db->getConnection();

        $query = $dbConn->prepare(
            'SELECT id, user_id, serial_data FROM device_serial_data
            WHERE user_id=:userId AND is_published=0'
        );
        $query->bindValue(':userId', $userId, PDO::PARAM_INT);
        $query->execute();

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateSerialDataStatus($data)
    {
        $id = '';
        foreach ($data as $row) {
            $id .= $row['id'] . ',';
        }

        $id = rtrim($id, ',');
        $dbConn = $this->db->getConnection();
        $sql = "UPDATE device_serial_data SET is_published=1 WHERE id IN ($id)";
        $query = $dbConn->prepare($sql);

        return $query->execute();
    }

    public function addLocationData($data)
    {
        $dbConn = $this->db->getConnection();
        $query = $dbConn->prepare(
            "INSERT INTO location(user_id, longitude, latitude)
            VALUES (:userId, :longitude, :latitude)"
        );
        $query->bindValue(':userId', $data['userId'], PDO::PARAM_INT);
        $query->bindValue(':longitude', $data['longitude'], PDO::PARAM_STR);
        $query->bindValue(':latitude', $data['latitude'], PDO::PARAM_STR);
        $query->execute();

        return $dbConn->lastInsertId();
    }

    public function getLocationData($userId, $date)
    {
        $dbConn = $this->db->getConnection();
        $data['userId'] = $userId;

        $sql = 'SELECT * FROM location WHERE user_id=:userId';
        if (!empty($date)) {
            $sql .= ' AND DATE(created_at)=:date';
            $data['date'] = $date;
        }

        $query = $dbConn->prepare($sql);
        $query->execute($data);

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}
