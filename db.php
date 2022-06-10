<?php

    $DB_HOST = 'localhost';
    $DB_USER = 'root';
    $DB_PASS = '07860';
    $DB_NAME = 'xlink';

    try {
        $db = new PDO("mysql:host=$DB_HOST;DB_NAME=$DbName", $DB_USER, $DB_PASS);
    }
    catch(PDOException $e){
        die ('DataBase Connection failed: ' . $e->getMessage());
    }
    
    date_default_timezone_set('Asia/Kolkata');

?>