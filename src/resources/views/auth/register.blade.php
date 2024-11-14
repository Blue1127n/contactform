@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
<link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
@endsection

@section('showLoginButton')
<a href="{{ route('login') }}" class="header__login-button">login</a>
@endsection

@section('content')
<div class="register__content">
    <div class="register__heading">
        Register
    </div>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    <form class="form" action="{{ route('register') }}" method="post" >
    @csrf
    <div class="form__group">
        <label for="name">お名前</label>
        <input type="text" name="name" id="name" value="{{ old('name') }}" placeholder="例: 山田 太郎" >
        @error('name')
        <p class="form__error">{{ $message }}</p>
    @enderror
    </div>
    <div class="form__group">
        <label for="email">メールアドレス</label>
        <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder="例: test@example.com" >
        @error('email')
        <p class="form__error">{{ $message }}</p>
    @enderror
    </div>
    <div class="form__group">
    <label for="password">パスワード</label>
    <input type="password" name="password" id="password" placeholder="例: coachtech1106" >
    @error('password')
        <p class="form__error">{{ $message }}</p>
    @enderror
</div>
    <div class="form__button">
        <button class="form__button-submit" type="submit">登録</button>
    </div>
    </form>
</div>
@endsection