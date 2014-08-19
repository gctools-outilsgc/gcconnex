<?php

  // this is a quick hack of the compatibility script included with simple pie

  // Load Elgg engine
  require_once(dirname(dirname(dirname(dirname(dirname(__FILE__))))) . "/engine/start.php");

$php_ok = (function_exists('version_compare') && version_compare(phpversion(), '4.3.0', '>='));
$xml_ok = extension_loaded('xml');
$pcre_ok = extension_loaded('pcre');
$curl_ok = function_exists('curl_exec');
$zlib_ok = extension_loaded('zlib');
$mbstring_ok = extension_loaded('mbstring');
$iconv_ok = extension_loaded('iconv');

ob_start();

?>

<style type="text/css">
body {
}

#site {
  width:550px;
  margin:20px auto 0 auto;
  font:14px/1.4em "Lucida Grande", Verdana, Arial, Helvetica, Clean, Sans, sans-serif;
  letter-spacing:0px;
  color:#333;
  margin:0;
  padding:0;
}

#site a {
  color:#000;
  text-decoration:underline;
  padding:0 1px;
}

#site a:hover {
  color:#fff;
  background-color:#333;
  text-decoration:none;
  padding:0 1px;
}

#site p {
  margin:0;
  padding:5px 0;
}

#site em {
  font-style:normal;
  background-color:#ffc;
}

#site ul, ol {
  margin:10px 0 10px 20px;
  padding:0 0 0 15px;
}

#site ul li, ol li {
  margin:0 0 7px 0;
  padding:0 0 0 3px;
}

#site h2 {
  font-size:18px;
  padding:0;
  margin:30px 0 10px 0;
}

#site h3 {
  font-size:16px;
  padding:0;
  margin:20px 0 5px 0;
}

#site h4 {
  font-size:14px;
  padding:0;
  margin:15px 0 5px 0;
}

#site code {
  font-size:1.1em;
  background-color:#f3f3ff;
  color:#000;
}

#site em strong {
    text-transform: uppercase;
}

table#chart {
  border-collapse:collapse;
}

table#chart th {
  background-color:#eee;
  padding:2px 3px;
  border:1px solid #fff;
}

table#chart td {
  text-align:center;
  padding:2px 3px;
  border:1px solid #eee;
}

table#chart tr.enabled td {
  /* Leave this alone */
}

table#chart tr.disabled td, 
table#chart tr.disabled td a {
  color:#999;
  font-style:italic;
}

table#chart tr.disabled td a {
  text-decoration:underline;
}

.chunk {
  margin:20px 0 0 0;
  padding:0 0 10px 0;
  border-bottom:1px solid #ccc;
}

.footnote,
.footnote a {
  font:10px/12px verdana, sans-serif;
  color:#aaa;
}

.footnote em {
  background-color:transparent;
  font-style:italic;
}
</style>


  <div style="margin:0;">

<div id="elggreturn">
  <a href="javascript:history.go(-1)">Return to Tools Administration</a>
</div>

<div id="site">
  <div id="content">
    <div class="chunk">
      <h2 style="text-align:center;">SimplePie Compatibility Test</h2>
      <table cellpadding="0" cellspacing="0" border="0" width="100%" id="chart">
        <thead>
          <tr>
            <th>Test</th>
            <th>Should Be</th>
            <th>What You Have</th>
          </tr>
        </thead>
        <tbody>
          <tr class="<?php echo ($php_ok) ? 'enabled' : 'disabled'; ?>">
            <td>PHP&sup1;</td>
            <td>4.3.0 or higher</td>
            <td><?php echo phpversion(); ?></td>
          </tr>
          <tr class="<?php echo ($xml_ok) ? 'enabled' : 'disabled'; ?>">
            <td><a href="http://php.net/xml">XML</a></td>
            <td>Enabled</td>
            <td><?php echo ($xml_ok) ? 'Enabled' : 'Disabled'; ?></td>
          </tr>
          <tr class="<?php echo ($pcre_ok) ? 'enabled' : 'disabled'; ?>">
            <td><a href="http://php.net/pcre">PCRE</a>&sup2;</td>
            <td>Enabled</td>
            <td><?php echo ($pcre_ok) ? 'Enabled' : 'Disabled'; ?></td>
          </tr>
          <tr class="<?php echo ($curl_ok) ? 'enabled' : 'disabled'; ?>">
            <td><a href="http://php.net/curl">cURL</a></td>
            <td>Enabled</td>
            <td><?php echo (extension_loaded('curl')) ? 'Enabled' : 'Disabled'; ?></td>
          </tr>
          <tr class="<?php echo ($zlib_ok) ? 'enabled' : 'disabled'; ?>">
            <td><a href="http://php.net/zlib">Zlib</a></td>
            <td>Enabled</td>
            <td><?php echo ($zlib_ok) ? 'Enabled' : 'Disabled'; ?></td>
          </tr>
          <tr class="<?php echo ($mbstring_ok) ? 'enabled' : 'disabled'; ?>">
            <td><a href="http://php.net/mbstring">mbstring</a></td>
            <td>Enabled</td>
            <td><?php echo ($mbstring_ok) ? 'Enabled' : 'Disabled'; ?></td>
          </tr>
          <tr class="<?php echo ($iconv_ok) ? 'enabled' : 'disabled'; ?>">
            <td><a href="http://php.net/iconv">iconv</a></td>
            <td>Enabled</td>
            <td><?php echo ($iconv_ok) ? 'Enabled' : 'Disabled'; ?></td>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="chunk">
      <h3>What does this mean?</h3>
      <ol>
        <?php if ($php_ok && $xml_ok && $pcre_ok && $mbstring_ok && $iconv_ok && $curl_ok && $zlib_ok): ?>
        <li><em>You have everything you need to run SimplePie properly!  Congratulations!</em></li>
        <?php else: ?>
          <?php if ($php_ok): ?>
            <li><strong>PHP:</strong> You are running a supported version of PHP.  <em>No problems here.</em></li>
            <?php if ($xml_ok): ?>
              <li><strong>XML:</strong> You have XML support installed.  <em>No problems here.</em></li>
              <?php if ($pcre_ok): ?>
                <li><strong>PCRE:</strong> You have PCRE support installed. <em>No problems here.</em></li>
                <?php if ($curl_ok): ?>
                  <li><strong>cURL:</strong> You have <code>cURL</code> support installed.  <em>No problems here.</em></li>
                <?php else: ?>
                  <li><strong>cURL:</strong> The <code>cURL</code> extension is not available.  SimplePie will use <code>fsockopen()</code> instead.</li>
                <?php endif; ?>
  
                <?php if ($zlib_ok): ?>
                  <li><strong>Zlib:</strong> You have <code>Zlib</code> enabled.  This allows SimplePie to support GZIP-encoded feeds.  <em>No problems here.</em></li>
                <?php else: ?>
                  <li><strong>Zlib:</strong> The <code>Zlib</code> extension is not available.  SimplePie will ignore any GZIP-encoding, and instead handle feeds as uncompressed text.</li>
                <?php endif; ?>
  
                <?php if ($mbstring_ok && $iconv_ok): ?>
                  <li><strong>mbstring and iconv:</strong> You have both <code>mbstring</code> and <code>iconv</code> installed!  This will allow SimplePie to handle the greatest number of languages.  Check the <a href="http://simplepie.org/wiki/faq/supported_character_encodings">Supported Character Encodings</a> chart to see what's supported on your webhost.</li>
                <?php elseif ($mbstring_ok): ?>
                  <li><strong>mbstring:</strong> <code>mbstring</code> is installed, but <code>iconv</code> is not.  Check the <a href="http://simplepie.org/wiki/faq/supported_character_encodings">Supported Character Encodings</a> chart to see what's supported on your webhost.</li>
                <?php elseif ($iconv_ok): ?>
                  <li><strong>iconv:</strong> <code>iconv</code> is installed, but <code>mbstring</code> is not.  Check the <a href="http://simplepie.org/wiki/faq/supported_character_encodings">Supported Character Encodings</a> chart to see what's supported on your webhost.</li>
                <?php else: ?>
                  <li><strong>mbstring and iconv:</strong> <em>You do not have either of the extensions installed.</em> This will significantly impair your ability to read non-English feeds, as well as even some English ones.  Check the <a href="http://simplepie.org/wiki/faq/supported_character_encodings">Supported Character Encodings</a> chart to see what's supported on your webhost.</li>
                <?php endif; ?>
              <?php else: ?>
                <li><strong>PCRE:</strong> Your PHP installation doesn't support Perl-Compatible Regular Expressions.  <em>SimplePie is a no-go at the moment.</em></li>
              <?php endif; ?>
            <?php else: ?>
              <li><strong>XML:</strong> Your PHP installation doesn't support XML parsing.  <em>SimplePie is a no-go at the moment.</em></li>
            <?php endif; ?>
          <?php else: ?>
            <li><strong>PHP:</strong> You are running an unsupported version of PHP.  <em>SimplePie is a no-go at the moment.</em></li>
          <?php endif; ?>
        <?php endif; ?>
      </ol>
    </div>

    <div class="chunk">
      <?php if ($php_ok && $xml_ok && $pcre_ok && $mbstring_ok && $iconv_ok) { ?>
        <h3>Bottom Line: Yes, you can!</h3>
        <p><em>Your webhost has its act together!</em></p>
        <p class="footnote"><em><strong>Note</strong></em>: Passing this test does not guarantee that SimplePie will run on your webhost &mdash; it only ensures that the basic requirements have been addressed.</p>
      <?php } else if ($php_ok && $xml_ok && $pcre_ok) { ?>
        <h3>Bottom Line: Yes, you can!</h3>
        <p><em>For most feeds, it'll run with no problems.</em>  There are <a href="http://simplepie.org/wiki/faq/supported_character_encodings">certain languages</a> that you might have a hard time with though.</p>
        <p class="footnote"><em><strong>Note</strong></em>: Passing this test does not guarantee that SimplePie will run on your webhost &mdash; it only ensures that the basic requirements have been addressed.</p>
      <?php } else { ?>
        <h3>Bottom Line: We're sorry…</h3>
        <p><em>Your webhost does not support the minimum requirements for SimplePie.</em>  It may be a good idea to contact your webhost, and ask them to install a more recent version of PHP as well as the <code>xml</code>, <code>mbstring</code>, <code>iconv</code>, <code>curl</code>, and <code>zlib</code> extensions.</p>
      <?php } ?>
    </div>

    <div class="chunk">
      <p class="footnote">&sup1; &mdash; SimplePie 2 will not support PHP 4.x. The core PHP team has discontinued PHP 4.x patches and support. <a href="http://simplepie.org/blog/2007/07/13/simplepie-is-going-php5-only/">Read the announcement.</a></p>
      <p class="footnote">&sup2; &mdash; Some recent versions of the PCRE (PERL-Compatible Regular Expression) engine compiled into PHP have been buggy, and are the source of PHP segmentation faults (e.g. crashes) which cause random things like blank, white screens. Check the <a href="http://simplepie.org/support/">Support Forums</a> for the latest information on patches and ongoing fixes.</p>
    </div>

  </div>

</div>
</div>

<?php
  $content = ob_get_clean();
  $body = elgg_view_layout('one_column', $content);
  echo page_draw(null, $body);
?>
