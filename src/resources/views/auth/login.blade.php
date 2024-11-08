@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
<link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
@endsection

@section('showLoginButton')
<a href="{{ route('register') }}" class="header__register-button">register</a>
@endsection

@section('content')
<div class="login__content">
    <div class="login__heading">
        Login
    </div>
    <form class="form" action="{{ route('login') }}" method="post" >
    @csrf
        <div class="form__group">
        <label for="email">メールアドレス</label>
        <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder="例: test@example.com" required>
        @error('email')
            <p class="form__error">{{ $message }}</p>
        @enderror
    </div>
    <div class="form__group">
    <label for="password">パスワード</label>
    <input type="password" name="password" id="password" placeholder="例: coachtech1106" required>
                @error('password')
                    <p class="form__error">{{ $message }}</p>
                @enderror
    </div>
    <div class="form__button">
        <button class="form__button-submit" type="submit">ログイン</button>
    </div>
    </form>
</div>
@endsection