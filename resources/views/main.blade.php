@extends('app')
@section('title')
Главная
@endsection
@section('content')
<div>
    <div id="count"></div>
    @foreach($applications as $application)
    <div>
        <p>{{$application->updated_at}}</p>
        <p>{{$application->name}}</p>
        <p>{{$application->categories->name}}</p>
        <div id="images">
            <img class="before" src="{{sprintf('%s/storage/images/%s',route('main'),$application->image)}}">
            <img class="after" src="{{sprintf('%s/storage/images/%s',route('main'),$application->imageAfter)}}">
        </div>
    </div>
    @endforeach
</div>
<script>
    function count() {
        let xhr = new XMLHttpRequest()
        xhr.open('get', "{{route('count')}}", true)
        xhr.setRequestHeader('Content-Type', 'application/json')
        xhr.setRequestHeader('Accept', 'application/json')
        xhr.send()
        xhr.onload = () => {
            let count = JSON.parse(xhr.responseText)['count']
            document.querySelector('#count').textContent = `Заявок решено: ${count}`
            //Тут оповещение
        }
    }
    count()
    setInterval(count, 5000)
</script>
@endsection