<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MainController extends Controller 
{
    public function index(){
        $app=Application::where('status','Решена')->orderByDesc('updated_at')->limit(4)->get();
        return view('main',[
            'applications'=>$app
        ]);
    }
    public function count(){
        return response()->json(['count'=>Application::where('status','Решена')->count()]);
    }
}
