<?php
    session_start();
    
    function openDB() {
        $host = 'localhost';
        $db = 'MUSIC_COLLECTION';
        $user = 'root';
        $password = 'root';

        $con = new PDO("mysql:host=$host;dbname=$db;charset=UTF8", $user, $password);
        // set the PDO error mode to exception
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $con->exec("set names UTF8");

        return $con;
    }

    function closeDB() {
        return null;
    }
?>