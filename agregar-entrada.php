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

//$postSubmit = $_POST['submit'];


$entrada = new Contenido();

/*echo "<div class='row'> Mostamos:  <pre>";print_r($_POST); echo "</pre></div>";*/

// Si hay $_POST
if (isset($_POST['submit'])) {
    $nombreCategoria = $categoria->getNombreCategoriaById($_POST['categoria']);
    $date_added = date("j/F/Y");
    $idLibro = (!empty($_POST['libro'])) ? $_POST['libro'] : $_POST['libro2'];
    echo " </p>";
    $data = array(
        'referencia' => trim($_POST['referencia']),
        'pagina' => trim($_POST['pagina']),
        'id_libro' => $idLibro,
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
             S\'ha creat l\'entrada número:<a href="entrada.php?id=' . $actualizado . '" <strong>' . $actualizado . ' </strong></a>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>';
    }
}
if (isset($_GET['idUpdate'])) {
    echo ' <!-- Success Alert -->            
            <div class="col-12 text-center alert alert-success alert-dismissible fade show">
                 L\'entrada  <strong>' . $_GET['idUpdate'] . ' </strong> ha estat actualitzada amb èxit !! <a href="entrada.php?id=' . $_GET['idUpdate'] . '">Veure l\'entrada</a>
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>';
}
if (isset($_GET['idDelete'])) {
    // L\'entrada  <strong>' . $idEntrada . ' </strong> es eliminat correctament !!
    echo ' <!-- Success Alert -->            
            <div class="col-12 text-center alert alert-success alert-dismissible fade show">
                 L\'entrada  <strong>' . $_GET['idDelete'] . ' </strong> es eliminat correctament !!
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>';
}
?>
    <div class="col-12 text-08" id="editar-entrada">
        <div class="card">
            <h5 class="card-header text-center">
                <strong>Afegir Entrada</strong>
            </h5>

            <div class="card-body p-1">
                <form name="form-agregar-entrada" method="POST" class=""
                      action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <!-- Primer Linea -->
                    <div class=" form-row">
                        <div class="form-group col-md-4 ">
                            <label for="any">Any:</label>
                            <select name="any" id="any" class="form-control form-control-sm text-08" required>
                                <option value="">--</option>
                                <?php
                                for ($i = 1800; $i <= 2050; $i++) {
                                    echo '<option value="' . $i . '">' . $i . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="id_libro">Llibre:</label>
                            <select name="libro" id="libro" class="form-control form-control-sm text-08">
                                <option value="">--</option>
                                <?php selectLibroOrderTitol(); ?>
                            </select>
                        </div>

                        <div class="form-group col-md-4 ">
                            <label for="referencia">Referència: </label>
                            <input name="referencia" type="text" class="form-control form-control-sm" id="referencia"
                                   value="" spellcheck="false">
                        </div>

                    </div><!-- .form-row -->

                    <!-- Segunda Linea -->
                    <div class=" form-row">
                        <div class="form-group col-md-4">
                            <label for="categoria">Categoria:</label>
                            <select name="categoria" id="categoria" class="form-control form-control-sm text-08"
                                    required>
                                <option value="">--</option>
                                <?php selectCategoria(); ?>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="libro2">Llibre:</label>
                            <select name="libro2" id="libro2" class="form-control form-control-sm text-08">
                                <option value="">--</option>
                                <?php selectLibro(); ?>
                            </select>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="pagina">Pàgina:</label>
                            <input name="pagina" type="text" class="form-control form-control-sm" id="pagina"
                                   value="">
                        </div>

                    </div><!-- .form-row -->

                    <!-- -->
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="contenido" class="">Contingut: </label>
                            <textarea spellcheck="false" name="contenido" id="contenido" class="form-control" rows="15"
                                      required></textarea>
                        </div>
                    </div>


                    <div class="form-group row">
                        <div class="col-sm-12 ml-sm-auto">
                            <button type="submit" name="submit" value="1" class="float-right btn btn-primary">Crea
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


<?php
//Si no viene nada pagina error
include('templates/footer.php');


