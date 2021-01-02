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

    public function getUser(string $username, string $password)
    {
        $shaPassword = sha1($password);
        $dbConn = $this->db->getConnection();
        $query = $dbConn->prepare(
            "SELECT user_id, username, email, role
            FROM user
            WHERE username=:username AND password=:password"
        );
        $query->bindValue(':username', $username, PDO::PARAM_STR);
        $query->bindValue(':password', $shaPassword, PDO::PARAM_STR);
        $query->execute();

        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public function getUserByUsername(string $username)
    {
        $dbConn = $this->db->getConnection();
        $query = $dbConn->prepare(
            "SELECT user_id, username, email, role
            FROM user
            WHERE username=:username"
        );
        $query->bindValue(':username', $username, PDO::PARAM_STR);
        $query->execute();

        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public function getUserName(string $email)
    {
        $dbConn = $this->db->getConnection();
        $query = $dbConn->prepare(
            'SELECT user_name as name FROM user WHERE user_email=:email'
        );

        $query->bindValue(':email', $email, PDO::PARAM_STR);
        $query->execute();

        return $query->fetchColumn();
    }

    public function getUserByMobileNumber($mobileNumber)
    {
        $dbConn = $this->db->getConnection();
        $query = $dbConn->prepare(
            "SELECT id, user_name, user_email, user_role
			FROM user
            WHERE user_mobile=:mobileNumber"
        );

        $query->bindValue(':mobileNumber', $mobileNumber, PDO::PARAM_STR);
        $query->execute();

        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public function checkUserExist(string $email, $mobile)
    {
        $dbConn = $this->db->getConnection();
        $query = $dbConn->prepare(
            "SELECT count(id) as count FROM user
            WHERE user_email=:email OR user_mobile=:mobile"
        );

        $query->bindValue(':email', $email, PDO::PARAM_STR);
        $query->bindValue(':mobile', $mobile, PDO::PARAM_STR);
        $query->execute();

        return (bool) $query->fetchColumn();
    }

    public function addUser(array $data)
    {
        $name = ucfirst(strtolower($data['name']));
        $shaPassword = sha1($data['password']);
        $dbConn = $this->db->getConnection();
        $query = $dbConn->prepare(
            "INSERT INTO user(
                user_name, user_email, user_pass, user_mobile, user_role
            )
            VALUES (:name, :email, :password, :mobile, :role)"
        );
        $query->bindValue(':name', $name, PDO::PARAM_STR);
        $query->bindValue(':email', $data['email'], PDO::PARAM_STR);
        $query->bindValue(':password', $shaPassword, PDO::PARAM_STR);
        $query->bindValue(':mobile', $data['mobile'], PDO::PARAM_STR);
        $query->bindValue(':role', 'student', PDO::PARAM_STR);

        return $query->execute();
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

    public function updateForgotToken(string $uniqId, string $email)
    {
        $dbConn = $this->db->getConnection();
        $query = $dbConn->prepare(
            "UPDATE user
            SET forgot_pass_token=:uniqId
            WHERE user_email=:email"
        );
        $query->bindValue(':uniqId', $uniqId, PDO::PARAM_STR);
        $query->bindValue(':email', $email, PDO::PARAM_STR);
        $query->execute();
        return (bool) $query->rowCount();
    }

    public function checkUserByUniqId(string $uniqId)
    {
        $dbConn = $this->db->getConnection();
        $query = $dbConn->prepare(
            "SELECT count(id) as count FROM user
            WHERE forgot_pass_token=:uniqId"
        );

        $query->bindValue(':uniqId', $uniqId, PDO::PARAM_STR);
        $query->execute();

        return (bool) $query->fetchColumn();
    }

    public function updateUserPassword(string $password, string $uniqId)
    {
        $dbConn = $this->db->getConnection();
        $query = $dbConn->prepare(
            "UPDATE user
            SET forgot_pass_token = null,
                user_pass=:password
            WHERE forgot_pass_token=:uniqId"
        );
        $query->bindValue(':password', $password, PDO::PARAM_STR);
        $query->bindValue(':uniqId', $uniqId, PDO::PARAM_STR);

        $query->execute();
        return (bool) $query->rowCount();
    }

    public function updateUserPasswordByEmail(string $email, string $password)
    {
        $dbConn = $this->db->getConnection();
        $query = $dbConn->prepare(
            "UPDATE user
            SET user_pass=:password
            WHERE user_email=:email"
        );
        $query->bindValue(':password', $password, PDO::PARAM_STR);
        $query->bindValue(':email', $email, PDO::PARAM_STR);

        $query->execute();
        return (bool) $query->rowCount();
    }
}
