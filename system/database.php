<?php
require_once('../system/config.php');

//TODO: Improve the implementation
function dbconnect() {
    //FIXME: Move to config.php, don't store username, and password
    $config = array(
        'DB_DNS' => 'mysql:host=127.0.0.1;port=3306;dbname=bigscreen;',
        'DB_USER' => 'root',
        'DB_PASSWORD' => 'Ranallo10'
    );

    try {
        $db = new PDO($config['DB_DNS'], $config['DB_USER'], $config['DB_PASSWORD']);
        $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $db->setAttribute(PDO::ERRMODE_EXCEPTION, true);
    } catch (Exception $ex) {
        var_dump($ex);
        echo $ex->getMessage();
        $db = null;
    }


    return $db;
}
