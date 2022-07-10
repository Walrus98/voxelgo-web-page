<?php

define("INCLUDE_GUARD", true);

require_once("api-database.php");

// Array associativo usato come risposta da parte del server
$apiResponse = [
    "code" => "IDLE"
];

// Controllo l'endpoint della richiesta
if (isset($_GET["endpoint"])) {
    switch ($_GET["endpoint"]) {
        case "models/list":
            require_once("api-route-models-list.php");
            break;
        case "models/get":
            require_once("api-route-models-get.php");
            break;
    }
}

// Restituisco l'array associativo apiResponse codificato in json come risposta
header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json");
echo json_encode($apiResponse, JSON_PRETTY_PRINT);
