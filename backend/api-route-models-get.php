<?php

if (!defined("INCLUDE_GUARD")) die;

if (isset($_GET["name"])) {

    $modelName = $_GET["name"];

    $databaseCollectibleStatement = $databaseConnection->prepare("
        SELECT model_properties FROM voxel_models WHERE model_url_name = :model_url_name
    ");
    $databaseCollectibleStatement->bindParam("model_url_name", $modelName);
    $databaseCollectibleStatement->execute();

    $databaseCollectibleResult = $databaseCollectibleStatement->fetch(PDO::FETCH_ASSOC);
    
    $model = json_decode($databaseCollectibleResult["model_properties"], true);

    $apiResponse["code"] = "SUCCESS";
    $apiResponse["property"] = $model;
    
} else {
    $apiResponse["code"] = "INVALID_PARAMETERS";
}