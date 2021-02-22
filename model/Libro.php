<?php
require_once("autoload.php");

class Libro
{
    const TABLA = 'libros_hi';
    private $conect;

    public function __construct()
    {

        $this->conect = DB::getInstance();
        DB::setCharsetEncoding();
    }

    public function getLibro()
    {
        try {
            $sql = "SELECT * FROM " . self::TABLA;
            $stm = $this->conect->prepare($sql);
            $stm->execute();
            return $stm->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            print $e->getMessage();
        }

    }
    public function getLibroOrderTitol()
    {
        try {
            $sql = "SELECT * FROM " . self::TABLA . " ORDER BY titulo";
            $stm = $this->conect->prepare($sql);
            $stm->execute();
            return $stm->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            print $e->getMessage();
        }

    }

    public function getLibroById($id)
    {
        try {
            $sql = "SELECT * FROM " . self::TABLA;
            $sql .= " WHERE id=" . $id;
            $stm = $this->conect->prepare($sql);
            $stm->execute();
            return $stm->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            print $e->getMessage();
        }

    }

    /********* ****** *********/
    /********* INSERT *********/
    /********* ****** *********/

    public function addBook($data)
    {
        try {
            $sql = "INSERT INTO " . self::TABLA . " (titulo, autor, editorial, edicion, ano, date_added) VALUES ";
            $sql .= "(:titulo, :autor, :editorial, :edicion, :ano,:date_added)";
            //print_r($sql);
            $stm = $this->conect->prepare($sql);
            /*            $stm->bindParam(':referencia',$data['referencia'],PDO::PARAM_STR);
                        $stm->bindParam(':pagina',$data['pagina'],PDO::PARAM_STR);
                        $stm->bindParam(':id_libro',$data['id_libro'],PDO::PARAM_STR);
                        $stm->bindParam(':nombre_categoria',$data['nombre_categoria'],PDO::PARAM_STR);
                        $stm->bindParam(':anos',$data['anos'],PDO::PARAM_STR);
                        $stm->bindParam(':contenido',$data['contenido'],PDO::PARAM_STR);
                        $stm->bindParam(':date_added',$data['date_added'],PDO::PARAM_STR);*/

            $stm->execute($data);
            return $this->conect->lastInsertId();
            //return $stm->rowCount();
        } catch (Exception $e) {
            print $e->getMessage();
        }

    }

    public function updateBook($data)
    {
        try {
            $sql = "UPDATE " . self::TABLA . " SET titulo=:titulo, autor=:autor, editorial=:editorial, edicion=:edicion, ano=:ano, date_added=:date_added";
            $sql .= " WHERE id=:id";
            //print_r($sql);
            $stm = $this->conect->prepare($sql);
            $stm = $this->conect->prepare($sql);
            $stm->bindParam(':titulo',$data['titulo'],PDO::PARAM_STR);
            $stm->bindParam(':autor',$data['autor'],PDO::PARAM_STR);
            $stm->bindParam(':editorial',$data['editorial'],PDO::PARAM_STR);
            $stm->bindParam(':edicion',$data['edicion'],PDO::PARAM_STR);
            $stm->bindParam(':ano',$data['ano'],PDO::PARAM_STR);
            $stm->bindParam(':date_added',$data['date_added'],PDO::PARAM_STR);
            $stm->bindParam(':id',$data['id'],PDO::PARAM_INT);
            $stm->execute($data);
            return $stm->rowCount();
        } catch (Exception $e) {
            print $e->getMessage();
        }
    }

    public function delBook($id){
        try {
            $sql = "DELETE FROM " . self::TABLA . " WHERE id = ?";
            $stm = $this->conect->prepare($sql);
            $stm->execute(array($id));
            return $stm->rowCount();

        }catch (Exception $e){
            print $e->getMessage();
        }
    }
}
