<?php

namespace Migrations;

use Illuminate\Database\Capsule\Manager as Capsule;
use Phinx\Seed\AbstractSeed;

class Seed extends AbstractSeed
{
  /** @var \Illuminate\Database\Capsule\Manager $capsule */
  public $capsule;
  /** @var \Illuminate\Database\Schema\Builder $capsule */
  public $schema;

  public function init()
  {
    $this->capsule = new Capsule;
    $this->capsule->addConnection([
      'driver' => DB_ADAPTER,
      'host' => DB_HOST,
      'database' => DB_NAME,
      'username' => DB_USER,
      'password' => DB_PASS,
      'charset'   => 'utf8',
      'collation' => 'utf8_unicode_ci',
      'unix_socket'=>DB_SOCKET
    ]);

    $this->capsule->bootEloquent();
    $this->capsule->setAsGlobal();
    $this->schema = $this->capsule->schema();
  }
}
