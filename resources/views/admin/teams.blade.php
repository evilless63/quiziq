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

                            <a href="{{ route('team.create') }}" class="btn btn-primary">Создать команду</a>


                        Команды:

                        @foreach($teams as $team)
                                <p>{{$team->name}}
                                <form method="post" action="{{route('team.destroy', $team->id)}}">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn btn-danger">Удалить</button>
                                </form>
                                <a href="{{route('team.edit', $team->id)}}" class="btn btn-primary">Редактировать</a>
                                </p>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection