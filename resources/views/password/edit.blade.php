@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @include('helpers.flash-message')
            <div class="card">
                <div class="card-header">Projetos a Serem Avaliados</div>
                <div class="card-body">
                    <form action="{{ route('passwords.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="old_password">Senha atual: </label>
                            <input id="old_password" name="old_password" type="password" class="form-control">

                            <label for="new_password">Nova senha: </label>
                            <input id="new_password" name="new_password" type="password" class="form-control">

                            <label for="new_password_confirmation">Confirme a nova senha: </label>
                            <input id="new_password_confirmation" name="new_password_confirmation" type="password" class="form-control">
                        </div>

                        <div class="float-right">
                            <button type="submit" class="btn btn-info">Salvar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
