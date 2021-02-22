<?php
require_once("model/Categoria.php");
require_once("model/Contenido.php");
require_once("functions.php");

$tituloPagina = "Programa d'Història - Entrada ";
$categoria = new Categoria();
$Categorias = $categoria->getCategoria();
include('templates/header.php');

if ($_GET['id']) {
    $idEntrada = $_GET['id'];
    $entrada = new Contenido();
    $ContenidoEntrada = $entrada->getEntradaById($idEntrada);
}
if (!empty($ContenidoEntrada)){

    ?>
    <div class="col-12 entrada ">
    <!---->
    <div class="card">
        <div class="card-header py-1">
            <h5 class="text-center">
                <span class="float-left"><?php echo $ContenidoEntrada[0]['anos']; ?> </span>
                <?php echo $ContenidoEntrada[0]['nombre_categoria']; ?>
                <small class="text-muted float-right"><?php echo $ContenidoEntrada[0]['date_added']; ?></small>
            </h5>
        </div>
        <div class="card-body " style="min-height: 400px;">

            <p class="card-text"><?php echo nl2br($ContenidoEntrada[0]['contenido']);?></p>

        </div>
        <div class="card-footer">
            <div class="w-50 float-left">Referència: <span class="font-weight-bold"><?php echo $ContenidoEntrada[0]['referencia']; ?></span></div>
            <div class="w-20 float-left">Pàgina: <span class="font-weight-bold"><?php echo $ContenidoEntrada[0]['pagina']; ?></span></div>
            <div class="w-20 float-left">Llibre: <span class="font-weight-bold"><?php echo $ContenidoEntrada[0]['id_libro']; ?></span></div>
            <div class="w-10 float-left text-center"> <a href="editar-entrada.php?id=<?php echo $ContenidoEntrada[0]['id']; ?>" class="btn btn-sm btn-warning"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></div>

        </div>
    </div>
    <!---->
    </div> <!-- <div class="col-12 entrada"> -->
    <?php
} else { ?>
    <div class="alert alert-warning m-auto" role="alert">
        <h2>oops! Malauradament, no existeix aquesta entrada.<h2>
    </div>
    <?php
}
include('templates/footer.php');
