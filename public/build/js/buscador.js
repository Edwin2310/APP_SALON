document.addEventListener('DOMContentLoaded', function(){

    iniciarApp();

});

function iniciarApp(){
    buscarPorFecha();
}


//Funcion Filtrar por Fecha
function buscarPorFecha(){
    const fechaInput = document.querySelector('#fecha');
    fechaInput.addEventListener('input', function(e){
        const fechaSeleccionada = e.target.value;

        window.location= `?fecha=${fechaSeleccionada}`; //Filtra las citas por METODO GETR


    });


}