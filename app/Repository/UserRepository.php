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

    public function getSensorByUserId(int $userId)
    {
        $dbConn = $this->db->getConnection();
        $query = $dbConn->prepare('SELECT * FROM sensor WHERE user_id=:userId');
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
}
