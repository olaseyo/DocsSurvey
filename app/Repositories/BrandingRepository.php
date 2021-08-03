<?php
namespace App\Repositories;
use App\Repositories\Contracts\BrandingInterface;
use App\Models\Branding;
class BrandingRepository implements BrandingInterface{
	public $branding;
	function __construct(Branding $branding){
		$this->branding=$branding;
	}

	public function getModel()
	{
		return $this->branding;
	}

	public function find($id){
		return $this->branding->find($id);
	}

	public function get(){
		return $this->branding->get();
	}

	public function create(array $data){
		return $this->branding->create($data);
	}

	public function update($data,$conditions){
		return $this->branding->update($data,$conditions);
	}

	public function delete($conditions){
		return $this->branding->delete($conditions);
	}
}
?>
