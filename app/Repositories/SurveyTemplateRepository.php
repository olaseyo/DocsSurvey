<?php
namespace App\Repositories;
use App\Repositories\Contracts\SurveyTemplateInterface;
use App\Models\SurveyTemplate;
use Illuminate\Support\Collection;
class SurveyTemplateRepository implements SurveyTemplateInterface{
	public $surveyTemplate;
	function __construct(SurveyTemplate $surveyTemplate){
		$this->surveyTemplate=$surveyTemplate;
	}

	public function getModel():SurveyTemplate
	{
		return $this->surveyTemplate;
	}

	public function find(string $id):?SurveyTemplate{
		return $this->surveyTemplate->find($id);
	}

	public function get():collection{
		return $this->surveyTemplate->get();
	}

	public function create(array $data):SurveyTemplate{
		return $this->surveyTemplate->create($data);
	}

	public function update($data,$id):bool{
		return $this->surveyTemplate->find($id)->update($data);
	}

	public function delete($conditions):bool{
		return $this->surveyTemplate->delete($conditions);
	}

	public function getStatus(string $id):string{
		return $this->surveyTemplate->find($id)->surveyStatus;
	}

}
?>
