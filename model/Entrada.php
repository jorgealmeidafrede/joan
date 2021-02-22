<?php
require_once("autoload.php");

class Entrada
{
    public $id;
    public $referencia;
    public $pagina;
    public $id_categoria;
    public $nombre_categoria;
    public $anos;
    public $contenido;
    public $date_added;

   public function __construct($id ,$referencia , $pagina, $id_categoria, $nombre_categoria,$anos,$contenido,$date_added )
    {
        $this->id = $id;
        $this->referencia = $referencia;
        $this->pagina = $pagina;
        $this->id_categoria = $id_categoria;
        $this->nombre_categoria = $nombre_categoria;
        $this->anos = $anos;
        $this->contenido = $contenido;
        $this->date_added = $date_added;
    }
}