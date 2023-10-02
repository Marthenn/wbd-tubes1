<?php
$env = parse_ini_file('../../.env');
foreach ($env as $key => $value) {
    putenv("$key=$value");
}

define('BASEURL', getenv('BASE_URL')); // path to public folder
// define('BASEURL', 'http://localhost/tugas-besar-1/src/public');

// DB
define('DB_HOST', getenv('DB_HOST'));
define('DB_USER', getenv('POSTGRES_USER'));
define('DB_PASS', getenv('POSTGRES_PASSWORD'));
define('DB_NAME', getenv('POSTGRES_DB'));
