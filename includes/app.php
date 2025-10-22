<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/funciones.php';

use Model\ActiveRecord;

// Conectarnos a la base de datos
$db = conectarDB();
ActiveRecord::setDB($db);
