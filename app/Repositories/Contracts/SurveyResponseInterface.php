<?php
namespace App\Repositories\Contracts;
use App\Models\SurveyResponse;
use Illuminate\Support\Collection;
interface SurveyResponseInterface{
  public function find(string $id):?SurveyResponse;
  public function get():collection;
  public function create(array $attribute):SurveyResponse;
  public function update(array $data,array $conditions):bool;
  public function delete(array $conditions):bool;
  public function insertBulk(array $bulk_data):bool;
}
?>
