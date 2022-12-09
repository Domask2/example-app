@extends('layouts.main')

@section('content')
    <div class="container-fluid mt-5">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="mt-lg-4">
                    <ul class="nav nav-tabs card-header-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" href="#">Проекты</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Базы данных</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Пользователи</a>
                        </li>
                    </ul>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="card mt-lg-4">
                            <div class="card-body">
                                <h4>Проекты системы</h4>
                                <table class="table table-sm">
                                    <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Key</th>
                                        <th scope="col">Title</th>
                                        <th scope="col">Description</th>
                                        <th scope="col"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($projects as $item)
                                        <tr>
                                            <td>{{$loop->index + 1}}</td>
                                            <td><a href="#!">{{$item['key']}}</a></td>
                                            <td>{{$item['title']}}</td>
                                            <td>{{$item['description']}}</td>
                                            <td>
                                                <button type="submit" class="form-control btn btn-link">Отправить</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-6">
                        <div class="card mt-lg-4">
                            <div class="card-body">
                                <h4>Проекты {{$srv}}</h4>
                                <table class="table table-sm">
                                    <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Key</th>
                                        <th scope="col">Title</th>
                                        <th scope="col">Description</th>
                                        <th scope="col"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($remoteProjects['data'] as $item)
                                        <tr>
                                            <td>{{$loop->index + 1}}</td>
                                            <td><a href="#!">{{$item['key']}}</a></td>
                                            <td>{{$item['title']}}</td>
                                            <td>{{$item['description']}}</td>
                                            <td>
                                                <button type="submit" class="form-control btn btn-link">Обновить
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
