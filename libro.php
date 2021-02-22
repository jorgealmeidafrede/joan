<?php
require_once("model/Libro.php");
require_once("functions.php");

$tituloPagina = "Libros - Programa d'Història";
$itemMenuActivo = "libro";
$libro = new Libro();

include('templates/header.php');

if (isset($_POST['addBook'])) {
//print_r($_POST);
    $date_added = date("j/F/Y");
    $data = array(
        'titulo' => trim($_POST['title']),
        'autor' => trim($_POST['author']),
        'editorial' => trim($_POST['editorialBook']),
        'edicion' => "",
        'ano' => $_POST['yearBook'],
        'date_added' => $date_added,
    );
    $actualizado = $libro->addBook($data);

    if ($actualizado > 0) { //S'ha creat el llibre "Nom" amb el número
        echo '
        <!-- Success Alert -->
        <div class="col-12 text-center alert alert-success alert-dismissible fade show">
             S\'ha creat el llibre titulat:<a href="/libro.php#libro-' . $actualizado . '" <strong>' . $data['titulo'] . ' </strong></a>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>';
    }
}
?>
<div class="col-12" id="libro-agregar">
    <div class="card">

        <h5 class="card-header text-center py-2">
            <strong>Afegir Llibre</strong>
        </h5>

        <!--Card content-->
        <div class="card-body py-2">

            <!-- Form -->
            <form method="POST" action=" <?php echo $_SERVER['PHP_SELF'] ?>" class="text-center">
                <!-- Titulo del Libro -->
                <div class="form-group row mb-1">
                    <label for="title" class="col-sm-2 col-form-label">Títol de el llibre</label>
                    <div class="col-sm-10">
                        <input spellcheck="false" type="text" class="form-control form-control-sm" name="title"
                               id="title" placeholder="" required>
                    </div>
                </div>
                <!-- Autor  -->
                <div class="form-group row mb-1">
                    <label for="author" class="col-sm-2 col-form-label">Autor de el llibre</label>
                    <div class="col-sm-10">
                        <input spellcheck="false" type="text" class="form-control form-control-sm" name="author"
                               id="author" placeholder="">
                    </div>
                </div>
                <!-- Editorial  -->
                <div class="form-group row mb-1">
                    <label for="editorialBook" class="col-sm-2 col-form-label">Editorial de el llibre</label>
                    <div class="col-sm-10">
                        <input spellcheck="false" type="text" class="form-control form-control-sm" name="editorialBook"
                               id="editorialBook" placeholder="">
                    </div>
                </div>
                <!-- Año  -->
                <div class="form-group row mb-1">
                    <label for="yearBook" class="col-2 col-form-label">Any de el llibre</label>
                    <div class="col-9">
                        <input spellcheck="false" type="text" class="form-control form-control-sm" name="yearBook"
                               id="yearBook" placeholder="">
                    </div>
                    <div class="col-1">
                        <button name="addBook" id="addBook" class="float-right btn btn-primary btn-sm" type="submit">
                            Afegir
                        </button>
                    </div>
                </div>

                <!-- Sign in button -->


            </form>
            <!-- Form -->

        </div>
    </div>

</div>

<div class="col-12" id="libro-listar">
    <h1 class="lead text-center my-2">Llistat de Llibres</h1>
    <div class="row">
        <?php
        $i = 0;
        $listadosLibros = $libro->getLibro();
        foreach ($listadosLibros as $libroItem) {
            ?>
            <div id="libro-<?php echo $libroItem['id'] ?>" class="libro-item col-12 mb-1 py-1 d-flex align-items-center">
                <div class="libro-item-num float-left mr-4 p-2 rounded-circle bg-dark text-white d-flex align-items-center justify-content-center text-center font-weight-bold"><?php echo $libroItem['id'] ?> </div>
                <h6 class="float-left text-14 w-95"><?php echo $libroItem['titulo']; ?> <small class="text-muted pl-2">
                        - <?php echo $libroItem['autor']; ?> - <?php echo $libroItem['ano']; ?></small></h6>

                <a class="libro-item-enlace px-0 float-right" href="editar-libro.php?id=<?php echo $libroItem['id']; ?>"
                   aria-label="Settings">
                    <i class="fa fa-eye" aria-hidden="true"></i>
                </a>
            </div><!-- .col-12 -->
            <?php $i++;
        } ?>
    </div><!-- .row -->
</div><!-- .#libro-listar -->