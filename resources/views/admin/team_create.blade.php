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

                        Создать команду:

                        <form method="post" action="{{ route('team.store') }}">
                            <div class="form-group">
                                @csrf
                                <label for="name">Наименование:</label>
                                <input type="text" class="form-control" name="name"/>
                            </div>

                            <button type="submit" class="btn btn-primary">Создать</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection