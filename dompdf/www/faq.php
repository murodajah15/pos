<?php include("head.inc"); ?>
<a name="FAQ"> </a>
<h2>Frequently Asked Questions</h2>

<ol>
<li><a href="#hello_world">Is there a 'hello world' script for dompdf?</a></li>

<li><a href="#dom">I'm getting the following error: <br/>
 Fatal error: DOMPDF_autoload() [function.require]: Failed opening required
 '/var/www/dompdf/include/domdocument.cls.php'
 (include_path='.:') in
 /var/www/dompdf/dompdf_config.inc.php
 on line 146</a></li>

<li><a href="#exec_time">I'm getting the following error: <br/> Fatal error:
  Maximum execution time of 30 seconds exceeded in /var/www/dompdf/dompdf.php
  on line XXX</a></li>

<li><a href="#tables">I have a big table and it's broken!</a></li>

</ol>

<div class="divider1">&nbsp;</div>

<a name="hello_world"> </a>
<h3>Is there a 'hello world' script for dompdf?</h3>

<p>Here's a hello world script:
<pre>
&lt;?php
require_once("dompdf_config.inc.php");
$html =
    '&lt;html&gt;&lt;body&gt;'.
    '&lt;p&gt;Hello World!&lt;/p&gt;'.
    '&lt;/body&gt;&lt;/html&gt;';

$dompdf = new DOMPDF();
$dompdf->load_html($html);

$dompdf->render();
$dompdf->stream("hello_world.pdf");

?&gt;
</pre>

<p>Put this script in the same directory as
dompdf_config.inc.php.  You'll have to change the paths in
dompdf_config.inc.php to match your installation.</p>

<a href="#FAQ">[back to top]</a>
<div class="divider2" style="background-position: 25% 0%">&nbsp;</div>

<a name="dom"> </a>
<h3>I'm getting the following error: <br/>
 Fatal error: DOMPDF_autoload() [function.require]: Failed opening required
 '/var/www/dompdf/include/domdocument.cls.php'
 (include_path='.:') in
 /var/www/dompdf/dompdf_config.inc.php
 on line 146</h3>

<p>This error occurs when the version of PHP that you are using does not have
the DOM extension enabled.  You can check which extensions are enabled by
examning the output of <code>phpinfo()</code>.</p>

<p>There are a couple of ways that the DOM extension could have been
disabled.  DOM uses libxml, so if libxml is not present on your server
then the DOM extension will not work.  Alternatively, if PHP was compiled
with the '--disable-dom' switch or the '--disable-xml' switch, DOM support
will also be removed.  You can check which switches were used to compile
PHP with <code>phpinfo()</code>.</p>

<a href="#FAQ">[back to top]</a>
<div class="divider1" style="background-position: 73% 0%">&nbsp;</div>

<a name="exec_time"> </a>
<h3>I'm getting the following error: <br/> Fatal error:
  Maximum execution time of 30 seconds exceeded in /var/www/dompdf/dompdf.php
  on line XXX</h3>

<p>Nested tables are not supported yet (v0.3.2) and can cause dompdf to enter an
endless loop, thus giving rise to this error.</p>

<a href="#FAQ">[back to top]</a>
<div class="divider2" style="background-position: 49% 0%">&nbsp;</div>

<a name="tables"> </a>
<h3>I have a big table and it's broken!</h3>

<p>Currently tables can not span pages.  If they do, their layout breaks.  This will 
hopefully be fixed soon.</p>

<a href="#FAQ">[back to top]</a>
<div class="divider1" style="background-position: 33% 0%">&nbsp;</div>
<? include "foot.inc" ?>