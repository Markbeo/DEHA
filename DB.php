<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class DB
{
    static private $connection;
    const DB_TYPE = "mysql";
    const DB_HOST = "localhost";
    const DB_NAME = "curd";
    const USER_NAME = "root";
    const USER_PASSWORD = "";

    static public function getConnection()
    {
        if (static::$connection == null) {
            try {
                static::$connection = new PDO(
                    self::DB_TYPE . ":host=" . self::DB_HOST . ";dbname=" . self::DB_NAME,
                    self::USER_NAME,
                    self::USER_PASSWORD
                );
                static::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (Exception $exception) {
                throw new Exception("Connection failed: " . $exception->getMessage());
            }
        }
        return static::$connection;
    }

    static public function execute($sql, $data = [])
    {
        $statement = self::getConnection()->prepare($sql);
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $statement->execute($data);
        return $statement->fetchAll();
    }

    static public function fetchOne($sql, $data = [])
    {
        $statement = self::getConnection()->prepare($sql);
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $statement->execute($data);
        return $statement->fetch();
    }
}
