<?php

    $DB_HOST = 'remotemysql.com';
    $DB_NAME = 'N8rkDpIJP8';
    $DB_USER = 'N8rkDpIJP8';
    $DB_PASS = 'b7l2EvQOB5';

    try {
        $db = new PDO("mysql:host=$DB_HOST;dbname=$DB_NAME", $DB_USER, $DB_PASS);
    }
    catch(PDOException $e){
        die ('DataBase Connection failed: ' . $e->getMessage());
    }
    
    date_default_timezone_set('Asia/Kolkata');

?>