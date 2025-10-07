<?php 

function conectarDB() : mysqli {
    $db = new mysqli('localhost', 'lotescampestres', 'doy62FHTQAd73_b)_8', 'lotescampestres');

    if(!$db) {
        echo "Error no se pudo conectar";
        exit;
    }
    
    return $db;
}