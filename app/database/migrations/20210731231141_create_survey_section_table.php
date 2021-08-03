<?php

use \Migrations\Migration;
use Illuminate\Support\Str;
class CreateSurveySectionTable extends Migration
{
  public function up()
  {
    $this->schema->create('survey_sections', function (Illuminate\Database\Schema\Blueprint $table) {
      $table->uuid('id')->primary();
      $table->uuid('templateId')->nullable(false);
      $table->foreign('templateId')->references('id')->on('survey_templates')->onDelete('cascade');;
      $table->integer('order');
      $table->string('title');
      $table->string('subtext');
      $table->string('icon')->nullable();
      $table->dateTime('createdAt')->useCurrent();
      $table->dateTime('updatedAt')->useCurrent();
    });

    $faker = Faker\Factory::create();
    $data = [];
    $last_section=$this->fetchRow('SELECT count(*) FROM survey_sections');
    $order=$last_section[0];
    for ($i = 0; $i <50; $i++) {
      $template=$this->fetchRow('SELECT survey_templates.* FROM survey_templates
        JOIN brandings on brandings.templateId=survey_templates.id order by RAND()');
        $data[]=[
          'id'                =>(string)Str::uuid(),
          'templateId'        =>$template['id'],
          'order'             =>$order,
          'title'             =>$faker->words(3,true),
          'subtext'           =>$faker->words(3,true),
          'icon'              =>'https://source.unsplash.com/random'
        ];
        $order++;
      }
      $this->table('survey_sections')->insert($data)->save();
    }
    public function down()
    {

      $this->execute('SET FOREIGN_KEY_CHECKS = 0');
      $this->schema->drop('survey_sections');
    }
  }
