<?php
require __DIR__ . '/config.php';
return [
    'paths' => [
      'migrations' => 'app/database/migrations',
      'seeds' => 'app/database/seeds'
    ],
    'migration_base_class' => '\Migrations\Migration',
    'seed_base_class' => '\Seeds\Seed',
    'environments' => [
      'default_database' => 'dev',
      'dev' => [
        'adapter' => DB_ADAPTER,
        'host' => DB_HOST,
        'name' => DB_NAME,
        'user' => DB_USER,
        'pass' => DB_PASS,
        'port' => DB_PORT,
        'unix_socket'=>DB_SOCKET
      ]
    ]
  ];