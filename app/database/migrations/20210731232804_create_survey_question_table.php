<?php

use \Migrations\Migration;
use Illuminate\Support\Str;
class CreateSurveyQuestionTable extends Migration
{
  public function up()
  {
    $this->schema->create('survey_questions', function (Illuminate\Database\Schema\Blueprint $table) {
      $table->uuid('id')->primary();
      $table->uuid('templateId')->nullable(false);
      $table->foreign('templateId')->references('id')->on('survey_templates')->onDelete('cascade');
      $table->uuid('surveySectionId')->nullable(false);
      $table->foreign('surveySectionId')->references('id')->on('survey_sections')->onDelete('cascade');
      $table->uuid('surveySubSectionId')->nullable(false);
      $table->foreign('surveySubSectionId')->references('id')->on('survey_sub_sections')->onDelete('cascade');
      $table->integer('order');
      $table->string('slug')->nullable();
      $table->string('prompt');
      $table->boolean('required');
      $table->dateTime('createdAt')->useCurrent();
      $table->dateTime('updatedAt')->useCurrent();
    });

    $faker = Faker\Factory::create();
    $data = [];
    $order=$this->fetchRow('SELECT count(*) FROM survey_questions');
    $order_count=$order[0];
    for ($i = 0; $i <50; $i++) {
      $result=$this->fetchRow('SELECT survey_sub_sections.* FROM survey_sub_sections
        join survey_templates on survey_templates.id=survey_sub_sections.templateId
        join survey_sections on survey_sections.id=survey_sub_sections.surveySectionId order by RAND()');

        $data[]=[
          'id'                =>Str::uuid(),
          'templateId'        =>$result['templateId'],
          'surveySectionId'   =>$result['surveySectionId'],
          'surveySubSectionId'=>$result['id'],
          'slug'              =>str_slug($faker->words(3,true), '-'),
          'order'             =>$order_count,
          'prompt'            =>$faker->words(3,true),
          'required'          =>rand(0,1),
        ];
        $order_count++;
      }

      $this->table('survey_questions')->insert($data)->saveData();
    }
    public function down()
    {

      $this->execute('SET FOREIGN_KEY_CHECKS = 0');
      $this->schema->drop('survey_sub_sections');
    }
  }
