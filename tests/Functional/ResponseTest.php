<?php

namespace Tests\Functional;
use App\Models\SurveyQuestion;
class ResponseTest extends BaseTestCase
{
  /**
  * Test that the index route returns a rendered response containing the text 'SlimFramework' but not a greeting
  */
  function getTestData(){
    $test_data=SurveyQuestion::Select('survey_questions.*')
    ->JOIN('survey_templates','survey_templates.id','=','survey_questions.templateId')
    ->where('survey_templates.surveyStatus','!=','2')
    ->inRandomOrder()->first();
    return $test_data;
  }
  public function testCanSaveAQuestionResponse()
  {
    $test_data=$this->getTestData();
    $faker = \Faker\Factory::create();
    $payload=array(
      "id"=>$test_data->id,
      "value"=>$faker->words(10,true)
    );
    $response = $this->runApp('PUT',
    '/api/v1/surveys/'.$test_data->templateId.'/responses/'.$test_data->id.'',
    ($payload));
    $this->assertEquals(200, $response->getStatusCode());
  }

  public function testCanSaveSurveyResponses()
  {
    $payload=[];
    for($i=0;$i<6;$i++){
      $test_data=$this->getTestData();
      $faker = \Faker\Factory::create();
      $payload[]=array(
        "id"=>$test_data->id,
        "value"=>$faker->words(10,true)
      );
    }
    $response = $this->runApp('PUT',
    '/api/v1/surveys/'.$test_data->templateId.'/responses',
    ($payload));
    $this->assertEquals(200, $response->getStatusCode());
  }

  public function testCanGetAQuestionResponse()
  {
    $test_data=$this->getTestData();
    $response = $this->runApp('GET',
    '/api/v1/surveys/'.$test_data->templateId.'/responses/'.$test_data->id.'');
    $this->assertEquals(200, $response->getStatusCode());
  }

  public function testCanGetSurveyResponses()
  {
    $test_data=$this->getTestData();
    $response = $this->runApp('GET',
    '/api/v1/surveys/'.$test_data->templateId.'');
    $this->assertEquals(200, $response->getStatusCode());
  }

  public function testCanCompleteSurvey()
  {
    $test_data=$this->getTestData();
    $response = $this->runApp('PUT',
    '/api/v1/surveys/'.$test_data->templateId.'/status',['surveyStatus'=>2]);
    $this->assertEquals(200, $response->getStatusCode());

  }

}
