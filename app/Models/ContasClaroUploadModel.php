<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ContasClaroUploadModel
 *
 * @property int $id
 * @property int|null $conta
 * @property \Illuminate\Support\Carbon $data_cadastro
 * @property int|null $usuario_upload
 * @property \Illuminate\Support\Carbon|null $data_inicio
 * @property \Illuminate\Support\Carbon|null $data_fim
 * @property string|null $nome_arquivo
 * @method static \Illuminate\Database\Eloquent\Builder|ContasClaroUploadModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ContasClaroUploadModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ContasClaroUploadModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|ContasClaroUploadModel whereConta($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContasClaroUploadModel whereDataCadastro($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContasClaroUploadModel whereDataFim($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContasClaroUploadModel whereDataInicio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContasClaroUploadModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContasClaroUploadModel whereNomeArquivo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContasClaroUploadModel whereUsuarioUpload($value)
 * @mixin \Eloquent
 */
class ContasClaroUploadModel extends Model
{

    protected $table = 'contas_claro_upload';
    protected $fillable = [
        'conta', 'data_cadastro', 'usuario_upload', 'data_inicio', 'data_fim', 'nome_arquivo'
    ];
    protected $dates = ['data_cadastro', 'data_inicio', 'data_fim'];
    protected $hidden = [];
    public $timestamps = false;
    protected $casts = [];
    protected $with = [];

}