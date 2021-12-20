<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\SmsOperadorasModel
 *
 * @property int $id
 * @property int $origem
 * @property int $destino
 * @property string|null $valor_operadora
 * @property string|null $valor_cliente
 * @property int|null $fatura
 * @property int|null $operadora
 * @property int|null $cli_id
 * @property \Illuminate\Support\Carbon|null $data_cadastro
 * @property int|null $conta_operadora
 * @property \Illuminate\Support\Carbon|null $data_sms
 * @property \Illuminate\Support\Carbon|null $data_inicio
 * @property \Illuminate\Support\Carbon|null $data_fim
 * @property \Illuminate\Support\Carbon|null $data_envio
 * @property int|null $conta
 * @property int|null $linha_arquivo
 * @property string|null $descricao
 * @property int|null $tipo_servico
 * @method static \Illuminate\Database\Eloquent\Builder|SmsOperadorasModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SmsOperadorasModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SmsOperadorasModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|SmsOperadorasModel whereCliId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SmsOperadorasModel whereConta($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SmsOperadorasModel whereContaOperadora($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SmsOperadorasModel whereDataCadastro($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SmsOperadorasModel whereDataEnvio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SmsOperadorasModel whereDataFim($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SmsOperadorasModel whereDataInicio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SmsOperadorasModel whereDataSms($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SmsOperadorasModel whereDescricao($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SmsOperadorasModel whereDestino($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SmsOperadorasModel whereFatura($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SmsOperadorasModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SmsOperadorasModel whereLinhaArquivo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SmsOperadorasModel whereOperadora($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SmsOperadorasModel whereOrigem($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SmsOperadorasModel whereTipoServico($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SmsOperadorasModel whereValorCliente($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SmsOperadorasModel whereValorOperadora($value)
 * @mixin \Eloquent
 */
class SmsOperadorasModel extends Model
{
    protected $table = 'sms_operadoras';
    protected $fillable = [
        'origem', 'destino', 'valor_operadora', 'valor_cliente', 'fatura', 'operadora', 'cli_id',
        'data_cadastro', 'conta_operadora', 'data_sms', 'data_inicio', 'data_fim',
        'data_envio', 'conta', 'linha_arquivo', 'descricao', 'tipo_servico',
    ];
    protected $dates = [
        'data_cadastro', 'data_sms', 'data_inicio', 'data_fim', 'data_envio'
    ];
    protected $hidden = [];
    public $timestamps = false;
    protected $casts = [];
    protected $with = [];
}
