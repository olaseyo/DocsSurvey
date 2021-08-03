<?php
namespace App\Repositories\Contracts;
interface BrandingInterface{
  public function find($id);
  public function get();
  public function create(array $attribute);
  public function update(array $data,array $conditions);
  public function delete(array $conditions);
}
?>
