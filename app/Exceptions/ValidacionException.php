<?php

namespace App\Exceptions;

use Exception;

class ValidacionException extends Exception
{
    protected string $ruta;

    public function __construct(string $mensaje, string $ruta)
    {
        parent::__construct($mensaje);
        $this->ruta = $ruta;
    }

    public function render()
    {
        return redirect()->route($this->ruta)->with('error', $this->getMessage());
    }
}
