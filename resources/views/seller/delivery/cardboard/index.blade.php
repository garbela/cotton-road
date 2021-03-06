@extends('layouts.base')

@section('content')
    <div class="container">
        <h1 class="h1">ダンボール一覧</h1>

        <ul class="nav nav-tabs mb-4">
            <li class="nav-item">
                <a href="#wait" class="nav-link active" data-toggle="tab">ダンボール配送待ち</a>
            </li>
            <li class="nav-item">
                <a href="#done" class="nav-link" data-toggle="tab">ダンボール配送済み</a>
            </li>
        </ul>

        <div class="tab-content">
            <div id="wait" class="tab-pane active">
                <div>
                    @if (count($waitCardboards) === 0)
                        <p>該当レコードが見つかりませんでした。</p>
                    @else
                        <table class="table table-striped">
                            <tr>
                                <th>サイズ</th>
                                <th>箱数</th>
                                <th>注文日</th>
                            </tr>
                            @foreach ($waitCardboards as $cardboard)
                                <tr>
                                    <td>{{ $cardboard->cardboard->size }}</td>
                                    <td>{{ $cardboard->number }}</td>
                                    <td>{{ $cardboard->created_at }}</td>
                                </tr>
                            @endforeach
                        </table>
                        {{ $waitCardboards->links() }}
                    @endif
                </div>
            </div>

            <div id="done" class="tab-pane">
                <div>
                    @if (count($doneCardboards) === 0)
                        <p>該当レコードが見つかりませんでした。</p>
                    @else
                        <table class="table table-striped">
                            <tr>
                                <th>サイズ</th>
                                <th>箱数</th>
                                <th>注文日</th>
                                <th>配送日</th>
                            </tr>
                            @foreach ($doneCardboards as $cardboard)
                                <tr>
                                    <td>{{ $cardboard->cardboard->size }}</td>
                                    <td>{{ $cardboard->number }}</td>
                                    <td>{{ $cardboard->created_at }}</td>
                                    <td>{{ $cardboard->updated_at }}</td>
                                </tr>
                            @endforeach
                        </table>
                        {{ $doneCardboards->links() }}
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection