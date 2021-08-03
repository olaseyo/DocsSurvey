<?php
namespace App\Controllers;
use App\Repositories\SurveyTemplateRepository;
use App\Repositories\SurveySectionRepository;
use App\Repositories\SurveySubSectionRepository;
use App\Repositories\SurveyQuestionRepository;
use App\Models\SurveyTemplate;
use App\Models\Branding;
use App\Models\SurveySection;
use App\Models\SurveySubSection;
use App\Models\SurveyQuestion;
use App\Models\SurveyQuestionInput;
use Illuminate\Support\Str;
use App\Core\SurveyStatus;
use Slim\Http\Response;
use Illuminate\Support\Collection;
class SurveyTemplateController extends Controller{
  protected $surveyTemplate,$surveySection,$surveySubSection,$surveyQuestion;

  function __construct(SurveyTemplateRepository $surveyTemplate,SurveySectionRepository $surveySection,SurveySubSectionRepository $surveySubSection,SurveyQuestionRepository $surveyQuestion){
    $this->surveyTemplate=$surveyTemplate;
    $this->surveySection=$surveySection;
    $this->surveySubSection=$surveySubSection;
    $this->surveyQuestion=$surveyQuestion;
  }
  public function getSection(string $surveyId):collection{
    $sections=$this->surveySection->getBySurveyId($surveyId);
    $index=0;
    foreach($sections as $section){
      $sectionId=$section->id;
      $sections[$index]->subsections=$this->getSubSection($section);
      unset($sections[$index]['id']);
      $questionIndex=0;
      foreach($sections[$index]->subsections as $subsection){
        $sections[$index]->subsections[$questionIndex]->questions=$this->getQuestions($subsection);
        unset($sections[$index]->subsections[$questionIndex]['id']);
        $questionInputIndex=0;
        foreach($sections[$index]->subsections[$questionIndex]->questions as $question){
          $input=$sections[$index]->subsections[$questionIndex]->questions[$questionInputIndex]->input=$this->getInputs($question);
          $questionInputIndex++;
        }
        $questionIndex++;
      }

      $index++;
    }
    return $sections;
  }

  public function getSubSection(SurveySection $section):collection{
    $subSection=$section->survey_sub_sections()->get(['id','order','title','icon']);
    return $subSection;
  }

  public function getQuestions(SurveySubSection $subSection):collection{
    $questions=$subSection->survey_questions()->get(['id','order','slug','prompt','required']);
    return $questions;
  }


  public function getInputs(SurveyQuestion $question):array{
    $questionInputs=$question->survey_question_inputs()->first(['id','type']);
    $questionInputsToArray=[];
    if($questionInputs){
      $questionInputsToArray=$questionInputs->toArray();
      unset($questionInputsToArray['id']);
      $questionInputsToArray['options']['enumns']=$this->getInputOptions($questionInputs);
    }
    return $questionInputsToArray;
  }

  public function getInputOptions(SurveyQuestionInput $input):collection{

    $questionInputOptions=$input->survey_question_input_options()->get(['display','value','order','isDefault']);
    return $questionInputOptions;
  }
  public function getBrand(SurveyTemplate $template):Branding{
    return ($template)? $template->brandings()
    ->first(['logo','logoCaption','bannerTitle','bannerSubtext'])
    :new Branding();
  }
  public function getSurveyAndQuestions($request, $response,$args) {
    $surveyId=$args['surveyId'];

    if(!$this->surveyTemplate->find($surveyId)){
      $result["error"] ="bad_request";
      $result["description"] = "survey not found";
      return $response->withJson($result, 404);
    }
    if($this->surveyTemplate->getStatus($surveyId)==SurveyStatus::$SUBMITTED){
      $result["error"] ="bad_request";
      $result["description"] = "survey already completed";
      return $response->withJson($result, 400);
    }

    $template=$this->surveyTemplate->getModel()->where('id',$surveyId)->first(['id','surveyStatus','createdAt','lastEvent']);
    if($template){
      $template->branding=$this->getBrand($template);
      $template->sections=$this->getSection($template->id);
    }
    return $response->withJson($template,200);
  }

  public function completeSurvey($request, $response,$args):Response{
    $input=(array)$request->getParsedBody();
    $result=[];
    if(!isset($input['surveyStatus'])){
      $result["error"] ="bad_request";
      $result["description"] = "invalid request payload";
      return $response->withJson($result, 400);
    }
    if(!$this->surveyTemplate->find($args['surveyId'])){
      $result["error"] ="bad_request";
      $result["description"] = "survey not found";
      return $response->withJson($result, 404);
    }
    if($this->surveyTemplate->getStatus($args['surveyId'])==SurveyStatus::$SUBMITTED){
      $result["error"] ="bad_request";
      $result["description"] = "survey already completed";
      return $response->withJson($result, 400);
    }
    $data=$this->surveyTemplate->update($input,$args['surveyId']);
    if($data){
      return $response->withJson("survey successfully completed",200);
    }
  }
}
