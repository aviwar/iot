<?php

namespace Iot\Repository;

use Iot\Util\Db;
use PDO;

class AuthRepository
{
    protected $db;

    public function __construct(Db $db)
    {
        $this->db = $db;
    }

    public function getActiveUser(string $username, string $password)
    {
        $shaPassword = sha1($password);
        $dbConn = $this->db->getConnection();
        $query = $dbConn->prepare(
            'SELECT user_id, username, is_active FROM user
            WHERE username=:username AND password=:password AND is_active!=0'
        );
        $query->bindValue(':username', $username, PDO::PARAM_STR);
        $query->bindValue(':password', $shaPassword, PDO::PARAM_STR);
        $query->execute();

        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public function getUser(string $username, string $password)
    {
        $shaPassword = sha1($password);
        $dbConn = $this->db->getConnection();
        $query = $dbConn->prepare(
            'SELECT user_id, username FROM user
            WHERE username=:username AND password=:password'
        );
        $query->bindValue(':username', $username, PDO::PARAM_STR);
        $query->bindValue(':password', $shaPassword, PDO::PARAM_STR);
        $query->execute();

        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public function getUserByUsername(string $username)
    {
        $dbConn = $this->db->getConnection();
        $sql =
            'SELECT user_id, username, mobile FROM user WHERE username=:username';
        $query = $dbConn->prepare($sql);
        $query->bindValue(':username', $username, PDO::PARAM_STR);
        $query->execute();

        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public function checkAuthenticateUser(int $userId, string $uniqId)
    {
        $dbConn = $this->db->getConnection();
        $query = $dbConn->prepare(
            "SELECT count(user_id) as count FROM user
            WHERE user_id=:userId AND auth_token=:uniqId"
        );

        $query->bindValue(':userId', $userId, PDO::PARAM_STR);
        $query->bindValue(':uniqId', $uniqId, PDO::PARAM_STR);
        $query->execute();

        return (bool) $query->fetchColumn();
    }

    public function updateUserAuthToken(int $userId, string $uniqId)
    {
        $dbConn = $this->db->getConnection();
        $query = $dbConn->prepare(
            "UPDATE user SET auth_token=:uniqId
            WHERE user_id=:userId"
        );
        $query->bindValue(':userId', $userId, PDO::PARAM_STR);
        $query->bindValue(':uniqId', $uniqId, PDO::PARAM_STR);
        $query->execute();
    }

    public function updateUserPassword(int $userId, string $password)
    {
        $shaPassword = sha1($password);

        $dbConn = $this->db->getConnection();
        $query = $dbConn->prepare(
            "UPDATE user SET password=:password, is_active=1
            WHERE user_id=:userId"
        );
        $query->bindValue(':userId', $userId, PDO::PARAM_STR);
        $query->bindValue(':password', $shaPassword, PDO::PARAM_STR);

        return $query->execute();
    }
}
