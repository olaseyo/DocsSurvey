<?php
namespace App\Repositories;
use App\Repositories\Contracts\SurveySubSectionInterface;
use App\Models\SurveySubSection;
use Illuminate\Support\Collection;
class SurveySubSectionRepository implements SurveySubSectionInterface{
  public $surveySubSection;
  function __construct(SurveySubSection $surveySubSection){
    $this->surveySubSection=$surveySubSection;
  }

  public function getModel():SurveySubSection
  {
    return $this->surveySubSection;
  }

  public function find(string $id):?SurveySubSection{
    return $this->surveySubSection->find($id);
  }

  public function get():collection{
    return $this->surveySubSection->get();
  }

  public function create(array $data):SurveySubSection{
    return $this->surveySubSection->create($data);
  }

  public function update($data,$conditions):bool{
    return $this->surveySubSection->update($data,$conditions);
  }

  public function delete($conditions):bool{
    return $this->surveySubSection->delete($conditions);
  }
  public function getBySectionId(string $id):collection{
    return $this->surveySubSection->where('surveySectionId',$id)->get(['id','order','title','icon'])->toArray();
  }

}
?>
