@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/confirm.css') }}">
@endsection

@section('content')
<div class="confirm__content">
    <div class="confirm__heading">
            Confirm
    </div>
    <form class="form" action="{{ route('contact.process') }}" method="post">
    @csrf
    <div class="confirm-table">
        <table class="confirm-table__inner">
            <tr class="confirm-table__row">
                <th class="confirm-table__header">お名前</th>
                <td class="confirm-table__text">
                    {{ $contact['first_name'] }} {{ $contact['last_name'] }}
                    <input type="hidden" name="first_name" value="{{ $contact['first_name'] }}" />
                    <input type="hidden" name="last_name" value="{{ $contact['last_name'] }}" />
                </td>
            </tr>
            <tr class="confirm-table__row">
                <th class="confirm-table__header">性別</th>
                <td class="confirm-table__text">
                    {{ $contact['gender_text'] }}
                    <input type="hidden" name="gender" value="{{ $contact['gender'] }}">
                </td>
            </tr>
            <tr class="confirm-table__row">
                <th class="confirm-table__header">メールアドレス</th>
                <td class="confirm-table__text">
                    {{ $contact['email'] }}
                    <input type="hidden" name="email" value="{{ $contact['email'] }}" />
                </td>
            </tr>
            <tr class="confirm-table__row">
                <th class="confirm-table__header">電話番号</th>
                <td class="confirm-table__text">
                    {{ $contact['tel'] }}
                    <input type="hidden" name="tel" value="{{ $contact['tel'] }}" />
                </td>
            </tr>
            <tr class="confirm-table__row">
                <th class="confirm-table__header">住所</th>
                <td class="confirm-table__text">
                    {{ $contact['address'] }}
                    <input type="hidden" name="address" value="{{ $contact['address'] }}" />
                </td>
            </tr>
            <tr class="confirm-table__row">
                <th class="confirm-table__header">建物名</th>
                <td class="confirm-table__text">
                    {{ $contact['building'] }}
                    <input type="hidden" name="building" value="{{ $contact['building'] }}" />
                </td>
            </tr>
            <tr class="confirm-table__row">
                <th class="confirm-table__header">お問い合わせの種類</th>
                <td class="confirm-table__text">
                {{ $contact['category_content'] }}
                </td>
            </tr>
            <tr class="confirm-table__row">
                <th class="confirm-table__header">お問い合わせ内容</th>
                <td class="confirm-table__text">
                    {{ $contact['detail'] }}
                    <input type="hidden" name="detail" value="{{ $contact['detail'] }}">
                </td>
            </tr>
        </table>
    </div>
    <div class="form__button">
        <button class="form__button-submit" type="submit" name="action" value="submit">送信</button>
        <button class="form__button-back" type="submit" name="action" value="back" style="display: inline-block; background: none; border: none; color: rgba(139, 121, 105, 1); padding: 10px 20px; font-family: Inika; font-size: 20px; font-weight: 400;
    text-decoration: underline; cursor: pointer; white-space: nowrap;">修正</button>
    </div>
    </form>
</div>
@endsection
