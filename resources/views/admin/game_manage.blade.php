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
                                <div class="col"><input type="checkbox" name="use_alter_range" id="use_alter_range" value="0" @if($game->use_alter_range == "1") checked @endif ><label for="use_alter_range">Использовать ручное ранжирование</label></div>
                            </div>

                            <div id="game_id" game_id="{{$game->id}}"></div>


                            <table class="table table-borderless">
                                <thead>
                                    <tr>
                                        <th scope="col" class="th_header">Место</th>
                                        <th scope="col" class="th_header">Команда</th>
                                        <!-- Раунды -->
                                        @for ($round = 1; $round <= $game->rounds; $round++)
                                            <th scope="col round" class=""> <span class="round_text_background">Раунд {{$round}}</span> </th>
                                        @endfor
                                        <!-- Итоги -->
                                        <th scope="col"> <span class="th_result">Итог</span> </th>
                                        <th scope="col"> <span class="th_result">руч. Ранжирование</span> </th>
                                    </tr>
                                </thead>
                                <tbody> 
                                    @if($game->use_alter_range == "1")
                                        @php $coll = $game->totalscores()->orderBy('current_game_position', 'asc')->get() @endphp
                                    @else
                                        @php $coll = $game->totalscores()->orderBy('totalscore', 'desc')->get() @endphp
                                    @endif

                                    @foreach($coll as $key=>$totalscore)
                                    <tr tabindex="{{count($game->teams()->get()->toArray()) - ($key + 1)}}">
                                        <td class="game_number">{{$key + 1}}</td>
                                        <td final_team_id="{{$game->teams->where('id', $totalscore->team_id)->first()->id}}" class="command_name final_team_id">{{$game->teams->where('id', $totalscore->team_id)->first()->name}}</td>
                                        @php ($round_number = 0)
                                        @foreach($game->rounds()->get() as $k=>$round)
                                            @if($round->team_id == $game->teams->where('id', $totalscore->team_id)->first()->id)
                                            @php ($round_number = $round_number + 1)
                                            <td request='true' class="color_rgba">
                                                <input type="text" class="form-control" team_id="{{$game->teams->where('id', $totalscore->team_id)->first()->id}}" round_id="{{$round->id}}" current_game_position="{{ $totalscore->current_game_position }}" name="round_{{$round->id}}_team_{{$game->teams->where('id', $totalscore->team_id)->first()->id}}" round_number = "{{$round->number}}" value="{{ $round->score }}"/> 
                                                <input type="hidden" class="form-control" team_id="{{$game->teams->where('id', $totalscore->team_id)->first()->id}}" round_id="{{$round->id}}" current_game_position="{{ $totalscore->current_game_position }}" name="round_{{$round->id}}_team_{{$game->teams->where('id', $totalscore->team_id)->first()->id}}"  value="0"/>
                                            </td>
                                            @endif
                                        @endforeach
                                        <td class="color_rgba_result"> <span class="td_result">{{$totalscore->totalscore}}</span> </td>
                                        <td  class="color_rgba_result current_game_position"> <input alter-range='true' type="text" class="form-control" team_id="{{$totalscore->team_id}}" current_game_position="{{ $totalscore->current_game_position }}" name="current_game_position" value="{{ $totalscore->current_game_position }}"/> </td>
                                    </tr>
                                    @endforeach
                                   
                                </tbody>
                            </table>

                            <button type="submit" class="btn btn-primary" id="update_game">Сохранить состояние игры</button>
                            <a href="{{route('show_game_client', $game->id)}}" class="btn btn-success">Клиентская часть</a>
                            <button type="submit" class="btn btn-danger" id="end_game">Завершить игру</button>                            
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
