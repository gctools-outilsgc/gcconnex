<?php
global $START_MICROTIME;
global $DB_TIME;
global $MEMCACHE_TIME;
global $dbcalls;

$totaltime = microtime(true) - $START_MICROTIME;
$scripttime = $totaltime - $DB_TIME - $MEMCACHE_TIME;
?>
<!-- DB calls: <?php echo $dbcalls; ?>, Script time: <?php echo round($scripttime, 2); ?>, DB time: <?php echo round($DB_TIME,2); ?>, Memcache time: <?php echo round($MEMCACHE_TIME, 2); ?> -->
