@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @include('helpers.flash-message')
            <div class="alert alert-warning">
                <p>Atenção:</p>
                <ul>
                    <li>As Avaliações concedidas por alunos/outros usuários terão peso 1.</li>
                    <li>As Avaliações concedidas por professores terão peso 2.</li>
                    <li>Somente avalie os projetos dos quais esteve presente na apresentação.</li>
                    <li>Somente os usuários administradores (todos os professores) conseguem acessar o ranking dos projetos avaliados.</li>
                </ul>
                <p>Critérios de Ordem no Ranking Final:</p>
                <ol>
                    <li>Nota Média Ponderada Geral.</li>
                    <li>Nota Média dos Professores (1º Critério de desempate).</li>
                    <li>Nota Média dos Alunos (2º Critério de desempate).</li>
                </ol>
            </div>
            <div class="card">
                <div class="card-header">Projetos a Serem Avaliados</div>
                <div class="card-body">
                    @if (count($projects) > 0)
                        <table class="table table-responsive" style="display: table">
                            <thead>
                                <tr>
                                    <th>Projeto</th>
                                    <th>Integrantes</th>
                                    <th class="text-center">Ação</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($projects as $project)
                                <tr>
                                    <td style="width: 50%">
                                        {{ $project->name }}
                                    </td>
                                    <td style="width: 40%">
                                        @foreach($project->members as $member)
                                            {{ $member->name }}
                                            <br>
                                        @endforeach
                                    </td>
                                    <td style="width: 10%">
                                        <a
                                            class="btn btn-info btn-block"
                                            href="{{ route('evaluations.create', $project->getKey()) }}"
                                        >
                                            Avaliar
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @else
                        <p>Você já avaliou todos os projetos!</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
