<?php

namespace App\Controllers;
use Illuminate\Support\Str;
class Controller {
    protected $container;
    
    public function response(string $message="",$code){
        $result=[];
        if($code==400){
            $result["error"] ="bad_request";
            $result["description"] =$message;
        }else if($code==404){
            $result["error"] ="bad_request";
            $result["description"] =$message;
        }
        return $result;
       
    }

    public function validate($payload){
        $errors = [];
            foreach ($payload as $key=>$value) {
                if (empty($value)) {
                    $errors[] = $key;
                } 
            }
        return $errors;
        }
}