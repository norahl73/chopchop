<?php
    //Handles the database connection for the Chop app.
    require_once 'config.php';

    try {
        $dsn = "pgsql:host=" . Config::$db['host'] . 
            ";port=" . Config::$db['port'] . 
            ";dbname=" . Config::$db['database'];
        
        $pdo = new PDO($dsn, Config::$db['user'], Config::$db['pass']);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Database connection failed: " . $e->getMessage());
    }
?>