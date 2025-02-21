<?php

namespace App\Exceptions;

use Exception;

class ValidacionException extends Exception
{
    protected string $ruta;
    protected array $parametros;

    public function __construct(string $mensaje, string $ruta, array $parametros = [])
    {
        parent::__construct($mensaje);
        $this->ruta = $ruta;
        $this->parametros = $parametros;
    }

    public function render()
    {
        return redirect()->route($this->ruta, $this->parametros)->with('error', $this->getMessage());
    }
}

