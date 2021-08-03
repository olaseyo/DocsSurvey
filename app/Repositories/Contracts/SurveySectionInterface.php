<?php
namespace App\Repositories\Contracts;
use App\Models\SurveySection;
use Illuminate\Support\Collection;
interface SurveySectionInterface{
  public function find(string $id):?SurveySection;
  public function get():collection;
  public function getById(string $id):collection;
  public function getBySurveyId(string $id):collection;
  public function create(array $attribute):SurveySection;
  public function update(array $data,array $conditions):bool;
  public function delete(array $conditions):bool;
}
?>
