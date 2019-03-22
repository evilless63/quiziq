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

                        Редактировать команду:

                        <form method="post" action="{{ route('team.update', $team->id) }}">
                            @csrf
                            @method('PATCH')
                            <div class="form-group">

                                <label for="name">Наименование:</label>
                                <input type="text" class="form-control" name="name" value="{{ $team->name }}"/>
                            </div>

                            <button type="submit" class="btn btn-primary">Редактировать</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection