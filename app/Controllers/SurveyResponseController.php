<?php
namespace App\Controllers;
use App\Repositories\SurveyResponseRepository;
use App\Models\SurveyResponse;
use App\Repositories\SurveyTemplateRepository;
use App\Models\SurveyQuestion;
use App\Repositories\SurveyQuestionRepository;
use App\Core\SurveyStatus;
use App\Models\SurveyTemplate;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Slim\Http\Response;
class SurveyResponseController extends Controller{
  protected $surveyResponse,$surveyTemplate,$surveyQuestion;

  function __construct(SurveyResponseRepository $surveyResponse,SurveyTemplateRepository $surveyTemplate,SurveyQuestionRepository $surveyQuestion){
    $this->surveyResponse=$surveyResponse;
    $this->surveyTemplate=$surveyTemplate;
    $this->surveyQuestion=$surveyQuestion;
  }

  public function checkRecord(array $rules,array $input):array{
    $response=[];
    if(isset($input['surveyId']) && in_array("survey",$rules)){
    if(!$this->surveyTemplate->find($input['surveyId'])){
      $response=array(
        "code"=>400,
        "description"=>"survey not found"
      );
      return $response;
    }
    if($this->surveyTemplate->getStatus($input['surveyId'])==SurveyStatus::$SUBMITTED &&  in_array("status",$rules)){
      $response=array(
        "code"=>400,
        "description"=>"survey already completed"
      );
      return $response;
    }
  }else if(isset($input['id']) &&  in_array("question",$rules)){
    if(!$this->surveyQuestion->find($input['id'])){
      $response=array(
        "code"=>404,
        "description"=>"question not found"
      );
      return $response;
    }
  }
  return [];
}
  public function saveQuestionResponse($request, $response,$args):Response{
    $input=(array)$request->getParsedBody();
    $result=[];
    if(count($this->validate($input,['id','value']))>0) {
      $result=$this->response('invalid request payload',400);
      return $response->withJson($result, 400);
    }
    $validate_payload=[];
    $validate_payload['surveyId']=$args['surveyId'];
    $validate_payload['id']=$input['id'];
    $checks=$this->checkRecord(['survey','question','status'],$validate_payload);
    if(count($checks)>0){
      $validator_response=$this->response($checks['description'],$checks['code']);
      return $response->withJson($validator_response,$checks['code']);
    }
    $input['templateId']=$args['surveyId'];
    $input['surveyQuestionId']=$input['id'];
    $input['id']=(string)Str::uuid();
    $data=$this->surveyResponse->create($input);
    return $response->withJson("responses saved",200);
  }

  public function getQuestionResponse($request, $response,$args):Response{
    $result=[];
    $validate_payload=[];
    $validate_payload['surveyId']=$args['surveyId'];
    $validate_payload['id']=$args['questionId'];
    $checks=$this->checkRecord(['survey','question','status'],$validate_payload);
    if(count($checks)>0){
      $validator_response=$this->response($checks['description'],$checks['code']);
      return $response->withJson($validator_response,$checks['code']);
    }
    $data=$this->surveyResponse->getModel()->where('surveyQuestionId',$args['questionId'])->first(['id','value']);
    return $response->withJson($data,200);
  }
  public function getSurveyResponses($request, $response,$args):Response{
    $result=[];
    $validate_payload=[];
    $validate_payload['surveyId']=$args['surveyId'];
    $checks=$this->checkRecord(['survey','status'],$validate_payload);
    if(count($checks)>0){
      $validator_response=$this->response($checks['description'],$checks['code']);
      return $response->withJson($validator_response,$checks['code']);
    }

    $data=$this->surveyResponse->getModel()->where('templateId',$args['surveyId'])->get(['id','value']);
    return $response->withJson($data,200);
  }

  function prepareBulkResponse(array $payload,string $templateId):array{
    $repare_payload=[];
    $error_count=0;
    foreach($payload as $data){
      if(!$this->surveyQuestion->find($data['id'])){
        $error_count++;
      }
      $repare_payload[]=[
        'id'=>(string)Str::uuid(),
        'value'=>$data['value'],
        'templateId'=>$templateId,
        'surveyQuestionId'=>$data['id']
      ];

    }
    return ['validation_error_count'=>$error_count,'payload'=>$repare_payload];
  }

  public function saveSurveyResponses($request, $response,$args):Response{
    $input=(array)$request->getParsedBody();
    $result=[];
    if (count($input)==count($input,COUNT_RECURSIVE))
    {
      $result["error"] ="bad_request";
      $result["description"] = "bad request format";
      return $response->withJson($result, 400);
    }
    $validate_payload=[];
    $validate_payload['surveyId']=$args['surveyId'];
    $checks=$this->checkRecord(['survey','status'],$validate_payload);
    if(count($checks)>0){
      $validator_response=$this->response($checks['description'],$checks['code']);
      return $response->withJson($validator_response,$checks['code']);
    }
    $prepared_payload=$this->prepareBulkResponse($input,$args['surveyId']);
    if($prepared_payload['validation_error_count']>0){
      $result["error"] ="bad_request";
      $result["description"] = $prepared_payload['validation_error_count']." question(s) not found";
      return $response->withJson($result, 404);
    }
    $data=$this->surveyResponse->insertBulk($prepared_payload['payload']);
    return $response->withJson("responses saved",200);
  }

}
