@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    Редактировать игру:

                    <form method="post" action="{{ route('game.update', $game->id) }}">
                        <div class="form-group">
                            @csrf
                            @method('PATCH')
                            <label for="name">Наименование игры:</label>
                            <input type="text" class="form-control" name="name" value="{{ $game->name }}" />
                        </div>

                        <div class="form-group">
                            <label for="date">Дата проведения игры:</label>
                            <input type="date" class="form-control" name="date" value="{{ $game->date }}" />
                        </div>

                        <div class="form-group">
                            <label for="rounds">Количество раундов:</label>
                            <input type="text" class="form-control" name="rounds" value="{{ $game->rounds }}" />
                        </div>

                        <div class="form-group">

                            <input type="text" id="searchTeams" class="form-control" placeholder="Подбор команд">

                            <ul id="searchForm" class="list-group">
                                @foreach($teams as $team)

                                <li class="list-group-item">
                                    <input type="checkbox" name="teams[]" value="{{$team->id}}"
                                        @if($game->teams->where('id', $team->id)->count())
                                        checked="checked"
                                        @endif
                                    >
                                    <a href="">{{ucfirst($team->name)}}</a>
                                </li>

                                @endforeach
                            </ul>

                        </div>


                        <button type="submit" class="btn btn-primary">Редактировать</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection