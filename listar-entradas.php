<?php
require_once("model/Paginator.php");
require_once("functions.php");

$tituloPagina = "Listado de Entradas - Programa d'Història ";
$itemMenuActivo = "listar-entrada";

include('templates/header.php');
if (isset($_GET['page'])){
    $paginator = new Paginator('contenido_hi',$_GET['page']);
}else {
    $paginator = new Paginator('contenido_hi');
}


$contenido = $paginator->getData();

//print_r(count($contenido->data));
//echo '<br>';


if (!empty($contenido->data)) {
  echo $paginator->links();;
    ?>

    <table class="table table-striped">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Any</th>
            <th scope="col">Categoria</th>
            <th scope="col">Contenido</th>
            <th scope="col">LLibre</th>
            <th scope="col">Pagina</th>
            <th scope="col">Referencia</th>
            <th scope="col"></th>
        </tr>
        </thead>
        <tbody>
<?php
foreach ($contenido->data as $data){ ?>

    <tr>
        <th scope="row"><?= $data ['id'] ?></th>
        <td><?= $data ['anos'] ?></td>
        <td><?= $data ['nombre_categoria'] ?></td>
        <td><?= $data ['contenido'] ?></td>
        <td><?= $data ['id_libro'] ?></td>
        <td><?= $data ['pagina'] ?></td>
        <td><?= $data ['referencia'] ?></td>
        <td>
            <a class="px-0" href="entrada.php?id=<?= $data ['id'] ?>" aria-label="Settings">
                <i class="fa fa-eye" aria-hidden="true"></i>
            </a>
        </td>
    </tr>


<?php } ?>

        </tbody>
    </table>

    <div class="col-12 listado-entrada ">

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

//$paginator = new Paginator('contenido_hi');