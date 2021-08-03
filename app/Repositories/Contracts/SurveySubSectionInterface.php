<?php
namespace App\Repositories\Contracts;
use App\Models\SurveySubSection;
use Illuminate\Support\Collection;
interface SurveySubSectionInterface{
  public function find(string $id):?SurveySubSection;
  public function get():collection;
  public function create(array $attribute):SurveySubSection;
  public function update(array $data,array $conditions):bool;
  public function delete(array $conditions):bool;
  public function getBySectionId(string $id):collection;
}
?>
