<?php

namespace App\Http\Controllers;

use App\Models\WebService;
use Illuminate\Http\Request;

class WebServiceController extends Controller
{
    public function index(Request $request): object
    {
        //pega todos os webservices do banco de dados e mostra uma listagem deles
        $webservices = WebService::all();
        $mensagem = $request->session()->get('mensagem');

        return view('web-service.index', compact('webservices', 'mensagem'));
    }

    public function store(Request $request): string
    {
        //procura se o webservice existe; se sim, ele abre o modal de edição; se nao, abre o de adicionar
        if(!is_null($request->id)) {
            $webservice = WebService::find($request->id);
            $webservice->descricao = $request->descricao;
            $request->session()
                ->flash(
                    'mensagem',
                    "Web Service {$webservice->descricao} editado com sucesso!"
                );
        }
        else {
            $webservice = new WebService();
            $webservice->descricao = $request->descricao;
            $request->session()
                ->flash(
                    'mensagem',
                    "Web Service {$webservice->descricao} criado com sucesso!"
                );
        }

        //adiciona ou edita o webservice
        $webservice->api_server = $request->api_server;
        $webservice->api_http_user = $request->api_http_user;
        $webservice->api_http_pass = $request->api_http_pass;
        $webservice->chave_acesso = $request->chave_acesso;
        $webservice->chave_name = $request->chave_name;

        $webservice->save();

        return redirect()->route('listagem');
    }

    public function destroy(Request $request): string
    {
        //deleta o webservice especifico
        WebService::destroy($request->id);

        $request->session()
            ->flash(
                'mensagem',
                "Web Service {$request->descricao} removido com sucesso!"
            );
        return redirect()->route('listagem');
    }

    public function show(Request $request)
    {
        //procura o webservice especifico e retorna todos os valores
        // para um js que vai exibir eles nos inputs de edição
        $webservice = WebService::find($request->id);
        return response()->json($webservice);
    }

}
