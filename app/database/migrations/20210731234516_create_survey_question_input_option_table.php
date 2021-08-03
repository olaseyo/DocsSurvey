<?php

use \Migrations\Migration;
use Illuminate\Support\Str;
class CreateSurveyQuestionInputOptionTable extends Migration
{
  public function up()
  {
    $this->schema->create('survey_question_input_options', function (Illuminate\Database\Schema\Blueprint $table) {
      $table->uuid('id')->primary();
      $table->uuid('templateId')->nullable(false);
      $table->foreign('templateId')->references('id')->on('survey_templates')->onDelete('cascade');
      $table->uuid('surveySectionId')->nullable(false);
      $table->foreign('surveySectionId')->references('id')->on('survey_sections')->onDelete('cascade');
      $table->uuid('surveySubSectionId')->nullable(false);
      $table->foreign('surveySubSectionId')->references('id')->on('survey_sub_sections')->onDelete('cascade');
      $table->uuid('surveyQuestionId')->nullable(false);
      $table->foreign('surveyQuestionId')->references('id')->on('survey_questions')->onDelete('cascade');
      $table->uuid('surveyQuestionInputId')->nullable(false);
      $table->foreign('surveyQuestionInputId')->references('id')->on('survey_question_inputs')->onDelete('cascade');
      $table->string('display');
      $table->string('value');
      $table->integer('order');
      $table->boolean('isDefault')->default(0);
      $table->dateTime('createdAt')->useCurrent();
      $table->dateTime('updatedAt')->useCurrent();
    });

    $faker = Faker\Factory::create();
    $data = [];
    $order=$this->fetchRow('SELECT count(*) FROM survey_question_input_options');
    $order_count=$order[0];
    $types = array("dimensionInput","enumDropdown","rangeDropdown","enumRadio","enumRadioMultipleChoice","numInput","rangeSlider");
    for ($i = 0; $i <50; $i++) {
      shuffle($types);
      $result=$this->fetchRow('SELECT survey_question_inputs.* FROM survey_sub_sections
        join survey_templates on survey_templates.id=survey_sub_sections.templateId
        join survey_sections on survey_sections.id=survey_sub_sections.surveySectionId
        join survey_questions on survey_questions.surveySubSectionId=survey_sub_sections.id
        join survey_question_inputs on survey_question_inputs.surveyQuestionId=survey_questions.id order by RAND()');


        $data[]=[
          'id'                    =>Str::uuid(),
          'templateId'            =>$result['templateId'],
          'surveySectionId'       =>$result['surveySectionId'],
          'surveySubSectionId'    =>$result['surveySubSectionId'],
          'surveyQuestionId'      =>$result['surveyQuestionId'],
          'surveyQuestionInputId' =>$result['id'],
          'display'               =>$faker->words(3,true),
          'value'                 =>$faker->words(5,true),
          'order'                 =>$order_count,
          'isDefault'             =>rand(0,1),
        ];
        $order_count++;
      }

      $this->table('survey_question_input_options')->insert($data)->saveData();
    }
    public function down()
    {

      $this->execute('SET FOREIGN_KEY_CHECKS = 0');
      $this->schema->drop('survey_question_input_options');
    }
  }
