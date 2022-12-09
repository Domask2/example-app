@extends('layouts.main')

@section('content')

    @if (session('status'))
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card mt-lg-5">
                        <div class="card-body">
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif


    <div class="container">
        <div class="row justify-content-center">

            <div class="col-md-6">
                <div class="card mt-lg-5 bg-warning shadow-sm">
                    <div class="card-body pt-0 pb-0">
                            <pre>
                                <h4>GET</h4>
1. Фильтрация в GET запросе.
    ?__filter={{ '<fld_name><operator><val>|<val2>|...' }},
    {{ '<fld_name><operator><val>|<val2>|...' }}
    ['__like__', '>=', '<=', '!=', '>', '<', '=']

3. Пагинация.
    ?__per_page={{'<кол-во записей>'}}&__cur_page={{'<№ страницы>'}}}}

3. Поиск. (все записи где поля "search" содержат <поисковый запрос>)
    ?__search={{'<поисковый запрос>'}}
                            </pre>
                    </div>
                </div>

                <div class="card mt-lg-4 bg-primary shadow-sm">
                    <div class="card-body pt-0 pb-0">
                            <pre class="text-white">
                                <h4>UPDATE</h4>
{
    "__data": {...},
    "__filter": "{{'<fieldname>=<value>, ...'}}",
    "__method": "update"
}
                            </pre>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card mt-lg-5 bg-success shadow-sm">
                    <div class="card-body pt-0 pb-0">
                            <pre>
                                <h4>POST</h4>
{
    "__data": {...},
    "__method": "store"
}
                            </pre>
                    </div>
                </div>

                <div class="card mt-lg-4 bg-danger shadow-sm">
                    <div class="card-body pt-0 pb-0">
                            <pre class="text-white">
                                <h4>DELETE</h4>
{
    "__filter": "{{'<fieldname>=<value>, ...'}}",
    "__method": "destroy"
}

<i>Если нашлось несколько записей, будет удалена первая.</i>
                            </pre>
                    </div>
                </div>

                <div class="card mt-lg-4 shadow-sm" style="background-color: #8447c1; border: #61259c">
                    <div class="card-body pt-0 pb-0">
                            <pre class="text-white">
                                <h4>EXECUTE</h4>
{...}
                            </pre>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
