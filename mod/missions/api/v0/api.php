<?php

/**
* NRC Recommendation Platform API Library
* Copyright (c) 2017 National Research Council Canada
*
* Author: Luc Belliveau <luc.belliveau@nrc-cnrc.gc.ca>
*
*/
header('Content-Type: application/json');

global $meta_fields;
$meta_fields = [
  'education',
  'work',
  'gc_skills',
  'portfolio',
];

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
*
* @param str $type Desired entity type.  (object, user)
* @param str $subtype Desired subtype.  (mission)
* @param int $guid GUID of single object, for single entity fetch.
* @param int $since: Fetch objects that have been modified since the specified time
* @param int $before: Fetch obhects that have been modified before the specified time
* @param int $limit: Fetch at most X entities.
* @param int $resume: Resume starting at the specified GUID.
*
* @return Generator[] Guid iterable
*/
function mm_api_get_entity_guids($type, $subtype = false, $guid = null,
$since = null, $before = null, $limit = null, $resume = null, $sort = false) {
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

  $limit_sql = '';
  if (is_numeric($limit)) {
    $limit_sql = 'LIMIT ' . mysql_escape_string($limit);
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
    ' . $sort_sql . '
    ' . $limit_sql;

    $result = mysql_query($sql, _elgg_services()->db->getLink('read'));
    yield mysql_num_rows($result);
    $emit = !is_numeric($resume);
    while ($row = mysql_fetch_object($result)) {
      if ($emit) {
        yield $row->guid;
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
  function exportEntity($entity_or_guid) {
    // List of fields not to include in any export
    $omit = array('password', 'password_hash', 'salt');
    if (is_object($entity_or_guid)) {
      $entity = $entity_or_guid;
    } else {
      $entity = get_entity($entity_or_guid);
      if (!is_object($entity)) {
        $ret = new \stdClass;
        $ret->guid = $entity_or_guid;
        $ret->__error__ = 'Not found';
        return $ret;
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
    return $ret;
  }

  $skipped_counter = false;
  foreach ($entity_guids as $uguid) {
    if (!$skipped_counter) {
      $skipped_counter = true;
      continue;
    }
    if ($object = get_entity($uguid)) {
      $options = array(
        'guid' => $object->guid,
        'limit' => 0
      );

      $metadata = elgg_get_metadata($options);
      $annotations = elgg_get_annotations($options);
      $relationships = get_entity_relationships($object->guid);
      $relationships2 = get_entity_relationships($object->guid, true);

      $data = exportEntity($object);

      if ($metadata) {
        foreach ($metadata as $v) {
          $prop = $v->name;
          $data->$prop = $v->value;
        }
      }
      if ($annotations) {
        foreach ($annotations as $v) {
          $data->annotations[$v->name] = $v->value;
        }
      }
      if ($relationships) {
        foreach ($relationships as $v) {
          $data->relationships[] = array(
            'direction' => 'OUT',
            'time_created' => $v->time_created,
            'id' => $v->id,
            'entity' => exportEntity($v->guid_two),
            'relationship' => $v->relationship,
          );
        }
      }
      if ($relationships2) {
        foreach ($relationships2 as $v) {
          $data->relationships[] = array(
            'direction' => 'IN',
            'time_created' => $v->time_created,
            'id' => $v->id,
            'entity' => exportEntity($v->guid_one),
            'relationship' => $v->relationship,
          );
        }
      }
      yield [ 'object' => $object, 'export' => $data ];
    }
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