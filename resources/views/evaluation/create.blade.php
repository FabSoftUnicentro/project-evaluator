@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @include('helpers.flash-message')
                <div class="card">
                    <div class="card-header">Avaliando Projeto: {{ $project->name }}</div>
                    <div class="card-body">
                        <form action="{{ route('evaluations.store', $project->id) }}" method="post">
                            @csrf
                            <label for="rating">Nota: </label>
                            <select id="rating" name="rating">
                                @for ($i = 0; $i <= 10; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>

                            <br>
                            <label for="comment">Comentário: </label>
                            <textarea id="comment" name="comment" cols="73" rows="10" style="resize: vertical"></textarea>
                            <br>
                            <br>

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
