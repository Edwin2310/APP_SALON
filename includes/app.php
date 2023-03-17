<?php

require __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__); //variable de entorno
$dotenv->safeLoad();
require 'funciones.php';
require 'database.php';


// Conectarnos a la base de datos
use Model\ActiveRecord;

ActiveRecord::setDB($db);
