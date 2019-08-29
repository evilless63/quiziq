@extends('layouts.client')

@section('content')

    <table class="table table-borderless">
        <thead>
            <tr>
                <th scope="col" class="th_header">М</th>
                <th scope="col" class="th_header">Р</th>
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
            @if($game->use_alter_range == "1")
                @php $coll = $game->totalscores()->orderBy('current_game_position', 'asc')->get() @endphp
            @else
                @php $coll = $game->totalscores()->orderBy('totalscore', 'desc')->get() @endphp
            @endif
            @foreach($coll as $key=>$totalscore)
            <tr @if( $game->is_over) @else style="display: none" @endif tabindex="{{count($game->teams()->get()->toArray()) - ($key + 1)}}">
                <td class="game_number">{{$key + 1}}</td>
                @if(isset($game->teams->where('id', $totalscore->team_id)->first()->ranks()->first()->image_path))
                <td><img src="{{ asset('/storage/' .$game->teams->where('id', $totalscore->team_id)->first()->ranks()->first()->image_path)}}" class="rounded" alt=""></td>
                @else
                <td>--</td>
                @endif
                <td class="command_name resizeble-font">{{$game->teams->where('id', $totalscore->team_id)->first()->name}}</td>               
                @foreach($game->rounds()->get() as $k=>$round)
                    @if($round->team_id == $game->teams->where('id', $totalscore->team_id)->first()->id)
                    <td class="color_rgba">{{$round->score}}</td>
                    @endif
                @endforeach
                <td class="color_rgba_result"> <span class="td_result">{{$totalscore->totalscore}}</span> </td>
            </tr>
            @endforeach
        </tbody>
    </table>

@endsection
