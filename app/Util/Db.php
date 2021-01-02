<?php
namespace Iot\Util;

use PDO;

class Db
{
    private $db;

    public function __construct($host, $username, $password, $dbName = null)
    {
        $dns = sprintf('mysql:host=%s', $host);
        if ($dbName !== null) {
            $dns = sprintf('%s;dbname=%s', $dns, $dbName);
        }

        try {
            $this->db = new PDO($dns, $username, $password);
        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function getConnection()
    {
        return $this->db;
    }

    public function __destruct()
    {
        $this->db = null;
    }
}
