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

    public function __construct() {
        parent::__construct();
        if (!($this->sesionIniciada() && $this->getSesionVar('idRol') == 2)) {
            header("Location:" . BASE . DS . 'index' . DS);
        }

    }

    public function index() {
        $this->view->setTitle("Bienvenido");
        $this->view->renderize("index");
    }


}
