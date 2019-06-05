@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @include('helpers.flash-message')
            <div class="card">
                <div class="card-header">Projetos Ordenados pela Média das Avaliações</div>
                <div class="card-body">
                    <table class="table table-responsive text-center" style="display: table">
                        <thead>
                            <tr>
                                <th>Projeto</th>
                                <th>Nota Média</th>
                                <th>Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($projects as $project)
                            <tr>
                                <td style="width: 40%">
                                    {{ $project->name }}
                                </td>
                                <td style="width: 40%">
                                    {{ $project->evaluationAverage }}
                                </td>
                                <td style="width: 20%">
                                    <a
                                        class="btn btn-info btn-block"
                                        href=""
                                    >
                                        Ver Avaliações
                                    </a>
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
@endsection
