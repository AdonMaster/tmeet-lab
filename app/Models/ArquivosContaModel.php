<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ArquivosContaModel
 *
 * @property int $id
 * @property string|null $nome_arquivo
 * @property \Illuminate\Support\Carbon|null $data_insercao
 * @method static \Illuminate\Database\Eloquent\Builder|ArquivosContaModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ArquivosContaModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ArquivosContaModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|ArquivosContaModel whereDataInsercao($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ArquivosContaModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ArquivosContaModel whereNomeArquivo($value)
 * @mixin \Eloquent
 */
class ArquivosContaModel extends Model
{
    protected $table = 'arquivos_conta';
    protected $fillable = [
        'nome_arquivo', 'data_insercao'
    ];
    protected $dates = ['data_insercao'];
    protected $hidden = [];
    public $timestamps = false;
    protected $casts = [];
    protected $with = [];
}
