<?php

/**
* Opportunity Platform API Library
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

  # Ensure API has full access via an admin account - but do not allow
  # this session to persist.
  session_destroy();
  login(get_user(6), false);
}

/**
* Based on the URL of the API call, collect the GUIDs of all interesting
* entities.
*
* Supported query parameters:
* - int since: Fetch objects that have been modified since the specified time*.
* - int before: Fetch obhects that have been modified before the specified time*.
* - int limit: Fetch at most X entities.
* * times are expressed as UNIX timestamps.
*
* @param str $type Desired entity type.  (object, user)
* @param str $subtype Desired subtype.  (mission)
* @param int $guid GUID of single object, for single entity fetch.
*
* @return mixed[] Returns array with guids at index 0 and fields at index 1.
*/
function mm_api_get_entity_guids($type, $subtype = false, $guid = null) {

  $where = array('a.type = "' . mysql_escape_string($type) . '"');
  if ($subtype !== false) {
    $subtype_id = get_data("select id from elggentity_subtypes where subtype = '$subtype'")[0]->id;
    $where[] = 'a.subtype = ' . $subtype_id;
  } else $subtype_id = 0;

  if (!is_null($guid) && is_numeric($guid)) {
    $where[] = 'a.guid = ' . mysql_escape_string(intval($guid));
  }
  if (isset($_GET['since']) && is_numeric($_GET['since'])) {
    $where[] = 'a.time_updated > ' . mysql_escape_string($_GET['since']);
  }
  if (isset($_GET['before']) && is_numeric($_GET['before'])) {
    $where[] = 'a.time_updated < ' . mysql_escape_string($_GET['before']);
  }

  $limit = '';
  if (isset($_GET['limit']) && is_numeric($_GET['limit'])) {
    $limit = 'LIMIT ' . mysql_escape_string($_GET['limit']);
  }

  $guids = get_data('
    SELECT
      a.guid
    FROM
      elggentities a
    WHERE ' . implode(' AND ', $where) . '
    ORDER BY
      a.time_updated ASC
    ' . $limit);

  return array(
    $guids,
    mm_api_get_entity_fields(
      (object) array(
        'type'=>$type,
        'subtype'=>$subtype_id
      )
    )
  );
}

/**
* Iterate over list of GUIDs and yields the complete object as a row.
*
* @param mixed $entity_guids Array of entity GUIDs
* @param mixed $fields Array of entity fields to query
* @param int $limit Maximum amount of entities to process.
*/
function mm_api_entity_export($entity_guids, $fields, $limit) {
  global $meta_fields;
  $c = 0;
  foreach ($entity_guids as $uguid) {
    $c++;
    if ($c > $limit) break;
    if ($object = get_entity($uguid->guid)) {
      $u = [];
      foreach ($object as $key=>$value) {
        if (!in_array($key, array('password', 'password_hash', 'salt'))) {
          $u[$key] = $value;
        }
      }
      foreach ($fields as $field) {
        $f = $field->string;
        if (in_array($f, $meta_fields)) {
          $u[$f] = mm_api_get_field_value($object->$f);
        } else {
          $u[$f] = $object->$f;
        }
      }
    }
    $u['relationships'] = array();
    $relationships = get_entity_relationships($u['guid']);
    foreach ($relationships as $rel) {
      if ($entity_name = mm_api_get_entity_type($rel->guid_two)) {
        $u['relationships'][] = array(
          'direction' => 'OUT',
          'time_created' => $rel->time_created,
          'id' => $rel->id,
          $entity_name => $rel->guid_two,
          'relationship' => $rel->relationship,
        );
      }
    }
    $relationships = get_entity_relationships($u['guid'], true);
    foreach ($relationships as $rel) {
      if ($entity_name = mm_api_get_entity_type($rel->guid_one)) {
        $u['relationships'][] = array(
          'direction' => 'IN',
          'time_created' => $rel->time_created,
          'id' => $rel->id,
          $entity_name => $rel->guid_one,
          'relationship' => $rel->relationship,
        );
      }
    }
    yield array($u, ($c < $limit));
 }
}

/**
* Convert the supplied $value to a format suitable for export.
*
* @param mixed $value Value to process
* @return mixed Scalar or array of data processed by mm_api_load_field
*/
function mm_api_get_field_value($value) {
  if (is_array($value)) {
    $ret = array();
    foreach ($value as $v) {
      $ret[] = mm_api_load_field($v);
    }
    return $ret;
  } else {
    return mm_api_load_field($value);
  }
}

/**
* If the supplied string is a GUID, return an entity representation, otherwise
* return as-is.
*
* @param mixed $guid Scalar value representing either another entity, or not.
* @return mixed Returns either an entity representation of $guid, or $guid.
*/
function mm_api_load_field($guid) {
  global $meta_fields;

  if (!is_numeric($guid)) return $guid;

  if ($obj = get_entity($guid)) {
    $ret = [];
    foreach ($obj as $key=>$value) {
      $ret[$key] = $value;
    }
    $objfields = mm_api_get_entity_fields($obj);
    foreach ($objfields as $field) {
      $f = $field->string;
      if (in_array($f, $meta_fields)) {
        $ret[$f] = mm_api_get_field_value($obj->$f);
      } else {
        $ret[$f] = $obj->$f;
      }
    }
    return $ret;
  }
  return $guid;
}

/**
* Determine all field names available for given entity.
*
* @param object $entity Elgg entity object
* @return mixed Array of field names
*/
function mm_api_get_entity_fields($entity) {

  $field_id_sql = "
    SELECT
      DISTINCT name_id
    FROM
      elggmetadata a
      INNER JOIN elggentities b ON a.entity_guid = b.guid
    WHERE
      b.type = '{$entity->type}'
      AND b.subtype = {$entity->subtype}
  ";
  $field_ids_res = get_data($field_id_sql);
  $field_ids = array();
  foreach ($field_ids_res as $fir) $field_ids[] = $fir->name_id;

  $field_query_sql = "
    SELECT
      a.id,
      a.string
    FROM
      elggmetastrings a
    WHERE
      a.id IN (" . implode(',', $field_ids) .")
  ";

  $fields = get_data($field_query_sql);
  return $fields;
}

/**
* Determines if the supplied guid is an opportunity or a user.
*
* @param int $guid
* @return str 'opportunity', 'user' or null
*/
function mm_api_get_entity_type($guid) {
  $e = get_entity($guid);
  if (elgg_instanceof($e, 'object', 'mission')) {
    return 'opportunity';
  } else if (elgg_instanceof($e, 'user')) {
    return 'user';
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