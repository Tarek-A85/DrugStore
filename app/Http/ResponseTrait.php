<?php
namespace App\Http;
trait ResponseTrait{
    public function Success($message){
        return response()->json([
            "status"=>true,
            "message"=>$message,
        ]);
    }
    public function Error($message){
        return response()->json([
            "status"=>false,
            "message"=>$message,
        ]);
    }
    public function Data($message,$data){
        return response()->json([
            "status"=>true,
            "message"=>$message,
            "data"=>$data,
        ]);
    }
}