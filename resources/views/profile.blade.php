@extends('app')
 @section('title')
 Профиль
 @endsection
 @section('content')
 <div>
     <div>
         <a href="{{route('application.index')}}">Все</a>
         <a href="{{route('application.index',['status'=>'Новая'])}}">Новые</a>
         <a href="{{route('application.index',['status'=>'Отклонена'])}}">Отклоненные</a>
         <a href="{{route('application.index',['status'=>'Решена'])}}">Решенные</a>
    </div>
     @foreach($applications as $application)
     <div>
         <p>{{$application->created_at}}</p>
         <p>{{$application->name}}</p>
         <p>{{$application->description}}</p>
         <p>{{$application->status}}</p>
         @if($application->status=="Новая")
         <form onsubmit="return confirm('Вы действительно хотите удалить заявку?')" method="post" action="{{route('application.destroy',$application->id)}}">
         @csrf
         @method('delete')
             <button>Удалить</button>
         </form>
         @endif
     </div>
     @endforeach
 </div>
 @endsection