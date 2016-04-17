<?php
if (is_file('connectvars.prod.php'))
    include_once('connectvars.prod.php');

if (is_file('connectvars.local.php'))
    include_once('connectvars.local.php');

if (!defined('ENV'))
    define('ENV', 'prod');

if (!defined('DB_HOST'))
    define('DB_HOST', 'localhost');

if (!defined('DB_USER'))
    define('DB_USER', 'root');

if (!defined('DB_PASSWORD'))
    define('DB_PASSWORD', '123');

if (!defined('DB_NAME'))
    define('DB_NAME', 'myblog-db');






