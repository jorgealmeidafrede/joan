<?php
require_once("model/Categoria.php");
require_once("model/Contenido.php");
require_once("functions.php");

$tituloPagina = "Programa d'Història - Categories";
$itemMenuActivo = "categorias";
$categorias = new Categoria();
$nombresCategorias = $categorias->getCategoria();
include('templates/header.php');

if (isset($_GET['id'])) {
    $idCategoria = $_GET['id'];
    $contenido = new Contenido();
    $getContenidoByCategoria = $contenido->getContenidoByCategoria($idCategoria);
    foreach ($getContenidoByCategoria as $itemContenido) {
        ?>
        <div class="col-12">
            <div class="card ">
                <div class="card-body py-1">
                    <!-- <h6 class="card-subtitle"> <?php echo $itemContenido['anos']; ?> </h6>-->
                    <h6 class="card-title mb-0">
                       <!-- <?php echo $itemContenido['nombre_categoria']; ?>
                        <small class="text-muted pl-2"></small>-->
                        <?php echo $itemContenido['anos']; ?>
                    </h6>
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

} else {

    /* Create Category */
    if (isset($_POST['action']) AND $_POST['action'] == 'insert'){
        echo  "insert";
        $nameCategory['nombre'] = $_POST['nombre'];
        $creado = $categorias->addCategory($nameCategory);
        $nombresCategorias = $categorias->getCategoria();

                if ($creado > 0) {
                    echo '
                <!-- Success Alert -->
                <div class="col-12 text-center alert alert-success alert-dismissible fade show">
                     S\'ha creat correctament la categoria categoria:<a href="/categoria.php#categoria-' . $creado . '" <strong>' . $nameCategory['nombre'] . ' </strong></a>
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>';
                }
        /* Delete Category */
    }elseif (isset($_POST['action']) AND $_POST['action'] == 'delete'){
        echo  "delete";
        $idCategoria = $_POST['id-editar'];
        $borrado = $categorias->deleteCategory($idCategoria);
        $nombresCategorias = $categorias->getCategoria();

        if ($borrado > 0) {
            echo '
        <!-- Success Alert -->
        <div class="col-12 text-center alert alert-success alert-dismissible fade show">
             S\'ha eliminat la categoria categoria:<strong> ' . $_POST['nombre-editar']. '</strong>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>';
        }

        /* Edit Category */
    }elseif (isset($_POST['action']) AND $_POST['action'] == 'edit') {
        echo  "edit";
        $categoria = array('id' => $_POST['id-editar'], "nombre" => $_POST['nombre-editar']);
         $editado = $categorias->updateCategory($categoria);
         $nombresCategorias = $categorias->getCategoria();
        if ($editado > 0) {
            echo '
        <!-- Success Alert -->
        <div class="col-12 text-center alert alert-success alert-dismissible fade show">
             El nom ha canviat per:<strong> ' . $_POST['nombre-editar'] . '</strong>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>';
        }
    }
    ?>
    <div class="col-3  ">
        <ul class="list-group" id="list-category">
            <?php
            sidebarCategoriasEditar($nombresCategorias);
            ?>
        </ul>
    </div><!-- .col-3 -->
    <div class="col-8" >
        <!--Agregar Categoria-->
        <div class="card" id="categoria-crear">
            <h5 class="card-header text-center py-2">
                <strong>Afegir Categoria</strong>
            </h5>

            <!--Card content-->
            <div class="card-body py-2">

                <!-- Form -->
                <form method="POST" action="<?php echo $_SERVER['PHP_SELF']?>"  class="text-center">

                    <!-- Titulo del Libro -->
                    <div class="form-group row ">
                        <div class="col-sm-12">
                            <input spellcheck="false" type="text" class="form-control form-control-sm" name="nombre" id="nombre" placeholder="nova categoria" required>
                        </div>
                    </div>

                    <button name="action" type="submit" value="insert" id="addCat" class="float-right btn btn-primary btn-sm">Afegir</button>
                    <!--<button name="action" type="submit" value="delete" id="delCat"  class="btn btn-danger float-left btn-sm">Esborrar</button>-->

                </form>
                <!-- Form -->

            </div>
        </div>
        <!--Update && Delete Categoria-->
        <div class="card" id="categoria-editar" style="display: none; background-color: #343a40">
            <button type="button" class="close" style="color: #fff; position: absolute;right: 5px;" onClick="muestroAgregarCat()">×</button>
            <h5 class="card-header text-center py-2" style="color: #fff;">
                <strong>Edita Categoria</strong>
            </h5>

            <!--Card content-->
            <div class="card-body py-2">

                <!-- Form -->
                <form method="POST" action="<?php echo $_SERVER['PHP_SELF']?>"  class="text-center">

                    <!-- Titulo del Libro -->
                    <div class="form-group row ">
                        <div class="col-sm-12">
                            <input type="hidden" name="id-editar" id="id-editar" value="">
                            <input spellcheck="false" type="text" class="form-control form-control-sm" name="nombre-editar" id="nombre-editar" value="" required>
                        </div>
                    </div>

                    <button name="action" type="submit" value="edit" id="addCat" class="float-right btn btn-primary btn-sm">Edita</button>
                    <button name="action" type="submit" value="delete" id="delCat" class="float-left  btn btn-danger  btn-sm">Esborrar</button>

                </form>
                <!-- Form -->

            </div>
        </div>
    </div>



    <?php
}
include('templates/footer.php');