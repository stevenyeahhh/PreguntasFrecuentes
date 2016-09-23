<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UsuarioSecundarioController
 *
 * @author steven
 */
class UsuarioSecundarioController extends Controller {

    private $encuesta;
    private $candidato;
    private $eleccionUsuario;

    public function __construct() {
        parent::__construct();
        if (!($this->sesionIniciada() && $this->getSesionVar('idRol') == 2)) {
            header("Location:" . BASE . DS . 'index' . DS);
        }
        $this->encuesta = $this->loadModel("Encuesta");
        $this->candidato = $this->loadModel("Candidato");
        $this->eleccionUsuario = $this->loadModel("EleccionUsuario");
    }

    public function index() {
        $this->view->setTitle("Bienvenido");
        $this->view->renderize("index");
    }

    public function actualizarUsuarioSecundario() {
        
    }

    public function listarEleccionesActivas() {
        $this->view->setParams($this->encuesta->selectEncuestaPosiblesList(), 'encuestas');
        $this->view->setTitle("Elecciones activas");
        $this->view->renderize("listarElecciones");
    }

    public function consultarEleccion($idEleccion) {
        $this->view->setParams($this->encuesta->getEncuestaPorId($idEleccion)->fetch(PDO::FETCH_ASSOC), 'encuesta');
        $this->view->setParams($idEleccion, 'idEleccion');
        $this->view->setTitle("Elección #$idEleccion");
        $this->view->renderize("consultarEleccion");
    }

    public function listarCandidatos($idEleccion) {
        $validar = $this->validar(array_merge(array(
            'idCandidato' => array('required' => true, 'number' => true),
        )));
        if ($_POST) {
            
            $validar->setValores($_POST);
            if ($validar->validarServidor()) {
                extract($_POST);
                $candidato = $this->candidato->getCandidatoPorId($idCandidato)->fetch(PDO::FETCH_ASSOC);
                $this->eleccionUsuario->setIdUsuario($candidato["id_usuario"]);
                $this->eleccionUsuario->setIdEncuesta($idEleccion);
                $this->eleccionUsuario->insertEleccionUsuario();
//                die();
                if ($this->eleccionUsuario->insertEleccionUsuario()) {
                    header('Location:' . BASE . DS . 'usuarioSecundario' . DS . 'votar' . DS . $this->eleccionUsuario->insertEleccionUsuario() . DS . $idCandidato.DS.$idEleccion);
                } else {
                    $this->view->setError("No se pudo registrar");
                }
            }
            
        }
        $this->view->setValidacion($validar->getCamposJSON());
        $this->view->setParams($this->candidato->getCandidatoPorIdEncuesta($idEleccion)->fetchAll(PDO::FETCH_ASSOC), 'candidatos');
        $this->view->setParams($this->eleccionUsuario->getEleccionUsuarioPorIdEncuestaConfirmada($idEleccion)->fetch(PDO::FETCH_ASSOC), 'eleccionUsuario');
        $this->view->setTitle("Elección #$idEleccion");
        $this->view->renderize("listarCandidatos");
    }

    public function votar($idVotacion, $idCandidato,$idEleccion) {
        if ($_POST) {

             //En caso de no haber seleccionado el captcha
            if(!$this->validarCaptcha()){
                $this->view->setError("No puede votar hasta que no compruebe el CAPTCHA");
            }
            //El captcha está bien, proceda a hacer el voto
            else{
                $candidato = $this->candidato->getCandidatoPorId($idCandidato)->fetch(PDO::FETCH_ASSOC);
                if ($this->eleccionUsuario->validarVoto($candidato["id_usuario"], $idVotacion)) {
                    header("Location:" . BASE . DS . 'UsuarioSecundario' . DS . "listarEleccionesActivas");
                } else {
                    $this->view->setError("Ocurrió un error");
                }
            }

        }
        $this->view->setParams($idVotacion, 'votacion');
        $this->view->setParams($this->candidato->getCandidatoPorId($idCandidato)->fetch(PDO::FETCH_ASSOC), 'candidato');
        $this->view->setTitle("Elección #$idEleccion");
        $this->view->renderize("votar");
    }

    public function cancelar($idVotacion) {
//        echo "Hola";
        $this->eleccionUsuario->cancelarVoto($idVotacion);
//        echo "Hola";
        Header('Location:' . BASE . 'usuarioSecundario' . DS . 'listarEleccionesActivas');
    }

    /*IntSoftw - Captcha - Inicio*/
    private function validarCaptcha(){

        //Credenciales Captcha
        $secretKey = "6LdVPx8TAAAAAHyag48RxcQOf8LHthrsvR-6EgjZ";
        $ip = $_SERVER['REMOTE_ADDR'];
        $captcha = $_POST['g-recaptcha-response'];

        if(isset($captcha) && $captcha){

            //Respuesta de Google
            $respuesta = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$captcha&remoteip$ip");

            //Decodificamos el Json que repsonde el servicio de Google
            $array = json_decode($respuesta, TRUE);
            if($array['success']){
                return true;
            }else{
                return false;
            }

        }else{
            return false;
        }
    }
    /*IntSoftw - Captcha - Fin*/

}
