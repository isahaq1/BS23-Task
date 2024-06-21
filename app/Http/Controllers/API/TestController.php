<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function approveStatus(){
      $response['status'] = 'approved'; 
      return $response;
    }

    public function failStatus(){
        $response['status'] = 'failed'; 
        return $response;
      }
}
