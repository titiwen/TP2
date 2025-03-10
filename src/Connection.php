<?php
namespace App;

use \PDO;

class Connection
{
    public static function getPDO(): PDO
    {
        return new PDO('mysql:host=127.0.0.1;dbname=tutoblog', 'root', 'root', [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
    }
}