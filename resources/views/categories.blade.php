@extends('app')
 @section('title')
 Категории
 @endsection
 @section('content')
 <div>
     @foreach($categories as $category)
     <div>
         <p>{{$category->name}}</p>
         <form method="post" action="{{route('category.destroy',$category->id)}}">
            @csrf
            @method('delete')
            <button>Удалить</button>
         </form>
     </div>
     @endforeach
 </div>
 <form method="post" action="{{route('category.store')}}">
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
        <input type="text" id="name" name="name">
    </div>
    <button>Создать категорию</button>
 </form>
 @endsection