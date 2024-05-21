<?php
namespace App\Http\Trait;

trait ApiResponseTrait{
    public function apiResponse($data,$message,$status){
        $array=[
            $data,
            $message,
        ];
        return response()->json($array,$status);
    }
    
    public function apiDelete($message,$status){
       
        return response()->json($message,$status);
    }
}