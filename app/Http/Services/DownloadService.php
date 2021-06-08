<?php

namespace App\Http\Services;

use App\Models\WebService;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Csv;

class DownloadService
{
    //procura o serviço que se procura no webservice selecionado e retorna-o
    protected function auxiliarDownload($id, $rota, $params): mixed
    {
        try{
            $webservice = WebService::find($id);

            $api_server = $webservice->api_server . $rota;
            $api_http_user = $webservice->api_http_user;
            $api_http_pass = $webservice->api_http_pass;
            $chave_acesso = $webservice->chave_acesso;
            $chave_name = $webservice->chave_name;
            $format = 'json';

            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, "{$api_server}/format/{$format}");
            curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
            curl_setopt($curl, CURLOPT_USERPWD, "{$api_http_user}:{$api_http_pass}");
            curl_setopt($curl, CURLOPT_HTTPHEADER, array("{$chave_name}:{$chave_acesso}"));
            curl_setopt($curl, CURLOPT_NOBODY, 1);
            curl_exec($curl);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_HEADER, 0);
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($params));
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
            $output = curl_exec($curl);
            curl_close($curl);
            $obj = json_decode($output); // Resposta do WebService
            return $obj;

            /*$curl = curl_init();

            $url = $webservice->apiserver . $rota;
            $url .= "&" . http_build_query($params);

            curl_setopt_array(
                $curl,
                [
                    CURLOPT_URL            => $url,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING       => '',
                    CURLOPT_MAXREDIRS      => 10,
                    CURLOPT_TIMEOUT        => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST  => 'POST',
                ]
            );

            $response = json_decode(curl_exec($curl));
            $arrInfo = curl_getinfo($curl);
            if($arrInfo['http_code'] >= 300 ){
                throw new \Exception("Retorno Web-Service moodle error: ({$arrInfo['http_code']}) " . curl_strerror(curl_errno($curl)));
            }

            if(isset($response->exception) && isset($response->message)){
                throw new \Exception("Retorno Web-Service moodle error: " . $response->message);
            }
            curl_close($curl);
            return $response;*/
        } catch (\Exception $e) {
            curl_close($curl);
            return "";
        }
    }

    protected function spreadsheet($objBancoQuestoes, $arrTextoAlternativas, $arrCorreta, $disciplina): Spreadsheet
    {
        $spreadsheet = new Spreadsheet();

        //coloca titulos em cada coluna do excel
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', "Question Title")
            ->setCellValue('B1', "Question Text")
            ->setCellValue('C1', "Question Type")
            ->setCellValue('D1', "Question Options")
            ->setCellValue('E1', "Correct Answer")
            ->setCellValue('F1', "Answer Hint")
            ->setCellValue('G1', "Answer Description")
            ->setCellValue('H1', "Tags")
            ->setCellValue('I1', "Date of Post")
            ->setCellValue('J1', "status(draft/publish)")
            ->setCellValue('K1', "Image")
            ->setCellValue('L1', "image alignment")
            ->setCellValue('M1', "Curso")
            ->setCellValue('N1', "Disciplina");

        $rows = 2;
        $numQuestao = 1;
        foreach ($objBancoQuestoes as $item) {
            try {
                $correta = 0;

                //coloca underline nas alternativas para deixar separadas
                $stringImplode = implode("__", $arrTextoAlternativas[$item->QuestaoID]);

                //encontra a opção correta
                for ($i = 0; $i < count($arrCorreta[$item->QuestaoID]); $i++) {
                    if ($arrCorreta[$item->QuestaoID][$i] == 'S') {
                        $correta = $i + 1;
                    }
                }

                //coloca as questoes junto com as alternativas correspondentes no excel
                $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue('A' . $rows, "Questão " . $numQuestao . " - - " . $disciplina)
                    ->setCellValue('B' . $rows, strip_tags($item->Enunciado))
                    ->setCellValue('C' . $rows, "single")
                    ->setCellValue('D' . $rows, strip_tags($stringImplode))
                    ->setCellValue('E' . $rows, $correta)
                    ->setCellValue('F' . $rows, "")
                    ->setCellValue('G' . $rows, "")
                    ->setCellValue('H' . $rows, "")
                    ->setCellValue('I' . $rows, "")
                    ->setCellValue('J' . $rows, "")
                    ->setCellValue('K' . $rows, "")
                    ->setCellValue('L' . $rows, "")
                    ->setCellValue('M' . $rows, $disciplina)
                    ->setCellValue('N' . $rows, $item->QuestaoID);

                $numQuestao++;
                $rows++;

            } catch (\Exception $e) {
                Log::error($e->getMessage() . "linha do erro: " . $e->getLine());
            }

        }
        return $spreadsheet;
    }

    public function downloadService($id, $disciplina)
    {

        $arrayDisciplina = explode(" ", $disciplina);
        $arrayArqNaoVazio = [];
        $arrayArqVazio = [];

        foreach ($arrayDisciplina as $itemDisciplina) {
            //buscando as questoes no banco de questoes
            $objBancoQuestoes = $this->auxiliarDownload($id, "getBancoQuestoesDisciplinas", ["DisciplinaID" => $itemDisciplina]);

            if(!is_array($objBancoQuestoes)) {
                $arrayArqVazio[] = $itemDisciplina;
                continue;
            }

            //buscando as questoes do banco de alternativas
            $objAlternativas = $this->auxiliarDownload($id, "getAlternativasDisciplina", ["disciplinaID" => $itemDisciplina]);

            //loop que pega o texto das alternativas e qual a alternativa correta
            foreach ($objAlternativas as $item) {
                try {
                    if($item) {
                        $arrTextoAlternativas[$item->QuestaoID][] = $item->Texto;
                        $arrCorreta[$item->QuestaoID][] = $item->Correta;
                    }
                } catch (\Exception $e) {
                    throw new \Exception('Essa disciplina não existe.');
                }
            }

            //prepara o excel
            $spreadsheet = $this->spreadsheet($objBancoQuestoes, $arrTextoAlternativas, $arrCorreta, $itemDisciplina);

            //processo para salvar o excel na pasta e fazer download dele no browser
            $objWriter = new Csv($spreadsheet);

            $arqQuestao = __DIR__ . "/../../../public/questao/disciplina-" . $itemDisciplina . ".csv";
            $objWriter->save($arqQuestao);

            $nomeArq = 'disciplina-' . $itemDisciplina . '.csv';

            $arrayArqNaoVazio[] = $nomeArq;
        }

        return [
            'arrayArqNaoVazio' => $arrayArqNaoVazio,
            'arrayArqVazio' => $arrayArqVazio
        ];
    }
}
