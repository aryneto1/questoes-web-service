@extends('layout')

<link rel="stylesheet" href="{{ asset('css/download/download-index.css') }}">

@section('cabecalho')
    Download Questões
@endsection

@section('conteudo')
    <form method="post" action="/questoes/download">
        <div class="form-group">
            <label for="web-service" id="textoWebService">Escolha o Web Service</label>
            <select name="web-service" id="selecao" required class="form-group">
                <option value="" selected disabled hidden>Selecionar Web Service</option>
                @foreach($webservices as $webservice)
                    <option value="{{ $webservice->id }}">{{ $webservice->descricao }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="disciplina">Informe os códigos das disciplinas (use 1 espaço para separá-los)</label>
            <input type="text" name="disciplina" id="disciplina" class="form-control" placeholder="Códigos da disciplinas" required>
        </div>
        @csrf
        <div class="btn btn-outline-primary" id="botao">
            <i class="fas fa-download"> Download</i>
        </div>
    </form>
    <script>
        $(document).ready( function(){
            window.rotaDownload = "{{ route('downloadGet') }}"
            window.urlDisciplina = "{{ url("questao/") }}" +"/";
        });
    </script>
    <script src="{{ asset('js/download/download-index.js') }}"></script>
@endsection
