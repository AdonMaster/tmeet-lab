<?php


namespace App\Structs;


use Exception;
use Illuminate\Http\UploadedFile;

/**
 * Class SmsClaroFileSt
 * @package App\Structs
 * @property UploadedFile $file
 * @property string $id1
 * @property string $id2
 * @property string $dt
 * @property string $sequence
 */
class SmsClaroFileSt
{
    public $file;
    public $filename_raw;
    public $id1;
    public $id2;
    public $dt;
    public $sequence;

    /**
     * SmsClaroFileSt constructor.
     * @param UploadedFile $file
     * @param string $id1
     * @param string $id2
     * @param string $dt
     * @param string $sequence
     */
    public function __construct(UploadedFile $file, $id1, $id2, $dt, $sequence)
    {
        $this->file = $file;
        $this->id1 = $id1;
        $this->id2 = $id2;
        $this->dt = $dt;

        $this->filename_raw = join('_', [$id1, $id2, $dt]);

        $this->sequence = $sequence;
    }


    /**
     * @param UploadedFile $file
     * @return SmsClaroFileSt
     * @throws Exception
     */
    static public function extract(UploadedFile $file)
    {
        $FILENAME_PATTERN = '/(.+)_(.+)_(\d{4}_\d{2}_\d{2})_(\d).txt/';

        $filename = $file->getClientOriginalName();
        $matches = null;
        preg_match($FILENAME_PATTERN, $filename, $matches);

        if (count($matches) !== 5) throw new Exception("Nome de arquivo inválido: `$filename`");

        $model = new SmsClaroFileSt($file, $matches[1], $matches[2], $matches[3], $matches[4]);
        return $model;
    }

}