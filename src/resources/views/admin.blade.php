@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
<link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
<link rel="stylesheet" href="{{ asset('css/modal.css') }}">
@endsection

@section('showLoginButton')
<a href="{{ route('logout') }}" class="header__logout-button">logout</a>
@endsection

@section('content')
<div class="admin-content">
    <header class="admin-header">
            Admin
    </header>

    <div class="admin-search">
        <form method="GET" action="{{ route('admin.search') }}">{{-- @csrf は不要（GETリクエストにはCSRFトークン不要） --}}
            <input type="text" name="query" placeholder="名前やメールアドレスを入力してください">
            <select name="gender">
                {{-- ラベルとしての「性別」（選択不可） --}}
                <option value="" disabled {{ request('gender') === null ? 'selected' : '' }}>性別</option>
                {{-- 「全て」を選択肢として明示的に表示 --}}
                <option value="" {{ request('gender') === '' ? 'selected' : '' }}>全て</option>
                {{-- 各性別の選択肢 --}}
                <option value="1" {{ request('gender') == '1' ? 'selected' : '' }}>男性</option>
                <option value="2" {{ request('gender') == '2' ? 'selected' : '' }}>女性</option>
                <option value="3" {{ request('gender') == '3' ? 'selected' : '' }}>その他</option>
            </select>
            <select name="category_id">
                <option value="">お問い合わせの種類</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->content }}</option>
                @endforeach
            </select>
            <input type="date" name="date">
            <button type="submit" class="btn btn-search">検索</button>
            {{-- リセットボタンをtype="submit"でGETパラメータ無しのフォームにするのが王道 --}}
            <a href="{{ route('admin.search') }}" class="btn btn-reset">リセット</a>
        </form>
    </div>

    <div class="admin-actions">
        <form action="{{ route('admin.export') }}" method="GET">
            <input type="hidden" name="query" value="{{ request('query') }}">
            <input type="hidden" name="gender" value="{{ request('gender') }}">
            <input type="hidden" name="category_id" value="{{ request('category_id') }}">
            <input type="hidden" name="date" value="{{ request('date') }}">

            <button class="btn btn-export">エクスポート</button>
        </form>

        <div class="pagination-container">
        {{ $contacts->links() }}
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
                    <td>{{ $contact->last_name }} {{ $contact->first_name }}</td>
                    <td>
                        @if ($contact->gender == 1) 男性
                        @elseif ($contact->gender == 2) 女性
                        @else その他
                        @endif
                    </td>
                    <td>{{ $contact->email }}</td>
                    <td>{{ $contact->category->content }}</td>
                    <td>
                        <!-- 詳細ボタン -->
                        <button class="btn btn-detail" data-id="{{ $contact->id }}">詳細</button>

                        <!-- モーダル -->
                        <div class="modal" id="modal-{{ $contact->id }}">
                            <div class="modal-content">
                                <span class="modal-close" data-id="{{ $contact->id }}">&times;</span>
                                    <p><strong>お名前</strong><span>{{ $contact->last_name }} {{ $contact->first_name }}</span></p>
                                    <p><strong>性別</strong><span>@if ($contact->gender == 1) 男性 @elseif ($contact->gender == 2) 女性 @else その他 @endif</span></p>
                                    <p><strong>メールアドレス</strong><span>{{ $contact->email }}</span></p>
                                    <p><strong>電話番号</strong><span>{{ $contact->tel }}</span></p>
                                    <p><strong>住所</strong><span>{{ $contact->address }}</span></p>
                                    <p><strong>建物名</strong><span>{{ $contact->building }}</span></p>
                                    <p><strong>お問い合わせの種類</strong><span>{{ $contact->category->content }}</span></p>
                                    <p><strong>お問い合わせ内容</strong><span>{{ $contact->content }}</span></p>

                                <form method="POST" action="{{ route('admin.delete', ['id' => $contact->id]) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-delete">削除</button>
                                </form>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // 詳細ボタンでモーダル表示
        document.querySelectorAll('.btn-detail').forEach(button => {
            button.addEventListener('click', function () {
                const id = this.getAttribute('data-id');
                document.getElementById(`modal-${id}`).style.display = 'block';
            });
        });

        // 閉じるボタンでモーダル非表示
        document.querySelectorAll('.modal-close').forEach(closeBtn => {
            closeBtn.addEventListener('click', function () {
                const id = this.getAttribute('data-id');
                document.getElementById(`modal-${id}`).style.display = 'none';
            });
        });

        // モーダル外クリックで閉じる
        window.addEventListener('click', function (e) {
            document.querySelectorAll('.modal').forEach(modal => {
                if (e.target === modal) modal.style.display = 'none';
            });
        });
    });
</script>
@endpush
