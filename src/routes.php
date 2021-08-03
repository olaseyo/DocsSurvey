<?php

use Slim\Http\Request;
use Slim\Http\Response;


// Root


$app->group('/api/v1', function() {
  $this->group('/surveys', function() {

    $this->get('/{surveyId}/responses/{questionId}', 'ResponseController:getQuestionResponse');
    $this->get('/{surveyId}/responses', 'ResponseController:getSurveyResponses');
    $this->get('/{surveyId}', 'SurveyTemplateController:getSurveyAndQuestions');
    $this->put('/{surveyId}/responses/{questionId}', 'ResponseController:saveQuestionResponse');
    $this->put('/{surveyId}/responses', 'ResponseController:saveSurveyResponses');
    $this->put('/{surveyId}/status', 'SurveyTemplateController:completeSurvey');

  });



});
