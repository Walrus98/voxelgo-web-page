<?php

define("CONFIG_DATABASE_HOST", "localhost");
define("CONFIG_DATABASE_PORT", "3306");
define("CONFIG_DATABASE_USER", "walrus");
define("CONFIG_DATABASE_PASS", "password");
define("CONFIG_DATABASE_NAME", "voxel");

$databaseConnection = new PDO(
    sprintf(
        "mysql:host=%s:%s;dbname=%s",
        CONFIG_DATABASE_HOST,
        CONFIG_DATABASE_PORT,
        CONFIG_DATABASE_NAME
    ),
    CONFIG_DATABASE_USER,
    CONFIG_DATABASE_PASS,
    [
        PDO::ATTR_PERSISTENT => true
    ]
);
$databaseConnection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$databaseConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
