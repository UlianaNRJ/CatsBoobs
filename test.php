<?php
define('DATE_FORMAT', 'M d, Y');
define('TIME_FORMAT', 'H:i:s');
define('SQL_FORMAT', 'Y-m-d H:i:s');

$x = strtotime("2011-10-12 10:27:21");
echo date(SQL_FORMAT, time());