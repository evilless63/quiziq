@extends('layouts.app')


@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <h1>Команды</h1>

                <a href="{{ route('team.create') }}" class="btn btn-primary">Создать команду</a>
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

                @foreach($teams as $team)
                    <div class="card mt-2">
                        <div class="card-body">
                            <h5 class="card-title">{{$team->name}}</h5>
                            <div class="row">
                                <div class="col">
                                    <a href="{{route('team.edit', $team->id)}}" class="btn btn-primary">Редактировать</a>
                                </div>
                                <div class="col">
                                    <form method="post" action="{{route('team.destroy', $team->id)}}">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-danger">Удалить</button>
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