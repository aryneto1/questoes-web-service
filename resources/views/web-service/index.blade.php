@extends('layout')

<link rel="stylesheet" href="{{ asset('css/web-service/webservice-index.css') }}">

@section('cabecalho')
    Listagem de ambientes de importação
@endsection

@section('conteudo')
    @include('mensagem', ['mensagem' => $mensagem])
    <table class="tabela">
        <thead>
        <tr class="titulos">
            <th>Código</th>
            <th>Descrição</th>
            <th>Ações</th>
        </tr>
        </thead>
        <tbody>
        @foreach($webservices as $webservice)
            <tr>
                <td class="idTabela">{{ $webservice->id }}</td>
                <td>{{ $webservice->descricao }}</td>
                <td class="bot">
                    <button class="btn btn-outline-info btn-sm mr-1 botEditar" data-id="{{$webservice->id}}">
                        <i class="fas fa-edit"> Editar</i>
                    </button>
                    <form method="post" action="/listagem/excluir/{{ $webservice->id }}"
                          onsubmit="return confirm('Tem certeza que deseja excluir {{ addslashes($webservice->descricao) }}?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-outline-danger btn-sm mr-1 botDeletar">
                            <i class="far fa-trash-alt"> Excluir</i>
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <button type="button" class="btn btn-outline-primary mt-3" id="adicionar">
        <i class="fas fa-plus-circle"> Adicionar</i>
    </button>

    @include('web-service.create')

    <script>
        $(document).ready( function () {
           window.urlListagem = "{{ route('editar') }}"
        });
    </script>
    <script src="{{ asset('js/web-service/webservice-index.js') }}"></script>
@endsection


