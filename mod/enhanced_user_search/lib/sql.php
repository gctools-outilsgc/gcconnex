<?php

namespace NRC\EUS\SQL;

class Constants {
  public function get() {
    $dbprefix = elgg_get_config("dbprefix");
    $dbname = elgg_get_config("dbname");

    $tableName = "NRC_EUS_mvMemberSearch";
    $procName = "NRC_EUS_Refresh_MemberSearch";

    $BUILD_SQL = "
    CREATE TABLE IF NOT EXISTS `{$tableName}` (
      user_guid bigint(20) unsigned not null,
      name text not null,
      contactemail text,
      education text,
      gc_skills text,
      portfolio text,
      work text
    );
    CREATE TABLE IF NOT EXISTS `{$tableName}_tmp` (
      user_guid bigint(20) unsigned not null,
      name text not null,
      contactemail text,
      education text,
      gc_skills text,
      portfolio text,
      work text
    );";

    $INDEX_SQL = "
    CREATE FULLTEXT INDEX NRC_EUS_MemberSearch ON
      `{$tableName}`(
        name,
        contactemail,
        education,
        gc_skills,
        portfolio,
        work
      );
    CREATE FULLTEXT INDEX NRC_EUS_MemberSearchTmp ON
      `{$tableName}_tmp`(
        name,
        contactemail,
        education,
        gc_skills,
        portfolio,
        work
      );";

    $REFRESH_PROC = "
    CREATE PROCEDURE `{$procName}` ()
    BEGIN
      TRUNCATE TABLE `{$tableName}_tmp`;
      SET group_concat_max_len=15000;
      INSERT INTO `{$tableName}_tmp`
      SELECT
        a.guid as user_guid,
        a.name as name,
        c.string as contactemail,
        GROUP_CONCAT(DISTINCT f1.title SEPARATOR ', ') as education,
        GROUP_CONCAT(DISTINCT f2.title SEPARATOR ', ') as gc_skills,
        GROUP_CONCAT(DISTINCT f3.title SEPARATOR ', ') as portfolio,
        GROUP_CONCAT(DISTINCT f4.title SEPARATOR ', ') as work
      FROM
        elggusers_entity a

        LEFT JOIN {$dbprefix}metadata b ON b.entity_guid = a.guid AND b.name_id = (SELECT id from {$dbprefix}metastrings WHERE string = 'contactemail')
        LEFT JOIN {$dbprefix}metastrings c ON c.id = b.value_id

        LEFT JOIN {$dbprefix}metadata d1 ON d1.entity_guid = a.guid AND d1.name_id IN (SELECT id from {$dbprefix}metastrings WHERE string = 'education')
        LEFT JOIN {$dbprefix}metastrings e1 ON e1.id = d1.value_id
        LEFT JOIN {$dbprefix}objects_entity f1 ON f1.guid = e1.string

        LEFT JOIN {$dbprefix}metadata d2 ON d2.entity_guid = a.guid AND d2.name_id IN (SELECT id from {$dbprefix}metastrings WHERE string = 'gc_skills')
        LEFT JOIN {$dbprefix}metastrings e2 ON e2.id = d2.value_id
        LEFT JOIN {$dbprefix}objects_entity f2 ON f2.guid = e2.string

        LEFT JOIN {$dbprefix}metadata d3 ON d3.entity_guid = a.guid AND d3.name_id IN (SELECT id from {$dbprefix}metastrings WHERE string = 'portfolio')
        LEFT JOIN {$dbprefix}metastrings e3 ON e3.id = d3.value_id
        LEFT JOIN {$dbprefix}objects_entity f3 ON f3.guid = e3.string

        LEFT JOIN {$dbprefix}metadata d4 ON d4.entity_guid = a.guid AND d4.name_id IN (SELECT id from {$dbprefix}metastrings WHERE string = 'work')
        LEFT JOIN {$dbprefix}metastrings e4 ON e4.id = d4.value_id
        LEFT JOIN {$dbprefix}objects_entity f4 ON f4.guid = e4.string
      GROUP BY
        a.guid;

      RENAME TABLE `{$tableName}_tmp` TO `{$tableName}_tmpA`,
                   `{$tableName}` TO `{$tableName}_tmp`,
                   `{$tableName}_tmpA` TO `{$tableName}`;

    END;";

    $READY_SQL = "SELECT user_guid from {$tableName} limit 1;";

    $SEARCH_SQL = "
    SELECT SQL_CALC_FOUND_ROWS
      user_guid,
      name,
      MATCH(
        name,
        contactemail,
        education,
        gc_skills,
        portfolio,
        work
      ) AGAINST (?) AS relevance,
      contactemail,
      education,
      gc_skills,
      portfolio,
      work
    FROM
      {$tableName}
    WHERE
      MATCH(
        name,
        contactemail,
        education,
        gc_skills,
        portfolio,
        work
      ) AGAINST (?)
    ORDER BY
      relevance DESC
    LIMIT ?, ?;";

    $TABLE_EXISTS_SQL = "
    SELECT *
      FROM
        information_schema.tables
      WHERE
        table_schema = '{$dbname}'
        AND table_name = '{$tableName}'
      LIMIT 1";

    $PROC_EXISTS_SQL = "SHOW PROCEDURE STATUS WHERE name = \"${procName}\";";

    return array(
      $tableName,
      $procName,
      $BUILD_SQL,
      $INDEX_SQL,
      $REFRESH_PROC,
      $SEARCH_SQL,
      $READY_SQL,
      $TABLE_EXISTS_SQL,
      $PROC_EXISTS_SQL
    );
  }
}

?>
