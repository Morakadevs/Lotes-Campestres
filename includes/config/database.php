<?php 

function conectarDB() : mysqli {
    $host = 'localhost';
    $user = 'lotescampestres';
    $pass = 'doy62FHTQAd73_b)_8';
    $db_name = 'lotescampestres';

    $db = new mysqli($host, $user, $pass, $db_name);

    if ($db->connect_errno) {
        die("❌ Error de conexión a la base de datos ({$db->connect_errno}): " . $db->connect_error);
    }

    $db->set_charset('utf8');
    return $db;
}
