<?php
ini_set('display_errors', 1);
require_once("model/Categoria.php");
require_once("model/Contenido.php");
require_once("functions.php");

$tituloPagina = "Programa d'Història - Edita Entrada ";

include('templates/header.php');

$idEntrada = $_GET['id'];

/*echo "<div class='row'> Mostamos:  <pre>";echo "</pre></div>";*/

if ($idEntrada) {
    $categoria = new Categoria();
    $categorias = $categoria->getCategoria();
    $entrada = new Contenido();
    $ContenidoEntrada = $entrada->getEntradaById($idEntrada);
}

/*echo "<pre>";
print_r($ContenidoEntrada[0]['id_categoria']);
echo "</pre>";*/

if (!empty($ContenidoEntrada)) {

    $libro = new Libro();
    $listaLibros = $libro->getLibro();
    /*    $categoria = new Categoria();
        $categorias = $categoria->getCategoria();*/


    // Si hay $_POST  eliminar actualizar
    $postAction = isset($_POST['action'])?$_POST['action']:"";
    if ($postAction == 'editar') {

        $nombreCategoria = $categoria->getNombreCategoriaById($_POST['categoria']);

       // Array ( [libro] => 1 [categoria] => 2 [any] => 2030 [pagina] => 56 [referencia] => referencia [contenido] => Contenido [action] => editar )
        $referencia = isset($_POST['referencia']) ? trim($_POST['referencia']) : "";
        $pagina = isset($_POST['pagina']) ? trim($_POST['pagina']) : "";
        $idLibro = isset($_POST['libro']) ? trim($_POST['libro']) : "";
        $idCategoria = isset($_POST['categoria']) ? $_POST['categoria'] : "";
        $any = isset($_POST['any']) ? $_POST['any'] : "";
        $contenidoPost = isset($_POST['contenido']) ? trim($_POST['contenido']) : "";
        $date_added = date("j/F/Y");
        $data = array(
            'referencia' => $referencia,
            'pagina' => $pagina,
            'id_libro' => $idLibro,
            'id_categoria' => $idCategoria,
            'nombre_categoria' => $nombreCategoria,
            'anos' => $any,
            'contenido' => $contenidoPost,
            'date_added' => $date_added,
            'id' => $idEntrada
        );
        $actualizado = $entrada->updateEntrada($data);

        $ContenidoEntrada = $entrada->getEntradaById($idEntrada);

        if ($actualizado > 0) { ?>

            <script type="application/javascript">
                var path = window.location.origin + (window.location.pathname.substring(0, window.location.pathname.lastIndexOf('/') + 1));
                console.log('path -> ' + path);
                window.location.href = path + 'agregar-entrada.php?idUpdate=<?= $data['id']?>';
            </script>
            <?php
        }
    } elseif ($postAction == 'eliminar') {
        $eliminado = $entrada->deleteEntrada($idEntrada);
        if ($eliminado > 0) { ?>
            <script type="application/javascript">
                var path = window.location.origin + (window.location.pathname.substring(0, window.location.pathname.lastIndexOf('/') + 1));
                console.log('path -> ' + path);
                window.location.href = path + 'agregar-entrada.php?idDelete=<?=$idEntrada?>';
            </script>
            <?php
        }
    }
    ?>
    <div class="col-12 text-08" id="editar-entrada">
        <div class="card">
            <div class="card-header py-1">
                <h6 class="card-title m-0">Edita Entrada: </h6>
            </div>

            <div class="card-body p-1">
                <form name="form1" method="POST" class=""
                      action="<?php echo $_SERVER['PHP_SELF'] . "?" . "id=" . $idEntrada; ?>">

                    <div class="form-row ">
                        <div class="form-group col-md-12">
                            <label for="libro">Libre:</label>
                            <select name="libro" id="libro" class="form-control form-control-sm text-08">
                                <?php selectLibro($listaLibros, $ContenidoEntrada[0]['id_libro']); ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="categoria">Categoria:</label>
                            <select name="categoria" id="categoria" class="form-control form-control-sm">
                                <?php selectCategoria($ContenidoEntrada[0]['id_categoria']); ?>
                            </select>
                        </div>
                    </div>

                    <div class=" form-row">
                        <div class="form-group col-md-1 ">
                            <label for="pagina">Any:</label>
                            <input name="any" type="text" class="form-control form-control-sm" maxlength="4"
                                   id="referencia"
                                   value="<?php echo $ContenidoEntrada[0]['anos'] ?>">
                        </div>
                        <div class="form-group col-md-5">
                            <label for="pagina">Pàgina:</label>
                            <input name="pagina" type="text" class="form-control form-control-sm" id="referencia"
                                   value="<?php echo $ContenidoEntrada[0]['pagina'] ?>">
                        </div>

                        <div class="form-group col-md-6 ">
                            <label for="referencia">Referència: </label>
                            <input name="referencia" type="text" class="form-control form-control-sm" id="referencia"
                                   value="<?php echo $ContenidoEntrada[0]['referencia'] ?>">
                        </div>


                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="contenido" class="">Contenido: </label>
                            <textarea spellcheck="false" name="contenido" id="contenido" class="form-control"
                                      rows="15"><?php echo cambiarCaracteres($ContenidoEntrada[0]['contenido']) ?></textarea>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-12 ml-sm-auto">
                            <button type="submit" name="action" value="eliminar" class="btn btn-danger float-left">
                                Eliminar
                            </button>
                            <button type="submit" name="action" value="editar" class="float-right btn btn-primary">
                                Actualitzar
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <?php
    //Si no viene nada pagina error
} else { ?>
    <div class="alert alert-warning m-auto" role="alert">
        <h2>oops! Malauradament, no existeix aquesta entrada.<h2>
    </div>
    <?php
}
include('templates/footer.php');


