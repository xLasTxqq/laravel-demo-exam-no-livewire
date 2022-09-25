@extends('app')
@section('title')
Страница админа
@endsection
@section('content')
<div>
    @foreach($applications as $application)
    <div>
        <p>{{$application->created_at}}</p>
        <p>{{$application->name}}</p>
        <p>{{$application->categories->name}}</p>
        <img src="{{sprintf('%s/storage/images/%s',route('main'),$application->image)}}">
        <form method="post" action="{{route('application.update',$application->id)}}" enctype="multipart/form-data">
            @csrf
            @method('patch')
            <div class="errors">
                @if($errors->any())
                @foreach($errors->all() as $error)
                <div><strong>{{$error}}</strong></div>
                @endforeach
                @endif
            </div>
            <div>
                <label for="status">Статус</label>
                <select onchange="changeStatus(this)" class="shadow" id="category" name="status">
                    <option value="Решена">Решена</option>
                    <option value="Отклонена">Отклонена</option>
                </select>
            </div>
            <div id="reject" class="hidden">
                <label for="comment">Комментарий</label>
                <textarea class="shadow" id="comment" name="comment"></textarea>
            </div>
            <div id="accept">
                <label for="image">Фото</label>
                <input class="shadow" type="file" id="image" name="image">
            </div>
            <button>Изменить</button>
        </form>
    </div>
    @endforeach
</div>
<script>
    function changeStatus(e) {
        if (e.value == "Решена") {
            document.querySelector('#reject').classList.add('hidden')
            document.querySelector('#accept').classList.remove('hidden')
        } else if (e.value == "Отклонена") {
            document.querySelector('#reject').classList.remove('hidden')
            document.querySelector('#accept').classList.add('hidden')
        }
    }
</script>
@endsection