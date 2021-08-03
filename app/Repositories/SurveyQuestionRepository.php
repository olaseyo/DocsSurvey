<?php
namespace App\Repositories;
use App\Repositories\Contracts\SurveyQuestionInterface;
use App\Models\SurveyQuestion;
use Illuminate\Support\Collection;
class SurveyQuestionRepository implements SurveyQuestionInterface{
  public $surveyQuestion;
  function __construct(SurveyQuestion $surveyQuestion){
    $this->surveyQuestion=$surveyQuestion;
  }

  public function getModel():SurveyQuestion
  {
    return $this->surveyQuestion;
  }

  public function find(string $id):?SurveyQuestion{
    return $this->surveyQuestion->find($id);
  }

  public function get():collection{
    return $this->surveyQuestion->get();
  }

  public function create(array $data):SurveyQuestion{
    return $this->surveyQuestion->create($data);
  }

  public function update($data,$conditions):bool{
    return $this->surveyQuestion->update($data,$conditions);
  }

  public function delete($conditions):bool{
    return $this->surveyQuestion->delete($conditions);
  }
  public function getBySubSectionId(string $id):collection{
    return $this->surveyQuestion->where('surveySubSectionId',$id)->get()->toArray();
  }

}
?>
