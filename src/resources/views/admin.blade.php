@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
<link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
@endsection

@section('showLogoutButton')
<a href="{{ route('logout') }}" class="header__logout-button">logout</a>
@endsection

@section('content')
<div class="admin-content">
    <header class="admin-header">
            Admin
    </header>

    <div class="admin-search">
        <form method="POST" action="{{ route('admin.search') }}">
            @csrf
            <input type="text" name="query" placeholder="名前やメールアドレスを入力してください">
            <select name="gender">
                <option value="">性別</option>
                <option value="1">男性</option>
                <option value="2">女性</option>
                <option value="3">その他</option>
            </select>
            <select name="category_id">
                <option value="">お問い合わせの種類</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->content }}</option>
                @endforeach
            </select>
            <input type="date" name="date">
            <button type="submit" class="btn btn-search">検索</button>
            <button type="reset" class="btn btn-reset">リセット</button>
        </form>
    </div>

    <div class="admin-actions">
        <button class="btn btn-export">エクスポート</button>
        <div class="pagination-container">
        <{{ $contacts->links() }}
        </div>
    </div>

    <div class="admin-table">
        <table>
            <thead>
                <tr>
                    <th>お名前</th>
                    <th>性別</th>
                    <th>メールアドレス</th>
                    <th>お問い合わせの種類</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($contacts as $contact)
                <tr>
                    <td>{{ $contact->first_name }} {{ $contact->last_name }}</td>
                    <td>
                        @if ($contact->gender == 1) 男性
                        @elseif ($contact->gender == 2) 女性
                        @else その他
                        @endif
                    </td>
                    <td>{{ $contact->email }}</td>
                    <td>{{ $contact->category->content }}</td>
                    <td><button class="btn btn-detail">詳細</button></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection