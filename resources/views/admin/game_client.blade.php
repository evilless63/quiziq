@extends('layouts.client')

@section('content')

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
                    <td class="color_rgba"> 11 </td>
                @endfor
                <td class="color_rgba_result"> <span class="td_result">36</span> </td>
            </tr>
            @endforeach
        </tbody>
    </table>

@endsection
