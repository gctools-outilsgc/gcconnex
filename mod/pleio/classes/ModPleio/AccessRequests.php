<?php
namespace ModPleio;

class AccessRequests {
    function count() {
        $count = get_data_row("SELECT COUNT(*) AS total FROM pleio_request_access");
        return (int) $count->total;
    }

    function get($id) {
        $id = (int) $id;
        $entity = get_data_row("SELECT * FROM pleio_request_access WHERE id = {$id}");
        if ($entity) {
            return new AccessRequest($entity);
        }

        return null;
    }

    function fetchAll($limit = 20, $offset = 0) {
        $limit = (int) $limit;
        $offset = (int) $offset;
        
        $return = [];
        $entities = get_data("SELECT * FROM pleio_request_access ORDER BY time_created DESC LIMIT {$offset}, {$limit}");
        foreach ($entities as $entity) {
            $return[] = new AccessRequest($entity);
        }

        return $return;
    }
}