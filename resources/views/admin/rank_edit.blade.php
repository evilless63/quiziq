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

                    Редактировать ранг:

                    <form method="post" action="{{ route('rank.update', $rank->id) }}" enctype="multipart/form-data">
                        <div class="form-group">
                            @csrf
                            @method('PATCH')
                            <label for="name">Наименование ранга:</label>
                            <input type="text" class="form-control" name="name" value="{{ $rank->name }}"/>
                        </div>

                        <div class="form-group">
                            <label for="name">Минимальное количество балов для достижения ранга:</label>
                            <input type="text" class="form-control" name="min_score" value="{{ $rank->min_score }}"/>
                        </div>

                        <div class="form-group">
                            <label for="name">Изображение:</label>
                            <input type="file" class="form-control" name="image_path"/>
                        </div>

                        @if(isset($rank->image_path))
                        <div class="form-group">
                            <div class="text-center">
                                <img src="{{ asset('/storage/' .$rank->image_path)}}" class="rounded img-thumbnail float-left" alt="{{ $rank->name }}">
                            </div>
                        </div>
                        @endif

                        <button type="submit" class="btn btn-primary">Редактировать</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection