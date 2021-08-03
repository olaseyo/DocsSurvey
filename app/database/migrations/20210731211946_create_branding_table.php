<?php

use \Migrations\Migration;
use Illuminate\Support\Str;
class CreateBrandingTable extends Migration
{
  public function up()
  {
    $this->schema->create('brandings', function (Illuminate\Database\Schema\Blueprint $table) {
      $table->uuid('id')->primary();
      $table->uuid('templateId')->nullable(false);
      $table->foreign('templateId')->references('id')->on('survey_templates')->onDelete('cascade');;
      $table->string('logo')->nullable();
      $table->string('logoCaption')->nullable();
      $table->string('bannerTitle');
      $table->text('bannerSubtext');
      $table->dateTime('createdAt')->useCurrent();
      $table->dateTime('updatedAt')->useCurrent();
    });

    $faker = Faker\Factory::create();
    $data = [];
    for ($i = 0; $i <50; $i++) {
      $template=$this->fetchRow('SELECT * FROM survey_templates order by RAND()');
      $data[]=[
        'id'            =>Str::uuid(),
        'logo'          =>'https://source.unsplash.com/random',
        'templateId'    =>$template['id'],
        'logoCaption'   =>$faker->words(3,true),
        'bannerTitle'   =>$faker->words(5,true),
        'bannerSubtext' =>$faker->words(10,true)
      ];

    }

    $data=$this->table('brandings')->insert($data)->saveData();
  }
  public function down()
  {
    $this->schema->drop('brandings');
  }
}
