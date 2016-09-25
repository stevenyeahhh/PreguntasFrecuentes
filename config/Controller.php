<?php

abstract class Controller {

    protected $view;
                
    abstract public function index();

    public function __construct() {
        session_start();
        $this->view = new View(Singleton::getInstance()->r->getController());
        $menu = array();
        if ($this->sesionIniciada()) {
            switch ($this->getRol()) {
                case ROL_AUTOR:
                    $this->crearMenu($menu, "pregunta/generar", 'Generar pregunta');
                    $this->crearMenu($menu, "publicacion/modificar", 'Modificar Publicación');
                    break;
                case ROL_USUARIO_SECUNDARIO:
                    $this->crearMenu($menu, "usuarioSecundario/listarEleccionesActivas", 'Listar elecciones activas');                    
                    break;                
                default:
                    break;
            }
            $this->crearMenu($menu, "utilities/logout", 'Cerrar sesión ');
            
        }else{
            $this->crearMenu($menu, "index/iniciar", 'Iniciar sesión');
            $this->crearMenu($menu, "pregunta/buscar", 'Buscar Pregunta-Respuesta');
        }
            $this->view->setMenu($menu);
    }

    public function loadModel($model) {

        $model = $model . 'Model';
        if (is_readable($controllerPath = ROOT . 'models' . DS . $model . '.php')) {
            include_once $controllerPath = ROOT . 'models' . DS . $model . '.php';
            return new $model;
        }
    }

    public function sesionIniciada() {
        return isset($_SESSION['session']);
    }

    public function getSesionVar($name) {
        return $_SESSION[$name];
    }

    public function cerrarSesion() {
        session_destroy();
    }

    public function getRol() {
        return $_SESSION["idRol"];
    }

    public function crearMenu(&$menu, $url, $descripcion) {
        $menu[] = array('url' => BASE . $url,
            'descripcion' => $descripcion);
    }

    public function showConstructMsg() {
        die("En construcción");
    }

    public function redirigirARol() {
        switch ($this->getSesionVar("ID_ROL")) {
            case ROL_ADMINISTRADOR:
                header("Location:" . BASE . DS . 'administrador' . DS);
                break;
            case ROL_CLIENTE:
                header("Location:" . BASE . DS . 'cliente' . DS);
                break;
            case ROL_REPARTIDOR:
                header("Location:" . BASE . DS . 'repartidor' . DS);
                break;

            default:
                header("Location:" . BASE . DS . 'index' . DS);

                break;
        }
    }

    public function validar($data) {
        include ROOT . 'config' . DS . 'Validador.php';
        $validador = new Validador();
        $validador->setCampos($data);
        return $validador;
    }

    public function exportExcel($data, $title, $filename) {
        /**
         * Funci�n para exportar a excel a partir de un excel
         * @param array $data <b>Arreglo con la informaci�n que va a ir en el excel
         * </b>
         */
        $hoy = new DateTime();
        ob_clean();
        include ROOT . 'config' . DS . 'Classes' . DS . 'PHPExcel.php';
        header('Content-Disposition: attachment; filename="'.$filename. ($hoy->getTimestamp())  .'.xls"');
        header('Content-Type: application/vnd.ms-excel');
        $objPHPExcel = new PHPExcel;
        $objPHPExcel = new PHPExcel();
        $worksheet = $objPHPExcel->getActiveSheet();
        $worksheet->setCellValueByColumnAndRow(0, 1, "Hola ");
        $worksheet->setCellValueByColumnAndRow(0, 1, "$title: ");
        $worksheet->getStyle("A1")->getFont()->setBold(true)->setSize(16);
        foreach (range('A', "Z") as $col) {
            $objPHPExcel->getActiveSheet()
                    ->getColumnDimension($col)
                    ->setAutoSize(true);
        }
        $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow();        
        $row = 3;//Column names
        foreach ($data as $key => $value) {
            $columnHeader = 0;
            foreach ($value as $key2 => $value2) {
                $worksheet->setCellValueByColumnAndRow($columnHeader, $row, $key2);
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($columnHeader, $row)->getFont()->setBold(true);
                $columnHeader++;
            }
        }
        $row = 4;//Data
        foreach ($data as $key => $value) {
            $column = 0;
            foreach ($value as $key2 => $value2) {
                $worksheet->setCellValueByColumnAndRow($column, $row, $value2);
                $column++;
            }
            $row++;
        }
        $objPHPExcel->setActiveSheetIndex(0);       
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }
    public function redirigir($url) {
        echo "<script>window.location.href='$url'</script>";
    }

    /*IntSoftw - Pass en Correo - Inicio*/
    public function enviarPassPorCorreo($nombre, $apellido, $userName, $email, $newPass){

        // require '../libs/phpmailer/PHPMailerAutoload.php';
        require ROOT . 'libs' . DS . 'phpmailer' . DS . 'PHPMailerAutoload.php';
        
        /*--------------------------------------------------------------------------------*/
        $urlSave = "http://localhost/";
        $base_email = "infoincocredito@gmail.com";
        $base_pass = "incocredito2015";

        $mail = new PHPMailer;

        //$mail->SMTPDebug = 3;                             // Enable verbose debug output
        $mail->isSMTP();                                    // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com';             // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                             // Enable SMTP authentication
        $mail->Username = $base_email;      // SMTP username
        $mail->Password = $base_pass;                // SMTP password
        $mail->SMTPSecure = 'tls';                          // Enable TLS encryption, 
        $mail->Port = 587;                                  // TCP port to connect to

        $mail->setFrom($base_email, 'Info Save');
        $mail->addAddress($email, $nombre);     // Add a recipient

        /*--------------------------------------------------------------------------------*/
        $html = "<!DOCTYPE html>";
        $html .= "<html>";
        $html .= "<meta content=\"text/html; charset=utf-8\" http-equiv=\"Content-Type\">";
        $html .= "<meta content=\"width=device-width, initial-scale=1\" name=\"viewport\">";
        $html .= "<head>";
        $html .= "<link href=\"https://fonts.googleapis.com/css?family=Montserrat\" rel=\"stylesheet\" type=\"text/css\">";
        $html .= "</head>";
        $html .= "<body style=\"margin: 0 auto; width: 100%; font-family: 'Montserrat', sans-serif; margin: 0 auto;\">";
        $html .= "<table style=\"text-align: center; width: 650px; display:block;\">";
        $html .= "<tbody style=\"display:block;\">";
        $html .= "<tr style=\"height: 107px; line-height: 80px; background: #34495e; display:block;\">";
        $html .= "<td style=\"width:100%; display:block;\">";
        $html .= "<h1 style=\"font-size: 25px; font-weight: normal; background: none; color: #fff; display:block;\">";
        $html .= "Hola, bienvenido a ";
        $html .= "<a style=\"color: #fff; font-weight: 700; background: none; font-style: italic;\">";
        $html .= "Save";
        $html .= "</a>";
        $html .= "</h1>";
        $html .= "</td>";
        $html .= "</tr>";
        $html .= "<tr style=\"background: #2c3e50; height:10px; display:block;\">";
        $html .= "<td style=\"width:100%; display:block;\">";
        $html .= "</td>";
        $html .= "</tr>";
        $html .= "<tr style=\"display:block; width:100%;\">";
        $html .= "<td style=\"text-align: justify; padding: 20px 120px; display:block;\">";
        $html .= "<p style=\"display:block;\">Hola ". $nombre ." te damos la bienvenida a la plataforma de Save, para poder ingresar a la aplicaci&oacute;n deber&aacute;s identificarte con los datos descritos en este correo. </p>";
        $html .= "<center>  ";
        /*--------------------------------------------------------------------------------*/
        $html .= "<p>Usuario: <a style=\"color: #22A7F0; font-weight: 700;\">";
        $html .= $userName;     //NOMBRE USUARIO
        $html .= "</a> </p>";
        $html .= "<p>Contrase&ntilde;a: <a style=\"color: #22A7F0; font-weight: 700;\">";
        $html .= $newPass;      //CONTRASEÑA
        $html .= "</a> </p>";
        /*--------------------------------------------------------------------------------*/
        $html .= "<br />";
        $html .= "<a href=\"". $urlSave ."\" target=\"_blanc\" style=\"background: #3498db; padding: 10px; border-radius: 7px; text-align: center; border-bottom: 4px solid #34495e; text-decoration: none; color: #fff;\">Ir a la plataforma</a>";
        $html .= "</center>";
        $html .= "<br />";
        $html .= "<p style=\"font-style: italic;\">Si este correo no es para ti, haz caso omiso al mismo. </p>";
        $html .= "</td>";
        $html .= "</tr>";
        $html .= "<tr style=\"height: 70px; line-height: 70px; background-color: #555; color:#ccc; display:block; font-size: smaller;\">";
        $html .= "<td style=\"width:100%; display:block;\">";
        $html .= "<span style=\"background: none;\">Proyecto SAVE todos los derechos reservados</span>";
        $html .= "</td>";
        $html .= "</tr>";
        $html .= "<tr style=\"background: #333; height:5px; display:block;\">";
        $html .= "<td style=\"width:100%; display:block;\">";
        $html .= "</td>";
        $html .= "</tr>";
        $html .= "</tbody>";
        $html .= "</table>";
        $html .= "</body>";
        $html .= "</html>";
        /*--------------------------------------------------------------------------------*/
        $MensajeAlterno = "No se ha podido cargar el mensaje completo. Para acceder a la aplicacion por favor ingrese a http://www.proyectosave.com/ y ingrese sus datos. Su nueva contraseña es: ". $newPass . " Si tiene algun problema al iniciar, por favor contactese con el administrador.";
        /*--------------------------------------------------------------------------------*/

        $mail->isHTML(true);                                  // Set email format to HTML

        $mail->Subject = htmlspecialchars('Bienvenido '. $nombre .' a Save.com');
        $mail->Body    = $html; 
        $mail->AltBody = $MensajeAlterno;

        if(!$mail->send()) {
            // echo 'El correo no pudo ser enviado.';
            // echo 'PHPMailer Error: ' . $mail->ErrorInfo;
            return false;
        } else {
            // echo 'Mensaje enviado correctamente.';
            return true;
        }

    }
    /*IntSoftw - Pass en Correo - Fin*/

}