@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        Проведение игры

                        <form method="post" action="{{ route('game.update', $game->id) }}">
                            <div class="form-group">
                                @csrf
                                @method('PATCH')
                            </div>

                            <div class="row">
                                <div class="col"><p>Наименование: <strong>{{ $game->name }}</strong></p></div>
                                <div class="col"><p>Дата проведения: <strong>{{ $game->date }}</strong></p></div>
                                <div class="col"><p>Количество раундов: <strong>{{ $game->rounds }}</strong></p></div>
                            </div>


                            <table class="table table-borderless">
                                <thead>
                                    <tr>
                                        <th scope="col" class="th_header">Место</th>
                                        <th scope="col" class="th_header">Команда</th>
                                        <!-- Раунды -->
                                        @for ($round = 1; $round <= $game->rounds; $round++)
                                            <th scope="col round" class=""> <span class="round_text_background">{{$round}}</span> </th>
                                        @endfor
                                        <!-- Итоги -->
                                        <th scope="col"> <span class="th_result">Итог</span> </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($game->teams()->get() as $key=>$team)
                                    <tr tabindex="{{count($game->teams()->get()->toArray()) - ($key + 1)}}">
                                        <td class="game_number">1</td>
                                        <td class="command_name">{{$team->name}}</td>
                                        @for ($round = 1; $round <= $game->rounds; $round++)
                                            <td class="color_rgba"> <input type="text" class="form-control" value="0"/> </td>
                                        @endfor
                                        <td class="color_rgba_result"> <span class="td_result">36</span> </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <button type="submit" class="btn btn-primary">Сохранить состояние игры</button>
                            <a href="{{route('show_game_client', $game->id)}}" class="btn btn-primary">Клиентская часть</a>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
