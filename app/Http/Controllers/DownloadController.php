<?php

namespace App\Http\Controllers;

use App\Http\Services\DownloadService;
use App\Models\WebService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class DownloadController extends Controller
{
    public function index(Request $request): object
    {
        //manda para a caixa de select todos os webservices
        $webservices = WebService::all();

        return view('download.index', compact('webservices'));
    }

    public function download(Request $request)
    {

        //pega o webservice e a disciplina para fazer download do arquivo .csv
        $id = $request['id'];
        $disciplina = $request['disciplina'];

        $webservice = new DownloadService();
        $arrayTotalArq = $webservice->downloadService($id, $disciplina);

        return response()->json($arrayTotalArq);
    }
}
