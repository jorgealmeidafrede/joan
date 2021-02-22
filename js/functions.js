$('#myModal').modal('toggle');

function showUpdateCategory(elemento) {
    var id = elemento.getAttribute('id');
    var nombre = elemento.getAttribute('data-nombre');
    console.log(id + " -> " + nombre);
    var nombreEditar = document.getElementById("nombre-editar"),
        idEditar = document.getElementById("id-editar");
    nombreEditar.value = nombre;
    idEditar.value = id;
    console.log(idEditar);


    document.getElementById('categoria-crear').style.display = 'none';
    document.getElementById('categoria-editar').style.display = 'flex';

}

function muestroAgregarCat() {
    document.getElementById('categoria-crear').style.display = 'flex';
    document.getElementById('categoria-editar').style.display = 'none';
}
function netaForm(){
    var busqueda = document.getElementById("busqueda");
    var year1 = document.getElementById("year1");
    var year2 = document.getElementById("year2");
    var idCategoria = document.getElementById("id_categoria");

    busqueda.value = "";
    year1.value="";
    year2.value="";
    idCategoria.value="0";
}