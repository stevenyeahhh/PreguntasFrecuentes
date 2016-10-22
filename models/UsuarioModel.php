<?php

class UsuarioModel extends Model {

    private $idUsuario;
    private $nombre;
    private $apellido;
    private $usuario;
    private $clave;
    private $idRol;
    private $estado;
    private $fechaRegistro;

    public function __construct() {
        parent::__construct();
    }

    public function inciarSesion($usuario, $contrasena) {
        return $this->getDb()->selectQuery(
                        "usuario u", "*", "u.usuario='$usuario' AND  u.clave='" . md5($contrasena) . "' AND u.estado='1'");
    }
/*
    public function registrar() {
        return $this->getDb()->insertQuery("USUARIO", "nombre_usuario,contrasena,nombre,apellidos,numero_identificacion,fecha_nacimiento,id_rol,id_tipo_identificacion,id_genero_usuario,id_cargo_trabajo", "'$this->nombreUsuario','" . md5($this->contrasena) . "','$this->nombre','$this->apellidos','$this->numeroIdentificacion','$this->fechaNacimiento',"
                        . "'$this->idRol','$this->idTipoIdentificacion','$this->idGeneroUsuario','$this->idCargoTrabajo'");
    }

    public function actualizar() {//updateQuery($table, $columnValues, $where)
        return $this->getDb()->updateQuery("USUARIO", "nombre ='$this->nombre',
                apellidos ='$this->apellidos',
                numero_identificacion ='$this->numeroIdentificacion',
                fecha_nacimiento ='$this->fechaNacimiento',
                id_rol ='$this->idRol',
                id_tipo_identificacion ='$this->idTipoIdentificacion',
                id_genero_usuario ='$this->idGeneroUsuario',
                id_cargo_trabajo ='$this->idCargoTrabajo'", "id_usuario='$this->idUsuario'");
    }

    public function getRoles() {
        return $this->getDb()->selectQuery(
                        "ROL r ", "*", "");
    }

    public function selectUsuario() {
        return $this->getDb()->query("SELECT id_usuario,nombre_usuario,contrasena,nombre,apellidos,numero_identificacion,fecha_nacimiento,id_rol,id_tipo_identificacion,id_genero_usuario,id_cargo_trabajo FROM USUARIO");
    }

    public function selectUsuariosParaHabilitar() {
        return Singleton::getInstance()->db->query("SELECT u.id_usuario as u_id_usuario, 
                                                           u.nombre as u_nombre, 
                                                           u.apellidos as u_apellidos, 
                                                           u.numero_identificacion as u_numero_identificacion, 
                                                           ct.id_cargo_trabajo as ct_id_cargo_trabajo,
                                                           ct.nombre as ct_nombre,
                                                           at.id_area_trabajo as at_id_area_trabajo,
                                                           at.nombre as at_nombre
                                                    FROM USUARIO u
                                                    JOIN CARGO_TRABAJO ct ON ct.id_cargo_trabajo = u.id_cargo_trabajo
                                                    JOIN AREA_TRABAJO at ON at.id_area_trabajo = ct.id_area_trabajo
                                                    WHERE u.id_rol = 2");
    }

    public function getUsuarioPorId($id) {
        return Singleton::getInstance()->db->selectQuery("USUARIO "
                        , "id_usuario,nombre_usuario,contrasena,nombre,apellidos,numero_identificacion,fecha_nacimiento,id_rol,id_tipo_identificacion,id_genero_usuario,id_cargo_trabajo"
                        , "id_usuario= '$id'");
    }

    public function getUsuarioPorRol($rol) {
        return Singleton::getInstance()->db->selectQuery("USUARIO u join TIPO_IDENTIFICACION ti ON (ti.id_tipo_identificacion=u.id_tipo_identificacion) JOIN GENERO_USUARIO gu ON(gu.id_genero_usuario=u.id_genero_usuario) JOIN CARGO_TRABAJO ct ON (ct.id_cargo_trabajo=u.id_cargo_trabajo)", "u.id_usuario,u.nombre_usuario,u.nombre,u.apellidos,u.numero_identificacion,u.fecha_nacimiento,ti.nombre tipo_identificacion,gu.nombre genero_usuario,ct.nombre cargo_trabajo,u.estado "
                        , " u.id_rol= '$rol'");
    }

    public function cambiarEstado($id, $estado) {
        return Singleton::getInstance()->db->updateQuery("USUARIO", "estado='$estado'", " id_usuario='$id'");
    }
*/
}
