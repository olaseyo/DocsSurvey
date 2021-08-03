<?php
namespace App\Repositories;
use App\Repositories\Contracts\SurveyResponseInterface;
use App\Models\SurveyResponse;
use Illuminate\Support\Collection;
class SurveyResponseRepository implements SurveyResponseInterface{
	public $surveyResponse;
	function __construct(SurveyResponse $surveyResponse){
		$this->surveyResponse=$surveyResponse;
	}

	public function getModel():SurveyResponse
	{
		return $this->surveyResponse;
	}

	public function find(string $id):?SurveyResponse{
		return $this->surveyResponse->find($id);
	}

	public function get():collection{
		return $this->surveyResponse->get();
	}

	public function create(array $data):SurveyResponse{
		return $this->surveyResponse->create($data);
	}

	public function update($data,$conditions):bool{
		return $this->surveyResponse->update($data,$conditions);
	}

	public function delete($conditions):bool{
		return $this->surveyResponse->delete($conditions);
	}

	public function insertBulk(array $bulk_data):bool{
		return $this->surveyResponse->insert($bulk_data);
	}
}
?>
