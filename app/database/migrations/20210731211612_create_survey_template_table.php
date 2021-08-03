<?php

use \Migrations\Migration;
use Illuminate\Support\Str;
class CreateSurveyTemplateTable extends Migration
{
  public function up()
  {
    $this->schema->create('survey_templates', function (Illuminate\Database\Schema\Blueprint $table) {
      $table->uuid('id')->primary();
      $table->boolean('global');
      $table->string('name');
      $table->enum('surveyStatus',[0,1,2]);
      $table->dateTime('lastEvent')->nullable();
      $table->integer('practiceId')->nullable();
      $table->integer('userId')->nullable();
      $table->dateTime('createdAt')->useCurrent();
      $table->dateTime('updatedAt')->useCurrent();
    });
    $faker = Faker\Factory::create();
    $data = [];
    for ($i = 0; $i <100; $i++) {
      $data[]=[
        'id'            =>Str::uuid(),
        'global'        =>rand(0,1),
        'name'          =>$faker->words(3,true),
        'surveyStatus'  =>rand(0,1),
        'lastEvent'     =>date('Y-m-d H:i:s'),
        'practiceId'    =>rand(0,1000),
        'userId'        =>rand(0,100)
      ];

    }

    $data=$this->table('survey_templates')->insert($data)->saveData();

  }
  public function down()
  {
    $this->execute('SET FOREIGN_KEY_CHECKS = 0');
    $this->schema->drop('survey_templates');
  }
}
