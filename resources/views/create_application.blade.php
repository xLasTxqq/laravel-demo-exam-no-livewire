@extends('app')
 @section('title')
 Создать заявку
 @endsection
 @section('content')
 <form method="post" action="{{route('application.store')}}" enctype="multipart/form-data">
    @csrf
    <div class="errors">
     @if($errors->any())
        @foreach($errors->all() as $error)
        <div><strong>{{$error}}</strong></div>
        @endforeach
     @endif
     </div>
    <div>
        <label for="name">Название</label>
        <input class="shadow" type="text" value="{{old('name')}}" id="name" name="name">
    </div>
    <div>
        <label for="description">Описание</label>
        <textarea class="shadow" id="description" value="{{old('description')}}" name="description"></textarea>
    </div>
    <div>
        <label for="category">Категория</label>
        <select class="shadow" id="category" value="{{old('category')}}" name="category">
            <option value="0" hidden selected>Выберите категорию</option>
            @foreach($categories as $category)
            <option value="{{$category->id}}">{{$category->name}}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label for="image">Фото</label>
        <input class="shadow" type="file" id="image" name="image">
    </div>
    <button>Создать</button>
 </form>
 @endsection