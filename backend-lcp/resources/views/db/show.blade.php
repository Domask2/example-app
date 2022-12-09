@extends('layouts.main')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-4">
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

            <form method="post" action="{{route('db.destroy', $dataBase)}}" name="destroyForm">
            @csrf
            @method('delete')
            <!-- Modal -->
                <div class="modal fade modal" id="destroyProjectModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                     aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Удаление базы данных</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                Проект будет удален безвозвратно.<br>
                                Подтвердите удаление или отмените действие.
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Отменить</button>
                                <button type="submit" class="btn btn-danger"><i class="bi bi-trash mr-2"></i>Удалить
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <div class="col-md-8 mt-lg-4">
                <div class="card mb-4">
                    <div class="card-body">
                        <table class="table table-hover table-sm m-0">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Title</th>
                                <th scope="col">Key</th>
                                <th scope="col">Type</th>
                                <th scope="col">CRUD</th>
                                <th scope="col"></th>
                                <th scope="col"></th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($dataBase->dataSources as $item)
                                <tr>
                                    <th scope="row" style="width: 40px">{{$loop->index + 1}}</th>
                                    <td>
                                        @if($item->type === 'BASE TABLE')
                                            <i class="bi bi-table mr-2" style="color: dodgerblue"></i>
                                        @elseif($item->type === 'VIEW')
                                            <i class="bi bi-front mr-2" style="color: forestgreen"></i>
                                        @elseif($item->type === 'PROCEDURE')
                                            <i class="bi bi-gear-fill mr-2" title="Procedure"
                                               style="color: blueviolet"></i>
                                        @elseif($item->type === 'FUNCTION')
                                            <i class="bi bi-gear-fill mr-2" title="Function"
                                               style="color: deeppink"></i>
                                        @endif
                                        <a href="{{route('ds.show', $item)}}">{{$item->title}}</a>
                                    </td>
                                    <td>{{$item->key}}</td>
                                    <td>{{$item->type}}</td>
                                    <td>{{$item->crud}}</td>
                                    <td style="width: 30px">
                                        <a target="_blank"
                                           href="{{route('mc.index', ['db_key' => $dataBase->key, 'ds_key' => $item->key])}}">
                                            <i class="bi bi-link" style="font-size: 17px" title="ссылка"></i>
                                        </a>
                                    </td>
                                    <td style="width: 30px">
                                        <form method="POST"
                                              action="{{route('ds.destroy', $item->id)}}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-link p-0">
                                                <i class="bi bi-chevron-down" style="font-size: 17px"
                                                   title="отключить"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-4 offset-md-4">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-hover table-sm m-0">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Table name (Key)</th>
                                <th scope="col">Type</th>
                                <th scope="col"></th>
                            </tr>
                            </thead>
                            <tbody>

                            @php $i = 0 @endphp
                            @foreach($tables as $item)
                                @php
                                    $flg = true
                                @endphp
                                @foreach($dataBase->dataSources as $ds)
                                    @if($item->table_name == $ds->key)
                                        @php
                                            $flg = false
                                        @endphp
                                    @endif
                                @endforeach

                                @if($flg)
                                    @php $i++ @endphp
                                    <tr>
                                        <th scope="row" style="width: 40px">{{$i}}</th>
                                        <td>
                                            @if($item->table_type === 'BASE TABLE')
                                                <i class="bi bi-table mr-2" style="color: dodgerblue"></i>
                                            @elseif($item->table_type === 'VIEW')
                                                <i class="bi bi-front mr-2" style="color: forestgreen"></i>
                                            @else
                                                <i class="bi bi-question-diamond-fill mr-2" style="color: orange"></i>
                                            @endif
                                            {{$item->table_name}}
                                        </td>
                                        <td>{{$item->table_type}}</td>
                                        <td style="width: 30px">
                                            <form method="POST"
                                                  action="{{route('ds.store')}}">
                                                @csrf
                                                <input type="hidden" name="data_base_id" value="{{$dataBase->id}}">
                                                <input type="hidden" name="table_name" value="{{$item->table_name}}">
                                                <input type="hidden" name="table_type" value="{{$item->table_type}}">
                                                <button type="submit" class="btn btn-link p-0">
                                                    <i class="bi bi-chevron-up" style="font-size: 17px"
                                                       title="подключить"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-hover table-sm m-0">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Routine name (Key)</th>
                                <th scope="col">Type</th>
                                <th scope="col"></th>
                            </tr>
                            </thead>
                            <tbody>

                            @php $i = 0 @endphp
                            @foreach($routines as $item)
                                @php
                                    $flg = true
                                @endphp
                                @foreach($dataBase->dataSources as $ds)
                                    @if($item->routine_name == $ds->key)
                                        @php
                                            $flg = false
                                        @endphp
                                    @endif
                                @endforeach

                                @if($flg)
                                    @php $i++ @endphp
                                    <tr>
                                        <th scope="row" style="width: 40px">{{$i}}</th>
                                        <td>
                                            @if($item->routine_type === 'PROCEDURE')
                                                <i class="bi bi-gear-fill mr-2" title="Procedure"
                                                   style="color: blueviolet"></i>
                                            @elseif($item->routine_type === 'FUNCTION')
                                                <i class="bi bi-gear-fill mr-2" title="Function"
                                                   style="color: deeppink"></i>
                                            @else
                                                <i class="bi bi-question-diamond-fill mr-2" style="color: orange"></i>
                                            @endif
                                            {{$item->routine_name}}
                                        </td>
                                        <td>{{$item->table_type}}</td>
                                        <td style="width: 30px">
                                            <form method="POST"
                                                  action="{{route('ds.store')}}">
                                                @csrf
                                                <input type="hidden" name="data_base_id" value="{{$dataBase->id}}">
                                                <input type="hidden" name="table_name" value="{{$item->routine_name}}">
                                                <input type="hidden" name="table_type" value="{{$item->routine_type}}">
                                                <button type="submit" class="btn btn-link p-0">
                                                    <i class="bi bi-chevron-up" style="font-size: 17px"
                                                       title="подключить"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
