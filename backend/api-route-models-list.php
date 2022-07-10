<?php

if (!defined("INCLUDE_GUARD")) die;

$databaseCollectibleStatement = $databaseConnection->prepare("
    SELECT model_name as collectibleName, model_url as collectibleModel, model_url_image as collectibleImage, model_rarity as collectibleRarity FROM voxel_models
");
$databaseCollectibleStatement->execute();

$databaseCollectibleResult = $databaseCollectibleStatement->fetchAll(PDO::FETCH_ASSOC);


$apiResponse = $databaseCollectibleResult;
