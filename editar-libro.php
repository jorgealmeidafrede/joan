<?php
require_once("model/Libro.php");
require_once("functions.php");

$tituloPagina = "Edita Llibre - Programa d'Història";
$itemMenuActivo = "libro";
$libro = new Libro();

include('templates/header.php');

if (isset($_GET['id'])) {
    $libroById = $libro->getLibroById($_GET['id']);

}
if ($libroById) {
    // Si hay $_POST
    if (isset($_POST['editBook'])) {

        $date_added = date("j/F/Y");
        $data = array(
            'titulo' => trim($_POST['title']),
            'autor' => trim($_POST['author']),
            'editorial' => trim($_POST['editorialBook']),
            'edicion' => " ",
            'ano' => $_POST['yearBook'],
            'date_added' => $date_added,
            'id' => $libroById['id']
        );
        $actualizado = $libro->updateBook($data);

        if ($actualizado > 0) {
            $libroById = $libro->getLibroById($_GET['id']);
            echo '
        <!-- Success Alert -->
        <div class="col-12 text-center alert alert-success alert-dismissible fade show">
             S\'ha actualitzat el llibre titulat:<a href="/libro.php#libro-' . $data['id'] . '" <strong>' . $data['titulo'] . ' </strong></a>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>';
        }
    } elseif (isset($_POST['delBook'])) {
        $eliminado = $libro->delBook($libroById['id']);
        if ($eliminado > 0) {
            $libroById = $libro->getLibroById($_GET['id']);
            echo '
        <!-- Success Alert -->
        <div class="col-12 text-center alert alert-success alert-dismissible fade show">
             S\'ha eliminat el llibre titulat:<strong>' . $_POST['title'] . ' </strong>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>';
        }
    }

    if (isset($eliminado)) {
        $html = '<a href="/libro.php"><i class="fas fa-hand-point-left"></i> Tornar a llibres</a>';
        echo $html;
    }else{
    ?>
    <div class="col-12" id="libro-agregar">
        <!-- Material form subscription -->
        <div class="card">

            <h5 class="card-header text-center py-2">
                <strong>Edita Llibre</strong>
            </h5>

            <!--Card content-->
            <div class="card-body py-2">

                <!-- Form -->
                <form method="POST" action="<?php echo $_SERVER['PHP_SELF'] . "?" . "id=" . $libroById['id']; ?>"
                      class="text-center">

                    <!-- Titulo del Libro -->
                    <div class="form-group row mb-1">
                        <label for="title" class="col-sm-2 col-form-label">Títol de el llibre</label>
                        <div class="col-sm-10">
                            <input spellcheck="false" type="text" class="form-control form-control-sm" name="title"
                                   id="title" value="<?php echo $libroById['titulo'] ?>" required>
                        </div>
                    </div>
                    <!-- Autor  -->
                    <div class="form-group row mb-1">
                        <label for="author" class="col-sm-2 col-form-label">Autor de el llibre</label>
                        <div class="col-sm-10">
                            <input spellcheck="false" type="text" class="form-control form-control-sm" name="author"
                                   id="author" value="<?php echo $libroById['autor'] ?>">
                        </div>
                    </div>
                    <!-- Editorial  -->
                    <div class="form-group row mb-1">
                        <label for="editorialBook" class="col-sm-2 col-form-label">Editorial de el llibre</label>
                        <div class="col-sm-10">
                            <input spellcheck="false" type="text" class="form-control form-control-sm"
                                   name="editorialBook" id="editorialBook"
                                   value="<?php echo $libroById['editorial'] ?>">
                        </div>
                    </div>
                    <!-- Año  -->
                    <div class="form-group row mb-1">
                        <label for="yearBook" class="col-sm-2 col-form-label">Any de el llibre</label>
                        <div class="col-sm-10">
                            <input spellcheck="false" type="text" class="form-control form-control-sm" name="yearBook"
                                   id="yearBook" value="<?php echo $libroById['ano'] ?>">
                        </div>
                    </div>

                    <!-- Sign in button -->
                    <button name="delBook" value="1" id="delBook" class="float-left btn btn-danger btn-sm"
                            type="submit">Eliminar
                    </button>
                    <button name="editBook" value="1" id="editBook" class="float-right btn btn-primary btn-sm"
                            type="submit">Edita
                    </button>

                </form>
                <!-- Form -->

            </div>
        </div>

    </div>
    <?php
    } //$eliminado
} else { ?>
    <div class="alert alert-warning m-auto" role="alert">
        <h2>oops! Desafortunadament, no existeix aquest llibre.<h2>
    </div>
    <?php
}//$libroById
include('templates/footer.php');