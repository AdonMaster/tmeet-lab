<?php


namespace App\Http\Controllers;


use App\Processors\SmsClaroImporter;
use Exception;

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
