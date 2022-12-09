@extends('layouts.main')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card mt-lg-4">
                    <div class="card-body">
                        Ошибка доступа к базе данных.
                    </div>
                </div>

                <div class="card mt-lg-4">
                    <div class="card-body">

                        <div class="mb-0 row">
                            <label for="title" class="col-sm-4 col-form-label pt-0 pb-0">
                                <i class="bi bi-server mr-2" style="color: orange; font-size: 25px;"></i>
                            </label>
                            <div for="title" class="col-sm-8 col-form-label pt-2">
                                <strong>{{$dataBase->title}}</strong>
                            </div>
                        </div>

                        <hr class="mt-1">

                        <form method="post" action="{{route('db.update', $dataBase)}}">
                            @csrf
                            @method('put')
                            <div class="mb-1 row">
                                <label for="title" class="col-sm-4 col-form-label">Title:</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control form-control-sm" id="title" name="title"
                                           value="{{$dataBase->title}}">
                                </div>
                            </div>
                            <div class="mb-1 row">
                                <label for="key" class="col-sm-4 col-form-label">Key:</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control form-control-sm" id="key" name="key"
                                           value="{{$dataBase->key}}">
                                </div>
                            </div>
                            <div class="mb-1 row">
                                <label for="driver" class="col-sm-4 col-form-label">Driver:</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control form-control-sm"
                                           id="driver" name="driver" readonly
                                           value="{{$dataBase->driver}}">
                                </div>
                            </div>
                            <div class="mb-1 row">
                                <label for="host" class="col-sm-4 col-form-label">Host:</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control form-control-sm" id="host" name="host"
                                           value="{{$dataBase->host}}">
                                </div>
                            </div>
                            <div class="mb-1 row">
                                <label for="port" class="col-sm-4 col-form-label">Port:</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control form-control-sm" id="port" name="port"
                                           value="{{$dataBase->port}}">
                                </div>
                            </div>
                            <div class="mb-1 row">
                                <label for="database" class="col-sm-4 col-form-label">Database:</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control form-control-sm" id="database"
                                           name="database"
                                           value="{{$dataBase->database}}">
                                </div>
                            </div>
                            <div class="mb-1 row">
                                <label for="username" class="col-sm-4 col-form-label">Username:</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control form-control-sm" id="staticEmail"
                                           name="username"
                                           value="{{$dataBase->username}}">
                                </div>
                            </div>
                            <div class="mb-1 row">
                                <label for="password" class="col-sm-4 col-form-label">Password:</label>
                                <div class="col-sm-8">
                                    <input type="password" class="form-control form-control-sm" id="password"
                                           name="password"
                                           value="{{$dataBase->password}}">
                                </div>
                            </div>
                            <div class="mb-1 row">
                                <label for="charset" class="col-sm-4 col-form-label">Charset:</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control form-control-sm" id="charset" name="charset"
                                           value="{{$dataBase->charset}}">
                                </div>
                            </div>
                            <div class="mb-1 row">
                                <label for="schema" class="col-sm-4 col-form-label">Schema:</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control form-control-sm" id="schema" name="schema"
                                           value="{{$dataBase->schema}}">
                                </div>
                            </div>
{{--                            <div class="mb-1 row">--}}
{{--                                <label for="prefix" class="col-sm-4 col-form-label">Prefix:</label>--}}
{{--                                <div class="col-sm-8">--}}
{{--                                    <input type="text" class="form-control form-control-sm" id="prefix" name="prefix"--}}
{{--                                           value="{{$dataBase->prefix}}">--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="mb-1 row">--}}
{{--                                <label for="prefix_indexes" class="col-sm-4 col-form-label">Prf_indexes:</label>--}}
{{--                                <div class="col-sm-8">--}}
{{--                                    <input type="text" class="form-control form-control-sm" id="prefix_indexes"--}}
{{--                                           name="prefix_indexes"--}}
{{--                                           value="{{$dataBase->prefix_indexes}}">--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="mb-3 row">--}}
{{--                                <label for="sslmode" class="col-sm-4 col-form-label">Sslmode:</label>--}}
{{--                                <div class="col-sm-8">--}}
{{--                                    <input type="text" class="form-control form-control-sm" id="sslmode" name="sslmode"--}}
{{--                                           value="{{$dataBase->sslmode}}">--}}
{{--                                </div>--}}
{{--                            </div>--}}
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control form-control-sm" id="description" maxlength="2048"
                                          name="description" rows="5">{{$dataBase->description}}</textarea>
                            </div>

                            <div class="mb-3 row">
                                <div class="col-sm-4 pr-0">
                                    <button type="button"
                                            class="btn btn-danger form-control text-white" data-toggle="modal"
                                            data-target="#destroyProjectModal">
                                        <i class="bi bi-trash mr-2"></i>Удалить
                                    </button>
                                </div>
                                <div class="col-sm-8">
                                    <button type="submit" class="form-control btn btn-info text-white">Сохранить
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
