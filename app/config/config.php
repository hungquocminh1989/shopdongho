<?php
define('SYSTEM_BASE_URL', 'http://127.0.0.1/shopdongho/');
define('DATABASE_TYPE', 'pgsql');
define('DATABASE_NAME', 'sdh_2018');
define('DATABASE_HOST', '127.0.0.1');
define('DATABASE_USER', 'postgres');
define('DATABASE_PASS', '123456');
define('DATABASE_DNS', sprintf ('%1$s:dbname=%2$s;host=%3$s',DATABASE_TYPE, DATABASE_NAME, DATABASE_HOST));