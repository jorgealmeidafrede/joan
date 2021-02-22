<?php
require_once("autoload.php");

class Categoria
{
    private $nombre;
    private $date_added;
    const TABLE = 'categorias_hi';
    private $conect;

    public function __construct()
    {

        $this->conect = DB::getInstance();
        DB::setCharsetEncoding();
    }

    public function getCategoria(){
        try {
            $sql ="SELECT * FROM " .self::TABLE . " ORDER BY nombre";
            $stm = $this->conect->prepare($sql);
            $stm->execute();
            return $stm->fetchAll(PDO::FETCH_ASSOC);
        }catch (Exception $e){
            print $e->getMessage();
        }

    }

    public function getNombreCategoriaById($id){
        try {
            $sql ="SELECT nombre FROM " . self::TABLE . " WHERE id=" . $id ;
            $stm = $this->conect->prepare($sql);
            $stm->execute();
            $data = $stm->fetchAll(PDO::FETCH_ASSOC);
            return $data[0]['nombre'];
        }catch (Exception $e){
            print $e->getMessage();
        }

    }

    public function addCategory($nameCategory){

        try{
            $sql = "INSERT INTO " . self::TABLE . "(nombre) VALUES (:nombre)";
            $stm = $this->conect->prepare($sql);
            $stm->execute($nameCategory);
            return $this->conect->lastInsertId();
        }catch (Exception $e){
            print $e->getMessage();
        }
}

    public function updateCategory($category)
    {
        try{
            $sql = "UPDATE " . self::TABLE . " SET nombre=:nombre WHERE id=:id ";
            //print_r($sql);
            $stm = $this->conect->prepare($sql);
            $stm->execute($category);
            return $stm->rowCount();
        }catch (Exception $e){
            print $e->getMessage();
        }
    }

    public function deleteCategory($idCategory)
    {
        try{
            $sql = "DELETE FROM " . self::TABLE . " WHERE id=:id ";
            //print_r($sql);
            $stm = $this->conect->prepare($sql);
            $stm->execute(array("id" => $idCategory));
            return $stm->rowCount();
        }catch (Exception $e){
            print $e->getMessage();
        }
    }

}

/*$query = "SELECT * FROM contenido_hi
								where id_categoria='$id_categoria'
								ORDER BY anos";*/