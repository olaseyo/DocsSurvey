<?php
namespace App\Repositories;
use App\Repositories\Contracts\SurveySectionInterface;
use App\Models\SurveySection;
use Illuminate\Support\Collection;
class SurveySectionRepository implements SurveySectionInterface{
  public $surveySection;
  function __construct(SurveySection $surveySection){
    $this->surveySection=$surveySection;
  }

  public function getModel():SurveySection
  {
    return $this->surveySection;
  }

  public function find(string $id):?SurveySection{
    return $this->surveySection->find($id);
  }

  public function get():collection{
    return $this->surveySection->get();
  }

  public function create(array $data):SurveySection{
    return $this->surveySection->create($data);
  }

  public function update($data,$conditions):bool{
    return $this->surveySection->update($data,$conditions);
  }

  public function delete($conditions):bool{
    return $this->surveySection->delete($conditions);
  }
  public function getById(string $id):collection{
    return $this->surveySection->where('id',$id)->get();
  }

  public function getBySurveyId(string $id):collection{
    return $this->surveySection->where('templateId',$id)->get(['id','order','title','subtext','icon']);
  }

}
?>
