@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<div class="contact-form__content">
    <div class="contact-form__heading">
        Contact
    </div>

    <form class="form" action="{{ route('contact.confirm') }}" method="post" novalidate>
    @csrf
    <div class="form__group">
        <div class="form__group-title">
            <span class="form__label--item">お名前</span>
            <span class="form__label--required">※</span>
        </div>
        <div class="form__group-content">
            <span class="form__input--text">
                <input type="text" name="first_name" placeholder="例:山田" value="{{ old('first_name', $contact['first_name'] ?? '') }}" />
                @error('first_name')
                    <p class="form__error">{{ $message }}</p>
                @enderror
                <input type="text" name="last_name" placeholder="例:太郎" value="{{ old('last_name', $contact['last_name'] ?? '') }}" />
                @error('last_name')
                    <p class="form__error">{{ $message }}</p>
                @enderror
            </span>
        </div>
    </div>
    <div class="form__group">
        <div class="form__group-title">
            <span class="form__label--item">性別</span>
            <span class="form__label--required">※</span>
        </div>
        <div class="form__group-content">
            <div class="form__input--radio">
            <input type="radio" id="male" name="gender" value="1" {{ old('gender', $contact['gender'] ?? '1') == '1' ? 'checked' : '' }} />
            <label for="male">男性</label>
            <input type="radio" id="female" name="gender" value="2" {{ old('gender', $contact['gender'] ?? '') == '2' ? 'checked' : '' }} />
            <label for="female">女性</label>
            <input type="radio" id="other" name="gender" value="3" {{ old('gender', $contact['gender'] ?? '') == '3' ? 'checked' : '' }} />
            <label for="other">その他</label>
            </div>
            @error('gender')
                <p class="form__error">{{ $message }}</p>
            @enderror
        </div>
    </div>
    <div class="form__group">
        <div class="form__group-title">
            <span class="form__label--item">メールアドレス</span>
            <span class="form__label--required">※</span>
        </div>
        <div class="form__group-content">
            <div class="form__input--text">
                <input type="email" class="input-full" name="email" placeholder="例:test@example.com" value="{{ old('email', $contact['email'] ?? '') }}" />
            </div>
            @error('email')
                <p class="form__error">{{ $message }}</p>
            @enderror
        </div>
    </div>
    <div class="form__group">
        <div class="form__group-title">
            <span class="form__label--item">電話番号</span>
            <span class="form__label--required">※</span>
        </div>
        <div class="form__group-content">
            <div class="form__input--text">
                <input type="tel" class="input-short" id="phone-part1" name="phone_part1" placeholder="080" value="{{ old('phone_part1', $contact['phone_part1'] ?? '') }}" />
                - <input type="tel" class="input-short" id="phone-part2" name="phone_part2" placeholder="1234" value="{{ old('phone_part2', $contact['phone_part2'] ?? '') }}" />
                - <input type="tel" class="input-short" id="phone-part3" name="phone_part3" placeholder="5678" value="{{ old('phone_part3', $contact['phone_part3'] ?? '') }}" />
            </div>
            @error('phone_number')
                <p class="form__error">{{ $message }}</p>
            @enderror
        </div>
    </div>
    <div class="form__group">
        <div class="form__group-title">
            <span class="form__label--item">住所</span>
            <span class="form__label--required">※</span>
        </div>
        <div class="form__group-content">
            <div class="form__input--text">
                <input type="text" class="input-full" name="address" placeholder="例:東京都渋谷区千駄ヶ谷1-2-3" value="{{ old('address', $contact['address'] ?? '') }}" />
            </div>
            @error('address')
            <p class="form__error">{{ $message }}</p>
            @enderror
        </div>
    </div>
    <div class="form__group">
        <div class="form__group-title">
            <span class="form__label--item">建物名</span>
        </div>
        <div class="form__group-content">
            <div class="form__input--text">
                <input type="text" name="building" class="input-full" placeholder="例:千駄ヶ谷マンション101" value="{{ old('building', $contact['building'] ?? '') }}" />
            </div>
            @error('building')
                <p class="form__error">{{ $message }}</p>
            @enderror
        </div>
    </div>
    <div class="form__group">
        <div class="form__group-title">
            <span class="form__label--item">お問い合わせの種類</span>
            <span class="form__label--required">※</span>
        </div>
        <div class="form__group-content">
            <div class="form__input--select">
                <select name="category_id" required>
                <option value="" disabled {{ old('category_id', $contact['category_id'] ?? '') == '' ? 'selected' : '' }}>選択してください</option>
                @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ old('category_id', $contact['category_id'] ?? '') == $category->id ? 'selected' : '' }}>{{ $category->content }}</option>
                @endforeach
                </select>
            </div>
            @error('category_id')
                <p class="form__error">{{ $message }}</p>
            @enderror
        </div>
    </div>
    <div class="form__group">
        <div class="form__group-title">
            <span class="form__label--item">お問い合わせ内容</span>
            <span class="form__label--required">※</span>
        </div>
        <div class="form__group-content">
            <div class="form__input--textarea">
            <textarea name="detail" class="input-full" placeholder="お問い合わせ内容をご記載ください">{{ old('detail', $contact['detail'] ?? '') }}</textarea>
            </div>
            @error('detail')
                <p class="form__error">{{ $message }}</p>
            @enderror
        </div>
    </div>
    <div class="form__button">
        <button class="form__button-submit" type="submit">確認画面</button>
    </div>
    </form>
</div>
@endsection
