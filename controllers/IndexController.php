<?php
class IndexController extends Controller {
    private $usuario;//los modelos se guardan en models/[nombre modelo]

    public function __construct() {        
        parent::__construct();
        $this->usuario = $this->loadModel("Usuario");//Para iniciar el modelo, ejemplo de uso de módelo, controller/EmpresaController.php
        if ($this->sesionIniciada()) {
             switch ($_SESSION["idRol"]){
                case ROL_ADMINISTRADOR:
                    header("Location:" . BASE .  'administrador');
                    break;
                case ROL_USUARIO_SECUNDARIO:
                    header("Location:" . BASE .  'usuarioSecundario');
                    break;
            }
            
        }
    }

    public function index() {
        $title="Bienvenido a Save";
        $renderize="index";
        $validar = $this->validar(array_merge(array(
            'nombreUsuario' => array('required' => true),
            'contrasena' => array('required' => true),
        )));        
        if($_POST){
            $validar->setValores($_POST);            
            if ($validar->validarServidor()) {                
                extract($_POST);
//                var_dump($this->usuario->inciarSesion($nombreUsuario,$contrasena)->fetchAll(PDO::FETCH_ASSOC));
                if($infoUsuario=$this->usuario->inciarSesion($nombreUsuario,$contrasena)->fetch(PDO::FETCH_ASSOC)){
                    $_SESSION["idUsuario"]=$infoUsuario["id_usuario"]; 
                    $_SESSION["idRol"]=$infoUsuario["id_rol"]; 
                    switch ($infoUsuario["id_rol"]){
                        case ROL_ADMINISTRADOR:
                            header("Location:" . BASE .  'administrador');
                            break;
                        case ROL_USUARIO_SECUNDARIO:
                            header("Location:" . BASE .  'usuarioSecundario');
                            break;
                    }   
                }else{
                    $this->view->setError("¡No registrado o datos errados!");
                }        
            }
        }
        $this->view->setValidacion($validar->getCamposJSON());
        $this->view->setTitle($title);
        $this->view->renderize($renderize);
    }
    
//    public function desactivarIndex() {
//    Funci? para deshabilitar registros a trav? de la tabla con el bootstrap.switch ejemplo en views/index/index.phtml
//        extract($_POST);//        
//        die($this->bodega->cambiarEstado($usuario,$estado)? "?ito al " . (($estado) ? "activar" : "desactivar") . "  la bodega '$usuario'" : "No se pudo actualizar la bodega");
//        
//    }
    public function reporte($excel=false) {
        $data=array('a' => 1, 'b' => 2, 'c' => 3, 'd' => 4, 'e' => 5);
        if ($excel == 1) {
            $this->exportExcel($data, "Título", "Nombre del archivo");//La funci? exportExcel, permite exportar arreglos tal y como se env?
        }else{
            $this->view->setParams(json_encode($data),"json_object");
            $this->view->renderize('report');
        }
        
    }
}