@extends('app')
 @section('title')
 Регистрация
 @endsection
 @section('content')
 <form method="post" action="{{route('register.store')}}">
     @csrf
     <div class="errors">
     @if($errors->any())
        @foreach($errors->all() as $error)
        <li><strong>{{$error}}</strong></li>
        @endforeach
     @endif
     </div>
     <div> 
        <label for="fullname">Имя</label>
        <input onchange="validateAJAX()" type="text" value="{{old('fullname')}}" id="fullname" name="fullname">
    </div>
    <div>
        <label for="login">Логин</label>
        <input onchange="validateAJAX()" type="text" value="{{old('login')}}" id="login" name="login">
    </div>
    <div>
        <label for="email">Email</label>
        <input onchange="validateAJAX()" type="text" value="{{old('email')}}" id="email" name="email">
    </div>
    <div>
        <label for="password">Пароль</label>
        <input onchange="validateAJAX()" type="password" id="password" name="password">
    </div>
    <div>
        <label for="password_confirmation">Повтор пароля</label>
        <input onchange="validateAJAX()" type="password" id="password_confirmation" name="password_confirmation">
    </div>
    <div class="flex">
        <label for="accept">Согласие на обработку персональных данных</label>
        <input onchange="validateAJAX()" type="checkbox" id="accept" name="accept">
    </div>
    <button>Зарегистрироваться</button>
 </form>
 <script>
     function validateAJAX(){
     let xhr = new XMLHttpRequest()
        xhr.open('post', "{{route('register.store')}}", true)
        xhr.setRequestHeader('Content-Type', 'application/json; utf-8;')
        xhr.setRequestHeader('Accept', 'application/json;')
        let object = JSON.stringify({
            _token:"{{ csrf_token() }}",
            fullname:document.querySelector('#fullname').value,
            email:document.querySelector('#email').value,
            login:document.querySelector('#login').value,
            password:document.querySelector('#password').value,
            password_confirmation:document.querySelector('#password_confirmation').value,
            accept:document.querySelector('#accept').checked,
            
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
                    li.prepend(strong)
                    div.append(li)
                }
            }
            document.querySelector('.errors').replaceWith(div)

            console.log(JSON.parse(xhr.responseText))
        }
    }
 </script>
 @endsection