 @extends('app')
 @section('title')
 Логин
 @endsection
 @section('content')
 <form method="post" action="{{route('login.store')}}">
     @csrf
     <div class="errors">
     @if($errors->any())
        @foreach($errors->all() as $error)
        <li><strong>{{$error}}</strong></li>
        @endforeach
     @endif
     </div>
    <div>
        <label for="login">Логин</label>
        <input type="text" onchange="validateAJAX()" value="{{old('login')}}" id="login" name="login">
    </div>
    <div>
        <label for="password">Пароль</label>
        <input type="password" onchange="validateAJAX()" id="password" name="password">
    </div>
    <button>Войти</button>
 </form>
 <script>
     function validateAJAX(){
     let xhr = new XMLHttpRequest()
        xhr.open('post', "{{route('login.store')}}", true)
        xhr.setRequestHeader('Content-Type', 'application/json; utf-8;')
        xhr.setRequestHeader('Accept', 'application/json;')
        
        let object = JSON.stringify({
            _token:"{{ csrf_token() }}",
            login:document.querySelector('#login').value,
            password:document.querySelector('#password').value,
            
        })
        xhr.send(object)
        xhr.onload = () => {
            let div = document.createElement('div')
            div.classList.add('errors')
            if(xhr.responseText.length<1){
                document.querySelector('.errors').replaceWith(div)
                return
            }
            let response = JSON.parse(xhr.responseText)['errors']
            for(object in response){
                for(obj in response[object]){
                    let li = document.createElement('li')
                    let strong = document.createElement('strong')
                    strong.textContent = response[object][obj]
                    li.append(strong)
                    div.prepend(li)
                }
            }
            document.querySelector('.errors').replaceWith(div)

            console.log(JSON.parse(xhr.responseText))
        }
    }
 </script>
 @endsection