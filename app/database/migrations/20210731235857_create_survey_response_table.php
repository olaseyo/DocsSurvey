<?php

use \Migrations\Migration;

class CreateSurveyResponseTable extends Migration
{
  public function up()
  {
    $this->schema->create('survey_responses', function (Illuminate\Database\Schema\Blueprint $table) {
      $table->uuid('id')->primary();
      $table->uuid('surveyQuestionId')->nullable(false);
      $table->foreign('surveyQuestionId')->references('id')->on('survey_questions')->onDelete('cascade');
      $table->uuid('templateId')->nullable(false);
      $table->foreign('templateId')->references('id')->on('survey_templates')->onDelete('cascade');
      $table->text('value');
      $table->dateTime('createdAt')->useCurrent();
      $table->dateTime('updatedAt')->useCurrent();
    });
  }
  public function down()
  {

    $this->execute('SET FOREIGN_KEY_CHECKS = 0');
    $this->schema->drop('survey_responses');
  }
}
