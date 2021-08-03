<?php
require_once __DIR__ . '/../config.php';
return [
  'settings' => [
    'displayErrorDetails' => true, // set to false in production
    'addContentLengthHeader' => false, // Allow the web server to send the content-length header



    // Monolog settings
    'logger' => [
      'name' => 'slim-app',
      'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
      'level' => \Monolog\Logger::DEBUG,
    ],

    // Eloquent Database settings
    'db' => [
      'driver' =>DB_ADAPTER,
      'host' => DB_HOST,
      'database' =>DB_NAME,
      'username' =>DB_USER,
      'password' =>DB_PASS,
      'charset'   => 'utf8',
      'collation' => 'utf8_unicode_ci',
      'prefix'    => '',
      'unix_socket'=>DB_SOCKET
    ]
  ],
];
