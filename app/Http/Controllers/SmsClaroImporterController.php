<?php


namespace App\Http\Controllers;


use App\Processors\SmsClaroImporter;
use Throwable;

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

            $USUARIO_ID_DE_EXEMPLO = 1; // <----- aki supostamente pegaria o usuario da sessão
            $msg = $importer->import($USUARIO_ID_DE_EXEMPLO, $files);

            return $this->jsonOk($msg);

        } catch (Throwable $e) {
            return $this->jsonError($e->getMessage());
        }
    }




}
