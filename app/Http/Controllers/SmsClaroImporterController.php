<?php


namespace App\Http\Controllers;


use App\Models\ArquivosContaModel;
use App\Models\SmsOperadorasModel;
use App\Processors\SmsClaroImporter;
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

class SmsClaroImporterController extends Controller
{


    public function store(SmsClaroImporter $importer)
    {
        // basic validation
        $files = request()->file('arquivos');
        if (!$files || !is_array($files) || count($files) < 1) {
            return $this->jsonError('Campo [arquivos] inválido');
        }

        //
        try {

            $msg = $importer->import($files);

            return $this->jsonOk($msg);

        } catch (Exception $e) {
            return $this->jsonError($e->getMessage());
        }
    }




}
