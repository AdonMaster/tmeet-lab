<?php


namespace App\Utils;


use Closure;
use Exception;
use Illuminate\Http\UploadedFile;

class FileIterator
{
    /**
     * @var string
     */
    private $path;

    /**
     * FileIterator constructor.
     * @param UploadedFile $file
     * @throws Exception
     */
    public function __construct(UploadedFile $file)
    {
        $this->path= $file->getPathname();

        if (! $this->path) {
            throw new Exception('Caminho do arquivo em branco. Provavelmente o arquivo é muito grande. Tente configurar o PHP ini para permitir arquivos deste tamanho');
        }
    }

    public function iterate(Closure $cb)
    {
        $handle = fopen($this->path, 'r');
        $cont = 0;

        while (!feof($handle)) {
            $line = utf8_encode(fgets($handle));

            $cont++;

            if ($cb($line, $cont) === false) break;
        }

        fclose($handle);
    }

}