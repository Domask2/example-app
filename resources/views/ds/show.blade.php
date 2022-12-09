@extends('layouts.main')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-3">
                <div class="card mt-lg-4">
                    <div class="card-body">

                        <div class="mb-0 row">
                            <label for="title" class="col-sm-4 col-form-label pt-0"><strong>БД:</strong></label>
                            <div for="title" class="col-sm-8 col-form-label pt-0">
                                <strong>
                                    <a href="{{route('db.show', $dataSource->dataBase)}}">
                                        {{$dataSource->dataBase->title}}</a>
                                </strong>
                            </div>
                        </div>

                        <div class="mb-0 row">
                            <label for="title" class="col-sm-4 col-form-label pt-0 pb-0">
                                @if($dataSource->type === 'BASE TABLE')
                                    <i class="bi bi-table mr-2" style="color: dodgerblue; font-size: 25px;"></i>
                                @elseif($dataSource->type === 'VIEW')
                                    <i class="bi bi-front mr-2" style="color: forestgreen; font-size: 25px;"></i>
                                @endif
                            </label>
                            <div for="title" class="col-sm-8 col-form-label pt-2">
                                <strong>
                                    {{$dataSource->title}}
                                    &nbsp;&nbsp;
                                    <a target="_blank"
                                       href="{{route('mc.index', ['db_key' => $dataSource->dataBase->key, 'ds_key' => $dataSource->key])}}">
                                        get( )
                                    </a>
                                </strong>
                            </div>
                        </div>

                        <hr class="mt-1">

                        <form method="post" action="{{route('ds.update', $dataSource)}}">
                            @csrf
                            @method('put')
                            <input type="hidden" name="data_base_id" value="{{$dataSource->dataBase->id}}">
                            <div class="mb-1 row">
                                <label for="title" class="col-sm-4 col-form-label">Title:</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control form-control-sm" id="title" name="title"
                                           value="{{$dataSource->title}}">
                                </div>
                            </div>
                            <div class="mb-1 row">
                                <label for="key" class="col-sm-4 col-form-label">Key:</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control form-control-sm" id="key" name="key"
                                           value="{{$dataSource->key}}">
                                </div>
                            </div>
                            <div class="mb-1 row">
                                <label for="type" class="col-sm-4 col-form-label">Type:</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control form-control-sm"
                                           id="type" name="type" readonly
                                           value="{{$dataSource->type}}">
                                </div>
                            </div>
                            <div class="mb-1 row">
                                <label for="crud" class="col-sm-4 col-form-label">CRUD:</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control form-control-sm" id="crud" name="crud"
                                           value="{{$dataSource->crud}}">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control form-control-sm" id="description" maxlength="2048"
                                          name="description" rows="5">{{
    !empty($dataSource->description) ? $dataSource->description : $description}}</textarea>
                                @if(empty($dataSource->description) && !empty($description))
                                    <div style="text-align: center; color: red"><i>Надо сохранить</i></div>
                                @endif
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <button type="submit" class="form-control btn btn-info text-white">Сохранить
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card mt-lg-4">
                    <div class="card-body">

                        <table class="table table-borderless table-sm m-0">
                            @foreach($dataSource->dataSourceAccesses as $item)
                                <tr>
                                    <td>
                                        <div style="padding: 5px"><b>{{$item->role}}</b></div>
                                    </td>
                                    <td>
                                        <div style="padding: 5px">{{$item->source_name}}</div>
                                    </td>
                                    <td>
                                        <form method="post" action="{{route('dsa.destroy', $item)}}">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="form-control btn btn-link">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </table>

                        <hr class="mt-1">

                        <form method="post" action="{{route('dsa.store')}}">
                            @csrf
                            <div class="input-group mb-3">
                                <input type="hidden" class="form-control form-control-sm"
                                       id="data_source_id" name="data_source_id"
                                       value="{{$dataSource->id}}">
                                <input type="hidden" class="form-control form-control-sm"
                                       id="key" name="key"
                                       value="{{$dataSource->key}}">
                                <input type="text" class="form-control form-control-sm"
                                       id="role" name="role" placeholder="role">
                                <input type="text" class="form-control form-control-sm"
                                       id="source_name" name="source_name" placeholder="source_name"
                                       value="{{$dataSource->key}}">
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <button type="submit" class="form-control btn btn-info text-white">Сохранить
                                    </button>
                                </div>
                            </div>
                        </form>

                        <br>

                        <div class="alert alert-info mb-4 shadow" role="alert">
                            Если не указано, то доступ есть у всех, если указано, то доступ только у перечиселнных
                            ролей.
                        </div>

                    </div>
                </div>
            </div>


            <div class="col-md-9 mt-lg-4">
                @if($dataSource->type === 'BASE TABLE' || $dataSource->type === 'VIEW')
                    <div class="card mb-4">
                        <div class="card-body">
                            <table class="table table-hover table-sm m-0">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Key</th>
                                    <th scope="col">Type</th>
                                    <th scope="col">Visible</th>
                                    <th scope="col">PK</th>
                                    <th scope="col">Search</th>
                                    <th scope="col"></th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($dataSource->dataSourceFields as $item)

                                    <tr>
                                        <th scope="row" style="width: 40px">{{$loop->index + 1}}</th>
                                        <td>
                                            <form method="post" action="{{route('dsf.update', $item)}}">
                                                @csrf
                                                @method('put')
                                                <div class="input-group input-group-sm">
                                                    <input type="text" class="form-control" value="{{$item->title}}"
                                                           aria-label="Recipient's username"
                                                           name="title"
                                                           aria-describedby="button-addon2">
                                                    <input type="hidden" name="id" value="{{$item->id}}">
                                                    <div class="input-group-append">
                                                        <button class="btn btn-outline-secondary" type="submit"
                                                                id="button-addon2">OK
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </td>
                                        <td>{{$item->key}}</td>
                                        <td>{{$item->type}}</td>
                                        <td>
                                            <form method="post" action="{{route('dsf.update', $item)}}">
                                                @csrf
                                                @method('put')
                                                @if($item->visible == 1)
                                                    <input type="hidden" name="visible" value="0"/>
                                                    <button type="submit" class="btn btn-link p-0">
                                                        <i class="bi bi-check-circle-fill"></i>
                                                    </button>
                                                @else
                                                    <input type="hidden" name="visible" value="1"/>
                                                    <button type="submit" class="btn btn-link p-0">
                                                        <i class="bi bi-check-circle"></i>
                                                    </button>
                                                @endif
                                            </form>
                                        </td>
                                        <td>
                                            <form method="post" action="{{route('dsf.update', $item)}}">
                                                @csrf
                                                @method('put')
                                                @if($item->pk == 1)
                                                    <input type="hidden" name="pk" value="0"/>
                                                    <button type="submit" class="btn btn-link p-0">
                                                        <i class="bi bi-check-circle-fill"></i>
                                                    </button>
                                                @else
                                                    <input type="hidden" name="pk" value="1"/>
                                                    <button type="submit" class="btn btn-link p-0">
                                                        <i class="bi bi-check-circle"></i>
                                                    </button>
                                                @endif
                                            </form>
                                        </td>
                                        <td>
                                            <form method="post" action="{{route('dsf.update', $item)}}">
                                                @csrf
                                                @method('put')
                                                @if($item->search == 1)
                                                    <input type="hidden" name="search" value="0"/>
                                                    <button type="submit" class="btn btn-link p-0">
                                                        <i class="bi bi-check-circle-fill"></i>
                                                    </button>
                                                @else
                                                    <input type="hidden" name="search" value="1"/>
                                                    <button type="submit" class="btn btn-link p-0">
                                                        <i class="bi bi-check-circle"></i>
                                                    </button>
                                                @endif
                                            </form>
                                        </td>
                                        <td style="width: 30px">
                                            <form method="POST"
                                                  action="{{route('dsf.destroy', $item->id)}}">
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
                @endif

                @if($dataSource->type === 'BASE TABLE' || $dataSource->type === 'VIEW')
                    <div class="card mb-4">
                        <div class="card-body">
                            <table class="table table-hover table-sm m-0">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Column name (Key)</th>
                                    <th scope="col">Type</th>
                                    <th scope="col">
                                        <form method="POST"
                                              action="{{route('dsf.store')}}">
                                            @csrf

                                            <input type="hidden" name="title" value="-">
                                            <input type="hidden" name="key" value="-all-">
                                            <input type="hidden" name="dataIndex" value="-">
                                            <input type="hidden" name="visible" value="1">
                                            <input type="hidden" name="type" value="-">
                                            <input type="hidden" name="data_source_id" value="{{$dataSource->id}}">

                                            <button type="submit" class="btn btn-link p-0">
                                                <i class="bi bi-chevron-double-up" style="font-size: 17px"
                                                   title="подключить все"></i>
                                            </button>
                                        </form>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>

                                @php $i = 0 @endphp
                                @foreach($fields as $item)
                                    @php
                                        $flg = true
                                    @endphp
                                    @foreach($dataSource->dataSourceFields as $dsf)
                                        @if($item->column_name == $dsf->key)
                                            @php
                                                $flg = false
                                            @endphp
                                        @endif
                                    @endforeach

                                    @if($flg)
                                        @php $i++ @endphp
                                        <tr>
                                            <th scope="row" style="width: 40px">{{$i}}</th>
                                            <td>{{$item->column_name}}</td>
                                            <td>{{$item->data_type}}</td>
                                            <td style="width: 30px">
                                                <form method="POST"
                                                      action="{{route('dsf.store')}}">
                                                    @csrf
                                                    <input type="hidden" name="data_source_id"
                                                           value="{{$dataSource->id}}">
                                                    <input type="hidden" name="title" value="{{$item->column_name}}">
                                                    <input type="hidden" name="key" value="{{$item->column_name}}">
                                                    <input type="hidden" name="dataIndex"
                                                           value="{{$item->column_name}}">
                                                    <input type="hidden" name="visible" value="1">
                                                    <input type="hidden" name="type" value="{{$item->data_type}}">
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
                @endif


                @if($dataSource->type === 'PROCEDURE' || $dataSource->type === 'FUNCTION')
                    <div class="card mb-4">
                        <div class="card-body">
                            <table class="table table-hover table-sm m-0">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Key</th>
                                    <th scope="col">Type</th>
                                    <th scope="col">Visible</th>
                                    <th scope="col">PK</th>
                                    <th scope="col"></th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($dataSource->dataSourceFields as $item)

                                    <tr>
                                        <th scope="row" style="width: 40px">{{$loop->index + 1}}</th>
                                        <td>
                                            <form method="post" action="{{route('dsf.update', $item)}}">
                                                @csrf
                                                @method('put')
                                                <div class="input-group input-group-sm">
                                                    <input type="text" class="form-control" value="{{$item->title}}"
                                                           aria-label="Recipient's username"
                                                           name="title"
                                                           aria-describedby="button-addon2">
                                                    <input type="hidden" name="id" value="{{$item->id}}">
                                                    <div class="input-group-append">
                                                        <button class="btn btn-outline-secondary" type="submit"
                                                                id="button-addon2">OK
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </td>
                                        <td>{{$item->key}}</td>
                                        <td>{{$item->type}}</td>
                                        <td>
                                            <form method="post" action="{{route('dsf.update', $item)}}">
                                                @csrf
                                                @method('put')
                                                @if($item->visible == 1)
                                                    <input type="hidden" name="visible" value="0"/>
                                                    <button type="submit" class="btn btn-link p-0">
                                                        <i class="bi bi-check-circle-fill"></i>
                                                    </button>
                                                @else
                                                    <input type="hidden" name="visible" value="1"/>
                                                    <button type="submit" class="btn btn-link p-0">
                                                        <i class="bi bi-check-circle"></i>
                                                    </button>
                                                @endif
                                            </form>
                                        </td>
                                        <td>
                                            <form method="post" action="{{route('dsf.update', $item)}}">
                                                @csrf
                                                @method('put')
                                                @if($item->pk == 1)
                                                    <input type="hidden" name="pk" value="0"/>
                                                    <button type="submit" class="btn btn-link p-0">
                                                        <i class="bi bi-check-circle-fill"></i>
                                                    </button>
                                                @else
                                                    <input type="hidden" name="pk" value="1"/>
                                                    <button type="submit" class="btn btn-link p-0">
                                                        <i class="bi bi-check-circle"></i>
                                                    </button>
                                                @endif
                                            </form>
                                        </td>
                                        <td style="width: 30px">
                                            <form method="POST"
                                                  action="{{route('dsf.destroy', $item->id)}}">
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

                    <div class="card mb-4">
                        <div class="card-body">
                            <table class="table table-hover table-sm m-0">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Column name (Key)</th>
                                    <th scope="col">Type</th>
                                    <th scope="col">
{{--                                        <form method="POST"--}}
{{--                                              action="{{route('dsf.store')}}">--}}
{{--                                            @csrf--}}

{{--                                            <input type="hidden" name="title" value="-">--}}
{{--                                            <input type="hidden" name="key" value="-all-">--}}
{{--                                            <input type="hidden" name="dataIndex" value="-">--}}
{{--                                            <input type="hidden" name="visible" value="1">--}}
{{--                                            <input type="hidden" name="type" value="-">--}}
{{--                                            <input type="hidden" name="data_source_id" value="{{$dataSource->id}}">--}}

{{--                                            <button type="submit" class="btn btn-link p-0">--}}
{{--                                                <i class="bi bi-chevron-double-up" style="font-size: 17px"--}}
{{--                                                   title="подключить все"></i>--}}
{{--                                            </button>--}}
{{--                                        </form>--}}
                                    </th>
                                </tr>
                                </thead>
                                <tbody>

                                @php $i = 0 @endphp
                                @foreach($fields as $item)
                                    @php
                                        $flg = true
                                    @endphp
                                    @foreach($dataSource->dataSourceFields as $dsf)
                                        @if($item->column_name == $dsf->key)
                                            @php
                                                $flg = false
                                            @endphp
                                        @endif
                                    @endforeach

                                    @if($flg)
                                        @php $i++ @endphp
                                        <tr>
                                            <th scope="row" style="width: 40px">{{$i}}</th>
                                            <td>{{$item->parameter_name}}</td>
                                            <td>{{$item->data_type}}</td>
                                            <td style="width: 30px">
                                                <form method="POST"
                                                      action="{{route('dsf.store')}}">
                                                    @csrf
                                                    <input type="hidden" name="data_source_id"
                                                           value="{{$dataSource->id}}">
                                                    <input type="hidden" name="title"
                                                           value="{{$item->parameter_name}}">
                                                    <input type="hidden" name="key"
                                                           value="{{$item->parameter_name}}">
                                                    <input type="hidden" name="dataIndex"
                                                           value="{{$item->parameter_name}}">
                                                    <input type="hidden" name="visible" value="1">
                                                    <input type="hidden" name="type"
                                                           value="{{$item->data_type}}">
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
                @endif


                @isset($definition->definition)
                    <div class="alert alert-warning mb-4 shadow" role="alert">
                    <pre class="m-0">
{{print_r($definition->definition)}}
                    </pre>
                    </div>
                @endisset

            </div>
        </div>
    </div>

@endsection
