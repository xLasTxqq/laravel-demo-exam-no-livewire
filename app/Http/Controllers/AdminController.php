<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(){
        $app = Application::where('status','Новая')->get();
        return view('admin_page',['applications'=>$app]);
    }
}
