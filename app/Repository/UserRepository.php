<?php
namespace Iot\Repository;

use Iot\Util\Db;
use PDO;

class UserRepository
{
    protected $db;

    public function __construct(Db $db)
    {
        $this->db = $db;
    }

    public function getProjectTitleByUserId(int $userId)
    {
        $dbConn = $this->db->getConnection();
        $query = $dbConn->prepare(
            'SELECT project_title FROM user WHERE user_id=:userId'
        );
        $query->bindValue(':userId', $userId, PDO::PARAM_INT);
        $query->execute();

        return $query->fetchColumn();
    }

    public function updateProjectTitle($data)
    {
        $dbConn = $this->db->getConnection();
        $query = $dbConn->prepare(
            'UPDATE user SET project_title=:title WHERE user_id=:userId'
        );
        $query->bindValue(':userId', $data['userId'], PDO::PARAM_INT);
        $query->bindValue(':title', $data['projectTitle'], PDO::PARAM_STR);

        return $query->execute();
    }

    public function getMobileNumberByUserId(int $userId)
    {
        $dbConn = $this->db->getConnection();
        $query = $dbConn->prepare(
            'SELECT mobile FROM user WHERE user_id=:userId'
        );
        $query->bindValue(':userId', $userId, PDO::PARAM_INT);
        $query->execute();

        return $query->fetchColumn();
    }

    public function updateMobileNumber($data)
    {
        $dbConn = $this->db->getConnection();
        $query = $dbConn->prepare(
            'UPDATE user SET mobile=:mobile WHERE user_id=:userId'
        );
        $query->bindValue(':userId', $data['userId'], PDO::PARAM_INT);
        $query->bindValue(':mobile', $data['mobile'], PDO::PARAM_STR);

        return $query->execute();
    }

    public function getSensorByUserId(int $userId)
    {
        $dbConn = $this->db->getConnection();
        $sql =
            'SELECT * FROM sensor WHERE user_id=:userId ORDER BY created_at DESC';
        $query = $dbConn->prepare($sql);
        $query->bindValue(':userId', $userId, PDO::PARAM_INT);
        $query->execute();

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getDeviceByUserId(int $userId)
    {
        $dbConn = $this->db->getConnection();
        $query = $dbConn->prepare('SELECT * FROM device WHERE user_id=:userId');
        $query->bindValue(':userId', $userId, PDO::PARAM_INT);
        $query->execute();

        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public function getLocationByUserId(int $userId)
    {
        $dbConn = $this->db->getConnection();
        $query = $dbConn->prepare(
            'SELECT * FROM location WHERE user_id=:userId'
        );
        $query->bindValue(':userId', $userId, PDO::PARAM_INT);
        $query->execute();

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSensorSettingByUserId(int $userId)
    {
        $dbConn = $this->db->getConnection();
        $query = $dbConn->prepare(
            'SELECT * FROM sensor_setting WHERE user_id=:userId'
        );
        $query->bindValue(':userId', $userId, PDO::PARAM_INT);
        $query->execute();

        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public function updateSensorSetting($data)
    {
        $sql = 'INSERT INTO sensor_setting (';
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

    public function getDeviceSettingByUserId(int $userId)
    {
        $dbConn = $this->db->getConnection();
        $query = $dbConn->prepare(
            'SELECT * FROM device_setting WHERE user_id=:userId'
        );
        $query->bindValue(':userId', $userId, PDO::PARAM_INT);
        $query->execute();

        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public function updateDeviceSetting($data)
    {
        $sql = 'INSERT INTO device_setting (';
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
