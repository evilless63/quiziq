@extends('layouts.app')


@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <h1>Игры</h1>

                <a href="{{ route('rank.create') }}" class="btn btn-primary">Создать игру</a>
            </div>
            <div class="col-md-12">

                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <strong>Внимание !</strong> Есть ошибки при заполнении формы.<br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                @foreach($games as $game)
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{$game->name}}</h5>
                            <p class="card-text">{{$game->rounds}}</p>
                            <p class="card-text">{{$game->date}}</p>
                            <form method="post" action="{{route('game.destroy', $game->id)}}">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-danger">Удалить</button>
                            </form>
                            <a href="{{route('game.edit', $game->id)}}" class="btn btn-primary">Редактировать</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection