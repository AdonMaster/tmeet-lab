<?php


namespace App\Structs;


use App\Utils\FileIterator;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\UploadedFile;
use Str;

/**
 * Class SmsClaroFileHeaderSt
 * @package App\Structs
 *
 * @property Carbon $ref_dt_ini
 * @property Carbon $ref_dt_end
 */
class SmsClaroFileHeaderSt
{

    public $ref_dt_ini;
    public $ref_dt_end;

    /**
     * SmsClaroFileHeaderSt constructor.
     * @param Carbon $ref_dt_ini
     * @param Carbon $ref_dt_end
     */
    public function __construct(Carbon $ref_dt_ini, Carbon $ref_dt_end)
    {
        $this->ref_dt_ini = $ref_dt_ini;
        $this->ref_dt_end = $ref_dt_end;
    }


    /**
     * @param UploadedFile $file
     * @return SmsClaroFileHeaderSt
     * @throws Exception
     */
    public static function extract(UploadedFile $file)
    {
        $pathname = $file->getPathname();

        if (! $pathname) {
            throw new Exception('Caminho do arquivo em branco. Provavelmente o arquivo é muito grande. Tente configurar o PHP ini para permitir arquivos deste tamanho');
        }

        $p_header = false;
        $p_ref_ini = null;
        $p_ref_end = null;

        $fileIterator = new FileIterator($file);
        $fileIterator->iterate(function($line, $cont) use (&$p_header, &$p_ref_ini, &$p_ref_end) {

            if (++$cont > 20) return false;
            if (Str::startsWith($line, 'Tel;Seção;Data;Hora')) return false;

            if (Str::startsWith($line, 'TRANSMEET LT')) {
                $p_header = true;
            }

            // periodo referencia
            if (Str::startsWith($line, 'Período de Referência: ')) {
                $matches = [];
                preg_match('/.+: (\d{2}\/\d{2}\/\d{4}) a (\d{2}\/\d{2}\/\d{4})/', $line, $matches);
                $p_ref_ini = Carbon::createFromFormat('d/m/Y', $matches[1])->startOfDay();
                $p_ref_end = Carbon::createFromFormat('d/m/Y', $matches[2])->startOfDay();
            }

            return true;
        });

        // validation
        if (!$p_ref_ini || !$p_ref_end || !$p_header) {
            throw new Exception('Cabeçalho de arquivo inválido');
        }

        //
        return new SmsClaroFileHeaderSt($p_ref_ini, $p_ref_end);
    }


}