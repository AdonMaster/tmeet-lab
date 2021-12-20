<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    private function json($message, $code, array $payload)
    {
        return response()->json(compact('message', 'payload'), $code);
    }

    public function jsonOk($message='Ok!', array $payload=[])
    {
        return $this->json($message, 200, $payload);
    }

    public function jsonPayload(array $payload)
    {
        return $this->json('Ok!', 200, $payload);
    }

    public function jsonError($message='Ops!', $code=400)
    {
        return $this->json($message, $code, []);
    }

}
