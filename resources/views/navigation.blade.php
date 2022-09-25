<div class="flex">
    <a href="{{route('main')}}">Главная</a>
    @guest
    <a href="{{route('login.index')}}">Логин</a>
    <a href="{{route('register.index')}}">Регистрация</a>
    @endguest
    @auth
    <a href="{{route('application.index')}}">Профиль</a>
    <a href="{{route('application.create')}}">Создать заявку</a>
    @if(Auth::user()->roles->name=="admin")
    <a href="{{route('category.index')}}">Категории</a>
    <a href="{{route('admin')}}">Кабинет админа</a>
    @endif
    <a href="{{route('logout')}}">Выход</a>
    @endauth
</div>