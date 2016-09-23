<?php

class Validador {

    private $campos;
    private $valores;
    private $valoresQuitados;

    public function __construct() {
        $this->campos = array();
    }

    public function setValores($valores) {
        $this->valores = $valores;
    }

    public function setCampos(array $campos) {
        $this->campos = $campos;
    }

    public function getCamposJSON() {
        return json_encode($this->campos);
    }

    public function quitarValidacionesServidor($valores) {
        $this->valoresQuitados = $valores;
    }

    public function validarServidor() {        
        $isValid = false;
        foreach ($this->campos as $key => $value) {
            foreach ($value as $validacion => $valor) {
                if (!array_key_exists($key,$this->valoresQuitados)) {
                    if ($validacion === "required") {
//                        echo $validacion ."=>".$this->valores[$key]."=>".$key;
                        if (!empty($this->valores[$key])) {
                            $isValid = true;
                        } else {
                            $isValid = false;
                            return $isValid;
                        }
                    }
                    if ($validacion === "number") {
                        if (is_numeric($this->valores[$key])) {
                            $isValid = true;
                        } else {
                            $isValid = false;
                            return $isValid;
                        }
                    }
                    if ($validacion === "max") {
                        if ($this->valores[$key] <= $valor) {
                            $isValid = true;
                        } else {
                            $isValid = false;
                            return $isValid;
                        }
                    }
                    if ($validacion === "min") {
                        if ($this->valores[$key] >= $valor) {
                            $isValid = true;
                        } else {
                            $isValid = false;
                            return $isValid;
                        }
                    }
                    if ($validacion === "regexp") {
                        if (preg_match("/^$valor$/", $this->valores[$key]) == 1) {
                            $isValid = true;
                        } else {
                            $isValid = false;
                            return $isValid;
                        }
                    }
                }
            }
        }
        return $isValid;
    }

    public function validarData() {
//        foreach()
    }

}
