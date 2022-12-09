@extends('layouts.main')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card mt-lg-5">
                    <div class="card-body">
                        <form name="formNewProject" action="{{route('project.store')}}" method="POST">
                            @csrf
                            <div class="mb-3 row">
                                <label for="staticEmail" class="col-sm-3 col-form-label">Название</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control form-control-sm" id="staticEmail"
                                           name="title" value="{{$project->title}}" required>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="staticEmail" class="col-sm-3 col-form-label">Ключ</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control form-control-sm" id="key" name="key"
                                           value="{{$project->key}}" required>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="staticEmail" class="col-sm-3 col-form-label">Тип</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control-plaintext form-control-sm" name="type"
                                           readonly id="type" value="API">
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="inputDesc" class="col-sm-3 col-form-label">Описание</label>
                                <div class="col-sm-9">
                                    <textarea rows="3" id="inputDesc" class="form-control form-control-sm" name="description"></textarea>
                                </div>
                            </div>

                            <hr>

                            <div class="row justify-content-end">
                                <div class="col-sm-9">
                                    <button type="submit" class="btn btn-info form-control btn-sm text-white">Создать</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
