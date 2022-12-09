@extends('layouts.main')

@section('content')
    <div class="container-fluid mt-5">
        <div class="row justify-content-center">

            <div class="col-md-4">
                <div class="card mt-lg-4">

                    <div class="card-body">
                        <h5 class="card-title">Пользователи</h5>

                        <table class="table table-sm">
                            <thead>
                            <tr>
                                <th scope="col">Id</th>
                                <th scope="col">Name</th>
                                <th scope="col">Role</th>
                                <th scope="col">Project Roles</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>{{$user->id}}</td>
                                    <td>{{$user->name}}</td>
                                    <td>{{$user->role}}</td>
                                    <td>
                                        @foreach($user->toArray($user)['projects_roles'] as $key => $val)
                                            {{$key}} - [{{ implode(', ', $val) }}]
                                            <br>
                                        @endforeach
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        <hr>

                        <div>
                            {{ $users->links() }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card mt-lg-4">

                    <div class="card-body">
                        <h5 class="card-title">Проекты</h5>

                        <table class="table table-sm">
                            <thead>
                            <tr>
                                <th scope="col">Id</th>
                                <th scope="col">Name</th>
                                <th scope="col">Key</th>
                                <th scope="col">Published</th>
                                <th scope="col">Open</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($projects as $project)
                                <tr>
                                    <td>{{$project->id}}</td>
                                    <td>{{$project->title}}</td>
                                    <td>{{$project->key}}</td>
                                    <td>{{$project->is_published}}</td>
                                    <td>{{$project->is_open}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        <hr>

                        <div>
                            {{ $users->links() }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card mt-lg-4">

                    <div class="card-body">
                        <h5 class="card-title">LCP системы</h5>
                        <table class="table table-sm">
                            <thead>
                            <tr>
                                <th scope="col">Id</th>
                                <th scope="col">Host</th>
                                <th scope="col">Key</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>1</td>
                                <td><a href="/admin/remotes/b.lcplinor.ru">Сервер - b.lcplinor.ru</a></td>
                                <td>Dee85Fq3W2</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
