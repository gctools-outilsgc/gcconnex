<?php
/**
 * Server-side cache for recommendation provider API
 *
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/dt/
 *
 * License: MIT
 * Copyright: Her Majesty the Queen in Right of Canada, as represented by
 * the Minister of National Research Council, 2019
 */

namespace NRC;

class ApiCache {
  // Filename to store cache into
  private $cacheFile = NULL;

  // Location to store cache files
  private $cacheFolder = '/tmp/nrc-api-cache/';

  // Number of seconds cache is valid
  private $cacheExpires = 3600;

  function __construct($signature) {
    $this->cacheFolder = sys_get_temp_dir() . '/nrc-api-cache/';
    if (!file_exists($this->cacheFolder)) {
      mkdir($this->cacheFolder);
    }
    $filename = base64_encode(json_encode($signature));
    $this->cacheFile = $this->cacheFolder . $filename;
  }

  public function get($cb) {
    $cached = false;
    if (file_exists($this->cacheFile)) {
      $fp = fopen($this->cacheFile, 'r');
      $cacheTime = (int)fgets($fp);
      if ($cacheTime < (time() + $this->cacheExpires)) {
        $cached = true;
        while (($buffer = fgets($fp)) !== false) {
          yield $buffer;
        }
      }
      fclose($fp);
    }
    if (!$cached) {
      $fp = fopen($this->cacheFile, 'w');
      fwrite($fp, time() . "\n");
      $data = $cb();
      while ($data->valid()) {
        $output = $data->current();
        fwrite($fp, $output . "\n");
        yield $output;
        $data->next();
      }
      fclose($fp);
    }
  }
}