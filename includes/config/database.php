<?php 

function conectarDB() : mysqli {
    $host = 'localhost'; 
    $user = 'lotescampestres'; // el usuario MySQL de DomCloud (igual que tu usuario del sitio)
    $pass = 'doy62FHTQAd73_b)_8'; // tu contraseña de MySQL (la misma que usas actualmente)
    $db_name = 'lotescampestres_db'; // usa el nombre exacto de la base que se muestra en DomCloud

    $db = new mysqli($host, $user, $pass, $db_name);

    if ($db->connect_errno) {
        die("❌ Error de conexión a la base de datos ({$db->connect_errno}): " . $db->connect_error);
    }

    $db->set_charset('utf8');
    return $db;
}
