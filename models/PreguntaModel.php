<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Pregunta
 *
 * @author jcaperap
 */
class PreguntaModel extends Model {

    private $idPregunta;
    private $titulo;
    private $idCategoria;
    private $respuesta;
    private $idUsuarioRegistra;
    private $estado;
    private $fechaRegistro;

    public function __construct() {
        parent::__construct();
    }

    public function getIdPregunta() {
        return $this->idPregunta;
    }

    public function getTitulo() {
        return $this->titulo;
    }

    public function getIdCategoria() {
        return $this->idCategoria;
    }

    public function getRespuesta() {
        return $this->respuesta;
    }

    public function getIdUsuarioRegistra() {
        return $this->idUsuarioRegistra;
    }

    public function getEstado() {
        return $this->estado;
    }

    public function getFechaRegistro() {
        return $this->fechaRegistro;
    }

    public function setIdPregunta($idPregunta) {
        $this->idPregunta = $idPregunta;
    }

    public function setTitulo($titulo) {
        $this->titulo = $titulo;
    }

    public function setIdCategoria($categoriaName) {   
		$categoria = new CategoriaModel();
        $this->idCategoria = $categoria->getIdCategoriaNombre($categoriaName);
    }

    public function setRespuesta($respuesta) {
        $this->respuesta = $respuesta;
    }

    public function setIdUsuarioRegistra($idUsuarioRegistra) {
        $this->idUsuarioRegistra = $idUsuarioRegistra;
    }

    public function setEstado($estado) {
        $this->estado = $estado;
    }

    public function setFechaRegistro($fechaRegistro) {
        $this->fechaRegistro = $fechaRegistro;
    }
    public function insertPregunta() {
        $this->getDb()->insertQuery("pregunta", "titulo,id_categoria,respuesta,id_usuario_registra",
                "'$this->titulo','".$this->getIdCategoria()."','$this->respuesta','$this->idUsuarioRegistra'");
        return $this->getDb()->lastInsertId();        
    }
}
