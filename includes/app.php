<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once 'config/database.php';
require_once 'funciones.php';

use Model\ActiveRecord;

// Conectarnos a la base de datos
$db = conectarDB();
ActiveRecord::setDB($db);
