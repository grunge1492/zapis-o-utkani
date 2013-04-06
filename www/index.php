<?php

// Uncomment this line if you must temporarily take down your site for maintenance.
// require '.maintenance.php';

// absolute filesystem path to this web root
define('WWW_DIR', dirname(__FILE__));

// absolute filesystem path to the libraries
define('LIBS_DIR', WWW_DIR . '/../libs');

// Let bootstrap create Dependency Injection container.
$container = require __DIR__ . '/../app/bootstrap.php';

// Run application.
$container->application->run();

