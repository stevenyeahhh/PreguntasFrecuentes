<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UtilitiesController
 *
 * @author jcaperap
 */
class UtilitiesController extends Controller{
    //put your code here
    public function __construct() {
        parent::__construct();
    }
    public function index() {
        ;
    }
    public function logout(){
        $this->cerrarSesion();
        header('Location:'.BASE.'index');
                
    }
}
