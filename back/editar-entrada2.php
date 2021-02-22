<?php
ini_set('display_errors', 1);
require_once("model/Categoria.php");
require_once("model/Contenido.php");
require_once("functions.php");

$tituloPagina = "Programa d'Història - Edita Entrada ";

include('templates/header.php');
$postSubmit = $_POST['submit'];
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
    if (isset($postSubmit)) {

        $nombreCategoria = $categoria->getNombreCategoriaById($_POST['categoria']);
        $date_added = date("j/F/Y");
        $data = array(
            'referencia' => trim($_POST['referencia']),
            'pagina' => trim($_POST['pagina']),
            'id_libro' => trim($_POST['id_libro']),
            'id_categoria' => $_POST['categoria'],
            'nombre_categoria' => $nombreCategoria,
            'anos' => $_POST['any'],
            'contenido' => trim($_POST['contenido']),
            'date_added' => $date_added,
            'id' => $_GET['id']
        );
        $actualizado = $entrada->updateEntrada($data);

        $ContenidoEntrada = $entrada->getEntradaById($idEntrada);

        if ($actualizado > 0) {
            echo '
    <!-- Success Alert -->
    <div class="col-12 text-center alert alert-success alert-dismissible fade show">
         La entrada <strong>' . $data['id'] . ' </strong> ha sido actualizada con éxito !!
        <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>';
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
                            <input name="any" type="text" class="form-control form-control-sm" maxlength="4" id="referencia"
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
                            <textarea spellcheck="false" name="contenido" id="contenido" class="form-control" rows="15"><?php echo cambiarCaracteres($ContenidoEntrada[0]['contenido']) ?></textarea>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-12 ml-sm-auto">
                            <button type="submit" name="submit" value="eliminar" class="btn btn-danger float-left">Eliminar</button>
                            <button type="submit" name="submit" value="actualizar" class="float-right btn btn-primary">Actualitzar</button>
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


