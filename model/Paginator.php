<?php
require_once("autoload.php");

class Paginator
{
    /**
     * @var PDO
     */
    private $conect;
    private $_table;
    private $_query; //"SELECT * FROM " . $this->_table;

    private $_range; // 10
    private $_totalEntries;
    private $_page; // 1
    private $_totalPages;


    public function __construct($_table, $_page = 1, $_range = 10, $_query = "")
    {
        $this->conect = DB::getInstance();
        DB::setCharsetEncoding();

        $this->_table = $_table;
        $this->_totalEntries = $this->calculationTotal(); // total de entradas resultado de la  consulta
        $this->_range = $_range; // cantidad de entradas por pagina
        $this->_page = $_page; // pagina actual
        $this->_totalPages = ceil($this->_totalEntries / $this->_range); // cantidad de paginas
        if (empty($_query)) {
            $this->_query = "SELECT * FROM " . $this->_table;
        } else {
            $this->_query = $_query;
        }
        /*            echo "<pre>";
                    echo "(page= ".$this->_page . " - 1 )" . " * " . $this->_range ;
                    echo "</pre>";*/

    }


    public function links()
    {

        $actual="";
        $active ="";
        $html = '<nav aria-label="Page navigation">';
        $html .= '<ul class="pagination">';

        if ($this->_page <= $this->_range) {
            echo " if -> ".$this->_page;
            for ($i = 1; $i <= $this->_range; $i++) {
                $active = $i == $this->_page ? " active " : "";
                $html .= '<li class="page-item' . $active . '"><a class="page-link" href="listar-entradas.php?page='.$i.'">' . $i . '</a></li>';
            }
            $html .= ($i < $this->_totalPages) ? $this->next($i) : "";
        } else {
            echo " page -> ".$this->_page;
            $html .= $this->previous($this->_page - 6);
            for ($i = $this->_page - (($this->_range / 2) ); $i <= $this->_page + ($this->_range /2 ); $i++) {
                if($i == $this->_page){
                    $active = " active ";
                    $actual = $i;
                }
                $active = $i == $this->_page ? " active " : "";
                $html .= '<li class="page-item' . $active . '"><a class="page-link" href="listar-entradas.php?page='.$i.'">' . $i . '</a></li>';
            }
            $html .= ($i < $this->_totalPages) ? $this->next($i) : "";
        }
        $html .= "</ul>";
        $html .= "</nav>";
       // <li class="page-item"><a class="page-link" href="#">1</a></li>

       // $html .= "<p style='color: red'>  ||  " . $this->_totalEntries . " / 10  --->  " . $this->_totalPages . "</p>";
        return $html;
    }

    /**
     * @param int $limit
     * @param int $page
     * @return stdClass
     */
    public function getData()
    {
        try {


            //$limit = 10, $page = 1
            $sql = $this->_query . " LIMIT " . (($this->_page - 1) * $this->_range) . ", $this->_range";
            //print $sql;
            $stm = $this->conect->prepare($sql);
            $stm->execute();

            while ($row = $stm->fetchAll()) {
                $results[] = $row;
            }


            $result = new stdClass();
            $result->page = $this->_page;
            $result->limit = $this->_range;
            $result->total = $this->_total;
            $result->data = $results['0'];

            return $result;
        } catch (Exception $e) {
            print $e->getMessage();
        }
    }

    private function calculationTotal()
    {
        try {
            $sql = "SELECT * FROM " . $this->_table;
            $stm = $this->conect->prepare($sql);
            $stm->execute();

            return $stm->rowCount();

        } catch (Exception $e) {
            print $e->getMessage();
        }
    }

    /**
     * @return mixed
     */
    public function getTotal()
    {
        return $this->_total;
    }

    private function next($id)
    {

        return '<li class="page-item">
      <a class="page-link" href="listar-entradas.php?page=' . $id . '" aria-label="Next">
        <span aria-hidden="true">&raquo;</span>
        <span class="sr-only">Next</span>
      </a>
    </li>';

    }

    private function previous($id)
    {

        return '<li class="page-item">
      <a class="page-link" href="listar-entradas.php?page=' . $id . '" aria-label="Previous">
        <span aria-hidden="true">&laquo;</span>
        <span class="sr-only">Previous</span>
      </a>
    </li>';

    }
}

/*<nav aria-label="Page navigation example">
  <ul class="pagination">
    <li class="page-item">
      <a class="page-link" href="#" aria-label="Previous">
        <span aria-hidden="true">&laquo;</span>
        <span class="sr-only">Previous</span>
      </a>
    </li>
    <li class="page-item"><a class="page-link" href="#">1</a></li>
    <li class="page-item"><a class="page-link" href="#">2</a></li>
    <li class="page-item"><a class="page-link" href="#">3</a></li>

  </ul>
</nav>*/