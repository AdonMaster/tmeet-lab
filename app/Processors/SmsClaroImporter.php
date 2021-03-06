<?php


namespace App\Processors;


use App\Repo\SmsClaroRepo;
use App\Structs\SmsClaroFileHeaderSt;
use App\Structs\SmsClaroFileSt;
use App\Utils\FileIterator;
use App\Utils\Number;
use Carbon\Carbon;
use DB;
use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Throwable;

class SmsClaroImporter
{
    /**
     * @var SmsClaroRepo
     */
    private $repo;
    /**
     * @var int
     */
    private $usuario_id;


    /**
     * SmsClaroImporter constructor.
     * @param SmsClaroRepo $smsClaroRepo
     */
    public function __construct(SmsClaroRepo $smsClaroRepo)
    {
        $this->repo = $smsClaroRepo;
    }

    /**
     * @param int $usuario_id
     * @param UploadedFile[] $files
     * @return string
     * @throws Throwable
     */
    public function import($usuario_id, array $files)
    {
        //
        $this->usuario_id = $usuario_id;

        // aki processo o nome dos arquivos e valido se estão em ordem
        $files = $this->processFilesSt($files);

        // validando se o arquivo jah foi processado
        $nome_arquivo = $files[0]->filename_raw;
        if ($this->repo->arquivosContaExists($nome_arquivo)) {
            throw new Exception('Este arquivo já foi processado');
        }

        // aki processo o conteudo, enviando para o banco de dados tb
        $saved = $this->processFilesContent($files);

        // arquivo processado, vamos marcar no banco isso
        $this->repo->arquivosContaAdd($nome_arquivo);

        //
        return "$saved registros inseridos";
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
     * @return int
     * @throws Exception
     * @throws Throwable
     */
    private function processFilesContent(array $files)
    {
        // salvando contas_claro_upload
        $headerModel = $this->processFilesContentHeader($files[0]);

        // salvando sms_operadoras
        $saved = 0;
        DB::transaction(function() use($headerModel, $files, &$saved) {

            $l_column_names = [];
            foreach ($files as $file) {
                $fileIterator = new FileIterator($file->file);
                $fileIterator->iterate(function($line, $cont) use ($headerModel, $file, &$l_column_names, &$saved) {

                    if (count($l_column_names) && $line) {

                        $row = explode(';', $line);
                        $secao = $row[$l_column_names['Seção']];

                        if ($secao == 'Torpedos') {

                            try {
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

                                $saved++;
                            } catch (Exception $e) {
                                $msg = $e->getMessage();
                                $sequence = $file->sequence;
                                throw new Exception("Erro Sequencia: $sequence@$cont | $msg | $line");
                            }

                        }

                    } else if (Str::startsWith($line, 'Tel;Seção;Data;Hora;Origem(UF)-Destino;Número;')) {
                        $l_column_names = array_flip(explode(';', $line));
                    }

                });
            } // for each file

        }); // transaction

        return $saved;
    }

    /**
     * @param SmsClaroFileSt $file
     * @return \App\Models\ContasClaroUploadModel
     * @throws Exception
     */
    private function processFilesContentHeader(SmsClaroFileSt $file)
    {
        $headerFile = $file->file;
        $headerSt = SmsClaroFileHeaderSt::extract($headerFile);

        $conta = $file->id2;
        $data_inicio = $headerSt->ref_dt_ini;
        $data_fim = $headerSt->ref_dt_end;
        $usuario_upload = $this->usuario_id;
        $nome_arquivo = $file->filename_raw;

        return $this->repo->contasClaroAdd($conta, $data_inicio, $data_fim, $usuario_upload, $nome_arquivo);
    }

}
