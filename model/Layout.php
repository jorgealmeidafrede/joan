<?php
require_once("autoload.php");

class Layout
{


    public function simpleEntry($entrada)
    {
        $html = '<div class="col-12 my-1 ">';
        $html .= '<div class="card ">';
        $html .= '<div class="card-body py-1">';

        $html .= '<div class="row">';
        $html .= '<div class="card-text text-08 pl-2 pr-1" style="width: 98%">';
        $html .= $entrada['contenido'] . ' (  ' . $entrada['id_libro'] . ' , ' . $entrada['referencia'] . ' , pàgina : ' . $entrada['pagina'].' ) ';
        $html .= '</div>';
        $html .= '<div class="card-text text-08 text-center" style="width: 2%" >';
        $html .= '<a class="px-0" href="entrada.php?id=' . $entrada['id'] . '" aria-label="Settings">';
        $html .= '<i class="fa fa-eye" aria-hidden="true"></i>';
        $html .= '</a>';
        $html .= '</div>';
        $html .= '</div>  <!--.row-->';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div><!-- .col-12  -->';

        return $html;
    }
    public function singleEntry($entrada)
    {
        $html = '<div class="col-12 my-1 ">';
        $html .= '<div class="card ">';
        $html .= '<div class="card-body py-1">';
        $html .= '<h5 class="card-title mb-0">' . $entrada['nombre_categoria'];
        $html .= '<small class="text-muted pl-2">' . $entrada['anos'] . '</small>';
        $html .= '</h5>';
        $html .= '<div class="row">';
        $html .= '<div class="card-text text-08 pl-2 pr-1" style="width: 98%">';
        $html .= $entrada['contenido'] . '" ( " ' . $entrada['id_libro'] . '" , "' . $entrada['referencia'] . ' " ) "';
        $html .= '</div>';
        $html .= '<div class="card-text text-08 text-center" style="width: 2%" >';
        $html .= '<a class="px-0" href="entrada.php?id=' . $entrada['id'] . '" aria-label="Settings">';
        $html .= '<i class="fa fa-eye" aria-hidden="true"></i>';
        $html .= '</a>';
        $html .= '</div>';
        $html .= '</div>  <!--.row-->';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div><!-- .col-12  -->';

        return $html;
    }

 public function orderByYears($entrada){
     if (!empty($entrada)){
         /*        echo "<pre> orderByYears Inicio ->  ";
                 print_r($entrada);
                 echo "</pre>";*/

         foreach ($entrada as $key => $row) {
             $aux[$key] = $row['anos'];
         }
         array_multisort($aux, SORT_ASC, $entrada);
     }
     return $entrada;
 }
}