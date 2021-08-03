<?php
use  App\Models\SurveyTemplate;
use  App\Repositories\SurveyTemplateRepository;
use  App\Models\SurveySection;
use  App\Repositories\SurveySectionRepository;
use  App\Models\SurveySubSection;
use  App\Repositories\SurveySubSectionRepository;
use  App\Models\SurveyResponse;
use  App\Repositories\SurveyResponseRepository;
use  App\Models\SurveyQuestion;
use  App\Repositories\SurveyQuestionRepository;



// DIC configurationm

$container = $app->getContainer();


// monolog
$container['logger'] = function ($c) {
  $settings = $c->get('settings')['logger'];
  $logger = new Monolog\Logger($settings['name']);
  $logger->pushProcessor(new Monolog\Processor\UidProcessor());
  $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
  return $logger;
};

// elequent
$capsule = new \Illuminate\Database\Capsule\Manager;
$capsule->addConnection($container['settings']['db']);
$capsule->setAsGlobal();
$capsule->bootEloquent();

$container['db'] = function($c)  use($capsule) {
  return $capsule;
};

// Override the default Not Found Handler
$container['notFoundHandler'] = function ($c) {
  return function ($request, $response) use ($c) {
    return $c['response']
    ->withStatus(404)
    ->withHeader('Content-Type', 'application/json')
    ->withJson(['error'=>'bad_request','description'=>'Page Not Found!'],404);
  };
};

// Override the default Not Allow Handler
$container['notAllowedHandler'] = function ($c) {
  return function ($request, $response, $methods) use ($c) {
    return $c['response']
    ->withStatus(405)
    ->withHeader('Allow', implode(', ', $methods))
    ->withHeader('Content-type', 'application/json')
    ->withJson(['error'=>'bad_request','description'=>'Method must be one of: ' . implode(', ', $methods)],400);
  };
};

// Override the default Not Allow Handler
$container['phpErrorHandler'] = function ($c) {
  return function ($request, $response, $error) use ($c) {
    return $c['response']
    ->withStatus(500)
    ->withHeader('Content-Type', 'application/json')
    ->withJson(['error'=>'bad_request','description'=>'Something went wrong!'.$error],500);
  };
};


/*
*=========Controllers Container Goes Here===========
*/
//Validator
$container['validator'] = function () {
  return new App\Validation\Validator;
};



//Survey Controller
$container['SurveyTemplateController'] = function ($c) {
  $surveyTemplateRepository = $c->get(SurveyTemplateRepository::class);
  $surveySectionRepository = $c->get(SurveySectionRepository::class);
  $surveySubSectionRepository = $c->get(SurveySubSectionRepository::class);
  $surveyQuestionRepository = $c->get(SurveyQuestionRepository::class);
  return new App\Controllers\SurveyTemplateController($surveyTemplateRepository,$surveySectionRepository,$surveySubSectionRepository,$surveyQuestionRepository);
};
//Response Controller
$container['ResponseController'] = function ($c) {
  $surveyResponseRepository = $c->get(SurveyResponseRepository::class);
  $surveyTemplateRepository = $c->get(SurveyTemplateRepository::class);
  $surveyQuestionRepository = $c->get(SurveyQuestionRepository::class);
  return new App\Controllers\SurveyResponseController($surveyResponseRepository,$surveyTemplateRepository,$surveyQuestionRepository);
};
$container[SurveyTemplateRepository::class] = function ($c) {
  $Model = new SurveyTemplate();
  return new App\Repositories\SurveyTemplateRepository($Model);
};

$container[SurveySectionRepository::class] = function ($c) {
  $Model = new SurveySection();
  return new App\Repositories\SurveySectionRepository($Model);
};
$container[SurveySubSectionRepository::class] = function ($c) {
  $Model = new SurveySubSection();
  return new App\Repositories\SurveySubSectionRepository($Model);
};

$container[SurveyResponseRepository::class] = function ($c) {
  $Model = new SurveyResponse();
  return new App\Repositories\SurveyResponseRepository($Model);
};

$container[SurveyQuestionRepository::class] = function ($c) {
  $Model = new SurveyQuestion();
  return new App\Repositories\SurveyQuestionRepository($Model);
};

//Auth Controller
$container['AuthController'] = function ($c) {
  return new App\Controllers\Auth\AuthController($c);
};

//CSRF protection middleware
$container['csrf'] = function ($c) {
  return new \Slim\Csrf\Guard;
};

//SignIn authentication
$container['auth'] = function ($c) {
  return new App\Auth\Auth;
};

//Middleware
$app->add(new \App\Middleware\ValidationErrorsMiddleware($container));
$app->add(new \App\Middleware\OldInputMiddleware($container));
//$app->add($container->csrf);
