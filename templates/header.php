<?php
require_once("functions.php");
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../../../favicon.ico">

    <title> <?php echo $tituloPagina ?> </title>

    <!-- Bootstrap core CSS -->
    <!--<link href="css/bootstrap-4.0.0-dist/css/bootstrap.min.css" rel="stylesheet">-->
    <link href="bootstrap-4.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="css/style.css" rel="stylesheet">
    <link href="css/reloj.css" rel="stylesheet">
</head>

<body>
<span class="oi" data-glyph="icon-name" title="icon name" aria-hidden="true"></span>
<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">

    <div class="collapse navbar-collapse container" id="menu_principal">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item  <?php echo ($itemMenuActivo == "index") ? "active" : "" ?>">
                <a class="nav-link" href="index.php">Inicio <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item <?php echo ($itemMenuActivo == "libro") ? "active" : "" ?>">
                <a class="nav-link" href="libro.php">Libros</a>
            </li>
            <li class="nav-item <?php echo ($itemMenuActivo == "categorias") ? "active" : "" ?>">
                <a class="nav-link " href="categoria.php">Categorias</a>
            </li>
            <li class="nav-item <?php echo ($itemMenuActivo == "agregar-entrada") ? "active" : "" ?>">
                <a class="nav-link " href="agregar-entrada.php">Agregar Entrada</a>
            </li>
            <li class="nav-item <?php echo ($itemMenuActivo == "listar-entrada") ? "active" : "" ?>">
                <a class="nav-link " href="listar-entradas.php">Listar Entrada</a>
            </li>

        </ul>

    </div>
</nav>

<main role="main" class="container">
    <!--Buscador principal-->
    <form method="GET" action="buscar.php?page=0" class=" my-2 my-lg-0">
        <div class="form-row">
            <div class="col-6"><!-- col-7 -->
                <input id="busqueda" name="busqueda" size="48" class="form-control form-control-sm px-0" type="text"
                       placeholder="" aria-label="" value="<?= empty($_GET['busqueda']) ? "" : $_GET['busqueda'] ?>">
            </div>
            <div class="form-group col-1">
                <input id="year1" name="ano1" size="" class="form-control form-control-sm px-1 text-center" type="text"
                       maxlength="4"
                       placeholder="Des de l'any" aria-label=""
                       value="<?= empty($_GET['ano1']) ? "" : $_GET['ano1'] ?>">
            </div>
            <div class="form-group col-1 text-center">
                <!-- <?php /*selectAnyExisten(); */ ?> -->
                <input id="year2" name="ano2" size="" class="form-control form-control-sm px-1 text-center" type="text"
                       maxlength="4"
                       placeholder="Fins a l'any" aria-label=""
                       value="<?= empty($_GET['ano2']) ? "" : $_GET['ano2'] ?>">
            </div>

            <div class="col-2">
                <select name="id_categoria" class="form-control form-control-sm px-0" id="id_categoria">
                    <option value="0">Triar Categoria</option>
                    <?php selectCategoria($_GET['id_categoria']); ?>
                </select>

            </div>
            <div class="col-1 text-center">
                <button name="neta" value="" type="button" class="btn btn-primary btn-sm px-1 w-100" onclick="netaForm()">Neta</button>

            </div>
            <div class="col-1 text-center">
                <button name="buscar" value="1" type="submit" class="btn btn-success btn-sm px-1 w-100">Cerca</button>
            </div>
        </div>
    </form>

    <div class="row mt-3 cuerpo">
