<?php

/**
* NRC Recommendation Platform API Library
* Copyright (c) 2017 National Research Council Canada
*
* Author: Luc Belliveau <luc.belliveau@nrc-cnrc.gc.ca>
*
*/
header('Content-Type: application/json');

/**
* Verify that the API request has the appropriate X-Custom-Authorization
* header, and make sure the script has all require privileges to run.
*
* Responds with a 403 if authorization is missing or invalid.
*
*/
function mm_api_secure() {

  if (
      !isset($_SERVER['HTTP_X_CUSTOM_AUTHORIZATION'])
      || (!openssl_public_decrypt(base64_decode($_SERVER['HTTP_X_CUSTOM_AUTHORIZATION']), $decrypted, PUBLIC_KEY))
      || ($decrypted !== '-- NRC -- LPSS -- GCTools -- Sig -- dsaj9843uj80w7IJHYS&UHSJY(*IOIJHY*')
    ) {
    header('HTTP/1.0 403 Forbidden');
    exit;
  }

  # Ensure API has full access
  session_destroy();
  elgg_set_ignore_access(true);

  # Increase the script timeout value
  set_time_limit(14400);
}

/**
* Generator that finds the GUIDs of the entities defined by the search critera.
* The first value yielded is the total number of guids found.
*
* @param str $type Desired entity type.  (object, user, export)
* @param str $subtype Desired subtype.  (mission)
* @param int $guid GUID of single object, for single entity fetch.
* @param int $since: Fetch entities that have been modified since the specified time
* @param int $before: Fetch entities that have been modified before the specified time
* @param int $limit: Fetch at most X entities.
* @param int $resume: Resume starting at the specified GUID.
* @param bool $sort: If true sorts entities based on time created.
* @param str $omit: Comma separated list of GUIDs to omit.
*
* @return Generator[] Guid iterable
*/
function mm_api_get_entity_guids($type, $subtype = false, $guid = null,
$since = null, $before = null, $limit = null, $resume = null, $sort = false,
$omit = null) {
  $where = ['a.enabled = "yes"'];
  if ($type !== 'export') {
    $where[] = 'a.type = "' . mysql_escape_string($type) . '"';
  }
  if ($subtype !== false) {
    $subtype_id = get_data("select id from ".elgg_get_config('dbprefix')."entity_subtypes where subtype = '$subtype'")[0]->id;
    $where[] = 'a.subtype = ' . $subtype_id;
  } else $subtype_id = 0;

  if (!is_null($guid) && is_numeric($guid)) {
    $where[] = 'a.guid = ' . mysql_escape_string(intval($guid));
  }
  if (is_numeric($since)) {
    $where[] = 'a.time_updated > ' . mysql_escape_string($since);
  }
  if (is_numeric($before)) {
    $where[] = 'a.time_updated < ' . mysql_escape_string($before);
  }
  if (!is_null($omit)) {
    $omitGuids = explode(',', $omit);
    if (count($omitGuids) > 0) {
      $ogs = [];
      foreach ($omitGuids as $og) {
        $ogs[] = mysql_escape_string(intval($og));
      }
      $where[] = 'a.guid NOT IN ('.implode(',', $ogs).')';
    }
  }

  $where_sql = '';
  if (count($where) > 0) {
    $where_sql = 'WHERE ' . implode(' AND ', $where);
  }
  if ($sort) {
    $sort_sql = 'ORDER BY a.time_updated ASC';
  }
  try {
    $sql = '
    SELECT
      a.guid
    FROM
      '.elgg_get_config('dbprefix').'entities a
    ' . $where_sql . '
    ' . $sort_sql;
    $result = mysql_query($sql, _elgg_services()->db->getLink('read'));
    yield mysql_num_rows($result);
    $emit = !is_numeric($resume);
    $max = (is_numeric($limit) && ($limit > 0)) ? $limit : false;
    $count = 0;
    while ($row = mysql_fetch_object($result)) {
      if ($emit) {
        $count += 1;
        yield $row->guid;
        if (($max !== false) && ($count >= $max)) break;
      }
      if (!$emit) {
        if ($row->guid == $resume) {
          $emit = true;
        }
      }
    }
  } catch (Exception $e) {
    //
  }
}

/**
* Iterate over list of GUIDs and yields the complete object as a row.
*
* @param mixed $entity_guids Array of entity GUIDs
*/
function mm_api_entity_export($entity_guids) {
  function createInvalidEntityObject($guid) {
    $ret = new \stdClass;
    $ret->guid = $guid;
    $ret->__error__ = 'Incomplete Entity Error';
    return $ret;
  }
  function exportEntity($entity_or_guid) {
    // List of fields not to include in any export
    $omit = array('password', 'password_hash', 'salt');
    if (is_object($entity_or_guid)) {
      $entity = $entity_or_guid;
    } else {
      $entity = get_entity($entity_or_guid);
      if (!is_object($entity)) {
        $invalidObj = createInvalidEntityObject($entity_or_guid);
        return [$invalidObj, $invalidObj];
      }
    }
    $ret = new \stdClass;
    $exportable_values = $entity->getExportableValues();
    foreach ($exportable_values as $v) {
      $ret->$v = $entity->$v;
    }
    foreach ($entity as $field=>$value) {
      if (!in_array($field, $exportable_values) && !in_array($field, $omit)) {
        $ret->$field = $value;
      }
    }
    $ret->url = $entity->getURL();
    $ret->subtype_name = $entity->getSubtype();
    return [$entity, $ret];
  }
  function dismount($object) {
    $reflectionClass = new ReflectionClass(get_class($object));
    $array = array();
    foreach ($reflectionClass->getProperties() as $property) {
        $property->setAccessible(true);
        $array[$property->getName()] = $property->getValue($object);
        $property->setAccessible(false);
    }
    return $array;
  }

  while ($entity_guids->valid()) {
    yield ',';

    $uguid = $entity_guids->current();
    $objectData = exportEntity($uguid);
    $object = $objectData[0];
    $data = $objectData[1];

    $options = array(
      'guid' => $object->guid,
      'limit' => 0
    );

    $metadata = elgg_get_metadata($options);
    $annotations = elgg_get_annotations($options);

    if ($metadata) {
      foreach ($metadata as $v) {
        $prop = $v->name;
        if (!isset($data->$prop)) $data->$prop = $object->$prop;
      }
    }
    if ($annotations) {
      foreach ($annotations as $v) {
        if (!isset($data->annotations[$v->name])) {
          $data->annotations[$v->name] = [];
        };
        $data->annotations[$v->name][] = dismount($v);
      }
    }
    yield '{'.substr(json_encode($data), 1, -1) . ',"relationships":[';

    $relstart = false;
    $reltable = elgg_get_config('dbprefix') . 'entity_relationships';
    $relationships = mysql_unbuffered_query(
      "SELECT * from $reltable where guid_one = {$object->guid}",
      _elgg_services()->db->getLink('read')
    );
    while ($v = mysql_fetch_object($relationships)) {
      yield (($relstart) ? ',' : '') . json_encode(array(
        'direction' => 'OUT',
        'time_created' => $v->time_created,
        'id' => $v->id,
        'relationship' => $v->relationship,
        'entity' => $v->guid_two,
      ));
      $relstart = true;
    }
    mysql_free_result($relationships);

    $relationships2 = mysql_unbuffered_query(
      "SELECT * from $reltable where guid_two = {$object->guid}",
      _elgg_services()->db->getLink('read')
    );
    while ($v = mysql_fetch_object($relationships2)) {
      yield (($relstart) ? ',' : '') . json_encode(array(
        'direction' => 'IN',
        'time_created' => $v->time_created,
        'id' => $v->id,
        'relationship' => $v->relationship,
        'entity' => $v->guid_one,
      ));
      $relstart = true;
    }
    mysql_free_result($relationships2);
    yield ']}';
    $entity_guids->next();
  }
}

// Public key of server authorized to make requests against this API.
define('PUBLIC_KEY', "-----BEGIN PUBLIC KEY-----
MIICIjANBgkqhkiG9w0BAQEFAAOCAg8AMIICCgKCAgEAmYj9ceaqHi7UmUmhE8e/
eU/02ZEJeLD8HN7Ku+VN8IB1dIwoSibvoxWZv5bfKnVajkGvud88TMNw3NwqO1jP
b2XiXs/1VvJkqHC/KYkd82iDUOdiDxvXtl8ZxVRA3m4WjtTIB8eJCZitc75fNrzl
fshoP0XQfbNQBBvfP7IBvPIhNuRPgmRMcDdzisqM+c2mAAzQQ04AZ11olhTZzYW0
HEx6vExkdNBXy/Q0pWas5Zvxe4eTONi7ls14GMKzMeecDnlbQh6P/dCf9ZGF06eM
biMSsnUiYeGsCgtAm9voq0omuVaDY6BDtlsJ50UyMnS5cCIkQrA1Vlt6g8MNt3jh
yXX8L0SxORCBiLGobFnxMSqvuxZkHjp7Jq/k4S3JK2mYxWlJHzcOB8yioI99ErqU
IO+2bqljuNe9v95bh3wu82UjhpU+gmbL5TMqR3mVGGH6mW2WJaRkujQL9hK/efde
V5T4oSM85QajxodYF4nsnhVjmQLzyDxQcVTyj6yQk+cwr68guOMkh389G29Kxgoi
otz1VvR5vYO5/KOFRDkELA8XLEIWtKmwYXTwmwzjX36GdeQpDny3JGJMlBPP7xVd
cBCzK/zh7Ize/pWhN5KSAhJ/a0jByClU0VtMD5d8da6dClWkO6k+Mg9nynSsIAOr
ALJ7RZP/EF2k6WwUtdrGluUCAwEAAQ==
-----END PUBLIC KEY-----
");

?>