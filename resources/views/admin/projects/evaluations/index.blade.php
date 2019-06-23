@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @include('helpers.flash-message')
            <div class="card">
            <div class="card-header">Avaliações do Projeto: {{ $project->name }}</div>
                <div class="card-body">
                    @if (count($evaluations) > 0)
                        <table class="table table-responsive text-center" style="display: table">
                            <thead>
                                <tr>
                                    <th>Nota</th>
                                    <th>Comentário</th>
                                    <th>Avaliador</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($evaluations as $evaluation)
                                <tr>
                                    <td style="width: 10%">
                                        {{ $evaluation->value }}
                                    </td>
                                    <td style="width: 50%">
                                        <textarea cols="30" rows="10" style="resize: none" disabled>{{ $evaluation->comment }}</textarea>
                                    </td>
                                    <td style="width: 20%">
                                        {{ $evaluation->user->name }}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @else
                        <p>Este projeto ainda não tem nenhuma avaliação!</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
