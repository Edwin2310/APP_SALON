<h1 class="nombre-pagina">Nuevos Servicios</h1>
<p class="descripcion-pagina">Llene todos los campos para crear un nuevo servicio</p>


<?php
include_once __DIR__ . '/../templates/barras.php';
include_once __DIR__ . '/../templates/alertas.php';

?>

<form action="/servicios/crear" method="POST" class="formulario">
    <?php include_once __DIR__ . '/formulario.php'; ?>
    <input type="submit" class="boton" value="Guardar Servicio">
</form>