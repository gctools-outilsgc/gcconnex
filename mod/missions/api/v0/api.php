<?php
/**
* NRC Recommendation Platform API Library
*
* @author National Research Council
* @author Luc Belliveau
* @link http://www.nrc-cnrc.gc.ca/eng/rd/dt/ NRC Digital Technologies
*
* @license MIT
* @copyright Her Majesty the Queen in Right of Canada, as represented by the Minister of National Research Council, 2019
*
*/
require_once(elgg_get_plugins_path() . 'missions/api/v0/cache.php');

header('Content-Type: application/json');

global $subtypes;
$subtypes = NULL;

class FakeGUIDEntity {
  public $guid;
  public function __construct($guid) {
    $this->guid = $guid;
  }
}

class FakeEntity extends \ElggEntity {
  private $entity;
  public function __construct($entity) {
    $this->entity = $entity;
  }
  public function __get($name) {
    return $this->entity->$name;
  }
  public function getType() {
    return $this->entity->type;
  }
  public function getSubtype() {
    global $subtypes;
    return $subtypes["i_{$this->entity->subtype}"];
  }
  public function getOwnerEntity() {
    if ($this->entity->owner_guid > 0) {
      return new FakeGUIDEntity($this->entity->owner_guid);
    } else return false;
  }
  public function getDisplayName() {
    return $this->entity->name;
  }
  public function getContainerEntity() {
    if ($this->entity->container_guid > 0) {
      return new FakeGUIDEntity($this->entity->container_guid);
    } else return false;
  }
  public function setDisplayName($displayName) {}
}

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
global $CONFIG;
function getURL($entity) {
  global $CONFIG;
  global $subtypes;
  $type = $entity->type;
  $subtype = $subtypes["i_{$entity->subtype}"];

  $url = '';

  if (isset($CONFIG->entity_url_handler[$type][$subtype])) {
    $function = $CONFIG->entity_url_handler[$type][$subtype];
    if (is_callable($function)) {
      $url = call_user_func($function, $entity);
    }
  } elseif (isset($CONFIG->entity_url_handler[$type]['all'])) {
    $function = $CONFIG->entity_url_handler[$type]['all'];
    if (is_callable($function)) {
      $url = call_user_func($function, $entity);
    }
  } elseif (isset($CONFIG->entity_url_handler['all']['all'])) {
    $function = $CONFIG->entity_url_handler['all']['all'];
    if (is_callable($function)) {
      $url = call_user_func($function, $entity);
    }
  }

  if ($url) {
    $url = elgg_normalize_url($url);
  }

  $params = array('entity' => new FakeEntity($entity));
  $url = _elgg_services()->hooks->trigger('entity:url', $type, $params, $url);

  return elgg_normalize_url($url);
}

function mm_build_subtypes_array() {
  global $subtypes;
  if (is_null($subtypes)) {
    $dbprefix = elgg_get_config('dbprefix');
    $dblink = _elgg_services()->db->getLink('read');

    // Get all subtypes
    $subtypes = [];
    $subtype_results = mysql_unbuffered_query(
      "select id, subtype from {$dbprefix}entity_subtypes",
      $dblink
    );
    while ($row = mysql_fetch_object($subtype_results)) {
      $subtypes["i_{$row->id}"] = $row->subtype;
      $subtypes["s_{$row->subtype}"] = $row->id;
    }
    mysql_free_result($subtype_results);
  }
}

function mm_api_generateWhereStatement($type, $subtype = false, $guid = null,
  $since = null, $before = null, $limit = null, $resume = null, $sort = false,
  $omit = null) {
  mm_build_subtypes_array();

  $dbprefix = elgg_get_config('dbprefix');
  $dblink = _elgg_services()->db->getLink('read');

  $where = ['a.enabled = "yes"'];
  if ($type !== 'export') {
    $where[] = 'a.type = "' . mysql_escape_string($type) . '"';
  }
  if ($subtype !== false) {
    $where[] = 'a.subtype = ' .
      (($subtypes["s_$subtype"]) ? $subtypes["s_$subtype"] : -1);
  }

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
  return $where_sql;
}

function mm_api_export_count($type, $subtype = false, $guid = null,
$since = null, $before = null, $limit = null, $resume = null, $sort = false,
$omit = null) {
  $where_sql = mm_api_generateWhereStatement($type, $subtype, $guid,
    $since, $before, $limit, $resume, $sort, $omit);
  $dbprefix = elgg_get_config('dbprefix');
  return (int)get_data(
    "select count(guid) c from {$dbprefix}entities a $where_sql"
    )[0]->c;
}


/**
* Stream the requested entities as efficently as possible using JSON.
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
* @return Generator[] JSON formatted text stream
*/
function mm_api_export_entities($type, $subtype = false, $guid = null,
$since = null, $before = null, $limit = null, $resume = null, $sort = false,
$omit = null) {
  $cache = new NRC\ApiCache([
    $type, $subtype, $guid, $since, $before,
    $limit, $resume, $sort, $omit
  ]);
  $data = $cache->get(
    function() use ($type, $subtype, $guid, $since, $before,
    $limit, $resume, $sort, $omit) {
      _elgg_services()->db->establishLink('api_exporter');
      $dbprefix = elgg_get_config('dbprefix');
      $dblink = _elgg_services()->db->getLink('read');
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
      global $in_array;
      $in_array = false;
      function outVal($val, $start_with_comma=true) {
        global $in_array;
        $value = ($val->meta_type === 'integer') ?
          json_encode(intval($val->meta_value)) : json_encode($val->meta_value);
        if (($in_array !== false) && ($in_array == $val->meta_name)) {
          return (($start_with_comma) ? ',' : '').$value;
        }
        $ret = '';
        if (($in_array !== false) && (($in_array != $val->meta_name) || ($val->arr == 0))) {
          $ret .= ']';
          $in_array = false;
        }
        if ($start_with_comma) $ret .= ',';
        $ret .= '"' . $val->meta_name . '":';
        if ($val->arr != 0) {
          $ret .= '[';
          $in_array = $val->meta_name;
        }
        $ret .= $value;
        return $ret;
      }
      function finalizeEntity($uguid) {
        global $in_array;
        $dbprefix = elgg_get_config('dbprefix');
        $dblink = _elgg_services()->db->getLink('read');

        if ($uguid > 0) {
          if ($in_array) {
            yield ']';
            $in_array = false;
          }

          $options = array('guid' => $uguid, 'limit' => 0);
          $annotations = elgg_get_annotations($options);

          if ($annotations) {
            $data = [ 'annotations' => []];
            foreach ($annotations as $v) {
              if (!isset($data['annotations'][$v->name])) {
                $data['annotations'][$v->name] = [];
              };
              $data['annotations'][$v->name][] = dismount($v);
            }
            yield ','.substr(json_encode($data), 1, -1);
          }
          yield ',"relationships":[';

          $relstart = false;
          $reltable = "{$dbprefix}entity_relationships";
          $relationships = mysql_unbuffered_query(
            "SELECT * from $reltable where guid_one = " .
            mysql_escape_string($uguid) .
            ' OR guid_two = ' . mysql_escape_string($uguid),
            $dblink
          );
          while ($v = mysql_fetch_object($relationships)) {
            yield (($relstart) ? ',' : '') . json_encode(array(
              'direction' => ($v->guid_one == $uguid) ? 'OUT' : 'IN',
              'time_created' => $v->time_created,
              'id' => $v->id,
              'relationship' => $v->relationship,
              'entity' => ($v->guid_one == $uguid) ? $v->guid_two : $v->guid_one,
            ));
            $relstart = true;
          }
          mysql_free_result($relationships);
          yield ']}';
        }
      }

      $where_sql = mm_api_generateWhereStatement($type, $subtype, $guid,
        $since, $before, $limit, $resume, $sort, $omit);

      if ($sort) {
        $sort_sql = 'ORDER BY a.time_updated ASC';
      }

      try {
        $sql = "
        SELECT
          a.guid,
          a.type,
          a.subtype,
          a.owner_guid,
          a.site_guid,
          a.container_guid,
          a.time_created,
          a.time_updated,
          a.access_id,
          a.enabled,
          a.last_action,
          o.title,
          o.description,
          u.name,
          u.username,
          u.admin,
          u.banned,
          u.language,
          u.last_action AS user_last_action,
          u.prev_last_action,
          u.last_login,
          u.prev_last_login,
          g.name as group_name,
          g.description as group_description,
          (
            SELECT
              COUNT(name_id)
            FROM
              elggmetadata
            WHERE
              entity_guid = a.guid
              AND name_id = b.name_id
          ) > 1 as arr,
          b.value_type as meta_type,
          c.string as meta_name,
          d.string as meta_value
        FROM
          {$dbprefix}entities a
          LEFT JOIN {$dbprefix}objects_entity o on o.guid = a.guid
          LEFT JOIN {$dbprefix}users_entity u ON u.guid = a.guid
          LEFT JOIN {$dbprefix}groups_entity g ON g.guid = a.guid
          LEFT JOIN {$dbprefix}metadata b ON b.entity_guid = a.guid
          LEFT JOIN {$dbprefix}metastrings c ON c.id = b.name_id
          LEFT JOIN {$dbprefix}metastrings d ON d.id = b.value_id
        $where_sql
        $sort_sql";

        $entity_data = mysql_unbuffered_query(
          $sql,
          _elgg_services()->db->getLink('api_exporter')
        );
        $emit = !is_numeric($resume);
        $max = (is_numeric($limit) && ($limit > 0)) ? $limit : false;
        $count = 0;
        $currentGuid = -1;
        $uguid = -1;
        $euguid = -1;
        while ($row = mysql_fetch_object($entity_data)) {
          if ($emit) {
            if ($currentGuid != $row->guid) {
              $fin = finalizeEntity($currentGuid);
              foreach ($fin as $fs) yield $fs;
              $currentGuid = -1;
              $count += 1;
              if (($max !== false) && ($count > $max)) break;
              if ($count > 1) yield ',';
              yield '{';
              $currentGuid = $row->guid;
              $euguid = mysql_escape_string(intval($row->guid));
              $uguid = $row->guid;

              yield '"guid":' . $row->guid . ',' .
                '"type":"' . $row->type . '",' .
                '"subtype":' . $row->subtype . ',' .
                '"subtype_name":' . json_encode($subtypes["i_{$row->subtype}"]) . ',' .
                '"time_created":' . $row->time_created . ',' .
                '"url":' . json_encode(getURL($row)) . ',' .
                '"access_id":' . $row->access_id . ',' .
                '"time_updated":' . $row->time_updated . ',' .
                '"owner_guid":' . $row->owner_guid . ',' .
                '"container_guid":' . $row->container_guid . ',' .
                '"enabled":"' . $row->enabled . '",' .
                '"site_guid":' . $row->site_guid;
              if (!is_null($row->title)) {
                yield ',"title":' . json_encode($row->title) . ',' .
                  '"description":' . json_encode($row->description);
              }
              if (!is_null($row->group_name)) {
                yield ',"name":' . json_encode($row->group_name) . ',' .
                  '"description":' . json_encode($row->group_description);
              }
              if (!is_null($row->name)) {
                yield ',"name":' . json_encode($row->name) . ',' .
                  '"username":' . json_encode($row->username) . ',' .
                  '"language":"' . $row->language . '",' .
                  '"admin":"' . $row->admin . '",' .
                  '"banned":"' . $row->banned . '",' .
                  '"last_action":' . $row->user_last_action . ',' .
                  '"prev_last_action":' . $row->prev_last_action . ',' .
                  '"last_login":' . $row->last_login . ',' .
                  '"prev_last_login":' . $row->prev_last_login;
              } else {
                yield ',"last_action":' . $row->last_action;
              }
            }
            if (!is_null($row->meta_name)) yield outVal($row);
          }
          if (!$emit) {
            if ($row->guid == $resume) {
              $emit = true;
            }
          }
        }
        if ($currentGuid > 0) {
          $fin = finalizeEntity($currentGuid);
          foreach ($fin as $fs) yield $fs;
        }
      } catch (Exception $e) {
        yield ',"error": ' . json_encode($e);
      }
    }
  );
  while ($data->valid()) {
    yield $data->current();
    $data->next();
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