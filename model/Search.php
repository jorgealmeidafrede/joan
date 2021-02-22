<?php
require_once("autoload.php");

class Search
{
    private $conect;
    private $quest;
    private $year1;
    private $year2;
    private $idCategory;
    private $modelContenido;
    private $entradas = array();

    public function __construct($quest = "", $year1 = "", $year2 = "", $idCategory = "")
    {
        $this->conect = DB::getInstance();
        DB::setCharsetEncoding();
        $this->modelContenido = new Contenido();
        $this->quest = $quest;
        $this->year1 = $year1;
        $this->year2 = $year2;
        $this->idCategoria = $idCategory;
    }

    /**
     * @return array
     */
    public function getEntradas()
    {
        return $this->entradas;
    }


    public function search()
    {
        $multipleSearch = $this->multipleSearch();


        if ($multipleSearch) {

            $sql = "SELECT * FROM contenido_hi WHERE contenido LIKE";

            for ($i = 0; $i < count($multipleSearch); $i++) {
                $sql .= ' "%' . $multipleSearch[$i] . '%" ';
                $sql .= $i < count($multipleSearch) - 1 ? ' AND contenido LIKE ' : '';
            }
            if (!empty($this->year1) and empty($this->year2)) {
                $sql .= ' AND anos =' . $this->year1;
            } elseif (empty($this->year1) and !empty($this->year2)) {
                $sql .= ' AND anos =' . $this->year2;
            } elseif (!empty($this->year1) and !empty($this->year2)) {
                $sql .= ' AND anos >=' . $this->year1 . ' AND anos <=' . $this->year2;
            }
            $sql .= empty($this->idCategoria) ? '' : ' AND id_categoria <=' . $this->idCategoria;


        } else {
            $sql = 'SELECT * FROM contenido_hi';

            if (!empty($this->quest)) {
                $sql .= ' WHERE contenido LIKE "%' . $this->quest . '%" ';

                if (!empty($this->year1) and empty($this->year2)) {
                    $sql .= ' AND anos =' . $this->year1;
                } elseif (empty($this->year1) and !empty($this->year2)) {
                    $sql .= ' AND anos =' . $this->year2;
                } elseif (!empty($this->year1) and !empty($this->year2)) {
                    $sql .= ' AND anos >=' . $this->year1 . ' AND anos <=' . $this->year2;
                }
                $sql .= empty($this->idCategoria) ? '' : ' AND id_categoria <=' . $this->idCategoria;
            }else {
                if (!empty($this->year1) and empty($this->year2)) {
                    $sql .= ' WHERE anos =' . $this->year1;
                } elseif (empty($this->year1) and !empty($this->year2)) {
                    $sql .= ' WHERE anos =' . $this->year2;
                } elseif (!empty($this->year1) and !empty($this->year2)) {
                    $sql .= ' WHERE anos >=' . $this->year1 . ' AND anos <=' . $this->year2;
                }

            if(empty($this->year1) and empty($this->year2) AND !empty($this->idCategoria)){
                $sql .= ' WHERE id_categoria =' . $this->idCategoria;
            }else{
                $sql .= empty($this->idCategoria) ? '' : ' AND id_categoria =' . $this->idCategoria;
            }
        }
        }
        try {
            $sql .= " ORDER BY anos, nombre_categoria, contenido";
            //echo "<pre>".$sql."</pre>";
            $stm = $this->conect->prepare($sql);
            $stm->execute();
            $this->entradas = $stm->fetchAll();
        } catch (Exception $e) {
            print $e->getMessage();
        }
    }//function search


    private function multipleSearch()
    {
        if (strstr($this->quest, "+")) {
            return explode("+", $this->quest);
        }
        return false;
    }

    public function paintSearch()
    {
        if (!empty($this->quest)) {
            $entryPaint = array();
            foreach ($this->entradas as $entrada) {
                if ($this->multipleSearch()) {
                    foreach ($this->multipleSearch() as $simpleSearch) {
                        $entrada['contenido'] = $this->highlightWords($entrada['contenido'], $simpleSearch);
                    }
                } else {
                    $entrada['contenido'] = $this->highlightWords($entrada['contenido'], $this->quest);
                }
                $entryPaint[] = $entrada;
            }
            return $entryPaint;
        }
        return $this->entradas;
    }//paintSearch

    // Highlight words in text
    private function highlightWords($text, $word)
    {
        $text = preg_replace('#' . preg_quote($word) . '#i', '<span class="hlw">\0</span>', $text);
//        echo ($word);
        //      echo($text);
        return $text;
    }

}//SEARCH