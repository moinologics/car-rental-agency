<?php

    $DB_HOST = 'sql301.epizy.com';
    $DB_NAME = 'epiz_31928394_db';
    $DB_USER = 'epiz_31928394';
    $DB_PASS = '95UZ5xEMi8c';

    try {
        $db = new PDO("mysql:host=$DB_HOST;dbname=$DB_NAME", $DB_USER, $DB_PASS);
    }
    catch(PDOException $e){
        die ('DataBase Connection failed: ' . $e->getMessage());
    }
    
    date_default_timezone_set('Asia/Kolkata');

?>