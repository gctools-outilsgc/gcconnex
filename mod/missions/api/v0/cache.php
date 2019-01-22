<?php
/**
 * Server-side cache for recommendation provider API
 *
 * Construct a ApiCache object by passing an array of all parameters that
 * uniquely identifies the request.  The array will be serialized then base64
 * encoded to generate a cache filename that can be easily referenced later.
 *
 * Calling the get() generator will either yield data from cache, or proxied
 * and automatically cached data via the provided generator closure.
 *
 * Cache files are newline seperated data chunks to be yielded.
 * The first line is reserved for the timestamp the cache was created.
 *
 * By default, all caches live for 1 hour.  This can be overriden by
 * instantiating an ApiCache instance, and setting the cacheExpires property.
 *
 * @author National Research Council
 * @author Luc Belliveau
 * @link http://www.nrc-cnrc.gc.ca/eng/rd/dt/ NRC Digital Technologies
 *
 * @license MIT
 * @copyright Her Majesty the Queen in Right of Canada, as represented by the Minister of National Research Council, 2019
 */

namespace NRC;

class ApiCache {
  // Filename to store cache into
  private $cacheFile = NULL;

  // Location to store cache files, must end with a trailing /
  public $cacheFolder = NULL;

  // Number of seconds cache is valid.  Default is 3600 seconds, or 1 hour.
  public $cacheExpires = 3600;

  function __construct($signature) {
    $this->cacheFolder = sys_get_temp_dir() . '/nrc-api-cache/';
    if (!file_exists($this->cacheFolder)) {
      mkdir($this->cacheFolder);
    }
    $this->cacheFile = base64_encode(json_encode($signature));
  }

  /**
   * Get the requested cache, or call the callback $cb to seed it.
   *
   * @param Closure $cb generator
   */
  public function get($cb) {
    $cached = false;
    $filename = $this->cacheFolder . $this->cacheFile;

    if (file_exists($filename)) {
      $fp = fopen($filename, 'r');
      $cacheTime = (int)fgets($fp);
      if ($cacheTime < (time() + $this->cacheExpires)) {
        $cached = true;
        fpassthru($fp);
        // while (($buffer = fgets($fp, 4096)) !== false) {
        //   yield $buffer;
        // }
      }
      fclose($fp);
    }
    if (!$cached) {
      $fp = fopen($filename, 'w');
      fwrite($fp, time() . "\n");
      $data = $cb();
      while ($data->valid()) {
        $output = $data->current();
        fwrite($fp, $output);
        yield $output;
        $data->next();
      }
      fclose($fp);
    }
  }
}