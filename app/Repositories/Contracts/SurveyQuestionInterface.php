<?php
namespace App\Repositories\Contracts;
use App\Models\SurveyQuestion;
use Illuminate\Support\Collection;
interface SurveyQuestionInterface{
  public function find(string $id):?SurveyQuestion;
  public function get():collection;
  public function create(array $attribute):SurveyQuestion;
  public function update(array $data,array $conditions):bool;
  public function delete(array $conditions):bool;
  public function getBySubSectionId(string $id):collection;

}
?>
