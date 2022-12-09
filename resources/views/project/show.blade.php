@extends('layouts.main')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-4">

                <div class="card mt-lg-4">
                    <div class="card-body">
                        <div class="mb-0 row">
                            <label for="title" class="col-sm-4 col-form-label pt-0 pb-0">
                                <i class="bi bi-briefcase-fill mr-2" style="color: saddlebrown; font-size: 25px;"></i>
                            </label>
                            <div for="title" class="col-sm-8 col-form-label pt-2">
                                <strong>{{$project->title}}</strong>
                            </div>
                        </div>

                        <hr class="mt-1">

                        <form name="formNewProject" action="{{route('project.update', $project)}}" method="post">
                            @csrf
                            @method('put')
                            <div class="mb-1 row">
                                <label for="staticEmail" class="col-sm-4 col-form-label">Название:</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control form-control-sm" id="staticEmail"
                                           name="title"
                                           value="{{$project->title}}">
                                </div>
                            </div>

                            <div class="mb-1 row">
                                <label for="staticEmail" class="col-sm-4 col-form-label">Ключ:</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control form-control-sm" id="key" name="key"
                                           value="{{$project->key}}">
                                </div>
                            </div>

                            <div class="mb-1 row">
                                <label for="staticEmail" class="col-sm-4 col-form-label">Тип:</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control-plaintext form-control-sm" name="type"
                                           readonly id="type" value="{{$project->type}}">
                                </div>
                            </div>

                            <div class="mb-1 row">
                                <label for="inputDesc" class="col-sm-4 col-form-label">Описание:</label>
                                <div class="col-sm-8">
                                    <textarea rows="5" id="inputDesc" class="form-control form-control-sm"
                                              name="description">{{$project->description}}</textarea>
                                </div>
                            </div>

                            <hr>

                            <div class="row justify-content-end">
                                <div class="col-sm-4 pr-0">
                                    <button type="button"
                                            class="btn btn-danger form-control text-white" data-toggle="modal"
                                            data-target="#destroyProjectModal">
                                        <i class="bi bi-trash mr-2"></i>Удалить
                                    </button>
                                </div>
                                <div class="col-sm-8">
                                    <button type="submit"
                                            class="btn btn-info form-control text-white"><i
                                            class="bi bi-check-lg mr-2"></i></i>Сохранить
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <form method="post" action="{{route('project.destroy', $project)}}" name="destroyForm">
                @csrf
                @method('delete')
                <!-- Modal -->
                    <div class="modal fade modal" id="destroyProjectModal" tabindex="-1"
                         aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Удаление проекта</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    Проект будет удален безвозвратно.<br>
                                    Подтвердите удаление или отмените действие.
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Отменить
                                    </button>
                                    <button type="submit" class="btn btn-danger"><i class="bi bi-trash mr-2"></i>Удалить
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>


                <br>

                <div class="row justify-content-center">
                    <div class="col-sm-11 text-center">
                        <a class="btn btn-light form-control" href="{{route('project.create')}}">
                            <i class="bi bi-plus-lg mr-2"></i> Создать новый проект</a>
                    </div>
                </div>

            </div>

            <div class="col-md-8">
                <div class="card mt-lg-4">
                    <div class="card-body">

                        <table class="table table-sm">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Title</th>
                                <th scope="col">Key</th>
                                <th scope="col">Host</th>
                                <th scope="col">Port</th>
                                <th scope="col">Database</th>
                                <th scope="col">Schema</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($project->dataBases as $item)
                                <tr>
                                    <td>{{$loop->index + 1}}</td>
                                    <td><i class="bi bi-server mr-2" style="color: orange"></i>
                                        <a href="{{route('db.show', $item)}}">{{$item->title}}</a></td>
                                    <td>{{$item->key}}</td>
                                    <td>{{$item->host}}</td>
                                    <td>{{$item->port}}</td>
                                    <td>{{$item->database}}</td>
                                    <td>{{$item->schema}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        <div class="row justify-content-center">
                            <div class="col-sm-11">
                                <a href="{{route('db.create')}}"
                                   class="btn btn-light form-control">
                                    <i class="bi bi-plus-lg mr-2"></i>Добавить базу данных</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
