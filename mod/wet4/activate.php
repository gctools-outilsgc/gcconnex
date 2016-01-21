<?php
try{
    run_sql_script(__DIR__ . '/sql/activate.sql');
    
    //mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    //$DBprefix=elgg_get_config('dbprefix');
    //$DBname=elgg_get_config('dbname');

    
    //$mysqli = new mysqli(elgg_get_config('dbhost'), elgg_get_config('dbuser'), elgg_get_config('dbpass'), elgg_get_config('dbname'));
    //if ($mysqli->connect_errno) {
    //    throw new Exception($mysqli->connect_errno);
    //}
    //if (!$mysqli->query("DROP PROCEDURE IF EXISTS GET_suggestedFriends") ||
    //!$mysqli->query("CREATE PROCEDURE `GET_suggestedFriends`(IN `UserGUID` BIGINT(20),IN Sug_Limit INT) BEGIN select fof.guid_two,ue.username FROM {$DBprefix}entities as e INNER JOIN {$DBprefix}users_entity ue ON ue.guid = e.guid INNER JOIN {$DBprefix}entity_relationships fr ON fr.guid_one = UserGUID AND fr.relationship = 'friend' INNER JOIN {$DBprefix}entity_relationships fof ON fof.guid_one = fr.guid_two AND fof.relationship = 'friend' WHERE ue.banned='no' and e.guid NOT IN (SELECT f.guid_two FROM {$DBprefix}entity_relationships f WHERE f.guid_one = UserGUID AND f.relationship = 'friend') and fof.guid_two = e.guid and e.guid != UserGUID GROUP BY e.guid ORDER BY fof.guid_two desc, ue.last_action DESC LIMIT Sug_Limit;END;")) {
    //    throw new Exception($mysqli->errno);
    //}
    
    //$mysqli->close();

    
      //  run_sql_script(__DIR__ . '/sql/activate.sql');

}
catch (Exception $e)
{
    echo 'Caught exception: ',  $e->getMessage(), "\n";
    //$mysqli->close();
}
?>