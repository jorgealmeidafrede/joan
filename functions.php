<?php
date_default_timezone_set('Europe/Madrid');
require_once("model/Contenido.php");


/**
 * @param $lista
 */
function sidebarCategorias($lista)
{

    foreach ($lista as $valor) {
        echo '<a href="categoria.php?id=' . $valor['id'] . '" class="px-1 py-2 list-group-item list-group-item-action">' . $valor['nombre'] . '</a>';
    }

}

/**
 * @param $lista
 */
function sidebarCategoriasEditar($lista)
{

    foreach ($lista as $valor) {
        echo '<li class="list-group-item p-2">';

            echo '<a class="mr-2" href="#" aria-label="Settings" onClick="showUpdateCategory(this)" id="' . $valor['id'] . '" data-nombre = "' . $valor['nombre'] . '">
                                <i class="fa fa-edit" aria-hidden="true"></i>
                            </a>';

        echo '<a id="categoria-' . $valor['id'] . '" href="categoria.php?id=' . $valor['id'] . '" class="list-group-item-action float-right d-block w-90" title="Veure entrades">' . $valor['nombre'] . '</a>';
        echo '</li>';
    }
}

/**
 * @param $lista
 * @param $idSelected
 */
function selectLibro($idSelected ="")
{
    $libros = new Libro();
    $listaLibros = $libros->getLibro();

    foreach ($listaLibros as $libro) {
        $selected = $libro['id'] == $idSelected ? "selected" : "";
        $recortado = (strlen($libro['titulo']) > 100) ? " ..." : "";
        echo '<option ' . $selected . ' value="' . $libro['id'] . '">' . $libro['id'] . ' > ' . substr($libro['titulo'], 0, 100) . $recortado . '</option>';
    }
}
function selectLibroOrderTitol($idSelected ="")
{
    $libros = new Libro();
    $listaLibros = $libros->getLibroOrderTitol();

    foreach ($listaLibros as $libro) {
        $selected = $libro['id'] == $idSelected ? "selected" : "";
        $recortado = (strlen($libro['titulo']) > 100) ? " ..." : "";
        echo '<option ' . $selected . ' value="' . $libro['id'] . '">' . $libro['id'] . ' > ' . substr($libro['titulo'], 0, 100) . $recortado . '</option>';
    }
}

/**
 * @param $lista
 * @param $idSelected
 */
function selectCategoria($idSelected = "")
{
    $categoria = new Categoria();
    $categorias = $categoria->getCategoria();
    foreach ($categorias as $cat) {
        $selected = $cat['id'] == $idSelected ? "selected" : "";
        echo '<option ' . $selected . ' value="' . $cat['id'] . '"> - ' . $cat['nombre'] . '</option>';
    }
}

/**
 * @param string $anySelected
 */
function selectAnyExisten()
{
    $contenido = new Contenido();
    $anys = $contenido->getAnyExisten();
    foreach ($anys as $any) {
        echo '<option value="' . $any['anos'] . '">' . $any['anos'] . '</option>';
    }

}

/**
 * @param string $anySelected
 */
function selectAny($anySelected = "")
{
    for ($i = 1800; $i <= 2030; $i++) {
        $selected = ($i == $anySelected) ? "selected" : "";
        echo '<option ' . $selected . ' value="' . $i . '">' . $i . '</option>';
    }
}


function cambiarCaracteres($haystack)
{
    $caracteres = ['Ã³', 'Ã', 'Ã¨', 'Ã©', 'Ã¼', 'Ã '];
    foreach ($caracteres as $caracter) {
        if (strpos($haystack, $caracter)) {
            $haystack = utf8_decode($haystack);
        }
    }

    return $haystack;
}

function listAllContentByYear()
{
    $contenido = new Contenido();

    $yearsExist = $contenido->getAnyExisten();

    foreach ($yearsExist as $year) {
        $contenidoAll[] = $contenido->getContenidobyYear($year['anos']);
    }

    foreach ($contenidoAll as $itemContenido) {
        ?>
        <div class="col-12">
            <div class="card ">
                <div class="card-body py-1">
                    <!-- <h6 class="card-subtitle"> <?php echo $itemContenido['anos']; ?> </h6>-->
                    <h5 class="card-title mb-0">
                        <?php echo $itemContenido['nombre_categoria']; ?>
                        <small class="text-muted pl-2"><?php echo $itemContenido['anos']; ?></small>
                    </h5>
                    <div class="row">
                        <div class="card-text text-08 pl-2 pr-1" style="width: 98%">

                            <?php echo $itemContenido['contenido'] . " ( " . $itemContenido['id_libro'] . " , " . $itemContenido['referencia'] . " ) "; ?>
                        </div>
                        <div class="card-text text-08 text-center" style="width: 2%">
                            <a class="px-0" href="entrada.php?id=<?php echo $itemContenido['id']; ?>"
                               aria-label="Settings">
                                <i class="fa fa-eye" aria-hidden="true"></i>
                            </a>
                        </div>
                    </div>  <!--.row-->
                </div>
            </div>
        </div><!-- .col-12  -->

        <?php
    }

}

function getFirstYear()
{
    $contenido = new Contenido();
    $year = $contenido->getFirstYear();
    return $year['anos'];

}

function getLastYear()
{
    $contenido = new Contenido();
    $year = $contenido->getLastYear();
    return $year['anos'];

}

function paginationAllYear($anyActive=0, $rango = 10)
{
    $contenido = new Contenido();
    $firstYear = $contenido->getFirstYear();
    $lastYeart = $contenido->getLastYear();
    $yearsQuantity = $lastYeart['0'] - $firstYear['0'];
    $pageTotal = ceil($yearsQuantity / $rango);

    $anyActive = ($anyActive == 0) ? '1800' : $anyActive;

    echo '
    <nav aria-label="Page navigation example" >
  <ul class="pagination justify-content-center pagination-sm">
     <!--<li class="page-item">
      <a class="page-link" href="#" aria-label="Previous">
        <span aria-hidden="true">&laquo;</span>
        <span class="sr-only">Previous</span>
      </a>
    </li>-->';
    $c = 1800;
    for ($i = 0; $i < $pageTotal; $i++) {
        $active = ($anyActive == $c) ? "active" : "";
        echo '<li class="page-item ' . $active . '"> <a class="page-link" href="buscar.php?page=' . $c . '" >' . $c . '</a></li>';
        $c = $c + $rango;
    }

    echo '<!--<li class="page-item">
      <a class="page-link" href="#" aria-label="Next">
        <span aria-hidden="true">&raquo;</span>
        <span class="sr-only">Next</span>
      </a>
    </li>-->
  </ul>
</nav>';
}

/**
 * @param $categoria
 * @param $contenido
 * @param $idLibro
 * @param $referencia
 * @param $idEntrada
 */
function listEntriesGrupedByYears($categoria, $contenido, $idLibro, $referencia, $idEntrada)
{
    echo '<div class="col-12 my-1">';
        echo '<div class="card ">';
            echo '<div class="card-body py-1 ">';
                //echo '<h6 class="card-title mb-0">' . $categoria . '</h6>';
                echo '<div class="row">';
                    echo '<div class="card-text pl-2 pr-1" style="width: 98%">';
                            echo $contenido . " ( " . $idLibro . " , " . $referencia . " ) ";
                    echo '</div>';
                    echo '<div class="card-text text-08 text-center" style="width: 2%" >';
                        echo '<a class="px-0" href = "entrada.php?id=' . $idEntrada . '" aria - label = "Settings" ><i class="fa fa-eye" aria-hidden="true"></i></a >';
                    echo '</div>';
                echo '</div>'; // <!--.row-- >
            echo '</div>';
        echo '</div>';
    echo '</div>';//
}

/***********************************/
/************BUSCADOR***************/
/***********************************/
    function maquetarEntradasBuscadas($entrada , $resaltados){

         $contenidoResaltado =$entrada['contenido'] ;
/*                        echo "<pre>";
                        print_r(count($resaltados));
                        echo "</pre>";*/
         if(!empty($resaltados)){
             //echo "resaltado si";
            foreach ($resaltados as $resaltado){

                $contenidoResaltado = highlightWords($contenidoResaltado,$resaltado);
            }
        }

        echo '<div class="col-12 my-1 ">';
                echo '<div class="card ">';
                  echo '<div class="card-body py-1">
                        <h5 class="card-title mb-0">' . $entrada['nombre_categoria'] .
                            '<small class="text-muted pl-2">'. $entrada['anos'] . '</small>
                        </h5>
                        <div class="row">
                        <div class="card-text text-08 pl-2 pr-1" style="width: 98%">'.
                      $contenidoResaltado . '" ( " '.$entrada['id_libro'] . '" , "' . $entrada['referencia'] .' " ) "</div>
                        <div class="card-text text-08 text-center" style="width: 2%" >
                            <a class="px-0" href="entrada.php?id=' .$entrada['id']. '" aria-label="Settings">
                                <i class="fa fa-eye" aria-hidden="true"></i>
                            </a>
                        </div>
</div>  <!--.row-->
                    </div>
                </div>
         </div><!-- .col-12  -->
        ';
    }

// Highlight words in text
function highlightWords($text, $word){
    $text = preg_replace('#'. preg_quote($word) .'#i', '<span class="hlw">\0</span>', $text);
    return $text;
}

function orderByYears($entrada){
    if (!empty($entrada)){
/*        echo "<pre> orderByYears Inicio ->  ";
        print_r($entrada);
        echo "</pre>";*/

        foreach ($entrada as $key => $row) {
            $aux[$key] = $row['anos'];
        }
    array_multisort($aux, SORT_ASC, $entrada);
    }
    return $entrada;
}