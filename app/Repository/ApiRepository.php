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
}
