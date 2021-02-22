<?php
require_once("model/Categoria.php");
require_once("model/Contenido.php");
require_once("model/Search.php");
require_once("functions.php");

$tituloPagina = "Buscar - Programa d'Història";
$entradas = new Contenido();
$search = new Search();

include('templates/header.php');


$busqueda = trim($_GET['busqueda']);
$ano1 = $_GET['ano1'];
$ano2 = $_GET['ano2'];
$id_categoria = $_GET['id_categoria'];

$search->setContenido($busqueda); // texto buscado
$search->setIdCategoria($id_categoria);
$search->setYear1($ano1);
$search->setYear2($ano2);

?>
<div class="col-12">

    <?php
    if (!empty($busqueda) or !empty($ano1) or !empty($ano2) or !empty($id_categoria)) {


        $search->search();
        $resaltado = $search->getWantedS();
        $entradasBuscadas = $search->getEntradasBuscadas();
        $cantidadEncontrada = count($search->getEntradasBuscadas()[0]);
        echo "<h3>S'han trobat  <b>" . $cantidadEncontrada . " </b> coincidències</h3>";
        $entradasBuscadasOrdenadas = orderByYears($entradasBuscadas['0']);
/*        echo "<pre> $entradasBuscadasOrdenadas ->";
        print_r($entradasBuscadasOrdenadas);
        echo "</pre>";*/
        foreach ($entradasBuscadasOrdenadas as $entradaBuscada) {
/*        echo "<pre>";
      print_r($resaltado);
        echo "</pre><hr>";*/
            maquetarEntradasBuscadas($entradaBuscada, $resaltado);
        }

    } else {
        paginationAllYear($_GET['page']);
        $initialYear = ($_GET['page'] == 0 or !isset($_GET['page'])) ? getFirstYear() : $_GET['page'];
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
    <div class="card ">
        <div class="card-body py-1">
        </div>
    </div>
</div>
