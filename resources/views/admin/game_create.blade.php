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

                        Создать игру:

                        <form method="post" action="{{ route('game.store') }}" enctype="multipart/form-data">
                            <div class="form-group">
                                @csrf
                                <label for="name">Наименование игры:</label>
                                <input type="text" class="form-control" name="name"/>
                            </div>

                            <div class="form-group">
                                <label for="name">Дата проведения игры:</label>
                                <input type="date" class="form-control" name="date"/>
                            </div>

                            <div class="form-group">
                                <label for="name">Количество раундов:</label>
                                <input type="text" class="form-control" name="rounds"/>
                            </div>

                            <div class="form-group">
                                @foreach($teams as $team)
                                    <input type="checkbox" name="teams[]" value="{{$team->id}}">
                                    <label>{{ucfirst($team->name)}}</label>
                                    <br>
                                @endforeach
                            </div>

                            <button type="submit" class="btn btn-primary">Создать</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection