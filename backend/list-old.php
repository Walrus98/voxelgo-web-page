<?php

if (!defined("INCLUDE_GUARD")) die;

$databaseTournamentStatement = $databaseConnection->prepare("
    SELECT model_name, model_url_name, model_rarity FROM voxel_models
");
$databaseTournamentStatement->execute();

$databaseTournamentsResult = $databaseTournamentStatement->fetchAll(PDO::FETCH_ASSOC);

$apiResponse["code"] = "SUCCESS";
$apiResponse["models"] = $databaseTournamentsResult;

// if (isset($apiRequest["entriesAmount"])) {

//     $entriesAmount = $apiRequest["entriesAmount"];

//     if ($entriesAmount > 0 AND $entriesAmount <= 10) {
//         // Restituisce i tornei più recenti
//         $databaseTournamentStatement = $databaseConnection->prepare("
//             SELECT tournament_identifier, tournament_name, tournament_description, game_name AS 'torunament_game_name', tournament_price, tournament_image, tournament_game_start, tournament_game_end, tournament_subscription_start, tournament_subscription_end, tournament_subscription_count 
//             FROM gg_tournaments LEFT JOIN gg_tournaments_games ON gg_tournaments.tournament_game = gg_tournaments_games.game_identifier
//             ORDER BY tournament_identifier DESC LIMIT :entries_amount
//         ");
//         $databaseTournamentStatement->bindParam("entries_amount", $entriesAmount, PDO::PARAM_INT);
//         $databaseTournamentStatement->execute();
//         $databaseTournamentsResult = $databaseTournamentStatement->fetchAll(PDO::FETCH_ASSOC);
        
//         $apiResponse["code"] = "SUCCESS";
//         $apiResponse["tournaments"] = $databaseTournamentsResult;
//     } else {
//         $apiResponse["code"] = "INVALID_PARAMETERS";
//     }
// }
