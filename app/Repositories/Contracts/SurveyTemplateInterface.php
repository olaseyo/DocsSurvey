<?php
namespace App\Repositories\Contracts;
use App\Models\SurveyTemplate;
use Illuminate\Support\Collection;
interface SurveyTemplateInterface{
  public function find(string $id):?SurveyTemplate;
  public function get():collection;
  public function create(array $attribute):SurveyTemplate;
  public function update(array $data,string $id):bool;
  public function delete(array $conditions):bool;
  public function getStatus(string $id):string;
}
?>
