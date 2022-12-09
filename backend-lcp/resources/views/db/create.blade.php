@extends('layouts.main')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card mt-lg-4">
                <div class="card-header bg-info text-white">Новая база данных</div>
                <div class="card-body">
                    <form method="post" action="{{route('db.store')}}">
                        @csrf
                        <div class="mb-1 row">
                            <label for="title" class="col-sm-4 col-form-label">Title:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control form-control-sm" id="title" name="title">
                            </div>
                        </div>
                        <div class="mb-1 row">
                            <label for="key" class="col-sm-4 col-form-label">Key:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control form-control-sm" id="key" name="key">
                            </div>
                        </div>
                        <div class="mb-1 row">
                            <label for="driver" class="col-sm-4 col-form-label">Driver:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control form-control-sm"
                                       value="pgsql"
                                       readonly name="driver">
                            </div>
                        </div>
                        <div class="mb-1 row">
                            <label for="host" class="col-sm-4 col-form-label">Host:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control form-control-sm" id="host" name="host">
                            </div>
                        </div>
                        <div class="mb-1 row">
                            <label for="port" class="col-sm-4 col-form-label">Port:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control form-control-sm" id="port" name="port">
                            </div>
                        </div>
                        <div class="mb-1 row">
                            <label for="database" class="col-sm-4 col-form-label">Database:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control form-control-sm" id="database"
                                       name="database">
                            </div>
                        </div>
                        <div class="mb-1 row">
                            <label for="username" class="col-sm-4 col-form-label">Username:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control form-control-sm" id="staticEmail"
                                       name="username">
                            </div>
                        </div>
                        <div class="mb-1 row">
                            <label for="password" class="col-sm-4 col-form-label">Password:</label>
                            <div class="col-sm-8">
                                <input type="password" class="form-control form-control-sm" id="password"
                                       name="password">
                            </div>
                        </div>
                        <div class="mb-1 row">
                            <label for="charset" class="col-sm-4 col-form-label">Charset:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control form-control-sm" id="charset" name="charset">
                            </div>
                        </div>
                        <div class="mb-1 row">
                            <label for="schema" class="col-sm-4 col-form-label">Schema:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control form-control-sm" id="schema" name="schema">
                            </div>
                        </div>
{{--                        <div class="mb-1 row">--}}
{{--                            <label for="prefix" class="col-sm-4 col-form-label">Prefix:</label>--}}
{{--                            <div class="col-sm-8">--}}
{{--                                <input type="text" class="form-control form-control-sm" id="prefix" name="prefix">--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="mb-1 row">--}}
{{--                            <label for="prefix_indexes" class="col-sm-4 col-form-label">Prf_indexes:</label>--}}
{{--                            <div class="col-sm-8">--}}
{{--                                <div class="form-check form-switch">--}}
{{--                                    <input class="form-check-input" type="checkbox"--}}
{{--                                           name="prefix_indexes" id="prefix_indexes"--}}
{{--                                           id="flexSwitchCheckChecked">--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="mb-3 row">--}}
{{--                            <label for="sslmode" class="col-sm-4 col-form-label">Sslmode:</label>--}}
{{--                            <div class="col-sm-8">--}}
{{--                                <input type="text" class="form-control form-control-sm" id="sslmode" name="sslmode">--}}
{{--                            </div>--}}
{{--                        </div>--}}
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control form-control-sm" id="description" maxlength="2048"
                                      name="description" rows="5"></textarea>
                        </div>
                        <div class="mb-3 row">
                            <div class="col-sm-12">
                                <button type="submit" class="form-control btn btn-info btn-sm text-white">Сохранить
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
