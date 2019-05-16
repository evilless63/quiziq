@extends('layouts.app')


@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <h1>Игры</h1>

                <a href="{{ route('game.create') }}" class="btn btn-primary">Создать игру</a>
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
                    <div class="card mt-2">
                        <div class="card-body">
                            <div class="row">
                                <div class="col" style="    border-right: 1px solid;">
                                    <h5 class="card-title">{{$game->name}} @if($game->is_over) - Завершена @endif</h5>
                                    <p class="card-text">Количество раундов: {{$game->rounds}}</p>
                                    <p class="card-text">Дата проведения игры: {{$game->date}}</p>
                                    <p class="card-text">Команды в игре:
                                        <br>
                                        <span>{{ $game->teams()->pluck('name')->implode(', ') }}</span>
                                    </p>

                                    <div class="row">
                                        @if($game->go_on)
                                        <div class="col">
                                            <a href="{{route('manage_game', $game->id)}}" class="btn btn-primary">Управление игрой</a>
                                        </div>
                                        @else
                                        <div class="col">
                                            <a href="{{route('game.edit', $game->id)}}" class="btn btn-primary">Редактировать</a>
                                        </div>
                                        <div class="col">
                                            <a href="{{route('start_game', $game->id)}}" class="btn btn-primary">Запустить игру</a>
                                        </div> 
                                        <div class="col">
                                            <form method="post" action="{{route('game.destroy', $game->id)}}">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="btn btn-danger">Удалить</button>
                                            </form>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col">
                                    <p>Комментарий к игре: <strong>{{$game->comment}}</strong></p>
                                    <form method="post" action="{{route('add_comment_game', $game->id)}}">
                                        @csrf
                                        <div class="form-group">
                                            <textarea name="comment" id="" cols="30" class="form-control" rows="3"></textarea>
                                        </div>

                                        <button type="submit" class="btn btn-primary">Новый комментарий</button>
                                    </form>       
                                </div>
                            </div>

                            
                            
                            
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection