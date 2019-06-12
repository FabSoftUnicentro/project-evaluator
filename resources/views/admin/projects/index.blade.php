@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @include('helpers.flash-message')
            <div class="card">
                <div class="card-header">Projetos</div>
                <div class="card-body">
                    <table class="table table-responsive text-center" style="display: table">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Membros</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($projects as $project)
                            <tr>
                                <td style="width: 40%">
                                    {{ $project->name }}
                                </td>
                                <td style="width: 30%">
                                    @if (count($project->members) > 0)
                                        @foreach($project->members as $member)
                                            <p>{{ $member->name }}</p>
                                        @endforeach
                                    @else
                                        <p>Nenhum</p>
                                    @endif
                                </td>
                                <td style="width: 30%">
                                    <div class="btn-group-sm">
                                        <a
                                            class="btn-sm btn-info"
                                            href=""
                                        >
                                            Detalhar
                                        </a>
                                        <a
                                            class="btn-sm btn-warning"
                                            href=""
                                        >
                                            Editar
                                        </a>
                                        <a
                                            href="#"
                                            class="btn-sm btn-danger delete-project"
                                            data-id="{{ $project->getKey() }}"
                                        >
                                            Excluir
                                        </a>
                                    </div>
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

@section('js')
    <script>
        $(function () {
            $('.delete-project').click(function () {
                if (confirm('Confirma a exclusão do projeto?')) {
                    const projectId = $(this).data('id');

                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        url: '{{ route('admin.projects.destroy', '_project') }}'.replace('_project', projectId),
                        method: 'DELETE',
                        success: function (xhr) {
                            alert('Projeto excluído com sucesso!');
                            window.location.reload();
                        },
                        error: function (xhr) {
                            alert('Falha ao excluir projeto!');
                        }
                    });
                }
            });
        });
    </script>
@endsection
