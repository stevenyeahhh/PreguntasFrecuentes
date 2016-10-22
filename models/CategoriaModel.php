<?php

/**
 * Description of CategoriaModel
 *
 * @author jcaperap
 */
class CategoriaModel extends Model {

    private $idCategoria;
    private $categoria;
    private $estado;
    private $fechaRegistro;

    public function getCategorias() {
        return $this->getDb()->selectQuery(
                        "categoria c", "*", "c.estado='1'");
    }
	public function getIdCategoriaNombre($categoriaName) {
		
        $categoriaId = $this->getDb()->selectQuery(
                        "categoria c",
			"*", 
			"c.estado='1' AND REPLACE( REPLACE( REPLACE( REPLACE( REPLACE( REPLACE( REPLACE( REPLACE( REPLACE( REPLACE( REPLACE( REPLACE( REPLACE( REPLACE( REPLACE( REPLACE( REPLACE( REPLACE( REPLACE( REPLACE( REPLACE( REPLACE( REPLACE( REPLACE( REPLACE( REPLACE( REPLACE( REPLACE( REPLACE( REPLACE( UPPER(TRIM(c.categoria)), 'Ù','U'), 'Ú','U'), 'Û','U'), 'Ü','U'), 'Ý','Y'), 'Ë','E'), 'À','A'), 'Á','A'), 'Â','A'), 'Ã','A'),  'Ä','A'), 'Å','A'), 'Æ','A'), 'Ç','C'), 'È','E'), 'É','E'), 'Ê','E'), 'Ë','E'), 'Ì','I'), 'Í','I'),  'Î','I'), 'Ï','I'), 'Ð','O'), 'Ñ','N'), 'Ò','O'), 'Ó','O'), 'Ô','O'), 'Õ','O'), 'Ö','O'), 'Ø','O') = REPLACE( REPLACE( REPLACE( REPLACE( REPLACE( REPLACE( REPLACE( REPLACE( REPLACE( REPLACE( REPLACE( REPLACE( REPLACE( REPLACE( REPLACE( REPLACE( REPLACE( REPLACE( REPLACE( REPLACE( REPLACE( REPLACE( REPLACE( REPLACE( REPLACE( REPLACE( REPLACE( REPLACE( REPLACE( REPLACE( UPPER(TRIM('$categoriaName')), 'Ù','U'), 'Ú','U'), 'Û','U'), 'Ü','U'), 'Ý','Y'), 'Ë','E'), 'À','A'), 'Á','A'), 'Â','A'), 'Ã','A'),  'Ä','A'), 'Å','A'), 'Æ','A'), 'Ç','C'), 'È','E'), 'É','E'), 'Ê','E'), 'Ë','E'), 'Ì','I'), 'Í','I'),  'Î','I'), 'Ï','I'), 'Ð','O'), 'Ñ','N'), 'Ò','O'), 'Ó','O'), 'Ô','O'), 'Õ','O'), 'Ö','O'), 'Ø','O')")->fetch(PDO::FETCH_ASSOC);
        if (!$categoriaId) {
            $this->categoria=  ucwords(strtolower(str_replace("  ", " ", $categoriaName)));
            return  $this->insertCategoria();
        }else{
            return $categoriaId["id_categoria"];
        }
    }

    public function insertCategoria() {
        $this->getDb()->insertQuery("categoria", "categoria", "'$this->categoria'");
        return $this->getDb()->lastInsertId();
    }

    public function __construct() {
        parent::__construct();
    }

    public function getIdCategoria() {
        return $this->idCategoria;
    }

    public function getCategoria() {
        return $this->categoria;
    }

    public function getEstado() {
        return $this->estado;
    }

    public function getFechaRegistro() {
        return $this->fechaRegistro;
    }

    public function setIdCategoria($idCategoria) {
        $this->idCategoria = $idCategoria;
    }

    public function setCategoria($categoria) {
        $this->categoria = $categoria;
    }

    public function setEstado($estado) {
        $this->estado = $estado;
    }

    public function setFechaRegistro($fechaRegistro) {
        $this->fechaRegistro = $fechaRegistro;
    }

}
