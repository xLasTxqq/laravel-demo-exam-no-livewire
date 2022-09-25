<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $app=Auth::user()->applications->sortByDesc('created_at');
        if($request->status=='Новая'||$request->status=='Отклонена'||$request->status=='Решена')
            $app=$app->where('status',$request->status);
        return view('profile',['applications'=>$app]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cat = Category::all();
        return view('create_application',['categories'=>$cat]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required|string',
            'description'=>'required|string',
            'category'=>'required|exists:categories,id',
            'image'=>'required|mimes:png,jpeg,jpg,bmp|max:10240'
        ]);

        $name = sprintf("%s.%s",str()->random(16),$request->file('image')->extension());
        Storage::putFileAs('public/images',$request->file('image'),$name);
        Application::create([
            'name'=>$request->name,
            'description'=>$request->description,
            'category_id'=>$request->category,
            'image'=>$name,
            'user_id'=>Auth::user()->id
        ]);

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function show(Application $application)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function edit(Application $application)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Application $application)
    {
        if($application->status!='Новая')return back();

        $request->validate([
            'status'=>'required|string|in:Решена,Отклонена',
            'comment'=>'exclude_if:status,Решена|string',
            'image'=>'exclude_if:status,Отклонена|mimes:png,jpeg,jpg,bmp|max:10240'
        ]);

        if($request->status=="Решена"){
            $name = sprintf("%s.%s",str()->random(16),$request->file('image')->extension());
            Storage::putFileAs('public/images',$request->file('image'),$name);
            $request->comment=null;
        }

        $application->update([
            'status'=>$request->status,
            'imageAfter'=>$name??null,
            'comment'=>$request->comment
        ]);
        $application->save();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function destroy(Application $application)
    {
        if($application->status!='Новая'||$application->user_id!=Auth::user()->id) return back();
        Storage::delete(sprintf('public/images/%s',$application->image));
        $application->delete();
        return back();
    }
}
