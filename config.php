<?php
// Configuration File - Taller DevOps
session_start();

define('APP_NAME', 'DevOps Shop & Promos');
define('DB_DRIVER', 'sqlite'); // 'sqlite' (instant out-of-box) or 'mysql'
define('DB_HOST', 'localhost');
define('DB_NAME', 'taller_devops');
define('DB_USER', 'root');
define('DB_PASS', '');
define('SQLITE_FILE', __DIR__ . '/database.sqlite');
