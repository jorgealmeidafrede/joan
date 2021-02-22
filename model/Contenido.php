<?php
require_once("autoload.php");

class Contenido
{
    private $nombre;
    private $date_added;
    const TABLA = 'contenido_hi';
    private $conect;

    public function __construct()
    {

        $this->conect = DB::getInstance();
        DB::setCharsetEncoding();
    }

    /**
     * @param $idCategoria
     * @return array
     */
    public function getContenidoByCategoria($idCategoria)
    {
        try {
            $sql = "SELECT * FROM " . self::TABLA . " WHERE id_categoria = " . $idCategoria . " ORDER BY anos";
            $stm = $this->conect->prepare($sql);
            $stm->execute();
            return $stm->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            print $e->getMessage();
        }
    }

    /**
     * @param $idEntrada
     * @return array
     */
    public function getEntradaById($idEntrada)
    {
        try {
            $sql = "SELECT * FROM " . self::TABLA . " WHERE id = " . $idEntrada;
            $stm = $this->conect->prepare($sql);
            $stm->execute();
            return $stm->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            print $e->getMessage();
        }

    }
    /***************************/
    /********* YEARS  *********/
    /***************************/
    /**
     * @return mixed
     */
    public function getFirstYear()
    {
        $sql = "SELECT anos FROM " . self::TABLA . " ORDER BY anos ASC LIMIT 1";
        $stm = $this->conect->prepare($sql);
        $stm->execute();
        return $stm->fetch();
    }

    /**
     * @return mixed
     */
    public function getLastYear()
    {
        $sql = "SELECT anos FROM " . self::TABLA . " ORDER BY anos DESC LIMIT 1";
        $stm = $this->conect->prepare($sql);
        $stm->execute();
        return $stm->fetch();
    }


    public function getContenidoByYears($firstYear, $lastYear)
    {
        try {
            //SELECT * FROM contenido_hi WHERE anos>= 1800 AND anos <=1820 ORDER BY anos
            $sql = "SELECT * FROM " . self::TABLA . " WHERE anos >= " . $firstYear . " AND anos <= " . $lastYear . " ORDER BY anos";
            $stm = $this->conect->prepare($sql);
            $stm->execute();
            $years = $stm->fetch(PDO::FETCH_ASSOC);
            return $years;
        } catch (Exception $e) {
            print_r($e);
        }
    }

    /**
     * @param $idCategoria
     * @return array
     */
    public function getContenidobyYear($year)
    {
        try {
            $sql = "SELECT * FROM " . self::TABLA . " WHERE anos = " . $year . " ORDER BY id_categoria";
            $stm = $this->conect->prepare($sql);
            $stm->execute();
            $contenido = $stm->fetchAll(PDO::FETCH_ASSOC);
            return $contenido;
        } catch (Exception $e) {
            print $e->getMessage();
        }
    }

    public function getAnyExisten($initialYear = "1800", $finalYear = "")
    {
        try {
            $sql = "SELECT DISTINCT anos FROM " . self::TABLA;
            $sql .= empty($initialYear) ? "" : " WHERE anos>=" . $initialYear;
            $sql .= empty($finalYear) ? "" : " AND anos <= " . $finalYear . " ORDER BY anos ";
            $stm = $this->conect->prepare($sql);
            $stm->execute();
            $anyExisten = $stm->fetchAll(PDO::FETCH_ASSOC);
            return $anyExisten;
        } catch (Exception $e) {
            print $e->getMessage();
        }

    }
    /********* ****** *********/
    /********* Buscador *********/
    /********* ****** *********/

    public function wantedInContenido($wanted = "", $initialYear = "", $finalYear = "", $idCategoria = "")
    {

        try {

            if (empty($wanted)) {
                $sql = "SELECT * FROM " . self::TABLA;
                if (!empty($initialYear)) {
                    $sql .= " WHERE anos>=" . $initialYear;
                    if (!empty($finalYear)) {
                        $sql .= " AND anos<=" . $finalYear;
                    };
                    if (!empty($idCategoria)) {
                        $sql .= " AND id_categoria = " . $idCategoria;
                    }
                } else {
                    if (!empty($finalYear)) {
                        $sql .= " WHERE anos<=" . $finalYear;
                        if (!empty($idCategoria)) {
                            $sql .= " AND id_categoria = " . $idCategoria;
                        }
                    } else {
                        if (!empty($idCategoria)) {
                            $sql .= " WHERE id_categoria = " . $idCategoria;
                        }
                    }

                }

            } else {
/*                echo "<pre>";
                    print_r($wanted);
                echo "</pre<hr>";*/
                $sql = "SELECT * FROM " . self::TABLA . " WHERE contenido LIKE '% " . $wanted . " %'";
                $sql .= empty($initialYear) ? "" : " AND anos>=" . $initialYear;
                $sql .= empty($finalYear) ? "" : " AND anos <= " . $finalYear;
                $sql .= empty($idCategoria) ? "" : " AND id_categoria = " . $idCategoria;
            }
            echo "<p>".$sql."</p>";
            $stm = $this->conect->prepare($sql);
            $stm->execute();
           // $anyExisten = $stm->fetchAll(PDO::FETCH_ASSOC);
            return $stm->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            print $e->getMessage();
        }

    }

    /**
     * @param $idEntrada
     * @return array
     */
    public function updateEntrada($data)
    {
        try {
            $sql = "UPDATE " . self::TABLA . " SET referencia=:referencia, pagina=:pagina, id_libro=:id_libro, id_categoria=:id_categoria, " .
                "nombre_categoria=:nombre_categoria, anos=:anos, contenido=:contenido, date_added=:date_added" .
                " WHERE id=:id";
            $stm = $this->conect->prepare($sql);
            $stm->bindParam(':referencia', $data['referencia'], PDO::PARAM_STR);
            $stm->bindParam(':pagina', $data['pagina'], PDO::PARAM_STR);
            $stm->bindParam(':id_libro', $data['id_libro'], PDO::PARAM_STR);
            $stm->bindParam(':nombre_categoria', $data['nombre_categoria'], PDO::PARAM_STR);
            $stm->bindParam(':anos', $data['anos'], PDO::PARAM_STR);
            $stm->bindParam(':contenido', $data['contenido'], PDO::PARAM_STR);
            $stm->bindParam(':date_added', $data['date_added'], PDO::PARAM_STR);
            $stm->bindParam(':id', $data['id'], PDO::PARAM_INT);

            $stm->execute($data);

            return $stm->rowCount();
        } catch (Exception $e) {
            print $e->getMessage();
        }

    }

    public function addEntrada($data)
    {
        try {
            $sql = "INSERT INTO " . self::TABLA . " (referencia, pagina, id_libro, id_categoria, nombre_categoria, anos, contenido, date_added) VALUES ";
            $sql .= "(:referencia, :pagina, :id_libro, :id_categoria, :nombre_categoria, :anos, :contenido, :date_added)";
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

    public function deleteEntrada($idEntrada)
    {
        try {
            $sql = " DELETE FROM " . self::TABLA . " WHERE id=:id";
            $stm = $this->conect->prepare($sql);
            $stm->execute(array('id' => $idEntrada));
            return $stm->rowCount();

        } catch (Exception $e) {
            print $e->getMessage();
        }
    }

    public function getEntradas()
    {
        try {
            $sql = "SELECT * FROM ". self::TABLA ;
            $stm = $this->conect->prepare($sql);
            $stm->execute();

            return $stm->fetchAll();
        }catch (Exception $e){
            print $e->getMessage();
        }
    }
}