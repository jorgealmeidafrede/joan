<?php
ini_set('display_errors', 1);
require_once("model/Categoria.php");
require_once("model/Contenido.php");
require_once("functions.php");

$tituloPagina = "Agregar EntradPrograma d'Història a ";
$itemMenuActivo = "agregar-entrada";

include('templates/header.php');
$categoria = new Categoria();
$categorias = $categoria->getCategoria();

$postSubmit = $_POST['submit'];


$entrada = new Contenido();

/*echo "<div class='row'> Mostamos:  <pre>";print_r($_POST); echo "</pre></div>";*/

// Si hay $_POST
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
    );
      $actualizado = $entrada->addEntrada($data);

            /*entrada.php?id=11519*/
            if ($actualizado > 0) {
                echo '
        <!-- Success Alert -->
        <div class="col-12 text-center alert alert-success alert-dismissible fade show">
             S\'ha creat l\'entrada número:<a href="'. $_SERVER['SERVER_NAME']. '/entrada.php?id='.$actualizado .'" <strong>' . $actualizado . ' </strong></a>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>';
            }
}
?>
    <div class="col-12 text-08" id="editar-entrada">
        <div class="card">
            <h5 class="card-header text-center">
                <strong>Afegir Entrada</strong>
            </h5>

            <div class="card-body p-1">
                <form name="form-agregar-entrada" method="POST" class=""
                      action="<?php echo $_SERVER['PHP_SELF'];?>">
                    <!-- Select Categorías -->
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="categoria">Categoria:</label>
                            <select name="categoria" id="categoria" class="form-control form-control-sm" required>
                                <option value="">--</option>
                                <?php selectCategoria(); ?>
                            </select>
                        </div>
                    </div>
                    <!--Select Libros-->
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="id_libro">Llibre:</label>
                            <select name="libro" id="libro" class="form-control form-control-sm text-08" required>
                                <option value="">--</option>
                                <?php selectLibro(); ?>
                            </select>
                        </div>
                    </div>
                    <!-- -->
                    <div class=" form-row">
                        <div class="form-group col-md-1 ">
                            <label for="any">Any:</label>
                            <input name="any" type="text" class="form-control form-control-sm " id="any" maxlength="4" value="">
                        </div>
                        <div class="form-group col-md-5">
                            <label for="pagina">Pàgina:</label>
                            <input name="pagina" type="text" class="form-control form-control-sm" id="pagina"
                                   value="">
                        </div>

                        <div class="form-group col-md-6 ">
                            <label for="referencia">Referència: </label>
                            <input name="referencia" type="text" class="form-control form-control-sm" id="referencia"
                                   value="">
                        </div>

                    </div>


                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="contenido" class="">Contenido: </label>
                            <textarea spellcheck="false" name="contenido" id="contenido" class="form-control" rows="15" required></textarea>
                        </div>
                    </div>


                    <div class="form-group row">
                        <div class="col-sm-12 ml-sm-auto">
                            <button type="submit" name="submit" value="1" class="float-right btn btn-primary">Crea</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


<?php
//Si no viene nada pagina error
include('templates/footer.php');


