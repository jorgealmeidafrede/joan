<?php
require_once("model/Categoria.php");
require_once("model/Contenido.php");
require_once("model/Search.php");
require_once("functions.php");

$tituloPagina = "Buscar - Programa d'Història";
$entradas = new Contenido();


include('templates/header.php');

// $page =(isset($_GET['page'])) ? $_GET['page'] :0;
$busqueda = (isset($_GET['busqueda'])) ? $_GET['busqueda'] : "";
$ano1 = (isset($_GET['ano1'])) ? $_GET['ano1'] : "";
$ano2 = (isset($_GET['ano2'])) ? $_GET['ano2'] : "";
$id_categoria = (isset($_GET['id_categoria'])) ? $_GET['id_categoria'] : "";

$search = new Search($busqueda, $ano1, $ano2, $id_categoria);
$layout = new Layout();

?>
<div id="buscar" class="w-100">
    <!--<div class="col-12">-->

    <?php
    if (!empty($busqueda) or !empty($ano1) or !empty($ano2) or !empty($id_categoria)) {

        $search->search();
        $category = new Categoria();
        $nameCategory = $category->getNombreCategoriaById($id_categoria);
        $entradasBuscadas = $search->getEntradas();
        $cantidadEncontrada = count($search->getEntradas());
        $entryPainted = $search->paintSearch();
        $html = '<div class="row" id="detalle-busqueda" >';
        $html .= '<div class="col-8" id="search-path">';
        $html .= isset($busqueda)?'<span class="border-light font-weight-bold align-top text-08"><i class="fa fa-long-arrow-right" aria-hidden="true"></i> '.$busqueda.'</span>':"";
        $html .= !empty($ano1)?'<span class="align-top text-08"> ~'.$ano1.'</span>':"";
        $html .= !empty($ano2)?'<span class="align-top text-08"> ~'.$ano2.'</span>':"";
        $html .= !empty($nameCategory) ?' ~ <span class="font-italic align-top text-08">'.$nameCategory.'</span>':"";
        $html .='</div>';
        $html .= '<div class="col-4 text-center" id="cantidad-busqueda"><h6 class="">S\'han troba <b>' . $cantidadEncontrada . '</b> coincidències</h6></div>';
        $html .= '</div>';
        echo $html;
        //echo "<h6 id='cantidad-busqueda' class='col-12 text-center'>S'han trobat  <b>" . $cantidadEncontrada . " </b> coincidències</h6>";
        //$entryOrdered = $layout->orderByYears($entryPainted);
        $yearPrint = "";
        $categoryPrint = "";
        foreach ($entryPainted as $entry) {
            /*Año una sola vez*/
            if ($yearPrint != $entry['anos']) {
                $yearPrint = $entry['anos'];
                echo "<h4 class='col-12 font-weight-bold mt-3 mb-0'>" . $yearPrint . "</h4>";
                $categoryPrint = "";
            }
            /*Categoria una sola vez*/
            if ($categoryPrint != $entry['nombre_categoria']) {
                $categoryPrint = $entry['nombre_categoria'];
                echo "<h6 class='col-12 my-2 text-primary'><b>" . $categoryPrint . "</b></h6>";
            }


            echo $layout->simpleEntry($entry);

        }

    } else {
        //$anyActive =
        $page = (isset($_GET['page'])) ? $_GET['page'] : 0;
        paginationAllYear($page);
        //paginationAllYear($_GET['page']);
        //$initialYear = ($_GET['page'] == 0 or !isset($_GET['page'])) ? getFirstYear() : $_GET['page'];
        $initialYear = ($page == 0 or !isset($page)) ? getFirstYear() : $page;
        $rango = 10;
        $yearExist = $entradas->getAnyExisten($initialYear, $initialYear + $rango - 1);
        foreach ($yearExist as $year) {

            echo '<div class="col-12"><h4 class="text-center font-weight-bold">' . $year['anos'] . "</h4></div>";
            $entrada = $entradas->getContenidobyYear($year['anos']);
            $nombreCategoria = "";
            foreach ($entrada as $ent) {
                echo ($nombreCategoria == $ent['nombre_categoria']) ? '' : '<h5 class="col-12 m-0">' . $ent['nombre_categoria'] . '</h5>';
                listEntriesGrupedByYears($ent['nombre_categoria'], $ent['contenido'], $ent['id_libro'], $ent['referencia'], $ent['id']);
                $nombreCategoria = $ent['nombre_categoria'];
            }
        }
    }

    include('templates/footer.php');
    ?>
    <p></p>