<?php
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
require_once ("model/Categoria.php");
require_once ("functions.php");
$itemMenuActivo = "index";
$tituloPagina= "Programa d'Història ";
$categorias = new Categoria();
$nombresCategorias = $categorias->getCategoria();

include('templates/header.php');
?>


        <div class="col-9">
            <h1 class="text-center mb-4">Programa d'Història</h1>

<?php include ('templates/reloj.php') ?>
        </div>

        <div class="col-3 ">
            <ul class="list-group" id="list-category">
                <?php
                sidebarCategorias($nombresCategorias);
                ?>
            </ul>
        </div>



<?php
include('templates/footer.php');
//  Ã³','Ã','Ã¨','Ã©','Ã¼'
/*$strUTF = "Ã¨ Ã³ Ã© Ã Ã³ Ã  , Ã , Ã" ;
$str = "proposÃ";*/

//echo "<p style='color: #1e7e34'>". nl2br(cambiarCaracteres($str)) . "</p>";
/*echo "<p style='color: #005cbf'>mb_detect_encoding => " . mb_detect_encoding($str) ."<p>";

$strDecode =utf8_decode($strUTF);
$strEncode =utf8_encode($strUTF);

/*echo "<p style='color: #6f42c1'>". $str . "</p>";*/
/*echo "<p style='color: #1c7430'>". $strUTF . "</p>";
echo "<p style='color: #6f42c1'>". $strDecode . "</p>";
echo "<p style='color: #721c24'>". $strEncode . "</p>";*/
