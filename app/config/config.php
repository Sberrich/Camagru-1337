<?php
include_once 'database.php';
  // DB Params
  define('DB_HOST', 'mysql');
  define('DB_USER', 'root');
  define('DB_PASS', 'tiger');
  define('DB_NAME', 'camagru');

  // App Root
  define('APPROOT', dirname(dirname(__FILE__)));
  // URL Root
  define('URLROOT',''.$HOST.':8088/camagru');
  // Site Name
  define('SITENAME', 'Camagru');
  // App Version
  define('APPVERSION', '1.0.0');

//  define('AllowedMethods', ['','','','','','','','','','','','','','','','','','','','','']);
  