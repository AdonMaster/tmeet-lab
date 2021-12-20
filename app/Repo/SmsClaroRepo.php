<?php


namespace App\Repo;


use App\Models\ArquivosContaModel;
use App\Models\ContasClaroUploadModel;
use App\Models\SmsOperadorasModel;
use Illuminate\Support\Carbon;

class SmsClaroRepo
{

    public function arquivosContaExists($nome_arquivo)
    {
        return ArquivosContaModel::where(compact('nome_arquivo'))->exists();
    }

    public function arquivosContaAdd($nome_arquivo)
    {
        return ArquivosContaModel::create(compact('nome_arquivo'));
    }

    /**
     * @param $conta
     * @param \Carbon\Carbon $data_inicio
     * @param \Carbon\Carbon $data_fim
     * @param $usuario_upload
     * @param $nome_arquivo
     * @return ContasClaroUploadModel
     */
    public function contasClaroAdd($conta, \Carbon\Carbon $data_inicio, \Carbon\Carbon $data_fim, $usuario_upload, $nome_arquivo)
    {
        return ContasClaroUploadModel::create(compact(
            'conta', 'data_inicio', 'data_fim', 'usuario_upload', 'nome_arquivo'
        ));
    }

    public function smsOperadorasAdd(
        Carbon $data_inicio, Carbon $data_fim, $origem, $destino, $valor_operadora, $conta,
        $data_envio, $linha_arquivo, $descricao
    )
    {
        return SmsOperadorasModel::create(compact(
            'data_inicio', 'data_fim', 'origem', 'destino', 'valor_operadora',
            'conta', 'data_envio', 'linha_arquivo', 'descricao'
        ));
    }

}