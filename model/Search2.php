<?php
require_once("autoload.php");

class Search2
{
    private $conect;
    private $contenido;
    private $year1;
    private $year2;
    private $idCategoria;
    private $modelContenido;
    private $entradasBuscadas = array();
    private $wantedS;

    public function __construct()
    {
        $this->conect = DB::getInstance();
        DB::setCharsetEncoding();
        $this->modelContenido = new Contenido();
    }

    /**
     * @return mixed
     */
    public function getWantedS()
    {
        return $this->wantedS;
    }

    /**
 * @return array
 */
    public function getEntradasBuscadas()
    {
        return $this->entradasBuscadas;
    }

    /**
     * @param mixed $idCategoria
     * @return Search
     */
    public function setIdCategoria($idCategoria)
    {
        $this->idCategoria = $idCategoria;
        return $this;
    }

    /**
     * @param mixed $contenido
     * @return Search
     */
    public function setContenido($contenido)
    {
        $this->contenido = $contenido;
        return $this;
    }

    /**
     * @param mixed $year1
     * @return Search
     */
    public function setYear1($year1)
    {
        $this->year1 = $year1;
        return $this;
    }

    /**
     * @param mixed $year2
     * @return Search
     */
    public function setYear2($year2)
    {
        $this->year2 = $year2;
        return $this;
    }

public function search (){

    $wantedS = $this->buscarSeparador();
    $initialYear = $this->year1;
    $finalYear = $this->year2;
    $idCategoria = $this->idCategoria;

    if (empty($wantedS)){
        $this->entradasBuscadas[] = $this->modelContenido->wantedInContenido($wantedS ,$initialYear , $finalYear , $idCategoria );
    }else {
        foreach ($wantedS as $wanted){
            $this->entradasBuscadas[] = $this->modelContenido->wantedInContenido($wanted ,$initialYear , $finalYear , $idCategoria );
        }
    }


/*    echo "<pre>";
    print_r(count($entradaBuscada['0']));
    echo "</pre>";*/
}



    private function buscarSeparador()
    {
        $this->wantedS = array();
      if (!empty($this->contenido)){


        $separados = explode("+", $this->contenido);
         print_r($this->contenido);
        foreach ($separados as $separado){
            $this->wantedS[] = trim($separado);
        }
      }
              return $this->wantedS ;
    }

    /**
     * @param $indexType
     * @param $columnName
     * @return bool
     */
    private function checkIndexType($indexType, $columnName)
    {
        $sql = "SHOW INDEX FROM contenido_hi ";
        $stm = $this->conect->prepare($sql);
        $stm->execute();
        foreach ($stm->fetchAll() as $index) {
            if ($index['Index_type'] == $indexType and $index['Column_name'] == $columnName) {
                return true;
            }
        }
        return false;
    }//checkIndexType
}//SEARCH