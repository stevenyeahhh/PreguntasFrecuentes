<?php

class AprobadorController extends Controller {

    private $usuario; //los modelos se guardan en models/[nombre modelo]

    public function __construct() {
        parent::__construct();
		var_dump(($this->sesionIniciada() && $this->getSesionVar('idRol') == 3));
		var_dump($this->sesionIniciada());
		var_dump($this->getSesionVar('idRol'));
		var_dump($_SESSION);
		die();
        if (!($this->sesionIniciada() && $this->getSesionVar('idRol') == 3)) {
            header("Location:" . BASE . 'index' . DS);
        }
    }

    public function index() {

        $title = "Bienvenido a PreguntApp";
        $renderize = "index";
        $this->view->setTitle($title);
        $this->view->renderize($renderize);
    }

    public function iniciar() {
        $title = "Bienvenido a PreguntApp";
        $renderize = "iniciar";

        if ($_POST) {
            $_SESSION['session'] = $_POST['session'];
            $title = 'Inició sesión';
            $renderize = 'initsession';
        }
        if ($this->sesionIniciada()) {
            $title = 'Inició sesión';
            $renderize = 'initsession';
        }
        $this->view->setTitle($title);
        $this->view->renderize($renderize);
    }

//    public function desactivarIndex() {
//    Funci? para deshabilitar registros a trav? de la tabla con el bootstrap.switch ejemplo en views/index/index.phtml
//        extract($_POST);//        
//        die($this->bodega->cambiarEstado($usuario,$estado)? "?ito al " . (($estado) ? "activar" : "desactivar") . "  la bodega '$usuario'" : "No se pudo actualizar la bodega");
//        
//    }
    public function reporte($excel = false) {
        $data = array('a' => 1, 'b' => 2, 'c' => 3, 'd' => 4, 'e' => 5);
        if ($excel == 1) {
            $this->exportExcel($data, "Título", "Nombre del archivo"); //La funci? exportExcel, permite exportar arreglos tal y como se env?
        } else {
            $this->view->setParams(json_encode($data), "json_object");
            $this->view->renderize('report');
        }
    }

}
