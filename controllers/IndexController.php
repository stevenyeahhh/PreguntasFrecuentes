<?php

class IndexController extends Controller {

    private $usuario; //los modelos se guardan en models/[nombre modelo]

    public function __construct() {

        parent::__construct();
        if ($this->sesionIniciada()) {
            switch ($_SESSION['idRol']) {
                case ROL_ADMINISTRADOR:
                    header("Location:" . BASE . 'administrador');
                    break;
                case ROL_AUTOR:
                    header("Location:" . BASE . 'autor');
                    break;
                case ROL_APROBADOR:
                    header("Location:" . BASE . 'aprobador');
                    break;
            }
        }
        $this->usuario = $this->loadModel('Usuario');
    }

    public function index() {
        $title = "Bienvenido a " . APP_NAME;
        $renderize = "index";   
        $this->view->setTitle($title);
        $this->view->renderize($renderize);
    }

    public function iniciar() {
        $validar = $this->validar(array_merge(array(
            'nombreUsuario' => array('required' => true),
            'clave' => array('required' => true),
        )));

        $title = "Bienvenido a " . APP_NAME;
        $renderize = "iniciar";
        $this->view->setValidacion($validar->getCamposJSON());
        if ($_POST) {
            $validar->setValores($_POST);
            if ($validar->validarServidor()) {
                //var_dump($_POST);
                extract($_POST, EXTR_PREFIX_ALL, "postVal");
                // ejemplo de autenticación
                $ldaprdn = "uid=$postVal_nombreUsuario,dc=example,dc=com";     // ldap rdn or dn
                $ldappass = 'password';  // associated password
                // conexión al servidor LDAP
                $ldapconn = ldap_connect("ldap://ldap.forumsys.com", 389) or die("Could not connect to LDAP server.");

                ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);

                if ($ldapconn) {

                    // realizando la autenticación
                    $ldapbind = ldap_bind($ldapconn, $ldaprdn, $ldappass);

                    // verificación del enlace
                    //    var_dump(ldap_first_attribute ($ldapconn));
                    if ($ldapbind) {


                        $_SESSION["idUsuario"] = 1;
                        $_SESSION["idRol"] = 2;
                        $_SESSION["session"] = $postVal_session;
                        $_SESSION["nomUsuario"] = $postVal_nombreUsuario;
                        $title = 'Inició sesión';
                        $renderize = 'initsession';
                        var_dump($ldapbind);
                        var_dump($_SESSION);

                        switch ($_SESSION["idRol"]) {
                            case ROL_ADMINISTRADOR:
                                //die("Hola1");
                                header("Location:" . BASE . 'administrador');
                                break;
                            case ROL_AUTOR:
                                //die("Hola2");
                                header("Location:" . BASE . 'autor');
                                break;
                            case ROL_APROBADOR:
                                //die("Hola3");
                                header("Location:" . BASE . 'aprobador');
                                break;
                        }
                    } else {
                        $this->view->setError("¡No registrado o datos errados!");
                    }
                }
                /* if ($usuData = $this->usuario->inciarSesion($postVal_nombreUsuario, $postVal_clave)->fetch(PDO::FETCH_ASSOC)) {
                  /*$_SESSION['session'] = $postVal_session;
                  $_SESSION["idUsuario"] = $usuData["id_usuario"];
                  $_SESSION["idRol"] = $usuData["id_rol"];
                  $title = 'Inició sesión';
                  $renderize = 'initsession';
                  switch ($usuData['id_rol']) {
                  case ROL_ADMINISTRADOR:
                  header("Location:" . BASE . 'administrador');
                  break;
                  case ROL_AUTOR:
                  header("Location:" . BASE . 'autor');
                  break;
                  case ROL_APROBADOR:
                  header("Location:" . BASE . 'aprobador');
                  break;
                  }
                  }else{
                  $this->view->setError("¡No registrado o datos errados!");
                  } */
            }
        }
        if ($this->sesionIniciada()) {
//            $title = 'Inició sesión';
//            $renderize = 'initsession';
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
