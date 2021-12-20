<?php


namespace App\Http\Controllers;


use App\Models\ArquivosContaModel;
use App\Models\SmsOperadorasModel;
use App\Repo\SmsClaroRepo;
use App\Structs\SmsClaroFileHeaderSt;
use App\Structs\SmsClaroFileSt;
use App\Utils\FileIterator;
use App\Utils\Number;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class SmsClaroImporterController extends Controller
{

    /**
     * @var SmsClaroRepo
     */
    private $repo;


    /**
     * SmsClaroImporterController constructor.
     * @param SmsClaroRepo $smsClaroRepo
     */
    public function __construct(SmsClaroRepo $smsClaroRepo)
    {
        $this->repo = $smsClaroRepo;
    }

    public function store()
    {
        // basic validation
        $files = request()->file('arquivos');
        if (!$files || !is_array($files) || count($files) < 1) {
            return $this->jsonError('Campo [arquivos] inválido');
        }

        //
        try {

            // aki processo o nome dos arquivos e valido se estão em ordem
            $files = $this->processFilesSt($files);

            // validando se o arquivo jah foi processado
            $nome_arquivo = $files[0]->filename_raw;
            if ($this->repo->arquivosContaExists($nome_arquivo)) {
                return $this->jsonError('Este arquivo já foi processado');
            }

            // aki processo o conteudo, enviando para o banco de dados tb
            $this->processFilesContent($files);

            // arquivo processado, vamos marcar no banco isso
            //TODO: $this->repo->arquivosContaAdd($nome_arquivo);

        } catch (Exception $e) {
            return $this->jsonError($e->getMessage());
        }

        return $this->jsonOk();
    }

    /**
     * @param UploadedFile[] $files
     * @return SmsClaroFileSt[]
     * @throws Exception
     */
    private function processFilesSt(array $files)
    {
        $res = [];

        foreach ($files as $file) {
            $res[] = SmsClaroFileSt::extract($file);
        }

        $sortedModels = collect($res)->sortBy(function($model) {
            return $model->sequence;
        })->all();

        foreach ($sortedModels as $key => $model) {
            if ($key + 1 != $model->sequence) {
                throw new Exception('O cabeçalho ou mais arquivos da sequência estão faltando.');
            }
        }

        return $sortedModels;
    }


    /**
     * @param SmsClaroFileSt[] $files
     * @throws Exception
     */
    private function processFilesContent(array $files)
    {
        // salvando contas_claro_upload
        $headerModel = $this->processFilesContentHeader($files[0]);

        // salvando sms_operadoras
        $ccont = 0;
        $l_column_names = [];
        foreach ($files as $file) {
            $fileIterator = new FileIterator($file->file);
            $fileIterator->iterate(function($line, $cont) use ($headerModel, $file, &$ccont, &$l_column_names) {

                if (count($l_column_names)) {

                    $row = explode(';', $line);
                    $l_secao = $row[$l_column_names['Seção']];

                    if ($l_secao == 'Torpedos') {

                        $data_inicio = $headerModel->data_inicio;
                        $data_fim = $headerModel->data_fim;
                        $origem = preg_replace("/[^0-9]/", '', $row[$l_column_names['Tel']]);
                        $destino = preg_replace("/[^0-9]/", '', $row[$l_column_names['Número']]);
                        $valor_operadora = Number::brToFloat1($row[$l_column_names['Valor Cobrado']]);
                        $conta = $file->id2;
                        $data_envio = Carbon::createFromFormat('d/m/Y', $row[$l_column_names['Data']])->startOfDay();
                        $linha_arquivo = $cont;
                        $descricao = $row[$l_column_names['Descrição']];

                        $this->repo->smsOperadorasAdd(
                            $data_inicio, $data_fim, $origem, $destino, $valor_operadora, $conta,
                            $data_envio, $linha_arquivo, $descricao
                        );

                        if (++$ccont > 20) return false;
                    }

                } else if (Str::startsWith($line, 'Tel;Seção;Data;Hora;Origem(UF)-Destino;Número;')) {
                    $l_column_names = array_flip(explode(';', $line));
                } else if ($cont > 100) {
                    throw new Exception('Este arquivo não parece conter dados.');
                }

            });
        }
    }

    /**
     * @param SmsClaroFileSt $file
     * @return \App\Models\ContasClaroUploadModel
     * @throws Exception
     */
    private function processFilesContentHeader(SmsClaroFileSt $file)
    {
        $USUARIO_ID = 1;
        $headerFile = $file->file;
        $headerSt = SmsClaroFileHeaderSt::extract($headerFile);

        $conta = $file->id2;
        $data_inicio = $headerSt->ref_dt_ini;
        $data_fim = $headerSt->ref_dt_end;
        $usuario_upload = $USUARIO_ID;
        $nome_arquivo = $file->filename_raw;

        return $this->repo->contasClaroAdd($conta, $data_inicio, $data_fim, $usuario_upload, $nome_arquivo);
    }


}